<?php
//Agregamos la libreria FPDF
require('../../fpdf/fpdf.php');
include_once('../../modelo/conector.php');
include_once('../../modelo/trabajadores/trabajador.php');

require('obtenerDatosVendedor.php');
$datosInforme = new SimpleXMLElement($xml->toString());


$idVendedor=$_GET["idVendedor"];
$fechaInicio=$_GET["fechaInicio"];
$fechaFin=$_GET["fechaFin"];

$vendedor = new Trabajador($idVendedor);




$pdf = new FPDF('P','mm','A4');
$pdf->AddPage(); //Agregamos una Pagina


$date = strtotime($fechaInicio);
$fechaI = date("d", $date)."-".date("m", $date)."-".date("Y", $date);

$date = strtotime($fechaFin);
$fechaF = date("d", $date)."-".date("m", $date)."-".date("Y", $date);

////////////////////////////////////////////////////////////////////////////////////
//////Titulo////////
$pdf->SetFont('Times','',20); //Establecemos tipo de fuente, negrita y tamaño 16
$pdf->Text(100-$pdf->GetStringWidth("Informe de Venta")/2,15,"Informe de Venta");


////////////////////////////////////////////////////////////////////////////////////
//////Datos Generales////////
$pdf->SetFont('Times','',15); //Establecemos tipo de fuente, negrita y tamaño 15

$pdf->SetX(10);
$pdf->SetY(30);
$posY=$pdf->GetY();
$pdf->Line(0,$posY,210,$posY);
$pdf->SetY($posY+5);
$pdf->Ln();
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Vendedor: " . $vendedor->toString());
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Periodo");
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Fecha Inicio: ".$fechaI);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Fecha Fin: ".$fechaF);
$pdf->Ln();$pdf->Ln();

$pdf->Line(0,$pdf->GetY(),210,$pdf->GetY());
$pdf->Ln();


////////////////////////////////////////////////////////////////////////////////////
//////Datos Ventas////////



$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Resumen Dinero");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();


$dineroVentas = $datosInforme->DineroVentaProductos + $datosInforme->DeudasProductos->DineroTotal;
$dineroAlquileres = $datosInforme->Alquileres->DineroAlquileres6Bidones+$datosInforme->Alquileres->DineroAlquileres8Bidones+$datosInforme->Alquileres->DineroAlquileres10Bidones+$datosInforme->Alquileres->DineroAlquileres12Bidones;
$dineroTotal = $dineroVentas+$dineroAlquileres;

$pdf->Write(5,"Dinero Total: " . $dineroTotal ." $");
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero Alquileres: " . $dineroAlquileres ." $");
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero Venta: " . $dineroVentas ." $");
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero Cobrado Venta: " . $datosInforme->DineroVentaProductos ." $");
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero Deudado Venta: " . $datosInforme->DeudasProductos->DineroTotal ." $");

