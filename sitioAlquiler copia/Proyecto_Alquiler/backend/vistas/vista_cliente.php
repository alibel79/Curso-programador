
<?php

require_once "modelos/clientes.php";

$objCliente = new cliente ();
$respusta="";

if(isset($_POST['accion']) && $_POST['accion'] == "Ingresar"){

	$nombre          = $_POST['txt_nombre'];
    $apellido        = $_POST['txt_apellido'];
	$email    	     = $_POST['txt_email'];
    $telefono        = $_POST['txt_telefono'];
    $direccion       = $_POST['txt_direccion'];
	$tipoDoc    	 = $_POST['txt_tipoDoc'];
    $documento    	 = $_POST['txt_documento'];
    $clave           = $_POST['txt_clave'];
	

	$datos = [
		'idRegistro'	 =>'', 
		'estadoRegistro' =>'', 
		'nombre'         => $nombre, 
        'apellido'		 => $apellido,
        'email'		     => $email,
        'telefono'       => $telefono, 
        'direccion'		 => $direccion,
        'tipoDoc'		 => $tipoDoc,
        'documento'      => $documento, 
        'clave'		     => $clave,
       

    ];
       

	$objCliente->constructor($datos);
	$respuesta = $objCliente->ingresarCliente();

}

    if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar"){
	
        if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){
            $idRegistro = $_POST['idRegistro'];		
            $objCliente->traerCliente($idRegistro);
        }
    }
    

    if(isset($_POST['accion']) && $_POST['accion'] == "ConfirmarEliminar"){
	
        if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){
    
            $idRegistro = $_POST['idRegistro'];
            
            $objCliente ->traerCliente($idRegistro);
            $objCliente ->modificarEstadoBorrado();
            $respuesta = $objCliente->guardarCliente();
    
        }
        
    }

    
if(isset($_POST['accion']) && $_POST['accion'] == "Editar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];		
		$objCliente->traerCliente($idRegistro);

	}
}

if(isset($_POST['accion']) && $_POST['accion'] == "Guardar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != ""){

		$idRegistro         = $_POST['idRegistro'];		
		$nombre             = $_POST['txt_nombre'];
        $apellido           = $_POST['txt_apellido'];
		$email	            = $_POST['txt_email'];
        $telefono           = $_POST['txt_telefono'];
		$direccion	        = $_POST['txt_direccion'];
		$tipoDoc	        = $_POST['txt_tipoDoc'];
        $documento	        = $_POST['txt_documento'];
        $clave              = $_POST['txt_clave'];
		
      
   

		$objCliente ->traerCliente ($idRegistro);
		$objCliente ->nombre         = $nombre;
        $objCliente ->apellido       = $apellido;
        $objCliente ->email          = $email;
        $objCliente ->telefono       = $telefono;
        $objCliente ->direccion      = $direccion;
        $objCliente ->tipoDoc        = $tipoDoc;
        $objCliente ->documento      = $documento;
        $objCliente ->clave          = $clave;
      
	

		if(isset($_POST['Eliminar']) && $_POST['Eliminar'] == "ok" ){
			$objCliente->modificarEstadoBorrado();
		}
		$respuesta = $objCliente->guardarCliente();

	}
}

$arrayFiltros = [];
$BUSCAR = "";

if(isset($_GET['accion']) && $_GET['accion'] == "Buscar"){

	if(isset($_GET['txtBuscar']) && $_GET['txtBuscar'] != ""){

		$arrayFiltros['buscar'] = $_GET['txtBuscar'];
		$BUSCAR 			   	= $_GET['txtBuscar'];
	}

}

$totalCliente = $objCliente->totalClientes($arrayFiltros);

if(isset($_GET['pag'])){

	$PAGINA = $_GET['pag'];

	if($PAGINA == "" || $PAGINA <= 0){
		$PAGINA = 0;
		$PAGINAANTERIOR = $PAGINA;	
	}else{
		$PAGINAANTERIOR = $PAGINA - 1;	
	}

	$limitPagina = $totalCliente / 5;
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
	$limitPagina = $totalCliente / 5;

}

$listarClientes = $objCliente->listarClientes($arrayFiltros);

?>

<div class="section no-pad-bot" id="index-banner">
			<div class="container">
			<br>
			<h1 class="header center brown-text">Clientes</h1>			
	
      </div>
  </div>
  <div class="container">
	   <?php
	if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != ""){
?>
			<div class="#fbe9e7 deep-orange lighten-5">
				<form class="col s12" action="backend.php?cli" method="POST">
					<div class="input-field col s12">
						<h3>Eliminar el Registro: <?=$objCliente->email." ". $objCliente->documento?>?</h3>
					</div>					
					<input type="hidden" id="idAccion" name="accion" value="ConfirmarEliminar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objCliente->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves- #bf360c deep-orange darken-4" type="submit">Eliminar
						<br>
					<button class="btn waves-effect waves- #3e2723 brown darken-4" type="submit"> <a href="backend.php?cli">Cancelar</a>
					</button>	
					
				</form>
				
			</div>	
<?php
	}
