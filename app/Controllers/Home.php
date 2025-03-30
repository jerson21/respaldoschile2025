<?php 
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	class Home extends Controllers{
		use TCategoria, TProducto;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function home()
		{
			$pageContent = getPageRout('inicio');
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda_virtual";
			$data['page'] = $pageContent;
			$data['slider'] = $this->getCategoriasT(CAT_SLIDER);
			$data['banner'] = $this->getCategoriasT(CAT_BANNER);
			$data['productos'] = $this->getProductosHome();

			$data['categorias'] = $this->getCategorias();
			$data['respaldos'] = $this->getRespaldosDeCama(); // Aquí agregamos los respaldos
			$data['closet'] = $this->getVariados(9);
			$data['colchones'] = $this->getVariados(5); // Aquí agregamos los closet


			$this->views->getView($this,"home",$data); 
		}

	}
 ?>
