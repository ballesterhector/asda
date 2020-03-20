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
				<h3 class="titulos" id="">Data equipos</h3>
			</div>
			<div class="ayudarecepcion">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/informaticaEquipos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
                <a href="#" onclick="window.open('http:aplicaciones/ayudas/especificacionesdeGmail.pdf')" /><i class="fas fa-address-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual Gmail"></i></a>
			    <input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Nuevo">
            </div>
		</div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
				<tr class="bg-success">
					<th class="text-center">Correlativo</th>
					<th class="text-center">Asignado a</th>
					<th class="text-center">Email</th>
					<th class="text-center">Ubicación</th>
					<th class="text-center">Tipo</th>
					<th class="text-center">Asignado al CPU<br> <sub>(Link)</sub></th>
					<th class="text-center">Sistema operativo</th>
					<th class="text-center">Iconos</th>
					<th class="text-center">Estado</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL informatica_EquiposConsulta('0')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
						    <?php if($filas['estado'] == 'Activo'){?>
						        <tr>
                                    <td><?php echo $filas['correlativo'] ?></td>
                                    <td><?php echo $filas['asignadoA'] ?></td>
                                    <td><?php echo $filas['email'] ?></td>
                                    <td><?php echo $filas['ubicacion'] ?></td>
                                    <td><?php echo $filas['tipoEquipo'] ?></td>
                                    <td class="text-center" style="background:#EBF5FB"><a href='javascript:ordenador(<?php echo $filas['ordenador'] ?>)'</a><?php echo $filas['ordenador'] ?></td>
                                    <td><?php echo $filas['sistemaoperativo'] ?></td>
                                    <td><?php echo $filas['iconosActivos'] ?></td>
                                    <td><?php echo $filas['estado'] ?></td>
                                    <td class="text-center icono">
                                       <a href='javascript:modifica(<?php echo $filas['correlativo'] ?>,<?php echo $niveles ?>)' class='fas fa-edit' title='Modificar'</a>
                                       <a href='javascript:complemento(<?php echo $filas['correlativo'] ?>,<?php echo $niveles ?>)' class='fas fa-link' title='Complemento'</a>
                                     </td>
                                </tr>
						     <?php }else{ ?>
						  	<tr>
								<td class="bg-danger"><?php echo $filas['correlativo'] ?></td>
								<td class="bg-danger"><?php echo $filas['asignadoA'] ?></td>
								<td class="bg-danger"><?php echo $filas['email'] ?></td>
								<td class="bg-danger"><?php echo $filas['ubicacion'] ?></td>
								<td class="bg-danger"><?php echo $filas['tipoEquipo'] ?></td>
								<td class="bg-danger text-center" style="background:#EBF5FB"><a href='javascript:ordenador(<?php echo $filas['ordenador'] ?>)'</a><?php echo $filas['ordenador'] ?></td>
								<td class="bg-danger"><?php echo $filas['sistemaoperativo'] ?></td>
								<td class="bg-danger"><?php echo $filas['iconosActivos'] ?></td>
								<td class="bg-danger"><?php echo $filas['estado'] ?></td>
								<td class="text-center icono bg-danger">
									<a href='javascript:modifica(<?php echo $filas['correlativo'] ?>,<?php echo $niveles ?>)' class='fas fa-edit' title='Modificar'</a>
									<a href='javascript:complemento(<?php echo $filas['correlativo'] ?>,<?php echo $niveles ?>)' class='fas fa-link' title='Complemento'</a>
								</td>
							</tr>
					        <?php } ?>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
      </article>
      
    </div>
    <!--Inicio modal nuevo Y Modificar-->
	<div class="form-group">
		<div class="modal fade" id="abreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header bg-info cabeza">
						<h3 class="modal-title fondoLs" id="myModalLabel"></h3>
						<div class="respuesta" id="respuesta"></div>
					</div>
					<form id="formulario" class="form-horizontal" onsubmit="return registroData();">
						<div class="modal-body">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso" value="Registro">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladoG">
									    <label for="">Estado
										    <select class="form-control" name="estado" id="estado" required="require" style="width:150px" required="require">
										    	<option value="Activo">Activo</option>
										    	<option value="Por reparación">Por reparación</option>
										    	<option value="Desincorporado">Desincorporado</option>
										    	<option value="por asignar">por asignar</option>
										    </select>
										</label>
										<label for="" class="">Usuario
											<select class="form-control" name="user" id="user" required="require">
												<option value="No asignado">No asignado</option>
												<?php
													$obj = new conectarDB();
													$data = $obj->consultar("CALL usuarioActivos()");
													foreach($data as $key){
														echo "<option value='".$key['nombreUsuario']."'>".$key['nombreUsuario']."</option>";
													}
												?>
											</select>
										</label>
										
										<label for="" class="">Ubicación
											<input type="text" name="ubica" id="ubica" class="form-control" style="width:260px" required="require">
										</label>
										<label for="" class="">Email
											<input type="email" name="email" id="email" class="form-control" style="width:260px">
										</label>
									</div>	
									<div class="subladoC">
									    <h4 style="color:#158ff5;">conexion remota</h4>
											<label for="" class="">Team Viewer
											<input type="text" name="team" id="team" class="form-control" value="0" style="width:140px;text-align: center;" required="require">
										</label>
										<label for="" class="">AnyDesk
											<input type="text" name="any" id="any" class="form-control" value="0" style="width:140px;text-align: center;" required="require">
										</label>
									</div>
									<h4 style="color:#158ff5;margin-top:-7px">Equipo</h4>
									<div class="subladoC" style="margin-top:-18px">	
									    <label for="">Tipo
										    <select class="form-control" name="tipo" id="tipo" required="require" style="width:110px" required="require">
										    	<option value="PC">PC</option>
										    	<option value="Servidor">Servidor</option>
										    	<option value="Lapto">Lapto</option>
										    	<option value="Teclado">Teclado</option>
										    	<option value="Monitor">Monitor</option>
										    	<option value="Impresora">Impresora</option>
										    	<option value="Camara">Camara</option>
										    	<option value="Ups">Ups</option>
										    	<option value="Ratón">Ratón</option>
										    	<option value="Teléfono">Teléfono</option>
										    </select>
										</label>
										<label for="" class="">Ordenador
											<input type="text" name="pc" id="pc" class="form-control" style="width:110px" value="0">
										</label>
										<label for="" class="">Sistema Operativo
											<input type="text" name="siteoparat" id="siteoparat" class="form-control" style="width:110px">
										</label>
										<label for="" class="">Ram(GB)
											<input type="text" name="ram" id="ram" class="form-control" value="0" style="width:70px;text-align: center;">
										</label>
										<label for="" class="">DD(GB)
											<input type="text" name="dd" id="dd" class="form-control" value="0" style="width:70px;text-align: center;">
										</label>
									</div>
									<div class="">
									    <label for="" class="">IP
											<input type="text" name="ip" id="ip" class="form-control" style="width:110px;text-align: center;">
										</label>
									    <label for="" class="">Mac address
											<input type="text" name="mac" id="maca" class="form-control" style="width:180px;text-align: center;">
										</label>
									</div>
									<div id="detalleimpre">
									    <h4 style="color:#158ff5;">Impresora</h4>
									    <label for="" class="">Marca
											<input type="text" name="impremarca" id="impremarca" class="form-control">
										</label>
										<label for="" class="">Modelo
											<input type="text" name="impremodelo" id="impremodelo" class="form-control">
										</label>
										<label for="" class="">Tóner
											<input type="text" name="toner" id="toner" class="form-control">
										</label>
									</div>
									<div class="">
										<label for="" class="">Iconos
											<input type="text" name="iconos" id="iconos" class="form-control" style="width:550px">
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
	<!--Fin modal nuevo Y Modificar-->
   <!--Inicio modal complemento-->
	<div class="form-group">
		<div class="modal fade" id="abreModalcomplemento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header bg-info cabeza">
						<h3 class="modal-title fondoLs" id="myModalLabelc"></h3>
						<div class="respuesta" id="respuesta"></div>
					</div>
					<form id="formularioc" class="form-horizontal" onsubmit="return registroData();">
						<div class="modal-body">
							<input type="hidden" id="id-prodc" name="id-prodc">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso" value="Registro">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladoG">
									    <label for="">Estado
										    <select class="form-control" name="estado" id="estadoc" required="require" style="width:150px" required="require">
										    	<option value="Activo">Activo</option>
										    	<option value="Por reparación">Por reparación</option>
										    	<option value="Desincorporado">Desincorporado</option>
										    	<option value="por asignar">por asignar</option>
										    </select>
										</label>
										<label for="" class="">Usuario
											<select class="form-control" name="user" id="userc" required="require">
												<option value=""></option>
												<?php
													$obj = new conectarDB();
													$data = $obj->consultar("CALL usuarioActivos()");
													foreach($data as $key){
														echo "<option value='".$key['nombreUsuario']."'>".$key['nombreUsuario']."</option>";
													}
												?>
											</select>
										</label>
									</div>	
									<div class="subladoC">
									    <h4 style="color:#158ff5;">conexion remota</h4>
											<label for="" class="">Team Viewer
											<input type="text" name="team" id="teamc" class="form-control" value="0" style="width:140px;text-align: center;" required="require">
										</label>
										<label for="" class="">AnyDesk
											<input type="text" name="any" id="anyc" class="form-control" value="0" style="width:140px;text-align: center;" required="require">
										</label>
									</div>
									<h4 style="color:#158ff5;margin-top:-7px">Equipo</h4>
									<div class="subladoC" style="margin-top:-18px">	
									    <label for="">Tipo
										    <select class="form-control" name="tipo" id="tipoc" required="require" style="width:110px" required="require">
										    	<option value="PC">PC</option>
										    	<option value="Lapto">Lapto</option>
										    	<option value="Teclado">Teclado</option>
										    	<option value="Monitor">Monitor</option>
										    	<option value="Impresora">Impresora</option>
										    	<option value="Camara">Camara</option>
										    </select>
										</label>
										<label for="" class="">Ram(GB)
											<input type="text" name="ram" id="ramc" class="form-control" value="0" style="width:70px;text-align: center;">
										</label>
										<label for="" class="">DD(GB)
											<input type="text" name="dd" id="ddc" class="form-control" value="0" style="width:70px;text-align: center;">
										</label>
										<label for="" class="">IP
											<input type="text" name="ip" id="ipc" class="form-control" style="width:110px;text-align: center;">
										</label>
											<label for="" class="">Mac address
											<input type="text" name="mac" id="mac" class="form-control" style="width:180px;text-align: center;">
										</label>
									</div>
									<div class="subladoC">
									
									</div>
									<div id="detalleimprec">
									    <h4 style="color:#158ff5;">Impresora</h4>
									    <label for="" class="">Marca
											<input type="text" name="impremarca" id="impremarcac" class="form-control">
										</label>
										<label for="" class="">Modelo
											<input type="text" name="impremodelo" id="impremodeloc" class="form-control">
										</label>
										<label for="" class="">Tóner
											<input type="text" name="toner" id="tonerc" class="form-control">
										</label>
									</div>
								</article>
							</section>
							<section class="pie">
								<label for="" class="control-label ">Observaciones</label>
									<input type="text" class="form-control observa"  name="observa" id="observac">
							</section>
						</div>
						<div class="pieData bg-success">
							<div class="boton">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							<div class="submit">
								
							</div>
						</div>
					</form>
				</div>
				<!--fin modal-content-->
			</div>
			<!--fin modal-dialog-->
		</div>
	</div>
	<!--Fin modal complemento-->
    <!--Inicio modal ordenador-->
	<div class="form-group">
		<div class="modal fade" id="abreModald" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header bg-info cabeza">
						<h3 class="modal-title fondoLs" id="myModalLabeld"></h3>
					</div>
					<form id="formulariod" class="form-horizontal" onsubmit="return registroData();">
						<div class="modal-body">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladoc">
                                        <label for="">Correlativo
                                            <input type="text" class="form-control" id="id-prodd">
                                        </label>
									    <label for="">Estado
										    <select class="form-control" name="estado" id="estadod">
										    	<option value="Activo">Activo</option>
										    	<option value="Por reparación">Por reparación</option>
										    	<option value="Desincorporado">Desincorporado</option>
										    	<option value="por asignar">por asignar</option>
										    </select>
										</label>
										<label for="" class="">Usuario
											<select class="form-control" name="user" id="userd">
												<option value=""></option>
												<?php
													$obj = new conectarDB();
													$data = $obj->consultar("CALL usuarioActivos()");
													foreach($data as $key){
														echo "<option value='".$key['nombreUsuario']."'>".$key['nombreUsuario']."</option>";
													}
												?>
											</select>
										</label>
									</div>	
									<div class="subladoc">
										<label for="" class="">Ubicación
											<input type="text" name="ubica" id="ubicad" class="form-control">
										</label>
										<label for="" class="">Email
											<input type="email" name="email" id="emaild" class="form-control">
										</label>
										
											<label for="" class="">Team Viewer
											<input type="text" name="team" id="teamd" class="form-control" value="0" style="width:90px;text-align: center;" required="require">
										</label>
										<label for="" class="">AnyDesk
											<input type="text" name="any" id="anyd" class="form-control" value="0" style="width:90px;text-align: center;" required="require">
										</label>
									</div>
									<h4 style="color:#158ff5;margin-top:-7px">Equipo</h4>
									<div class="subladoC" style="margin-top:-18px">	
									    <label for="">Tipo
										    <select class="form-control" name="tipo" id="tipod" required="require" style="width:110px" required="require">
										    	<option value="PC">PC</option>
										    	<option value="Lapto">Lapto</option>
										    	<option value="Teclado">Teclado</option>
										    	<option value="Monitor">Monitor</option>
										    	<option value="Impresora">Impresora</option>
										    	<option value="Camara">Camara</option>
										    	<option value="Ups">Ups</option>
										    </select>
										</label>
										<label for="" class="">Ordenador
											<input type="text" name="pc" id="pcd" class="form-control" style="width:110px" value="0">
										</label>
										<label for="" class="">Sistema Operativo
											<input type="text" name="siteoparat" id="siteoparatd" class="form-control" style="width:110px">
										</label>
										<label for="" class="">Ram(GB)
											<input type="text" name="ram" id="ramd" class="form-control" value="0" style="width:70px;text-align: center;">
										</label>
										<label for="" class="">DD(GB)
											<input type="text" name="dd" id="ddd" class="form-control" value="0" style="width:70px;text-align: center;">
										</label>
										<label for="" class="">IP
											<input type="text" name="ip" id="ipd" class="form-control" style="width:110px;text-align: center;">
										</label>
									</div>
									
									<div class="">
										<label for="" class="">Iconos
											<input type="text" name="iconos" id="iconosd" class="form-control" style="width:550px">
										</label>
									</div>
								</article>
							</section>
							<section class="pie">
								<label for="" class="control-label ">Observaciones</label>
									<input type="text" class="form-control observa"  name="observa" id="observad">
							</section>
						</div>
						<div class="pieData bg-success">
							<div class="boton">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							<div class="submit">
								<input type="submit" value="Modificar" class="btn btn-success" id="regd" />
							</div>
						</div>
					</form>
				</div>
				<!--fin modal-content-->
			</div>
			<!--fin modal-dialog-->
		</div>
	</div>
	<!--Fin modal ordenador-->
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
		<script src="aplicaciones/js/informatica.js"></script>
	</div>
  </body>
</html>