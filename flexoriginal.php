<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();

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
		<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
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
				<h3 class="titulos">Data recepciones registradas</h3>
			</div>
			<div class="nuevo">
				<input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Nuevo">
			</div>
		</div>
    </header>
    <div id='main'>
      <article>article
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
						<thead>
							<tr class="bg-success">
								<th class="text-center">Cliente</th>
								<th class="text-center">Fecha</th>
								<th class="text-center">Recepcion</th>
								<th class="text-center">Movimiento</th>
								<th class="text-center">Solicitud</th>
								<th class="text-center">Acción</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$obj= new conectarDB();
								$data= $obj->subconsulta("CALL recepcionesActivas('0')");
								$dat= json_encode($data);
								if ($dat=='null') {
									echo '';
								}else{
									foreach ($data as $filas) { ?>
										<tr>
											<td><?php echo $filas['clienteName_recep'] ?></td>
											<td><?php echo $filas['fecha_recep'] ?></td>
											<td><?php echo $filas['num_recep'] ?></td>
											<td><?php echo $filas['movimient_recep'] ?></td>
											<td><?php echo $filas['documento_clie_recep'] ?></td>
											<td class="text-center icono">
												<a href='javascript:modal(<?php echo $filas['num_recep'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar'</a>
												<a href='recepciones_Etiquetas.php?numRecep=<?php echo $filas['num_recep'] ?>&numCli=<?php echo $filas['cliente_recep'] ?>' class='fas fa-download' title='Ingresar productos'</a>
												<a href='javascript:confirma(<?php echo $filas['num_recep'] ?>,<?php echo $niveles ?>)' class='fas fa-trash-alt' title='Modificar estado'</a>
											</td>
										</tr>
										<?php } ?>
								<?php } ?>
								<!--Fin del if $dat-->
						</tbody>
					</table>
      </article>
      <nav>
      	<?php include "aplicaciones/nav/menuizquierda.html" ?>
      </nav>
      <aside>aside</aside>
    </div>
    <footer>footer</footer>
    <div>
		<script src="aplicaciones/js/jquery-1.11.1.min.js"></script>
		<script src="aplicaciones/js/bootstrap.min.js"></script>
		<script src="aplicaciones/js/bootstrap-submenu.min.js"></script>
		<script src="aplicaciones/js/jquery.dataTables.min.js"></script>
		<script src="aplicaciones/js/sweetalert.min.js"></script>
		<script src="aplicaciones/js/jsConstantes.js"></script>
		<script src="aplicaciones/js/recepcion.js"></script>
	</div>
  </body>
</html>