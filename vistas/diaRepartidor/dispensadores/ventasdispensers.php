



<script type="text/javascript">
  function mostrarVentasDispensers()
  {
  if(document.getElementById("divVentasDispensers").style.display == "block")
    document.getElementById("divVentasDispensers").style.display = "none";
  else
    document.getElementById("divVentasDispensers").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarVentasDispensers()" style="font-size:20px">Ventas Dispensers</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divVentasDispensers">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Ventas Dispensers</h3>
  </div>
  <br>
  <p style="font-size:20px">Número de Ventas: <?php echo $diaRepartidor->getVentasDispensers()->getSize(); ?></p>
  <br>

  <script type="text/javascript">
  function itemClickVentaDispenser(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getVentasDispensers()->getSize()>0)
    {
    $items = $diaRepartidor->getVentasDispensers()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "ventadispenser";
    $nombreClick = "VentaDispenser";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
