<?php
require_once ("vehiculos.php");

$objVehic= new vehiculos();



$respueta=$objVehic->traerVehic($idRegistro);

print_r($respueta);




die();


$objVehic= new vehiculos();

$objVehic->traerVehic(4);//hasta aca fuciona
$objVehic->traerVehic(3);
$objVehic->traerVehic(2);
$objVehic->traerVehic(1);


die();

$objVehic= new vehiculos();

$datos=[

    "idRegistro"=>'',"estadoRegistro"=>'',"matricula"=>'SQ12',"marca"=>'Renault',"modelo"=>'Kwid',"color"=>'naranja',"motor"=>'1000'];

$objVehic->constructor($datos);

$respuesta=$objVehic->ingresarVehic();

print_r($respuesta);

print_r($datos);





?>