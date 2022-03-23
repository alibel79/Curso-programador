<?php

require_once ("generico.php");

class autos extends generico{

    public $modelo;	
	public $color;
	public $foto;
	public $matricula;
	public $motor;
	public $km;
	public $idMarca;
	public $idTipo;


    
	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);
		$this->modelo       = $this->chequeadorConstructor($arrayDatos,'modelo','');
		$this->color 	    = $this->chequeadorConstructor($arrayDatos,'color',''); 
		$this->foto 	    = $this->chequeadorConstructor($arrayDatos,'foto',''); 
		$this->matricula	= $this->chequeadorConstructor($arrayDatos,'matricula','');
		$this->motor 	    = $this->chequeadorConstructor($arrayDatos,'motor','');
		$this->km  	        = $this->chequeadorConstructor($arrayDatos,'km','');
		$this->idMarca 	    = $this->chequeadorConstructor($arrayDatos,'idMarca','');
		$this->idTipo 	    = $this->chequeadorConstructor($arrayDatos,'idTipo','');

		
    }

    public function ingresaAuto(){

        try{
            $varSQL='SELECT * FROM autos WHERE modelo=:modelo AND matricula=:matricula';
            $arrayAutos= array ('modelo'=>$this->modelo, 'matricula'=> $this->matricula);
            $respuesta=$this->traerListado($varSQL,$arrayAutos);

            if(!empty($respuesta)){

            return "ya esta ingresado el vehiculo";
            }

      
        $sql="INSERT INTO autos SET

                        modelo         = :modelo,
						color          = :color, 
						foto           = :foto, 
						matricula      = :matricula,						
						motor          = :motor,		
						km             = :km,
						idMarca		   = :idMarca,
						idTipo		   = :idTipo,
						estadoRegistro = :estadoRegistro,
						fechaEdicion   = :fechaEdicion;
        
         ";

        $fecha = date("Y-m-d h:i:s");

        $arrayAutos = array(
				
                      "modelo" 		        =>  $this->modelo,
                      "color" 		        =>  $this->color,
                      "foto" 		        =>  $this->foto,
                      "matricula"	        =>	$this->matricula,				
                      "motor" 		        =>  $this->motor,
                      "km" 		            =>  $this->km,
                      "idMarca"		        =>  $this->idMarca,
                      "idTipo"		        =>  $this->idTipo,
                      "estadoRegistro"	    =>	$this->estadoRegistro,
                      "fechaEdicion"        =>  $fecha,
                    );	


         $respuesta = $this->ejecutarSentencia($sql, $arrayAutos);

          if($respuesta == 1){
                       $retorno = "El vehiculo se ingreso correctamente";
           }else{
                   $retorno = "Error al ingresar Vehiculo";
                   
           }

              return $retorno;
               
            }catch(PDOException $e){

                $retorno = "Ocurrio Un error al ingresar el vehiculo".$e->getMessage();
                return $retorno;
    
            }

        

    }
    
    

    public function traerAuto($idRegistro){

        $varSQL='SELECT * FROM autos WHERE idVehic=:idVehic;';

        $arrayAutos = array('idVehic' => $idRegistro);

        $respuesta = $this->traerListado($varSQL,$arrayAutos);

		$this->idRegistro      = $respuesta[0]['idVehic'];
		$this->modelo		   = $respuesta[0]['modelo'];
		$this->color		   = $respuesta[0]['color'];
		$this->foto	           = $respuesta[0]['foto'];
		$this->matricula       = $respuesta[0]['matricula'];		
		$this->motor		   = $respuesta[0]['motor'];
		$this->km	           = $respuesta[0]['km'];
		$this->idMarca		   = $respuesta[0]['idMarca'];
		$this->idTipo		   = $respuesta[0]['idTipo'];
		$this->estadoRegistro  = $respuesta[0]['estadoRegistro'];

    }

    public function guardarAuto(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE autos SET

				modelo         = :modelo,
				color          = :color, 
				foto           = :foto, 
				matricula      = :matricula,						
				motor          = :motor,		
				km             = :km,
				idMarca		   = :idMarca,
		        idTipo		   = :idTipo,
				estadoRegistro = :estadoRegistro,
				fechaEdicion   = :fechaEdicion
					
				WHERE idVehic = :idVehic;
			";

		$arrayAutos = array(
		
			"modelo" 		   =>  $this->modelo,
			"color" 		   =>  $this->color,
			"foto" 		       =>  $this->foto,
			"matricula"	       =>  $this->matricula,			
			"motor" 		   =>  $this->motor,
			"km" 		       =>  $this->km,
			"idMarca"		   =>  $this->idMarca,
			"idTipo"	       =>  $this->idTipo,
			"estadoRegistro"   =>  $this->estadoRegistro,
			"fechaEdicion"     =>  $fecha,
			"idVehic"          =>  $this->idRegistro,

		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayAutos);
		if($respuesta == 1){
			$retorno = "Se guardo el vehiculo correctamente";
		}else{
			$retorno = "Error al guardar el vehiculo";
		}
		return $retorno;

	}


	public function listarVehic($filtos = array()){
		
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
		 'SELECT * FROM autos LIMIT 0,5'; 
		
		 $puntoSalida = $pagina * $limite;

		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE modelo LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = "SELECT * FROM autos ".$buscador."ORDER BY idVehic LIMIT ".$puntoSalida.",".$limite."";


		$retorno = $this->traerListado($varSQL, array());
		return $retorno;		
		
	}

	public function totalVehic($filtos = array()){
		
		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE modelo LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = 'SELECT count(1) AS totalRegistros FROM autos '.$buscador.'';

		$respuesta = $this->traerListado($varSQL, array());
		$retorno = $respuesta[0]['totalRegistros'];

		return $retorno;

	}




	public function listarVehicMarca(){
		
		$varSQL = 'SELECT * FROM  autos WHERE modelo = "";';
		$retorno = $this->traerListado($varSQL, array());
		
		return $retorno;

	}







}






?>