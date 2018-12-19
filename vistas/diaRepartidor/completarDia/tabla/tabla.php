

<!-- Tabla Planilla -->


<?php include_once('otrosTabla.php'); ?>


<div class="contenedor" >

  <?php $titulo = $planilla->getNombre(); ?>

  <?php require 'tituloTabla.php' ?>


  <div class="tabla borde" style="background-color:white">
    <?php require 'cabezeraTabla.php' ?>
    <?php require 'planillaTabla.php'  ?>
  </div>





</div>
