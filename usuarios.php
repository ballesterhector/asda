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
		<div class="enlinea">
			<div class="titulo">
				<h3 class="titulos" id="respuesta">Data usuarios registrados</h3>
			</div>
			<div class="nuevo">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/usuarios.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
			 </div>
		</div>
    </header>
    <div id='main'>
      <article class="tablaUser">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
				<tr class="bg-success">
					<th class="text-center">Foto</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Usuario</th>
					<th class="text-center">Teléfono</th>
					<th class="text-center">Email</th>
					<th class="text-center">Nivel</th>
					<th class="text-center">Estado</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL usuarioSelect('0')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<?php if($filas['estadoUsuario']==0){?>
								<tr>
									<td class="text-center"><img src="../aplicaciones/fotos/<?php echo $filas['cedulaUsuario'] ?>.jpg" alt="" style="width:30px;"></td>
									<td class=""><?php echo $filas['nombreUsuario'] ?></td>
									<td class=""><?php echo $filas['usuario'] ?></td>
									<td class=""><?php echo $filas['telefonoUsuario'] ?></td>
									<td><?php echo $filas['emailUsuario'] ?></td>
									<td class="text-center"><?php echo $filas['nivelAutorizado'] ?></td>
									<td><?php echo $filas['estado'] ?></td>
									<td class="icono">
										<a href='javascript:asignaNivel(<?php echo $filas['num_usuario'] ?>,<?php echo $filas['cedulaUsuario'] ?>)' class='glyphicon glyphicon-folder-open fa-sm' title='Modificar nivel'</a>
										<a href='javascript:modificaEstado(<?php echo $filas['num_usuario'] ?>,<?php echo $filas['cedulaUsuario'] ?>)' class='fas fa-times fa-sm' title='Inactivar'</a>
										<a href='javascript:modal(<?php echo $filas['num_usuario'] ?>,<?php echo $filas['cedulaUsuario'] ?>)' class='fas fa-male fa-sm' title='Actualizar'</a>
									</td>
								</tr>
							<?php }else{ ?>
									<tr class="">
										<td class="text-center"><img src="../aplicaciones/fotos/<?php echo $filas['cedulaUsuario'] ?>.jpg" alt="" style="width:30px;"></td>
										<td class="bg-danger"><?php echo $filas['nombreUsuario'] ?></td>
										<td class="bg-danger"><?php echo $filas['usuario'] ?></td>
										<td class="bg-danger"><?php echo $filas['telefonoUsuario'] ?></td>
										<td class="bg-danger"><?php echo $filas['emailUsuario'] ?></td>
										<td class="bg-danger text-center"><?php echo $filas['nivelAutorizado'] ?></td>
										<td class="bg-danger"><?php echo $filas['estado'] ?></td>
										<td class="icono">
											<a href='javascript:asignaNivel(<?php echo $filas['num_usuario'] ?>,<?php echo $filas['cedulaUsuario'] ?>)' class='glyphicon glyphicon-folder-open fa-sm' title='Modificar nivel'</a>
											<a href='javascript:modificaEstado(<?php echo $filas['num_usuario'] ?>,<?php echo $filas['cedulaUsuario'] ?>)' class='fas fa-check fa-sm'   title='Activar'</a>
										    <a href='javascript:modal(<?php echo $filas['num_usuario'] ?>,<?php echo $filas['cedulaUsuario'] ?>)' class='fas fa-male fa-sm' title='Actualizar'</a>
										</td>
									</tr>
							<?php } ?>	
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
					<form id="formulario" class="form-horizontal" onsubmit="return modificarUsuario();">
						<div class="modal-body">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" name="modificador" id="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso">
							<input type="hidden" id="estado" name="estado">
							<section class="">
								<article class="">
									<div class="">
										<label for="" class="">Usuario</label>
										<input type="text" class="form-control" name="name" id="name" disabled="disabled">
									</div>
									<div class="">
										<label for="" class="">Sucursal</label>
										<input type="text" class="form-control" name="sucursar" id="sucursar">
									</div>
									<div class="">
										<label for="" class="">Gerencia</label>
										<input type="text" class="form-control" name="gerencia" id="gerencia">
									</div>
									<div class="">
										<label for="" class="">Area</label>
										<input type="text" class="form-control" name="area" id="area">
									</div>
									<div class="">
										<label for="" class="">Email</label>
										<input type="text" class="form-control" name="email" id="email">
									</div>
									<div class="">
										<label for="" class="">Teléfono</label>
										<input type="text" class="form-control" name="telefono" id="telefono">
									</div>
								</article>	
							</section>		
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
		<script src="aplicaciones/js/usuarios.js"></script>
	</div>
  </body>
</html>