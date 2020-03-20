<?php
	require 'conectarBD/conectarASDA.php';
	require_once ("plantillas/dompdf/dompdf_config.inc.php");
	$fecha = date("d-m-Y H:i:s");
    set_time_limit(320); 
    
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['id_cliente']."')");

$codigohtml='
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8-8" >
		<link rel="stylesheet" href="plantillas/css/style.css">
	</head>
	<body>
    
        <table width="530" align="center" height="35" border="0">
			<tr>
				<td><img src="plantillas/imagenes/logo.png" width="85px"></td>
				<td align="center"><b width="300" align="left">INVENTARIO DISPONIBLE POR ETIQUETA <br>
                  '.$data[0]['nombre_cli'].'  
                </b>
                </td>
			</tr>
		</table>

		<table width="100%" border="1" style="border-collapse: collapse" class="letras2">
		<thead>
			<tr class="bg-info">
                <th class="text-center">Etiqueta</th>
				<th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Lote</th>
                <th class="text-center">Ubicación</th>
                <th class="text-center">Almacen</th>
                <th class="text-center">Unidades</th>
                <th class="text-center">Kilos</th>
                <th class="text-center">Empaques</th>
			</tr>';
			$obj= new conectarDB();
			$data= $obj->subconsulta("CALL inv_DisponiblePorEtiqueta('".$_GET['id_cliente']."')");
            $totalU=0;
            $totalK=0;
            $totaep=0;
			foreach ($data as $filas) {
                $totalU=$totalU+$filas['unidades'];
                $totalK=$totalK+$filas['kilos'];
                $totaep=$totaep+$filas['empaques'];
			$codigohtml.='
				<tr style="padding:0">
					<td align="">'. $filas['etiquetaEvol'].'</td>
                    <td align="">'. $filas['codigoEtiqueta'].'</td>
					<td align="">'. $filas['productoEtiqueta'].'</td>
                    <td align="">'. $filas['loteEtiqueta'].'</td>
					<td align="">'. $filas['ubicaEtiqueta'].'</td>
					<td align="center">'. $filas['almacenEtiqueta'].'</td>
                    <td align="right">'.number_format($filas['empaques'],0).'</td>
					<td align="right">'.number_format($filas['unidades'],0).'</td>
					<td align="right">'.number_format($filas['kilos'],2).'</td>
                    
				</tr>';
			}
            $codigohtml.='
                <tr>
                    <td colspan="6" align="right"><b>Totales</b></td>
                     <td align="right">'.number_format($totaep,0).'</td>
                    <td align="right">'.number_format($totalU,0).'</td>
                    <td align="right">'.number_format($totalK,2).'</td>
                   
                </tr>
			</thead>
			<tfoot>
		</table>
		<div class="fixed letras col-sm-12"> Inventario Emitido el '.$fecha.'</div>
        <script type="text/php">
          if (isset($pdf))
            {
              $font = Font_Metrics::get_font("Arial", "bold");
              $pdf->page_text(450, 770, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }
        </script>

		
	</body>
</html>';

		$dompdf  =  new DOMPDF ( ) ;
		$dompdf -> load_html ( $codigohtml ) ;
		$dompdf -> set_paper ( "letter" ,  "portrait"  ) ;
			ini_set ("memory_limit", "124M") ;
		$dompdf -> render () ;
		$dompdf -> stream ( "my_pdf.pdf" , array ( "Attachment"  =>  0 )); //para que se vea en pantalla
		$dompdf -> stream ( " seguros.pdf" ) ;
$dompdf->page_text(1,1, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
	echo $codigohtml;
?>