$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Cantidad de Repartos: ".$datosInforme->CantidadDeRepartos);

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Promedios");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero por Dia: ".bcdiv($dineroTotal,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero por Dia Ventas: ".bcdiv($dineroVentas,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero por Dia Alquileres: ".bcdiv($dineroAlquileres,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Resumen de Actividad");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Total Activos: ".$datosInforme->DatosClientes->TotalActivos);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Total Inactivos: ".($datosInforme->DatosClientes->NumeroClientes-$datosInforme->DatosClientes->TotalActivos));


$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Porcentaje de Inactivos: ".(bcdiv($datosInforme->DatosClientes->NumeroClientes-$datosInforme->DatosClientes->TotalActivos,$datosInforme->DatosClientes->NumeroClientes,2)*100)."%");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();


$pdf->AddPage();
$pdf->Ln();$pdf->Ln();$pdf->Ln();


//////Productos Vendidos,Bonificados////////

$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Cantidades de Productos Vendidos");
$pdf->SetX(110);
$pdf->Write(5,"Cantidades de Productos Bonificados");

$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->SetTextColor(0,0,0);

$pdf->Write(5,"Bidones 20L: ".$datosInforme->ProductosVendidos->Bidones20L);
$pdf->SetX(110);
$pdf->Write(5,"Bidones 20L: ".$datosInforme->ProductosBonificados->Bidones20L);

$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones 12L: ".$datosInforme->ProductosVendidos->Bidones12L);
$pdf->SetX(110);
$pdf->Write(5,"Bidones 12L: ".$datosInforme->ProductosBonificados->Bidones20L);

$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones 10L: ".$datosInforme->ProductosVendidos->Bidones10L);
$pdf->SetX(110);
$pdf->Write(5,"Bidones 10L: ".$datosInforme->ProductosBonificados->Bidones10L);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones 8L: ".$datosInforme->ProductosVendidos->Bidones8L);
$pdf->SetX(110);
$pdf->Write(5,"Bidones 8L: ".$datosInforme->ProductosBonificados->Bidones8L);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones 5L: ".$datosInforme->ProductosVendidos->Bidones5L);
$pdf->SetX(110);
$pdf->Write(5,"Bidones 5L: ".$datosInforme->ProductosBonificados->Bidones5L);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Pack Botellas 2L: ".$datosInforme->ProductosVendidos->PackBotellas2L);
$pdf->SetX(110);
$pdf->Write(5,"Pack Botellas 2L: ".$datosInforme->ProductosBonificados->PackBotellas2L);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Pack Botellas 500mL: ".$datosInforme->ProductosVendidos->PackBotellas500mL);
$pdf->SetX(110);
$pdf->Write(5,"Pack Botellas 500mL: ".$datosInforme->ProductosBonificados->PackBotellas500mL);
$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();


$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Promedio de Bidones Retornables Vendidos por Dia");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones de 20L: ".bcdiv($datosInforme->ProductosVendidos->Bidones20L,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones de 12L: ".bcdiv($datosInforme->ProductosVendidos->Bidones12L,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();$pdf->Ln();


//////Dinero Venta Productos////////

$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Dinero Total Productos Vendidos");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();$pdf->Ln();;
$pdf->Write(5,"Dinero: ".($datosInforme->DineroVentaProductos + $datosInforme->DeudasProductos->DineroTotal). " $");
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Promedio de Dinero por Dia de Ventas: ".bcdiv($datosInforme->DineroVentaProductos + $datosInforme->DeudasProductos->DineroTotal,$datosInforme->CantidadDeRepartos,2) . " $");
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Promedio de Productos Descartables Vendidos por Dia");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones de 10L: ".bcdiv($datosInforme->ProductosVendidos->Bidones10L,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones de 8L: ".bcdiv($datosInforme->ProductosVendidos->Bidones8L,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones de 5L: ".bcdiv($datosInforme->ProductosVendidos->Bidones5L,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Botellas de 2L: ".bcdiv($datosInforme->ProductosVendidos->PackBotellas2L,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Botellas de 500mL: ".bcdiv($datosInforme->ProductosVendidos->PackBotellas500mL,$datosInforme->CantidadDeRepartos,2));

$pdf->Ln();$pdf->Ln();$pdf->Ln();

//////Alquileres////////

$pdf->AddPage();
$pdf->SetX(10);
$pdf->SetY(20);
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Cantidades de Bidones de Entregas Alquileres");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones 20L: ".$datosInforme->EntregaAlquileres->Bidones20L);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones 12L: ".$datosInforme->EntregaAlquileres->Bidones12L);
$pdf->Ln();$pdf->Ln();$pdf->Ln();


//////Total Retornables Entregados////////

$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Cantidad Total de Bidones Retornables Entregados");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones de 20L: ". ($datosInforme->ProductosVendidos->Bidones20L+$datosInforme->EntregaAlquileres->Bidones20L+$datosInforme->ProductosBonificados->Bidones20L));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones de 12L: ". ($datosInforme->ProductosVendidos->Bidones12L+$datosInforme->EntregaAlquileres->Bidones12L+$datosInforme->ProductosBonificados->Bidones12L));




$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Promedio de Bidones Retornables Entregados por Dia");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones de 20L: ".bcdiv($datosInforme->ProductosVendidos->Bidones20L+$datosInforme->EntregaAlquileres->Bidones20L+$datosInforme->ProductosBonificados->Bidones20L,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones de 12L: ".bcdiv($datosInforme->ProductosVendidos->Bidones12L+$datosInforme->EntregaAlquileres->Bidones12L+$datosInforme->ProductosBonificados->Bidones12L,$datosInforme->CantidadDeRepartos,2));

$pdf->Ln();$pdf->Ln();$pdf->Ln();



//////Vacios Recuperados////////

$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Vacios Recuperados");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Bidones 20L: ".$datosInforme->VaciosRecuperados->Bidones20L);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones 12L: ".$datosInforme->VaciosRecuperados->Bidones12L);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Balance Vacios: (Entregados - Recuperados)");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Bidones 20L: ".($datosInforme->ProductosVendidos->Bidones20L+$datosInforme->EntregaAlquileres->Bidones20L+$datosInforme->ProductosBonificados->Bidones20L - $datosInforme->VaciosRecuperados->Bidones20L));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Bidones 12L: ".($datosInforme->ProductosVendidos->Bidones12L+$datosInforme->EntregaAlquileres->Bidones12L+$datosInforme->ProductosBonificados->Bidones12L - $datosInforme->VaciosRecuperados->Bidones12L));


