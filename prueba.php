
<html lang="es">


    <head>
        <title>Saint Michel</title>
        </head>


    <style type="text/css">

    *{box-sizing: border-box;}


    body
      {
      /* width: 100%; */
      }

    .contenedor
      {
      width:100%;
      margin:5px;
      padding:50px;
      }

    .tabla
      {
      width: 100%;
      height: 500px;
      overflow:auto;
      }

    .row:after
      {
      content: "";
      display: table;
      clear: both;
      }

    .fila
      {
      height: 50px;
      width: 2000px;
      }

    .borde
      {
      border-style: solid;
      border-width: 1px;
      border-collapse: collapse;
      }
    .fuente
      {
      font-family: "Segoe Print";
      font-size: 15px;
      }
    .fuente.borde.columna
      {
      height: 100%;
      float: left;
      border-style: solid;
      border-width: 1px;
      border-collapse: collapse;
      }
    .fuente.borde.columna.columnaCabezera
      {
      width: 500px;
      border-width: 3px;
      }

    .columnaPrueba
      {
      width: 500px;
      background-color: yellow;
      }




    .fuente.input
      {
      height: 100%;
      width: 100%;
      margin: 0px;
      padding: 0px;
      }

    .fuente.input.color
      {
      background-color:transparent;
      }
    .fuente.tituloTabla
      {
      text-align: center;
      }
    .filaTitulo
      {
      height: 65px;
      width: 100%;
      }

    </style>


    <body id="cuerpo" >


      <div class="contenedor">


        <div class="tabla borde">

          <div class="row filaTitulo">

            <h3 class="fuente tituloTabla">Titulo</h3>

          </div>

          <div class="row fila">

            <div class="fuente borde columna columnaCabezera">


            </div>

            <div class="fuente borde columna columnaPrueba">
              <input type="text"  class="input fuente" name="" value="">

            </div>

            <div class="fuente borde columna columnaPrueba">
            </div>

            <div class="fuente borde columna columnaPrueba">
            </div>


          </div>

          <div class="row fila">

            <div class="fuente borde columna columnaPrueba">
            </div>

            <div class="fuente borde columna columnaPrueba">
            </div>

            <div class="fuente borde columna columnaPrueba">
            </div>

          </div>







        </div>




      </div>



    </body>

</html>
