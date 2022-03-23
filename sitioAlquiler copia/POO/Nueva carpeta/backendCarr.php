<?PHP

require_once("modelos/carroceria.php");

$objCarroc = new carroceria();

$respuesta = "";

if(isset($_POST['accion']) && $_POST['accion'] == "Ingresar"){

	$carroceria  = $_POST['txt_carroc'];
	$precio    	 = $_POST['txt_precio'];

	$datos = [
		'idRegistro'	 =>'', 
		'estadoRegistro' =>'', 
		'carroceria'     => $carroceria, 
        'precio'		 => $precio,

    ];
       

	$objCarroc->constructor($datos);
	$respuesta = $objCarroc->ingresarCarroc();

}


if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){
		$idRegistro = $_POST['idRegistro'];		
		$objCarroc->traerCarroceria($idRegistro);
	}
}

if(isset($_POST['accion']) && $_POST['accion'] == "ConfirmarEliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];
		
		$objCarroc->traerCarroceria($idRegistro);
		$objCarroc->modificarEstadoBorrado();
		$respuesta = $objCarroc->guardarCarroceria();

	}
	
}



if(isset($_POST['accion']) && $_POST['accion'] == "Editar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];		
		$objCarroc->traerCarroceria($idRegistro);

	}
}
 

if(isset($_POST['accion']) && $_POST['accion'] == "Guardar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro     = $_POST['idRegistro'];		
		$carroceria     = $_POST['txt_carroc'];
		$precio 	    = $_POST['txt_precio'];
      
   

		$objCarroc ->traerCarroceria ($idRegistro);
		$objCarroc ->carroceria      = $carroceria;
        $objCarroc ->precio          = $precio;
      
	

		if(isset($_POST['Eliminar']) && $_POST['Eliminar'] == "ok" ){
			$objCarroc->modificarEstadoBorrado();
		}
		$respuesta = $objCarroc->guardarCarroceria();

	}
}

$arrayFiltros = [];
$BUSCAR = "";

if(isset($_GET['accion']) && $_GET['accion'] == "Buscar"){

	if(isset($_GET['txtBuscar']) && $_GET['txtBuscar'] != ""){

		$arrayFiltros['buscar'] = $_GET['txtBuscar'];
		$BUSCAR 			         	= $_GET['txtBuscar'];
	}

}
$totalTipo = $objCarroc->totalTipos($arrayFiltros);

if(isset($_GET['pag'])){

	$PAGINA = $_GET['pag'];

	if($PAGINA == "" || $PAGINA <= 0){
		$PAGINA = 0;
		$PAGINAANTERIOR = $PAGINA;	
	}else{
		$PAGINAANTERIOR = $PAGINA - 1;	
	}

	$limitPagina = $totalTipo / 5;
	if($limitPagina <= ($PAGINA+1) ){
		$PAGINASIGUENTE = $PAGINA;
	}else{
		$PAGINASIGUENTE = $PAGINA + 1;		
	}
	$arrayFiltros['pagina'] = $PAGINA;

}else{

	$PAGINA = 0;
	$PAGINASIGUENTE = $PAGINA + 1;
	$PAGINAANTERIOR = $PAGINA;
	$limitPagina = $totalTipo / 5;

}

$listarTipos = $objCarroc->listarCarroceria($arrayFiltros);
sort($listarTipos);

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
  <title>Rent & Move</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="backend/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="backend/css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="backend/css/libreria.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link rel="shortcut icon" href="backend/img/Logoauto (1).ico " type="image/x-icon">
</head>

