<?php
include_once('otros/otros.php');
include_once('modelo/conector.php');
include_once('modelo/diaRepartidor/diaRepartidor.php');



// redirect('prueba.php');





session_start();
if(!isset($_SESSION["id"]))
    {
    $_SESSION["id"] = "0";
    $_SESSION["conexion"] = false;
    }

if(isset($_SESSION["conexion"]))
  {
  if($_SESSION["conexion"] == false)
    {
    $conexion = new Conector();
    if($conexion->abrirConexion())
      {
      $_SESSION["conexion"] = true;
      $_SESSION["servidor"] = $conexion->getServidor();
      $_SESSION["usuario"] = $conexion->getUsuario();
      $_SESSION["contraseña"] = $conexion->getContraseña();
      }
    else
      {
      redirect("vistas/configuracion/configuracion.php");
      }
    }
  else
    {
    $conector = new Conector();
    $conector->setServidor($_SESSION["servidor"]);
    $conector->setUsuario($_SESSION["usuario"]);
    $conector->setContraseña($_SESSION["contraseña"]);

     if(!$conector->abrirConexion())
       {
       $mensaje = "La conexion se cayó, configurelá nuevamente";
       redirect("vistas/configuracion/configuracion.php?mensaje=$mensaje");
       }
    }

  }

?>


<html lang="es">


    <head>
        <title>Saint Michel</title>
        <link rel="stylesheet" href="vistas/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vistas/css/general.css">
        <script src="vistas/bootstrap/js/bootstrap.min.js"></script>
        <script src="vistas/javascript/lista.js"></script>

        <script src="otros\otros.js"></script>
    </head>

    <body id="cuerpo" >

      <div style="padding:50px" class="text-center">
        <h1 class="titulo"> Saint Michel </h1>
      </div>

      <nav class="navbar navbar-inverse">

          <?php if ($_SESSION["id"] != 0) { ?>



          <ul class="nav navbar-nav" style="margin-left:15px">
            <li><a target="_blank" href="vistas/informes/empresa.php">Empresa</a></li>
          </ul>

          <ul class="nav navbar-nav" style="margin-left:15px">
            <li><a target="_blank" href="vistas/informes/repartidores.php">Repartidores</a></li>
          </ul>

          <ul class="nav navbar-nav" style="margin-left:15px">
            <li><a target="_blank" href="vistas/informes/vendedores.php">Vendedores</a></li>
          </ul>

        <ul class="nav navbar-nav" style="margin-left:15px">
          <li><a target="_blank" href="vistas/informes/pruebaExcel.php">Prueba Excel</a></li>
        </ul>


          <ul class="nav navbar-nav" style="margin-left:15px">
        <li><a target="_blank" href="vistas/diaRepartidor/seleccionarDiaRepartidor/seleccionarDiaRepartidor.php">Dia Repartidor</a></li>
          </ul>

        <ul class="nav navbar-nav" style="margin-left:15px">
          <li><a target="_blank" href="vistas/buscadorCliente/buscarCliente.php">Buscar Cliente</a></li>
        </ul>



        <ul class="nav navbar-nav" style="margin-left:15px;display:none">
          <li><button onclick="probar()">Probar</button></li>
        </ul>

        <script type="text/javascript">

          function probar()
          {
          lista = new Lista;
          elemento = new ElementoLista("Prueba");

          elemento.setTitulo("Titulo");
          elemento.setColorTitulo("White");

          elemento.setDescripcion("aaaaaaaa");
          elemento.setDetalle("opmanjkasdalskndlaaaaaaaa");

          lista.addElemento(elemento.getElemento());
          document.getElementById("footer").appendChild(lista.getLista());
          }

          function clicka(a)
          {
            alert(a);
          }






        </script>

          <?php } ?>


          <?php if ($_SESSION["conexion"]) { ?>

            <?php if ($_SESSION["id"] == 0) { ?>


            <ul class="nav navbar-nav navbar-right" style="margin-rigth:15px" >
              <li><a href="vistas/sesion/iniciarSesion.php" ><span class="glyphicon glyphicon-log-in"></span>Ingresar</a></li>
            </ul>


            <?php } else { ?>

              <ul class="nav navbar-nav navbar-right" style="margin-rigth:15px" >
                <li><a href="controladores/cerrarSesion.php" >Cerrar Sesión</a></li>
              </ul>

            <?php } ?>

          <?php } ?>


          <ul class="nav navbar-nav navbar-right" style="margin-rigth:15px">
            <li >
              <a href="vistas/configuracion/configuracion.php" >
                Configuración<?php if($_SESSION["conexion"]){echo "(Conexión establecida)";}else{echo "(Debe establecer la conexión)";}?>
              </a>
            </li>
          </ul>


      </nav>

      <div  id="footer" class="">
        <script type="text/javascript">




        </script>

      </div>

      <footer  style="height:500px">
      </footer>


    </body>

</html>
