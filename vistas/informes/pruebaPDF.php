
<?php

$valor=$_GET["valor"];

 //Agregamos la libreria FPDF
 require('../../fpdf/fpdf.php');

 $pdf = new FPDF('P','mm','A4');
 $pdf->AddPage(); //Agregamos una Pagina
 $pdf->SetFont('Arial','B',16); //Establecemos tipo de fuente, negrita y tamaño 16
//Agregamos texto en una celda de 40px ancho y 10px de alto, Con Borde, Sin salto de linea y Alineada a la derecha

 //$pdf->Cell(40,10,'Hola, Mundo',1,0,'L');
$pdf->Text(10,10,"AAAAAAAAAAAAAAAAA");

$pdf->SetFont('Arial','B',12); //Establecemos tipo de fuente, negrita y tamaño 16

$pdf->Text(10,30,"BBBBBBBBBBB");

$pdf->Text(10,40,$valor);


 $pdf->Output(); //Mostramos el PDF creado
?>
