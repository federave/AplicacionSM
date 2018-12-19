<?php
include_once('../../modelo/cliente/cliente.php');
session_start();

$cliente = $_SESSION["Cliente"];

?>


<html lang="es">


    <head>
        <title>Saint Michel</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/general.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../javascript/lista.js"></script>

        <script src="../../otros/otros.js"></script>
    </head>

    <body id="cuerpo" >

      <div class="row" style="margin:3%;width:94%">
        <div class="text-center" style="">
          <h4 class="titulo">Datos Cliente</h4>
        </div>
      </div>



      <div class="row borde" style="margin-left:5%;margin-right:5%;width:90%">



        <div class="row" style="margin-top:50px;margin-left:100px;">

          <!-- Datos Basicos del Cliente -->
          <div class="column" style="width:25%">
            <?php require 'datosBasicosCliente.php'; ?>
          </div>


          <!-- Direccion -->
          <div class="column" style="width:25%;margin-left:5%;">
            <?php require 'direccion.php'; ?>
          </div>


          <!-- Inactividad -->
          <div class="column" style="width:25%;margin-left:5%;">
            <?php require 'inactividad.php'; ?>
          </div>


        </div>


        <div class="row" style="margin-top:50px;margin-bottom:50px;margin-left:100px;">

          <!-- Asignacion y Reparto -->

          <div class="column" style="width:25%">
            <?php require 'asignacionReparto.php';?>
          </div>

          <!-- Datos Alquiler -->
          <?php require 'datosAlquiler.php';?>

          <!-- Precio Especial Productos -->
          <?php require 'precioEspecialProductos.php';?>


        </div>

        <div class="row" style="margin-top:50px;margin-bottom:50px;margin-left:100px;">

          <!-- Deudas Productos -->
          <?php
          if($cliente->getDeudasProductos()->getSize()>0)
            {
              ?>
            <div class="column" style="width:25%">
              <?php require 'deudasProductos.php';?>
            </div>

          <?php
            }
          ?>


        </div>

      </div>






      <footer  style="height:500px">
      </footer>


    </body>

</html>
