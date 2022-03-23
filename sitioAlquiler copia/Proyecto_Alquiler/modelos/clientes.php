<?php

require_once("generico.php");

class cliente extends generico{

public $nombre;
public $apellido;
public $email;
public $telefono;
public $direccion;
public $tipoDoc;
public $documento;
public $clave;


public function constructor ($arrayDatos = array('idRegistro'=>0,'estadoRegistro'=>'')){


    parent::constructor($arrayDatos);

    $this->nombre       = $this->chequeadorConstructor($arrayDatos,'nombre');
    $this->apellido     = $this->chequeadorConstructor($arrayDatos,'apellido');
    $this->email        = $this->chequeadorConstructor($arrayDatos,'email');
    $this->telefono     = $this->chequeadorConstructor($arrayDatos,'telefono');
    $this->direccion    = $this->chequeadorConstructor($arrayDatos,'direccion');
    $this->tipoDoc      = $this->chequeadorConstructor($arrayDatos,'tipoDoc');
    $this->documento    = $this->chequeadorConstructor($arrayDatos,'documento');
    $this->clave        = $this->chequeadorConstructor($arrayDatos,'clave');
}

public function ingresarCliente(){

    try{

        $varSQL = 'SELECT * FROM cliente_bk WHERE email=:email AND documento =:documento';		
        $arrayCliente = array('email' => $this->email, 'documento' => $this->documento);
        $respuesta = $this->traerListado($varSQL, $arrayCliente);
        
        if(!empty($respuesta)){
        
            return "Ya esta ingresado el Cliente";
        }

        $fecha = date("Y-m-d h:i:s");
        $sql = "INSERT INTO cliente_bk SET 

                    nombre         = :nombre,
                    apellido       = :apellido,
                    email          = :email,
                    telefono       = :telefono,
                    direccion      = :direccion,
                    tipoDoc        = :tipoDoc,
                    documento      = :documento,
                    clave          = :clave,                  							
                    estadoRegistro = :estadoRegistro,
                    fechaEdicion   = :fechaEdicion;
                    
            ";

        $clave= md5( $this->clave);

        $arrayCliente = array(
            "nombre"	            =>	$this->nombre,
            "apellido" 		        =>  $this->apellido,	
            "email" 		        =>  $this->email,
            "telefono"	            =>	$this->telefono,
            "direccion" 		    =>  $this->direccion,	
            "tipoDoc" 		        =>  $this->tipoDoc,
            "documento" 		    =>  $this->documento,   
            "clave"	                =>	$clave,        	
            "estadoRegistro"	    =>	$this->estadoRegistro,
            "fechaEdicion"          =>  $fecha,
        );	

     

        $respuesta = $this->ejecutarSentencia($sql,$arrayCliente);

        if($respuesta == 1){
            $retorno = "Se ingreso correctamente";
        }else{
            $retorno = "Error al ingresar Cliente";
        }

        return $retorno;

       }catch(PDOException $e){

        return $retorno;

        $retorno = "error".$e->getMessage();
    
       }
    }
    
    public function traerCliente($idRegistro){

		$varSQL = 'SELECT * FROM cliente_bk where idCli = :idCli;';
		
		$arrayCliente = array('idCli' => $idRegistro);

	
		$respuesta = $this->traerListado($varSQL,$arrayCliente);

		$this->idRegistro        = $respuesta[0]['idCli'];
		$this->nombre            = $respuesta[0]['nombre'];
        $this->apellido          = $respuesta[0]['apellido'];
		$this->email	         = $respuesta[0]['email'];
        $this->telefono          = $respuesta[0]['telefono'];
		$this->direccion         = $respuesta[0]['direccion'];
        $this->tipoDoc           = $respuesta[0]['tipoDoc'];
		$this->documento         = $respuesta[0]['documento'];
        $this->clave	         = $respuesta[0]['clave'];      
		$this->estadoRegistro    = $respuesta[0]['estadoRegistro'];

    	
	}

    public function guardarCliente(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE cliente_bk SET
					nombre         = :nombre,
                    apellido       = :apellido,
					email          = :email,
                    telefono       = :telefono,
                    direccion      = :direccion,
					tipoDoc        = :tipoDoc,
                    documento      =:documento,		
                    clave          = :clave,					
					estadoRegistro = :estadoRegistro,
					fechaEdicion   = :fechaEdicion
					
				WHERE idCli = :idCli;
			";

        $arrayCliente = array(
			"nombre"	              =>  $this->nombre,
            "apellido"	              =>  $this->apellido,
			"email" 		          =>  $this->email,
            "telefono"	              =>  $this->telefono,
            "direccion"	              =>  $this->direccion,
			"tipoDoc" 		          =>  $this->tipoDoc,
            "documento" 		      =>  $this->documento,	
            "clave"	                  =>  $this->clave,
			"estadoRegistro"          =>  $this->estadoRegistro,
			"fechaEdicion"            =>  $fecha,
			"idCli"                   =>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayCliente);
		if($respuesta == 1){
			$retorno = "Se guardo  correctamente";
		}else{
			$retorno = "Error al guardar Cliente";
		}
		return $retorno;

	}

    public function listarClientes($filtos = array()){
		
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
		 'SELECT * FROM cliente_bk LIMIT 0,5'; 
		
		 $puntoSalida = $pagina * $limite;

		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE documento LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = "SELECT * FROM cliente_bk ".$buscador."ORDER BY idCli LIMIT ".$puntoSalida.",".$limite."";


		$retorno = $this->traerListado($varSQL, array());
		return $retorno;		
		
	}

	public function totalClientes($filtos = array()){
		
		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE documento LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = 'SELECT count(1) AS totalRegistros FROM cliente_bk '.$buscador.'';

		$respuesta = $this->traerListado($varSQL, array());
		$retorno = $respuesta[0]['totalRegistros'];

		return $retorno;

	}

    public function login($email, $clave){
		
	
        $claveMD5 = md5($clave);	
    
        $varSQL 	= 'SELECT * FROM cliente_bk WHERE email = :email AND clave = :clave ;';
        $arrayCliente 	= array('email' => $email, 'clave' => $claveMD5);
    
        
        $respuesta = $this->traerListado($varSQL, $arrayCliente);
    
        if(empty($respuesta)){
            /*
                En caso que tenga registro entro aca y devuelvo que ya ese autor esta ingresado
            */
            return "Error al entrar";
        }
    
        return $respuesta;
    
    }
    

}

?>

