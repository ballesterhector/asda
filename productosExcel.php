<?php 
	require 'conectarBD/conectarASDA.php';
    header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=Productos.xls");	
	
?>
<html>
	<head>
		<title>
			ASDA On-line
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8-8" />
		<script type="text/javascript" src="librerias/funtion.js"></script>
	</head>
	<body>
		<article class="tabla">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
				<tr class="bg-success">
					<th class="text-center">Cliente</th>
					<th class="text-center">Código</th>
					<th class="text-center">Producto</th>
					<th class="text-center">Presentación</th>
					<th class="text-center">Familia</th>
					<th class="text-center">Alimento?</th>
					<th class="text-center">Tipo</th>
					<th class="text-center">Neto</th>
					<th class="text-center">Bruto</th>
					<th class="text-center">Almacen</th>
					<th class="text-center">Estado</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL productosConsulta('".$_GET['clibus']."')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<tr>
								<td><?php echo $filas['cliente_nomb'] ?></td>
								<td><?php echo $filas['codigo_prod'] ?></td>
								<td><?php echo $filas['descrip_prod'] ?></td>
								<td><?php echo $filas['presen_prod'] ?></td>
								<td><?php echo $filas['familia_prod'] ?></td>
								<td><?php echo $filas['es_alimento'] ?></td>
								<td><?php echo $filas['tipo_prod'] ?></td>
								<td><?php echo $filas['peso_neto'] ?></td>
								<td><?php echo $filas['peso_bruto'] ?></td>
								<td><?php echo $filas['almacen_prod'] ?></td>
								<td><?php echo $filas['estado'] ?></td>
							</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
      </article>
	</body>
</html>