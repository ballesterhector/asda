<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();

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
				<h3 class="titulos">Data transportes registrados</h3>
			</div>
			<div class="nuevo">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/transportes.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
			</div>
			<div class="">
				<input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Nuevo">
			</div>
		</div>
    </header>
    <div id='main'>
      <article class="conduc">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
				<tr class="bg-success">
					<th class="text-center">Transporte</th>
					<th class="text-center">RIF</th>
					<th class="text-center">Estado</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL transportesSelect('2')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<?php if($filas['transEstado']==0){?>
                                <tr>
									<td><?php echo $filas['nombre_trans'] ?></td>
									<td><?php echo $filas['rif_transp'] ?></td>
									<td><?php echo $filas['estado'] ?></td>
									<td class="text-center">
										<a href='javascript:modal(<?php echo $filas['idtransporte'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado'</a>
									</td>
										</tr>
                                <?php }else{ ?>
									<tr class="">
										<td class="bg-danger"><?php echo $filas['nombre_trans'] ?></td>
										<td class="bg-danger"><?php echo $filas['rif_transp'] ?></td>
										<td class="bg-danger"><?php echo $filas['estado'] ?></td>
										<td class="text-center">
											<a href='javascript:modal(<?php echo $filas['idtransporte'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado'</a>
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
					<form id="formulario" class="form-horizontal" onsubmit="return agregarRegistro();">
						<div class="modal-body">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" name="modificador" id="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso">
							<section class="">
								<article class="">
									<div class="modalConductor">
										<label for="" class="">Transporte</label>
										<input type="text" class="form-control" name="transp" id="transp">
										
										<label for="" class="contened">RIF</label>
										<input type="text" name="rif" id="rif" class="form-control" value="0" autocomplete="off">
										<div class="estad">
											<label for="" class="" id="labelEstado">Estado</label>
											<select class="form-control" name="estad" id="estado">
												<option value="0">Activo</option>
												<option value="1">Inactivo</option>
											</select>
										</div>	
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
		</script>>
    </footer>
    <div>
		<?php require "aplicaciones/html/footer"  ?>
		<script src="aplicaciones/js/transportes.js"></script>
	</div>
  </body>
</html>