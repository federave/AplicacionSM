<h3 class="subtitulo" style="margin-bottom:30px;">Inactividad</h3>

<?php $activo = "Si";if($cliente->getDatos()->getActivo() == 0) $activo="no";?>

<p style="margin-top:5px;font-size:20px;">Cliente Activo: <?php echo $activo;?></p>
<p style="margin-top:5px;font-size:20px;">Descripcion: <?php echo $cliente->getInactividad()->getTipoInactivo()->getTipoInactivo();?></p>
<p style="margin-top:5px;font-size:20px;">Fecha Último Consumo: <?php echo $cliente->getInactividad()->getFechaUltimoConsumo();?></p>
<br>

<?php if($cliente->getInactividad()->getConsumo()) {?>


<p style="margin-top:5px;font-size:20px;margin-bottom:10px;">Datos del Consumo</p>
<?php if($cliente->getInactividad()->getRetornables()->getBidon20L()>0) {?>
<p style="margin-top:5px;font-size:20px;">Bidones 20L: <?php echo $cliente->getInactividad()->getRetornables()->getBidon20L();?></p>
<?php } ?>

<?php if($cliente->getInactividad()->getRetornables()->getBidon12L()>0) {?>
<p style="margin-top:5px;font-size:20px;">Bidones 12L: <?php echo $cliente->getInactividad()->getRetornables()->getBidon12L();?></p>
<?php } ?>

<?php if($cliente->getInactividad()->getDescartables()->getBidon10L()>0) {?>
<p style="margin-top:5px;font-size:20px;">Bidones 10L: <?php echo $cliente->getInactividad()->getDescartables()->getBidon10L();?></p>
<?php } ?>

<?php if($cliente->getInactividad()->getDescartables()->getBidon8L()>0) {?>
<p style="margin-top:5px;font-size:20px;">Bidones 8L: <?php echo $cliente->getInactividad()->getDescartables()->getBidon8L();?></p>
<?php } ?>

<?php if($cliente->getInactividad()->getDescartables()->getBidon5L()>0) {?>
<p style="margin-top:5px;font-size:20px;">Bidones 5L: <?php echo $cliente->getInactividad()->getDescartables()->getBidon5L();?></p>
<?php } ?>

<?php if($cliente->getInactividad()->getDescartables()->getPackBotellas2L()>0) {?>
<p style="margin-top:5px;font-size:20px;">Pack Botellas 2L: <?php echo $cliente->getInactividad()->getDescartables()->getPackBotellas2L();?></p>
<?php } ?>

<?php if($cliente->getInactividad()->getDescartables()->getPackBotellas500mL()>0) {?>
<p style="margin-top:5px;font-size:20px;">Pack Botellas 500mL: <?php echo $cliente->getInactividad()->getDescartables()->getPackBotellas500mL();?></p>
<?php } ?>

<?php } ?>

<br>
