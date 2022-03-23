<?php

require_once("usuarioGenerico.php");

$objUsuario = new usuario();

$arrayUsusario=['idRegistro'=>'1', 'nombre'=>'Alibel', 'mail'=>'elmail','clave'=>'clave', 'estadoR'=>'ingresado'];
$objUsuario->constructor($arrayUsusario);
$retorno=$objUsuario->obtenerAtributos();

print_r($retorno);

foreach($retorno as $datos){
    echo "Datos ingresados: $datos<br>";
}
?>