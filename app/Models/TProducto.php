<?php 
require_once("Libraries/Core/Mysql.php");
trait TProducto{
	private $con;
	private $strCategoria;
	private $intIdcategoria;
	private $intIdProducto;
	private $strProducto;
	private $cant;
	private $option;
	private $strRuta;
	private $strRutaCategoria;

	public function getRespaldosDeCama()
{
    $this->con = new Mysql();
    $categoriaId = 1; // ID de la categoría Respaldos de Cama
    $sql = "SELECT p.idproducto,
                    p.codigo,
                    p.nombre,
                    p.descripcion,
                    p.categoriaid,
                    c.nombre as categoria,
                    p.precio,
                    p.precio_normal,
                    p.ruta,
                    p.stock
            FROM producto p 
            INNER JOIN categoria c
            ON p.categoriaid = c.idcategoria
            WHERE p.status != 0 AND p.categoriaid = $categoriaId
            ORDER BY p.idproducto ASC";

    $request = $this->con->select_all($sql);
    if (count($request) > 0) {
        for ($c = 0; $c < count($request); $c++) {
            $intIdProducto = $request[$c]['idproducto'];
            $sqlImg = "SELECT img FROM imagen WHERE productoid = $intIdProducto";
            $arrImg = $this->con->select_all($sqlImg);
            if (count($arrImg) > 0) {
                for ($i = 0; $i < count($arrImg); $i++) {
                    $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                }
            }
            $request[$c]['images'] = $arrImg;
        }
    }
    return $request;
}





public function getVariados(int $id)
{
    $this->con = new Mysql();
    $categoriaId = $id; // ID de la categoría Respaldos de Cama
    $sql = "SELECT p.idproducto,
                    p.codigo,
                    p.nombre,
                    p.descripcion,
                    p.categoriaid,
                    c.nombre as categoria,
                    p.precio,
                    p.precio_normal,
                    p.ruta,
                    p.stock
            FROM producto p 
            INNER JOIN categoria c
            ON p.categoriaid = c.idcategoria
            WHERE p.status != 0 AND p.categoriaid = $categoriaId
            ORDER BY p.idproducto ASC";

    $request = $this->con->select_all($sql);
    if (count($request) > 0) {
        for ($c = 0; $c < count($request); $c++) {
            $intIdProducto = $request[$c]['idproducto'];
            $sqlImg = "SELECT img FROM imagen WHERE productoid = $intIdProducto";
            $arrImg = $this->con->select_all($sqlImg);
            if (count($arrImg) > 0) {
                for ($i = 0; $i < count($arrImg); $i++) {
                    $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                }
            }
            $request[$c]['images'] = $arrImg;
        }
    }
    return $request;
}