$pdf->Ln();$pdf->Ln();



//////Alquileres////////

$pdf->AddPage();

$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Alquileres");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Alquileres 6 Bidones: " . $datosInforme->Alquileres->Alquileres6Bidones);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Alquileres 8 Bidones: " . $datosInforme->Alquileres->Alquileres8Bidones);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Alquileres 10 Bidones: " . $datosInforme->Alquileres->Alquileres10Bidones);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Alquileres 12 Bidones: " . $datosInforme->Alquileres->Alquileres12Bidones);
$pdf->Ln();$pdf->Ln();
if($datosInforme->Alquileres->Alquileres6BidonesPrecioEspecial>0){
$pdf->Write(5,"Alquileres 6 Bidones con Precio Especial: " . $datosInforme->Alquileres->Alquileres6BidonesPrecioEspecial);
$pdf->Ln();$pdf->Ln();
}
if($datosInforme->Alquileres->Alquileres8BidonesPrecioEspecial>0){
$pdf->Write(5,"Alquileres 8 Bidones con Precio Especial: " . $datosInforme->Alquileres->Alquileres8BidonesPrecioEspecial);
$pdf->Ln();$pdf->Ln();
}
if($datosInforme->Alquileres->Alquileres10BidonesPrecioEspecial>0){
$pdf->Write(5,"Alquileres 10 Bidones con Precio Especial: " . $datosInforme->Alquileres->Alquileres10BidonesPrecioEspecial);
$pdf->Ln();$pdf->Ln();
}
if($datosInforme->Alquileres->Alquileres12BidonesPrecioEspecial>0){
$pdf->Write(5,"Alquileres 12 Bidones con Precio Especial: " . $datosInforme->Alquileres->Alquileres12BidonesPrecioEspecial);
$pdf->Ln();$pdf->Ln();
}
$pdf->Write(5,"Dinero Alquileres 6 Bidones: " . $datosInforme->Alquileres->DineroAlquileres6Bidones);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero Alquileres 8 Bidones: " . $datosInforme->Alquileres->DineroAlquileres8Bidones);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero Alquileres 10 Bidones: " . $datosInforme->Alquileres->DineroAlquileres10Bidones);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero Alquileres 12 Bidones: " . $datosInforme->Alquileres->DineroAlquileres12Bidones);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Dinero Total: " . ($datosInforme->Alquileres->DineroAlquileres6Bidones+$datosInforme->Alquileres->DineroAlquileres8Bidones+$datosInforme->Alquileres->DineroAlquileres10Bidones+$datosInforme->Alquileres->DineroAlquileres12Bidones));
$pdf->Ln();$pdf->Ln();


$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Deudas Productos");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

