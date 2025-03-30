<?php 
	class Cliente_confirma extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			getPermisos(MDPAGINAS);
		}

		public function Cliente_confirma()
		{
			$data['page_tag'] = "Cliente confirma";
			$data['page_title'] = "SUSCRIPTORES <small>Tienda Virtual</small>";
			$data['page_name'] = "cliente_confirma";
			
			$this->views->getView($this,"cliente_confirma",$data);
		}

	}
 ?>
