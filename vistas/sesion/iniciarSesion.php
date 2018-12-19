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


        <form class="form-signin" action="../../controladores/iniciarSesion.php" method="post" >

            <input id="iniciarSesion" name="iniciarSesion" type="hidden" value="1"/>

            <h4 class="form-signin-heading text-center" style="margin-bottom: 20px;">Datos de Usuario</h4>
            <label for="nombre" class="sr-only">Nombre</label>
            <input type="nombre" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required autofocus style="margin-bottom: 15px;">
            <label for="password" class="sr-only">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 20px;">Ingresar</button>

            <?php

            ?>

        </form>

    </div>







    </body>

</html>
