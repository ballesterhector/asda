<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['clibus']."')");
	$clientes = $data[0]['nombre_cli'];

	require "aplicaciones/html/head";
?>
  <body>
    <header>
		<input type="hidden" value="<?php echo $clientes ?>" id="nivelUsuario">
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
				<h3 class="titulos" id="">Data para ciclicos</h3>
			</div>
			<div>
				<select class="form-control" name="" id="cliBusca" autofocus>
					<option value=""><?php echo $clientes ?></option>
					<?php
						$obj = new conectarDB();
						$data = $obj->consultar("CALL clientesSelect('0')");
						foreach($data as $key){
							echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
							}
					?>
				</select>
			</div>
			<div>	
				<select class="form-control" title="Ingrese código identificador" style="width:190px" id="data">                                 </select> 
			</div>
			<div class="ayudaciclico">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/ciclicosdata.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="javascript: onclick(ciclicodatapdf())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Resultado de conteo"></i></a>
                <a href="#" onclick="window.open('http:aplicaciones/ayudas/ciclicoEnBlanco.xlsx')" /><i class="fas fa-file-excel fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte para toma de datos"></i></a>
                <a href="javascript: onclick(data())"><i class="fas fa-download fa-2x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i></a>
                <a href="javascript: onclick(cerrar())"><i class="fab fa-expeditedssl fa-2x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Culminar proceso"></i></a>
 			</div>
		</div>
    </header>
    <div id='main'>
      <article class="tablaciclico">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
			    <tr>
		        	<th border="0" class="th identif">Identificador</th><td class="identif"><?php echo $_GET['identificador'] ?></td>
			    </tr>
				<tr class="bg-success">
					<th class="text-center">Coordenada</th>
					<th class="text-center">Etiqueta</th>
					<th class="text-center">Código</th>
					<th class="text-center">Producto</th>
					<th class="text-center">Lote</th>
					<th class="text-center">Vence</th>
					<th class="text-center">Empaques</th>
					<th class="text-center">Fisico</th>
					<th class="text-center">Diferencia</th>
					<th class="text-center">Unidades</th>
					<th class="text-center">Fisico</th>
					<th class="text-center">Diferencia</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tfoot>
                <tr>
                    <th colspan="6" style="text-align:right">Total:</th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                </tr>
            </tfoot>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL ciclicosdataSelect('".$_GET['clibus']."','".$_GET['identificador']."')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
						<?php if($filas['culminado']==0){?>
							<tr>
								<td><?php echo $filas['coordenada'] ?></td>
								<td><?php echo $filas['etiqueta'] ?></td>
								<td><?php echo $filas['codigo'] ?></td>
								<td><?php echo $filas['producto'] ?></td>
								<td><?php echo $filas['lote'] ?></td>
								<td><?php echo $filas['vence'] ?></td>
								<td class="text-right bg-success"><?php echo $filas['empaques'] ?></td>
								<td class="text-right bg-danger"><?php echo $filas['empaquesFisico'] ?></td>
								<td class="text-right bg-warning"><?php echo $filas['diferEmpaq'] ?></td>
								<td class="text-right bg-success"><?php echo $filas['unidades'] ?></td>
								<td class="text-right bg-danger"><?php echo $filas['unidadesFisico'] ?></td>
								<td class="text-right bg-warning"><?php echo $filas['diferUnid'] ?></td>
								<td class="icono">
									<a href='javascript:modal(<?php echo $filas['idciclico'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado' </a>
								</td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td><?php echo $filas['coordenada'] ?></td>
								<td><?php echo $filas['etiqueta'] ?></td>
								<td><?php echo $filas['codigo'] ?></td>
								<td><?php echo $filas['producto'] ?></td>
								<td><?php echo $filas['lote'] ?></td>
								<td><?php echo $filas['vence'] ?></td>
								<td class="text-right bg-success"><?php echo $filas['empaques'] ?></td>
								<td class="text-right bg-danger"><?php echo $filas['empaquesFisico'] ?></td>
								<td class="text-right bg-warning"><?php echo $filas['diferEmpaq'] ?></td>
								<td class="text-right bg-success"><?php echo $filas['unidades'] ?></td>
								<td class="text-right bg-danger"><?php echo $filas['unidadesFisico'] ?></td>
								<td class="text-right bg-warning"><?php echo $filas['diferUnid'] ?></td>
								<td class="icono">
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
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h3 class="modal-title fondoLs" id="myModalLabel">Registro data ciclico</h3>
						<div class="respuesta" id="respuesta"></div>
					</div>
					<form id="formulario" class="form-horizontal" onsubmit="return agregarRegistro();">
						<div class="modal-body">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso">
							<section class="modalProductos">
							<article class="ladoA">
									<div class="subladotop">
										<label for="" class="text-center">Empaques
											<input type="text" class="form-control text-right" name="empaque" id="empaque" style="width:95px" value="0">
										</label>
										<div class="text-center">
											<label for="">Unidades
												<input type="text" class="form-control text-right" name="unidades" id="unidades" style="width:95px" value="0">
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
		<script src="aplicaciones/js/ciclico.js"></script>
	</div>
  </body>
</html>