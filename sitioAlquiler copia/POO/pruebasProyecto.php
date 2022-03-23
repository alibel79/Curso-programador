<!DOCTYPE html>
<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
  <title>Starter Template - Materialize</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="backend/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="backend/css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="backend/css/libreria.css" type="text/css" rel="stylesheet" media="screen,projection" />
</head>

<body>
  <div class="navbar-fixed">

    <nav class="#6d4c41 brown darken-1" role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Logo</a>
        <ul class="right hide-on-med-and-down">
          <li><a href="#">Usuarios</a></li>
          <li> <a href="#">Clientes</a></li>
          <li><a href="#">Autos</a></li>
          <li> <a href="#">Alquileres</a></li>
          <li> <a href="#">Reservas</a></li>
        </ul>

        <ul id="nav-mobile" class="sidenav">
          <li>><a href="#">Usuarios</a></li>
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
      <div class="col l3 s12">
        <form class="col s12" action="backend.php" method="GET">

       
            <div class="row">
              <div class="input-field col s3">
                <input placeholder="nombre" id="nombre" type="text" class="validate">
                <label for="Nombre">Nombre</label>
              </div>
              <div class="input-field col s3">
                <input id="mail" type="email" class="validate">
                <label for="Email">Email</label>
              </div>
              <div class="input-field col s3">
                <input id="clave" type="password" class="validate">
                <label for="Clave">Clave</label>
              </div>
              <div class="input-field col s3">
                <input type="submit" name="enviando" value="Ingresar" class="validate">
                <label for="Ingresar"></label>
              </div>
              <div class="col 6 s12">
              <label for="">Buscar  <input type="text" name="buscar"></label>
          
                <input type="submit" name="enviando" value="buscar" class="validate">
               
              </div>
            </div>
          </div>
        </form>
      </div>
      <br><br>
      <!--<h1 class="header center orange-text">Starter Template</h1>
      <div class="row center">
        <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
      </div>
      <div class="row center">
        <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light orange">Get Started</a>
      </div>
      <br><br>

    </div>
  </div>-->


       <div class="container">
      

         <table class="striped">
            <thead>
              <tr>
                <th>ID Registro</th>
                <th>Nombre</th>
                <th>Mail</th>
                <th>Perfil</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>01</td>
                <td>Alibel</td>
                <td>acolina@mail.com</td>
                <td>Vendedor</td>
                <td>Activo</td>
              </tr>
              <tr>
                <td>02</td>
                <td>Rodrigo</td>
                <td>rbarros@mail.com</td>
                <td>Supervisor</td>
                <td>Activo</td>
              </tr>
              <tr>
                <td>03</td>
                <td>Patricia</td>
                <td>psolis@mail.com</td>
                <td>Administrador</td>
                <td>Activo</td>
              </tr>
            </tbody>
          </table>


        </div>
        <br><br>
      </div>
      <br>
      <br>
      <br>


      <footer class="page-footer #6d4c41 brown darken-1">
        <div class="container">
          <div class="row">
            <div class="col l6 s12">
              <h5 class="white-text">Company Bio</h5>
              <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


            </div>
            <div class="col l3 s12">
              <h5 class="white-text">Settings</h5>
              <ul>
                <li><a class="white-text" href="#!">Link 1</a></li>
                <li><a class="white-text" href="#!">Link 2</a></li>
                <li><a class="white-text" href="#!">Link 3</a></li>
                <li><a class="white-text" href="#!">Link 4</a></li>
              </ul>
            </div>
            <div class="col l3 s12">
              <h5 class="white-text">Connect</h5>
              <ul>
                <li><a class="white-text" href="#!">Link 1</a></li>
                <li><a class="white-text" href="#!">Link 2</a></li>
                <li><a class="white-text" href="#!">Link 3</a></li>
                <li><a class="white-text" href="#!">Link 4</a></li>
              </ul>
            </div>
          </div>
        </div>
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

</body>

</html>