<?php
session_start();
?>

<html lang="es">
    <head>
        <title>Saint Michel</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>

    <body id="cuerpo">

      <?php require '../header.php' ?>



      <div class="container" style="width:280px">


        <?php
        if(isset($_GET["mensaje"]))
          {
          $mensaje = $_GET["mensaje"];
          $ancho = "250px";
          require '../mensaje.php';
          }
        ?>


        <form class="form-signin" action="../../controladores/configuracion.php" method="post" >

            <input id="configurar" name="configurar" type="hidden" value="1"/>

            <h4 class="form-signin-heading text-center" style="margin-bottom: 20px;">Datos de Conexion</h4>
            <label for="direccion" >Direccion</label>
            <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Direccion" required style="margin-bottom: 15px;">
            <label for="usuario" >Nombre</label>
            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre" required autofocus style="margin-bottom: 15px;">
            <label for="password" >Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 20px;">Configurar</button>


        </form>

    </div>







    </body>

</html>
