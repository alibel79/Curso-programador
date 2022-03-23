<?php 

require_once("modelos/marca.php");

/*$objMarca = new marca();
$arrayFiltros=[];
$listarMarca = $objMarca->listarMarca($arrayFiltros);

print_r($listarMarca);*/



echo ("Hola cron: ");

if(isset ($_SERVER['argv'][1])){

    print_r($_SERVER['argv'][1]);
};
echo ("\n");

if(isset ($_SERVER['argv'][2])){

    print_r($_SERVER['argv'][2]);
};

include("consola/instalador.php");


?>