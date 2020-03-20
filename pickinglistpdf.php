<?php
	require '../conectarBD/conectarASDA.php';
	require_once ("../plantillas/dompdf/dompdf_config.inc.php");
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
		<table border="0" class="tablasEnc">
			<tr>
				<td style="width:220px"><img src="../aplicaciones/imagenes/logo.png" width="120px"></td>
				
			';
			$obj= new conectarDB();
			$data= $obj->subconsulta("CALL pickinglistPorNumero('".$_GET['id_picking']."')");

$codigohtml.='
				
				<td style="width:420px">
					Picking List '.$data[0]['numPicking'].'<br>
					Cliente		 '. $data[0]['clientePickingNomb'].'<br>
					Fecha			 '. $data[0]['fechaPicking'].'<br>
					Elaborado por '. $data[0]['usuarioPicking'].'<br>
				</td>
				<td style="width:320px">
					Destino		 '. $data[0]['destinoCiudadPicking'].'<br>
					Cliente			 '. $data[0]['destinoClientPicking'].'<br>
					Factura '. $data[0]['documentoPedido'].'<br>
				</td>

			</tr>
		</table>

		<table border="1" cellspacing=0 cellpadding=2 class="tablasEnc" style="width:100%">
		<thead>
			<tr class="bg-info">
				<th class="text-center">Coordenada</th>
				<th class="text-center">Código</th>
				<th class="text-center">Producto</th>
				<th class="text-center">Lote</th>
				<th class="text-center">Vencimiento</th>
                <th class="text-center">Etiqueta nueva</th>
                <th class="text-center">Etiqueta anterior</th>
				<th class="text-center">Etiqueta manual</th>
                <th class="text-center">Empaques</th>
				<th class="text-center">Unidades</th>
				<th class="text-center">kilos</th>
				<th class="text-center">Ubicación</th>
				<th class="text-center">Almacen</th>
			</tr>';
			$obj= new conectarDB();
			$data= $obj->subconsulta("CALL pickinglistEtiquetas('".$_GET['id_picking']."')");
			$total=0;
			$totalK=0;
            $totalE=0;
			foreach ($data as $filas) {
                $totalE=$totalE+$filas['empaques'];
				$total=$total+$filas['unidades'];
				$totalK=$totalK+$filas['kilos'];
			$codigohtml.='
				<tr>
					<td>'. $filas['coordenadaEtiqueta'].'</td>
					<td>'. $filas['codigoEtiqueta'].'</td>
					<td>'. $filas['productoEtiqueta'].'</td>
					<td>'. $filas['loteEtiqueta'].'</td>
					<td align=center>'. $filas['venceEtiqueta'].'</td>
					<td align=center>'. $filas['etiquetaEvol'].'</td>
                    <td align=center>'. $filas['etiquetavieja'].'</td>
					<td align=center>'. $filas['manualEtiqueta'].'</td>
                    <td align=right>'.$filas['empaques'].'</td>
					<td align=right>'.$filas['unidades'].'</td>
					<td align=right>'. $filas['kilos'].'</td>
					<td>'. $filas['ubicaEtiqueta'].'</td>
					<td>'. $filas['almacenEtiqueta'].'</td>
				</tr>';
			}
			$codigohtml.='
				<tr>
					<td colspan=8 align=right><b>Totales</b></td>
                    <td align=right>'. $totalE.'</td>
					<td align=right>'. number_format($total,2).'</td>
					<td align=right>'. number_format($totalK,2).'</td>
					<td></td>
					<td></td>
				</tr>
			</thead>
			<tfoot>
		</table>
		<div class="fixed letras"> Picking List '.$_GET['id_picking'].' Emitido el '.$fecha.'</div>
		
		';	
	$codigohtml.='<h1 class="SaltoDePagina"> </h1>	

	<!--Segunda página resumen---------------------------------------------------------------------------------------------->
	<STRONG>RESUMEN</STRONG>
	<table border="0" class="tablasEnc">
			<tr>
				<td style="width:220px"><img src="../aplicaciones/imagenes/logo.png" width="120px"></td>
				
			';
			$obj= new conectarDB();
			$data= $obj->subconsulta("CALL pickinglistPorNumero('".$_GET['id_picking']."')");

