<?php
require_once ("Libraries/Core/Mysql.php");
trait TCliente
{
	private $con;

	private $conIntranet;

	private $intIdUsuario;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strEmail;
	private $strPassword;
	private $strToken;
	private $intTipoId;
	private $intIdTransaccion;



    public function getRutCliente($personaid) {
        $this->con = new Mysql();
        $sql = "SELECT identificacion FROM persona WHERE idpersona = ?";
        $arrData = array($personaid);
        $request = $this->con->select($sql, $arrData);
        return $request['identificacion'];
    }

    // Método para obtener el nombre del producto
    public function getNombreProducto($productoid) {
        $this->con = new Mysql();
        $sql = "SELECT nombre FROM producto WHERE idproducto = ?";
        $arrData = array($productoid);
        $request = $this->con->select($sql, $arrData);
        return $request['nombre'];
    }

	    // Método para obtener y descomponer la dirección del cliente
	    public function getDireccionCliente($idpedido) {
			$this->con = new Mysql();
			$sql = "SELECT direccion_envio,referencia FROM pedido WHERE idpedido = ?";
			$arrData = array($idpedido);
			$request = $this->con->select($sql, $arrData);
			$direccionCompleta = $request['direccion_envio'];
	
			// Descomponer la dirección
			list($direccion, $numero, $dpto, $region, $comuna) = explode(", ", $direccionCompleta);
	
			return array(
				'direccion' => $direccion,
				'numero' => $numero,
				'dpto' => $dpto,
				'region' => $region,
				'comuna' => $comuna,
				'referencia' => $request['referencia']
			);
		}


		public function getClienteInfo($personaid) {
			$this->con = new Mysql();
			$sql = "SELECT identificacion AS rut, nombres,apellidos, telefono, email_user FROM persona WHERE idpersona = ?";
			$arrData = array($personaid);
			$request = $this->con->select($sql, $arrData);
			return $request;
		}

		


	public function insertCliente(string $nombre, string $apellido, int $telefono, string $rut, string $email, string $password, int $tipoid)
	{
		$this->con = new Mysql();
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->rut = $rut;
		$this->intTipoId = $tipoid;

		$return = 0;
		$sql = "SELECT * FROM persona WHERE 
				identificacion = '{$this->rut}' ";
		$request = $this->con->select_all($sql);

		if (empty($request)) {
			$query_insert = "INSERT INTO persona(nombres,apellidos,telefono,identificacion,email_user,password,rolid) 
							  VALUES(?,?,?,?,?,?,?)";
			$arrData = array(
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono,
				$this->rut,
				$this->strEmail,
				$this->strPassword,
				$this->intTipoId
			);
			$request_insert = $this->con->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = "exist";
		}
		return $return;
	}

	public function insertPedido(string $idtransaccionpaypal = NULL, string $datospaypal = NULL, int $personaid, float $costo_envio, string $monto, string $descuento, string $tipopagoid, string $direccionenvio, string $referencia, string $status)
	{
		$this->con = new Mysql();
		// NO SE INSERTA FECHA PORQUE EN BD ESTA CURRENT_TIMESTAMP
		$query_insert = "INSERT INTO pedido(idtransaccionpaypal,datospaypal,personaid,costo_envio,monto,descuento,tipopagoid,direccion_envio,referencia,status) 
							  VALUES(?,?,?,?,?,?,?,?,?,?)";
		$arrData = array(
			$idtransaccionpaypal,
			$datospaypal,
			$personaid,
			$costo_envio,
			$monto,
			$descuento,
			$tipopagoid,
			$direccionenvio,
			$referencia,
			$status
		);
		$request_insert = $this->con->insert($query_insert, $arrData);
		$return = $request_insert;





		return $return;
	}

	public function getTableColumns($tableName) {
		$this->conIntranet = new Mysql();  // Asegúrate de que esta conexión está correctamente configurada.
		$sql = "DESCRIBE " . $tableName;  // Esta consulta SQL devuelve la estructura de la tabla.
		try {
			$result = $this->conIntranet->select_all($sql);
			return $result;
		} catch (PDOException $e) {
			echo 'Error al obtener columnas: ' . $e->getMessage();
			return null;
		}
	}



