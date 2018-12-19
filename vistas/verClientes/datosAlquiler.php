<?php
$datosAlquiler = $cliente->getDatos()->getDatosAlquiler();

if($datosAlquiler->getEstado()) {  ?>

  <div class="column" style="width:25%;margin-left:5%;">

    <h3 class="subtitulo" style="margin-bottom:30px;">Datos Alquiler</h3>

    <?php if($datosAlquiler->getAlquileres()->getAlquiler6Bidones() > 0) { ?>
    <p style="margin-top:5px;font-size:20px;">Alquileres 6 Bidones: <?php echo $datosAlquiler->getAlquileres()->getAlquiler6Bidones();?></p>
    <?php } ?>

    <?php if($datosAlquiler->getAlquileres()->getAlquiler8Bidones() > 0) { ?>
    <p style="margin-top:5px;font-size:20px;">Alquileres 8 Bidones: <?php echo $datosAlquiler->getAlquileres()->getAlquiler8Bidones();?></p>
    <?php } ?>

    <?php if($datosAlquiler->getAlquileres()->getAlquiler10Bidones() > 0) { ?>
    <p style="margin-top:5px;font-size:20px;">Alquileres 10 Bidones: <?php echo $datosAlquiler->getAlquileres()->getAlquiler10Bidones();?></p>
    <?php } ?>

    <?php if($datosAlquiler->getAlquileres()->getAlquiler12Bidones() > 0) { ?>
    <p style="margin-top:5px;font-size:20px;">Alquileres 12 Bidones: <?php echo $datosAlquiler->getAlquileres()->getAlquiler12Bidones();?></p>
    <?php } ?>

    <?php if($datosAlquiler->getAlquileres()->getAlquiler6Bidones() > 0) { ?>
    <p style="margin-top:5px;font-size:20px;">Alquileres 6 Bidones Pagados: <?php echo $datosAlquiler->getAlquileresPagados()->getAlquiler6Bidones();?></p>
    <?php } ?>

    <?php if($datosAlquiler->getAlquileres()->getAlquiler8Bidones() > 0) { ?>
    <p style="margin-top:5px;font-size:20px;">Alquileres 8 Bidones Pagados: <?php echo $datosAlquiler->getAlquileresPagados()->getAlquiler8Bidones();?></p>
    <?php } ?>

    <?php if($datosAlquiler->getAlquileres()->getAlquiler10Bidones() > 0) { ?>
    <p style="margin-top:5px;font-size:20px;">Alquileres 10 Bidones Pagados: <?php echo $datosAlquiler->getAlquileresPagados()->getAlquiler10Bidones();?></p>
    <?php } ?>

    <?php if($datosAlquiler->getAlquileres()->getAlquiler12Bidones() > 0) { ?>
    <p style="margin-top:5px;font-size:20px;">Alquileres 12 Bidones Pagados: <?php echo $datosAlquiler->getAlquileresPagados()->getAlquiler12Bidones();?></p>
    <?php } ?>

    <p style="margin-top:5px;font-size:20px;">Bidones 20L Entregados: <?php echo $datosAlquiler->getRetornablesEntregados()->getBidon20L();?></p>
    <p style="margin-top:5px;font-size:20px;">Bidones 12L Entregados: <?php echo $datosAlquiler->getRetornablesEntregados()->getBidon12L();?></p>

    <?php if($datosAlquiler->getPrecioEspecial()) { ?>

      <p style="margin-top:5px;font-size:20px;">Precio Especial Alquileres</p>

      <?php if($datosAlquiler->getAlquileres()->getAlquiler6Bidones() > 0) { ?>
      <p style="margin-top:5px;font-size:20px;">Alquiler 6 Bidones: <?php echo $datosAlquiler->getPrecioAlquileres()->getAlquiler6Bidones();?></p>
      <?php } ?>

      <?php if($datosAlquiler->getAlquileres()->getAlquiler8Bidones() > 0) { ?>
      <p style="margin-top:5px;font-size:20px;">Alquiler 8 Bidones: <?php echo $datosAlquiler->getPrecioAlquileres()->getAlquiler8Bidones();?></p>
      <?php } ?>

      <?php if($datosAlquiler->getAlquileres()->getAlquiler10Bidones() > 0) { ?>
      <p style="margin-top:5px;font-size:20px;">Alquiler 10 Bidones: <?php echo $datosAlquiler->getPrecioAlquileres()->getAlquiler10Bidones();?></p>
      <?php } ?>

      <?php if($datosAlquiler->getAlquileres()->getAlquiler12Bidones() > 0) { ?>
      <p style="margin-top:5px;font-size:20px;">Alquiler 12 Bidones: <?php echo $datosAlquiler->getPrecioAlquileres()->getAlquiler12Bidones();?></p>
      <?php } ?>


    <?php } ?>


  </div>


<?php } ?>
