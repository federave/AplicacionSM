<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/otros/otros.php');

$datoBusqueda  = $_GET["datoBusqueda"];


$xml = new Xml();
$xml->startTag("Clientes");




$conector = new Conector();

$k=0;


if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  // Busqueda en Datos Cliente

  $sql = "SELECT * FROM TipoDirecciones WHERE Numero LIKE '%$datoBusqueda%'";
  $tabla = $conexion->query($sql);

  while($row = $tabla->fetch_assoc())
      {
      $idDireccion = $row["IdDireccion"];
      $entre="";
      if($row["Entre1"]!="" && $row["Entre2"]!="")
        {
        $entre .= "entre " . $row["Entre1"] . " y " . $row["Entre2"];
        }
      else if($row["Entre1"]!="")
        {
        $entre .= "esquina " . $row["Entre1"];
        }
      else if($row["Entre2"]!="")
        {
        $entre .= "esquina " . $row["Entre2"];
        }
      else{}

      $departamento="";

      if($row["Departamento"]!="")
        {
        $departamento .= "Dep: " . $row["Departamento"];
        if($row["Piso"]!=-1)
          {
          $departamento .= " Piso: " . $row["Piso"];
          }
        }

      $direccion = $row["Calle"] . $entre . " N°: " . $row["Numero"] . " " . $departamento;

      $sql = "SELECT IdCliente FROM Direcciones WHERE IdDireccion ='$idDireccion'";
      $tabla2 = $conexion->query($sql);
      if($tabla2->num_rows>0)
          {
          $row2 = $tabla2->fetch_assoc();
          $idCliente = $row2["IdCliente"];

          $sql = "SELECT * FROM Clientes WHERE IdCliente ='$idCliente'";
          $tabla3 = $conexion->query($sql);
          if($tabla3->num_rows>0)
              {
                $row3 = $tabla3->fetch_assoc();
                $k++;

              $datos = $row3["Nombre"] . " " . $row3["Apellido"] . " Tel: " . $row3["Telefono1"];
              $xml->startTag("Cliente");
              $xml->addTag("Datos",$datos);
              $xml->addTag("Direccion",$direccion);
              $xml->addTag("IdCliente",$idCliente);
              $xml->addTag("IdDireccion",$idDireccion);
              $xml->closeTag("Cliente");
              }

          }


        }

$conector->cerrarConexion();

  }



    $xml->addTag("NumeroClientes",$k);
    $xml->closeTag("Clientes");







echo $xml->toString();


?>
