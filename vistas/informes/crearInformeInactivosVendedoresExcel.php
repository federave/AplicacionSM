<?php


require('../../PHPExcel-1.8/Classes/PHPExcel.php');



function insertarFilaExcel($hoja,$fila,$objPHPExcel,$nombre,$direccion,$telefono,$tipo,$dia)
{
$objPHPExcel->setActiveSheetIndex($hoja)
            ->setCellValue('A'.$fila,$nombre)
            ->setCellValue('B'.$fila,$direccion)
            ->setCellValue('C'.$fila,$telefono)
            ->setCellValue('D'.$fila,$tipo)
            ->setCellValue('E'.$fila,$dia);

}


$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Descripcion')
            ->setCellValue('B1', 'Direccion')
            ->setCellValue('C1', 'Telefono')
            ->setCellValue('D1', 'Tipo de Cliente')
            ->setCellValue('E1', 'Dia');


$objPHPExcel->getActiveSheet()->setTitle('Inactivos');



$numero = $datosInforme->Numero;


$k=0;
while($k<$numero)
  {

  $nombre=$datosInforme->OrdenTipoCliente->Cliente[$k]->IdCliente." ".$datosInforme->OrdenTipoCliente->Cliente[$k]->Nombre;
  $direccion=$datosInforme->OrdenTipoCliente->Cliente[$k]->Direccion;
  $telefono=$datosInforme->OrdenTipoCliente->Cliente[$k]->Telefono;
  $tipo=$datosInforme->OrdenTipoCliente->Cliente[$k]->Tipo;
  $dia=$datosInforme->OrdenTipoCliente->Cliente[$k]->Dia;

  insertarFilaExcel(0,($k+2),$objPHPExcel,$nombre,$direccion,$telefono,$tipo,$dia);
  $k++;

  }





$objPHPExcel->createSheet();




$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', 'Descripcion')
            ->setCellValue('B1', 'Direccion')
            ->setCellValue('C1', 'Telefono')
            ->setCellValue('D1', 'Tipo de Cliente')
            ->setCellValue('E1', 'Dia');


$objPHPExcel->getActiveSheet()->setTitle('Inactivos');


$k=0;
while($k<$numero)
  {

  $nombre=$datosInforme->OrdenDia->Cliente[$k]->IdCliente." ".$datosInforme->OrdenTipoCliente->Cliente[$k]->Nombre;
  $direccion=$datosInforme->OrdenDia->Cliente[$k]->Direccion;
  $telefono=$datosInforme->OrdenDia->Cliente[$k]->Telefono;
  $tipo=$datosInforme->OrdenDia->Cliente[$k]->Tipo;
  $dia=$datosInforme->OrdenDia->Cliente[$k]->Dia;

  insertarFilaExcel(1,($k+2),$objPHPExcel,$nombre,$direccion,$telefono,$tipo,$dia);
  $k++;

  }





$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . "INFORME" . '.xlsx"');
$objWriter->save('php://output');









 ?>
