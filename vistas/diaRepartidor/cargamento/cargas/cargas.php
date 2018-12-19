<script type="text/javascript">
  function mostrarCargas()
  {
  if(document.getElementById("divCargas").style.display == "block")
    document.getElementById("divCargas").style.display = "none";
  else
    document.getElementById("divCargas").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarCargas()" style="font-size:20px">Cargas</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divCargas">


  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Cargas</h3>
  </div>



  <div class="row">

    <div class="column" style="width:550px;">
      <br>
      <p style="font-size:20px">Numero de cargas: <?php echo $diaRepartidor->getCargamento()->getCargas()->getSize(); ?></p>
      <br>
    </div>

    <?php if ($diaRepartidor->getCargamento()->getCargas()->getSize()>0) { ?>

    <div class="column" style="margin-left:20px;">
      <br>
      <p style="font-size:20px">Total Cargado</p>
      <br>
    </div>

    <?php } ?>


  </div>



  <?php if ($diaRepartidor->getCargamento()->getCargas()->getSize()>0) { ?>

  <div class="row">


    <div class="column" style="width:550px;">
      <script type="text/javascript">
      function itemClickCarga(indice)
      {
      var nombre = "carga" + indice;
      if(document.getElementById(nombre).style.display == "block")
        document.getElementById(nombre).style.display = "none"
      else
        document.getElementById(nombre).style.display = "block";
      }
      </script>

      <?php
        $items = $diaRepartidor->getCargamento()->getCargas()->getItems();
        $ancho = 500;
        $alto = 300;
        $nombre = "carga";
        $nombreClick = "Carga";
        $eliminar = false;
        require '../componentes/vistaLista.php';
      ?>
    </div>

    <div class="column borde" style="margin-left:20px;padding:20px">

      <div class="text-center" style="font-size:18px;">
        <?php echo $diaRepartidor->getCargamento()->getCargas()->toString(); ?>
      </div>

    </div>

  </div>

  <?php } ?>


</div>
