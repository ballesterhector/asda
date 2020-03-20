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
		<input type="hidden" name="usumodifi" id="usumodifi" value="<?php echo $usuario ?>">
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
				<h3 class="titulos" id="">Solicitud de reparación de equipos</h3>
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
					<th class="text-center">Correlativo</th>
					<th class="text-center">Solicitado por</th>
					<th class="text-center">Equipo</th>
					<th class="text-center">Ubicación</th>
					<th class="text-center">Falla</th>
					<th class="text-center">Estado</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL informatica_solicitudSelect('0')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
						    <?php if($filas['estado'] == 'Abierta'){?>
						        <tr>
                                    <td><?php echo $filas['codigosolici'] ?></td>
                                    <td align="center"><?php echo str_pad($filas['codigosolici'], 7, "0", STR_PAD_LEFT) ?></td>
                                    <td><?php echo $filas['solicitadopor'] ?></td>
                                    <td><?php echo $filas['tipoEquipo'] ?></td>
                                    <td><?php echo $filas['ubicacion'] ?></td>
                                    <td><?php echo $filas['falla'] ?></td>
                                   	<td><?php echo $filas['estado'] ?></td>
                                    <td class="text-center icono">
                                       <a href='javascript:modifica(<?php echo $filas['codigosolici'] ?>,<?php echo $niveles ?>)' class='fas fa-edit' title='Modificar'></a>
                                       <a href='javascript:complemento(<?php echo $filas['codigosolici'] ?>,<?php echo $niveles ?>)' class='fas fa-link' title='Complemento'></a>
                                        <a href='javascript:cerrarmodal(<?php echo $filas['codigosolici'] ?>,<?php echo $niveles ?>)' class='fas fa-times' title='Cerrar'></a>
                                     </td>
                                </tr>
						     <?php }else{ ?>
						  	<tr style="background: #FAA35C">
						  		<td><?php echo $filas['codigosolici'] ?></td>
								<td align="center"><?php echo str_pad($filas['codigosolici'], 7, "0", STR_PAD_LEFT) ?></td>
                                <td><?php echo $filas['solicitadopor'] ?></td>
                                <td><?php echo $filas['tipoEquipo'] ?></td>
                                <td><?php echo $filas['ubicacion'] ?></td>
                                <td><?php echo $filas['falla'] ?></td>
                                <td><?php echo $filas['estado'] ?></td>
								<td class="icono">
									<a href=""></a>
									<a href=""></a>
									<a href='javascript:complemento(<?php echo $filas['codigosolici'] ?>,<?php echo $niveles ?>)' class='fas fa-link' title='Complemento' ></a>
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
							<input type="hidden" name="modifi" id="modifi" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso" value="Registro">
							<section class="modalProductos">
								<article class="ladoA">
									<div class="subladoG">
									    <label for="">
										    <input type="text" class="form-control" name="solicit" id="solicit" placeholder="Solicitado por" required="require" value="<?php echo $usuario ?>" readonly>
										</label>
										<label for="" class="">
											<select class="form-control" name="equip" id="equip" required="require">
												<option>Equipo</option>
												<?php
													$obj = new conectarDB();
													$data = $obj->consultar("CALL informatica_EquiposConsulta('0')");
													foreach($data as $key){
														echo "<option value='".$key['correlativo']."'>".str_pad($key['correlativo'], 7, "0", STR_PAD_LEFT)."  ".$key['tipoEquipo']."   ".$key['asignadoA']."</option>";
													}
												?>
											</select>
										</label>
										
										<label for="" style="width: 100%">
											<input type="text" name="falla" id="falla" class="form-control" placeholder="Indique la incidencia" required="require">
										</label>
									</div>	
								</article>
							</section>
							<section class="pie">
								<label for="" style="width: 100%">
									<input type="text" name="observ" id="observ" class="form-control" placeholder="Observaciones">
								</label>
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
   <!--Inicio modal cerrar-->
	<div class="form-group">
		<div class="modal fade" id="abreModalcerrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header bg-info cabeza">
						<h3 class="modal-title fondoLs" id="myModalLabelc">Registro de reparaciones</h3>
						<div class="respuesta" id="respuesta"></div>
					</div>
					<form id="formularioc" class="form-horizontal" onsubmit="return cerrar();">
						<div class="modal-body">
							<input type="hidden" id="codi" name="codi">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso" value="cerrar">
							<section class="modalProductos">
								<article class="pie">
									<div class="">
									   <label for="" class="">Factura
											<input type="text" class="form-control" name="facturacierre" id="facturacierre" style="width:120px;text-align: center;" required="require">
										</label>
									   <label for="" class="">Técnico
											<input type="text" name="tecni" id="tecni" class="form-control" style="width:300px;text-align: center;" required="require">
										</label>
									    <label for="">Costo
										   <input type="text" class="form-control" name="costo" id="costo" style="width:120px;text-align: center;" required="require">
										</label>
									</div>
								</article>
							</section>
							<section class="pie">
								<label for="" class="control-label ">Trabajo efectuado</label>
									<input type="text" class="form-control observa"  name="repara" id="repara">
							</section>
						</div>
						<div class="pieData bg-success">
							<div class="boton">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							<div class="submit">
								<input type="submit" value="Cerrar" class="btn btn-success" id="reg" />
							</div>
						</div>
					</form>
				</div>
				<!--fin modal-content-->
			</div>
			<!--fin modal-dialog-->
		</div>
	</div>
	<!--Fin modal cerrar-->
    
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
		<script src="aplicaciones/js/informaticasolicitud.js"></script>
	</div>
  </body>
</html>