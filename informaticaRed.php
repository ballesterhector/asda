<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();
	
	
	require "aplicaciones/html/head";
?>

 <body>
    <header>
		<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
		<input type="hidden" value="<?php echo $esinformatico ?>" id="esinformatico">
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
				<h3 class="titulos" id="">Data equipos de RED</h3>
			</div>
			<div class="ayudarecepcion">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/informaticaRed.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
                <a href="#" onclick="window.open('http:aplicaciones/ayudas/especificacionesdeGmail.pdf')" /><i class="fas fa-address-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual Gmail"></i></a>
			    <input type="button" name="nuevoRed" id="nuevoRed" class="btn btn-success " value="Nuevo">
            </div>
		</div>
    </header>
    <div id='main'>
      	<article class="tablainfo">
	      	<table class="table table-condensed table-bordered table-responsive display compact" style="font-size:10px" id="dataTables">
				<thead>
				   <tr class="bg-success">
						<th class="text-center">Correlativo</th>
						<th class="text-center">Ubicación</th>
						<th class="text-center">Dispositivo</th>
					    <th class="text-center">Tipo</th>
					    <th class="text-center">Puertos</th>
					    <th class="text-center">Estado</th>
					    <th class="text-center">Observación</th>
					   <th class="text-center">Acción</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$obj= new conectarDB();
						$data= $obj->subconsulta("CALL informaticaRedSelect('0')");
						$dat= json_encode($data);
						if ($dat=='null') {
							echo '';
						}else{
							foreach ($data as $filas) { ?>
							    <?php if($filas['estadoredes'] != 'Activo'){?>
							        <tr>
	                                    <td class="bg-danger"><?php echo str_pad($filas['correlativoredes'], 7, "0", STR_PAD_LEFT) ?></td>
	                                    <td class="bg-danger"><?php echo $filas['ubicacionredes'] ?></td>
	                                    <td class="bg-danger"><?php echo $filas['Equipored'] ?></td>
	                                    <td class="bg-danger"><?php echo $filas['tipodispositivo'] ?></td>
	                                    <td class="bg-danger"><?php echo $filas['puertos'] ?></td>
	                                    <td class="bg-danger"><?php echo $filas['estadoredes'] ?></td>
	                                    <td class="bg-danger"><?php echo $filas['observacionredes'] ?></td>
	                            <?php }else{ ?>    
	                                </tr>
							     
								  	<tr>
										<td><?php echo str_pad($filas['correlativoredes'],7,"0",STR_PAD_LEFT) ?></td>
		                                <td><?php echo $filas['ubicacionredes'] ?></td>
		                                <td><?php echo $filas['Equipored'] ?></td>
		                                <td><?php echo $filas['tipodispositivo'] ?></td>
		                                <td><?php echo $filas['puertos'] ?></td>
		                                <td><?php echo $filas['estadoredes'] ?></td>
		                                <td><?php echo $filas['observacionredes'] ?></td>
	                            <?php } ?>
	                                    <td class="text-center icono" >
	                                       <a href='javascript:modificared(<?php echo $filas['correlativoredes'] ?>,<?php echo $niveles ?>)' class='fas fa-edit' title='Modificar'></a>
	                                       <a href='javascript:equiposred(<?php echo $filas['correlativoredes'] ?>,<?php echo $niveles ?>)' class='fas fa-eye' title='Equipos conectados'></a>
	                                    </td>
									</tr>
							<?php } ?>
					<?php  } ?>
				</tbody>
			</table>
		</article>
	   <aside>
      		<table class="table table-condensed table-bordered table-responsive display compact" style="font-size:10px" id="dataTables">
				<thead>
                    <tr class="bg-info">
                        <th class="text-center">Correlativo</th>
                        <th class="text-center">Puerto</th>
                        <th class="text-center">Dispositivo</th>
                        <th class="text-center">Equipo</th>
                        <th class="text-center">Asignado a</th>
                        <th class="text-center">Acción</th>
                    </tr>
		       	</thead>
				<tbody>
					<?php
						$obj= new conectarDB();
						$data= $obj->subconsulta("CALL informatica_RedPuertoEquipo('".$_GET['nivel']."')");
						$dat= json_encode($data);
						if ($dat=='null') {
							echo '';
						}else{
							foreach ($data as $filas) { ?>
							    <?php if($filas['estadoredes'] != 'Activo'){?>
							        <tr>
	                                    <td ><?php echo str_pad($filas['correlativoredes'], 7, "0", STR_PAD_LEFT) ?></td>
	                                    <td ><?php echo $filas['puerto'] ?></td>
	                                    <td ><?php echo $filas['dispositivo'] ?></td>
	                                    <td ><?php echo $filas['tipoEquipo'] ?></td>
	                                    <td ><?php echo $filas['asignadoA'] ?></td>
	                            <?php }else{ ?>    
	                                </tr>
							     
								  	<tr>
										<td ><?php echo str_pad($filas['correlativoredes'],7,"0",STR_PAD_LEFT) ?></td>
		                                <td ><?php echo $filas['puerto'] ?></td>
		                                <td ><?php echo $filas['dispositivo'] ?></td>
		                                <td ><?php echo $filas['tipoEquipo'] ?></td>
		                                <td ><?php echo $filas['tipodispositivo'] ?></td>
		                                <td ><?php echo $filas['asignadoA'] ?></td>
		                        <?php } ?>
	                                    <td class="text-center icono">
	                                       <a href='javascript:ingresaequipos(<?php echo $filas['idpuertos'] ?>)' class="fas fa-download" title='Asignar equipo'></a>
	                                    </td>
									</tr>
							<?php } ?>
					<?php  } ?>
				</tbody>
		    </table>
      </aside>
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
					<form id="formulario" class="form-horizontal" onsubmit="return registroDataRed();">
						<div class="modal-body">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladoG">
									    <label for="">
										    <select class="form-control" name="estado" id="estado" style="width:150px" required="require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Estado">
										    	<option value="Activo">Activo</option>
										    	<option value="Por reparación">Por reparación</option>
										    	<option value="Desincorporado">Desincorporado</option>
										    	<option value="por asignar">por asignar</option>
										    </select>
										</label>
									</div>	
									<div class="subladoG">
										<input type="text" name="ubica" id="ubica" class="form-control" style="" required="require" placeholder="Ubicación">
									</div>
									<div class="subladoC" style="">	
									    <label for="">
										    <select class="form-control" name="tipo" id="tipo" style="width:120px" required aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Dispositivo">
										    	<option value="Router">Router</option>
										    	<option value="Switch">Switch</option>
										    	<option value="Repetidora">Repetidora</option>
										    	<option value="Antena">Antena</option>
										    	<option value="Modem">Modem</option>
										    	<option value="Firewall">Firewall</option>
										    	<option value="Patch panel">Patch panel</option>
										        <option value="Rack">Rack</option>
										    </select>
										</label>
										<label for="" class="">
											<input type="text" class="form-control" name="tipo2" id="tipo2" style="width: 330px" required="require" placeholder="Amplíe información">
										</label>
								        <label for="" class="">
											<input type="text" name="puerto" id="puerto" class="form-control" style="width:70px;text-align: center" placeholder="Puertos" required="require">
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
	</div>
	<!--Fin modal nuevo-->

	 <!--Inicio modal asigna dispositivo-->
	<div class="form-group">
		<div class="modal fade" id="abreModalasignadispositivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header bg-info cabeza">
						<h3 class="modal-title fondoLs" id="myModalLabelequi"></h3>
						<div class="respuestaequi" id="respuestaequi"></div>
					</div>
					<form id="formularioequi" class="form-horizontal" onsubmit="return ingresaequipo();">
						<div class="modal-body">
							<input type="hidden" id="id-prodequi" name="id-prodequi">
							<input type="hidden" id="proceso" name="proceso" value="asignaequiposred">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladoG">
										<input type="text" name="codequip" id="codequip" class="form-control" style="width: 140px;margin-left: 40px;text-align: center" required="require" placeholder="Indique código equipo">
									</div>
								</article>
							</section>
						</div>
						<div class="pieData bg-success">
							<div class="boton">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							<div class="submit">
								<input type="submit" value="" class="btn btn-success" id="regequi" />
							</div>
						</div>
					</form>
				</div>
				<!--fin modal-content-->
			</div>
			<!--fin modal-dialog-->
		</div>
	</div>
	<!--Fin modal asigna dispositivo-->



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
		<script src="aplicaciones/js/informatica.js"></script>
	</div>
  </body>
</html>