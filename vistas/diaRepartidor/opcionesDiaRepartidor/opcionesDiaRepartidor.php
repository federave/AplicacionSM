
<h4 style="text-align:center">Opciones</h4>
<br>


<?php if(isset($_SESSION["DiaRepartidor"])) {?>
  <div id="divMenuOpciones" style="display:block">
<?php } else{ ?>
  <div id="divMenuOpciones" style="display:none">
<?php } ?>


  <div>
    <button class="btn btn-link" style="font-size: 17px;" role="button" onclick="mostrarCargarDiaTablet()">Cargar Dia en Tablet</button >
  </div>

  <div class="">
    <button class="btn btn-link" style="font-size: 17px;" role="button" onclick="mostrarRecibirDiaTablet()">Recibir Dia de Tablet</button >
  </div>

  <div class="">

    <form class="" action="controladores/diaRepartidor/mostrarCompletarPlanilla.php" method="post">
      <input type="submit" name="" value="Completar Dia" class="btn btn-link" style="font-size: 17px;">

      <input type="hidden" name="idRepartidor_seleccionado" id="idRepartidor_seleccionado" value=<?php if(isset($_SESSION["DiaRepartidor"])) echo $_SESSION["DiaRepartidor"]->getRepartidor()->getId(); else echo "";?>>
      <input type="hidden" name="fecha_seleccionado" id="fecha_seleccionado" value=<?php if(isset($_SESSION["DiaRepartidor"]))echo $_SESSION["DiaRepartidor"]->getFecha(); else echo "";?>>


    </form>

  </div>

  <div class="">
    <button class="btn btn-link" style="font-size: 17px;" role="button" onclick="mostrarResumenDia()">Resumen del Dia </button >
  </div>

</div>



  <div id="divInfoOpciones" style = <?php if(isset($_SESSION["DiaRepartidor"])){if ($_SESSION["DiaRepartidor"]->getDiaCreado()) echo "display:none";}?> >
    <p id="infoOpciones">Debe seleccionar el reparto</p>
  </div>


  <script>

  function mostrarCargarDiaTablet(){}

  function mostrarRecibirDiaTablet(){}

  function mostrarCompletarDia(){}

  function mostrarResumenDia()
  {
  }

  function respuestaMostrarResumenDia()
  {
  }





  </script>
