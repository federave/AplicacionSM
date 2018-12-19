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
          <h4 class="titulo">Buscar Clientes</h4>
        </div>
      </div>



      <div class="row" style="margin-left:10%;margin-right:10%;width:80%">
        <?php
        $tituloBusqueda = "IdCliente";
        $anchoElemento = 300;
        $altoLista = 300;
        $linkSeleccionar = '../../controladores/verClientes/verCliente.php';
        require 'buscadorClienteId.php';
        ?>
      </div>



      <div class="row" style="margin-top:100px;margin-left:10%;margin-right:10%;width:80%">
        <?php
        $tituloBusqueda = "Nombre, Apellido o Telefono";
        $anchoElemento = 300;
        $altoLista = 300;
        $linkSeleccionar = '../../controladores/verClientes/verCliente.php';
        require 'buscadorCliente.php';
        ?>
      </div>


      <div class="row" style="margin-top:100px;margin-left:10%;margin-right:10%;width:80%">
        <?php
        $tituloBusqueda = "Calle";
        $anchoElemento = 300;
        $altoLista = 300;
        $linkSeleccionar = '../../controladores/verClientes/verCliente.php';
        require 'buscadorClienteCalle.php';
        ?>
      </div>

      <div class="row" style="margin-top:100px;margin-left:10%;margin-right:10%;width:80%">
        <?php
        $tituloBusqueda = "Numero";
        $anchoElemento = 300;
        $altoLista = 300;
        $linkSeleccionar = '../../controladores/verClientes/verCliente.php';
        require 'buscadorClienteNumero.php';
        ?>
      </div>


    </body>

</html>
