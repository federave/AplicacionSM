<?php
include_once('../../modelo/diaRepartidor/diaRepartidor.php');
include_once('../../modelo/diaRepartidor/viejo/include.php');

session_start();
$diaRepartidor = $_SESSION["DiaRepartidor"];
?>



<html lang="es">
    <head>
        <title>Saint Michel</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/general.css">
        <link rel="stylesheet" href="../diaRepartidor/completarDia/completarDia.css">
        <link rel="stylesheet" href="../diaRepartidor/completarDia/tabla/tabla.css">
    </head>

    <body id="cuerpo">




          <script type="text/javascript">

          function actualizarBalances(balance)
          {


            if (window.DOMParser)
              {
              parser = new DOMParser();
              xmlDoc = parser.parseFromString(balance.target.responseText, "text/xml");
              }
            else // Internet Explorer
              {
              xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
              xmlDoc.async = false;
              xmlDoc.loadXML(balance.target.responseText);
              }

            if(xmlDoc.getElementsByTagName("Estado")[0].childNodes[0].nodeValue)
              {

              var pBidones20L = document.createElement("p");
              pBidones20L.setAttribute("style","font-size:22px");
              pBidones20L.innerHTML = "Bidones 20L: " + xmlDoc.getElementsByTagName("Bidones20L")[0].childNodes[0].nodeValue;

              var pBidones12L = document.createElement("p");
              pBidones12L.setAttribute("style","font-size:22px");
              pBidones12L.innerHTML = "Bidones 12L: " + xmlDoc.getElementsByTagName("Bidones12L")[0].childNodes[0].nodeValue;

              var pBidones10L = document.createElement("p");
              pBidones10L.setAttribute("style","font-size:22px");
              pBidones10L.innerHTML = "Bidones 10L: " + xmlDoc.getElementsByTagName("Bidones10L")[0].childNodes[0].nodeValue;

              var pBidones8L = document.createElement("p");
              pBidones8L.setAttribute("style","font-size:22px");
              pBidones8L.innerHTML = "Bidones 8L: " + xmlDoc.getElementsByTagName("Bidones8L")[0].childNodes[0].nodeValue;

              var pBidones5L = document.createElement("p");
              pBidones5L.setAttribute("style","font-size:22px");
              pBidones5L.innerHTML = "Bidones 5L: " + xmlDoc.getElementsByTagName("Bidones5L")[0].childNodes[0].nodeValue;

              var pPackBotellas2L = document.createElement("p");
              pPackBotellas2L.setAttribute("style","font-size:22px");
              pPackBotellas2L.innerHTML = "Pack Botellas 2L: " + xmlDoc.getElementsByTagName("PackBotellas2L")[0].childNodes[0].nodeValue;

              var pPackBotellas500mL = document.createElement("p");
              pPackBotellas500mL.setAttribute("style","font-size:22px");
              pPackBotellas500mL.innerHTML = "Pack Botellas 500mL: " + xmlDoc.getElementsByTagName("PackBotellas500mL")[0].childNodes[0].nodeValue;

              document.getElementById("divBalanceRepartos").innerHTML = "";
              document.getElementById("divBalanceRepartos").appendChild(pBidones20L);
              document.getElementById("divBalanceRepartos").appendChild(pBidones12L);
              document.getElementById("divBalanceRepartos").appendChild(pBidones10L);
              document.getElementById("divBalanceRepartos").appendChild(pBidones8L);
              document.getElementById("divBalanceRepartos").appendChild(pBidones5L);
              document.getElementById("divBalanceRepartos").appendChild(pPackBotellas2L);
              document.getElementById("divBalanceRepartos").appendChild(pPackBotellas500mL);

              var pBidones20LVacios = document.createElement("p");
              pBidones20LVacios.setAttribute("style","font-size:22px");
              pBidones20LVacios.innerHTML = "Bidones 20L: " + xmlDoc.getElementsByTagName("Bidones20LVacios")[0].childNodes[0].nodeValue;

              var pBidones12LVacios = document.createElement("p");
              pBidones12LVacios.setAttribute("style","font-size:22px");
              pBidones12LVacios.innerHTML = "Bidones 12L: " + xmlDoc.getElementsByTagName("Bidones12LVacios")[0].childNodes[0].nodeValue;


              document.getElementById("divBalanceVacios").innerHTML = "";
              document.getElementById("divBalanceVacios").appendChild(pBidones20LVacios);
              document.getElementById("divBalanceVacios").appendChild(pBidones12LVacios);


              }


          }


          </script>


    <div class="cointainer" id="DiaRepartidor">

      <!-- Titulo Dia Repartidor -->
      <div style="padding:50px" class="text-center">
        <h1 class="titulo">Dia Repartidor</h1>
      </div>

      <!-- Datos Generales Dia Repartidor -->

      <?php require 'datosGenerales/datosGenerales.php'; ?>



      <!-- Dinero -->

      <?php require 'dinero/dinero.php'; ?>

      <!-- Datos Clientes Visitados -->

      <?php require 'visitas/datosVisitas.php'; ?>


      <!-- Repartos -->

      <?php require 'repartos/repartos.php'; ?>


      <!-- Balances  -->

      <?php require 'balances/balances.php'; ?>








      <!-- Planilla del Dia -->

      <?php require 'completarDia/completarDia.php'; ?>




      <!-- Clientes Fuera de Recorrido -->

      <?php require 'clientesFueraDeRecorrido/clientesFueraDeRecorrido.php'; ?>






      <!-- Cargas -->

      <?php require 'cargamento/cargas/cargas.php'; ?>

      <!-- Descargas -->

      <?php require 'cargamento/descargas/descargas.php'; ?>

      <!-- Pagos Alquileres -->

      <?php require 'pagosAlquileres/pagosAlquileres.php'; ?>

      <!-- Gastos -->

      <?php require 'gastos/gastos.php'; ?>

      <!-- Deudas Productos -->

      <?php require 'deudas/deudasProductos.php'; ?>

      <!-- Observaciones -->

      <?php require 'observaciones/observaciones.php'; ?>

      <!-- Detalle Visitas -->

      <?php require 'visitas/visitas.php'; ?>









    </div>

    <footer style="height:500px"></footer>

  </body>
</html>
