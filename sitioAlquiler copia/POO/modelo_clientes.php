<?php

require_once("modelo_generico.php");

class clientes extends generico {

public $nombre;
public $apellido;

public function constructor ($arrayDatos=array ('idRegistro'=>0,'estadoRegistro'=>'','nombre'=>'','apellido'=>'')){


    parent:: constructor($arrayDatos);
/*$this->idRegistro = $arrayDatos['idRegistro'];

if($arrayDatos ['estadoRegistro']=='ingresado'){
    $this->modif_estad_Ingresado();
  }else{
    $this->modif_estad_Borrado();
  }*///Equivale al parent::constructor y al llamar al parent no cambia.

  $this->nombre  = $this-> check_constructor($arrayDatos,'nombre','');
  $this->apellido =  $this ->check_constructor($arrayDatos,'apellido','NN');

}
public function check_constructor($arrayDatos,$nombreCampo,$valorDefecto=""){

    $retorno="";

    if(isset($arrayDatos[$nombreCampo])){

        $retorno=$arrayDatos[$nombreCampo];

    }else{
        $retorno=$valorDefecto;
    }
    return $retorno;
}

}

$cliente1= new clientes();

$arrayDatos=['idRegistro'=>'123','estadoRegistro'=>'ingresado','nombre'=>'Juan','apellido'=>''];

/*echo "<br>".($objGenerico1->obtenerEstado());
echo"<hr>";*/

$cliente1->constructor($arrayDatos).'</br>';
echo ($cliente1->idRegistro).'</br>';
echo ($cliente1->obtenerEstado()).'</br>';
echo ($cliente1->nombre).'</br>';
echo ($cliente1->apellido).'</br>';

$cliente1->constructor($arrayDatos);
echo"<hr>";
echo($cliente1->idRegistro);
echo"<hr>";
echo($cliente1->obtenerEstado());
echo"<hr>";
echo($cliente1->nombre);
echo"<hr>";
echo($cliente1->apellido);





















?>