



<script type="text/javascript">
  function mostrarEntregasVertedores()
  {
  if(document.getElementById("divEntregasVertedores").style.display == "block")
    document.getElementById("divEntregasVertedores").style.display = "none";
  else
    document.getElementById("divEntregasVertedores").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarEntregasVertedores()" style="font-size:20px">Entregas Vertedores</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divEntregasVertedores">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Entregas Vertedores</h3>
  </div>
  <br>
  <p style="font-size:20px">Número de Entregas: <?php echo $diaRepartidor->getEntregasVertedores()->getSize(); ?></p>
  <br>

  <script type="text/javascript">
  function itemClickEntregaVertedor(indice){
  }
  </script>
  <?php
  if($diaRepartidor->getEntregasVertedores()->getSize()>0)
    {
    $items = $diaRepartidor->getEntregasVertedores()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "entregavertedor";
    $nombreClick = "EntregaVertedor";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
