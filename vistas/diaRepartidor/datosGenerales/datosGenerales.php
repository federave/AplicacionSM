



<div class="row borde" style="margin:50px;padding:50px">

  <div class="row" style="">
    <h3 class="subtitulo">Datos Generales del Día</h3>
  </div>

  <div class="row" style="margin-top:35px;">

    <div class="column" style="margin-left:0px">
      <h4 style="text-align:center">Repartidor</h4>
      <br>
      <p id="DR_Nombre" >Nombre: <?php echo " " . $diaRepartidor->getRepartidor()->getNombre();?></p>
      <p id="DR_Apellido" >Apellido:<?php echo " " . $diaRepartidor->getRepartidor()->getApellido();?></p>
    </div>

    <div class="column" style="margin-left:80px">
      <h4 style="text-align:center">Datos del Día</h4>
      <br>
      <p id="DR_Fecha" >Fecha:<?php echo " " . $diaRepartidor->getFecha();?></p>
      <p id="DR_DiaCreado">Dia Creado:<?php if ($diaRepartidor->getDiaCreado()) echo " si"; else echo " no";?></p>
      <p id="DR_DiaCompletado">Dia Completado:<?php if ($diaRepartidor->getDiaCompletado()) echo " si"; else echo " no";?></p>
    </div>

    <div class="column" style="margin-left:80px">
      <!-- style="margin-right:100px;float:right;margin-top:10px"> -->
      <h4 style="text-align:center">Actualizar Datos del Día</h4>
      <br>
      <form class="form-signin" action="../../controladores/diaRepartidor/seleccionarDiaRepartidor/seleccionarDiaRepartidor.php" method="post">

        <input  type="hidden" id="seleccionarDiaRepartidor" name ="seleccionarDiaRepartidor" value="1">
        <input  type="hidden" id="idRepartidor" name ="idRepartidor" value=<?php echo $diaRepartidor->getRepartidor()->getId();?>>
        <input  type="hidden" id="fecha" name ="fecha" value=<?php echo $diaRepartidor->getFecha();?>>
        <input type="submit" class="btn btn-lg btn-primary btn-block" style="margin-top:5px;width:200px" value="Actualizar"> <!-- onclick="seleccionarReparto()" -->
      </form>
    </div>

  </div>

</div>
