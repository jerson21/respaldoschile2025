<?php   
headerTienda($data);

$subtotal = 0;
$total = 0;
foreach ($_SESSION['arrCarrito'] as $producto) {
	$subtotal += $producto['precio'] * $producto['cantidad'];
}

$total = $subtotal + COSTOENVIO;

$tituloTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['titulo'] : "";
$infoTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['contenido'] : "";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>



<!-- Modal -->
<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= $tituloTerminos ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<div class="page-content">
        		<?= $infoTerminos  ?>
        	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

 <br><br><br>
<hr>
	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?= base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
				Inicio
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>
			<span class="stext-109 cl4">
				<?= $data['page_title'] ?>
			</span>
		</div>
	</div>
	<br>
	<div class="container">
	<?php $this->con = new Mysql();
								$request = array();
								$suma=0;
								$tienedireccion = false;
								$rut_cliente = $_SESSION['userData']['identificacion'];
								$sql = "SELECT * FROM direccion_cliente where rut_cliente = '$rut_cliente'";
								$requestPedido = $this->con->select($sql);
								if($requestPedido > 0){
									$sql_detalle = "SELECT * FROM direccion_cliente where rut_cliente = '$rut_cliente'";
									$requestProductos = $this->con->select_all($sql_detalle);
									$request = array('direccion' => $requestProductos,
													'numero' => $requestProductos
													);
									foreach($requestProductos as $form){ ?>



										

										<?php
										$detalle_dir = $form['direccion']." ".$form['numero'].", ".$form['dpto'].", ".$form['region'].", ".$form['comuna'];
										
											
										echo '<input type="hidden" id="direvalue" name="direvalue" value="'.$form["direccion"].'">
										<input type="hidden" id="direnumero" name="direnumero" value="'.$form["numero"].'">
										<input type="hidden" id="diredpto" name="diredpto" value="'.$form["dpto"].'">
										<input type="hidden" id="direregion" name="direregion" value="'.$form["region"].'"> 
										<input type="hidden" id="direcomuna" name="direcomuna" value="'.$form["comuna"].'">
										<input type="hidden" id="direreferencia" name="direreferencia" value="'.$form["referencia"].'">';
									

										

	?>
	 

	<?php
		
			}
		} ?>



		<div class="row">
			<div class="col-sm-10 col-lg-7 col-xl-6 m-lr-auto m-b-50">
<div id="divMetodoPago">
						
						<div id="optMetodoPago">	
							<hr>					
							<h4 class="mtext-109 cl2 p-b-30">
								Método de pago
							</h4>
							<div class="divmetodpago" >
								<div>
									<label for="paypal">
										<input type="radio" id="webpay" class="methodpago" name="payment-method"  value="Paypal">
										<img src="https://rulos.cl/wp-content/uploads/2018/12/logo-webpay-plus-3-copy.png" alt="Icono de PayPal" class="ml-space-sm" width="90">
									</label>
								</div> 
								<div>
									<label for="contraentrega">
										<input type="radio" id="contraentrega" class="methodpago" name="payment-method" value="CT">
										<span>Transferencia Bancaria</span>
									</label>
								</div>
						
							
								
							</div>
							<div id="divCondiciones">
							<input type="checkbox" id="condiciones" >
							<label for="condiciones"> Aceptar </label>
							<a href="#" data-toggle="modal" data-target="#modalTerminos" > Términos y Condiciones </a>
						</div>

						</div>
						<div>	<br>
							
								<label>Codigo descuento</label>
							<table style="text-align:center; " >
									<th></th>
									<th><input type="text" id="cod_descuento" name="cod_descuento" placeholder="Ingrese codigo de descuento"  class="form-control" style="width:220px;"></th>
									<th style="padding: 2px;"></th>
									<th>
									
								<input type="button" class="flex-c-m stext-101 cl0 size-125 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" name="aplicar" id="aplicar" onclick="aplicarDescuento();" value="Aplicar">

							</th>


								</table>
									
				
<div id="cupon" class="notblock" style="display: flex;border: 1px solid #d9d9d9;border-radius: 4px;padding: .5rem;background: #fff;justify-content: center;align-items: center;width: 50%;height: -webkit-fit-content;
height: -moz-fit-content;height: fit-content; font-size: 12px;">
<div style="z-index: 1;display: flex;justify-content: space-between;align-items: center;width: 100%;">
	<div style='font-family: "Barlow","Roboto","Helvetica Neue",sans-serif;color: #464646;   display: flex;'>
	<img style="margin-right: 6px;" alt="Check" src="https://checkout-corp.ripley.cl/static/media/check.4babb080.svg" width="20" height="20">
	<div><div ><input type="text" name="nombrecupon" id="nombrecupon" value="DESPACHOGRATIS" style="color: #008330;font-weight: 600;"></div>
	<div class="CouponTag_coupon_tag__coupon_description__1Xdyp"><div></div>
	<div>Cupón aplicado correctamente</div></div></div></div><button></button></div></div>




							
							
							
					
						</div>
					</div>

					<div id="depositobancario" class="notblock" >

						A continuación encontrarás los datos para que realices la transferencia antes de 48 horas, después de ese periodo se anulara el pedido.<br>
