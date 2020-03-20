<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['clibus']."')");
	$clientes = $data[0]['nombre_cli'];
	if($_GET['clibus']==30){
		$numClie=$_GET['clibus'];
	}else{
		$numClie= $_GET['clibus'];
	}


	require "aplicaciones/html/head";

?>

	<body>
		<header>
			<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
			<input type="hidden" value="<?php echo $nomClie ?>" id="nCliente">
			<input type="hidden" id="modificador" value="<?php echo $usuario ?>">
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
					<h3 class="titulos">Data piking list registrados</h3>
				</div>
				<div class="ayuda ayudapick">
					<a href="#" onclick="window.open('http:aplicaciones/ayudas/pickinglist.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				    <a href="javascript: onclick(imprimir())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir picking"></i></a>
                    <a href="javascript: onclick(imprimir2())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir picking Modificado"></i></a>
                    
                    <a class="" title="Hoja de excel" href="#" onclick="excel()"><i class="file excel fa-2x "></i></a>
					<input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Nuevo">
				</div>
				<div class="clienteselect">
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
			</div>
		</header>
		<div id='main'>
			<article class="tabla">
				<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
					<thead>
						<tr class="bg-success">
							<th class="text-center">Picking List</th>
							<th class="text-center">Fecha</th>
							<th class="text-center">Pedido</th>
							<th class="text-center">Fecha</th>
							<th class="text-center">Movimiento</th>
							<th class="text-center">Destino</th>
							<th class="text-center">Ciudad</th>
							<th class="text-center">Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL pickinglistActivos('".$numClie."')");
                            $dat= json_encode($data);
                            if ($dat=='null') {
								echo '';
                            }else{
								foreach ($data as $filas) { ?>
									<tr>
										<td class="text-center"><?php echo $filas['numPicking'] ?></td>
										<td class="text-center"><?php echo $filas['fechaPicking'] ?></td>
										<td><?php echo $filas['documentoPedido'] ?></td>
										<td class="text-center"><?php echo $filas['fechaDocumento'] ?></td>
										<td><?php echo $filas['movimientoPicking'] ?></td>
										<td><?php echo $filas['destinoClientPicking'] ?></td>
										<td><?php echo $filas['destinoCiudadPicking'] ?></td>
										<td class="text-center icono">
											<a href='javascript:modal(<?php echo $filas['numPicking'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar'</a>
										    <a href='javascript:codigos(<?php echo $filas['numPicking'] ?>,<?php echo $numClie ?>)' class='glyphicon glyphicon-edit fa-lg' title='Incluir productos'></a>
										    <a href='javascript:cerrar(<?php echo $filas['numPicking'] ?>)' title='Confirmar'><i class="fas fa-check"></i></a>
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
		</div>
		<!--Inicio modal nuevo-->
	    <div class="form-group">
    	    <div class="modal fade" id="abreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           		<div class="modal-dialog">
             		<div class="modal-content">
						<div class="modal-header bg-info cabeza">
							<h3 class="modal-title fondoLs" id="myModalLabel"></h3>
							<div class="respuesta" id="respuesta"></div>
						</div>
							<form id="formulario" class="form-horizontal" onsubmit="return modificarData();">
								<div class="modal-body">
									<input type="hidden" id="proceso" name="proceso">
									<input type="hidden" id="id-prod" name="id-prod">
									<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
									<section class="datosPicking">
										<div class="client">
											<label for="" class="labelA">Cliente
												<select class="form-control" name="numcli" id="numcli" disabled required="require">
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
											<label for="" class="labelB">Movimiento
												<select name="movimiento" id="movimientoPic" class="form-control" style="width:150px">
													<option value="despacho">Despacho</option>
													<option value="ajuste">Ajuste</option>
												</select>
											</label>	
										</div>	
										<div class="pedido">
											<label for="" class="labelA">Pedido
												<input type="text" name="pedido" id="pedido" class="form-control" value="No aplica" autocomplete="off" >
											</label>
											<label for="" class="labelB">Fecha
												<input type="date" name="pedidofecha" id="pedidofecha" class="form-control" value="<?php echo date('Y-m-d') ?>" autocomplete="off">
											</label>
								        </div>
								        <div class="pedido">			
											<label for="" class="labelC">Destino cliente
												<input type="text" name="desticlie" class="form-control" value="No aplica" id="desticlie">
											</label>
											<label for="" class="labelD">Ciudad
												<input type="text" name="desticiuda" class="form-control" value="No aplica" id="desticiuda">
											</label>
										</div>
										<div class="motivo">
											<lable class="labelE">Motivo
												<input type="text" class="form-control" name="motivo" id="motivo" autocomplete="off">
											</lable>
										</div>
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
                    	</div><!--fin modal-content-->
                	</div><!--fin modal-dialog-->
            	</div>  <!--fin modal-fade-->
       		</div><!--Fin form-group id=formG1-->
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
			<script src="aplicaciones/js/pickingList.js"></script>
		</div>
	</body>

	</html>
