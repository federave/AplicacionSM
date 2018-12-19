<h3 class="subtitulo" style="margin-bottom:30px;">Reparto</h3>

<p style="margin-top:5px;font-size:20px;margin-bottom:30px;">Cliente Asignado a : <?php if ($cliente->getDatos()->getRepartidor()->getId() > 0) echo $cliente->getDatos()->getRepartidor()->toString(); else echo "Saint Michel";?></p>

<h3 class="subtitulo" style="margin-bottom:20px;font-size:20px;">Dias Reparto</h3>


<?php
$k=0;
while($k < $cliente->getDatos()->getNumeroDiasReparto())
  { ?>
  <p style="margin-top:5px;font-size:20px;"><?php echo $cliente->getDatos()->getDiaReparto($k);?></p>
<?php
  $k++;
  }
?>
