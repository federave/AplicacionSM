<?php

include_once('../modelo/usuarios/usuario.php');
include_once('../otros/otros.php');

session_start();


if(isset($_POST["iniciarSesion"]))
   {

    $nombre = $_POST["nombre"];
    $password = $_POST["password"];
    $usuario = new Usuario();

    if($usuario->ingresar($nombre,$password))
      {
      $_SESSION["id"] = $usuario->getId();
      redirect("../index.php");
      }
    else
      {
      $mensaje = "Datos de usuario incorrecto";
      redirect("../vistas/sesion/iniciarSesion.php?mensaje=$mensaje");
      }


   }
 else
   {
   redirect("../index.php");
   }


?>
