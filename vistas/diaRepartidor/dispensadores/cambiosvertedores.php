



<script type="text/javascript">
  function mostrarCambiosVertedores()
  {
  if(document.getElementById("divCambiosVertedores").style.display == "block")
    document.getElementById("divCambiosVertedores").style.display = "none";
  else
    document.getElementById("divCambiosVertedores").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarCambiosVertedores()" style="font-size:20px">Cambios Vertedores</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divCambiosVertedores">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Cambios Vertedores</h3>
  </div>
  <br>
  <p style="font-size:20px">Número de Cambios: <?php echo $diaRepartidor->getCambiosVertedores()->getSize(); ?></p>
  <br>

  <script type="text/javascript">
  function itemClickCambioVertedor(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getCambiosVertedores()->getSize()>0)
    {
    $items = $diaRepartidor->getCambiosVertedores()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "cambiovertedor";
    $nombreClick = "CambioVertedor";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
