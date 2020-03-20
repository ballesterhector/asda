<?php
	require 'conectarBD/conectarASDA.php';
	require_once ("plantillas/dompdf/dompdf_config.inc.php");
	$fecha = date("d-m-Y H:i:s");
	set_time_limit(320);
$codigohtml='
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8-8" >
		<link rel="stylesheet" type="text/css" href="../aplicaciones/css/estilosFlex.css">
	</head>
	<body>
		<!--<a href="javascript:print()">Imprimir</a>-->
		<table border="0" class="tablaPdf" style="margin-top:20px;margin-left:20px">
			<tr class="tablaconteo">
				<td style="width:220px"><img src="aplicaciones/imagenes/logo.png" width="120px"></td>
				
			';
			$obj= new conectarDB();
			$data= $obj->subconsulta("CALL conteoPorIdentificador('".$_GET['codigo']."')");

$codigohtml.='
				
				<td style="width:420px">
					Cliente		 '. $data[0]['cliente'].'<br>
					Fecha			 '.date("d-m-Y",strtotime($data[0]['fecha'])).'<br>
					Identificador	 '. $data[0]['identificador'].'<br>
					Generado por '. $data[0]['usuario'].'<br>
				</td>
				<td><p>Reporte de resultado de conteo</p></td>
			</tr>
		</table>

		<table border="1" cellspacing=0 cellpadding=2 class="" style="margin-left:12px;width:97%">
		<thead>
			<tr class="tabladatos">
				<th class="text-center" style="width:63px">Coordenada</th>
					<th class="text-center">Etiqueta</th>
					<th class="text-center">Código</th>
					<th class="text-center">Producto</th>
					<th class="text-center" style="width:60px">Lote</th>
					<th class="text-center" style="width:60px">Vence</th>
					<th class="text-center empaque">WMS</th>
					<th class="text-center empaque">Cliente</th>
					<th class="text-center empaque">Fisico</th>
					<th class="text-center">WMS-fisico</th>
					<th class="text-center">cliente-fisico</th>
					<th class="text-center unidades">WMS</th>
					<th class="text-center unidades">Cliente</th>
					<th class="text-center unidades">Fisico</th>
					<th class="text-center">WMS-fisico</th>
					<th class="text-center">cliente-fisico</th>
			</tr>';
			$obj= new conectarDB();
			$data= $obj->subconsulta("CALL conteoPorIdentificador('".$_GET['codigo']."')");
			$total=0;
			$totalK=0;
			$totaEmp=0;
			$totalU=0;
			$totaUniFis=0;
			$totaUnidif=0;
			$unidcliente=0;
			$unidfisico=0;
			$difwmsfisi=0;
			$difclifisi=0;
			foreach ($data as $filas) {
				$total=$total+$filas['empaquesWms'];
				$totalK=$totalK+$filas['empaquesCliente'];
				$totaEmp=$totaEmp+$filas['empaquesFisico'];
				$totalU=$totalU+$filas['diferEmpaWmsFisico'];
				$totaUniFis=$totaUniFis+$filas['diferEmpaClieFisico'];
				$totaUnidif=$totaUnidif+$filas['unidadesWms'];
				$unidcliente=$unidcliente+$filas['unidadesCliente'];
				$unidfisico=$unidfisico+$filas['unidadesFisico'];
				$difwmsfisi=$difwmsfisi+$filas['diferUniWmsFisico'];
				$difclifisi=$difclifisi+$filas['diferUniClieFisico'];
			$codigohtml.='
				<tr class="tabladatos">
					<td>'. $filas['coordenada'].'</td>
					<td>'. $filas['etiqueta'].'</td>
					<td>'. $filas['codigo'].'</td>
					<td>'. $filas['producto'].'</td>
					<td>'. $filas['lote'].'</td>
					<td align=center>'.date("d-m-Y",strtotime($data[0]['vence'])).'</td>
					<td align=right>'. $filas['empaquesWms'].'</td>
					<td align=right>'. $filas['empaquesCliente'].'</td>
					<td align=right>'.$filas['empaquesFisico'].'</td>
					<td align=right>'.$filas['diferEmpaWmsFisico'].'</td>
					<td align=right>'.$filas['diferEmpaClieFisico'].'</td>
					<td align=right>'.number_format($filas['unidadesWms'],2).'</td>
					<td align=right>'.number_format($filas['unidadesCliente'],2).'</td>
					<td align=right>'.number_format($filas['unidadesFisico'],2).'</td>
					<td align=right>'.number_format($filas['diferUniWmsFisico'],2).'</td>
					<td align=right>'.number_format($filas['diferUniClieFisico'],2).'</td>
				</tr>';
			}
			$codigohtml.='
				<tr class="tabladatos">
					<td colspan=6 align=right><b>Totales</b></td>
					<td align=right>'. $total.'</td>
					<td align=right>'. $totalK.'</td>
					<td align=right>'. $totaEmp.'</td>
					<td align=right>'.$totalU.'</td>
					<td align=right>'.$totaUniFis.'</td>
					<td align=right>'.number_format($totaUnidif,2).'</td>
					<td align=right>'.number_format($unidcliente,2).'</td>
					<td align=right>'.number_format($unidfisico,2).'</td>
					<td align=right>'.number_format($difwmsfisi,2).'</td>
					<td align=right>'.number_format($difclifisi,2).'</td>
				</tr>
			</thead>
			<tfoot>
		</table>
		<div class="fixed letras"> Conteo '.$_GET['codigo'].' Emitido el '.$fecha.'</div>
		
			
		
	</body>
</html>';

		$dompdf  =  new DOMPDF ( ) ;
		$dompdf -> load_html ( $codigohtml ) ;
		$dompdf -> set_paper ( "letter" ,  "landscape"  ) ;
			ini_set ("memory_limit", "124M") ;
		$dompdf -> render () ;
		$dompdf -> stream ( "my_pdf.pdf" , array ( "Attachment"  =>  0 )); //para que se vea en pantalla
		$dompdf -> stream ( " pickinglist.pdf" ) ; 

//	echo $codigohtml;
?>
