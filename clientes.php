<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();


	require "aplicaciones/html/head";

?>

	<body>
		<header>
			<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
			<input type="hidden" id="modificador" value="<?php echo $usuario ?>">
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
					<h3 class="titulos">Data clientes registrados</h3>
				</div>
				<div class="nuevo">
					<a href="#" onclick="window.open('http:aplicaciones/ayudas/clientes.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
				</div>
				<div class="">
					<input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Nuevo">
				</div>
			</div>
		</header>
		<div id='main'>
			<article class="tabla">
				<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
					<thead>
						<tr class="bg-success">
							<th class="text-center">Nombre</th>
							<th class="text-center">Número</th>
							<th class="text-center">RIF</th>
							<th class="text-center">Contacto</th>
							<th class="text-center">Email</th>
							<th class="text-center">Teléfono</th>
							<th class="text-center">Arranque</th>
							<th class="text-center">Estatus</th>
							<th class="text-center">Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL clientesSelectTodos('0')");
                            $dat= json_encode($data);
                            if ($dat=='null') {
								echo '';
                            }else{
								foreach ($data as $filas) { ?>
							<?php if($filas['estatus_cli']==0){?>
							<tr>
								<td><?php echo $filas['nombre_cli'] ?></td>
								<td class="text-center"><?php echo $filas['num_cli'] ?></td>
								<td><?php echo $filas['rif_cliente'] ?></td>
								<td><?php echo $filas['contacto'] ?></td>
								<td><?php echo $filas['email_cliContacto'] ?></td>
								<td><?php echo $filas['telefono_cli'] ?></td>
								<td><?php echo $filas['arranque_cli'] ?></td>
								<td><?php echo $filas['estado'] ?></td>
								<td class="text-center">
									<a href='javascript:modal(<?php echo $filas['num_cli'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado' </a>
								</td>
							</tr>
							<?php }else{ ?>
							<tr class="" style="color: red;font-style: italic;">
								<td><?php echo $filas['nombre_cli'] ?></td>
								<td class="text-center"><?php echo $filas['num_cli'] ?></td>
								<td><?php echo $filas['rif_cliente'] ?></td>
								<td><?php echo $filas['contacto'] ?></td>
								<td><?php echo $filas['email_cliContacto'] ?></td>
								<td><?php echo $filas['telefono_cli'] ?></td>
								<td><?php echo $filas['arranque_cli'] ?></td>
								<td><?php echo $filas['estado'] ?></td>
								<td class="text-center">
									<a href='javascript:modal(<?php echo $filas['num_cli'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado' </a>
								</td>
							</tr>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							<!--Fin del if $dat-->
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
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header bg-info cabeza">
							<h3 class="modal-title fondoLs" id="myModalLabel"><b>Registro de clientes</b></h3>
							<div class="respuesta" id="respuesta"></div>
						</div>
						<form id="formulario" class="form-horizontal" onsubmit="return modificarCliente();">
							<div class="modal-body">
								<input type="hidden" id="id-prod" name="id-prod">
								<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
								<input type="hidden" id="proceso" name="proceso">
								<section class="datosCliente">
									<article class="datosA">
										<label for="" class="labelA">Cliente
												<input type="text" class="form-control names" name="name" id="name" disabled autocomplete="off" autofocus>
											</label>
										<label for="" class="labelB">Teléfono
												<input type="text" name="telef" id="telef" class="form-control center"  autocomplete="off">
											</label>
										<label for="" class="labelC">RIF
												<input type="text" class="form-control center" name="rif" id="rif"  autocomplete="off">
											</label>

									</article>
									<article class="datosB">
										<label for="" class="labelA">Contacto
												<input type="text" class="form-control names" name="contacto" id="contacto"  autocomplete="off">
											</label>
										<label for="" class="labelB">Teléfono
												<input type="text" name="teleContacto" id="teleContacto" class="form-control center"  autocomplete="off">
											</label>
										<label for="" class="labelC">Email
												<input type="text" class="form-control center" name="email" id="email"  autocomplete="off">
											</label>
									</article>
									<article class="datosC">
										<label for="" class="control-label">Dirección</label>
										<input type="text" name="direcc" id="direcc" class="form-control direccion">
									</article>
									<article class="datosD">
										<label for="" class="toler">Tolerancia
											<input type="text" class="form-control aling" value="90" name="tolera" id="tolera" data-container="body" data-toggle="popover" data-placement="bottom" title="Bloqueo automático" data-content="Días previos al vencimiento, para enviar la etiqueta al almacen de bloqueadas" autocomplete="off">
										</label>
										<label for="" class="">Paletas peso
											<input type="text" class="form-control aling" value="30" name="paleta" id="paleta" data-toggle="tooltip" data-placement="right" title="Peso de la paleta"  autocomplete="off">
										</label>
										<label for="" class="">Contratadas
											<input type="text" class="form-control aling" value="0" name="contratada" id="contratada" data-toggle="tooltip" data-placement="top" title="Paletas contratadas"  autocomplete="off">
										</label>
										<label for="" class="">Bloqueo
											<select class="form-control aling" name="bloqueo" id="bloqueo" data-container="body" data-toggle="popover" data-placement="top" title="Envio al almacen de bloqueadas" data-content="Activa procedimiento para el envío de la etiqueta al almacen de bloqueadas, depende de los días de tolerancia." autocomplete="off">
												<option value="0">No</option>
												<option value="1">Si</option>
											</select>
										</label>
										<label for="" class="">Estado
											<select class="form-control estado aling" name="estado" id="estado" style="width:120px">
												<option value="0">Activo</option>
												<option value="1">Inactivo</option>
											</select>
										</label>
									</article>
									<article class="datosC">
										<label for="" class="direccion">Observaciones
												<input type="text" class="form-control direccion" name="observ" id="observ">
											</label>
									</article>
								</section>
							</div>
							<div class="modal-footer bg-info">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<input type="submit" value="Modificar" class="btn btn-success text-center" style="width:90px " id="reg" />
							</div>
						</form>
					</div>
					<!--fin modal-content-->
				</div>
				<!--fin modal-dialog-->
			</div>
			<!--fin modal-fade-->
		</div>
		<!--Fin form-group id=formG1-->
		<!--Fin modal nuevo-->
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
			<script src="aplicaciones/js/clientes.js"></script>
		</div>
	</body>

	</html>
