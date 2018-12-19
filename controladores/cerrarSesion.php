<?php

include_once('../modelo/usuarios/usuario.php');
include_once('../otros/otros.php');

session_start();

$_SESSION["id"] = "0";
redirect("../index.php");


?>
