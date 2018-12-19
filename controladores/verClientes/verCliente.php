<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/cliente.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/otros/otros.php');



session_start();

$cliente = new Cliente($_GET["id"],$_GET["id2"]);

$_SESSION["Cliente"] = $cliente;


redirect('../../vistas/verClientes/verCliente.php');



?>
