<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();
	
	require "aplicaciones/html/head";

?>
<!--La transferencia dura solo un dia-->
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
				<h3 class="titulos" id="">Data transferencias clientes registradas</h3>
			</div>
			<div class="ayudarecepcion">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/transferencias.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="javascript: onclick(transferenciaspdf())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir reporte"></i></a>
                <input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Nuevo">
            </div>
		</div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
				<tr class="bg-success">
				    <th class="text-center">Tipo</th>
					<th class="text-center">Cliente sale</th>
					<th class="text-center">Cliente llega</th>
					<th class="text-center">Fecha</th>
					<th class="text-center">Transferencia</th>
					<th class="text-center">Usuario</th>
					<th class="text-center">Motivo</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL transferenciasSelectProceso('1')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<tr>
							    <td><?php echo $filas['tipoTransfe'] ?></td>
								<td><?php echo $filas['clienteTransfe'] ?></td>
								<td><?php echo $filas['clienteLlega'] ?></td>
								<td><?php echo $filas['fechaTrasfe'] ?></td>
								<td><?php echo $filas['numeroTransfe'] ?></td>
								<td><?php echo $filas['usuarioTransfe'] ?></td>
								<td><?php echo $filas['motivoTransfe'] ?></td>
								<td class="text-center icono">
									<a href='javascript:unidades(<?php echo $filas['numeroTransfe'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar'</a>
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
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header bg-info cabeza">
						<h3 class="modal-title fondoLs" id="myModalLabel"></h3>
						<div class="respuesta" id="respuesta"></div>
					</div>
					<form id="formulario" class="form-horizontal" onsubmit="return agregarRegistro();">
						<div class="modal-body">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso">
							<section class="modalProductos">
								<article class="">
									<div class="subladotop">
										<label for="" class="recep">Transferencia
											<input type="text" class="form-control recep" name="transfe" id="transfe" readonly style="width:80px">
										</label>
										<label for="" class="">Tipo
										    <input type="text" class="form-control" name="tipo" id="tipo" value="transferenciasclientes" readonly>
										</label>
									</div>
									<div class="llegada">
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
										<label for="" class="llegar">Cliente llega
											<select class="form-control" name="clillega" id="clillega" required="require">
												<option value="0">0</option>
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
									<div class="subladoB">
										<label for="" class="">Motivo
											<input type="text" name="motivo" id="motivo" style="width:265px" class="form-control">
										</label>
									</div>
								</article>
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
		<?php require "aplicaciones/html/footer" ?>
		<script src="aplicaciones/js/transferenciasClientes.js"></script>
	</div>
  </body>
</html>