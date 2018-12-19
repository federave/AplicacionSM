<?php
//Agregamos la libreria FPDF
require('../../fpdf/fpdf.php');
include_once('../../modelo/conector.php');
include_once('../../modelo/trabajadores/trabajador.php');

require('obtenerDatosInactivosVendedor.php');
$datosInforme = new SimpleXMLElement($xml->toString());

require('crearInformeInactivosVendedoresExcel.php');




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
$pdf->Text(100-$pdf->GetStringWidth("Informe de Inactivos")/2,15,"Informe de Inactivos");


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
$pdf->Write(5,"Total Clientes: ".$datosInforme->NumeroClientes);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Total Activos: ".$datosInforme->TotalActivos);
$pdf->Ln();$pdf->Ln();
$pdf->Write(5,"Total Inactivos: ".$datosInforme->Numero);
$pdf->SetTextColor(0,0,0xFF);
$pdf->Write(5,"  =  ".(bcdiv($datosInforme->Numero,$datosInforme->NumeroClientes,2)*100)."%");
$pdf->SetTextColor(0,0,0);




$pdf->Ln();$pdf->Ln();
$pdf->Line(0,$pdf->GetY(),210,$pdf->GetY());
$pdf->Ln();


////////////////////////////////////////////////////////////////////////////////////


$pdf->SetFont('Times','',12); //Establecemos tipo de fuente, negrita y tamaño 16

$numero = $datosInforme->Numero;

$pdf->Ln();
$pdf->Ln();




function insertarCabecera($pdf,$inicioY)
{

$inicioX=0;
$alto=15;
$anchoNombre=55;
$anchoDireccion=55;
$anchoTelefono=35;
$anchoTipo=35;
$anchoDia=30;


$inicioX=0;

$pdf->SetXY($inicioX+8,$inicioY+5);
$pdf->Write(5,"Descripcion");

$inicioX+=$anchoNombre;
$pdf->SetXY($inicioX+8,$inicioY+5);
$pdf->Write(5,"Direccion");

$inicioX+=$anchoDireccion;
$pdf->SetXY($inicioX+8,$inicioY+5);
$pdf->Write(5,"Telefono");

$inicioX+=$anchoTelefono;
$pdf->SetXY($inicioX+8,$inicioY+5);
$pdf->Write(5,"Tipo");

$inicioX+=$anchoTipo;
$pdf->SetXY($inicioX+8,$inicioY+5);
$pdf->Write(5,"Dia");


}

function insertarFila($pdf,$inicioY,$nombre,$direccion,$telefono,$tipo,$dia)
{


$inicioX=0;
$alto=15;
$anchoNombre=55;
$anchoDireccion=55;
$anchoTelefono=35;
$anchoTipo=35;
$anchoDia=30;

//Lineas Horizontales

$pdf->Line(0,$inicioY,210,$inicioY);
$pdf->Line(0,$inicioY+$alto,210,$inicioY+$alto);

//Lineas Verticales
$inicioX+=$anchoNombre;
$pdf->Line($inicioX,$inicioY,$inicioX,$inicioY+$alto);
$inicioX+=$anchoDireccion;
$pdf->Line($inicioX,$inicioY,$inicioX,$inicioY+$alto);
$inicioX+=$anchoTelefono;
$pdf->Line($inicioX,$inicioY,$inicioX,$inicioY+$alto);
$inicioX+=$anchoTipo;
$pdf->Line($inicioX,$inicioY,$inicioX,$inicioY+$alto);


$inicioX=0;

$pdf->SetXY($inicioX+1,$inicioY+5);
$pdf->Write(5,$nombre);

$inicioX+=$anchoNombre;
$pdf->SetXY($inicioX+1,$inicioY+5);
$pdf->Write(5,$direccion);

$inicioX+=$anchoDireccion;
$pdf->SetXY($inicioX+1,$inicioY+5);
$pdf->Write(5,$telefono);

$inicioX+=$anchoTelefono;
$pdf->SetXY($inicioX+1,$inicioY+5);
$pdf->Write(5,$tipo);

$inicioX+=$anchoTipo;
$pdf->SetXY($inicioX+1,$inicioY+5);
$pdf->Write(5,$dia);


}


$hoja=1;

$pdf->AddPage();
$pdf->SetXY(5,10);
$pdf->Write(5,"Hoja: ".$hoja."     Ordenados por Tipo de Cliente");
insertarCabecera($pdf,20);
$inicioY=35;


$k=0;
$aux=false;
while($k<$numero)
  {

  $nombre=$datosInforme->OrdenTipoCliente->Cliente[$k]->IdCliente." ".$datosInforme->OrdenTipoCliente->Cliente[$k]->Nombre;
  $direccion=$datosInforme->OrdenTipoCliente->Cliente[$k]->Direccion;
  $telefono=$datosInforme->OrdenTipoCliente->Cliente[$k]->Telefono;
  $tipo=$datosInforme->OrdenTipoCliente->Cliente[$k]->Tipo;
  $dia=$datosInforme->OrdenTipoCliente->Cliente[$k]->Dia;

  insertarFila($pdf,$inicioY,$nombre,$direccion,$telefono,$tipo,$dia);
  $inicioY+=15;



  $k++;


  if(($k % 15) == 0)
    {
    $hoja++;
    $pdf->AddPage();
    insertarCabecera($pdf,20);
    $pdf->SetXY(5,10);
    $pdf->Write(5,"Hoja: ".$hoja ."     Ordenados por Tipo de Cliente");
    $inicioY=35;
    }



  }



  $hoja=1;

  $pdf->AddPage();
  $pdf->SetXY(5,10);
  $pdf->Write(5,"Hoja: ".$hoja."     Ordenados por Dia");
  insertarCabecera($pdf,20);
  $inicioY=35;


  $k=0;
  $aux=false;
  while($k<$numero)
    {

    $nombre=$datosInforme->OrdenDia->Cliente[$k]->IdCliente." ".$datosInforme->OrdenDia->Cliente[$k]->Nombre;
    $direccion=$datosInforme->OrdenDia->Cliente[$k]->Direccion;
    $telefono=$datosInforme->OrdenDia->Cliente[$k]->Telefono;
    $tipo=$datosInforme->OrdenDia->Cliente[$k]->Tipo;
    $dia=$datosInforme->OrdenDia->Cliente[$k]->Dia;

    insertarFila($pdf,$inicioY,$nombre,$direccion,$telefono,$tipo,$dia);
    $inicioY+=15;



    $k++;


    if(($k % 15) == 0)
      {
      $hoja++;
      $pdf->AddPage();
      insertarCabecera($pdf,20);
      $pdf->SetXY(5,10);
      $pdf->Write(5,"Hoja: ".$hoja."     Ordenados por Dia");
      $inicioY=35;
      }



    }





$pdf->Output();














?>
