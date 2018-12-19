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
$xml->startTag("DatosInformeVendedor");

$xml->addTag("FechaInicio",$fechaInicio);
$xml->addTag("FechaFin",$fechaFin);
$xml->addTag("Vendedor",$vendedor->toString());


$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  //////Productos Vendidos////////

    $sql = "
          select sum(NBidon20L),sum(NBidon20L_B),sum(NBidon20L_A),sum(NBidon12L),sum(NBidon12L_B),sum(NBidon12L_A),sum(NBidon10L),sum(NBidon10L_B),sum(NBidon8L),sum(NBidon8L_B),sum(NBidon5L),sum(NBidon5L_B),sum(NPackBotellas2L),sum(NPackBotellas2L_B),sum(NPackBotellas500mL),sum(NPackBotellas500mL_B),sum(NBidon20L_V),sum(NBidon12L_V),sum(DineroProductos),count(distinct fecha)
          from planilladinamica
          where fecha between '$fechaInicio' and '$fechaFin' and IdEmpleado_Vendedor = '$idVendedor';";
    $tabla = $conexion->query($sql);
    if($tabla->num_rows>0)
        {
        $row = $tabla->fetch_assoc();


        $xml->addTag("CantidadDeRepartos",$row["count(distinct fecha)"]);

        $xml->startTag("ProductosVendidos");
          $xml->addTag("Bidones20L",$row["sum(NBidon20L)"]);
          $xml->addTag("Bidones12L",$row["sum(NBidon12L)"]);
          $xml->addTag("Bidones10L",$row["sum(NBidon10L)"]);
          $xml->addTag("Bidones8L",$row["sum(NBidon8L)"]);
          $xml->addTag("Bidones5L",$row["sum(NBidon5L)"]);
          $xml->addTag("PackBotellas2L",$row["sum(NPackBotellas2L)"]);
          $xml->addTag("PackBotellas500mL",$row["sum(NPackBotellas500mL)"]);
        $xml->closeTag("ProductosVendidos");


        $xml->startTag("ProductosBonificados");
          $xml->addTag("Bidones20L",$row["sum(NBidon20L_B)"]);
          $xml->addTag("Bidones12L",$row["sum(NBidon12L_B)"]);
          $xml->addTag("Bidones10L",$row["sum(NBidon10L_B)"]);
          $xml->addTag("Bidones8L",$row["sum(NBidon8L_B)"]);
          $xml->addTag("Bidones5L",$row["sum(NBidon5L_B)"]);
          $xml->addTag("PackBotellas2L",$row["sum(NPackBotellas2L_B)"]);
          $xml->addTag("PackBotellas500mL",$row["sum(NPackBotellas500mL_B)"]);
        $xml->closeTag("ProductosBonificados");


        $xml->addTag("DineroVentaProductos",$row["sum(DineroProductos)"]);

        $xml->startTag("EntregaAlquileres");
          $xml->addTag("Bidones20L",$row["sum(NBidon20L_A)"]);
          $xml->addTag("Bidones12L",$row["sum(NBidon12L_A)"]);
        $xml->closeTag("EntregaAlquileres");

        $xml->startTag("VaciosRecuperados");
          $xml->addTag("Bidones20L",$row["sum(NBidon20L_V)"]);
          $xml->addTag("Bidones12L",$row["sum(NBidon12L_V)"]);
        $xml->closeTag("VaciosRecuperados");



        }

        /* Datos Alquileres */



        $alquileres6Bidones=0;
        $alquileres8Bidones=0;
        $alquileres10Bidones=0;
        $alquileres12Bidones=0;

        $alquileres6BidonesPrecioEspecial=0;
        $alquileres8BidonesPrecioEspecial=0;
        $alquileres10BidonesPrecioEspecial=0;
        $alquileres12BidonesPrecioEspecial=0;

        $dineroAlquileres6Bidones=0;
        $dineroAlquileres8Bidones=0;
        $dineroAlquileres10Bidones=0;
        $dineroAlquileres12Bidones=0;





        $fechaAux = strtotime($fechaInicio);

        $fechaAuxFin = strtotime($fechaFin);

        $year = date("Y", $fechaAux);
        $mes = date("m", $fechaAux);
        $dia = date("d", $fechaAux);

        $fechaAux = strtotime("1-".$mes."-".$year);

        $cuenta="";

        $aux=true;
        while($aux)
        {

        $year = date("Y", $fechaAux);
        $mes = date("m", $fechaAux);
        $dia = date("d", $fechaAux);
        $fechaAux2 = $year . "-" . $mes ."-" .$dia;

        $preciosAlquileres = new PrecioAlquileres($fechaAux2);

        $sql = "SELECT alquilerdispenser_bidonesentregados.IdCliente FROM alquilerdispenser_bidonesentregados inner join clientes on clientes.IdCliente=alquilerdispenser_bidonesentregados.IdCliente WHERE mes = '$mes' AND año = '$year' AND clientes.IdEmpleado = '$idVendedor'";
        $tablaADBE = $conexion->query($sql);
        if($tablaADBE->num_rows>0)
            {



            while($rowADBE = $tablaADBE->fetch_assoc())
                {
                $idCliente = $rowADBE["IdCliente"];


                $sql = "SELECT * FROM AcuerdosDispenser WHERE IdCliente = '$idCliente' AND FechaInicio<='$fechaAux2' ORDER BY Fecha DESC";


                $tablaAD = $conexion->query($sql);
                if($tablaAD->num_rows>0)
                    {

                    $rowAD = $tablaAD->fetch_assoc();

                    if($rowAD["PrecioEspecial"]==1)
                      {
                      if($rowAD["NAlq6B"]>0)
                        {
                        $alquileres6Bidones+=$rowAD["NAlq6B"];
                        if($rowAD["PAlq6B"]!=-1)
                          {
                          $alquileres6BidonesPrecioEspecial+=$rowAD["PAlq6B"];
                          $dineroAlquileres6Bidones+=$rowAD["NAlq6B"]*$rowAD["PAlq6B"];
                          }
                        else
                          {
                          $dineroAlquileres6Bidones+=$rowAD["NAlq6B"]*$preciosAlquileres->getAlquiler6Bidones();
                          }
                        }
                      if($rowAD["NAlq8B"]>0)
                        {
                        $alquileres8Bidones+=$rowAD["NAlq8B"];
                        if($rowAD["PAlq8B"]!=-1)
                          {
                          $alquileres8BidonesPrecioEspecial+=$rowAD["PAlq8B"];
                          $dineroAlquileres8Bidones+=$rowAD["NAlq8B"]*$rowAD["PAlq8B"];
                          }
                        else
                          {
                          $dineroAlquileres8Bidones+=$rowAD["NAlq8B"]*$preciosAlquileres->getAlquiler8Bidones();
                          }
                        }
                      if($rowAD["NAlq10B"]>0)
                        {
                        $alquileres10Bidones+=$rowAD["NAlq10B"];
                        if($rowAD["PAlq10B"]!=-1)
                          {
                          $alquileres10BidonesPrecioEspecial+=$rowAD["PAlq10B"];
                          $dineroAlquileres10Bidones+=$rowAD["NAlq10B"]*$rowAD["PAlq10B"];
                          }
                        else
                          {
                          $dineroAlquileres10Bidones+=$rowAD["NAlq10B"]*$preciosAlquileres->getAlquiler10Bidones();
                          }
                        }
                      if($rowAD["NAlq12B"]>0)
                        {
                        $alquileres12Bidones+=$rowAD["NAlq12B"];
                        if($rowAD["PAlq12B"]!=-1)
                          {
                          $alquileres12BidonesPrecioEspecial+=$rowAD["PAlq12B"];
                          $dineroAlquileres12Bidones+=$rowAD["NAlq12B"]*$rowAD["PAlq12B"];
                          }
                        else
                          {
                          $dineroAlquileres12Bidones+=$rowAD["NAlq12B"]*$preciosAlquileres->getAlquiler12Bidones();
                          }
                        }
                      }
                    else
                      {
                      if($rowAD["NAlq6B"]>0)
                        {
                        $alquileres6Bidones+=$rowAD["NAlq6B"];
                        $dineroAlquileres6Bidones+=$rowAD["NAlq6B"]*$preciosAlquileres->getAlquiler6Bidones();
                        }
                      if($rowAD["NAlq8B"]>0)
                        {
                        $alquileres8Bidones+=$rowAD["NAlq8B"];
                        $dineroAlquileres8Bidones+=$rowAD["NAlq8B"]*$preciosAlquileres->getAlquiler8Bidones();
                        }
                      if($rowAD["NAlq10B"]>0)
                        {
                        $alquileres10Bidones+=$rowAD["NAlq10B"];
                        $dineroAlquileres10Bidones+=$rowAD["NAlq10B"]*$preciosAlquileres->getAlquiler10Bidones();
                        }
                      if($rowAD["NAlq12B"]>0)
                        {
                        $alquileres12Bidones+=$rowAD["NAlq12B"];
                        $dineroAlquileres12Bidones+=$rowAD["NAlq12B"]*$preciosAlquileres->getAlquiler12Bidones();
                        }

                      }
                    }
                }
            }



        /*
        codigo de alquileres
        */

        //$cuenta=$cuenta+1;

        $fechaAux = strtotime("+1 month",$fechaAux);

        if($fechaAux>$fechaAuxFin)
          $aux=false;
        }




        $xml->addTag("Cuenta",$cuenta);

        $xml->startTag("Alquileres");
          $xml->addTag("Alquileres6Bidones",$alquileres6Bidones);
          $xml->addTag("Alquileres8Bidones",$alquileres8Bidones);
          $xml->addTag("Alquileres10Bidones",$alquileres10Bidones);
          $xml->addTag("Alquileres12Bidones",$alquileres12Bidones);
          $xml->addTag("Alquileres6BidonesPrecioEspecial",$alquileres6BidonesPrecioEspecial);
          $xml->addTag("Alquileres8BidonesPrecioEspecial",$alquileres8BidonesPrecioEspecial);
          $xml->addTag("Alquileres10BidonesPrecioEspecial",$alquileres10BidonesPrecioEspecial);
          $xml->addTag("Alquileres12BidonesPrecioEspecial",$alquileres12BidonesPrecioEspecial);
          $xml->addTag("DineroAlquileres6Bidones",$dineroAlquileres6Bidones);
          $xml->addTag("DineroAlquileres8Bidones",$dineroAlquileres8Bidones);
          $xml->addTag("DineroAlquileres10Bidones",$dineroAlquileres10Bidones);
          $xml->addTag("DineroAlquileres12Bidones",$dineroAlquileres12Bidones);
        $xml->closeTag("Alquileres");





        /* Datos Deudas Productos */


        $xml->startTag("DeudasProductos");

        $sql = "SELECT count(D.IdDeuda),sum(D.NBidon20L),sum(D.NBidon12L),sum(D.NBidon10L),sum(D.NBidon8L),sum(D.NBidon5L),sum(D.NPackBotellas2L),sum(D.NPackBotellas500mL),sum(D.NBidon20L*D.PBidon20L+D.NBidon12L*D.PBidon12L+D.NBidon10L*D.PBidon10L+D.NBidon8L*D.PBidon8L+D.NBidon5L*D.PBidon5L+D.NPackBotellas2L*D.PPackBotellas2L+D.NPackBotellas500mL*D.PPackBotellas500mL) FROM Clientes AS C INNER JOIN Deudas_Productos AS D ON C.IdCliente=D.IdCliente WHERE D.Fecha>='$fechaInicio' AND D.Fecha<='$fechaFin' AND C.IdEmpleado='$idVendedor'";
        $tablaDP = $conexion->query($sql);
        if($tablaDP->num_rows>0)
            {
            $rowDP = $tablaDP->fetch_assoc();
            $xml->addTag("Bidones20L",$rowDP["sum(D.NBidon20L)"]);
            $xml->addTag("Bidones12L",$rowDP["sum(D.NBidon12L)"]);
            $xml->addTag("Bidones10L",$rowDP["sum(D.NBidon10L)"]);
            $xml->addTag("Bidones8L",$rowDP["sum(D.NBidon8L)"]);
            $xml->addTag("Bidones5L",$rowDP["sum(D.NBidon5L)"]);
            $xml->addTag("PackBotellas2L",$rowDP["sum(D.NPackBotellas2L)"]);
            $xml->addTag("PackBotellas500mL",$rowDP["sum(D.NPackBotellas500mL)"]);
            $xml->addTag("DineroTotal",$rowDP["sum(D.NBidon20L*D.PBidon20L+D.NBidon12L*D.PBidon12L+D.NBidon10L*D.PBidon10L+D.NBidon8L*D.PBidon8L+D.NBidon5L*D.PBidon5L+D.NPackBotellas2L*D.PPackBotellas2L+D.NPackBotellas500mL*D.PPackBotellas500mL)"]);
            $xml->addTag("Numero",$rowDP["count(D.IdDeuda)"]);
            }
          else
            {
            $xml->addTag("Bidones12L",0);
            $xml->addTag("Bidones10L",0);
            $xml->addTag("Bidones8L",0);
            $xml->addTag("Bidones5L",0);
            $xml->addTag("PackBotellas2L",0);
            $xml->addTag("PackBotellas500mL",0);
            $xml->addTag("Numero",0);
            $xml->addTag("DineroTotal",0);
            }

          $xml->closeTag("DeudasProductos");



                  /* Datos Sobre Clientes */

                  $xml->startTag("DatosClientes");


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

                  $sql = "select idcliente from planilladinamica
                  where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin' and (NBidon20L>0 OR NBidon12L>0 OR NBidon10L>0 OR NBidon8L>0 OR NBidon5L>0 OR NPackBotellas2L>0 OR NPackBotellas500mL>0 OR NBidon20L_A>0 OR NBidon12L_A>0)";
                  $tabla = $conexion->query($sql);
                  $xml->addTag("NumeroEntregas",$tabla->num_rows);

                  $sql = "select idcliente from planilladinamica
                  where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin' and not(NBidon20L>0 OR NBidon12L>0 OR NBidon10L>0 OR NBidon8L>0 OR NBidon5L>0 OR NPackBotellas2L>0 OR NPackBotellas500mL>0 OR NBidon20L_A>0 OR NBidon12L_A>0)";
                  $tabla = $conexion->query($sql);
                  $xml->addTag("NumeroVisitasSinEntrega",$tabla->num_rows);

                  $sql = "select idcliente from planilladinamica
                  where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'";
                  $tabla = $conexion->query($sql);
                  $xml->addTag("NumeroVisitas",$tabla->num_rows);






                  $xml->startTag("NivelesDeActividad");




                  $numero=10*diferenciaMeses($fechaInicio,$fechaFin);
                  $k=1;
                  while($k<=$numero)
                      {
                      $sql = " select idcliente,count(idcliente) from planilladinamica
                      where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin' and (NBidon20L>0 OR NBidon12L>0 OR NBidon10L>0 OR NBidon8L>0 OR NBidon5L>0 OR NPackBotellas2L>0 OR NPackBotellas500mL>0 OR NBidon20L_A>0 OR NBidon12L_A>0)
                      group by idcliente
                      having count(idcliente)='$k'";
                      $tabla = $conexion->query($sql);
                      $xml->addTag("Nivel",$tabla->num_rows);
                      $k++;
                      }


                    $xml->closeTag("NivelesDeActividad");


                  $xml->closeTag("DatosClientes");




                  /* Datos Sobre Clientes */

                  $xml->startTag("DatosClientesCompras");




                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having (sum(NBidon20L) > 0 or sum(NBidon20L_A) > 0) and sum(NBidon12L)=0 and sum(NBidon12L_A)=0 and sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                    $tabla = $conexion->query($sql);
                    $xml->addTag("SoloBidones20L",$tabla->num_rows);

                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having sum(NBidon20L) = 0 and sum(NBidon20L_A)=0 and (sum(NBidon12L)>0 or sum(NBidon12L_A)>0) and sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";

                    $tabla = $conexion->query($sql);
                    $xml->addTag("SoloBidones12L",$tabla->num_rows);


                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having sum(NBidon20L) = 0 and sum(NBidon20L_A) = 0 and sum(NBidon12L)=0 and sum(NBidon12L_A)=0 and sum(NBidon10L)>0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                    $tabla = $conexion->query($sql);

                    $xml->addTag("SoloBidones10L",$tabla->num_rows);

                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having sum(NBidon20L) = 0 and sum(NBidon20L_A) = 0 and sum(NBidon12L)=0 and sum(NBidon12L_A)=0 and sum(NBidon10L)=0 and sum(NBidon8L)>0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                    $tabla = $conexion->query($sql);
                    $xml->addTag("SoloBidones8L",$tabla->num_rows);

                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having sum(NBidon20L) = 0 and sum(NBidon20L_A) = 0 and sum(NBidon12L)=0 and sum(NBidon12L_A)=0 and sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                    $tabla = $conexion->query($sql);
                    $xml->addTag("SoloBidones5L",$tabla->num_rows);

                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having sum(NBidon20L) = 0 and sum(NBidon20L_A) = 0 and sum(NBidon12L)=0 and sum(NBidon12L_A)=0 and sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)=0";
                    $tabla = $conexion->query($sql);
                    $xml->addTag("SoloPackBotellas2L",$tabla->num_rows);


                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having sum(NBidon20L) = 0 and sum(NBidon20L_A) = 0 and sum(NBidon12L)=0 and sum(NBidon12L_A)=0 and sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)>0";
                    $tabla = $conexion->query($sql);
                    $xml->addTag("SoloPackBotellas500mL",$tabla->num_rows);


                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having (sum(NBidon20L) > 0 or sum(NBidon20L_A) > 0 or sum(NBidon12L)>0 or sum(NBidon12L_A)>0) and sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                    $tabla = $conexion->query($sql);
                    $xml->addTag("SoloRetornables",$tabla->num_rows);

                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having (sum(NBidon20L) = 0 and  sum(NBidon20L_A) = 0 and sum(NBidon12L)=0 and sum(NBidon12L_A)=0) and (sum(NBidon10L)>0 or sum(NBidon8L)>0 or sum(NBidon5L)>0 or sum(NPackBotellas2L)>0 or sum(NPackBotellas500mL)>0)";
                    $tabla = $conexion->query($sql);
                    $xml->addTag("SoloDescartables",$tabla->num_rows);


                    $sql = " select idcliente from planilladinamica
                    where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                    group by idcliente
                    having (sum(NBidon20L) > 0 or sum(NBidon20L_A) > 0 or sum(NBidon12L)>0 or sum(NBidon12L_A)>0) and (sum(NBidon10L)>0 or sum(NBidon8L)>0 or sum(NBidon5L)>0 or sum(NPackBotellas2L)>0 or sum(NPackBotellas500mL)>0)";
                    $tabla = $conexion->query($sql);
                    $xml->addTag("RetornablesYDescartables",$tabla->num_rows);


                    /// Enfocado a Descartables

                    $xml->startTag("Descartables");


                      $sql = " select idcliente from planilladinamica
                      where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                      group by idcliente
                      having sum(NBidon10L)>0 or sum(NBidon8L)>0 or sum(NBidon5L)>0 or sum(NPackBotellas2L)>0 or sum(NPackBotellas500mL)>0";
                      $tabla = $conexion->query($sql);

                      $xml->addTag("Numero",$tabla->num_rows);



                      $sql = " select idcliente from planilladinamica
                      where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                      group by idcliente
                      having (sum(NBidon10L)>0 or sum(NBidon8L)>0 or sum(NBidon5L)>0) and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                      $tabla = $conexion->query($sql);

                      $xml->addTag("SoloBidones",$tabla->num_rows);

                      $sql = " select idcliente from planilladinamica
                      where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                      group by idcliente
                      having sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and (sum(NPackBotellas2L)>0 or sum(NPackBotellas500mL)>0)";
                      $tabla = $conexion->query($sql);

                      $xml->addTag("SoloBotellas",$tabla->num_rows);

                      $sql = " select idcliente from planilladinamica
                      where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                      group by idcliente
                      having (sum(NBidon10L)>0 or sum(NBidon8L)>0 or sum(NBidon5L)>0) and (sum(NPackBotellas2L)>0 or sum(NPackBotellas500mL)>0)";
                      $tabla = $conexion->query($sql);

                      $xml->addTag("BidonesYBotellas",$tabla->num_rows);


                      $xml->startTag("UnProducto");
                        $numero=0;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)>0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones8L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones5L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Botellas2L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;


                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("SoloPackBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $xml->addTag("Numero",$numero);
                      $xml->closeTag("UnProducto");


                      $xml->startTag("DosProductos");

                        $numero=0;
                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)>0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones8L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)=0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones5L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBotellas2L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;


                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)>0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones8LYBidones5L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)>0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones8LYBotellas2L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)>0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones8LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;


                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones5LYBotellas2L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones5LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones2LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $xml->addTag("Numero",$numero);

                      $xml->closeTag("DosProductos");



                      $xml->startTag("TresProductos");

                        $numero=0;
                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)>0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones8LYBidones5L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)>0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones8LYBotellas2L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)>0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones8LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)=0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones5LYBotellas2L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)=0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones5LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)=0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBotellas2LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;



                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)>0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones8LYBidones5LYBotellas2L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;


                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)>0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones8LYBidones5LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)>0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones8LYBotellas2LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;


                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)=0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones5LYBotellas2LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $xml->addTag("Numero",$numero);



                      $xml->closeTag("TresProductos");

                      $xml->startTag("CuatroProductos");

                        $numero=0;
                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)>0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)=0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones8LYBidones5LYBotellas2L",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)>0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)=0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones8LYBidones5LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)>0 and sum(NBidon5L)=0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones8LYBotellas2LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;

                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)=0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones10LYBidones5LYBotellas2LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;


                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)=0 and sum(NBidon8L)>0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $xml->addTag("Bidones8LYBidones5LYBotellas2LYBotellas500mL",$tabla->num_rows);
                        $numero+=$tabla->num_rows;


                        $xml->addTag("Numero",$numero);



                      $xml->closeTag("CuatroProductos");



                      $xml->startTag("CincoProductos");

                        $numero=0;
                        $sql = " select idcliente from planilladinamica
                        where IdEmpleado_Vendedor='$idVendedor' and fecha between '$fechaInicio' and '$fechaFin'
                        group by idcliente
                        having sum(NBidon10L)>0 and sum(NBidon8L)>0 and sum(NBidon5L)>0 and sum(NPackBotellas2L)>0 and sum(NPackBotellas500mL)>0";
                        $tabla = $conexion->query($sql);
                        $numero+=$tabla->num_rows;

                        $xml->addTag("Numero",$numero);


                      $xml->closeTag("CincoProductos");





                    $xml->closeTag("Descartables");





                  $xml->closeTag("DatosClientesCompras");














  $conector->cerrarConexion();
  }





$xml->closeTag("DatosInformeVendedor");







 ?>