?>
<br>
<?php
	if(isset($_POST['accion']) && $_POST['accion'] == "Editar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != ""){
?>
			<div class="row">
				<form class="col s12" action="backend.php?cli" method="POST">
					<div class="input-field col s12">
						<h6>Ingresar Cliente<h6>
					</div>
                    <div class="input-field col s12">
						<input placeholder="Nombre" name="txt_nombre" id="first_name" type="text" class="validate" value="<?=$objCliente->nombre?>">
						<label for="Nombre">Nombre</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Apellido" name="txt_apellido" id="first_name" type="text" class="validate" value="<?=$objCliente->apellido?>">
						<label for="Apellido">Apellido</label>
					</div>
                    <div class="input-field col s12">
						<input placeholder="Email" name="txt_email" id="first_name" type="text" class="validate" value="<?=$objCliente->email?>">
						<label for="Email">Email</label>
					</div>
                    <div class="input-field col s12">
                    <input placeholder="Telefono" name="txt_telefono" id="first_name" type="text" class="validate" value="<?=$objCliente->telefono?>">
						<label for="Telefono">Telefono</label>
					</div>
                    <div>
                    <input placeholder="Direccion" name="txt_direccion" id="first_name" type="text" class="validate" value="<?=$objCliente->direccion?>">
						<label for="Direccion">Direccion</label>
					</div>
                    <div>
                    <input placeholder="Tipo Documento" name="txt_tipoDoc" id="first_name" type="text" class="validate" value="<?=$objCliente->tipoDoc?>">
						<label for="Tipo Documento">Tipo Documento</label>
					</div>
                    <div>
                    <input placeholder="Documento" name="txt_documento" id="first_name" type="text" class="validate" value="<?=$objCliente->documento?>">
						<label for="Documento">Documento</label>
					</div>
                    <div>
                    <input placeholder="Clave" name="txt_clave" id="first_name" type="text" class="validate" value="<?=$objCliente->clave?>">
						<label for="Clave">Clave</label>
					</div>

                    <input type="hidden" id="idAccion" name="accion" value="Guardar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objCliente->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves-#9e9d24 lime darken-3" type="submit">Guardar
						<br>
					<button class="btn waves-effect waves- #3e2723 brown darken-4" type=""> <a href="backend.php?cli">Cancelar</a>
					</button>
				</form>
    </div>
<?php
	}
?>	
 <table class="striped">
            <thead>
            <tr class=" #a1887f brown lighten-2">
						<th colspan="12">
							<div class="row">
								<div class="col 8 s left">
									<a class="waves-effect waves-light btn modal-trigger #795548 brown" href="#modal1">Ingresar</a>
								</div>
								<div class="col 1 s right">									
									<form class="col 1 s right" action="backend.php?cli" method="GET">	
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
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Tipo Doc</th>
                <th>Documento</th>
                <th>Clave</th>
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
                <th>--------</th>
                <th>--------</th>
                <th>--------</th>
                
				</tr>
            </thead>
            <tbody>
            <?php
				foreach($listarClientes as $cliente){
?>
            <tr>
						<td><?=$cliente['idCli']?></td>	
						<td><?=$cliente['nombre']?></td>
						<td><?=$cliente['apellido']?></td>
                        <td><?=$cliente['email']?></td>
						<td><?=$cliente['telefono']?></td>
                        <td><?=$cliente['direccion']?></td>
						<td><?=$cliente['tipoDoc']?></td>
		                <td><?=$cliente['documento']?></td>
                        <td><?=$cliente['clave']?></td>
		                <td><?=$cliente['estadoRegistro']?></td>
						<td>
							<form action="backend.php?cli" method="POST">
								<input type="hidden" name="accion" value="Eliminar">
								
								<input type="hidden" name="idRegistro" value="<?=$cliente['idCli']?>">
								<button class="btn-floating waves-effect waves- #bf360c deep-orange darken-4" type="submit" name="action">
									<i class="material-icons right">delete_forever</i>
								</button>
							</form>
							<form action="backend.php?cli" method="POST">
								<input type="hidden" name="accion" value="Editar">
								<input type="hidden" name="idRegistro" value="<?=$cliente['idCli']?>">
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
						<td colspan="12">
							<span class="left"><p>Total: <?=$totalCliente?></p> <button class="btn waves-effect waves- #3e2723 brown darken-4" type=""> <a href="backend.php?cli">Listado Completo</a>
					</button></span>
							<ul class="pagination right">
								<li class="waves-effect">
									<a href="backend.php?pag=<?=$PAGINAANTERIOR?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>"><i class="material-icons">chevron_left</i></a>
								</li>
<?php
								for ($i = 0; $i < $limitPagina; $i++) {

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
					<form class="col s12" action="backend.php?cli" method="POST">
						<div class="input-field col s12">
							<h6h6>Ingresar Cliente<h6>
						</div>
						<div class="input-field col s12">
							<input placeholder="Nombre" name="txt_nombre" id="first_name" type="text" class="validate">
							<label for="first_name">Nombre</label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="Apellido" name="txt_apellido" id="first_name" type="text" class="validate">
							<label for="first_name">Apellido</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Email" name="txt_email" id="first_name" type="text" class="validate">
							<label for="first_name">Email</label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="telefono" name="txt_telefono" id="first_name" type="text" class="validate">
							<label for="first_name">Telefono</label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="Direccion" name="txt_direccion" id="first_name" type="text" class="validate">
							<label for="first_name">Direccion</label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="Tipo Documento" name="txt_tipoDoc" id="first_name" type="text" class="validate">
							<label for="first_name">Tipo Documento</label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="Documento" name="txt_documento" id="first_name" type="text" class="validate">
							<label for="first_name">Documento</label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="Clave" name="txt_clave" id="first_name" type="text" class="validate">
							<label for="first_name">Clave</label>
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