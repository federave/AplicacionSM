<?php


require('../../PHPExcel-1.8/Classes/PHPExcel.php');


$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Descripcion')
            ->setCellValue('B1', 'Direccion')
            ->setCellValue('C1', 'Telefono')
            ->setCellValue('D1', 'Tipo de Cliente')
            ->setCellValue('E1', 'Dia');


$objPHPExcel->getActiveSheet()->setTitle('Usuarios');
$objPHPExcel->setActiveSheetIndex(0);



$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Descripcion');


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . "INFORME" . '.xlsx"');
$objWriter->save('php://output');









 ?>