	public function getProductosT(){
		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.precio_normal,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status != 0 and p.status != 2  ORDER BY p.idproducto DESC LIMIT ".CANTPORDHOME;
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;

						// SELECT PRECIOS

						$sqlDescuento = "SELECT descuento ,precio  FROM tamanos  WHERE descuento = (SELECT MAX(descuento) FROM tamanos where producto_id = $intIdProducto) and producto_id = $intIdProducto";

						$arrDesc = $this->con->select_all($sqlDescuento); 
						if(count($arrDesc) > 0){
							for ($i=0; $i < count($arrDesc); $i++) { 
								$arrDesc[$i]['descuento'] = $arrDesc[$i]['descuento'];


								

							}
						}
						$request[$c]['descuento'] = $arrDesc;
					}
				}
		return $request;
	}

	public function getProductosHome(){
		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.precio_normal,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status != 0 and p.status != 2 and p.categoriaid != 8 ORDER BY p.idproducto DESC LIMIT ".CANTPORDHOME;
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;

						// SELECT PRECIOS

						$sqlDescuento = "SELECT descuento ,precio  FROM tamanos  WHERE descuento = (SELECT MAX(descuento) FROM tamanos where producto_id = $intIdProducto) and producto_id = $intIdProducto";

						$arrDesc = $this->con->select_all($sqlDescuento); 
						if(count($arrDesc) > 0){
							for ($i=0; $i < count($arrDesc); $i++) { 
								$arrDesc[$i]['descuento'] = $arrDesc[$i]['descuento'];


								

							}
						}
						$request[$c]['descuento'] = $arrDesc;
					}
				}
		return $request;
	}


	//colores disponibles.
	public function getColores(){
		$this->con = new Mysql();
		$sql = "SELECT c.id, c.color FROM colores c";
				$request = $this->con->select_all($sql);



		return $request;
	}

	public function getColoresProducto(int $idprod){ // ACCEDER A LOS PRODUCTOS CON TAMAÑO UNICO 
		$this->con = new Mysql();
		$sql = "SELECT c.productoid,c.id, c.color FROM producto_colores c WHERE c.productoid = $idprod";
				$request = $this->con->select_all($sql);



		return $request;
	}

	public function getColorese($material){
		$this->con = new Mysql();

		
		$sql = "SELECT c.id, c.color FROM colores c where $material = '1' order by color";
		//$sql = "SELECT * FROM colores c INNER JOIN producto_material p ON p.material = ";
				$request = $this->con->select_all($sql);
			$cadena='';
				for ($p=0; $p < count($request); $p++) { 
					 $request[$p]['color'];
					 $request[$p]['id'];
					 
					 }

					 echo json_encode($request,JSON_UNESCAPED_UNICODE);



		
	}


	//Tamaños disponibles.
	public function getTamanos(int $idproducto){
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		$sql = "SELECT * FROM tamanos t where producto_id = $idproducto order by tamano";
				$request = $this->con->select_all($sql);			

		return $request;
	}
	//Telas disponibles.
	public function getTelas(int $idproducto){
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		$sql = "SELECT * FROM telas t INNER JOIN producto_material p on t.tipo_tela = p.material WHERE p.idproducto = $idproducto GROUP BY t.tipo_tela";
		
				$request = $this->con->select_all($sql);			

		return $request;
	}




	//Alturas disponibles.
	public function getAlturas(int $idproducto){
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		$sql = "SELECT * FROM alturas order by altura_base";
				$request = $this->con->select_all($sql);			

		return $request;
	}

