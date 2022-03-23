<?PHP

require_once("modelos/vehiculos.php");

$objVehic = new vehiculos();

$respuesta = "";

if(isset($_POST['accion']) && $_POST['accion'] == "Ingresar"){

	$matricula  = $_POST['txt_matricula'];
	$marca    	= $_POST['txt_marca'];
    $modelo    	= $_POST['txt_modelo'];
    $color	    = $_POST['txt_color'];
    $motor 	    = $_POST['txt_motor'];
	
	$datos = [
		'idRegistro'	=>'', 
		'estadoRegistro'=>'', 
		'matricula'		=> $matricula, 
        'marca'		    => $marca,
        'modelo'		=> $modelo,  
        'color'		    => $color, 
        'motor'		    => $motor]; 
	

	$objVehic->constructor($datos);
	$respuesta = $objVehic->ingresarVehic();

}


if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){
		$idRegistro = $_POST['idRegistro'];		
		$objVehic->traerVehic($idRegistro);
	}
}

if(isset($_POST['accion']) && $_POST['accion'] == "ConfirmarEliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];
		
		$objVehic->traerVehic($idRegistro);
		$objVehic->modificarEstadoBorrado();
		$respuesta = $objVehic->guardarVehic();

	}else{

		$idRegistro = $_POST['idRegistro'];
		
		$objVehic->traerVehic($idRegistro);
		$objVehic->modificarEstadoIngresado();
		$respuesta = $objVehic->guardarVehic();
		
	}
	
}



if(isset($_POST['accion']) && $_POST['accion'] == "Editar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];		
		$objVehic->traerVehic($idRegistro);

	}
}
 

