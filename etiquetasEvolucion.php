<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
	
	require "aplicaciones/html/head";
?>

< <body>
    <header>
		<input type="hidden" value="<?php echo $_GET['id_etiq'] ?>" id="etiques">
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
				<h3 class="titulos" id="">Etiquetas evolución</h3>
			</div>
			<div>
			<input type="text" class="form-control" id="etiqBusca">
			</div>
			<div class="nuevo">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/InventariosTeoricos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
			    <a href="javascript: onclick(inventarioExcel())"><i class="fas fa-file-excel fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="archivo por código"></i></a>
            </div>
		</div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered " id="dataTables">
			<thead>
			    <tr class="">
					<th class="text-center">Etiqueta actual</th>
					<th class="text-center">Coordenada</th>
					<th class="text-center">Movimiento</th>
					<th class="text-center">Documento <br><sub>(Link)</sub> </th>
					<th class="text-center">Picking</th>
					<th class="text-center">Código</th>
					<th class="text-center">Producto</th>
					<th class="text-center">Lote</th>
					<th class="text-center">Vencimiento</th>
					<th class="text-center">Empaques</th>
					<th class="text-center">Unidades</th>
					<th class="text-center">Kilos</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL etiquetasEvol('".$_GET['id_etiq']."')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<tr>
								<td><?php echo $filas['etiquetaEvol'] ?></td>
								<td><?php echo $filas['coordenadaEtiqueta'] ?></td>
								<td><?php echo $filas['movimientoEvol'] ?></td>
								<td class="text-center bg-info"><a href="javascript:documento(<?php echo $filas['pri'] ?>,<?php echo $filas['documentoEvol'] ?>)"><?php echo $filas['documentoEvol'] ?></a></td>
								<td><?php echo $filas['pickingEvol'] ?></td>
								<td><?php echo $filas['codigoEtiqueta'] ?></td>
								<td><?php echo $filas['productoEtiqueta'] ?></td>
								<td><?php echo $filas['loteEtiqueta'] ?></td>
								<td><?php echo $filas['venceEtiqueta'] ?></td>
								<td class="text-right"><?php echo $filas['empaquesEvol'] ?></td>
								<td class="text-right"><?php echo $filas['unidades'] ?></td>
								<td class="text-right"><?php echo $filas['kilos'] ?></td>
							</tr>
											
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
      </article>
    </div>
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
	</div>

	<script type=""text/javascript>
        $(document).ready(function () {
            $('#dataTables').dataTable({
                "order": [[0, 'asc'], [1, 'asc']],
                "lengthMenu": [[15], [15]]
            });
               
		}); //fin ready  
		
		$('#etiqBusca').on('change', function () {
          var numetiq = document.getElementById('etiqBusca').value;
          document.location = 'etiquetasEvolucion.php?id_etiq=' + numetiq;
        });

		function documento(movi,docu){
			if(movi==0){
					window.open("recepcionesHtml.php?numRecep=" + docu, "Reporte")
				}else if(movi==1){
					window.open("despachosHtml.php?num=" + docu, "Reporte");
				}else if(movi==3){
					window.open("transferenciasClientesHtml.php?trasfe=" + docu, "Reporte");
				}else{
					window.open("transferenciasHtml.php?trasfe=" + docu, "Reporte"); 
				}
					
		}

		function inventarioExcel() {
			var dat_etiq = document.getElementById('etiques').value;
			document.location.href = ("inventarioEvolucionExcel.php?id_etique=" + dat_etiq);
		}


    </script>
  </body>
</html>