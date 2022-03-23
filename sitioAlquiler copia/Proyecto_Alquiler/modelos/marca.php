<?php

require_once ("generico.php");

class marca extends generico{


	public $marca;	

	

	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);
		$this->marca     = $this->chequeadorConstructor($arrayDatos, 'marca','');

	
	}

	public function ingresarMarca(){
		
		
		try{

			$varSQL = 'SELECT * FROM marcas WHERE marca = :marca';		
			$arrayMarca = array('marca' => $this-> marca);
			$respuesta = $this->traerListado($varSQL, $arrayMarca);

			

			if(!empty($respuesta)){
				/*
					En caso que tenga registro entro aca y devuelvo que ya ese autor esta ingresado
				*/
				return "Ya esta ingresada la Marca";
			}

			$fecha = date("Y-m-d h:i:s");
			$sql = "INSERT INTO marcas SET 
						marca = :marca,
                        estadoRegistro = :estadoRegistro,
						fechaEdicion   = :fechaEdicion;
						
						
				";

$arrayMarca = array(
				"marca"	                =>	$this->marca,
				"estadoRegistro"	    =>	$this->estadoRegistro,
				"fechaEdicion"          =>  $fecha,
			);	

			$respuesta = $this->ejecutarSentencia($sql, $arrayMarca);

			if($respuesta == 1){
				$retorno = "La marca se ingreso correctamente";
			}else{
				$retorno = "Error al ingresar marca";
			}

			return $retorno;

		}catch(PDOException $e){

			$retorno = "Ocurrio Un error al ingresar marca";
			return $retorno;
		}

	}

	public function traerMarca($idRegistro){

		$varSQL = 'SELECT * FROM marcas where idMarca = :idMarca;';
		
		$arrayMarca = array('idMarca' => $idRegistro);

	
		$respuesta = $this->traerListado($varSQL,$arrayMarca);

		$this->idRegistro        = $respuesta[0]['idMarca'];
		$this->marca             = $respuesta[0]['marca'];		
		$this->estadoRegistro    = $respuesta[0]['estadoRegistro'];
	
	}
	
    

	public function guardarMarca(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE marcas SET
					marca          = :marca,								
					estadoRegistro = :estadoRegistro,
					fechaEdicion   = :fechaEdicion
					
				WHERE idMarca = :idMarca;
			";

		$arrayMarca = array(
			"marca"	                  =>  $this->marca,				
			"estadoRegistro"          =>  $this->estadoRegistro,
			"fechaEdicion"            =>  $fecha,
			"idMarca"                  =>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayMarca);
		if($respuesta == 1){
			$retorno = "Se guardo la marca";
		}else{
			$retorno = "Error al guardar la marca";
		}
		return $retorno;

	}


	public function listarMarca($filtos = array()){
		
		//$varSQL = 'SELECT * FROM vehiculos';

		// Evaluo si existe en el array que recibo la clave pagina en caso contrario pongo por defecto 0.
		if(isset($filtos['pagina']) && $filtos['pagina'] != "" ){			
			$pagina = $filtos['pagina'];
		}else{
			$pagina = 0;
		}
		// Evaluo si existe en el array que recibo la clave limite en caso contrario pongo por defecto 10.
		if(isset($filtos['limite']) && $filtos['limite'] != "" ){
			$limite = $filtos['limite'];
		}else{
			$limite = 5;
		}
		 'SELECT * FROM marcas LIMIT 0,5'; 
		
		 $puntoSalida = $pagina * $limite;

		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE marca LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = "SELECT * FROM marcas ".$buscador."ORDER BY marca LIMIT ".$puntoSalida.",".$limite."";


		$retorno = $this->traerListado($varSQL, array());
		return $retorno;		
		
	}

	public function totalMarca($filtos = array()){
		
		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE marca LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = 'SELECT count(1) AS totalRegistros FROM marcas '.$buscador.'';

		$respuesta = $this->traerListado($varSQL, array());
		$retorno = $respuesta[0]['totalRegistros'];

		return $retorno;

	}




	public function listarbyMarca(){
		
		$varSQL = 'SELECT * FROM  marcas WHERE marca = "";';
		$retorno = $this->traerListado($varSQL, array());
		
		return $retorno;

	}


}

?>