if(isset($_POST['accion']) && $_POST['accion'] == "Guardar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];		
		$matircula 	= $_POST['txt_matricula'];
		$marca 	    = $_POST['txt_marca'];
        $modelo 	= $_POST['txt_modelo'];
        $color  	= $_POST['txt_color'];
        $motor  	= $_POST['txt_motor'];
   

		$objVehic->traerVehic($idRegistro);
		$objVehic ->matricula = $matircula;
        $objVehic ->marca     = $marca;
        $objVehic ->modelo    = $modelo;
        $objVehic ->color     = $color;
        $objVehic ->motor     = $motor;
	

		if(isset($_POST['eliminar']) && $_POST['eliminar'] == "" ){
			$objVehic->modificarEstadoBorrado();
		}
		$respuesta = $objVehic->guardarVehic();

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
$totalVehic = $objVehic->totalVehic($arrayFiltros);

if(isset($_GET['pag'])){

	$PAGINA = $_GET['pag'];

	if($PAGINA == "" || $PAGINA <= 0){
		$PAGINA = 0;
		$PAGINAANTERIOR = $PAGINA;	
	}else{
		$PAGINAANTERIOR = $PAGINA - 1;	
	}

	$limitPagina = $totalVehic / 5;
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
	$limitPagina = $totalVehic / 5;

}

$listarVehic = $objVehic->listarVehic($arrayFiltros);


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
			<h1 class="header center brown-text">Listado Vehículos</h1>			
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
				<form class="col s12" action="backendVehic.php" method="POST">
					<div class="input-field col s12">
						<h3>Eliminar el Registro: <?=$objVehic->matricula." ". $objVehic->marca?>?</h3>
					</div>					
					<input type="hidden" id="idAccion" name="accion" value="ConfirmarEliminar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objVehic->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves- #bf360c deep-orange darken-4" type="submit">Eliminar
					<input type="hidden" id="idAccion" name="accion" value="Cancelar">
					<button class="btn waves-effect waves- #3e2723 brown darken-4" type="submit">Cancelar
						<i class="material-icons right">delete_forever</i>
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
				<form class="col s12" action="backendVehic.php" method="POST">
					<div class="input-field col s12">
						<h6h6>Ingresar Vehiculo<h6>
					</div>
          <div class="input-field col s12">
						<input placeholder="matricula" name="txt_matricula" id="first_name" type="text" class="validate" value="<?=$objVehic->matricula?>">
						<label for="Matricula">Matricula</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Marca" name="txt_marca" id="first_name" type="text" class="validate" value="<?=$objVehic->marca?>">
						<label for="Marca">Marca</label>
					</div>
          <div class="input-field col s12">
						<input placeholder="Modelo" name="txt_modelo" id="first_name" type="text" class="validate" value="<?=$objVehic->modelo?>">
						<label for="Modelo">Modelo</label>
					</div>
          <div class="input-field col s12">
						<input placeholder="Color" name="txt_color" id="first_name" type="text" class="validate" value="<?=$objVehic->color?>">
						<label for="Color">Color</label>
            </div>
            <div class="input-field col s12">
						<input placeholder="Motor" name="txt_motor" id="first_name" type="text" class="validate" value="<?=$objVehic->motor?>">
						<label for="Motor">Motor</label>
				
					</div>
				

					<div class="input-field col s12">
						<div class="switch">
							<label>
							Activado
							<input type="checkbox" name="eliminar" value="ok">
							<span class="lever"></span>
							Eliminar
							</label>
						</div>
					</div>

					<input type="hidden" id="idAccion" name="accion" value="Guardar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objVehic->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves-#9e9d24 lime darken-3" type="submit">Guardar
					<input type="hidden" id="idAccion" name="accion" value="Cancelar">
					<button class="btn waves-effect waves-#e65100 orange darken-4" type="submit">Cancelar
						<i class="material-icons right">send</i>
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
									<form class="col 1 s right" action="backendVehic.php" method="GET">	
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
                <th>Matricula</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Color</th>
                <th>Motor</th>
                <th>Estado</th>
				<th>Editar</th>
				
              </tr>
			  <tr class="white text">
			  <th>--------</th>
                <th>--------</th>
                <th>--------</th>
                <th>--------</th>
                <th>--------</th>
                <th>--------</th>
                <th>--------</th>
				<th>--------</th>
				</tr>
            </thead>
            <tbody>
            <?php
				foreach($listarVehic as $vehic){
?>
            <tr>
						<td><?=$vehic['marca_modelo_id']?></td>	
						<td><?=$vehic['matricula']?></td>
						<td><?=$vehic['marca']?></td>
						<td><?=$vehic['modelo']?></td>
                        <td><?=$vehic['color']?></td>
                        <td><?=$vehic['motor']?></td>
                        <td><?=$vehic['estadoRegistro']?></td>
						<td>
							<form action="backendVehic.php" method="POST">
								<input type="hidden" name="accion" value="Eliminar">
								
								<input type="hidden" name="idRegistro" value="<?=$vehic['marca_modelo_id']?>">
								<button class="btn-floating waves-effect waves- #bf360c deep-orange darken-4" type="submit" name="action">
									<i class="material-icons right">delete_forever</i>
								</button>
							</form>
							<form action="backendVehic.php" method="POST">
								<input type="hidden" name="accion" value="Editar">
								<input type="hidden" name="idRegistro" value="<?=$vehic['marca_modelo_id']?>">
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
							<span class="left"><p>Total Vehiculos: <?=$totalVehic?></p></span>
							<ul class="pagination right">
								<li class="waves-effect">
									<a href="backendVehic.php?pag=<?=$PAGINAANTERIOR?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>"><i class="material-icons">chevron_left</i></a>
								</li>
<?php
								for($i = 1; $i < $limitPagina ; $i++){

									$colorear = "waves-effect ";
									if($i == $PAGINA){
										$colorear = "active  waves- brown darken-2";
									}
?>
										<li class="<?=$colorear?>">
											<a href="backendVehic.php?pag=<?=$i?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>"><?=$i?></a>
										</li>
<?php 								
								}
?>

								<li class="waves-effect">
									<a href="backendVehic.php?pag=<?=$PAGINASIGUENTE?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>">
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
					<form class="col s12" action="backendVehic.php" method="POST">
						<div class="input-field col s12">
							<h6h6>Ingresar Vehiculos<h6>
						</div>
						<div class="input-field col s12">
							<input placeholder="Matricula" name="txt_matricula" id="first_name" type="text" class="validate">
							<label for="first_name">Matricula</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Marca" name="txt_marca" id="first_name" type="text" class="validate">
							<label for="first_name">Marca</label>
						</div>
            <div class="input-field col s12">
							<input placeholder="Modelo" name="txt_modelo" id="first_name" type="text" class="validate">
							<label for="first_name">Modelo</label>
						</div>
            <div class="input-field col s12">
							<input placeholder="Color" name="txt_color" id="first_name" type="text" class="validate">
							<label for="first_name">Color</label>
						</div>
            <div class="input-field col s12">
							<input placeholder="Motor" name="txt_motor" id="first_name" type="text" class="validate">
							<label for="first_name">Motor</label>
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