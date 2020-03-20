<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();
	

	

?>
	
	<?php  include "aplicaciones/html/head"  ?>
	
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
		<div class="recepcion">
			<div class="titulo">
				<h3 class="titulos" id="">Data recepciones registradas</h3>
			</div>
			<div class="ayudarecepcion">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/recepciones.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="javascript: onclick(recepcionpdf())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir ingreso"></i></a>
                <a href="javascript: onclick(recepciondevolucionespdf())"><i class="fas fa-truck fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir devoluciones"></i></a>
 				<a href="javascript: onclick(recepcionesEtiquetasPdf())"><i class="fab fa-etsy fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir etiquetas"></i></a>
                <a href="javascript: onclick(activar())"><i class="fas fa-calendar-check fa-2x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Activar recepción"></i></a>
 			<!--	<a href="#" onclick="ftp()"><i class="fas fa-download fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="FTP trasferir recepción"></i></a>-->
                <input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Nuevo">
            </div>
		</div>
    </header>
    <div id='main'>
      <article class="tabla">
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
									<a href='javascript:confirma(<?php echo $filas['num_recep'] ?>,<?php echo $niveles ?>)' class='fas fa-check' title='Modificar estado'</a>
								</td>
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
						<div class="respuesta" id="respuesta"></div>
					</div>
					<form id="formulario" class="form-horizontal" onsubmit="return modificarData();">
						<div class="modal-body">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladotop">
										<label for="" class="recep">Recepción
											<input type="text" class="form-control recep" name="recepci" id="recepci" readonly style="width:80px">
										</label>
										<label for="" class="">Movimiento
											<select class="form-control" name="movimiento" id="movimiento" style="width:130px">
												<option value="Ingreso">Ingreso</option>
												<option value="Ajuste">Ajuste</option>
												<option value="Complemento">Complemento</option>
											</select>
										</label>
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
														echo "<option value='".$key['conductor']."'>".$key['cedula_cond']."-".$key['conductor']."</option>";
													}
												?>
											</select>
										</label>
									</div>
									<div class="subladoA">
										<label for="" class="vehicu">Vehículos
											<select name='vehicu' id="vehicu" class="form-control">
												<?php
													$obj= new conectarDB();
													$data= $obj->subconsulta("CALL vehiculosActivos()");
													foreach ($data as $key) {
														echo "<option value='".$key['placas']."'>".$key['placas']."</option>";
													}
												?>
											</select>
										</label>
										<label for="" class="vehicu">Trailer
											<select name='trailer' id="trailer" class="form-control">
												<option value=""></option>
												<?php
													$obj= new conectarDB();
													$data= $obj->subconsulta("CALL vehiculosActivos()");
													foreach ($data as $key) {
														echo "<option value='".$key['placas']."'>".$key['placas']."</option>";
													}
												?>
											</select>
										</label>
										<label for="" class="contened">Contenedor
											<input type="text" name="contenedor" id="contenedor" class="form-control" value="0" autocomplete="off">
										</label>
										<label for="" class="recepA">Precintos
											<input type="text" name="precint" id="precint" class="form-control">
										</label>
									</div>
									<div class="subladoB">
										<label for="" class="recepA">Ciudad origen
											<input type="text" name="origen" id="origen" class="form-control">
										</label>
										<label for="" class="recepA">Cliente origen
											<input type="text" name="clieorig" id="clieorig" class="form-control">
										</label>
										<label for="" class="">Factura
											<input type="text" class="form-control" name="factura" id="factura">
										</label>
										<label for="" class="">Fecha
											<input type="date" class="form-control" name="factfecha" id="factfecha" step="1" min="2018-01-01" max="2023-12-31" value="<?php echo date("Y-m-d");?>">
										</label>
									</div>
									<div class="subladoC">
										<label for="" class="recepC">Temperatura
											<input type="text" name="tempera" id="tempera" value="0" class="form-control tempe" >
										</label>
										<label for="" class="recepC">Peso total
											<input type="text" name="pesocarga" id="pesocarga" value="0" class="form-control tempe">
										</label>
										<label for="" class="recepC">Unidades
											<input type="text" name="unidades" id="unidades" value="0" class="form-control tempe" >
										</label>
										<label for="" class="recepA">Paletas
											<input type="text" name="paletas" id="paletas" value="0" class="form-control palet" >
										</label>
										<label for="" class="recepA">Llenas
											<input type="text" name="llenas" id="llenas" value="0" class="form-control palet">
										</label>
										<label for="" class="recepA">Vacias
											<input type="text" name="vacia" id="vacia" value="0" class="form-control palet" >
										</label>
										<label for="" class="recepA">Malas
											<input type="text" name="mala" id="mala" value="0" class="form-control palet">
										</label>
									</div>
									<div class="subladoD">
										<label for="" class="">Vehículo llegada
											<input type="date" class="form-control" name="llegada" id="llegada" step="1" min="2018-01-01" max="2023-12-31" value="<?php echo date("Y-m-d");?>">
										</label>
										<label for="" class="">Hora
											<input type="time" class="form-control" name="horallegada" id="horallegada" value="<?php echo date('H:i:s') ?>" max="22:30:00" min="05:00:00" step="1">								
										</label>
										<label for="" class="recepB">Cobrar?
											<select name="cobrar" id="cobrar" class="form-control">
												<option value="Si">Si</option>
												<option value="No">No</option>
											</select>
										</label>
										<label for="" class="recepB">Granel
											<select name="granel" id="granel" class="form-control">
												<option value="No">No</option>
												<option value="Si">Si</option>
											</select>
										</label>
										<label for="" class="recepB">Sólo paleta
											<select name="solopaleta" id="solopaleta" class="form-control">
												<option value="No">No</option>
												<option value="Si">Si</option>
											</select>
										</label>
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
    <footer class="dat">
    	<script>
			var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
			var f=new Date();
			document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		</script>
    </footer>
    <div>
		<?php  require "aplicaciones/html/footer" ?>
		<script src="aplicaciones/js/recepcion.js"></script>
	</div>
  </body>
</html>