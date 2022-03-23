<?PHP

require_once("modelos/usuarios.php");

if(isset($_GET['cerrar']) && $_GET['cerrar'] == "ok"){

	@session_start();
	unset($_SESSION['nombre']);
	@session_destroy();
	
}else{

	@session_start();

	if(isset($_GET['sec'])){

		$_SESSION['seccion'] = $_GET['sec'];

	}else{

		if(isset($_SESSION['seccion']) && $_SESSION['seccion'] == ""){
			$_SESSION['seccion'] = "principal";
		}
	}
}


$objUsuario = new usuarios();
$respuesta = "";

if(isset($_POST['accion']) && $_POST['accion'] == "login"){

	$email = $_POST['txt_email'];
	$pwd 	= $_POST['txt_pwd'];
	
	$respuesta = $objUsuario->login($email, $pwd);

	if(isset($respuesta[0]['nombre'])){
		@session_start();
		$_SESSION['nombre'] = $respuesta[0]['nombre'];
		$_SESSION['fecha'] 	= date("Y-m-d H:i:s");
		

	}
}



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
                    <img src="backend/img/Logoauto.png" width="60px" heigth="60px"> RENT & MOVE </a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="backend.php?sec=usu">Usuarios</a></li>
                    <li> <a href="backend.php?sec=cli">Clientes</a></li>
                    <li><a href="backend.php?sec=vehic">Vehiculos</a></li>
                    <li> <a href="backend.php?sec=marca">Marcas</a></li>
                    <li> <a href="backend.php?sec=carr">Carroceria</a></li>
                    <li>
                        <a class='dropdown-trigger btn  -#a1887f brown lighten-2' href='#' data-target='dropdown1'> <b class="#a1887f brown lighten-2"> Menu<b> </a>
                        <!-- Dropdown Structure -->
                        <ul id='dropdown1' class='dropdown-content'>
                            <li><a href="backend.php?ini=inicio">Inicio</a></li>
                            <li><a href="#!">two</a></li>
                            <li><a href="#!">three</a></li>
                            <li><a href="#!"><i class="material-icons">view_module</i>four</a></li>
                            <li>
                                <a href="backend.php?cerrar=ok">
                                    <i class="material-icons">cloud</i>
                                    Cerrar
                                </a>
                            </li>
                            <!-- Dropdown Trigger -->


                        </ul>
                    </li>
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
        </nav>

    </div>

    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <br><br>
            <h2 class="header center brown-text">Administrador</h2>
            <br>
        </div>

    </div>

    <?php

    if (!isset($_SESSION['nombre'])){

    ?>

        <div class="container">
            <div class="row">
                <form class="col s12" action="backend.php?sec=ini" method="POST">

                    <div class="row">
                        <div class="input-field col s4">
                            <label for="Email">Email
                                <input name="txt_email" id="email" type="email" class="validate">
                            </label>

                        </div>

                        <div class="row">
                            <div class="input-field col s4">
                                <label for="Clave">Clave
                                    <input name="txt_pwd" id="password" type="password" class="validate">
                                </label>

                            </div>

                            <div>
                                <input name="accion" id="idAction" type="hidden" value="login">
                                <button class="btn waves-effect waves-#9e9d24 lime darken-3" type="submit">Enviar
                            </div>
                        </div>


                </form>
            </div>



        <?php

    }else{
    

        if ($_SESSION['seccion'] == "marca") {

            include("backend/vistas/vista_marca.php");

        } elseif ($_SESSION['seccion'] == "carr") {

            include("backend/vistas/vista_carroc.php");

        } elseif ($_SESSION['seccion']=="usu" ){

            include ("backend/vistas/vista_usu.php");

        } elseif ($_SESSION['seccion']=="vehic"){

            include ("backend/vistas/vista_vehic.php");

        } elseif ($_SESSION['seccion']=="cli"){

            include ("backend/vistas/vista_cliente.php");
            
        } else{
            
        

 ?>

         <h1 class="header center brown-text">Hola <?= $_SESSION['nombre'] ?> </h1></a>  
 <?php

        }
        
    }

        ?>


        </div>
        </div>




        <br><br><br><br>



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

                var elems = document.querySelectorAll('.dropdown-trigger');
                var instances = M.Dropdown.init(elems, options);

            });
        </script>

</body>

</html>