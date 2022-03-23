<?PHP

require_once ("modelos/carroceria.php");

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
		$BUSCAR 			    = $_GET['txtBuscar'];
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
 asort ($listarTipos);

?>


<div class="section no-pad-bot" id="index-banner">
			<div class="container">
			<br><br>
			<h1 class="header center brown-text">Tipos Chasis</h1>			
				<br>


      </div>
  </div>



	   <?php
	if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != ""){
?>
			<div class="#fbe9e7 deep-orange lighten-5">
				<form class="col s12" action="backend.php?carr" method="POST">
					<div class="input-field col s12">
						<h3>Eliminar el Registro: <?=$objCarroc->carroceria." ". $objCarroc->precio?>?</h3>
					</div>					
					<input type="hidden" id="idAccion" name="accion" value="ConfirmarEliminar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objCarroc->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves- #bf360c deep-orange darken-4" type="submit">Eliminar
					<br>
					<button class="btn waves-effect waves- #3e2723 brown darken-4" type="submit"> <a href="backend.php?carr">Cancelar</a>
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

<div class="container">
			<div class="row">
				<form class="col s12" action="backend.php?carr" method="POST">
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
					<br>
                    <button class="btn waves-effect waves- #3e2723 brown darken-4" type="submit"> <a href="backend.php?carr">Cancelar</a>
					</button>	
                   
			</div>
				</form>
			</div>	
<?php
	}
?>

<div class="section no-pad-bot" id="index-banner">
			<div class="container">

         <table class="striped">
            <thead>
            <tr class=" #a1887f brown lighten-2">
						<th colspan="8">
							<div class="row">
								<div class="col 8 s left">
									<a class="waves-effect waves-light btn modal-trigger #795548 brown" href="#modal1">Ingresar</a>
								</div>
								<div class="col 1 s right">									
									<form class="col 1 s right" action="backend.php?carr" method="GET">	
										<input type="hidden" id="idAccion" name="accion" value="Buscar">
										<button class="btn waves-effect waves- #795548 brown" type="submit">Buscar
											<i class="material-icons right"></i>
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
				foreach ($listarTipos as $carroc){
?>
            <tr>
						<td><?=$carroc['idTipo']?></td>	
						<td><?=$carroc['tipoCarroceria']?></td>
						<td><?=$carroc['precio']?></td>
		                <td><?=$carroc['estadoRegistro']?></td>
						<td>
							<form action="backend.php?carr" method="POST">
								<input type="hidden" name="accion" value="Eliminar">
								
								<input type="hidden" name="idRegistro" value="<?=$carroc['idTipo']?>">
								<button class="btn-floating waves-effect waves- #bf360c deep-orange darken-4" type="submit" name="action">
									<i class="material-icons right">delete_forever</i>
								</button>
							</form>
							<form action="backend.php?carr" method="POST">
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
							<span class="left"><p>Total Registros: <?=$totalTipo?></p> <button class="btn waves-effect waves- #3e2723 brown darken-4" type=""> <a href="backend.php?carr">Listado Completo</a>
					</button></span>
							<ul class="pagination right">
								<li class="waves-effect">
									<a href="backend.php?pag=<?=$PAGINAANTERIOR?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>"><i class="material-icons">chevron_left</i></a>
								</li>
<?php
								for($i = 0; $i < $limitPagina ; $i++){

									$colorear = "waves-effect ";
									if($i == $PAGINA){
										$colorear = "active  waves- brown darken-2";
									}
?>
										<li class="<?=$colorear?>">
											<a href="backend.php?pag=<?=$i?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>"><?=$i?></a>
										</li>
<?php 								
								}
?>

								<li class="waves-effect">
									<a href="backend.php?pag=<?=$PAGINASIGUENTE?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>">
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
					<form class="col s12" action="backend.php?carr" method="POST">
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