Para asistencia sobre el pago o dudas del producto, por favor contáctenos al +56979941253 o al mail contacto@respaldoschile.cl, en horario de atención de tienda (lunes a viernes de 09:00 a 18:00 hrs.).<br>

En el caso que la transacción se realice un día viernes, fin de semana o feriado el tiempo de despacho contara desde el dia habil siguiente. <br><br>
Respaldos Chile SPA<br>
Banco de Crédito e inversiones(BCI)<br>
Tipo de cuenta: Cuenta Corriente<br>
Cuenta: 46328157<br>
RUT: 77.186.031-1<br>
Correo: contacto@respaldoschile.cl <br>
					</div>
			</div>
				
<div  class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
				<div  class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm" >
					<div id="loaddeprueba" class="loaddeprueba"></div>

METODO DE PAGO
				</div></div>




			<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm" >
					<h4 class="mtext-109 cl2 p-b-30">
						Resumen
					</h4>

					<div class="flex-w flex-t bor12 p-b-13">
						<div class="size-208">
							<span class="stext-110 cl2">
								Subtotal:
							</span>
						</div>

						<div class="size-209">
							<span id="subTotalCompra" class="mtext-110 cl2"  >
							
								<table>
									<th>$</th>
									<th>
									<?= $subtotal ?>
							</th>
								</table>
							</span>
						</div>

						<div class="size-208">
							<span class="stext-110 cl2">
								Envío:
							</span>
						</div>

						<div class="size-209">
							<span class="mtext-110 cl2" style="font-family:'Roboto';">
								<table>
									<th>$</th>
									<th>
										<?php foreach ($_SESSION['precio_envio'] as $producto) {
											$costoenvio = $producto['precio'];
										} ?>
								<input type="text" id="costoenvio" name="costoenvio" value="<?php echo $costoenvio; ?>" readonly="readonly">
							</th>
								</table>
								


							</span>
						</div>

						<div class="size-208">
							<span class="stext-110 cl2">
								Descuento:
							</span>
						</div>

						<div class="size-209">
							<span class="mtext-110 cl2" style="font-family:'Roboto';">
								<table>
									<th>$</th>
									<th>
									
								
							</th>
								</table>
								


							</span>
						</div>
					</div>
					<div class="flex-w flex-t p-t-27 p-b-33">
						<div class="size-208">
							<span class="mtext-101 cl2">
								Total:
							</span>
						</div>

						<div class="size-209">

							<span id="totalCompra" class="mtext-110 cl2">
								<table>
									<th>$</th>
									<th>
								<input type="text" id="totalcompra" name="totalcompra" value="<?= $subtotal+$costoenvio ?>" readonly="readonly">
							</th>
							<?php   ?>
								</table>
							</span>

							<div id="metodosdepagoenlinea" name="metodosdepagoenlinea"  class="notblock">
									<div id="divtipopago" class="notblock" >
									<label for="listtipopago">Tipo de pago</label>
									<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
										<select id="listtipopago" class="js-select2" name="listtipopago">
										<?php 
											if(count($data['tiposPago']) > 0){ 
												foreach ($data['tiposPago'] as $tipopago) {
													if($tipopago['idtipopago'] != 1){
										 ?>
										 	<option value="<?= $tipopago['idtipopago']?>"><?= $tipopago['tipopago']?></option>
										<?php
													}
												}
										 } ?>
										</select>
										<div class="dropDownSelect2"></div>
									</div>
									<br>
								
									<button type="submit" id="btnComprar" name="btnComprar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Procesar pedido</button>
							

								</div>

	<?php 

		$catFotter = getCatFooter();
	 	


function get_ws($data,$method,$type,$endpoint){
    $curl = curl_init();
    if($type=='live'){
		$TbkApiKeyId='597055555532';
		$TbkApiKeySecret='579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
        $url="https://webpay3g.transbank.cl".$endpoint;//Live
    }else{
		$TbkApiKeyId='597055555532';
		$TbkApiKeySecret='579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
        $url="https://webpay3gint.transbank.cl".$endpoint;//Testing
    }
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
        'Tbk-Api-Key-Id: '.$TbkApiKeyId.'',
        'Tbk-Api-Key-Secret: '.$TbkApiKeySecret.'',
        'Content-Type: application/json'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    //echo $response;
    return json_decode($response);
}


