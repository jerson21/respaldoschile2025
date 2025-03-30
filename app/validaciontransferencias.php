<?php
// 210 exit code are sent instead of 200 because one client had issues with that (idk what D;)
class LinkifyEndpointsHandler
{
    private $request_body;
    private $payment_note_title = 'Linkify payment';
    private $cancellation_note_title = 'Linkify cancellation';
    private $note_line_separator = '<br>';

    private $secret_key;
    private $accept_overpaid;
    private $accept_underpaid;
    private $change_stock_on_partial_paymeny;
    
    public function __construct($secret_key, $accept_overpaid, $accept_underpaid, $change_stock_on_partial_paymeny)
    {
        $this->secret_key = $secret_key;
        $this->accept_overpaid = $accept_overpaid;
        $this->accept_underpaid = $accept_underpaid;
        $this->change_stock_on_partial_paymeny = $change_stock_on_partial_paymeny;
    }

    // Handle API calls from Linkify
    public function handleRequest($gateway_class)
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $raw_request_body = stripslashes($_GET["encoded_data"]);
                break;
            case "POST":
                $raw_request_body = file_get_contents('php://input');
                break;
            default:
                $this->sendHttpResponse(['message' => 'Request method not implemented', 'should_send_email' => true], 501);
        }

        // Check if the request is from Linkify. In case of error, this should throw error code other than 210.
        $this->checkHash($raw_request_body);

        $request_body = json_decode($raw_request_body, true);
        $order = wc_get_order($request_body['id']);

        if (!$order) {
            $this->sendHttpResponse(['message' => "No se encontró la orden #{$request_body['id']}"], 422);
        }

        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $this->handleGETRequest($order);
                break;
            case "POST":
                $this->handlePOSTRequest($order, $request_body, $gateway_class->get_return_url($order));
                break;
        }
    }

    // Check if a request is from Linkify
    private function checkHash($content)
    {
        $local_verification_hash = hash_hmac("sha256", $content, $this->secret_key);

        if ($local_verification_hash != $_SERVER["HTTP_X_LINKIFY_CONFIRMATION"]) {
            $this->sendHttpResponse(['message' => "El hash de validación es inválido" , 'should_send_email' => false], 401);
        }
    }
    
    // Clean buffer and send an http response to Linkify
    private function sendHttpResponse($response, $status_code)
    {
        // If there are entries in the buffer (previously echoed things by PHP or other plugins) clean it in order to send a clean http response
        while (ob_get_level() > 0) {
            ob_get_clean();
        }

        header('HTTP/1.1 ' . $status_code . ' OK');
        header('Content-Type: application/json');
        echo json_encode($response);
        die(); // If this is not called woocommerce answer with a -1 in the body idk why
    }

    // Handle a POST request from Linkify
    private function handlePOSTRequest($order, $request_body, $return_url)
    {
        if ($request_body["action"] == "notification") {
            return $this->handleNotification($order, $request_body, $return_url);
        } elseif ($request_body["action"] == "cancellation") {
            return $this->handleCancellation($order, $request_body);
        } else {
            $this->sendHttpResponse(['message' => 'Este plugin no maneja este tipo de interacciones con Linkify'], 422);
        }
    }

    // Handle a Linkify GET request
    private function handleGETRequest($order)
    {
        // Check for correct order status
        if (!in_array($order->get_status(), ['pending', 'partially-paid', 'on-hold'])) {
            $this->sendHttpResponse(['message' => "La orden #{$order->get_id()} no está pendiente de pago"], 422);
        }

        // Check if current payments already pays the order
        $debt = $order->get_total() - $this->getPayedAmount($order);
        if ($debt <= 0) {
            $this->sendHttpResponse(['message' => "La orden #{$order->get_id()} está pagada, pero en el estado incorrecto"], 422);
        }

        $this->sendHttpResponse([
            'amount'        => $debt,
            'description'   => $this->getOrderDetails($order),
            'currency'      => 'CLP',
        ], 210);
    }

    private function handleNotification($order, $request_body, $return_url)
    {
        // Check completeness
        if ($this->accept_overpaid == "no" && $request_body['completeness'] == 'overpaid') {
            $this->sendHttpResponse([
                'status'  => 'rejected',
                'message' => 'No se aceptan pagos mayores al total',
                'restart' => true
            ], 210);
        }
        
        if ($this->accept_underpaid == "no" && $request_body['completeness'] == 'underpaid') {
            $this->sendHttpResponse([
                'status'  => 'rejected',
                'message' => 'No se aceptan pagos menores al total',
                'restart' => true
            ], 210);
        }

        // Check the order status
        if (!in_array($order->get_status(), ['pending', 'partially-paid', 'on-hold'])) {
            $this->sendHttpResponse(['message' => "La orden #{$order->get_id()} no está pendiente de pago"], 422);
        }

        // Calculate the current debt (before transfers are added)
        $debt = $order->get_total() - $this->getPayedAmount($order);

        // Check if the order amount changed
        if ($debt != $request_body["original_amount"]) {
            $this->sendHttpResponse(['message' => "La orden #{$order->get_id()} ha sido modificada"], 422);
        }

        // Add a note for each transfer. This ignores transfers already added
        $transfers = $request_body['transfers'];
        $this->addTransfersNote($transfers, $order);

        // Calculate the new debt (after transfers were added)
        $debt = $order->get_total() - $this->getPayedAmount($order);

        if($debt && $request_body['completeness'] == 'exact') {
            $this->addTransfersNote([
                [
                    "amount" => $debt, 
                    "hashid" => $transfers[0]["hashid"] . '-C'
                ]
            ], $order, " - for completeness");
            $debt = 0;
        }

        // Response
        if ($debt > 0) { 
            // Partial payment
            if($this->change_stock_on_partial_paymeny == "yes") {
                wc_reduce_stock_levels($order->get_id());
            }
            
            $order->update_status('partially-paid');
            $this->sendHttpResponse([
                'status'    => 'accepted',
                'message'   => "Su pago fue ingresado, sin embargo aún falta por pagar $" . number_format($debt, 0, ",", ".") . ". Reinicie el proceso para validar el pago faltante.",
                'restart'   => true
            ], 210);
        } else { 
            // Full payment
            $order->add_order_note(__('Pago confirmado por Linkify', 'woothemes'));
            $order->update_status('pending');
            $order->payment_complete();
            $this->sendHttpResponse([
                'status'    => 'accepted',
                'message'   => 'Pago recibido correctamente',
                'redirect'  => $return_url
            ], 210);
        }
    }

    // When a transfer is cancelled, the note existing note is removed from the order and a new one is created showing the cancellation
    private function handleCancellation($order, $request_body)
    {
        // Check the order status
        if (in_array($order->get_status(), ['processing', 'on-hold', 'completed'])) {
            $this->sendHttpResponse(['message' => "La orden no está en un estado que permita anulaciones"], 422);
        }

        // Get transfers hashid
        $transfers = array_map(function ($transfer) {
            return $transfer["hashid"];
        }, $request_body['transfers']);

        // Check existing transfers, remove the ones cancelled and add a new note
        foreach ($this->getLinkifyTransfersNotes($order) as $note) {
            $existing_transfer_hashid = explode("-", explode($this->note_line_separator, $note->content)[2])[0];
            if (in_array($existing_transfer_hashid, $transfers)) {
                wp_delete_comment($note->id);

                $existing_transfer_amount = explode($this->note_line_separator, $note->content)[1];
                $order->add_order_note(__(implode($this->note_line_separator, [$this->cancellation_note_title, $existing_transfer_amount, $existing_transfer_hashid]), 'woothemes'));
            }
        }

        if ($order->get_status() == 'partially-paid' && !count($this->getLinkifyTransfersNotes($order))) {
            if($this->change_stock_on_partial_paymeny == "yes") {
                wc_increase_stock_levels($order->get_id());
            }
            
            $order->update_status('pending');
        }

        $this->sendHttpResponse(['message' => 'Pago desvinculado correctamente'], 210);
    }

    // Gets the order description to be displayed in Linkify
    // Items are handled differently in WooCommerce 3 and 4, so we try both ways
    private function getOrderDetails($order)
    {
        if (class_exists('WC_Order_Item_product')) {
            return $this->getOrderDetailsWC4($order);
        } else {
            return $this->getOrderDetailsWC3($order);
        }
    }

    // Get details string using WooCommerce class structure
    private function getOrderDetailsWC4($order)
    {
        $order_detail_string ="<strong>Orden #{$order->get_order_number()}</strong>\n";
        $item_ids = $order->get_items(); // In format {ID:{}, ID:{}, ID:{}}
        foreach ($item_ids as $item_id => $value) {
            $item = new WC_Order_Item_Product($item_id);
            $product_name = $item->get_product()->get_name();
            $quantity_sold = $item->get_quantity();
            $pluralize = $quantity_sold == 1 ? "" : "es";
            $order_detail_string .= "<strong>$product_name</strong> - $quantity_sold unidad{$pluralize}\n";
        }

        return $order_detail_string;
    }

    // Get details string using WooCommerce 3 way of doing it
    private function getOrderDetailsWC3($order)
    {
        $order_detail_string ="<strong>Orden #{$order->get_order_number()}</strong>\n";
        foreach ($order->get_items() as $item) {
            $pluralize = $item['qty'] == 1 ? "" : "es";
            $order_detail_string .= "<strong>{$item['name']}</strong> - {$item['qty']} unidad{$pluralize}\n";
        }

        return $order_detail_string;
    }

    // Gets all notes containing Linkify transfers
    private function getLinkifyTransfersNotes($order)
    {
        return array_filter(wc_get_order_notes(["order_id" => $order->get_id()]), function ($note) {
            return $note->added_by == "system" && !$note->customer_note && strpos($note->content, $this->payment_note_title) === 0;
        });
    }

    // Adds a note for each transfer that is not already added
    private function addTransfersNote($transfers, $order, $title_append = '')
    {
        $existing_transfers = array_map(function ($note) {
            return explode($this->note_line_separator, $note->content)[2];
        }, $this->getLinkifyTransfersNotes($order));

        foreach ($transfers as $transfer) {
            $formatted_amount = number_format($transfer['amount'], 0, ",", ".");
            if (!in_array($transfer['hashid'], $existing_transfers)) {
                $order->add_order_note(__(implode($this->note_line_separator, [$this->payment_note_title . $title_append, "\${$formatted_amount}", $transfer['hashid']]), 'woothemes'));
            }
        }
    }

    // Adds up all the amounts of the already added transfers
    private function getPayedAmount($order)
    {
        return array_reduce($this->getLinkifyTransfersNotes($order), function ($carry, $note) {
            $carry += preg_replace('/\D/', '', explode($this->note_line_separator, $note->content)[1]);
            return $carry;
        });
    }
}
