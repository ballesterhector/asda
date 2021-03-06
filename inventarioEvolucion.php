<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['id_cliente']."')");
	$clientes = $data[0]['nombre_cli'];
?>

<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="utf-8-8">
		<meta name="description" content="Aplicación para control de bienes y suministros">
		<meta name="keywords" content="asda">
		<meta name="author" content="Ballester Héctor @ballesterhector">
		<meta name="viewport" content="width=device-width, user-scalable=0,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
		<title>ASDA On Line</title>
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/bootstrap-submenu.min.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/font-awesome/css/fontawesome-all.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/sweetalert.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/estilosFlex.css">
	</head>
  <body>
    <header>
		<input type="hidden" value="<?php echo $_GET['id_cliente'] ?>" id="idclien">
		<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
		<input type="hidden" id="usuari" value="<?php echo $usuario ?>">
		<div class="menu">
			<div class="logo">
				<a href="#"><img src="aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
			</div>
			<nav class="enlaces" id="enlaces">
				<?php include "aplicaciones/nav/menuarriba.html" ?>
			</nav>
		</div>	
		<div class="enlinea">
			<div class="titulo">
				<h3 class="titulos" id="">Inventario evolución</h3>
			</div>
			<div>
				<select class="form-control" name="" id="cliBusca" autofocus>
					<option value=""><?php echo $clientes ?></option>
					<?php
						$obj = new conectarDB();
						$data = $obj->consultar("CALL clientesSelect('0')");
						foreach($data as $key){
							echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
							}
					?>
				</select>
			</div>
			<div class="nuevo">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/InventariosTeoricos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
			    <a href="javascript: onclick(inventarioExcel())"><i class="fas fa-file-excel fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Archivo Evolución"></i></a>
            </div>
		</div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered cedula_cond" id="dataTables">
			<thead>
			    <tr class="">
					<th class="text-center">Etiqueta actual</th>
					<th class="text-center">Etiqueta anterior</th>
					<th class="text-center">Movimiento</th>
					<th class="text-center">Documento <br><sub>(Link)</sub> </th>
					<th class="text-center">Fecha</th>
					<th class="text-center">Picking</th>
					<th class="text-center">Código</th>
					<th class="text-center">Producto</th>
					<th class="text-center">Lote</th>
					<th class="text-center">Vencimiento</th>
					<th class="text-center">Almacen</th>
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
								<td><?php echo $filas['etiquetavieja'] ?></td>
								<td><?php echo $filas['movimientoEvol'] ?></td>
								<td class="text-center bg-info"><a href="javascript:documento(<?php echo $filas['pri'] ?>,<?php echo $filas['documentoEvol'] ?>)"><?php echo $filas['documentoEvol'] ?></a></td>
								<td><?php echo $filas['fechaDocumentoEvol'] ?></td>
								<td><?php echo $filas['pickingEvol'] ?></td>
								<td><?php echo $filas['codigoEtiqueta'] ?></td>
								<td><?php echo $filas['productoEtiqueta'] ?></td>
								<td><?php echo $filas['loteEtiqueta'] ?></td>
								<td><?php echo $filas['venceEtiqueta'] ?></td>
								<td><?php echo $filas['almacenEtiqueta'] ?></td>
								<td class="text-right"><?php echo $filas['empaques'] ?></td>
								<td class="text-right"><?php echo $filas['unidades'] ?></td>
								<td class="text-right"><?php echo $filas['kilos'] ?></td>
								<td class="text-right"><?php echo $filas['despachoManual'] ?></td>
							</tr>
											
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
      </article>
    </div>
    <footer class="dat">
    	<script>
			var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
			var f=new Date();
			document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		</script>
    </footer>
    <div>
		<script src="aplicaciones/js/jquery-1.11.1.min.js"></script>
		<script src="aplicaciones/js/bootstrap.min.js"></script>
		<script src="aplicaciones/js/bootstrap-submenu.min.js"></script>
		<script src="aplicaciones/js/jquery.dataTables.min.js"></script>
		<script src="aplicaciones/js/sweetalert.min.js"></script>
		<script src="aplicaciones/js/jsConstantes.js"></script>
		<script src="aplicaciones/js/inventarioEvolucion.js"></script>
	</div>
  </body>
</html>