<?php
require 'conectarBD/conectarASDA.php';

//URL del pdf esta en codigoBarra
require('aplicaciones/php/codigoBarra.php');
//con P para verticar y con L apaisado
$pdf=new PDF_Code39('L','mm','Letter');


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);


$obj= new conectarDB();
$datas= $obj->subconsulta("CALL etiquetasSelectRecepcion('".$_GET['recep']."')");



foreach ($datas as $filas) 
{
   /* $code =$row[""];*/
    $coorde = $filas['coordenadaEtiqueta'];
    $etiquetas = $filas['etiquetaEtiqueta'];
    $recepcio =$filas['recepcionEtiqueta'];
	$recepciofech =$filas['fechaEtiqueta'];
	$client =$filas['clienteEtiqueta'];
	$codig =$filas['codigoEtiqueta'];
	$produc =$filas['productoEtiqueta'];
	$lotes =$filas['loteEtiqueta'];
	$factur =$filas['documento_clie_recep'];
	$unidade =$filas['unidades'];
	$kilo =$filas['kilos'];
	$present =$filas['presentacionPord'];
	$vence =$filas['venceEtiqueta'];
	
 /*
	$pdf->SetFont('Arial','IB',12); 
	$pdf->Cell(80);//alineacion horizontal
	$pdf->Cell(50,10,'Nº '.str_pad($code, 7, "0", STR_PAD_LEFT),0,0,'C'); 
*/
	$pdf->Image('aplicaciones/imagenes/logo.png',240,8,25); //derecha/izquierda,arriba/abajo/tamaÃ±o
    $pdf->Code39(2,14,str_pad($etiquetas, 7, "0", STR_PAD_LEFT),1,10);
	$pdf->Ln(49); //salto de linea
	
	$pdf->SetFont('Arial','IB',60); 
	
	$pdf->Cell(48);
	$pdf->Cell(45,-75,$coorde,0,0,'L',false); 
	$pdf->Ln(15); //salto de linea
   
    
    $pdf->SetFont('Arial','IB',40); 
   
	$pdf->Cell(8,-55,'Etiqueta:',0,0,'L',false);
    
    $pdf->SetFont('Arial','IB',70); 
    $pdf->Cell(80);
    $pdf->Cell(20,-55,$etiquetas,0,0,'L',false); 
	$pdf->Ln(5); //salto de linea
	
	
	//$pdf->Cell(50,22,utf-8-8_decode('Código: ').$codig.'  '.$produc,0,0,'L',false);  //para los caracteres especiales
    $pdf->Cell(50,-15,$codig,0,0,'L',false);  
	$pdf->Ln(9); //salto de linea

    
    $pdf->SetFont('Arial','IB',26); 
	$pdf->Cell(50,3,$produc,0,0,'L',false);
    $pdf->Ln(0); //salto de linea
    
	$pdf->Cell(5,25,'Ingreso: '.$recepcio.' Fecha '.$recepciofech,0,0,'L',false);  
	$pdf->Ln(9); //salto de linea
	
	
	$pdf->Cell(50,30,$client.'  Factura: '.$factur,0,0,'L',false);  
    $pdf->Ln(9); //salto de linea
    
  	$pdf->SetFont('Arial','IB',70); 
    $pdf->Cell(50,42,'Venc: '.$vence,0,0,'L',false);  
	$pdf->Ln(25); //salto de linea
    
    $pdf->SetFont('Arial','IB',45); 
    $pdf->Cell(50,35,'Lote: '.$lotes,0,0,'L',false);  
	$pdf->Ln(14); //salto de linea
	
	$pdf->Cell(50,45,'Unidades: '.$unidade.'   Kilos: '.$kilo,0,0,'L',false);
	$pdf->Ln(20); //salto de linea
    
   	$pdf->AddPage();
}
	
	$pdf->Output('etiquetas.pdf','I');
?>


