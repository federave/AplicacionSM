<?php
include_once('../../../modelo/trabajadores/repartidores.php');
?>


<html lang="es">
    <head>
        <title>Saint Michel</title>
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../css/general.css">

    </head>

    <body id="cuerpo">


      <div class="container" style="width:400px">

        <div class="text-center" style="margin-top:50px;margin-bottom:20px">
          <h4 class="subtitulo">Seleccionar Dia Repartidor</h4>
        </div>


        <?php
        if(isset($_GET["mensaje"]))
          {
          $mensaje = $_GET["mensaje"];
          $ancho = "250px";
          require '../mensaje.php';
          }
        ?>
        <div class="" style="padding-top:50px;padding-left:80px">
          <form class="form-signin" action="../../../controladores/diaRepartidor/seleccionarDiaRepartidor/seleccionarDiaRepartidor.php" method="post">

            <input  type="hidden" id="seleccionarDiaRepartidor" name ="seleccionarDiaRepartidor" value="1">

            <label for="idRepartidor" style="text-align: center;">Repartidores</label>
            <select class="form-control" id="idRepartidor" name="idRepartidor" style="width:200px;font-size:19px">
              <?php

              $repartidores = new Repartidores();
              $k=0;
              while($k<$repartidores->getNumeroRepartidores())
                  {
                  ?>
                  <option value=<?php echo $repartidores->getRepartidor($k)->getId() ?> >
                    <?php echo $repartidores->getRepartidor($k)->getNombre() . " " . $repartidores->getRepartidor($k)->getApellido() ?>
                  </option>
                <?php
                  $k++;
                  }
              ?>
            </select>
            <label for="fecha" style="margin-top:20px;" >Fecha</label>
            <input  class="form-control" style="width:200px;font-size:19px" type="date" id="fecha" name ="fecha">
            <input type="submit" class="btn btn-lg btn-primary btn-block" style="margin-top:30px;width:200px;font-size:22px" value="Seleccionar"> <!-- onclick="seleccionarReparto()" -->
          </form>
        </div>




    </div>


    </body>

</html>
