<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
	require "aplicaciones/html/head";
?>

	<body>
		<header>
			<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
			<input type="hidden" value="<?php echo $nomClie ?>" id="nCliente">
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
					<h3 class="titulos">Pesos por cliente y familia</h3>
				</div>
				<div class="ayuda ayudapick">
					<a href="#" onclick="window.open('http:aplicaciones/ayudas/pickingFamilia.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				</div>
				<div>
					<select class="form-control" name="" id="cliBusca" autofocus>
						<option value=""></option>
							<?php
								$obj = new conectarDB();
								$data = $obj->consultar("CALL clientesActivosConsulta('0')");
								foreach($data as $key){
									echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
								}
							?>
					</select>
				</div>
			</div>
		</header>
		<div id='main'>
			<article class="tabla">
				<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
					<thead>
						<tr class="bg-success">
						    <th class="text-center">Cliente</th>
                            <th class="text-center">Familia</th>
                            <th class="text-center">Empaques</th>
                            <th class="text-center">Unidades</th>
                            <th class="text-center">kilos</th>
                            <th class="text-center">Toneladas</th>
                        </tr>
					</thead>
					<tbody>
						<?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL clientesResumenPesoFamilia('".$_GET['id_cliente']."')");
                            $dat= json_encode($data);
                            if ($dat=='null') {
								echo '';
                            }else{
								foreach ($data as $filas) { ?>
									<tr>
									    <td class="text-center"><?php echo $filas['clienteEtiqueta'] ?></td>
										<td class=""><?php echo $filas['familiaEtiqueta'] ?></td>
										<td class="text-right"><?php echo $filas['empaques'] ?></td>
										<td class="text-right"><?php echo $filas['unidades'] ?></td>
										<td class="text-right"><?php echo $filas['kilos'] ?></td>
										<td class="text-right"><?php echo number_format($filas['toneladas'],3) ?></td>
									</tr>
								<?php } ?>
							<?php } ?>
							<!--Fin del if $dat-->
					</tbody>
				</table>
			</article>
			<nav>
				<?php include "aplicaciones/nav/menuizquierda.html" ?>
			</nav>
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
            
            $('#cliBusca').on('change', function () {
			    var numClie = document.getElementById('cliBusca').value;
			    document.location = 'clientesPesoFamilia.php?id_cliente=' + numClie;
			});
        </script>
	</body>

	</html>
