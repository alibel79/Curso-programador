<?php

require_once ("generico.php");

class carroceria extends generico{


	public $carroceria;	
	public $precio;
	

	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);
		$this->carroceria     = $this->chequeadorConstructor($arrayDatos, 'carroceria','');
		$this->precio 	      = $this->chequeadorConstructor($arrayDatos, 'precio',''); 
	
	}

	public function ingresarCarroc(){
		
		
		try{

			$varSQL = 'SELECT * FROM carroceria WHERE tipoCarroceria = :tipoCarroceria';		
			$arrayCarroceria = array('tipoCarroceria' => $this-> carroceria);
			$respuesta = $this->traerListado($varSQL, $arrayCarroceria);

			

			if(!empty($respuesta)){
				/*
					En caso que tenga registro entro aca y devuelvo que ya ese autor esta ingresado
				*/
				return "Ya esta ingresado el tipo de Carrocería";
			}

			$fecha = date("Y-m-d h:i:s");
			$sql = "INSERT INTO carroceria SET 
						tipoCarroceria = :carroceria,
						precio         =:precio,										
						estadoRegistro = :estadoRegistro,
						fechaEdicion   = :fechaEdicion;
						
				";

$arrayCarroceria = array(
				"carroceria"	    =>	$this->carroceria,
				"precio" 		        =>  $this->precio,		
				"estadoRegistro"	    =>	$this->estadoRegistro,
				"fechaEdicion"          =>  $fecha,
			);	

			$respuesta = $this->ejecutarSentencia($sql, $arrayCarroceria);

			if($respuesta == 1){
				$retorno = "El tipo de carrocería se ingreso correctamente";
			}else{
				$retorno = "Error al ingresar carrocería";
			}

			return $retorno;

		}catch(PDOException $e){

			$retorno = "Ocurrio Un error al ingresar el tipo carrocería";
			return $retorno;
		}

	}

	public function traerCarroceria($idRegistro){

		$varSQL = 'SELECT * FROM carroceria where idTipo = :idTipo;';
		
		$arrayCarroceria = array('idTipo' => $idRegistro);

	
		$respuesta = $this->traerListado($varSQL,$arrayCarroceria);

		$this->idRegistro        = $respuesta[0]['idTipo'];
		$this->carroceria        = $respuesta[0]['tipoCarroceria'];
		$this->precio	         = $respuesta[0]['precio'];
		$this->estadoRegistro    = $respuesta[0]['estadoRegistro'];
	
	}
	
    

	public function guardarCarroceria(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE carroceria SET
					tipoCarroceria = :carroceria,
					precio         = :precio,				
					estadoRegistro = :estadoRegistro,
					fechaEdicion   = :fechaEdicion
					
				WHERE idTipo = :idTipo;
			";

		$arrayCarroceria = array(
			"carroceria"	          =>  $this->carroceria,
			"precio" 		          =>  $this->precio,		
			"estadoRegistro"          =>  $this->estadoRegistro,
			"fechaEdicion"            =>  $fecha,
			"idTipo"                  =>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayCarroceria);
		if($respuesta == 1){
			$retorno = "Se guardo el tipo de carrocería correctamente";
		}else{
			$retorno = "Error al guardar la carrocería";
		}
		return $retorno;

	}


	public function listarCarroceria($filtos = array()){
		
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
		 'SELECT * FROM carroceria LIMIT 0,5'; 
		
		 $puntoSalida = $pagina * $limite;

		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE tipoCarroceria LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = "SELECT * FROM carroceria ".$buscador."ORDER BY tipoCarroceria LIMIT ".$puntoSalida.",".$limite."";


		$retorno = $this->traerListado($varSQL, array());
		return $retorno;		
		
	}

	public function totalTipos($filtos = array()){
		
		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE tipoCarroceria LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = 'SELECT count(1) AS totalRegistros FROM carroceria '.$buscador.'';

		$respuesta = $this->traerListado($varSQL, array());
		$retorno = $respuesta[0]['totalRegistros'];

		return $retorno;

	}




	public function listarCarrocTipo(){
		
		$varSQL = 'SELECT * FROM  carroceria WHERE tipoCarroceria = "";';
		$retorno = $this->traerListado($varSQL, array());
		
		return $retorno;

	}


}

?>