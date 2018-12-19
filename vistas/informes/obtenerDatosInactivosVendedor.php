<?php

include_once('../../modelo/conector.php');
include_once('../../otros/otros.php');
include_once('../../modelo/trabajadores/trabajador.php');
include_once('../../modelo/precios/precios.php');
include_once('funciones.php');


$idVendedor=$_GET["idVendedor"];
$fechaInicio=$_GET["fechaInicio"];
$fechaFin=$_GET["fechaFin"];

$vendedor = new Trabajador($idVendedor);


$xml = new Xml();
$xml->startTag("DatosInactivosVendedor");

$xml->addTag("FechaInicio",$fechaInicio);
$xml->addTag("FechaFin",$fechaFin);
$xml->addTag("Vendedor",$vendedor->toString());



$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $sql = "select count(distinct(idcliente)) from planilladinamica
  where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
    {
    $row = $tabla->fetch_assoc();
    $xml->addTag("NumeroClientes",$row["count(distinct(idcliente))"]);
    }
  else
    {
    $xml->addTag("NumeroClientes",0);
    }

  $sql = "select count(distinct(idcliente)) from planilladinamica
  where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin' and (NBidon20L>0 OR NBidon12L>0 OR NBidon10L>0 OR NBidon8L>0 OR NBidon5L>0 OR NPackBotellas2L>0 OR NPackBotellas500mL>0 OR NBidon20L_A>0 OR NBidon12L_A>0)";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
    {
    $row = $tabla->fetch_assoc();
    $xml->addTag("TotalActivos",$row["count(distinct(idcliente))"]);
    }
  else
    {
    $xml->addTag("TotalActivos",0);
    }




  $sql = "select pd.idcliente,c.nombre,c.apellido,c.telefono1,c.idtipocliente,tc.tipo,r.dia,td.calle,td.entre1,td.entre2,td.numero from planilladinamica as pd inner join clientes as c on pd.idcliente=c.idcliente inner join direcciones as d on c.idcliente=d.idcliente inner join tipodirecciones as td on d.iddireccion=td.iddireccion inner join repartos as r on d.idcliente=r.idcliente inner join tipoclientes as tc on c.idtipocliente=tc.idtipocliente
  where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
  group by pd.idcliente
  having sum(pd.NBidon20L)=0 and sum(pd.NBidon12L)=0 and sum(pd.NBidon10L)=0 and sum(pd.NBidon8L)=0 and  sum(pd.NBidon5L)=0 and sum(pd.NPackBotellas2L)=0 and sum(pd.NPackBotellas500mL)=0 and sum(pd.NBidon20L_A)=0 and sum(pd.NBidon12L_A)=0
  order by tc.idtipocliente";
  $tabla = $conexion->query($sql);
  $xml->addTag("Numero",$tabla->num_rows);
  $xml->startTag("OrdenTipoCliente");

  if($tabla->num_rows>0)
      {
      while($row = $tabla->fetch_assoc())
          {

          $direccion="";

          $direccion.=$row["calle"];
          if($row["entre1"]!="" && $row["entre2"]!="")
            {
            $direccion.=" e/ ".$row["entre1"]." y ".$row["entre2"];
            }
          else if($row["entre1"]!="")
            {
            $direccion.=" esq: ".$row["entre1"];
            }
          else if($row["entre2"]!="")
            {
            $direccion.=" esq: ".$row["entre2"];
            }
          else
            {
            }

          $direccion.= " Num: " . $row["numero"];


          $xml->startTag("Cliente");
            $xml->addTag("IdCliente",$row["idcliente"]);
            $xml->addTag("Nombre",$row["nombre"]);
            $xml->addTag("Apellido",$row["apellido"]);
            $xml->addTag("Telefono",$row["telefono1"]);
            $xml->addTag("Direccion",$direccion);
            $xml->addTag("Tipo",$row["tipo"]);
            $xml->addTag("Dia",$row["dia"]);

          $xml->closeTag("Cliente");



          }

      }
 $xml->closeTag("OrdenTipoCliente");




   $sql = "select pd.idcliente,c.nombre,c.apellido,c.telefono1,c.idtipocliente,tc.tipo,r.dia,td.calle,td.entre1,td.entre2,td.numero from planilladinamica as pd inner join clientes as c on pd.idcliente=c.idcliente inner join direcciones as d on c.idcliente=d.idcliente inner join tipodirecciones as td on d.iddireccion=td.iddireccion inner join repartos as r on d.idcliente=r.idcliente inner join tipoclientes as tc on c.idtipocliente=tc.idtipocliente
   where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
   group by pd.idcliente
   having sum(pd.NBidon20L)=0 and sum(pd.NBidon12L)=0 and sum(pd.NBidon10L)=0 and sum(pd.NBidon8L)=0 and  sum(pd.NBidon5L)=0 and sum(pd.NPackBotellas2L)=0 and sum(pd.NPackBotellas500mL)=0 and sum(pd.NBidon20L_A)=0 and sum(pd.NBidon12L_A)=0
   order by r.dia";
   $tabla = $conexion->query($sql);
   $xml->startTag("OrdenDia");

   if($tabla->num_rows>0)
       {
       while($row = $tabla->fetch_assoc())
           {

           $direccion="";

           $direccion.=$row["calle"];
           if($row["entre1"]!="" && $row["entre2"]!="")
             {
             $direccion.=" e/ ".$row["entre1"]." y ".$row["entre2"];
             }
           else if($row["entre1"]!="")
             {
             $direccion.=" esq: ".$row["entre1"];
             }
           else if($row["entre2"]!="")
             {
             $direccion.=" esq: ".$row["entre2"];
             }
           else
             {
             }

           $direccion.= " Num: " . $row["numero"];


           $xml->startTag("Cliente");
             $xml->addTag("IdCliente",$row["idcliente"]);
             $xml->addTag("Nombre",$row["nombre"]);
             $xml->addTag("Apellido",$row["apellido"]);
             $xml->addTag("Telefono",$row["telefono1"]);
             $xml->addTag("Direccion",$direccion);
             $xml->addTag("Tipo",$row["tipo"]);
             $xml->addTag("Dia",$row["dia"]);

           $xml->closeTag("Cliente");



           }

       }
  $xml->closeTag("OrdenDia");







  $conector->cerrarConexion();
  }





  $xml->closeTag("DatosInactivosVendedor");







?>
