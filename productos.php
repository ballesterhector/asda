<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['clibus']."')");
	$clientes = $data[0]['nombre_cli'];
	if($_GET['clibus']==30){
		$nomClie=31;
	}else{
		$nomClie= $_GET['clibus'];
	}

	require "aplicaciones/html/head";

?>

	<body>
		<header>
			<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
			<input type="hidden" value="<?php echo $nomClie ?>" id="nCliente">
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
					<h3 class="titulos">Data productos registrados</h3>
				</div>
				<div class="nuevo">
					<a href="#" onclick="window.open('http:aplicaciones/ayudas/productos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
					<a href='javascript: onclick(excel(<?php echo $nomClie ?>))'><i class="fas fa-file-excel fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte excel"></i></a>
				</div>
				<div>
					<select class="form-control" name="" id="cliBusca" autofocus>
						<option value=""><?php echo $clientes ?></option>
							<?php
								$obj = new conectarDB();
								$data = $obj->consultar("CALL clientesActivosConsulta('0')");
								foreach($data as $key){
									echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
								}
							?>
						</select>
				</div>
				<div class="excel">
					<a class="" title="Hoja de excel" href="#" onclick="excel()"><i class="file excel fa-2x "></i></a>
				</div>
				<div class="nuevo">
					<input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Nuevo">
				</div>
			</div>
			
		</header>
		<div id='main'>
			<article class="tabla">
				<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
					<thead>
						<tr class="bg-success">
							<th class="text-center">Código</th>
							<th class="text-center">Producto</th>
							<th class="text-center">Presentación</th>
							<th class="text-center">Familia</th>
							<th class="text-center">Estado</th>
							<th class="text-center">Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL productosConsulta('".$nomClie."')");
                            $dat= json_encode($data);
                            if ($dat=='null') {
								echo '';
                            }else{
								foreach ($data as $filas) { ?>
							<?php if($filas['estado_prod']==0){?>
							<tr>
								<td><?php echo $filas['codigo_prod'] ?></td>
								<td><?php echo $filas['descrip_prod'] ?></td>
								<td><?php echo $filas['presen_prod'] ?></td>
								<td><?php echo $filas['familia_prod'] ?></td>
								<td><?php echo $filas['estado'] ?></td>
								<td class="text-center">
									<a href='javascript:modal(<?php echo $filas['num_prod'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado' </a>
								</td>
							</tr>
							<?php }else{ ?>
							<tr class="">
								<td class="bg-danger"><?php echo $filas['codigo_prod'] ?></td>
								<td class="bg-danger"><?php echo $filas['descrip_prod'] ?></td>
								<td class="bg-danger"><?php echo $filas['presen_prod'] ?></td>
								<td class="bg-danger"><?php echo $filas['familia_prod'] ?></td>
								<td class="bg-danger"><?php echo $filas['estado'] ?></td>
								<td class="text-center"><a href='javascript:modal(<?php echo $filas['num_prod'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado' </a>
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
								<h3 class="modal-title fondoLs" id="myModalLabel"><b>Registro de productos</b></h3>
								<div class="respuesta" id="respuesta"></div>
							</div>
							<form id="formulario" class="form-horizontal" onsubmit="return modificarData();">
								<div class="modal-body">
									<input type="hidden" id="id-prod" name="id-prod">
									<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
									<input type="hidden" id="proceso" name="proceso">
									<section class="datosProductos">
										<article class="productoA">
											<label for="" class="labelA">Cliente
												<select class="form-control" name="numcli" id="name"  autofocus required="require">
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
											<label for="" class="labelB">Código
												<input type="text" name="codigo" id="codigo" class="form-control"  autocomplete="off" required="require">
											</label>
											<label for="" class="labelC">Porducto
												<input type="text" name="producto" id="producto" class="form-control" style="width:320px"  autocomplete="off" required="require">
											</label>
										</article>
										<article class="productoB">
											<label for="" class="labelA">Presentación
												<select name='presenta' id="presenta" class="form-control" required="require" required="require">
													<?php
														$obj= new conectarDB();
														$data= $obj->subconsulta("CALL productosPresentacion()");
															foreach ($data as $key) {
															echo "<option value='".$key['prod_presen']."'>".$key['prod_presen']."</option>";
														}
													?>
												</select>
											</label>
											<label for="" class="labelA">Familia
												<input type="text" name="familia" id="familia" class="form-control"  autocomplete="off" required="require">
											</label>
											<label for="" class="labelB">Tipo
												<select name='tipo' id="tipo" class="form-control" required="require">
													<option value='Producto terminado'>Producto terminado</option>
													<option value='Materia prima'>Materia prima</option>
												</select>
											</label>
											<label for="" class="labelC">En kilo
												<select name='enkilo' id="enkilo" class="form-control" title="Control en kilos?" required="require">
													<option value='no'>No</option>
													<option value='si'>Si</option>
												</select>
											</label>
											<label for="" class="labelC">Es cesta
												<select name='cesta' id="cesta" class="form-control" title="Control en cestas?" required="require">
													<option value='0'>No</option>
													<option value='1'>Si</option>
												</select>
											</label>
											<label for="" class="labelC">Alimento
												<select name='alimento' id="alimento" class="form-control" required="require">
													<option value='Si'>Si</option>
													<option value='No'>No</option>
												</select>
											</label>
											
										</article>
										<article class="productoC">
                                            <label for="" class="labelD">Ubicación
												<select name='ubicaci' id="ubicaci" class="form-control" required="require" required="require">
													<?php
														$obj= new conectarDB();
														$data= $obj->subconsulta("CALL productosUbicacion()");
															foreach ($data as $key) {
															echo "<option value='".$key['ubicacion']."'>".$key['ubicacion']."</option>";
														}
													?>
												</select>
											</label>
											<label for="" class="labelB">Estado
												<select name="estado" id="estado" class="form-control" required="require">
													<option value="0">Activo</option>
													<option value="1">Inactivo</option>
												</select>
											</label>
										    <label for="" class="labelC">Tolerancia
												<input type="number" name="tolera" id="tolera" class="form-control" title="Días de tolerancia" value="30" autocomplete="off" required="require">
											</label>
											<label for="" class="labelA">Unidades
												<input type="text" name="unidades" id="unidades" class="form-control" value="0" autocomplete="off" required="require">
											</label>
											<label for="" class="labelA">Peso
												<input type="text" name="pesounidad" id="pesounidad" class="form-control" value="0" autocomplete="off" required="require">
											</label>
											<label for="" class="labelA">Peso neto
												<input type="text" name="neto" id="neto" class="form-control" value="0" autocomplete="off" required="require">
											</label>
											<label for="" class="labelA">Bruto
												<input type="text" name="bruto" id="bruto" class="form-control" value="0" autocomplete="off" required="require">
											</label>
											<label for="" class="labelA">Camadas
												<input type="text" name="camada" id="camada" class="form-control" value="0" autocomplete="off" required="require">
											</label>
											<label for="" class="labelA">Ruma
												<input type="text" name="ruma" id="ruma" class="form-control" value="0" autocomplete="off" required="require">
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
			<?php require "aplicaciones/html/footer"  ?>
			<script src="aplicaciones/js/productos.js"></script>
		</div>
	</body>

	</html>
