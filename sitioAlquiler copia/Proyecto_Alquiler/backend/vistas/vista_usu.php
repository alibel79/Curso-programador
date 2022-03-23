<?PHP

require_once("modelos/usuarios.php");

$objUsuario = new usuarios();

$respuesta = "";

if(isset($_POST['accion']) && $_POST['accion'] == "Ingresar"){

	$nombre      = $_POST['txt_nombre'];
	$email    	 = $_POST['txt_email'];
    $clave       = $_POST['txt_clave'];
	$perfil   	 = $_POST['sel_perfil'];

	$datos = [
		'idRegistro'	 =>'', 
		'estadoRegistro' =>'', 
		'nombre'         => $nombre, 
		'email'			 =>$email,
        'clave'		     => $clave,
        'perfil'		 => $perfil,

    ];
       

	$objUsuario->constructor($datos);
	$respuesta = $objUsuario->ingresarUsuario();

}


if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){
		$idRegistro = $_POST['idRegistro'];		
		$objUsuario->traerUsuario($idRegistro);
	}
}

if(isset($_POST['accion']) && $_POST['accion'] == "ConfirmarEliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];
		
		$objUsuario->traerUsuario($idRegistro);
		$objUsuario->modificarEstadoBorrado();
		$respuesta = $objUsuario->guardarUsuario();

	}
	
}



if(isset($_POST['accion']) && $_POST['accion'] == "Editar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];		
		$objUsuario->traerUsuario($idRegistro);

	}
}
 

if(isset($_POST['accion']) && $_POST['accion'] == "Guardar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro     = $_POST['idRegistro'];		
		$nombre         = $_POST['txt_nombre'];
		$email	        = $_POST['txt_email'];
        $clave          = $_POST['txt_clave'];
		$perfil	        = $_POST['sel_perfil'];
      
   

		$objUsuario ->traerUsuario ($idRegistro);
		$objUsuario ->nombre         = $nombre;
        $objUsuario ->email          = $email;
        $objUsuario ->clave          = $clave;
        $objUsuario ->perfil         = $perfil;
      
	

		if(isset($_POST['Eliminar']) && $_POST['Eliminar'] == "ok" ){
			$objUsuario->modificarEstadoBorrado();
		}
		$respuesta = $objUsuario->guardarUsuario();

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
$totalUsuarios = $objUsuario->totalUsuario($arrayFiltros);

if(isset($_GET['pag'])){

	$PAGINA = $_GET['pag'];

	if($PAGINA == "" || $PAGINA <= 0){
		$PAGINA = 0;
		$PAGINAANTERIOR = $PAGINA;	
	}else{
		$PAGINAANTERIOR = $PAGINA - 1;	
	}

	$limitPagina = $totalUsuarios / 5;
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
	$limitPagina = $totalUsuarios / 5;

}

$listarUsuarios = $objUsuario->listarUsuarios($arrayFiltros);
sort($listarUsuarios);

$listarPerfiles =$objUsuario->Perfiles();


?>



  <div class="section no-pad-bot" id="index-banner">
			<div class="container">
			<br>
			<h1 class="header center brown-text">Usuarios</h1>			
	
      </div>
  </div>



       <div class="container">
	   <?php
	if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != ""){
?>
			<div class="#fbe9e7 deep-orange lighten-5">
				<form class="col s12" action="backend.php?usu" method="POST">
					<div class="input-field col s12">
						<h3>Eliminar el Registro: <?=$objUsuario->nombre." ". $objUsuario->perfil?>?</h3>
					</div>					
					<input type="hidden" id="idAccion" name="accion" value="ConfirmarEliminar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objUsuario->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves- #bf360c deep-orange darken-4" type="submit">Eliminar
						<br>
					<button class="btn waves-effect waves- #3e2723 brown darken-4" type="submit"> <a href="backend.php?usu">Cancelar</a>
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
				<form class="col s12" action="backend.php?usu" method="POST">
					<div class="input-field col s12">
						<h6>Ingresar Usuario<h6>
					</div>
          <div class="input-field col s12">
						<input placeholder="Usuario" name="txt_nombre" id="first_name" type="text" class="validate" value="<?=$objUsuario->nombre?>">
						<label for="Usuario">Usuario</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="email" name="txt_email" id="first_name" type="text" class="validate" value="<?=$objUsuario->email?>">
						<label for="Email">Email</label>
					</div>
                    <div class="input-field col s12">
						<input placeholder="clave" name="txt_clave" id="first_name" type="text" class="validate" value="<?=$objUsuario->clave?>">
						<label for="Clave">Clave</label>
					</div>
                    <div class="input-field col s12">
                  
						<label for="Perfil">Perfil</label>
                        <select name="sel_perfil">
    <?php     
                    foreach($listarPerfiles as $tipo=>$perfil){
    ?>                    

                        <option value="<?=$tipo?>"><?=$perfil?></option>

    <?php
                    }
    
    ?>
                            </select>	
	
					</div>


					<input type="hidden" id="idAccion" name="accion" value="Guardar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objUsuario->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves-#9e9d24 lime darken-3" type="submit">Guardar
						<br>
					<button class="btn waves-effect waves- #3e2723 brown darken-4" type=""> <a href="backend.php?usu">Cancelar</a>
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
									<form class="col 1 s right" action="backend.php?usu" method="GET">	
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
                <th>Nombre</th>
                <th>Email</th>
                <th>Clave</th>
                <th>Perfil</th>
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
                
				</tr>
            </thead>
            <tbody>
            <?php
				foreach($listarUsuarios as $usuario){
?>
            <tr>
						<td><?=$usuario['idUsuario']?></td>	
						<td><?=$usuario['nombre']?></td>
						<td><?=$usuario['email']?></td>
                        <td><?=$usuario['clave']?></td>
						<td><?=$usuario['perfil']?></td>
		                <td><?=$usuario['estadoRegistro']?></td>
						<td>
							<form action="backend.php?usu" method="POST">
								<input type="hidden" name="accion" value="Eliminar">
								
								<input type="hidden" name="idRegistro" value="<?=$usuario['idUsuario']?>">
								<button class="btn-floating waves-effect waves- #bf360c deep-orange darken-4" type="submit" name="action">
									<i class="material-icons right">delete_forever</i>
								</button>
							</form>
							<form action="backend.php?usu" method="POST">
								<input type="hidden" name="accion" value="Editar">
								<input type="hidden" name="idRegistro" value="<?=$usuario['idUsuario']?>">
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
							<span class="left"><p>Total: <?=$totalUsuarios?></p> <button class="btn waves-effect waves- #3e2723 brown darken-4" type=""> <a href="backend.php?usu">Listado Completo</a>
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
					<form class="col s12" action="backend.php?usu" method="POST">
						<div class="input-field col s12">
							<h6h6>Ingresar Usuario<h6>
						</div>
						<div class="input-field col s12">
							<input placeholder="Nombre" name="txt_nombre" id="first_name" type="text" class="validate">
							<label for="first_name">Nombre</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Email" name="txt_email" id="first_name" type="text" class="validate">
							<label for="first_name">Email</label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="Clave" name="txt_clave" id="first_name" type="text" class="validate">
							<label for="first_name">Clave</label>
						</div>
                        <div class="input-field col s12">
                            <select name="sel_perfil">
    <?php     
                    foreach($listarPerfiles as $tipo =>$perfil){
    ?>                    

                        <option value="<?=$tipo?>"><?=$perfil?></option>

    <?php
                    }
    
    ?>
                            </select>						
							<label for="first_name">Perfil</label>
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

	