	public function insertPedidoINT($personaid, $costo_envio, $totalPagado, $vendedor, $metodoEntrega, $estado, $orden_ext) 
		{
		$this->conIntranet = new Mysql();

		$fechaHoy = date('Y-m-d'); // Ajusta el formato según sea necesario


	    $query_insert = "INSERT INTO pedido(rut_cliente, fecha_ingreso, despacho, total_pagado, vendedor, metodo_entrega, estado, orden_ext) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
// Asegúrate de que solo haya 8 marcadores de posición

$arrData = array(
	$personaid,      // rut_cliente: ID del cliente
	$fechaHoy,       // fecha_ingreso: La fecha actual
	$costo_envio, // despacho: Dirección de envío
	$totalPagado,    // total_pagado: Monto total pagado, '0' inicialmente hasta que se valide la transferencia
	$vendedor,     // vendedor: Quién realiza la venta o la referencia de vendedor
	$metodoEntrega,  // metodo_entrega: Método de entrega del pedido
	$estado,         // estado: Estado del pedido, 'Pendiente' u otro valor inicial
	$orden_ext          // orden_ext: Podría ser usado para almacenar el estado del pedido o un identificador adicional
);
try {
	$request_insert = $this->conIntranet->insert($query_insert, $arrData);
	return $request_insert;
} catch (PDOException $e) {
	echo 'Error al insertar el pedido: ' . $e->getMessage();
	$columnDetails = $this->getTableColumns("pedido");
	print_r($columnDetails); 
	return $request_insert;




}




		
	}





	public function insertDetalle(int $idpedido, int $productoid, string $tamano, string $color, string $tipo_tela, string $altura_base, float $precio, int $cantidad)
	{
		$this->con = new Mysql();
		$query_insert = "INSERT INTO detalle_pedido(pedidoid,productoid,tamano,color,tipo_tela,altura_base,precio,cantidad) 
							  VALUES(?,?,?,?,?,?,?,?)";
		$arrData = array(
			$idpedido,
			$productoid,
			$tamano,
			$color,
			$tipo_tela,
			$altura_base,
			$precio,
			$cantidad
		);
		$request_insert = $this->con->insert($query_insert, $arrData);
		$return = $request_insert;




		/* ACTUALIZAR ESTADO DEL PRODUCTO UNICO. */

		$sql_detalle = "SELECT stock FROM producto where idproducto = $productoid";
		$requestProducto = $this->con->select_all($sql_detalle);
		foreach ($requestProducto as $data) {
			$stock = $data['stock'];
		}
		$stock = $stock - $cantidad;

		// ACTUALIZAR STOCK Y ESTADO DEL PRODUCTO, SI QUEDA SIN STOCK SE DESACTIVA EL PRODUCTO.
		if ($stock == 0) {
			$sql = "UPDATE producto SET status = ?, stock = ? WHERE idproducto = ?";
			$arrData = array('0', $stock, $productoid);
		} else {
			$sql = "UPDATE producto SET status = ?, stock = ? WHERE idproducto = ?";
			$arrData = array('1', $stock, $productoid);
		}

		$request_insert = $this->con->update($sql, $arrData);


		/*                     */


		return $return;
	}

	public function insertDireccion(string $personaid, string $direccion, string $dirNumero, string $dirDepto, string $dirRegion, string $dirComuna, string $instrucciones)
	{
		$this->con = new Mysql();
		$query_insert = "INSERT INTO direccion_cliente(rut_cliente,direccion,numero,dpto,region,comuna,referencia) 
							  VALUES(?,?,?,?,?,?,?)";
		$arrData = array(
			$personaid,
			$direccion,
			$dirNumero,
			$dirDepto,
			$dirRegion,
			$dirComuna,
			$instrucciones
		);
		$request_insert = $this->con->insert($query_insert, $arrData);
		$return = $request_insert;
		$request = array(
			'id' => $request_insert,
			'rut_cliente' => $personaid
		);
		return $request;
	}


	public function getDir(string $idcliente, string $iddireccionselect)
	{
		$this->con = new Mysql();
		$request = array();
		$_SESSION['iddireccion'] = $iddireccionselect;

		$sql = "SELECT * FROM direccion_cliente where rut_cliente = '$idcliente' and id = '$iddireccionselect'";
		$requestPedido = $this->con->select_all($sql);


		if ($requestPedido > 0) {
			$sql_detalle = "SELECT * FROM direccion_cliente where rut_cliente = '$idcliente' and id = '$iddireccionselect'";
			$requestProductos = $this->con->select_all($sql_detalle);
			$request = array(
				'direccion' => $requestProductos,
				'numero' => $requestProductos,
				'dpto' => $requestProductos,
				'region' => $requestProductos,
				'comuna' => $requestProductos,
				'referencia' => $requestProductos
			);


		}

		return $requestProductos;
	}


	public function getPrecioDescuento(string $codigo)
	{
		$this->con = new Mysql();
		$request = array();
		$sql = "SELECT * FROM descuentos where nombre = '$codigo' and estado = '1'";
		$requestPedido = $this->con->select($sql);
		if ($requestPedido > 0) {
			$sql_detalle = "SELECT * FROM descuentos where nombre = '$codigo' and estado = '1'";
			$requestProductos = $this->con->select_all($sql_detalle);
			foreach ($requestProductos as $precio) {
				$request = array('descuento' => $precio['precio'], 'nombre' => $precio['nombre']);
			}
		}

		return $request;
	}





