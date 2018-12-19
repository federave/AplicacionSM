<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/otros/otros.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/trabajadores/trabajador.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/diaRepartidor.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/planillas.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/include.php');

$idEmpleado  = $_POST["idRepartidorFueraDeRecorrido"];
$idCliente  = $_POST["idClienteFueraDeRecorrido"];
$idDireccion  = $_POST["idDireccionFueraDeRecorrido"];
$fecha  = $_POST["fechaFueraDeRecorrido"];
$mensaje  = $_POST["mensajeFueraDeRecorrido"];
$idFueraDeRecorrido  = $_POST["idFueraDeRecorrido"];



$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $sql = "INSERT INTO ClientesFueraDeRecorrido (IdCliente,IdDireccion,IdEmpleado,Fecha,IdFueraDeRecorrido,Mensaje)VALUES('$idCliente','$idDireccion','$idEmpleado','$fecha','$idFueraDeRecorrido','$mensaje')";
  $aux = $conexion->query($sql);

  $sql = "SELECT COUNT(IdCliente)  FROM  PlanillaDinamica WHERE  Fecha='$fecha' AND IdEmpleado='$idEmpleado'";
  $tabla = $conexion->query($sql);
  $row = $tabla->fetch_assoc();

  $orden = $row["COUNT(IdCliente)"];

  $sql = "SELECT IdEmpleado  FROM  Clientes WHERE  IdCliente='$idCliente'";
  $tabla = $conexion->query($sql);


  $row = $tabla->fetch_assoc();
  $idEmpleadoVendedor = $row["IdEmpleado"];

  if($idEmpleadoVendedor==$idEmpleado)
    $idEmpleadoVendedor=-1;


  $sql = "INSERT INTO PlanillaDinamica (IdCliente,IdDireccion,IdEmpleado,IdEmpleado_Vendedor,Fecha,Orden,Estado_ClienteAtendido,NBidon20L,NBidon12L,NBidon10L,NBidon8L,NBidon5L,NPackBotellas2L,NPackBotellas500mL,NBidon20L_B,NBidon12L_B,NBidon10L_B,NBidon8L_B,NBidon5L_B,NPackBotellas2L_B,NPackBotellas500mL_B,NBidon20L_V,NBidon12L_V,NBidon20L_O,NBidon12L_O,NBidon10L_O,NBidon8L_O,NBidon5L_O,NPackBotellas2L_O,NPackBotellas500mL_O,NBidon20L_A,NBidon12L_A,DineroProductos,Estado_CPF,Estado_CPD_Auxiliar,Estado_CExtra,Estado_CVendeor)VALUES('$idCliente','$idDireccion','$idEmpleado','$idEmpleadoVendedor','$fecha','$orden',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0)";
  $aux = $conexion->query($sql);

//  echo $sql;

  $conector->cerrarConexion();
  }

session_start();

$repartidor = new Trabajador($idEmpleado);
$diaRepartidor = new DiaRepartidor();

$diaRepartidor->setRepartidor($repartidor);
$diaRepartidor->setFecha($fecha);

$diaRepartidor->cargar();

$_SESSION["DiaRepartidor"] = $diaRepartidor;
$_SESSION["Planillas"] = new Planillas($idEmpleado,$fecha);

redirect('../../../vistas/diaRepartidor/diaRepartidor.php');





?>