$baseurl = "https://" . $_SERVER['HTTP_HOST'] . "/carrito/metododepago";
$url="https://webpay3g.transbank.cl/";//Live
$url="https://webpay3gint.transbank.cl/";//Testing

$action = isset($_GET["action"]) ? $_GET["action"] : 'init';
$message=null;
$post_array = false;

switch ($action) {
    
    case "init":
        $message.= 'init';
        $buy_order=rand();
        $session_id=rand();
        $amount=$subtotal+$costoenvio;
        $return_url = $baseurl."?action=getResult";
		$type="sandbox";
            $data='{
                    "buy_order": "'.$buy_order.'",
                    "session_id": "'.$session_id.'",
                    "amount": '.$amount.',
                    "return_url": "'.$return_url.'"
                    }';
            $method='POST';
            $endpoint='/rswebpaytransaction/api/webpay/v1.0/transactions';
            
            $response = get_ws($data,$method,$type,$endpoint);
            $message.= "<pre>";
            $message.= print_r($response,TRUE);
            $message.= "</pre>";
            $url_tbk = $response->url;
            $token = $response->token;
            $submit='Procesar Pago';
            

    break;

    case "getResult":
        
        $message.= "<pre>".print_r($_POST,TRUE)."</pre>";
        
        $submit='Continuar!';
        
         if (isset($_POST["TBK_TOKEN "]))
         	$url_tbk = $baseurl;
         $mensaje_anulacion= filter_input(INPUT_POST, 'TBK_TOKEN')."<br>".filter_input(INPUT_POST, 'TBK_ID_SESION')."<br>".filter_input(INPUT_POST, 'TBK_ORDEN_COMPRA');			
         $url_tbk = $baseurl;
        	            break;


        if (!isset($_POST["token_ws"])) 				
        	            break;

        /** Token de la transacción */
        $token = filter_input(INPUT_POST, 'token_ws');
        
        $request = array(
            "token" => filter_input(INPUT_POST, 'token_ws')
        );
        
        $data='';
		$method='PUT';
		$type='sandbox';
		$endpoint='/rswebpaytransaction/api/webpay/v1.0/transactions/'.$token;
		
        $response = get_ws($data,$method,$type,$endpoint);
       	
        $message.= "<pre>";
        $message.= print_r($response,TRUE);

        $message.= "</pre>";
        
        $url_tbk = $baseurl."?action=getStatus";
        $submit='Ver Status!';

      $token_ws = $_POST["token_ws"]; 	

    	$montotransbank = $response->amount;
    	$status_transbank = $response->status;
    	$fecha_transaccion = $response->transaction_date;
    	$buy_order = $response->buy_order;
     	$payment_type_code = $response->payment_type_code;
     	if($payment_type_code == 'VD'){
     		$payment_type_code = "Débito";
     	}
     	elseif($payment_type_code == 'VD'){
     		$payment_type_code = "Débito";
     	}
     	elseif($payment_type_code == 'VP'){
     		$payment_type_code = "Prepago";
     	}
     	elseif($payment_type_code == 'VN'){
     		$payment_type_code = "Sin Cuotas";
     	}
     	elseif($payment_type_code == 'VC'){
     		$payment_type_code = "En Cuotas";
     	}

    	$authorization_code = $response->authorization_code;    	    	
    	$card_detail = $response->card_detail->card_number;


						


        ?>

            <script type="text/javascript">

            	 


            	

           function agregarVenta(montotransbank, statustransbank,card_detail,payment_type_code,buy_order,fecha_transaccion,token_ws){
           	base_url = "<?= base_url(); ?>";

           
		let dir = document.querySelector("#direvalue").value;
		let numero = document.querySelector("#direnumero").value;
		 let dpto = document.querySelector("#diredpto").value;
		 let region = document.querySelector("#direregion").value;
	    let comuna = document.querySelector("#direcomuna").value;	    
	    let referencia = document.querySelector("#direreferencia").value;
	    let costo_envio = document.querySelector("#costoenvio").value;
	    let inttipopago = document.querySelector("#listtipopago").value;
	    

	    if( dir == "" || comuna == "" || inttipopago =="" ){
			swal("", "Complete datos de envío" , "error");
			return;
		}else{
				divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? 
	                    new XMLHttpRequest() : 
	                    new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Tienda/procesarVenta';
			let formData = new FormData();
		    formData.append('direccion',dir);    
		   	formData.append('numero',numero);
		   	formData.append('dpto',dpto);    
		   	formData.append('region',region);
		   	formData.append('comuna',comuna);   
		   	formData.append('token_ws',token_ws);
		   	formData.append('referencia',referencia);
		   	formData.append('costo_envio',costo_envio);		 
		   	formData.append('inttipopago',inttipopago);  	
			formData.append('montotransbank',montotransbank);
			formData.append('status_transbank',statustransbank);
			formData.append('buy_order',buy_order);
			formData.append('card_detail',card_detail);fecha_transaccion
			formData.append('payment_type_code',payment_type_code);
			formData.append('fecha_transaccion',fecha_transaccion);
		   	request.open("POST",ajaxUrl,true);
		    request.send(formData);
		    request.onreadystatechange = function(){
		    	if(request.readyState != 4) return;
		    	if(request.status == 200){
		    		let objData = JSON.parse(request.responseText);
		    		if(objData.status){
		    			window.location = base_url+"/tienda/confirmarpedido/";
		    		}else{
		    			swal("", objData.msg , "error");
		    		}
		    	}
		    	divLoading.style.display = "none";
            	return false;
		    }
		}
}
token_ws = "<?php echo $token_ws; ?>";
buy_order = "<?php echo $buy_order; ?>";
fecha_transaccion = "<?php echo $fecha_transaccion; ?>";
payment_type_code = "<?php echo $payment_type_code; ?>";
	card_detail = "<?php echo $card_detail; ?>";
 montotransbank = "<?php echo $montotransbank; ?>";
	      statustransbank = "<?php echo $status_transbank; ?>";
