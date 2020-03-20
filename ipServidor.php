<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';

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
		<input type="text" value="<?php echo $niveles ?>" id="nivelUsuario">
		<input type="text" value="<?php echo $cedula ?>" id="cedulas">
		<div class="menu">
			<div class="logo">
				<a href="#"><img src="aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
			</div>
			<nav class="enlaces" id="enlaces">
				<?php include "aplicaciones/nav/menuarriba.html" ?>
			</nav>
		</div>	
		<div class="recepcion">
			<div class="titulo">
				<h3 class="titulos" id="respuesta">Relación IP del servidor</h3>
			</div>
			<div class="ayudarecepcion">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/despachos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="javascript: onclick(despachospdf())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir despacho"></i></a>
                <a href="javascript: onclick(activar())"><i class="fas fa-calendar-check fa-2x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Activar despacho"></i></a>
 			    <input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Nuevo">
            </div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
				<tr class="bg-success">
				    <th class="text-center">ID</th>
					<th class="text-center">IP</th>
					<th class="text-center">Equipo</th>
					<th class="text-center">Entrada por</th>
					<th class="text-center">URL</th>
					<th class="text-center">User</th>
					<th class="text-center">Pass</th>
					<th class="text-center">Observación</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL ipservidor()");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<tr>
								<td><?php echo $filas['id_ip'] ?></td>
								<td><?php echo $filas['ip'] ?></td>
								<td><?php echo $filas['equipo'] ?></td>
								<td><?php echo $filas['entradaPor'] ?></td>
								<td><?php echo $filas['url'] ?></td>
								<td><?php echo $filas['user'] ?></td>
								<td><?php echo $filas['pass'] ?></td>
							   	<td><?php echo $filas['observacion'] ?></td>
							</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
      </article>
      <nav>
      	<?php include "aplicaciones/nav/menuizquierda.html" ?>
      </nav>
    </div>
    <!--Inicio modal nuevo-->
	<div class="form-group">
		<div class="modal fade" id="abreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header bg-info cabeza">
						<h3 class="modal-title fondoLs" id="myModalLabel"></h3>
						<h2 class="mensaje" id="mensaje"></h2>
					</div>
					<form id="formulario" class="form-horizontal" onsubmit="return agregarRegistro();">
						<div class="modal-body">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladotop">
										<label for="" class="recep">Despacho
											<input type="text" class="form-control recep" name="despacho" id="despacho" readonly style="width:80px">
										</label>
										<label for="" class="">Movimiento
											<select class="form-control" name="movimiento" id="movimiento" style="width:120px">
												<option value="despacho">Despacho</option>
												<option value="ajuste">Ajuste</option>
												<option value="complemento">Complemento</option>
											</select>
										</label>
										<div class="origi">
											<label for="">Retiro original
												<input type="text" class="form-control" name="original" id="original" style="width:95px" value="0">
											</label>
										</div>
										<label for="" class="">Cliente
											<select class="form-control" name="numCli" id="name" required="require">
												<option value=""></option>
												<?php
													$obj = new conectarDB();
													$data = $obj->consultar("CALL clientesActivosConsulta('0')");
													foreach($data as $key){
														echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
													}
												?>
											</select>
										</label>
									</div>	
									<div class="subladoG">
										<label for="" class="">Transporte
											<select name='transp' id="transp" class="form-control">
												<?php
													$obj= new conectarDB();
													$data= $obj->subconsulta("CALL transporteActivo()");
													foreach ($data as $key) {
														echo "<option value='".$key['nombre_trans']."'>".$key['nombre_trans']."</option>";
													}
												?>
											</select>
										</label>
										<label for="" class="">Conductor
											<select name='conduct' id="conduct" class="form-control">
												<?php
													$obj= new conectarDB();
													$data= $obj->subconsulta("CALL conductoresActivos()");
													foreach ($data as $key) {
														echo "<option value='".$key['conductor']."'>".$key['conductor']."</option>";
													}
												?>
											</select>
										</label>
									</div>
									<div class="subladoA">
										<label for="" class="vehicu">Vehículos
										    <input type="text" class="form-control" name="vehicu" id="vehicu">
										</label>
										<label for="" class="trailer">Trailer
										    <input type="text" class="form-control" name='trailer' id="trailer">
										</label>
										<label for="" class="contened">Contenedor
											<input type="text" name="contenedor" id="contenedor" class="form-control" value="0" autocomplete="off">
										</label>
										<label for="" class="recepA">Precintos
											<input type="text" name="precint" id="precint" class="form-control">
										</label>
									</div>
									<div class="subladoB">
										<label for="" class="recepA">Ciudad destino
											<input type="text" name="ciudest" id="ciudest" class="form-control">
										</label>
										<label for="" class="recepA">Cliente destino
											<input type="text" name="cliedesti" id="cliedesti" class="form-control">
										</label>
										<label for="" class="">Pedido
											<input type="text" class="form-control" name="factura" id="factura">
										</label>
										<label for="" class="">Fecha
											<input type="date" class="form-control" name="factfecha" id="factfecha" value="<?php echo date("Y-m-d");?>" required>
										</label>
									</div>
									<div class="subladoC">
										<label for="" class="recepC">Temperatura
											<input type="text" name="tempera" id="tempera" value="0" class="form-control tempe" >
										</label>
										<label for="" class="recepC">Peso carga
											<input type="text" name="pesocarga" id="pesocarga" value="0" class="form-control tempe">
										</label>
										<label for="" class="recepC">Pedidas
											<input type="text" name="pedidas" id="pedidas" value="0" class="form-control tempe" >
										</label>
										<label for="" class="recepA">Paletas
											<input type="text" name="paletas" id="paletas" value="0" class="form-control palet">
										</label>
										<label for="" class="recepA">Llenas
											<input type="text" name="llenas" id="llenas" value="0" class="form-control palet">
										</label>
										<label for="" class="recepA">Vacias
											<input type="text" name="vacia" id="vacia" value="0" class="form-control palet">
										</label>
										<label for="" class="recepA">Malas
											<input type="text" name="mala" id="mala" value="0" class="form-control palet">
										</label>
									</div>
									<div class="subladoD">
										<label for="" class="">Vehículo Salida
											<input type="date" class="form-control" name="salida" id="salida" step="1" min="2018-01-01" max="2023-12-31" value="<?php echo date("Y-m-d");?>" required>
										</label>
										<label for="" class="">Hora
											<input type="time" class="form-control" name="horasalida" id="horasalida" step="1" min="06:00:00" max="19:00:00" value="<?php echo date('H:i:s') ?>">								
										</label>
										<label for="" class="recepB">Cobrar?
											<select name="cobrar" id="cobrar" class="form-control">
												<option value="si">Si</option>
												<option value="no">No</option>
											</select>
										</label>
										<label for="" class="recepB">Granel
											<select name="granel" id="granel" class="form-control">
												<option value="no">No</option>
												<option value="si">Si</option>
											</select>
										</label>
										<label for="" class="recepB">Sólo paleta
											<select name="solopaleta" id="solopaleta" class="form-control">
												<option value="no">No</option>
												<option value="si">Si</option>
											</select>
										</label>
										<div class="confirm">
											<label for="" class="recepB">Confirmar
												<select name="confirme" id="confirme" class="form-control">
													<option value="no">No</option>
													<option value="si">Si</option>
												</select>
											</label>
										</div>	
									</div>
								</article>
							</section>
							<section class="pie">
								<label for="" class="control-label ">Observaciones</label>
									<input type="text" class="form-control observa"  name="observa" id="observa">
							</section>
						</div>
						<div class="pieData bg-success">
							<div class="boton">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							<div class="submit">
								<input type="submit" value="Modificar" class="btn btn-success" id="reg" />
							</div>
						</div>
					</form>
				</div>
				<!--fin modal-content-->
			</div>
			<!--fin modal-dialog-->
		</div>
		<!--fin modal-fade-->
	</div>
	<!--Fin modal nuevo-->
   	<!--Inicio modal picking-->
	<div class="form-group">
		<div class="modal fade" id="abreModalPicking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-info cabeza">
						<h3 class="modal-title fondoLs" id="myModalpicking"></h3>
						<h2 class="mensajepick" id="mensajepick"></h2>
					</div>
					<form id="formulariopickin" class="form-horizontal">
						<div class="modal-body">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="procesos" name="procesos">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladotop">
										<label for="" class="recep">Despacho
											<input type="text" class="form-control recep" name="despachos" id="despachos" readonly style="width:80px">
										</label>
										<label for="" class="recep">Fecha
											<input type="text" class="form-control recep" name="fechdesp" id="fechdesp" readonly >
										</label>
										<label for="" class="">Movimiento
											<input type="text" class="form-control" name="movimientos" id="movimientos" readonly>
										</label>
										<label for="" class="">Cliente
											<select class="form-control" name="numClis" id="names" disabled>
												<option value=""></option>
												<?php
													$obj = new conectarDB();
													$data = $obj->consultar("CALL clientesActivosConsulta('0')");
													foreach($data as $key){
														echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
													}
												?>
											</select>
										</label>
									</div>	
									<div class="subladoG">
										<label for="" class="">Picking
											<select name='picking' id="picking" class="form-control" onchange="mostrar()">
												<option value="">Indique picking list</option>
												<?php
													$obj= new conectarDB();
													$data= $obj->subconsulta("CALL pickinglistPorBajarSelect('0')");
													foreach ($data as $key) {
														echo "<option value='".$key['pickingEvol']."'>".$key['pickingEvol']."</option>";
													}
												?>
											</select>
										</label>
									</div>
									<div class="subladoA">
										<div id="etiquetas"></div>
      								</div>
								</article>	
							</section>
						</div>	
						<div class="pieData bg-success">
							<div class="boton">
								<button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
							</div>
							<div class="submit">
								<input type="button" class="btn btn-success" id="regsp">
							</div>
						</div>
					</form>
				</div>
				<!--fin modal-content-->
			</div>
			<!--fin modal-dialog-->
		</div>
		<!--fin modal-fade-->
	</div>
	<!--Fin modal picking-->
    
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
		<script src="aplicaciones/js/despachos.js"></script>
	</div>
  </body>
</html>