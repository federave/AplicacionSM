



<script type="text/javascript">
  function mostrarCambiosDispensers()
  {
  if(document.getElementById("divCambiosDispensers").style.display == "block")
    document.getElementById("divCambiosDispensers").style.display = "none";
  else
    document.getElementById("divCambiosDispensers").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarCambiosDispensers()" style="font-size:20px">Cambios Vertedores</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divCambiosDispensers">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Cambios Dispensers</h3>
  </div>
  <br>
  <p style="font-size:20px">Número de Cambios: <?php echo $diaRepartidor->getCambiosDispensers()->getSize(); ?></p>
  <br>

  <script type="text/javascript">
  function itemClickCambioDispenser(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getCambiosDispensers()->getSize()>0)
    {
    $items = $diaRepartidor->getCambiosDispensers()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "cambiodispenser";
    $nombreClick = "CambioDispenser";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
