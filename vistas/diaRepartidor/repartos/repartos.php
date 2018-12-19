






<script type="text/javascript">
  function mostrarProductosRepartidos()
  {
  if(document.getElementById("divProductosRepartidos").style.display == "block")
    document.getElementById("divProductosRepartidos").style.display = "none";
  else
    document.getElementById("divProductosRepartidos").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink" onclick="mostrarProductosRepartidos()" style="font-size:20px">Productos Repartidos</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divProductosRepartidos">

  <div class="text-center" style="width:100%;margin-bottom:25px">
    <h3 class="subtitulo">Productos Repartidos</h3>
  </div>



  <div class="row">

    <div class="column" style="width:17%;margin-top:50px;margin-left:25px">

      <p style="font-size:22px">Total Repartido</p>
      <br>
      <br>
      <p style="font-size:20px">Bidones 20L: <?php echo $diaRepartidor->getRetornablesRepartidos()->getBidon20L(); ?></p>
      <p style="font-size:20px">Bidones 12L: <?php echo $diaRepartidor->getRetornablesRepartidos()->getBidon12L(); ?></p>
      <p style="font-size:20px">Bidones 10L: <?php echo $diaRepartidor->getDescartablesRepartidos()->getBidon10L(); ?></p>
      <p style="font-size:20px">Bidones 8L: <?php echo $diaRepartidor->getDescartablesRepartidos()->getBidon8L(); ?></p>
      <p style="font-size:20px">Bidones 5L: <?php echo $diaRepartidor->getDescartablesRepartidos()->getBidon5L(); ?></p>
      <p style="font-size:20px">Pack Botellas 2L: <?php echo $diaRepartidor->getDescartablesRepartidos()->getPackBotellas2L(); ?></p>
      <p style="font-size:20px">Pack Botellas 500mL: <?php echo $diaRepartidor->getDescartablesRepartidos()->getPackBotellas500mL(); ?></p>

    </div>


    <div class="column " style="width:17%;margin-top:50px;margin-left:25px">

      <p style="font-size:22px">Total Vendido</p>
      <br>
      <br>
      <p style="font-size:20px">Bidones 20L: <?php echo $diaRepartidor->getRetornablesVendidos()->getBidon20L(); ?></p>
      <p style="font-size:20px">Bidones 12L: <?php echo $diaRepartidor->getRetornablesVendidos()->getBidon12L(); ?></p>
      <p style="font-size:20px">Bidones 10L: <?php echo $diaRepartidor->getDescartablesVendidos()->getBidon10L(); ?></p>
      <p style="font-size:20px">Bidones 8L: <?php echo $diaRepartidor->getDescartablesVendidos()->getBidon8L(); ?></p>
      <p style="font-size:20px">Bidones 5L: <?php echo $diaRepartidor->getDescartablesVendidos()->getBidon5L(); ?></p>
      <p style="font-size:20px">Pack Botellas 2L: <?php echo $diaRepartidor->getDescartablesVendidos()->getPackBotellas2L(); ?></p>
      <p style="font-size:20px">Pack Botellas 500mL: <?php echo $diaRepartidor->getDescartablesVendidos()->getPackBotellas500mL(); ?></p>

    </div>

    <div class="column " style="width:17%;margin-top:50px;margin-left:25px">

      <p style="font-size:22px">Total Alquiler</p>
      <br>
      <br>
      <p style="font-size:20px">Bidones 20L: <?php echo $diaRepartidor->getRetornablesAlquiler()->getBidon20L(); ?></p>
      <p style="font-size:20px">Bidones 12L: <?php echo $diaRepartidor->getRetornablesAlquiler()->getBidon12L(); ?></p>

    </div>


    <div class="column " style="width:17%;margin-top:50px;margin-left:25px">

      <p style="font-size:22px">Total Bonificado</p>
      <br>
      <br>
      <p style="font-size:20px">Bidones 20L: <?php echo $diaRepartidor->getRetornablesBonificados()->getBidon20L(); ?></p>
      <p style="font-size:20px">Bidones 12L: <?php echo $diaRepartidor->getRetornablesBonificados()->getBidon12L(); ?></p>
      <p style="font-size:20px">Bidones 10L: <?php echo $diaRepartidor->getDescartablesBonificados()->getBidon10L(); ?></p>
      <p style="font-size:20px">Bidones 8L: <?php echo $diaRepartidor->getDescartablesBonificados()->getBidon8L(); ?></p>
      <p style="font-size:20px">Bidones 5L: <?php echo $diaRepartidor->getDescartablesBonificados()->getBidon5L(); ?></p>
      <p style="font-size:20px">Pack Botellas 2L: <?php echo $diaRepartidor->getDescartablesBonificados()->getPackBotellas2L(); ?></p>
      <p style="font-size:20px">Pack Botellas 500mL: <?php echo $diaRepartidor->getDescartablesBonificados()->getPackBotellas500mL(); ?></p>

    </div>

    <div class="column " style="width:17%;margin-top:50px;margin-left:25px">

      <p style="font-size:22px">Total Deudado</p>
      <br>
      <br>
      <p style="font-size:20px">Bidones 20L: <?php echo $diaRepartidor->getRetornablesDeudados()->getBidon20L(); ?></p>
      <p style="font-size:20px">Bidones 12L: <?php echo $diaRepartidor->getRetornablesDeudados()->getBidon12L(); ?></p>
      <p style="font-size:20px">Bidones 10L: <?php echo $diaRepartidor->getDescartablesDeudados()->getBidon10L(); ?></p>
      <p style="font-size:20px">Bidones 8L: <?php echo $diaRepartidor->getDescartablesDeudados()->getBidon8L(); ?></p>
      <p style="font-size:20px">Bidones 5L: <?php echo $diaRepartidor->getDescartablesDeudados()->getBidon5L(); ?></p>
      <p style="font-size:20px">Pack Botellas 2L: <?php echo $diaRepartidor->getDescartablesDeudados()->getPackBotellas2L(); ?></p>
      <p style="font-size:20px">Pack Botellas 500mL: <?php echo $diaRepartidor->getDescartablesDeudados()->getPackBotellas500mL(); ?></p>

    </div>




  </div>






</div>
