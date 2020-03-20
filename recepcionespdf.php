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
	<body>';

			$obj= new conectarDB();
			$data= $obj->subconsulta("CALL recepcionesSelect('".$_GET['numRecep']."')");
                
            
$codigohtml.='
    <div class="tablaPdf">
        <div class="tablaA">        
            <table width="380" border="0" >
				<tr>
					<td align="center" width="80"><img src="../aplicaciones/imagenes/logo.png" width="80" height="85"></td>
					<td align="center"><b>ACTA DE RECEPCION</b><br>
					<b><u>Número '.str_pad($data[0]['num_recep'], 7, "0", STR_PAD_LEFT).'</u></b><br>
					</td>
                    <td><div id="codigoQR"></div></td>
				</tr>
			</table>
            <table border="0" >
				<tr>
					<td width="440px">
						<div><b>Cliente </b>'.$data[0]['clienteName_recep'].'</div>
						<div><b>Fecha </b>'.$data[0]['fecha_recep'].'</div>
						<div><b>Movimiento </b>'.$data[0]['movimient_recep'].' 
						';
						if($data[0]['movimient_recep']=="complemento"){
						
						$codigohtml.='
							<b>  Original </b>'.$data[0]['num_original'].'
						';
							
							
						}
						
						
		$codigohtml.='				
						</div>
						<div><b>Elaborado por </b>'.$data[0]['usuario_recep'].'</div>
						<div><b>Documento cliente </b>'.$data[0]['documento_clie_recep'].'</div>
                        <div><b>Valido contabilidad </b>'.$data[0]['valido_contabili'].'</div>
						<div><b>Paletas recibidas </b>'.$data[0]['paletas_ingreso'].'</div>
						
					</td>
					<td width="350px" >
						<div style="margin-left:10px">
							<div><b>Transporte </b>'.$data[0]['transport_recep'].'</div>
							<div><b>Conductor </b>'.$data[0]['conductor_recep'].'</div>
							<div><b>Vehículo </b>'.$data[0]['vehiculo_recp'].' <b>Trailer </b>'.$data[0]['trailer_recp'].' </div>
							<div><b>Contenedor </b>'.$data[0]['vehiculo_contenedor_recp'].'</div>
							<div><b>Llegada </b>'.date("d-m-Y",strtotime($data[0]['vehiculo_llegada_recp'])).' <b>Hora </b>'.$data[0]['vehiculohora_llegada_recp'].'</div>
							<div><b>Peso </b>'.$data[0]['kilos_transportados'].'</div>
							<div><b>Temperatura </b>'.$data[0]['temperatura_rece'].'</div>
							<div class=""><b>Precintos </b><span class="letras3">'.$data[0]['vehiculo_precinto_recp'].'</span></div>
						</div>
					</td>
				</tr>
			</table>
        </div>
         <div class="tablaB">
            <table border="1" style="border-collapse: collapse" width="95%">
				<tr align="center">
					<th>Código</th>
					<th>Producto</th>
					<th>Lote</td>
					<th>Vencimiento</th>
					<th>Etiquetas</td>
					<th>Empaques</th>
                    <th>Unidades</th>
					<th>Kilos</th>
				</tr>
    		
';
    
            $obj= new conectarDB();
			$datas= $obj->subconsulta("CALL etiquetasPDF('".$_GET['numRecep']."')");
			$totalE=0;
            $total=0;
			$totalK=0;
			foreach ($datas as $filas) {
				$totalE=$totalE+$filas['empaques'];
                $total=$total+$filas['unidades'];
				$totalK=$totalK+$filas['kilos'];
			$codigohtml.='
				<tr>
					<td>'. $filas['codigoEtiqueta'].'</td>
					<td>'. $filas['productoEtiqueta'].'</td>
					<td>'. $filas['loteEtiqueta'].'</td>
					<td align=center>'. $filas['venceEtiqueta'].'</td>
					<td align=center>'. $filas['paletasllenas'].'</td>
					<td align=right >'. number_format($filas['empaques'],0).'</td>
                    <td align=right>'. number_format($filas['unidades'],0).'</td>
					<td align=right>'. number_format($filas['kilos'],2).'</td>
				</tr>';
			}
			$codigohtml.='
				<tr>
					<td colspan=5 align=right><b>Totales</b></td>
					<td align=right>'. number_format($totalE,0).'</td>
                    <td align=right>'. number_format($total,0).'</td>
					<td align=right>'. number_format($totalK,2).'</td>
				</tr>
			</thead>
			<tfoot>
    	</table>
    </div>
    <div class="tablaC"> 
        <table class="" border="1" style="border-collapse: collapse" width="400" >
				<tr align="center">
					<th>Código</th>
					<th>Producto</th>
					<th style="width:80px">Unidades</th
					<th style="width:80px">Kilos</th>
				</tr>';
    
            $obj= new conectarDB();
			$datas= $obj->subconsulta("CALL etiquetasCestas('".$_GET['numRecep']."')");
			$totalcest=0;
			$totalKcest=0;
			foreach ($datas as $filas) {
				$totalUC=$totalcest+$filas['cestas'];
				$totalUK=$totalKcest+$filas['kilos'];
			$codigohtml.='
				<tr>
					<td>'. $filas['codigoEtiqueta'].'</td>
					<td>'. $filas['productoEtiqueta'].'</td>
					<td align=right>'. number_format($filas['cestas'],0).'</td>
					<td align=right>'. number_format($filas['kilos'],2).'</td>
				</tr>';
			}
			$codigohtml.='
				<tr>
					<td colspan=2 align=right><b>Total cestas</b></td>
					<td align=right>'. number_format($totalUC,0).'</td>
					<td align=right>'. number_format($totalUK,2).'</td>
				</tr>
                
                <tr>
                	<td colspan=2 align=right><b>Total recepción</b></td>
					<td align=right>'. number_format($total+$totalUC,0).'</td>
					<td align=right>'. number_format($totalK+$totalUK,2).'</td>
				</tr>
			</thead>
			<tfoot>
		</table>
    </div>	
    <div class="tablaD">  
        <div id="capa1"> 
            <b>Elaborado por :'.$data[0]['usuario_recep'].' &nbsp;&nbsp;   Chequado por_____________________________  &nbsp;&nbsp;  Supervisado por:_____________________________</b><br/>
			<h3>Observaciones </h3><span>'.$data[0]['observac_recep'].'</span>
		</div>
        
        <div id="capa2"> 
            <img src="../aplicaciones/imagenes/logo.png" width="80" height="85" style="filter:alpha(opacity=38);-moz-opacity:.38;opacity:.38"> 
        </div>
 	</div>
    <div class="fixed letras"> Acta de recepción '.$_GET['numRecep'].' Emitido el '.date('d/m/Y h:i:s').'</div>
		';	
			

$codigohtml.='  
    <script src="../plantillas/bootstrap/js/jquery-1.11.1.min.js"></script>
			<script src="../plantillas/bootstrap/js/qart.min.js"></script>
    </body>
</html>';

		$dompdf  =  new DOMPDF ( ) ;
		$dompdf -> load_html ( $codigohtml ) ;
		$dompdf -> set_paper ( "letter" ,  "portrait"  ) ;
			ini_set ("memory_limit", "124M") ;
		$dompdf -> render () ;
		$dompdf -> stream ( "my_pdf.pdf" , array ( "Attachment"  =>  0 )); //para que se vea en pantalla
		$dompdf -> stream ( " pickinglist.pdf" ) ; 

//	echo $codigohtml;
?>
