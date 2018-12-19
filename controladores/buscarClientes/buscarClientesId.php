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

  $sql = "SELECT IdCliente,Nombre,Apellido,Telefono1 FROM Clientes WHERE IdCliente LIKE '$datoBusqueda%' ";
  $tabla = $conexion->query($sql);

  if($tabla->num_rows>0)
      {
      while($row = $tabla->fetch_assoc())
          {

          $idCliente = $row["IdCliente"];

          $sql = "SELECT * FROM Direcciones,TipoDirecciones WHERE IdCliente='$idCliente' AND Direcciones.IdDireccion = TipoDirecciones.IdDireccion";
          $tabla2 = $conexion->query($sql);

          if($tabla2->num_rows>0)
              {
              while($row2 = $tabla2->fetch_assoc())
                {


                  $idDireccion = $row2["IdDireccion"];

                  $datos = $row["Nombre"] . " " . $row["Apellido"] . " Tel: " . $row["Telefono1"];

                  $entre="";

                  if($row2["Entre1"]!="" && $row2["Entre2"]!="")
                    {
                    $entre .= "entre " . $row2["Entre1"] . " y " . $row2["Entre2"];
                    }
                  else if($row2["Entre1"]!="")
                    {
                    $entre .= "esquina " . $row2["Entre1"];
                    }
                  else if($row2["Entre2"]!="")
                    {
                    $entre .= "esquina " . $row2["Entre2"];
                    }
                  else{}

                  $departamento="";

                  if($row2["Departamento"]!="")
                    {
                    $departamento .= "Dep: " . $row2["Departamento"];
                    if($row2["Piso"]!=-1)
                      {
                      $departamento .= " Piso: " . $row2["Piso"];
                      }
                    }

                  $direccion = $row2["Calle"] . $entre . " N°: " . $row2["Numero"] . " " . $departamento;
                  $xml->startTag("Cliente");
                  $xml->addTag("Datos",$datos);
                  $xml->addTag("Direccion",$direccion);
                  $xml->addTag("IdCliente",$idCliente);
                  $xml->addTag("IdDireccion",$idDireccion);
                  $xml->closeTag("Cliente");
                  $k++;

                }
              }
          }
      }
  }


$xml->addTag("NumeroClientes",$k);
$xml->closeTag("Clientes");

echo $xml->toString();


?>
