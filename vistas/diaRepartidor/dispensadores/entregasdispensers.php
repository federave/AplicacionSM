



<script type="text/javascript">
  function mostrarEntregasDispensers()
  {
  if(document.getElementById("divEntregasDispensers").style.display == "block")
    document.getElementById("divEntregasDispensers").style.display = "none";
  else
    document.getElementById("divEntregasDispensers").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarEntregasDispensers()" style="font-size:20px">Entregas Vertedores</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divEntregasDispensers">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Entregas Dispensers</h3>
  </div>
  <br>
  <p style="font-size:20px">Número de Entregas: <?php echo $diaRepartidor->getEntregasDispensers()->getSize(); ?></p>
  <br>

  <script type="text/javascript">
  function itemClickEntregaDispenser(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getEntregasDispensers()->getSize()>0)
    {
    $items = $diaRepartidor->getEntregasDispensers()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "entregadispenser";
    $nombreClick = "EntregaDispenser";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
