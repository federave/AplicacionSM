



<script type="text/javascript">
  function mostrarVentasVertedores()
  {
  if(document.getElementById("divVentasVertedores").style.display == "block")
    document.getElementById("divVentasVertedores").style.display = "none";
  else
    document.getElementById("divVentasVertedores").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarVentasVertedores()" style="font-size:20px">Ventas Vertedores</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divVentasVertedores">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Ventas Vertedores</h3>
  </div>
  <br>
  <p style="font-size:20px">Número de Ventas: <?php echo $diaRepartidor->getVentasVertedores()->getSize(); ?></p>
  <br>

  <script type="text/javascript">
  function itemClickVentaVertedor(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getVentasVertedores()->getSize()>0)
    {
    $items = $diaRepartidor->getVentasVertedores()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "ventavertedor";
    $nombreClick = "VentaVertedor";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
