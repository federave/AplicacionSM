


<script type="text/javascript">
  function mostrarDeudasProductos()
  {
  if(document.getElementById("divDeudasProductos").style.display == "block")
    document.getElementById("divDeudasProductos").style.display = "none";
  else
    document.getElementById("divDeudasProductos").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarDeudasProductos()" style="font-size:20px">Deudas Productos</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divDeudasProductos">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Deudas Productos del Día</h3>
  </div>

  <br>
  <p style="font-size:20px">Número de Deudas Productos: <?php echo $diaRepartidor->getDeudasProductos()->getSize(); ?></p>
  <br>



  <script type="text/javascript">
  function itemClickDeudaProducto(indice){
  var nombre = "deudaProducto" + indice;
  if(document.getElementById(nombre).style.display == "block")
    document.getElementById(nombre).style.display = "none"
  else
    document.getElementById(nombre).style.display = "block";
  }
  </script>
  <?php
  if($diaRepartidor->getDeudasProductos()->getSize()>0)
    {
    $items = $diaRepartidor->getDeudasProductos()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "deudaProducto";
    $nombreClick = "DeudaProducto";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
