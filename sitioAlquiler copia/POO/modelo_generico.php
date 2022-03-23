<?php

class generico{

    public $idRegistro;

    protected $estadoRegistro;

    public function constructor($arrayDatos=array('idRegistro'=>0,'estadoRegistro'=>'')){

        $this->idRegistro = $arrayDatos['idRegistro'];
        
        if(strtolower($arrayDatos ['estadoRegistro']=='ingresado')){
          $this->modif_estad_Ingresado();
        }else{
          $this->modif_estad_Borrado();
        }
  
    }
    public function obtenerEstado(){

        return $this->estadoRegistro;

    }
    public function modif_estad_Borrado(){

        $this->estadoRegistro="Borrado";
        
    }
    public function modif_estad_Ingresado(){

        $this->estadoRegistro="Ingresado";
 
    }

}

/*$objGenerico1=new generico;
$objGenerico1->idRegistro="soy atributo";
echo ($objGenerico1->idRegistro);
"<br>";

$objGenerico1->modif_estad_Borrado();

echo "<br>".($objGenerico1->obtenerEstado());
"<br>";

$objGenerico1->modif_estad_Ingresado();

echo "<br>".($objGenerico1->obtenerEstado());

echo"<hr>";

$arrayDatos=['idRegistro'=>'1','estadoRegistro'=>'ingresado'];

$objGenerico1->constructor($arrayDatos);

echo "<br>".($objGenerico1->idRegistro);

echo "<br>".($objGenerico1->obtenerEstado());
echo"<hr>";
$objGenerico1->constructor();

echo "<br>".($objGenerico1->idRegistro);

echo "<br>".($objGenerico1->obtenerEstado());*/

?>