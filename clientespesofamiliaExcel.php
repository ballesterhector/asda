<?php 
	require 'conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=clientes peso por familia.xls");
	
	
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
								 <th class="text-center">Cliente</th>
	                            <th class="text-center">Familia</th>
	                            <th class="text-center">Empaques</th>
	                            <th class="text-center">Unidades</th>
	                            <th class="text-center">kilos</th>
	                            <th class="text-center">Toneladas</th>
                           </tr>
						</thead>
				<tbody>
							<?php
                                $obj= new conectarDB();
                                $data= $obj->subconsulta("CALL clientesResumenPesoFamilia('".$_GET['id_cliente']."')");
								$dat= json_encode($data);
								if ($dat=='null') {
									echo '';
								}else{
									foreach ($data as $filas) { ?>
										<tr class="cambio">
											<td class="text-center"><?php echo $filas['clienteEtiqueta'] ?></td>
											<td class=""><?php echo $filas['familiaEtiqueta'] ?></td>
											<td class="text-right"><?php echo $filas['empaques'] ?></td>
											<td class="text-right"><?php echo $filas['unidades'] ?></td>
											<td class="text-right"><?php echo $filas['kilos'] ?></td>
											<td class="text-right"><?php echo number_format($filas['toneladas'],3) ?></td>
                                        </tr>
									<?php } ?>
								<?php } ?><!--Fin del if $dat-->
						</tbody>
			</table>
        </article>
	</body>
</html>