<h3 class="subtitulo" style="margin-bottom:30px;">Dirección</h3>

<p style="margin-top:5px;font-size:20px;">IdDireccion: <?php echo $cliente->getDireccion()->getId();?></p>
<p style="margin-top:5px;font-size:20px;">Direccion: <?php echo $cliente->getDireccion()->toString();?></p>

<h3 class="subtitulo" style="margin-top:50px;margin-bottom:30px;">Bidones DispenserFC</h3>

<p style="margin-top:5px;font-size:20px;">Bidones 20L: <?php echo $cliente->getBidonesDispenserFC()->getRetornables()->getBidon20L();?></p>
<p style="margin-top:5px;font-size:20px;">Bidones 12L: <?php echo $cliente->getBidonesDispenserFC()->getRetornables()->getBidon12L();?></p>
<p style="margin-top:5px;font-size:20px;">Dispenser FC: <?php echo $cliente->getBidonesDispenserFC()->getDispenserFC();?></p>
