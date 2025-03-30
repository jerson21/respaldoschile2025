<?php 
	class Productos extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MPRODUCTOS);
		}

		public function Productos()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Productos";
			$data['page_title'] = "PRODUCTOS ";
			$data['page_name'] = "productos";
			$data['page_functions_js'] = "functions_productos.js";
			$this->views->getView($this,"productos",$data);
		}

			

		public function getProductos()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectProductos();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					$arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']);
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver producto"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idproducto'].')" title="Editar producto"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idproducto'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}





				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setProducto(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					
					$idProducto = intval($_POST['idProducto']);
					$strNombre = strClean($_POST['txtNombre']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$strCodigo = strClean($_POST['txtCodigo']);
					$intCategoriaId = intval($_POST['listCategoria']);
					$strPrecio = strClean($_POST['txtPrecio']);
					$request_producto_color = null; // Inicializa antes de usarla

					if(empty($_POST['precio_unico'])){ $precio_unico="0";}else{
					$precio_unico = strClean($_POST['precio_unico']);	
					}

					$intStock = intval($_POST['txtStock']);
					$intStatus = intval($_POST['listStatus']);
					$a60x50x40 = strClean($_POST['60x50x40']);
					$a60x50x45 = strClean($_POST['60x50x45']);
					$a60x40x40 = strClean($_POST['60x40x40']);
					$a70x50x40 = strClean($_POST['70x50x40']);
					$a70x50x45 = strClean($_POST['70x50x45']);
					$cuerpo1 = strClean($_POST['cuerpo1']);
					$cuerpo2 = strClean($_POST['cuerpo2']);
					$cuerpo3 = strClean($_POST['cuerpo3']);
					$cuerpo4 = strClean($_POST['cuerpo4']);
					$cuerpo5 = strClean($_POST['cuerpo5']);

					if($intCategoriaId == '6'){
					$b50x50 = strClean($_POST['b50x50']);
					$b90x45 = strClean($_POST['b90x45']);
					$b100x45 = strClean($_POST['b100x45']);
					$b120x45 = strClean($_POST['b120x45']);
					$b150x45 = strClean($_POST['b150x45']);
					$b90x35 = strClean($_POST['b90x35']);
					$b100x35 = strClean($_POST['b100x35']);
					$b120x35 = strClean($_POST['b120x35']);
					$b150x35 = strClean($_POST['b150x35']);
					}
					if($precio_unico=="1"){

						$color1 = strClean($_POST['color1']);
						$color2 = strClean($_POST['color2']);
						$color3 = strClean($_POST['color3']);
						$color4 = strClean($_POST['color4']);
						$color5 = strClean($_POST['color5']);
					}


					

					if($intCategoriaId == '1' || $intCategoriaId == '3'|| $intCategoriaId == '5'){
					if(isset($_POST['1plaza'])){$a1plaza = strClean($_POST['1plaza']); }else{ $a1plaza = ''; } 
						if(isset($_POST['plazaymedia'])){$plazaymedia = strClean($_POST['plazaymedia']); }else{ $plazaymedia = ''; } 
							if(isset($_POST['full'])){$full = strClean($_POST['full']); }else{ $full = ''; } 
								if(isset($_POST['2plazas'])){$a2plazas = strClean($_POST['2plazas']); }else{ $a2plazas = ''; } 
									if(isset($_POST['queen'])){$queen = strClean($_POST['queen']); }else{ $queen = ''; } 
										if(isset($_POST['king'])){$king = strClean($_POST['king']); }else{ $king = ''; } 
											if(isset($_POST['superking'])){$superking = strClean($_POST['superking']); }else{ $superking = ''; } 
					
					
					 }
					
					
					
					
					$request_producto = "";
					$lino= '';
					$material = isset($_POST['checkMaterial']) ? $_POST['checkMaterial'] : [];
					foreach($material as $selected){
						if($selected == "Lino"){ $lino=1;}

						}

					$ruta = strtolower(clear_cadena($strNombre));
					$ruta = str_replace(" ","-",$ruta);

					if($idProducto == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_producto = $this->model->insertProducto($strNombre, 
																		$strDescripcion, 
																		$strCodigo, 
																		$intCategoriaId,
																		$strPrecio, 
																		$intStock, 
																		$ruta,
																		$intStatus,$precio_unico);

							
							if($intCategoriaId == '1' || $intCategoriaId == '3'|| $intCategoriaId == '5'){
							$request_precio = $this->model->insertPrecioProducto($request_producto,'1 plaza',$a1plaza);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'1 1/2',$plazaymedia);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'Full',$full);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'2 plazas',$a2plazas);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'queen',$queen);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'king',$king);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'Super King',$superking);

							}
							if($intCategoriaId == '4'){
							$request_precio = $this->model->insertPrecioProducto($request_producto,'60x50x40',$a60x50x40);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'60x50x45',$a60x50x45);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'60x40x40',$a60x40x40);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'70x50x40',$a70x50x40);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'70x50x45',$a70x50x45);
							 }
							 if($intCategoriaId == '2'){ // sofas
							$request_precio = $this->model->insertPrecioProducto($request_producto,'1 Cuerpo',$cuerpo1);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'2 Cuerpos',$cuerpo2);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'3 Cuerpos',$cuerpo3);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'4 Cuerpos',$cuerpo4);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'5 Cuerpos',$cuerpo5);
							
							 }
							 if($intCategoriaId == '6'){ // Banquetas

					

							$request_precio = $this->model->insertPrecioProducto($request_producto,'Pouff 50 Largo x 50 Ancho',$b50x50);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'90 Largo x 45 Ancho',$b90x45);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'100 Largo x 45 Ancho',$b100x45);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'120 Largo x 45 Ancho',$b120x45);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'150 Largo x 45 Ancho',$b150x45);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'90 Largo x 35 Ancho',$b90x35);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'100 Largo x 35 Ancho',$b100x35);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'120 Largo x 35 Ancho',$b120x35);
							$request_precio = $this->model->insertPrecioProducto($request_producto,'150 Largo x 35 Ancho',$b150x35);
							 }
							  if($intCategoriaId == '7'){ // Closet

					
							  	$request_precio = $this->model->insertPrecioProducto($request_producto,'1',$strPrecio);
							$request_precio = $this->model->insertColor($request_producto,$color1,"1");
							$request_precio = $this->model->insertColor($request_producto,$color2,"1");
							$request_precio = $this->model->insertColor($request_producto,$color3,"1");
							$request_precio = $this->model->insertColor($request_producto,$color4,"1");
							$request_precio = $this->model->insertColor($request_producto,$color5,"1");
							
							 }

							 


							 if($request_producto != 'exist') {
								// Verificar si el producto NO es de precio único antes de insertar colores
								if($precio_unico != "1") {
									foreach($_POST['checkMaterial'] as $selected) {
										$request_producto_color = $this->model->insertColorProducto($request_producto, $selected);
									}
								}
							}
							


							
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_producto = $this->model->updateProducto($idProducto,
																		$strNombre,
																		$strDescripcion, 
																		$strCodigo, 
																		$intCategoriaId,
																		$strPrecio, 
																		$intStock, 
																		$ruta,
																		$intStatus);
																		if($request_producto != 'exist') {
																			// Verificar si el producto NO es de precio único antes de insertar colores
																			if($precio_unico != "1") {
																				foreach($_POST['checkMaterial'] as $selected) {
																					$request_producto_color = $this->model->insertColorProducto($request_producto, $selected);
																				}
																			}
																		}
						}
					}

					if($request_producto > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'idproducto' => $request_producto, 'Insert' => $request_producto_color ,'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'idproducto' => $idProducto,'Insert' => $request_producto_color , 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_producto == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código Ingresado.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getProducto($idproducto) {
    if ($_SESSION['permisosMod']['r']) {
        $idproducto = intval($idproducto);
        if ($idproducto > 0) {
            $arrData = $this->model->selectProducto($idproducto);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                // Obtener los tamaños relacionados con el producto
                $arrTamanos = $this->model->selectTamanos($idproducto);
                
                // Agregar los tamaños a los datos del producto
                $arrData['tamanos'] = $arrTamanos;

                $arrImg = $this->model->selectImages($idproducto);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
                    }
                }
                $arrData['images'] = $arrImg;

                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            // Codificar y enviar la respuesta JSON
            header('Content-Type: application/json');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }
    die();
}

	
		

		public function setImage(){
			if($_POST){
				if(empty($_POST['idproducto'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de dato.');
				}else{
					$idProducto = intval($_POST['idproducto']);
					$foto      = $_FILES['foto'];
					$imgNombre = 'pro_'.md5(date('d-m-Y H:i:s')).'.jpg';
					$request_image = $this->model->insertImage($idProducto,$imgNombre);
					if($request_image){
						$uploadImage = uploadImage($foto,$imgNombre);
						$arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error de carga.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delFile(){
			if($_POST){
				if(empty($_POST['idproducto']) || empty($_POST['file'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					//Eliminar de la DB
					$idProducto = intval($_POST['idproducto']);
					$imgNombre  = strClean($_POST['file']);
					$request_image = $this->model->deleteImage($idProducto,$imgNombre);

					if($request_image){
						$deleteFile =  deleteFile($imgNombre);
						$arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delProducto(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdproducto = intval($_POST['idProducto']);
					$requestDelete = $this->model->deleteProducto($intIdproducto);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}

 ?>