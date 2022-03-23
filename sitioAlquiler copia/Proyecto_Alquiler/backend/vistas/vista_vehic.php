<?PHP

require_once("modelos/autos.php");

$objVehic = new autos();

$respuesta = "";

if (isset($_POST['accion']) && $_POST['accion'] == "Ingresar") {

	$foto = "";

	 if(isset($_FILES['txt_foto']['name']) && $_FILES['txt_foto']['name'] == ""){
		$_FILES['txt_foto']['name']= "no hay foto";

	   }elseif(isset($_FILES['txt_foto']['name'])){

		$ruta="imagenes/".$_FILES['txt_foto']['name'];

		if(copy($_FILES['txt_foto']['tmp_name'],$ruta)){

			$foto = $_FILES ['txt_foto']['name'];

		}
	
	
	}

	$modelo      = $_POST['txt_modelo'];
	$color       = $_POST['txt_color'];
	$matricula   = $_POST['txt_matric'];
	$motor       = $_POST['txt_motor'];
	$km          = $_POST['txt_km'];
	$idMarca     = $_POST['txt_idMarca'];
	$idTipo      = $_POST['txt_idTipo'];

	$datos = [
		'idRegistro'	 => '',
		'estadoRegistro' => '',
		'modelo'         => $modelo,
		'color'          => $color,
		'foto'           => $foto,
		'matricula'      => $matricula,
		'motor'          => $motor,
		'km'	         => $km,
		'idMarca'        => $idMarca,
		'idTipo'         => $idTipo,
	];


	$objVehic->constructor($datos);
	$respuesta = $objVehic->ingresaAuto();
}


if (isset($_POST['accion']) && $_POST['accion'] == "Eliminar") {

	if (isset($_POST['idRegistro']) && $_POST['idRegistro'] != "") {
		$idRegistro = $_POST['idRegistro'];
		$objVehic->traerAuto($idRegistro);
	}
}

if (isset($_POST['accion']) && $_POST['accion'] == "ConfirmarEliminar") {

	if (isset($_POST['idRegistro']) && $_POST['idRegistro'] != "") {

		$idRegistro = $_POST['idRegistro'];

		$objVehic->traerAuto($idRegistro);
		$objVehic->modificarEstadoBorrado();
		$respuesta = $objVehic->guardarAuto();
	}
}



if (isset($_POST['accion']) && $_POST['accion'] == "Editar") {

	if (isset($_POST['idRegistro']) && $_POST['idRegistro'] != "") {


		$idRegistro = $_POST['idRegistro'];
		$objVehic->traerAuto($idRegistro);
	}

}


if (isset($_POST['accion']) && $_POST['accion'] == "Guardar") {

	if (isset($_POST['idRegistro']) && $_POST['idRegistro'] != "") {

		$foto = "";

	 if(isset($_FILES['txt_foto']['name']) && $_FILES['txt_foto']['name'] == ""){
		$_FILES['txt_foto']['name']= "no hay foto";

	   }elseif(isset($_FILES['txt_foto']['name'])){

		$ruta="imagenes/".$_FILES['txt_foto']['name'];

		if(copy($_FILES['txt_foto']['tmp_name'],$ruta)){

			$foto = $_FILES ['txt_foto']['name'];

		}

		/* $foto = "";


		 if(isset($_FILES['txt_foto']['name'])){
	
			$ruta="imagenes/".$_FILES['txt_foto']['name'];
	
			if(copy($_FILES['txt_foto']['tmp_name'],$ruta)){
	
				$foto = $_FILES ['txt_foto']['name'];
	
			}*/
		}
		
	
		$idRegistro  = $_POST['idRegistro'];
		$modelo      = $_POST['txt_modelo'];
		$color       = $_POST['txt_color'];
		$matricula   = $_POST['txt_matric'];
		$motor       = $_POST['txt_motor'];
		$km          = $_POST['txt_km'];
		$idMarca     = $_POST['txt_idMarca'];
		$idTipo      = $_POST['txt_idTipo'];
		
		

		$objVehic->traerAuto($idRegistro);
		$objVehic->modelo        = $modelo;
		$objVehic->color         = $color;
		$objVehic->foto          = $foto;
		$objVehic->matricula     = $matricula;
		$objVehic->motor         = $motor;
		$objVehic->km            = $km;
		$objVehic->idMarca       = $idMarca;
		$objVehic->idTipo		 = $idTipo;

		

		if (isset($_POST['Eliminar']) && $_POST['Eliminar'] == "ok") {
			$objVehic->modificarEstadoBorrado();
		}
		$respuesta = $objVehic->guardarAuto();
    }
}

$arrayFiltros = [];
$BUSCAR = "";

if (isset($_GET['accion']) && $_GET['accion'] == "Buscar") {

	if (isset($_GET['txtBuscar']) && $_GET['txtBuscar'] != "") {

		$arrayFiltros['buscar'] = $_GET['txtBuscar'];
		$BUSCAR 			   	= $_GET['txtBuscar'];
	}
}
$totalVehic = $objVehic->totalVehic($arrayFiltros);

