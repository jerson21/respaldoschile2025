<?php

class Cliente_confirma extends Mysql
{
	private $intIdProducto;
	private $strNombre;
	private $strDescripcion;
	private $intCodigo;
	private $intCategoriaId;
	private $intPrecio;
	private $intStock;
	private $intStatus;
	private $strRuta;
	private $strImagen;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectProductos()
	{
		$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.categoriaid,
							c.nombre as categoria,
							p.precio,
							p.stock,
							p.tipo_prod,
							p.status 
					FROM producto p 
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE p.status != 0 ";
		$request = $this->select_all($sql);
		return $request;
	}

	public function insertProducto(string $nombre, string $descripcion, string $codigo, int $categoriaid, string $precio, int $stock, string $ruta, int $status, int $tipo_prod)
	{
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intCodigo = $codigo;
		$this->intCategoriaId = $categoriaid;
		$this->strPrecio = $precio;
		$this->intStock = $stock;
		$this->strRuta = $ruta;
		$this->intStatus = $status;
		$this->tipo_prod = $tipo_prod;
		$return = 0;
		$sql = "SELECT * FROM producto WHERE codigo = '{$this->intCodigo}'";
		$request = $this->select_all($sql);
		if (empty($request)) {
			$query_insert = "INSERT INTO producto(categoriaid,
														codigo,
														nombre,
														descripcion,
														precio,
														stock,
														ruta,
														status,tipo_prod) 
								  VALUES(?,?,?,?,?,?,?,?,?)";
			$arrData = array(
				$this->intCategoriaId,
				$this->intCodigo,
				$this->strNombre,
				$this->strDescripcion,
				$this->strPrecio,
				$this->intStock,
				$this->strRuta,
				$this->intStatus,
				$this->tipo_prod
			);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = "exist";
		}
		return $return;
	}


	public function insertColor(int $idproducto, string $color, string $status)
	{
		$this->color = $color;
		$this->idproducto = $idproducto;
		$this->status = $status;
		$return = 0;
		$sql = "SELECT * FROM producto_colores c WHERE c.productoid = $idproducto and c.color = '$color'";
		$request = $this->select_all($sql);



		if (empty($request)) {
			$query_insert = "INSERT INTO producto_colores(productoid,color,status) 
								  VALUES(?,?,?)";
			$arrData = array(
				$this->idproducto,
				$this->color,
				$this->status
			);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $color;
		} else {
			$return = "exist";
		}



		return $return;
	}



	public function insertColorProducto(int $idproducto, string $material)
	{
		$this->material = $material;
		$this->idproducto = $idproducto;

		$return = 0;
		$sql = "SELECT * FROM producto_material c WHERE c.idproducto = $idproducto and c.material = '$material'";
		$request = $this->select_all($sql);



		if (empty($request)) {
			$query_insert = "INSERT INTO producto_material(idproducto,material) 
								  VALUES(?,?)";
			$arrData = array(
				$this->idproducto,
				$this->material
			);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $material;
		} else {
			$return = "exist";
		}



		return $return;
	}

	public function insertPrecioProducto(int $idproducto, string $tamano, string $precio)
	{
		$this->idproducto = $idproducto;
		$this->precio = $precio;
		$this->tamano = $tamano;


		$return = 0;
		$sql = "SELECT * FROM tamanos t WHERE t.producto_id = $idproducto and t.tamano = '$tamano'";
		$request = $this->select_all($sql);



		if (empty($request)) {
			$query_insert = "INSERT INTO tamanos(producto_id,tamano,precio) 
								  VALUES(?,?,?)";
			$arrData = array(
				$this->idproducto,
				$this->tamano,
				$this->precio
			);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = "exist";
		}



		return $return;
	}



	public function updatePrecioProducto(int $idproducto, string $tamano, string $precio)
	{
		$this->idproducto = $idproducto;
		$this->precio = $precio;
		$this->tamano = $tamano;
		$return = 0;

		$sql = "SELECT * FROM tamanos t WHERE t.producto_id = $idproducto and t.tamano = '$tamano'";
		$request = $this->select_all($sql);



		if (empty($request)) {
			$sql = "UPDATE tamanos 
						SET precio=?														 
						WHERE idproducto = $this->idproducto and tamano = $this->tamano";
			$arrData = array(
				$this->idproducto,
				$this->precio,
				$this->tamano
			);

			$request = $this->update($sql, $arrData);
			$return = $request;
		} else {
			$return = "exist";
		}
		return $return;
	}





	public function updateProducto(int $idproducto, string $nombre, string $descripcion, string $codigo, int $categoriaid, string $precio, int $stock, string $ruta, int $status)
	{
		$this->intIdProducto = $idproducto;
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intCodigo = $codigo;
		$this->intCategoriaId = $categoriaid;
		$this->strPrecio = $precio;
		$this->intStock = $stock;
		$this->strRuta = $ruta;
		$this->intStatus = $status;
		$return = 0;
		$sql = "SELECT * FROM producto WHERE codigo = '{$this->intCodigo}' AND idproducto != $this->intIdProducto ";
		$request = $this->select_all($sql);
		if (empty($request)) {
			$sql = "UPDATE producto 
						SET categoriaid=?,
							codigo=?,
							nombre=?,
							descripcion=?,
							precio=?,
							stock=?,
							ruta=?,
							status=? 
						WHERE idproducto = $this->intIdProducto ";
			$arrData = array(
				$this->intCategoriaId,
				$this->intCodigo,
				$this->strNombre,
				$this->strDescripcion,
				$this->strPrecio,
				$this->intStock,
				$this->strRuta,
				$this->intStatus
			);

			$request = $this->update($sql, $arrData);
			$return = $request;
		} else {
			$return = "exist";
		}
		return $return;
	}

	public function selectProducto(int $idproducto)
	{
		$sql = "SELECT tipo_prod FROM producto where idproducto = $idproducto";
		$request = $this->select($sql);

		$this->intIdProducto = $idproducto;
		if ($request['tipo_prod'] == 1) {
			$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.precio,
							p.stock,
							p.categoriaid,
							c.nombre as categoria,
							p.status,
							p.tipo_prod							
					FROM producto p
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE idproducto = $this->intIdProducto";
			$request = $this->select($sql);
			return $request;
		} else {

			$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.precio,
							p.stock,
							p.categoriaid,
							c.nombre as categoria,
							p.status,
							t.tamano,
							t.precio,
							p.tipo_prod
					FROM producto p
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria INNER JOIN tamanos t
					ON p.idproducto = t.producto_id
					WHERE idproducto = $this->intIdProducto";
			$request = $this->select($sql);
			return $request;
		}




	}

	public function insertImage(int $idproducto, string $imagen)
	{
		$this->intIdProducto = $idproducto;
		$this->strImagen = $imagen;
		$query_insert = "INSERT INTO imagen(productoid,img) VALUES(?,?)";
		$arrData = array(
			$this->intIdProducto,
			$this->strImagen
		);
		$request_insert = $this->insert($query_insert, $arrData);
		return $request_insert;
	}

	public function selectImages(int $idproducto)
	{
		$this->intIdProducto = $idproducto;
		$sql = "SELECT productoid,img
					FROM imagen
					WHERE productoid = $this->intIdProducto";
		$request = $this->select_all($sql);
		return $request;
	}

	public function deleteImage(int $idproducto, string $imagen)
	{
		$this->intIdProducto = $idproducto;
		$this->strImagen = $imagen;
		$query = "DELETE FROM imagen 
						WHERE productoid = $this->intIdProducto 
						AND img = '{$this->strImagen}'";
		$request_delete = $this->delete($query);
		return $request_delete;
	}

	public function deleteProducto(int $idproducto)
	{
		$this->intIdProducto = $idproducto;
		$sql = "UPDATE producto SET status = ? WHERE idproducto = $this->intIdProducto ";
		$arrData = array(0);
		$request = $this->update($sql, $arrData);
		return $request;
	}
}
?>