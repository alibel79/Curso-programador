<?php

require_once ("generico.php");

class usuarios extends generico{


	public $nombre;	
	public $email;
    public $clave;
    public $perfil;
	

	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);

		$this->nombre         = $this->chequeadorConstructor($arrayDatos, 'nombre','');
		$this->email 	      = $this->chequeadorConstructor($arrayDatos, 'email',''); 
        $this->clave          = $this->chequeadorConstructor($arrayDatos, 'clave','');
		$this->perfil	      = $this->chequeadorConstructor($arrayDatos, 'perfil','');
	  
	}

	public function ingresarUsuario(){
		
		
		try{

			$varSQL = 'SELECT * FROM usuarios WHERE email=:email AND clave=:clave';		
			$arrayUsuarios = array('email' => $this-> email, 'clave'=>$this->clave);
			$respuesta = $this->traerListado($varSQL, $arrayUsuarios);

			

			if(!empty($respuesta)){
			
				return "Ya esta ingresado el Usuario";
			}

			$fecha = date("Y-m-d h:i:s");
			$sql = "INSERT INTO usuarios SET 
						nombre         = :nombre,
						email          = :email,
                        clave          = :clave,
                        perfil         = :perfil,								
						estadoRegistro = :estadoRegistro,
						fechaEdicion   = :fechaEdicion;
						
				";

             $clave= md5( $this->clave);

             $arrayUsuarios = array(
				"nombre"	            =>	$this->nombre,
				"email" 		        =>  $this->email,	
                "clave"	                =>	$clave,
				"perfil" 		        =>  $this->perfil,		
				"estadoRegistro"	    =>	$this->estadoRegistro,
				"fechaEdicion"          =>  $fecha,
			);	

			$respuesta = $this->ejecutarSentencia($sql, $arrayUsuarios);

			

			
			if($respuesta == 1){
				$retorno = "El Usuario se ingreso correctamente";

			}else{
				$retorno = "Error al ingresar usuario";
			}

			return $retorno;

		   }catch(PDOException $e){

			$retorno = "error".$e->getMessage();

			return $retorno;
           }

	}
		
		
	

	public function traerUsuario($idRegistro){

		$varSQL = 'SELECT * FROM usuarios where idUsuario = :idUsuario;';
		
		$arrayUsuarios = array('idUsuario' => $idRegistro);

	
		$respuesta = $this->traerListado($varSQL,$arrayUsuarios);

		$this->idRegistro        = $respuesta[0]['idUsuario'];
		$this->nombre            = $respuesta[0]['nombre'];
		$this->email	         = $respuesta[0]['email'];
        $this->clave	         = $respuesta[0]['clave'];
        $this->perfil	         = $respuesta[0]['perfil'];
		$this->estadoRegistro    = $respuesta[0]['estadoRegistro'];

	    
	}
	
    

	public function guardarUsuario(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE usuarios SET
					nombre         = :nombre,
					email          = :email,		
                    clave          = :clave,
					perfil         = :perfil,			
					estadoRegistro = :estadoRegistro,
					fechaEdicion   = :fechaEdicion
					
				WHERE idUsuario = :idUsuario;
			";
        $clave= md5($this->clave);

		$arrayUsuarios = array(
			"nombre"	              =>  $this->nombre,
			"email" 		          =>  $this->email,	
            "clave"	                  =>  $clave,
			"perfil" 		          =>  $this->perfil,		
			"estadoRegistro"          =>  $this->estadoRegistro,
			"fechaEdicion"            =>  $fecha,
			"idUsuario"               =>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayUsuarios);
		if($respuesta == 1){
			$retorno = "Se guardo el usuario correctamente";
		}else{
			$retorno = "Error al guardar usuario";
		}
		return $retorno;

	}


	public function listarUsuarios($filtos = array()){
		
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
		 'SELECT * FROM usuarios LIMIT 0,5'; 
		
		 $puntoSalida = $pagina * $limite;

		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE nombre LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = "SELECT * FROM usuarios ".$buscador."ORDER BY nombre LIMIT ".$puntoSalida.",".$limite."";


		$retorno = $this->traerListado($varSQL, array());
		return $retorno;		
		
	}

	public function totalUsuario($filtos = array()){
		
		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE nombre LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = 'SELECT count(1) AS totalRegistros FROM usuarios '.$buscador.'';

		$respuesta = $this->traerListado($varSQL, array());
		$retorno = $respuesta[0]['totalRegistros'];

		return $retorno;

	}





    public function Perfiles(){

    $retorno=["Administrador"=>"Administrador", "Supervisor"=>"Supervisor", "Vendedor"=>"Vendedor"];

    return $retorno;

    }

    public function login($email, $clave){
		
	
	$claveMD5 = md5($clave);	

	$varSQL 	= 'SELECT * FROM usuarios WHERE email = :email AND clave = :clave ;';
	$arrayUsuario 	= array('email' => $email, 'clave' => $claveMD5);

	
	$respuesta = $this->traerListado($varSQL, $arrayUsuario);

	if(empty($respuesta)){
		/*
			En caso que tenga registro entro aca y devuelvo que ya ese autor esta ingresado
		*/
		return "Error al entrar";
	}

	return $respuesta;

   }//totalUsuarios



}





?>