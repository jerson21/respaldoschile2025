<?php 
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	require_once("Models/TTipoPago.php");
	require_once("Models/TCliente.php");
	class Carrito extends Controllers{
		use TCategoria, TProducto, TTipoPago, TCliente;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function carrito()
		{
			$data['page_tag'] = NOMBRE_EMPESA.' - Carrito';
			$data['page_title'] = 'Carrito de compras';
			$data['page_name'] = "carrito";		
			
			$this->views->getView($this,"carrito",$data); 
		}
		public function procesarpago()
		{
			if(empty($_SESSION['arrCarrito'])){ 
				header("Location: ".base_url());
				die();
			}

			$data['page_tag'] = NOMBRE_EMPESA.' - Metodo de envio';
			$data['page_title'] = 'Metodo de envio';
			$data['page_name'] = "procesarpago";
			$data['tiposPago'] = $this->getTiposPagoT();
			$this->views->getView($this,"procesarpago",$data); 
		}

			public function metododepago()
		{
			if(empty($_SESSION['arrCarrito'])){ 
				header("Location: ".base_url());
				die();
			}

			$data['page_tag'] = NOMBRE_EMPESA.' - Procesar Pago';
			$data['page_title'] = 'Procesar Pago';
			$data['page_name'] = "procesarpago";
			$data['tiposPago'] = $this->getTiposPagoT();
			$this->views->getView($this,"metododepago",$data); 
		}

			public function metododepagoe()
		{
			if(empty($_SESSION['arrCarrito'])){ 
				header("Location: ".base_url());
				die();
			}

			$data['page_tag'] = NOMBRE_EMPESA.' - Procesar Pago';
			$data['page_title'] = 'Procesar Pago';
			$data['page_name'] = "procesarpago";
			$data['tiposPago'] = $this->getTiposPagoT();
			$this->views->getView($this,"metododepagoe",$data); 
		}

		public function pagarwebpay()
		{
			if(empty($_SESSION['arrCarrito'])){ 
				header("Location: https://www.respaldoschile.cl");
				die();
			}

				$data['page_tag'] = NOMBRE_EMPESA.' - Procesar Pago';
			$data['page_title'] = 'Procesar Pago';
			$data['page_name'] = "pagarwebpay";
			$data['tiposPago'] = $this->getTiposPagoT();
			$this->views->getView($this,"pagarwebpay",$data); 
		}

		

	}
 ?>
