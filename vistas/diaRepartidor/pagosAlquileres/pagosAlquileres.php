
<script type="text/javascript">
  function mostrarPagosAlquileres()
  {
  if(document.getElementById("divPagosAlquileres").style.display == "block")
    document.getElementById("divPagosAlquileres").style.display = "none";
  else
    document.getElementById("divPagosAlquileres").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarPagosAlquileres()" style="font-size:20px">Pagos Alquileres</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divPagosAlquileres">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Pagos Alquileres</h3>
  </div>

  <br>
  <p style="font-size:20px">Número de Pagos: <?php echo $diaRepartidor->getPagosAlquileres()->getSize(); ?></p>
  <br>



  <script type="text/javascript">
  function itemClickPagoAlquiler(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getPagosAlquileres()->getSize()>0)
    {
    $items = $diaRepartidor->getPagosAlquileres()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "pagoAlquiler";
    $nombreClick = "PagoAlquiler";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