	public function getPrecioEnvio(string $comuna)
	{
		$this->con = new Mysql();
		$request = array();
		$sql = "SELECT * FROM costos_envio where comuna = '$comuna'";
		$requestPedido = $this->con->select($sql);
		if ($requestPedido > 0) {
			$sql_detalle = "SELECT * FROM costos_envio where comuna = '$comuna'";
			$requestProductos = $this->con->select_all($sql_detalle);
			foreach ($requestProductos as $ass) {
				if ($ass['precio'] == 1) {
					$request = array(
						'precio' => "0",
						'comuna' => $comuna,
						'envio_loc' => "region",
						'iddireccion' => $ass['id']
					);
				} else {
					$request = array(
						'precio' => $ass['precio'],
						'comuna' => $comuna,
						'iddireccion' => $ass['id']
					);
				}
			}
		} else {
			$request = array(
				'precio' => "0",
				'comuna' => $comuna,
				'envio_loc' => "region"
			);
		}

		return $request;
	}



	public function insertDetalleTemp(array $pedido)
	{
		$this->intIdUsuario = $pedido['idcliente'];
		$this->intIdTransaccion = $pedido['idtransaccion'];
		$productos = $pedido['productos'];

		$this->con = new Mysql();
		$sql = "SELECT * FROM detalle_temp WHERE 
					transaccionid = '{$this->intIdTransaccion}' AND 
					personaid = $this->intIdUsuario";
		$request = $this->con->select_all($sql);

		if (empty($request)) {
			foreach ($productos as $producto) {
				$query_insert = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) 
								  VALUES(?,?,?,?,?)";
				$arrData = array(
					$this->intIdUsuario,
					$producto['idproducto'],
					$producto['precio'],
					$producto['cantidad'],
					$this->intIdTransaccion
				);
				$request_insert = $this->con->insert($query_insert, $arrData);
			}
		} else {
			$sqlDel = "DELETE FROM detalle_temp WHERE 
				transaccionid = '{$this->intIdTransaccion}' AND 
				personaid = $this->intIdUsuario";
			$request = $this->con->delete($sqlDel);
			foreach ($productos as $producto) {
				$query_insert = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) 
								  VALUES(?,?,?,?,?)";
				$arrData = array(
					$this->intIdUsuario,
					$producto['idproducto'],
					$producto['precio'],
					$producto['cantidad'],
					$this->intIdTransaccion
				);
				$request_insert = $this->con->insert($query_insert, $arrData);
			}
		}
	}

	public function getPedido(int $idpedido)
	{
		$this->con = new Mysql();
		$request = array();
		$sql = "SELECT p.idpedido,
					   p.referenciacobro,
					   p.idtransaccionpaypal,
					   p.datospaypal,
					   p.personaid,
					   p.fecha,
					   p.costo_envio,
					   p.monto,
					   p.tipopagoid,					 
					   p.direccion_envio,
					   p.status
				FROM pedido as p				
				WHERE p.idpedido = $idpedido";
		$requestPedido = $this->con->select($sql);

		if (count($requestPedido) > 0) {
			$sql_detalle = "SELECT p.idproducto,
								   p.nombre as producto,
								   (SELECT i.img FROM imagen i WHERE i.productoid = p.idproducto LIMIT 1) as img,
								   d.tamano,
								   d.color,
								   d.altura_base,
								   d.tipo_tela,
								   d.precio,
								   d.cantidad
							FROM detalle_pedido d
							INNER JOIN producto p
							ON d.productoid = p.idproducto
							WHERE d.pedidoid = $idpedido";
			$requestProductos = $this->con->select_all($sql_detalle);
			$request = array(
				'orden' => $requestPedido,
				'detalle' => $requestProductos
			);
		}
		return $request;
	}



	public function setSuscripcion(string $nombre, string $email)
	{
		$this->con = new Mysql();
		$sql = "SELECT * FROM suscripciones WHERE email = '{$email}'";
		$request = $this->con->select_all($sql);
		if (empty($request)) {
			$query_insert = "INSERT INTO suscripciones(nombre,email) 
							  VALUES(?,?)";
			$arrData = array($nombre, $email);
			$request_insert = $this->con->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = false;
		}
		return $return;
	}

	public function setContacto(string $nombre, string $email, string $mensaje, string $ip, string $dispositivo, string $useragent)
	{
		$this->con = new Mysql();
		$nombre = $nombre != "" ? $nombre : "";
		$email = $email != "" ? $email : "";
		$mensaje = $mensaje != "" ? $mensaje : "";
		$ip = $ip != "" ? $ip : "";
		$dispositivo = $dispositivo != "" ? $dispositivo : "";
		$useragent = $useragent != "" ? $useragent : "";
		$query_insert = "INSERT INTO contacto(nombre,email,mensaje,ip,dispositivo,useragent) 
						  VALUES(?,?,?,?,?,?)";
		$arrData = array($nombre, $email, $mensaje, $ip, $dispositivo, $useragent);
		$request_insert = $this->con->insert($query_insert, $arrData);
		return $request_insert;
	}
}

?>