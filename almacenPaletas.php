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
		<div class="recepcion">
			<div class="titulo">
				<h3 class="titulos" id="respuesta">Data evolución almacen paletas</h3>
			</div>
			<div class="ayudarecepcion">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/almacenPaletas.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="almacenPaletasResumen.php"><i class="fas fa-clone fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Resumen"></i></a>
                <a href='javascript: onclick(reportepdf(<?php echo $_GET['id_cliente'] ?>))'><i class="fas fa-file-pdf fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte evolución"></i></a>
            </div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
				<tr class="bg-success">
					<th class="text-center">Cliente</th>
					<th class="text-center">Fecha</th>
					<th class="text-center">Documento</th>
					<th class="text-center">Movimiento</th>
					<th class="text-center">Llenas</th>
					<th class="text-center">Vacias</th>
					<th class="text-center">Dañadas</th>
					<th class="text-center">Total</th>
				</tr>
			</thead>
			<tfoot>
                <tr>
                    <th colspan="4" style="text-align:right">Total:</th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                </tr>
            </tfoot>
			
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL almacenPaletasSelect('".$_GET['id_cliente']."')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<tr>
								<td><?php echo $filas['cliente_almpale'] ?></td>
								<td class="text-center"><?php echo $filas['fecha_document_almpale'] ?></td>
								<td class=""><?php echo $filas['documento_cnd_almpale'] ?></td>
								<td><?php echo $filas['movimiento_almpale'] ?></td>
								<td class="dt-right"><?php echo $filas['llenas_almpale'] ?></td>
								<td class="dt-right"><?php echo $filas['vacias_almpale'] ?></td>
								<td class="dt-right"><?php echo $filas['danadas_almpale'] ?></td>
								<td class="dt-right"><?php echo $filas['total'] ?></td>
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
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h3 class="modal-title" id="myModalLabel"></h3>
						<h2 class="mensajepick" id="mensajepick"></h2>
					</div>
					<form id="formulario" class="form-horizontal">
						<div class="modal-body">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" id="arranq" name="arranq">
							<input type="hidden" id="idclie" name="idclie">
							<section class="paletas">
								<article class="modaldata">
									<div class="ladoA">
										<label for="" class="recep">Cliente</label>
										<input type="text" class="form-control recep" id="client" readonly >
									</div>	
									<div class="ladoB">
										<label for="" class="recep">Movimiento
										    <input type="text" class="form-control recep" id="Movimi" readonly style="width:120px">
										</label>
										<label for="" class="recep">Documento
										    <input type="text" class="form-control recep" id="document" readonly style="width:95px">
										</label>
									</div>
									
									<div class="ladoC">
										<label for="" class="recep">Llenas
										    <input type="text" class="form-control recep" name="llenas" id="llenas">
										</label>
										<label for="" class="recep">Vacias
										    <input type="text" class="form-control recep" name="vacias" id="vacias">
										</label>
										<label for="" class="recep">Dañadas
										    <input type="text" class="form-control recep" name="malas" id="malas">
										</label>
									</div>
								</article>	
							</section>
						</div>	
						<div class="pieData bg-success">
							<div class="boton">
								<button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
							</div>
							<div class="submit">
								<input type="button" class="btn btn-success" id="regsp" value="Procesar">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
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
		<script src="aplicaciones/js/almacenPaletas.js"></script>
	</div>
  </body>
</html>