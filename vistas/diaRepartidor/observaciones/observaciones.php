



<script type="text/javascript">
  function mostrarObservaciones()
  {
  if(document.getElementById("divObservaciones").style.display == "block")
    document.getElementById("divObservaciones").style.display = "none";
  else
    document.getElementById("divObservaciones").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarObservaciones()" style="font-size:20px">Observaciones</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divObservaciones">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Observaciones Clientes</h3>
  </div>

  <br>
  <p style="font-size:20px">Número de Observaciones: <?php echo $diaRepartidor->getObservaciones()->getSize(); ?></p>
  <br>



  <script type="text/javascript">
  function itemClickObservacion(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getObservaciones()->getSize()>0)
    {
    $items = $diaRepartidor->getObservaciones()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "observacion";
    $nombreClick = "Observacion";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