<body>
  <div class="navbar-fixed">

    <nav class="#a1887f brown lighten-2" role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">
        <img src= "backend/img/Logoauto.png"  width="60px" heigth="60px"> RENT & MOVE </a>
        <ul class="right hide-on-med-and-down">
          <li><a href="#">Usuarios</a></li>
          <li> <a href="#">Clientes</a></li>
          <li><a href="#">Autos</a></li>
          <li> <a href="#">Alquileres</a></li>
          <li> <a href="#">Reservas</a></li>
        </ul>
   

  </div>
  
        <ul id="nav-mobile" class="sidenav">
          <li><a href="#">Usuarios</a></li>
          <li> <a href="#">Clientes</a></li>
          <li><a href="#">Autos</a></li>
          <li><a href="#">Tipo Vehiculo</a></li>
          <li> <a href="#">Alquileres</a></li>
          <li> <a href="#">Reservas</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>
    </nav>
  </div>
  <div class="section no-pad-bot" id="index-banner">
			<div class="container">
			<br><br>
			<h1 class="header center brown-text">Listado Tipos de Vehiculo</h1>			
				<br>
	<?PHP	
				if($respuesta != ""){
					
					echo('
						<nav>
							<div class="nav-wrapper center #827717 lime darken-4">'.
								$respuesta				
							.'</div>
						</nav>
					');
				}
?>
      </div>
  </div>



       <div class="container">
	   <?php
	if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != ""){
?>
			<div class="#fbe9e7 deep-orange lighten-5">
				<form class="col s12" action="backendCarr.php" method="POST">
					<div class="input-field col s12">
						<h3>Eliminar el Registro: <?=$objCarroc->carroceria." ". $objCarroc->precio?>?</h3>
					</div>					
					<input type="hidden" id="idAccion" name="accion" value="ConfirmarEliminar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objCarroc->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves- #bf360c deep-orange darken-4" type="submit">Eliminar
					<button class="btn waves-effect waves- #3e2723 brown darken-4" type=""> <a href="backend.php">Cancelar</a>
					</button>	
					
				</form>
				
			</div>	
<?php
	}
?>
       <?php

?>
<?php
	if(isset($_POST['accion']) && $_POST['accion'] == "Editar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != ""){
?>
			<div class="row">
				<form class="col s12" action="backendCarr.php" method="POST">
					<div class="input-field col s12">
						<h6>Ingresar Tipo Vehiculo<h6>
					</div>
          <div class="input-field col s12">
						<input placeholder="Tipo Carroceria" name="txt_carroc" id="first_name" type="text" class="validate" value="<?=$objCarroc->carroceria?>">
						<label for="Tipo">Tipo Carroceria</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="precio" name="txt_precio" id="first_name" type="text" class="validate" value="<?=$objCarroc->precio?>">
						<label for="Marca">Precio</label>
					</div>


					<input type="hidden" id="idAccion" name="accion" value="Guardar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objCarroc->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves-#9e9d24 lime darken-3" type="submit">Guardar
					<button class="btn waves-effect waves- #3e2723 brown darken-4" type=""> <a href="backend.php">Cancelar</a>
					</button>
				</form>
			</div>	
<?php
	}
?>

     

         <table class="striped">
            <thead>
            <tr class=" #a1887f brown lighten-2">
						<th colspan="8">
							<div class="row">
								<div class="col 8 s left">
									<a class="waves-effect waves-light btn modal-trigger #795548 brown" href="#modal1">Ingresar</a>
								</div>
								<div class="col 1 s right">									
									<form class="col 1 s right" action="backend.php" method="GET">	
										<input type="hidden" id="idAccion" name="accion" value="Buscar">
										<button class="btn waves-effect waves- #795548 brown" type="submit">Buscar
											<i class="material-icons right">search</i>
										</button>							
										<div class="col 1 s right">
											<input placeholder="Buscar" name="txtBuscar" id="idBuscar" type="text" value="">
										</div>
									
									</form>
								</div>
							</div>
						</th>
					</tr>
            
              <tr class="white text">
                <th>ID Registro</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Estado</th>
				<th>Editar</th>
				
              </tr>
			  <tr class="white text">
			  <th>--------</th>
                <th>--------</th>
                <th>--------</th>
                <th>--------</th>
                <th>--------</th>
                
				</tr>
            </thead>
            <tbody>
            <?php
				foreach($listarTipos as $carroc){
?>
            <tr>
						<td><?=$carroc['idTipo']?></td>	
						<td><?=$carroc['tipoCarroceria']?></td>
						<td><?=$carroc['precio']?></td>
		                <td><?=$carroc['estadoRegistro']?></td>
						<td>
							<form action="backendCarr.php" method="POST">
								<input type="hidden" name="accion" value="Eliminar">
								
								<input type="hidden" name="idRegistro" value="<?=$carroc['idTipo']?>">
								<button class="btn-floating waves-effect waves- #bf360c deep-orange darken-4" type="submit" name="action">
									<i class="material-icons right">delete_forever</i>
								</button>
							</form>
							<form action="backendCarr.php" method="POST">
								<input type="hidden" name="accion" value="Editar">
								<input type="hidden" name="idRegistro" value="<?=$carroc['idTipo']?>">
								<button class="btn-floating waves-effect waves- brown darken-2" type="submit" name="action">
									<i class="material-icons right">edit</i>
								</button>
							</form>
						</td>
            <?php
				}
