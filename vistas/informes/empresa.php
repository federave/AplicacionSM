
<?php
include_once('../../modelo/trabajadores/repartidores.php');
?>

<html lang="es">
    <head>
        <title>Saint Michel</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../css/general.css">
        <script src="../javascript/lista.js"></script>

    </head>

    <body id="cuerpo">



      <div class="row" style="margin:3%;width:94%">
        <div class="text-center" style="">
          <h4 class="titulo">Empresa</h4>
        </div>
      </div>



      <div class="row" style="margin-left:10%;margin-right:10%;width:80%">


      <div class="text-center" style="width:40%;margin-bottom:45px">
        <h3>Informe de Ventas Empresa </h3>
      </div>




      <div class="column borde" style="width:40%">

            <form target="_blank" action="informeEmpresa.php" method="get" >


            <div class="row" style="width:100%;height:80px;display:flex;align-items:center;">

              <div style="margin:auto">
                <span style="font-size:20px;">Seleccione Periodo</span>
              </div>

            </div>


            <div class="row" style="width:100%;height:100px;">

              <div class="column" style="margin-left:10%;width:40%;height:100%;display:flex;align-items:center;">
                <div style="">
                  <div class="text-center" style="margin-bottom:10px">
                    <span style="font-size:17px;">Fecha de Inicio</span>
                  </div>
                  <div style="width:90%;margin-left:auto;margin-right:auto">
                    <input  class="form-control" style="width:100%;font-size:19px" type="date" id="fechaInicio" name="fechaInicio">
                  </div>
                </div>
              </div>

              <div class="column" style="margin-left:10%;width:40%;height:100%;display:flex;align-items:center;">
                <div style="">
                  <div class="text-center" style="margin-bottom:10px">
                    <span style="font-size:17px;">Fecha de Fin</span>
                  </div>
                  <div style="width:90%;margin-left:auto;margin-right:auto">
                    <input  class="form-control" style="width:100%;font-size:19px" type="date" id="fechaFin" name="fechaFin">
                  </div>
                </div>
              </div>
            </div>


            <div class="row" style="margin-bottom:40px; width:100%;height:80px;display:flex;align-items:center;">

              <div style="margin:auto">
                <input type="submit" class="btn btn-lg btn-success btn-block" style="margin-top:30px;width:200px;font-size:22px" value="Crear Informe"> <!-- onclick="seleccionarReparto()" -->
              </div>

            </div>


            </form>

      </div>














      </div>




    </body>

</html>
