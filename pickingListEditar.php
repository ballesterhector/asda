<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';

	require "aplicaciones/html/head";
    
?>

  <body>
    <header>
		<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
		<input type="hidden" id="usuari" value="<?php echo $usuario ?>">
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
				<h3 class="titulos" id="">Editar picking List</h3>
			</div>
			<div class="edicion">
				<input type="number" class="form-control" id="anular" name="anular" style="width: 100px;text-align: center;" autocomplete="off" placeholder="Masivo" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Indique picking list a anular">
				<input type="text" class="form-control" id="motiv" name="motiv" placeholder="Motivo" style="margin-left: 10px">
				<i class="fas fa-check fa-2x" style="margin-left: 10px" id="anulacion"></i>
			</div>
			<div class="ayuda">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/consultaPickingList.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
			</div>
		</div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
			    <tr class="">
					<th class="text-center">Picking list</th>
					<th class="text-center">Etiqueta actual</th>
					<th class="text-center">Etiqueta anterior</th>
					<th class="text-center">Despacho</th>
					<th class="text-center">Código</th>
					<th class="text-center">Producto</th>
					<th class="text-center">Ubicación</th>
					<th class="text-center">Almacen</th>
					<th class="text-center">Motivo</th>
					<th class="text-center">Empaques</th>
					<th class="text-center">Unidades</th>
					<th class="text-center">Kilos</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tfoot>
                <tr>
                    <th colspan="8" style="text-align:right">Total:</th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                	<th class="dt-right"></th>
                </tr>
            </tfoot>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL pickinglistidevol('".$_GET['pickin']."')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{

								
						foreach ($data as $filas) { ?>
							<?php if ($filas['documentoEvol']==0) {?>
								<tr>
									<td><?php echo $filas['pickingEvol'] ?></td>
									<td><?php echo $filas['etiquetaEvol'] ?></td>
									<td><?php echo $filas['etiquetavieja'] ?></td>
									<td><?php echo $filas['documentoEvol'] ?></td>
									<td><?php echo $filas['codigoEtiqueta'] ?></td>
									<td><?php echo $filas['productoEtiqueta'] ?></td>
									<td><?php echo $filas['ubicaEtiqueta'] ?></td>
									<td><?php echo $filas['almacenEtiqueta'] ?></td>
									<td><?php echo $filas['motivoEtiqueta'] ?></td>
									<td class="text-right"><?php echo $filas['empaques'] ?></td>
									<td class="text-right"><?php echo $filas['unidades'] ?></td>
									<td class="text-right"><?php echo $filas['kilos'] ?></td>
									<td class="text-center icono">
										<a href='javascript:ajuste(<?php echo $filas['idevol'] ?>)' class='glyphicon glyphicon-folder-open fa-2x' title='Modificar'</a>
									</td>
								</tr>
							<?php }else{ ?>
								<tr class="bg-danger">
									<td class="bg-danger"><?php echo $filas['pickingEvol'] ?></td>
									<td class="bg-danger"><?php echo $filas['etiquetaEvol'] ?></td>
									<td class="bg-danger"><?php echo $filas['etiquetavieja'] ?></td>
									<td class="bg-danger"><?php echo $filas['documentoEvol'] ?></td>
									<td class="bg-danger"><?php echo $filas['codigoEtiqueta'] ?></td>
									<td class="bg-danger"><?php echo $filas['productoEtiqueta'] ?></td>
									<td class="bg-danger"><?php echo $filas['ubicaEtiqueta'] ?></td>
									<td class="bg-danger"><?php echo $filas['almacenEtiqueta'] ?></td>
									<td class="bg-danger"><?php echo $filas['motivoEtiqueta'] ?></td>
									<td class="text-right bg-danger"><?php echo $filas['empaques'] ?></td>
									<td class="text-right bg-danger"><?php echo $filas['unidades'] ?></td>
									<td class="text-right bg-danger"><?php echo $filas['kilos'] ?></td>
									<td class="text-center icono">
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
           		<div class="modal-dialog">
             		<div class="modal-content">
						<div class="modal-header bg-info cabeza">
							<h3 class="modal-title fondoLs" id="myModalLabel"></h3>
							<div class="respuesta" id="respuesta"></div>
						</div>
							<form id="formulario" class="form-horizontal" onsubmit="return modificarData();">
								<div class="modal-body">
									<input type="text" id="proceso" name="proceso">
									<input type="hidden" id="id-prod" name="id-prod">
									<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
									<section class="datosPicking">
										<div class="pedido">
											<label for="" class="labelA">Etiqueta
												<input type="text" class="form-control" name="etique" id="etique" disabled>
											</label>
											<label for="" class="labelB">Movimiento
												<input type="text" class="form-control" name="movimi" id="movimi" value='ajustaretiqueta'  >
											</label>
								        </div>
								        <div class="pedido">			
											<label for="" class="labelC">Unidades
												<input type="number" class="form-control" name="unidad" id="unidad" disabled>
											</label>
											<label for="" class="labelD">Ajuste
												<input type="number" class="form-control" name="unidajuste" id="unidajuste">
											</label>
										</div>
										<div class="motivo">
											<label for="" class="labelC">Empaque
												<input type="number" class="form-control" id="empaqu" disabled>
											</label>
											<label for="" class="labelD">Ajuste
												<input type="number" class="form-control" name="empaquajuste" id="empaquajuste">
											</label>
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
		<script src="aplicaciones/js/pickingListEditar.js"></script>
	</div>
  </body>
</html>