if($datosInforme->DeudasProductos->Numero>0)
{




if($datosInforme->DeudasProductos->Bidones20L>0){
$pdf->Write(5,"Bidones 20L: " . $datosInforme->DeudasProductos->Bidones20L);
$pdf->Ln();$pdf->Ln();
}

if($datosInforme->DeudasProductos->Bidones12L>0){
$pdf->Write(5,"Bidones 12L: " . $datosInforme->DeudasProductos->Bidones12L);
$pdf->Ln();$pdf->Ln();
}

if($datosInforme->DeudasProductos->Bidones10L>0){
$pdf->Write(5,"Bidones 10L: " . $datosInforme->DeudasProductos->Bidones10L);
$pdf->Ln();$pdf->Ln();
}

if($datosInforme->DeudasProductos->Bidones8L>0){
$pdf->Write(5,"Bidones 8L: " . $datosInforme->DeudasProductos->Bidones8L);
$pdf->Ln();$pdf->Ln();
}

if($datosInforme->DeudasProductos->Bidones5L>0){
$pdf->Write(5,"Bidones 5L: " . $datosInforme->DeudasProductos->Bidones5L);
$pdf->Ln();$pdf->Ln();
}

if($datosInforme->DeudasProductos->PackBotellas2L>0){
$pdf->Write(5,"Pack Botellas 2L: " . $datosInforme->DeudasProductos->PackBotellas2L);
$pdf->Ln();$pdf->Ln();
}

if($datosInforme->DeudasProductos->PackBotellas500mL>0){
$pdf->Write(5,"Pack Botellas 500mL: " . $datosInforme->DeudasProductos->PackBotellas500mL);
$pdf->Ln();$pdf->Ln();
}

$pdf->Write(5,"Dinero Total: " . $datosInforme->DeudasProductos->DineroTotal);
$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Numero de Deudas: " . $datosInforme->DeudasProductos->Numero);
$pdf->Ln();$pdf->Ln();

}
else
{

$pdf->Write(5,"No hay deudas productos");
$pdf->Ln();$pdf->Ln();

}

$pdf->AddPage();

$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Datos Sobre Clientes");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Total de Clientes: ".$datosInforme->DatosClientes->NumeroClientes);

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Niveles de Actividad");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();


$numero=10*diferenciaMeses($fechaInicio,$fechaFin);
if($datosInforme->DatosClientes->NivelesDeActividad->Nivel[0]>0){
$pdf->Write(5,"Clientes que se les entrego 1 vez: ".$datosInforme->DatosClientes->NivelesDeActividad->Nivel[0]);
}
$k=1;
while($k<$numero)
  {
    if($datosInforme->DatosClientes->NivelesDeActividad->Nivel[$k]>0){
  $pdf->Ln();$pdf->Ln();
  $pdf->Write(5,"Clientes que se les entrego ".($k+1)." veces: ".$datosInforme->DatosClientes->NivelesDeActividad->Nivel[$k]);
  }
  $k++;
  }

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Resumen de Actividad");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Total Activos: ".$datosInforme->DatosClientes->TotalActivos);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Total Inactivos: ".($datosInforme->DatosClientes->NumeroClientes-$datosInforme->DatosClientes->TotalActivos));


$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Porcentaje de Inactivos: ".(bcdiv($datosInforme->DatosClientes->NumeroClientes-$datosInforme->DatosClientes->TotalActivos,$datosInforme->DatosClientes->NumeroClientes,2)*100)."%");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();



$pdf->AddPage();

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Otros datos");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Numero de Clientes visitados: ".($datosInforme->DatosClientes->NumeroVisitas));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Total de Entregas realizadas: ".($datosInforme->DatosClientes->NumeroEntregas));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Numero de Clientes visitados sin entrega: ".($datosInforme->DatosClientes->NumeroVisitasSinEntrega));


$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Promedios");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes visitados por dia: ".bcdiv($datosInforme->DatosClientes->NumeroVisitas,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que se les entrega por dia: ".bcdiv($datosInforme->DatosClientes->NumeroEntregas,$datosInforme->CantidadDeRepartos,2));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que se los visita y no se les entrega nada por dia: ".bcdiv($datosInforme->DatosClientes->NumeroVisitasSinEntrega,$datosInforme->CantidadDeRepartos,2));



$pdf->AddPage();

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Datos Compras");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();


$pdf->Write(5,"Numero de Clientes que compraron: ".$datosInforme->DatosClientes->TotalActivos);

$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que solo compraron retornables: ".($datosInforme->DatosClientesCompras->SoloRetornables));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->SoloRetornables,$datosInforme->DatosClientes->TotalActivos,2)*100) . "%");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que solo compraron descartables: ".($datosInforme->DatosClientesCompras->SoloDescartables));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->SoloDescartables,$datosInforme->DatosClientes->TotalActivos,2)*100) . "%");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que compraron retornables y descartables: ".($datosInforme->DatosClientesCompras->RetornablesYDescartables));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->RetornablesYDescartables,$datosInforme->DatosClientes->TotalActivos,2)*100) . "%");
$pdf->SetTextColor(0,0,0);


