<?php 
	require 'conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=inventarioEvolucion.xls");
	
	
	$cliente_inv=$_GET['id_cliente'];
	
	
	
?>
<html>
	<head>
		<title>
			ASDA On-line
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body onload="valida_vacio();">
		<article class="col-sm-9">
			<table class="table table-condensed table-bordered cedula_cond" id="dataTables">
				<thead>
					<tr class="">
						<th class="text-center">Etiqueta actual</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Movimiento</th>
						<th class="text-center">Documento</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Picking</th>
						<th class="text-center">Código</th>
						<th class="text-center">Producto</th>
						<th class="text-center">Lote</th>
						<th class="text-center">Vencimiento</th>
						<th class="text-center">Almacen</th>
						<th class="text-center">Peso bruto</th>
						<th class="text-center">tara paleta</th>
						<th class="text-center">tara cesta</th>
						<th class="text-center">Empaques</th>
						<th class="text-center">Unidades</th>
						<th class="text-center">Kilos</th>
						<th class="text-center">Manual</th>
						
					</tr>
				</thead>
				
				<tbody>
					<?php
						$obj= new conectarDB();
						$data= $obj->subconsulta("CALL invEvolucion('".$_GET['id_cliente']."')");
						$dat= json_encode($data);
						if ($dat=='null') {
							echo '';
						}else{
							foreach ($data as $filas) { ?>
								<tr>
									<td><?php echo $filas['etiquetaEvol'] ?></td>
									<td><?php echo $filas['clienteEtiqueta'] ?></td>
									<td><?php echo $filas['movimientoEvol'] ?></td>
									<td class="text-center bg-info"><a href="javascript:documento(<?php echo $filas['pri'] ?>,<?php echo $filas['documentoEvol'] ?>)"><?php echo $filas['documentoEvol'] ?></a></td>
									<td><?php echo $filas['fechaDocumentoEvol'] ?></td>
									<td><?php echo $filas['pickingEvol'] ?></td>
									<td><?php echo $filas['codigoEtiqueta'] ?></td>
									<td><?php echo $filas['productoEtiqueta'] ?></td>
									<td><?php echo $filas['loteEtiqueta'] ?></td>
									<td><?php echo $filas['venceEtiqueta'] ?></td>
									<td><?php echo $filas['almacenEtiqueta'] ?></td>
									<td class="text-right"><?php echo number_format($filas['pesoProducto'],2,",","") ?></td>
									<td class="text-right"><?php echo $filas['tarapaleta'] ?></td>
									<td class="text-right"><?php echo $filas['taracesta'] ?></td>
									<td class="text-right"><?php echo number_format($filas['empaques'],0,",","") ?></td>
									<td class="text-right"><?php echo number_format($filas['unidades'],0,",","") ?></td>
									<td class="text-right"><?php echo number_format($filas['kilos'],2,",","") ?></td>
									<td class="text-right"><?php echo $filas['despachoManual'] ?></td>
								</tr>
												
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</article>
	</body>
</html>