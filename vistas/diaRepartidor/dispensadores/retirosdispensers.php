



<script type="text/javascript">
  function mostrarRetirosDispensers()
  {
  if(document.getElementById("divRetirosDispensers").style.display == "block")
    document.getElementById("divRetirosDispensers").style.display = "none";
  else
    document.getElementById("divRetirosDispensers").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarRetirosDispensers()" style="font-size:20px">Retiros Dispensers</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divRetirosDispensers">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Retiros Dispensers</h3>
  </div>
  <br>
  <p style="font-size:20px">Número de Retiros: <?php echo $diaRepartidor->getRetirosDispensers()->getSize(); ?></p>
  <br>

  <script type="text/javascript">
  function itemClickRetiroDispenser(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getRetirosDispensers()->getSize()>0)
    {
    $items = $diaRepartidor->getRetirosDispensers()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "retirodispenser";
    $nombreClick = "RetiroDispenser";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
