
<div class="column" style="margin-top:80px;margin-left:50px;">

  <div class="" style="margin-bottom:25px">
    <h3 class="subtitulo">Balance Repartos (Resultado = Cargado - Repartido - Descargado)</h3>
  </div>
 <br>

 <div id="divBalanceRepartos">
   <p style="font-size:22px">Bidones 20L = <?php echo $diaRepartidor->getBalanceBidones20L(); ?></p>
   <p style="font-size:22px">Bidones 12L = <?php echo $diaRepartidor->getBalanceBidones12L(); ?></p>
   <p style="font-size:22px">Bidones 10L = <?php echo $diaRepartidor->getBalanceBidones10L(); ?></p>
   <p style="font-size:22px">Bidones 8L = <?php echo $diaRepartidor->getBalanceBidones8L(); ?></p>
   <p style="font-size:22px">Bidones 5L = <?php echo $diaRepartidor->getBalanceBidones5L(); ?></p>
   <p style="font-size:22px">Pack Botellas 2L = <?php echo $diaRepartidor->getBalancePackBotellas2L(); ?></p>
   <p style="font-size:22px">Pack Botellas 500mL = <?php echo $diaRepartidor->getBalancePackBotellas500mL(); ?></p>
 </div>



</div>
