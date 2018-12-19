<?php

include_once('../../../otros/otros.php');
include_once('../../../modelo/trabajadores/trabajador.php');
include_once('../../../modelo/conector.php');
include_once('../../../modelo/diaRepartidor/diaRepartidor.php');
include_once('../../../modelo/diaRepartidor/viejo/planillas.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/viejo/include.php');

session_start();

if(isset($_POST["seleccionarDiaRepartidor"]))
    {

    $idRepartidor  = $_POST["idRepartidor"];
    $repartidor = new Trabajador($idRepartidor);
    $fecha = $_POST["fecha"];
    $diaRepartidor = new DiaRepartidor();

    $diaRepartidor->setRepartidor($repartidor);
    $diaRepartidor->setFecha($fecha);

    $diaRepartidor->cargar();

    $_SESSION["DiaRepartidor"] = $diaRepartidor;
    $_SESSION["Planillas"] = new Planillas($idRepartidor,$fecha);

      redirect('../../../vistas/diaRepartidor/diaRepartidor.php');

    }










/*

if(isset($_GET["dato"]))
  {


  $xml = new Xml();
  $conector = new Conector();

  $xml->startTag("Dato");

  if($conector->abrirConexion())
    {
    $xml->addTag("DatosCorrectos",true);

    $dato = new SimpleXMLElement($_GET["dato"]);
    $fecha = $dato->Fecha[0];
    $repartidor = new Repartidor($dato->Repartidor[0]);

    $diaRepartidor = new DiaRepartidor();

    $diaRepartidor->setRepartidor($repartidor);
    $diaRepartidor->setFecha($fecha);


    $xml->startTag("Repartidor");
      $xml->addTag("Nombre",$repartidor->getNombre());
      $xml->addTag("Apellido",$repartidor->getApellido());
      $xml->addTag("Id",$repartidor->getId());
    $xml->closeTag("Repartidor");
    $xml->addTag("Fecha",$fecha);

    $conexion = $conector->getConexion();

    $sql = "SELECT * FROM DiaRepartidor WHERE IdEmpleado = '$dato->Repartidor[0]' AND Fecha = '$fecha'";

    $tabla = $conexion->query($sql);

    if($tabla->num_rows>0)
        {
        $row = $tabla->fetch_assoc();
        $xml->addTag("DiaCreado",$row["Estado_Planilla_Creada"]);
        $xml->addTag("DiaCompletado",$row["Estado_Planilla_Completada"]);

        $diaRepartidor->setDiaCreado(true);
        $diaRepartidor->setDiaCompletado(true);

        }
    else
        {
        $xml->addTag("DiaCreado",false);
        $xml->addTag("DiaCompletado",false);

        $diaRepartidor->setDiaCreado(false);
        $diaRepartidor->setDiaCompletado(false);

        }

    $_SESSION["DiaRepartidor"] = $diaRepartidor;

    }
  else
    {
    $xml->addTag("DatosCorrectos",false);
    }

  $xml->closeTag("Dato");
  echo $xml->toString();

  }

*/

?>
