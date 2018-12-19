<?php

include_once('../../../../../modelo/conector.php');
include_once('../../../../../otros/otros.php');
include_once('../../../../../modelo/direccion.php');




if(isset($_GET["dato"]))
  {

  $dato = new SimpleXMLElement($_GET["dato"]);
  $idCliente = $dato->IdCliente[0];

  $xml = new Xml();
  $conector = new Conector();

  $xml->startTag("Dato");

  if($conector->abrirConexion())
    {

      $conexion = $conector->getConexion();


      $sql = "SELECT * FROM Clientes WHERE IdCliente = '$idCliente' ";

      $tabla = $conexion->query($sql);

      if($tabla->num_rows>0)
          {
          $row = $tabla->fetch_assoc();
          $xml->addTag("ClienteEncontrado",true);

          $sql = "SELECT IdDireccion FROM Direcciones WHERE IdCliente = '$idCliente' ";
          $tabla = $conexion->query($sql);


          if($tabla->num_rows>0)
              {
              $k=0;
              while($row = $tabla->fetch_assoc())
                  {
                  $direccion = new Direccion($row["IdDireccion"]);
                  $xml->addTag("IdDireccion",$row["IdDireccion"]);
                  $xml->addTag("Direccion",$direccion->toString());
                  $k++;
                  }
              }

          $xml->addTag("NumeroDirecciones",$k);



          }
      else
          {
          $xml->addTag("ClienteEncontrado",false);
          }





    }

    $xml->closeTag("Dato");


    echo $xml->toString();

  }
  else
  {
    echo "zzzzzzz";

  }





 ?>