//INNER JOIN tamanos t 				on t.producto_id = p.idproducto

	// DESPUES DE DESC AGREGAR LIMIT $desde,$porpagina
	public function getProductosPage($desde, $porpagina){
		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.precio_normal,
						p.ruta,
						p.stock,
						p.tipo_prod
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria				
				WHERE p.status = 1 and p.categoriaid != 8 ORDER BY p.idproducto  DESC";
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;

						// SELECT PRECIOS

						$sqlDescuento = "SELECT descuento ,precio  FROM tamanos  WHERE descuento = (SELECT MAX(descuento) FROM tamanos where producto_id = $intIdProducto) and producto_id = $intIdProducto";

						$arrDesc = $this->con->select_all($sqlDescuento); 
						if(count($arrDesc) > 0){
							for ($i=0; $i < count($arrDesc); $i++) { 
								$arrDesc[$i]['descuento'] = $arrDesc[$i]['descuento'];


								

							}
						}
						$request[$c]['descuento'] = $arrDesc;
						



					}
				}
		return $request;
	}

		// SELECT DE PRODUCTOS EN STOCK EN FABRICA
	public function getProductosStock($desde, int $porpagina){

		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.precio_normal,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status = 1 and c.idcategoria = 8 ORDER BY p.idproducto DESC LIMIT $desde,$porpagina";
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}
				}
		return $request;
	}



	public function getProductosCategoriaT(int $idcategoria, string $ruta, $desde = null, $porpagina = null){
		$this->intIdcategoria = $idcategoria;
		$this->strRuta = $ruta;
		$where = "";
		if(is_numeric($desde) AND is_numeric($porpagina)){
			$where = " LIMIT ".$desde.",".$porpagina;
		}

		$this->con = new Mysql();
		$sql_cat = "SELECT idcategoria,nombre,ruta FROM categoria WHERE idcategoria = '{$this->intIdcategoria}'";
		$request = $this->con->select($sql_cat);
		// DESPUES DE LIMIT AGREGAR .$where; PARA PAGINAR 
		if(!empty($request)){
			$this->strCategoria = $request['nombre'];
			$this->strRutaCategoria = $request['ruta'];
			$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.categoriaid,
							c.nombre as categoria,
							p.precio,
							p.ruta,
							p.stock
					FROM producto p 
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE p.status != 0 AND p.categoriaid = $this->intIdcategoria AND c.ruta = '{$this->strRuta}'
					ORDER BY p.idproducto asc ";
					$request = $this->con->select_all($sql);
					if(count($request) > 0){
						for ($c=0; $c < count($request) ; $c++) { 
							$intIdProducto = $request[$c]['idproducto'];
							$sqlImg = "SELECT img
									FROM imagen
									WHERE productoid = $intIdProducto";
							$arrImg = $this->con->select_all($sqlImg);
							if(count($arrImg) > 0){
								for ($i=0; $i < count($arrImg); $i++) { 
									$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
								}
							}
							$request[$c]['images'] = $arrImg;
						}
					}
			$request = array('idcategoria' => $this->intIdcategoria,
								'ruta' => $this->strRutaCategoria,
								'categoria' => $this->strCategoria,
								'productos' => $request
							);

		}
		return $request;
	}

	public function getProductoT(int $idproducto, string $ruta){
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		$this->strRuta = $ruta;
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						c.ruta as ruta_categoria,
						p.precio,
						p.ruta,
						p.stock,
						p.tipo_prod
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status != 0 AND p.idproducto = '{$this->intIdProducto}' AND p.ruta = '{$this->strRuta}' ";
				$request = $this->con->select($sql);
				if(!empty($request)){
					$intIdProducto = $request['idproducto'];
					$sqlImg = "SELECT img
							FROM imagen
							WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg);
					if(count($arrImg) > 0){
						for ($i=0; $i < count($arrImg); $i++) { 
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						}
					}else{
						$arrImg[0]['url_image'] = media().'/images/uploads/product.png';
					}
					$request['images'] = $arrImg;
				}
		return $request;
	}

	public function getProductosRandom(int $idcategoria, int $cant, string $option){
		$this->intIdcategoria = $idcategoria;
		$this->cant = $cant;
		$this->option = $option;

		if($option == "r"){
			$this->option = " RAND() ";
		}else if($option == "a"){
			$this->option = " idproducto ASC ";
		}else{
			$this->option = " idproducto DESC ";
		}

		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status != 0 AND p.categoriaid = $this->intIdcategoria
				ORDER BY $this->option LIMIT  $this->cant ";
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}
				}
		return $request;
	}	

	public function getProductoIDT(int $idproducto){
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock,
						p.tipo_prod
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status != 0 AND p.idproducto = '{$this->intIdProducto}' ";
				$request = $this->con->select($sql);
				if(!empty($request)){
					$intIdProducto = $request['idproducto'];
					$sqlImg = "SELECT img
							FROM imagen
							WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg);
					if(count($arrImg) > 0){
						for ($i=0; $i < count($arrImg); $i++) { 
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						}
					}else{
						$arrImg[0]['url_image'] = media().'/images/uploads/product.png';
					}
					$request['images'] = $arrImg;
				}
		return $request;
	}

	public function cantProductos($categoria = null){
		$where = "";
		if($categoria != null){
			$where = " AND categoriaid = ".$categoria;
		}
		$this->con = new Mysql();
		$sql = "SELECT COUNT(*) as total_registro FROM producto WHERE status = 1 ".$where;
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;

	}

	public function cantProductosStock($categoria = null){
		$where = "";
		if($categoria != null){
			$where = " AND categoriaid = ".$categoria;
		}
		$this->con = new Mysql();
		$sql = "SELECT COUNT(*) as total_registro FROM producto WHERE categoriaid = 8 and stock = 1 ".$where;
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;

	}

	public function cantProdSearch($busqueda){
		$this->con = new Mysql();
		$sql = "SELECT COUNT(*) as total_registro FROM productos WHERE nombre LIKE '%$busqueda%'  AND status = 1 ";
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;
	}

	public function getProdSearch($busqueda, $desde, $porpagina){
		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock,
						p.status
					
				FROM producto p 
				INNER JOIN categorias c
				ON p.categoriaid = c.idcategoria
				WHERE MATCH (p.nombre) AGAINST ('$busqueda') AND p.status = 1";
				//WHERE c.nombre LIKE '%".$busqueda."%' or p.nombre LIKE '%".$busqueda."%' AND p.status = 1  ORDER BY p.idproducto DESC LIMIT $desde,$porpagina";
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}
				}
				else{
					$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock,
						p.status
					
				FROM producto p 
				INNER JOIN categorias c
				ON p.categoriaid = c.idcategoria
				WHERE c.nombre LIKE '%".$busqueda."%' or p.nombre LIKE '%".$busqueda."%' AND p.status = 1  ORDER BY p.idproducto DESC LIMIT $desde,$porpagina";
				//WHERE ";
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}

				}
				 }
		return $request;
	}
}

 ?>