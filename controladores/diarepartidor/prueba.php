<?php

include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');


session_start();
 ?>
<html lang="es">


    <head>
        <title>Saint Michel</title>
        <link rel="stylesheet" href="vistas/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vistas/css/general.css">
        <script src="vistas/bootstrap/js/bootstrap.min.js"></script>
        <script src="otros\otros.js"></script>
    </head>

    <body id="cuerpo" >

    <?php  echo $_SESSION["var"]->getServidor();?>




          </body>

      </html>
