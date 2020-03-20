<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';


	require "aplicaciones/html/head";
?>

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
				<h3 class="titulos" id="respuesta">Data despachos registrados en base de datos</h3>
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
					<th class="text-center">Cliente</th>
					<th class="text-center">Fecha</th>
					<th class="text-center">Despacho</th>
					<th class="text-center">Movimiento</th>
					<th class="text-center">Pedido</th>
					<th class="text-center">Fecha</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL despachosActivos('0')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<tr>
								<td><?php echo $filas['cliente_retiro'] ?></td>
								<td class="text-center"><?php echo $filas['fecha_retiro'] ?></td>
								<td class="text-center"><?php echo $filas['num_retiro'] ?></td>
								<td><?php echo $filas['movimient_retir'] ?></td>
								<td class="text-center"><?php echo $filas['documento_client_retiro'] ?></td>
								<td class="text-center"><?php echo $filas['fechaFactura'] ?></td>
								<td class="text-center icono">
									<a href='javascript:modal(<?php echo $filas['num_retiro'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar'></a>
									<a href='javascript:modalpicking(<?php echo $filas['num_retiro'] ?>,<?php echo $niveles ?>)' class='fas fa-download' title='Asignar picking list'></a>
									<a href='javascript:modalmanual(<?php echo $filas['num_retiro'] ?>,<?php echo $niveles ?>,<?php echo $filas['cliente_num_retir'] ?>)' class="glyphicon glyphicon-hand-right" title='Despacho manual'></a>
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
											<select class="form-control" name="movimiento" id="movimiento" style="width:160px">
												<option value="despacho">Despacho</option>
												<option value="despachomanual">Despacho manual</option>
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
											<select class="form-control" name="numCli" id="name" required="require" style="width:400px">
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
											<input type="text" class="form-control" name="factura" id="factura" required="require">
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
    <!--Inicio modal manual-->
	<div class="form-group">
		<div class="modal fade" id="abreModalManual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-info cabeza">
						<h3 class="modal-title fondoLs" id="myModalmanual"></h3>
						<h2 class="mensajepick" id="mensajemanual"></h2>
					</div>
					<form id="formulariomanual" class="form-horizontal">
						<div class="modal-body">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" name="proceso" value="despachomanual">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladotop">
										<label for="" class="recep">Despacho
											<input type="text" class="form-control recep" name="despachom" id="despachosm" readonly style="width:80px">
										</label>
										<label for="" class="recep">Fecha
											<input type="text" class="form-control recep" name="fechdesm" id="fechdespm" readonly >
										</label>
										<label for="" class="">Movimiento
											<input type="text" class="form-control" name="movimientosm" id="movimientosm" readonly>
										</label>
										<label for="" class="">Cliente
											<select class="form-control" name="numClism" autofocus id="namesm" readonly>
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
									<div class="subladoH">
										<label for="" class="">Etiqueta
											<select class="form-control" name="manualetiqueta" title="Ingrese número etiqueta" style="width:190px" id="etiquets" required="require">
                                            </select>
										</label>
										<label for="" class="">Cantidad
											<input type="text" class="form-control" name="manualcantidad" required="require">
										</label>
										<label for="" class="">Tipo unidad
											<input type="text" class="form-control" name="manualtipo" required="require">
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
								<button type="button" class="btn btn-default" data-dismiss="modal" id="closem">Close</button>
							</div>
							<div class="submit">
								<input type="button" class="btn btn-success" id="regspm">
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
	<!--Fin modal manual-->   
    
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
		<script src="aplicaciones/js/despachos.js"></script>
	</div>
	<script type="text/javascript">
       $(document).ready(function(){
           
        //para el select anidado
            //verificamos cuando cambie el cliente
                $('#namesm').focusin(function(){
                    $('#namesm option:selected').each(function(){
                        idcliente = $(this).val();
                        $.get("inventario_Funciones.php",{id_cliente:idcliente},function(data){$('#etiquets').html(data)});
                    });
                });
                
            });//fin dela ready	
        
            $('#closem').on('click',function(){
                location.reload();
            });
        
            function numetique(){
                var clie = document.getElementById('namesm').value;
                document.location='despachos.php?id_cliente=' + clie; 
                return false
            }
    </script>    
  </body>
</html>