$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Compras de Descartables");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Numero de Clientes que compraron descartables: ".($datosInforme->DatosClientesCompras->Descartables->Numero));


$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que compraron solo bidones descartables: ".($datosInforme->DatosClientesCompras->Descartables->SoloBidones));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->Descartables->SoloBidones,$datosInforme->DatosClientesCompras->Descartables->Numero,2)*100) . "%");
$pdf->SetTextColor(0,0,0);


$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que compraron solo pack de botellas: ".($datosInforme->DatosClientesCompras->Descartables->SoloBotellas));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->Descartables->SoloBotellas,$datosInforme->DatosClientesCompras->Descartables->Numero,2)*100) . "%");
$pdf->SetTextColor(0,0,0);


$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que compraron bidones y pack de botellas: ".($datosInforme->DatosClientesCompras->Descartables->BidonesYBotellas));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->Descartables->BidonesYBotellas,$datosInforme->DatosClientesCompras->Descartables->Numero,2)*100) . "%");
$pdf->SetTextColor(0,0,0);



$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Compras de Solo un producto");
$pdf->SetTextColor(0,0,0);

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que solo compraron bidones de 20L: ".($datosInforme->DatosClientesCompras->SoloBidones20L));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->SoloBidones20L,$datosInforme->DatosClientes->TotalActivos,2)*100) . "%");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que solo compraron bidones de 12L: ".($datosInforme->DatosClientesCompras->SoloBidones12L));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->SoloBidones12L,$datosInforme->DatosClientes->TotalActivos,2)*100) . "%");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que solo compraron bidones de 10L: ".($datosInforme->DatosClientesCompras->SoloBidones10L));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que solo compraron bidones de 8L: ".($datosInforme->DatosClientesCompras->SoloBidones8L));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que solo compraron bidones de 5L: ".($datosInforme->DatosClientesCompras->SoloBidones5L));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que solo compraron pack botellas 2L: ".($datosInforme->DatosClientesCompras->SoloPackBotellas2L));
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que solo compraron pack botellas 500mL: ".($datosInforme->DatosClientesCompras->SoloPackBotellas500mL));




$pdf->AddPage();

$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Compras de Descartables");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"Otros Porcentajes");
$pdf->SetTextColor(0,0,0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Numero de Clientes que compraron descartables: ".($datosInforme->DatosClientesCompras->Descartables->Numero));
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Write(5,"Clientes que compraron 1 producto: ".($datosInforme->DatosClientesCompras->Descartables->UnProducto->Numero));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->Descartables->UnProducto->Numero,$datosInforme->DatosClientesCompras->Descartables->Numero,2)*100) . "%");
$pdf->SetTextColor(0,0,0);


$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que compraron 2 productos: ".($datosInforme->DatosClientesCompras->Descartables->DosProductos->Numero));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->Descartables->DosProductos->Numero,$datosInforme->DatosClientesCompras->Descartables->Numero,2)*100) . "%");
$pdf->SetTextColor(0,0,0);



$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que compraron 3 productos: ".($datosInforme->DatosClientesCompras->Descartables->TresProductos->Numero));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->Descartables->TresProductos->Numero,$datosInforme->DatosClientesCompras->Descartables->Numero,2)*100) . "%");
$pdf->SetTextColor(0,0,0);


$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que compraron 4 productos: ".($datosInforme->DatosClientesCompras->Descartables->CuatroProductos->Numero));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->Descartables->CuatroProductos->Numero,$datosInforme->DatosClientesCompras->Descartables->Numero,2)*100) . "%");
$pdf->SetTextColor(0,0,0);


$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Clientes que compraron 5 productos: ".($datosInforme->DatosClientesCompras->Descartables->CincoProductos->Numero));
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->DatosClientesCompras->Descartables->CincoProductos->Numero,$datosInforme->DatosClientesCompras->Descartables->Numero,2)*100) . "%");
$pdf->SetTextColor(0,0,0);






$pdf->Output();





?>