if (isset($_GET['pag'])) {

	$PAGINA = $_GET['pag'];

	if ($PAGINA == "" || $PAGINA <= 0) {
		$PAGINA = 0;
		$PAGINAANTERIOR = $PAGINA;
	} else {
		$PAGINAANTERIOR = $PAGINA - 1;
	}

	$limitPagina = $totalVehic / 5;
	if ($limitPagina <= ($PAGINA + 1)) {
		$PAGINASIGUENTE = $PAGINA;
	} else {
		$PAGINASIGUENTE = $PAGINA + 1;
	}
	$arrayFiltros['pagina'] = $PAGINA;
} else {

	$PAGINA = 0;
	$PAGINASIGUENTE = $PAGINA + 1;
	$PAGINAANTERIOR = $PAGINA;
	$limitPagina = $totalVehic / 5;
}

$listarVehic = $objVehic->listarVehic($arrayFiltros);
sort($listarVehic);

?>

<div class="section no-pad-bot" id="index-banner">
	<div class="container">
		<br><br>
		<h2 class="header center brown-text">Vehiculos</h2>
		<br>
	
	</div>
</div>



<div class="container">
	<?php
	if (isset($_POST['accion']) && $_POST['accion'] == "Eliminar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != "") {
	?>
		<div class="#fbe9e7 deep-orange lighten-5">
			<form class="col s12" action="backend.php?vehic" method="POST">
				<div class="input-field col s12">
					<h3>Eliminar el Registro: <?= $objVehic->modelo . " " . $objVehic->matricula ?>?</h3>
				</div>
				<div>
				<input type="hidden" id="idAccion" name="accion" value="ConfirmarEliminar">
				<input type="hidden" id="idRegistro" name="idRegistro" value="<?= $objVehic->obtenerIdRegistro() ?>">
				<button class="btn waves-effect waves- #bf360c deep-orange darken-4" type="submit">Eliminar<i class="material-icons right">delete_forever</i></button>
				</div>	
				<br>
				<div>
					<button class="btn waves-effect waves- #3e2723 brown darken-4" type="submit"> <a href="backend.php?vehic">Cancelar</a>
					</button>
	           </div>
			</form>

		</div>
	<?php
	}
	?>
	<?php

	?>
	<?php
	if (isset($_POST['accion']) && $_POST['accion'] == "Editar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != "") {
	?>
		<div class="row">
			<form class="col s12" action="backend.php?vehic" method="POST" enctype="multipart/form-data">
				<div class="input-field col s12">
					<h6>Editar Vehiculo<h6>
				</div>
				<div class="input-field col s12">
					<input placeholder="Modelo" name="txt_modelo" id="first_name" type="text" class="validate" value="<?= $objVehic->modelo ?>">
					<label for="Modelo">Modelo</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="Color" name="txt_color" id="first_name" type="text" class="validate" value="<?= $objVehic->color ?>">
					<label for="Color">Color</label>
				</div>
				
				<div>
				<div class="file-field input-field col s12">
					<div class="btn -#9e9d24 lime darken-3">
						<span>Archivo</span>
						<input type="file" name="txt_foto" placeholder="foto" value= "<?=$objVehic->foto ?>">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="<?=$objVehic->foto, print_r(__NAMESPACE__)?>">
					</div>
				</div>
				</div>

				<div class="input-field col s12">
					<input placeholder="matricula" name="txt_matric" id="first_name" type="text" class="validate" value="<?= $objVehic->matricula ?>">
					<label for="Matricula">Matricula</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="motor" name="txt_motor" id="first_name" type="text" class="validate" value="<?= $objVehic->motor ?>">
					<label for="Motor">Motor</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="km" name="txt_km" id="first_name" type="text" class="validate" value="<?= $objVehic->km ?>">
					<label for="KM">KMs</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="idMarca" name="txt_idMarca" id="first_name" type="text" class="validate" value="<?= $objVehic->idMarca ?>">
					<label for="Marca">Marca</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="idTipo" name="txt_idTipo" id="first_name" type="text" class="validate" value="<?= $objVehic->idTipo ?>">
					<label for="Chasis">Chasis</label>
				</div>
				<div>
				 <input type="hidden" id="idAccion" name="accion" value="Guardar">
				 <input type="hidden" id="idRegistro" name="idRegistro" value="<?= $objVehic->obtenerIdRegistro()?>">
				 <button class="btn waves-effect waves-#9e9d24 lime darken-3" type="submit">Guardar
				</div>
				<br>
				<div>
				  <button class="btn waves-effect waves- #3e2723 brown darken-4" type="submit"><a href="backend.php?vehic">Cancelar</a>
				  </button>
				</div>
			</form>
		</div>
	<?php
	}
	?>



	<table class="striped">
		<thead>
			<tr class=" #a1887f brown lighten-2">
				<th colspan="11">
					<div class="row">
						<div class="col 8 s left">
							<a class="waves-effect waves-light btn modal-trigger #795548 brown" href="#modal1">Ingresar</a>
						</div>
						<div class="col 1 s right">
							<form class="col 1 s right" action="backend.php?vehic" method="GET">
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
				<th>Modelo</th>
				<th>Color</th>
				<th>Foto</th>
				<th>Matricula</th>
				<th>Motor</th>
				<th>KM</th>
				<th>ID Marca</th>
				<th>ID Chasis</th>
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
			foreach ($listarVehic as $vehic) {
			?>
				<tr>
					<td><?= $vehic['idVehic'] ?></td>
					<td><?= $vehic['modelo'] ?></td>
					<td><?= $vehic['color'] ?></td>
					
					<td>
					 <img src="imagenes/<?=$vehic['foto']?>"; width="50px">
					</td>
					<td><?= $vehic['matricula'] ?></td>
					<td><?= $vehic['motor'] ?></td>
					<td><?= $vehic['km'] ?></td>
					<td><?= $vehic['idMarca'] ?></td>
					<td><?= $vehic['idTipo'] ?></td>
					<td><?= $vehic['estadoRegistro'] ?></td>
					<td>
						<form action="backend.php?vehic" method="POST">
							<input type="hidden" name="accion" value="Eliminar">

							<input type="hidden" name="idRegistro" value="<?= $vehic['idVehic'] ?>">
							<button class="btn-floating waves-effect waves- #bf360c deep-orange darken-4" type="submit" name="action">
							<i class="material-icons right">delete_forever</i>
							</button>
						</form>
						<form action="backend.php?vehic" method="POST">
							<input type="hidden" name="accion" value="Editar">
							<input type="hidden" name="idRegistro" value="<?= $vehic['idVehic'] ?>">
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
					<td colspan="11">
						<span class="left">
							<p>Total: <?= $totalVehic ?></p> <button class="btn waves-effect waves- #3e2723 brown darken-4" type=""> <a href="backend.php?vehic">Listado Completo</a>
							</button>
						</span>
						<ul class="pagination right">
							<li class="waves-effect">
								<a href="backend.php?pag=<?= $PAGINAANTERIOR ?>&accion=Buscar&txtBuscar=<?= $BUSCAR ?>"><i class="material-icons">chevron_left</i></a>
							</li>
							<?php
							for ($i = 0; $i < $limitPagina; $i++) {

								$colorear = "waves-effect ";
								if ($i == $PAGINA) {
									$colorear = "active  waves- brown darken-2";
								}
							?>
								<li class="<?= $colorear ?>">
									<a href="backend.php?pag=<?= $i ?>&accion=Buscar&txtBuscar=<?= $BUSCAR ?>"><?= $i ?></a>
								</li>
							<?php
							}
							?>

							<li class="waves-effect">
								<a href="backend.php?pag=<?= $PAGINASIGUENTE ?>&accion=Buscar&txtBuscar=<?= $BUSCAR ?>"><i class="material-icons">chevron_right</i></a>
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
			<form class="col s12" action="backend.php?vehic" method="POST" enctype="multipart/form-data">
				<div class="input-field col s12">
					<h6>Ingresar Vehiculo<h6>
				</div>
				<div class="input-field col s12">
					<input placeholder="Modelo" name="txt_modelo" id="first_name" type="text" class="validate">
					<label for="Modelo">Modelo</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="Color" name="txt_color" id="first_name" type="text" class="validate">
					<label for="Color">Color</label>
				</div>
				
				<div class="file-field input-field col s12">
					<div class="btn waves-effect waves-#9e9d24 lime darken-3">
						<span>Foto</span>
						<input type="file" name="txt_foto" placeholder="foto">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text">
					</div>

				<div class="input-field col s12">
					<input placeholder="matricula" name="txt_matric" id="first_name" type="text" class="validate">
					<label for="Matricula">Matricula</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="motor" name="txt_motor" id="first_name" type="text" class="validate">
					<label for="Motor">Motor</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="km" name="txt_km" id="first_name" type="text" class="validate">
					<label for="KM">KMs</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="idMarca" name="txt_idMarca" id="first_name" type="text" class="validate">
					<label for="Marca">Marca</label>
				</div>
				<div class="input-field col s12">
					<input placeholder="idTipo" name="txt_idTipo" id="first_name" type="text" class="validate">
					<label for="Chasis">Chasis</label>
				</div>

				<input type="hidden" id="idAccion" name="accion" value="Ingresar">
				<button class="btn waves-effect waves-light brown darken-1" type="submit">Enviar
				<i class="material-icons right"></i>
				</button>
			</form>
		</div>
	</div>
	<div class="modal-footer #a1887f brown lighten-2">
		<a href="#!" class="modal-close waves-effect waves-brown-2 btn-flat  white-text">Cancelar</a>
	</div>
</div>