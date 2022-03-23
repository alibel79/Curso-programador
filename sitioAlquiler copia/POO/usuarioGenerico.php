<?php

require_once ("generico.php");

class usuario extends generico{

public $nombre;

public $mail;

public $clave;


public function constructor($atributos){

    parent::constructor ($atributos);

$this->nombre = $atributos['nombre'];
$this->mail = $atributos['mail'];
$this->clave = $atributos['clave'];

}
    


public function obtenerAtributos (){

    $retorno=array();

   $retorno ['idRegistro']  =  $this->idRegistro;
   $retorno ['nombre']      = $this->nombre;
   $retorno ['mail']        =  $this->mail;
   $retorno ['clave']       =  $this->clave;
   $retorno ['estadoR']     =  $this->estadoR;

   return $retorno;

}

} 


?>