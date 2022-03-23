<?php

require_once ("generico.php");

class vehiculos extends generico{


	public $matricula;	
	public $marca;
	public $modelo;
	public $color;
	public $motor;

	

	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);
		$this->matricula = $this->chequeadorConstructor($arrayDatos, 'matricula','');
		$this->marca 	= $this->chequeadorConstructor($arrayDatos, 'marca','' ); 
		$this->modelo 	= $this->chequeadorConstructor($arrayDatos, 'modelo',''); 
		$this->color	= $this->chequeadorConstructor($arrayDatos, 'color','');
		$this->motor 	= $this->chequeadorConstructor($arrayDatos, 'motor','');

	}

	public function ingresarVehic(){
		
		
		try{

			$varSQL = 'SELECT * FROM vehiculos WHERE matricula = :matricula;';		
			$arrayVehic = array('matricula' => $this->matricula );
			$respuesta = $this->traerListado($varSQL, $arrayVehic);

			if(!empty($respuesta)){
				/*
					En caso que tenga registro entro aca y devuelvo que ya ese autor esta ingresado
				*/
				return "Ya esta ingresado el vehiculo";
			}

			$fecha = date("Y-m-d h:i:s");
			$sql = "INSERT INTO vehiculos SET 
						matricula = :matricula,
						marca =:marca,
						modelo = :modelo,
						color = :color, 
						motor = :motor,					
						estadoRegistro = :estadoRegistro,
						fechaEdicion = :fechaEdicion;
						
				";

$arrayVehic = array(
				"matricula"	            =>	$this->matricula,
				"marca" 		        =>  $this->marca,
				"modelo" 		        =>  $this->modelo,
				"color" 		        =>  $this->color,
				"motor" 		        =>  $this->motor,
				"estadoRegistro"	    =>	$this->estadoRegistro,
				"fechaEdicion"          =>  $fecha,
			);	

			$respuesta = $this->ejecutarSentencia($sql, $arrayVehic);

			if($respuesta == 1){
				$retorno = "El vehiculo se ingreso correctamente";
			}else{
				$retorno = "Error al ingresar Vehiculo";
			}

			return $retorno;

		}catch(PDOException $e){

			$retorno = "Ocurrio Un error al ingresar el vehiculo";
			return $retorno;
		}

	}

	public function traerVehic($idRegistro){
		
		$varSQL = 'SELECT * FROM vehiculos WHERE marca_modelo_id = :marca_modelo_id ;';
		$arrayVehic = array('marca_modelo_id' => $idRegistro);

		$respuesta = $this->traerListado($varSQL,$arrayVehic);

		print_r($respuesta);
		
		die();
		$this->idRegistro     =	$respuesta[0]['marca_modelo_id'];	
		$this->matricula      =$respuesta[0]['matricula'];
		$this->marca	      =$respuesta[0]['marca'];
		$this->modelo	      =$respuesta[0]['modelo'];
		$this->color	      =$respuesta[0]['color'];
		$this->motor	      =$respuesta[0]['motor'];
		$this ->fechaEdicion  =$respuesta [0] ['fechaEdicion'];								
		$this->estadoRegistro =$respuesta[0]['estadoRegistro'];


		/*print_r($respuesta[0]);
		print_r($respuesta[0]);
		print_r($respuesta[0]);
		print_r($respuesta[0]);*/

		
		/*Array ( [marca_modelo_id] => 3 
		[0] => 3 
		[matricula] => SQ2 [1] => SQ2 
		 [marca] => VW [2] => VW 
		 [modelo] => UP [3] => UP 
		 [color] => rojo [4] => rojo
		  [motor] => 1000 [5] => 1000 
		  [estadoRegistro] => Borrado [6] => Borrado 
		   [fechaEdicion] => 2022-03-11 01:43:42 [7]
		    => 2022-03-11 01:43:42 )*/
		
		/*$this->idRegistro     = $respuesta[0]['marca_modelo_id'];
		$this->matricula      = $respuesta[0]['matricula'];
		$this->marca	      = $respuesta[0]['marca'];
		$this->modelo		  = $respuesta[0]['modelo'];
		$this->color		  = $respuesta[0]['color'];
		$this->motor		  = $respuesta[0]['motor'];
		$this->estadoRegistro = $respuesta[0]['estadoRegistro'];*/

	
			
		
	
		
       
		
		
	}


	public function guardarVehic(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE vehiculos SET
					matricula = :matricula,
					marca = :marca,
					modelo = :modelo,
					color = :color,
					motor = :motor,
					estadoRegistro = :estadoRegistro,
					fechaEdicion = :fechaEdicion
					
				WHERE marca_modelo_id = :marca_modelo_id;
			";

		$arrayVehic = array(
			"matricula"	      =>  $this->matricula,
			"marca" 		  =>  $this->marca,
			"modelo" 		  =>  $this->modelo,
			"color" 		  =>  $this->color,
			"motor" 		  =>  $this->motor,
			"estadoRegistro"  =>  $this->estadoRegistro,
			"fechaEdicion"    =>  $fecha,
			"marca_modelo_id" =>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayVehic);
		if($respuesta == 1){
			$retorno = "Se guardo el vehiculo correctamente";
		}else{
			$retorno = "Error al guardar el vehiculo";
		}
		return $retorno;

	}


	/*public function listarVehic($filtos = array()){
		
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
		 'SELECT * FROM vehiculos LIMIT 0,10'; 
		
		 $puntoSalida = $pagina * $limite;

		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE marca LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = "SELECT * FROM vehiculos ".$buscador."ORDER BY marca LIMIT ".$puntoSalida.",".$limite."";


		$retorno = $this->traerListado($varSQL, array());
		return $retorno;		
		
	}

	public function totalVehic($filtos = array()){
		
		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE marca LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = 'SELECT count(1) AS totalRegistros FROM vehiculos '.$buscador.'';

		$respuesta = $this->traerListado($varSQL, array());
		$retorno = $respuesta[0]['totalRegistros'];

		return $retorno;

	}




	public function listarVehicMarca(){
		
		$varSQL = 'SELECT * FROM  vehiculos WHERE marca = "";';
		$retorno = $this->traerListado($varSQL, array());
		return $retorno;

	}*/


}





?>