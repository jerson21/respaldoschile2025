<?php 
	
	class Mysql extends Conexion
	{
		private $conexion;
		private $strquery;
		private $arrValues;
		
	
		function __construct()
		{
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();
		}

		public function getConexion() {
			return $this->conexion;
		}

		

		  // Agregar métodos para manejar transacciones
		  public function beginTransaction()
		  {
			  return $this->conexion->beginTransaction();
		  }
	  
		  public function commit()
		  {
			  return $this->conexion->commit();
		  }
	  
		  public function rollBack()
		  {
			  return $this->conexion->rollBack();
		  }

		//Insertar un registro
		public function insert(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
        	$insert = $this->conexion->prepare($this->strquery);
        	$resInsert = $insert->execute($this->arrVAlues);
        	if($resInsert)
	        {
	        	$lastInsert = $this->conexion->lastInsertId();
	        }else{
	        	$lastInsert = 0;
	        }
	        return $lastInsert; 
		}
		//Busca un registro
	    // Método select para una sola fila
		public function select($query, $arrValues = []) {
			$this->strquery = $query;
			$stmt = $this->conexion->prepare($this->strquery);
	
			if (!empty($arrValues)) {
				foreach ($arrValues as $key => $value) {
					$stmt->bindValue($key + 1, $value); // +1 because PDO uses 1-based indexing for parameters
				}
			}
	
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}
		//Devuelve todos los registros
		public function select_all(string $query)
		{
			$this->strquery = $query;
        	$result = $this->conexion->prepare($this->strquery);
			$result->execute();
        	$data = $result->fetchall(PDO::FETCH_ASSOC);
        	return $data;
		}
		//Actualiza registros
		public function update(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute($this->arrVAlues);
	        return $resExecute;
		}
		//Eliminar un registros
		public function delete(string $query)
		{
			$this->strquery = $query;
        	$result = $this->conexion->prepare($this->strquery);
			$del = $result->execute();
        	return $del;
		}
	}


 ?>

