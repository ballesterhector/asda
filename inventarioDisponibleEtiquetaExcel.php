<?php 
	require 'conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=disponible_por_etiqueta.xls");
	
	
	$cliente_inv=$_GET['id_cliente'];
	
	
	
?>
<html>
	<head>
		<title>
			ASDA On-line
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8-8" />
	</head>
	<body onload="valida_vacio();">
		<article class="col-sm-9">
					<table class="table table-condensed table-bordered table-responsive letras3" id="dataTables">
						<thead>
							<tr class="bg-info">
							    <th class="text-center">Etiqueta</th>
								<th class="text-center">Cliente</th>
								<th class="text-center">Coordenada</th>
                                <th class="text-center">Código</th>
                                <th class="text-center">Lote</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Ubicación</th>
                                <th class="text-center">Almacen</th>
                                <th class="text-center">Empaques</th>
                                <th class="text-center">Unidades</th>
                                <th class="text-center">Kilos</th>
                           </tr>
						</thead>
						<tbody>
							<?php
                                $obj= new conectarDB();
                                $data= $obj->subconsulta("CALL inv_DisponiblePorEtiqueta('".$_GET['id_cliente']."')");
								$dat= json_encode($data);
								if ($dat=='null') {
									echo '';
								}else{
									foreach ($data as $filas) { ?>
										<tr class="cambio">
											<td><?php echo $filas['etiquetaEvol'] ?></td>
											<td><?php echo $filas['clienteEtiqueta'] ?></td>
											<td><?php echo $filas['coordenadaEtiqueta'] ?></td>
											<td><?php echo $filas['codigoEtiqueta'] ?></td>
											<td><?php echo $filas['loteEtiqueta'] ?></td>
											<td><?php echo $filas['productoEtiqueta'] ?></td>
											<td><?php echo $filas['ubicaEtiqueta'] ?></td>
											<td><?php echo $filas['almacenEtiqueta'] ?></td>
                                            <td class="text-right"><?php echo number_format($filas['empaques'],0,",","") ?></td>
										    <td class="text-right"><?php echo number_format($filas['unidades'],2,",","") ?></td>
											<td class="text-right"><?php echo number_format($filas['kilos'],2,",","") ?></td>
                                        </tr>
									<?php } ?>
								<?php } ?><!--Fin del if $dat-->
						</tbody>
					</table>
				</article>
	</body>
</html>