agregarVenta(montotransbank,statustransbank,card_detail,payment_type_code,buy_order,fecha_transaccion,token_ws); 


          </script>

            <?php
        break;
        
    case "getStatus":
        
        if (!isset($_POST["token_ws"]))
            break;

        /** Token de la transacción */
        $token = filter_input(INPUT_POST, 'token_ws');
        
        $request = array(
            "token" => filter_input(INPUT_POST, 'token_ws')
        );
        
        $data='';
				$method='GET';
				$type='sandbox';
				$endpoint='/rswebpaytransaction/api/webpay/v1.0/transactions/'.$token;
		
        $response = get_ws($data,$method,$type,$endpoint);
       
        $message.= "<pre>";
        $message.= print_r($response,TRUE);
        $message.= "</pre>";
        
        $url_tbk = $baseurl."?action=refund";
        $submit='Refund!';
        break;
        
    case "refund":
        
        if (!isset($_POST["token_ws"]))
            break;

        /** Token de la transacción */
        $token = filter_input(INPUT_POST, 'token_ws');
        
        $request = array(
            "token" => filter_input(INPUT_POST, 'token_ws')
        );
        $amount=  $subtotal+$costoenvio;
        $data='{
                  "amount": '.$amount.'
                }';
		$method='POST';
		$type='sandbox';
		$endpoint='/rswebpaytransaction/api/webpay/v1.0/transactions/'.$token.'/refunds';
		
        $response = get_ws($data,$method,$type,$endpoint);
       
        $message.= "<pre>";
        $message.= print_r($response,TRUE);
        $message.= "</pre>";
        $submit='Crear nueva!';
        $url_tbk = $baseurl;
        break;          // METODOS DE WEBPAY
}  
?>
						
							<div id="divpaypal" class="notblock">
									
									<br>
									<div>
										
										<p>Para completar la transacción, te enviaremos a los servidores seguros de Transbank.</p>
									</div>
									
									<div class="container">
          <div class="vertical-center">
              <div class="lds-hourglass"></div>
               <p><?php echo $message; ?></p> 
              <?php if(isset($mensaje_anulacion)){
              	echo "Transaccion Anulada";
              	
              } ?>

              
                <?php if(strlen($url_tbk)) { ?>
                <form name="brouterForm" id="brouterForm"  method="POST" action="<?=$url_tbk?>" style="display:block;">
                  <input type="hidden" name="token_ws" value="<?=$token?>" />
                  <input type="submit" value="<?=(($submit)? $submit : 'Cargando...')?>" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" style="background-color: #6b196b;" />
                </form>
                <script>
            
                var auto_refresh = setInterval(
                function()
                {
                    //submitform();
                }, 15000);
            //}, 5000);
                function submitform()
                {
                  //alert('test');
                  document.brouterForm.submit();
                }
                </script>
            <?php } ?>
            </div>
        </div>
								</div> 


						</div>
					</div>
					</div>
					<hr>

<?php 
	if(isset($_SESSION['login'])){
?>
			

					
<?php } ?>
				</div>
			</div>
		</div>
	</div>

<?php 
	footerTienda($data);
 ?>
		
