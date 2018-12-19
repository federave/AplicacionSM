
<script type="text/javascript">
  function mostrarGastos()
  {
  if(document.getElementById("divGastos").style.display == "block")
    document.getElementById("divGastos").style.display = "none";
  else
    document.getElementById("divGastos").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarGastos()" style="font-size:20px">Gastos</button>
</div>


<div class="row borde" style="margin:50px;padding:50px" id="divGastos">

  <div class="text-center" style="width:500px;margin-bottom:25px">
    <h3>Gastos del Dia</h3>
  </div>

  <br>
  <p style="font-size:20px">Dinero total gastado: <?php echo $diaRepartidor->getGastos()->getDinero(); ?></p>
  <br>
  <p style="font-size:20px">Numero de gastos: <?php echo $diaRepartidor->getGastos()->getSize(); ?></p>
  <br>



  <script type="text/javascript">
  function itemClickGasto(indice){alert("aaaaa");}
  </script>
  <?php
  if($diaRepartidor->getGastos()->getSize()>0)
    {
    $items = $diaRepartidor->getGastos()->getItems();
    $ancho = 500;
    $alto = 300;
    $nombre = "gasto";
    $nombreClick = "Gasto";
    $eliminar = false;
    require '../componentes/vistaLista.php';
    }
  ?>


</div>
