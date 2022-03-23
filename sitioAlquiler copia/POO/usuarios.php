<?php

class generica{
   
    protected $idRegistro;

    protected $estadoRegistro;

    function __construct()
    {

    }

    function constructor (){
     $this->idRegistro=0;    
     $this->estadoRegistro="ingresado";
            
    }
    public function mostraridRegistro(){

        return $this->idRegistro;
    }
    public function mostrarEstadoR(){

        return $this->estadoRegistro;
    }

    }

class usuarios extends generica{

    public $nombre;

    public $mail;

    public $clave;

    public $perfil;

   function asignarValor($nombre,$mail,$clave,$perfil)
   {
    $this->nombre=$nombre;    
    $this->mail=$mail;
    $this->clave=$clave;   
    $this->perfil=$perfil;
       
   }
   function constructor()
   {
     parent::constructor();
     $this->idRegistro=55;    
 
   }
    public function obtenerValor(){

        $retorno=array();

            $retorno['nombre']=$this->nombre;
            $retorno['mail']=$this->mail;
            $retorno['clave']=$this->clave;
            $retorno['perfil']=$this->perfil;

            return $retorno;

        }

}

$objGenerica=new generica();
$objGenerica->constructor();
echo ($objGenerica->mostraridRegistro());
echo"<br>";
echo ($objGenerica->mostrarEstadoR());

$objUsuarios=new usuarios();

echo "</br>";
echo "<hr>";
$objUsuarios->asignarValor("alibel","acolin@mail.com","1234", "perfil");
$retorno=$objUsuarios->obtenerValor();
/*echo var_dump($retorno);*/
/*$objUsuarios->obtenerValor();*/
foreach($retorno as $datos){
    echo "Datos ingresados: $datos<br>";
}

/*echo $retorno('nombre'.'mail'.'clave'.'perfil');*/

echo "</br>";

$objUsuarios->constructor();
echo "<hr>";
echo($objUsuarios->mostraridRegistro());
echo "</br>";
echo($objUsuarios->mostrarEstadoR());
/*echo ($objUsuarios->mostrarTodo);
echo "</br>";
echo "<hr>";
$objUsuario2=new usuarios("nombre2","email2","clave2","perfil2"."<br>");
$objUsuario2->obtenerValor();
echo "</br>";
echo($objUsuario2->mostraridRegistro());
echo "</br>";
echo($objUsuario2->mostrarEstadoR());
"<br>";

/*

$objUsuario3= new usuarios("nombre3","email3","clave3","perfil3"."<br>");
$objUsuario3->mostrarTodo();
"<br>";
/*$objUsuario2=new usuarios();
$objUsuario2->nombre="Maria";
$objUsuario2->mail="mlopez@mail.com";
$objUsuario2->clave="laclave";
$objUsuario2->perfil="el perfil";

/*$objUsuarios->cargarTodo();

echo($objUsuarios->mail="ac@gmail.com"."<br>");

"<br>";
$objUsuarios->mail="ac@gmail.com";
echo "<br>";
echo ($objUsuarios->mail);
echo "<hr>";

$objUsuarios->mostrarTodo();


    /*public function cargarTodo(){

      $this->nombre = "soy nombre";
      $this->mail = "soy mail";
      $this->clave = "soy clave";
      $this->perfil = "soy perfil";
    }*/

?>