<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');

session_start();


if(isset($_POST["configurar"]))
   {

   $servidor = $_POST["direccion"];
   $usuario = $_POST["usuario"];
   $password = $_POST["password"];
   $conector = new Conector();
   $conector->setServidor($servidor);
   $conector->setUsuario($usuario);
   $conector->setContraseña($password);

    if($conector->abrirConexion())
      {
      $_SESSION["conexion"] = true;
      $_SESSION["servidor"] = $servidor;
      $_SESSION["usuario"] = $usuario;
      $_SESSION["contraseña"] = $password;

      redirect("../index.php");
      }
    else
      {
      $mensaje = "Datos de conexion incorrecta";
      redirect("../vistas/configuracion/configuracion.php?mensaje=$mensaje");
      }

   }
 else
   {
   redirect("../index.php");
   }




?>