$codigohtml.='
				
				<td style="width:420px">
					Picking List '.$data[0]['numPicking'].'<br>
					Cliente		 '. $data[0]['clientePickingNomb'].'<br>
					Fecha			 '. $data[0]['fechaPicking'].'<br>
					Elaborado por '. $data[0]['usuarioPicking'].'<br>
				</td>
				<td style="width:320px">
					Destino		 '. $data[0]['destinoCiudadPicking'].'<br>
					Cliente			 '. $data[0]['destinoClientPicking'].'<br>
					Factura '. $data[0]['documentoPedido'].'<br>
				</td>


			</tr>
		</table>

		<table border="1" cellspacing=0 cellpadding=2 class="tablasEnc" style="width:100%;height:20px">
		<thead>
			<tr class="bg-info">
				<th class="text-center">Código</th>
				<th class="text-center">Producto</th>
				<th class="text-center">Lote</th>
				<th class="text-center">Vencimiento</th>
                <th class="text-center">Empaques</th>
				<th class="text-center">Unidades</th>
				<th class="text-center">kilos</th>
			</tr>';
			$obj= new conectarDB();
			$data= $obj->subconsulta("CALL pickinglistResumenCodigo('".$_GET['id_picking']."')");
			$total=0;
			$totalK=0;
            $totalE=0;
			foreach ($data as $filas) {
                $totalE=$totalE+$filas['empaques'];
				$total=$total+$filas['unidades'];
				$totalK=$totalK+$filas['kilos'];
			$codigohtml.='
				<tr>
					<td>'. $filas['codigoEtiqueta'].'</td>
					<td>'. $filas['productoEtiqueta'].'</td>
					<td>'. $filas['loteEtiqueta'].'</td>
					<td align=center>'. $filas['venceEtiqueta'].'</td>
                    <td align=right>'.$filas['empaques'].'</td>
					<td align=right>'.$filas['unidades'].'</td>
					<td align=right>'. $filas['kilos'].'</td>
				</tr>';
			}
			$codigohtml.='
				<tr>
					<td colspan=4 align=right><b>Totales</b></td>
                    <td align=right>'. $totalE.'</td>
					<td align=right>'. number_format($total,2).'</td>
					<td align=right>'. number_format($totalK,2).'</td>
				</tr>
			</thead>
			<tfoot>
		</table><br/>
		<div class="tablasEnc" ><b>Conductor:_____________________________________cedula___________________</b><br/>
			<b>Hago constar que he verificado la carga y doy fe que los productos se encuentran en buen estado 
		    e igualmente que personalmente he anotado la cantidades de empaques que voy a transportar</b>
        </div>
        
        <table border="1" cellspacing=0 cellpadding=2 class="tablasEnc" style="width:50%;padding-top:40px">
		<thead>
            <tr><th colspan="5">REPORTE POR FAMILIA</th></tr>
			<tr class="bg-info">
				<th class="text-center">Familia</th>
                <th class="text-center">Empaques</th>
				<th class="text-center">Unidades</th>
				<th class="text-center">kilos</th>
                <th class="text-center">Toneladas</th>
			</tr>';
			$obj= new conectarDB();
			$data= $obj->subconsulta("CALL pickinglistResumenFamilia('".$_GET['id_picking']."')");
			$totalEmpaq=0;
            $total=0;
			$totalK=0;
            $totalT=0;
			foreach ($data as $filas) {
                $totalEmpaq=$totalEmpaq+$filas['empaques'];
				$total=$total+$filas['unidades'];
				$totalK=$totalK+$filas['kilos'];
                $totalT=$totalT+$filas['toneladas'];
			$codigohtml.='
				<tr>
					<td style="width:40%">'. $filas['familiaEtiqueta'].'</td>
                    <td align=right>'. $filas['empaques'].'</td>
					<td align=right>'.$filas['unidades'].'</td>
					<td align=right>'.$filas['kilos'].'</td>
                    <td align=right>'. number_format($filas['toneladas'],4).'</td>
				</tr>';
			}
			$codigohtml.='
				<tr>
					<td colspan=1 align=right><b>Totales</b></td>
                    <td align=right>'. $totalEmpaq.'</td>
					<td align=right>'. number_format($total,2).'</td>
					<td align=right>'. number_format($totalK,2).'</td>
                    <td align=right>'. number_format($totalT,4).'</td>
				</tr>
			</thead>
			<tfoot>
		</table><br/>
		
        

		<div class="fixed letras col-sm-12"> Picking List '.$_GET['id_picking'].' Emitido el '.$fecha.'</div>
		
		
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
