

<script type="text/javascript">
  function mostrarDinero()
  {
  if(document.getElementById("divDineroDia").style.display == "block")
    document.getElementById("divDineroDia").style.display = "none";
  else
    document.getElementById("divDineroDia").style.display = "block";
  }
</script>
<div class="" style="margin:50px;">
  <button class="btn-link buttonLink"  onclick="mostrarDinero()" style="font-size:20px">Dinero Día</button>
</div>

<div class="row borde" style="margin:50px;padding:50px" id="divDineroDia">

  <div class="text-center" style="width:500px;margin-bottom:45px">
    <h3 class="subtitulo">Dinero del Dia</h3>
  </div>

  <div class="">
    <br>
    <p style="font-size:20px">Dinero Total Recaudado: <?php echo $diaRepartidor->getDineroTotalRecaudado(); ?></p>
    <br>
    <p style="font-size:20px">Dinero Ventas: <?php echo $diaRepartidor->getDineroVentas(); ?></p>
    <br>
    <p style="font-size:20px">Dinero Total de Pagos: <?php echo $diaRepartidor->getDineroPagos(); ?></p>
    <br>
    <p style="font-size:20px">Dinero Pagos Alquiler: <?php echo  $diaRepartidor->getDineroPagosAlquiler(); ?></p>
    <br>
    <p style="font-size:20px">Dinero Pagos Deuda Productos: <?php echo $diaRepartidor->getDineroPagosDeudaProductos(); ?></p>
    <br>
    <p style="font-size:20px">Dinero Ventas Vertedores: <?php echo $diaRepartidor->getVentasVertedores()->getDinero(); ?></p>
    <br>
    <p style="font-size:20px">Dinero Ventas Dispensers: <?php echo $diaRepartidor->getVentasDispensers()->getDinero(); ?></p>
    <br>
    <p style="font-size:20px">Dinero Gastos: <?php echo $diaRepartidor->getDineroGastos(); ?></p>
    <br>
    <p style="font-size:20px;color:rgb(255, 184, 77)">Dinero a Presentar: <?php echo $diaRepartidor->getDineroAPresentar(); ?></p>
    <br>

  </div>






</div>
