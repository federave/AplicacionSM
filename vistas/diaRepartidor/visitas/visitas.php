


<script type="text/javascript">
  function mostrarDetalleVisitas()
  {
  if(document.getElementById("divDetalleVisitas").style.display == "block")
    document.getElementById("divDetalleVisitas").style.display = "none";
  else
    document.getElementById("divDetalleVisitas").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarDetalleVisitas()" style="font-size:20px">Detalle Visitas</button>
</div>



<div class="row borde" style="margin:50px;padding:50px" id="divDetalleVisitas">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Detalles Visitas</h3>
  </div>


  <script type="text/javascript">
  function itemClickVisita(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getVisitas()->getSize()>0)
    {
    $items = $diaRepartidor->getVisitas()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "visita";
    $nombreClick = "Visita";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