?>
						
					</tr>
          <tr>
						<td colspan="8">
							<span class="left"><p>Total Registros: <?=$totalTipo?></p> <button class="btn waves-effect waves- #3e2723 brown darken-4" type=""> <a href="backend.php">Listado Completo</a>
					</button></span>
							<ul class="pagination right">
								<li class="waves-effect">
									<a href="backendCarr.php?pag=<?=$PAGINAANTERIOR?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>"><i class="material-icons">chevron_left</i></a>
								</li>
<?php
								for($i = 1; $i < $limitPagina ; $i++){

									$colorear = "waves-effect ";
									if($i == $PAGINA){
										$colorear = "active  waves- brown darken-2";
									}
?>
										<li class="<?=$colorear?>">
											<a href="backendCarr.php?pag=<?=$i?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>"><?=$i?></a>
										</li>
<?php 								
								}
?>

								<li class="waves-effect">
									<a href="backendCarr.php?pag=<?=$PAGINASIGUENTE?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>">
										<i class="material-icons">chevron_right</i>
									</a>
								</li>
							</ul>
						</td>
					</tr>

            </tbody>
          </table>
         <br>
        </div>

        <div id="modal1" class="modal">
			<div class="modal-content">				
				<div class="row">
					<form class="col s12" action="backendCarr.php" method="POST">
						<div class="input-field col s12">
							<h6h6>Ingresar Tipo Carroceria<h6>
						</div>
						<div class="input-field col s12">
							<input placeholder="tipo" name="txt_carroc" id="first_name" type="text" class="validate">
							<label for="first_name">Tipo</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Precio" name="txt_precio" id="first_name" type="text" class="validate">
							<label for="first_name">Precio</label>
						</div>
        
            
						<input type="hidden" id="idAccion" name="accion" value="Ingresar" >
						<button class="btn waves-effect waves-light brown darken-1" type="submit">Enviar
							<i class="material-icons right">send</i>
						</button>	
					</form>
				</div>
			</div>
			<div class="modal-footer #a1887f brown lighten-2">
				<a href="#!" class="modal-close waves-effect waves-brown-2 btn-flat  white-text">Cancelar</a>
			</div>
		</div>

	

      <footer class="page-footer #6d4c41 brown darken-1">
        <div class="container">
         
              <h5 class="white-text">RENT & MOVE</h5>
          
        <div class="footer-copyright">
          <div class="container">
            Made by <a class="#6d4c41 brown darken-1" href="http://materializecss.com">Materialize</a>
          </div>
        </div>
      </footer>


      <!--  Scripts-->
      <script src="backend/js/jquery-2.1.1.min.js"></script>
      <script src="backend/js/materialize.js"></script>
      <script src="abckend/js/init.js"></script>
      <script>
			document.addEventListener('DOMContentLoaded', function() {		

 				M.AutoInit();
				var elems = document.querySelectorAll('.modal');
				var instances = M.Modal.init(elems, options);

				M.toast({html: 'I am a toast!', classes: 'rounded'});

			});
		</script>

</body>

</html>