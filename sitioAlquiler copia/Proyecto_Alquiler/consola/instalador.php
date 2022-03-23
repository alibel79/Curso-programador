<?php

require_once("modelos/generico.php");

$objGenerico = new generico ();

echo ("inicia instalacion");

$arraySQL=array();


$arraySQL[]=" CREATE TABLE `marcas` (
    `idMarca` int(3) NOT NULL AUTO_INCREMENT,
    `marca` varchar(50) DEFAULT NULL,
    `estadoRegistro` enum('Ingresado','Borrado') DEFAULT NULL,
    `fechaEdicion` datetime DEFAULT NULL,
    PRIMARY KEY (`idMarca`)
  )";

$arraySQL[]="CREATE TABLE `carroceria` (
    `idTipo` int(3) NOT NULL AUTO_INCREMENT,
    `tipoCarroceria` varchar(50) NOT NULL,
    `precio` int(4) DEFAULT NULL,
    `estadoRegistro` enum('Ingresado','Borrado') DEFAULT NULL,
    `fechaEdicion` datetime DEFAULT NULL,
    PRIMARY KEY (`idTipo`)
  )";

$arraySQL[]="CREATE TABLE `usuarios` (
    `idUsuario` int(3) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) NOT NULL,
    `email` tinytext NOT NULL,
    `clave` tinytext NOT NULL,
    `perfil` enum('Administrador','Supervisor','Vendedor') DEFAULT NULL,
    `estadoRegistro` enum('Ingresado','Borrado') DEFAULT NULL,
    `fechaEdicion` datetime DEFAULT NULL,
    PRIMARY KEY (`idUsuario`)
  )";

$arraySQL[]=" CREATE TABLE `autos` (
    `idVehic` int(3) NOT NULL AUTO_INCREMENT,
    `modelo` varchar(50) NOT NULL,
    `color` varchar(50) NOT NULL,
    `foto` varchar(900) NOT NULL,
    `matricula` varchar(10) NOT NULL,
    `motor` varchar(5) NOT NULL,
    `km` varchar(6) NOT NULL,
    `idMarca` int(3) NOT NULL,
    `idTipo` int(3) NOT NULL,
    `estadoRegistro` enum('Ingresado','Borrado') DEFAULT NULL,
    `fechaEdicion` datetime DEFAULT NULL,
    PRIMARY KEY (`idVehic`),
    KEY `idMarca` (`idMarca`),
    KEY `vehiculos_FK` (`idTipo`),
    CONSTRAINT `fk_marca_mc` FOREIGN KEY (`idMarca`) REFERENCES `marcas` (`idMarca`),
    CONSTRAINT `vehiculos_FK` FOREIGN KEY (`idTipo`) REFERENCES `carroceria` (`idTipo`)
  )";

$arraySQL[]="CREATE TABLE `clientes` (
    `idCliente` int(3) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) NOT NULL,
    `apellido` varchar(50) NOT NULL,
    `email` tinytext NOT NULL,
    `telefono` int(10) DEFAULT NULL,
    `direccion` varchar(50) DEFAULT NULL,
    `tipo_documento` varchar(20) NOT NULL,
    `numero_documento` varchar(50) NOT NULL,
    `clave` tinytext NOT NULL,
    `estadoRegistro` enum('Ingresado','Borrado') DEFAULT NULL,
    `fechaEdicion` datetime DEFAULT NULL,
    PRIMARY KEY (`idCliente`)
  )";

  foreach($arraySQL as $tabla){

  $objGenerico->ejecutarSentencia ($tabla);

  }

  echo ("fin instalacion");





?>