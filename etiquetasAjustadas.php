<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['clibus']."')");
	$clientes = $data[0]['nombre_cli'];

    if($_GET['del']==0){
        $fedel = date('Y-m-d');
        $feal = date('Y-m-d');
    }else{
        $fedel = $_GET['del'];
        $feal = $_GET['al'];
    }

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
        <link rel="stylesheet" ty pe="text/css" href="aplicaciones/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="aplicaciones/css/bootstrap-submenu.min.css">
        <link rel="stylesheet" type="text/css" href="aplicaciones/font-awesome/css/fontawesome-all.css">
        <link rel="stylesheet" type="text/css" href="aplicaciones/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="aplicaciones/css/sweetalert.css">
        <link rel="stylesheet" type="text/css" href="aplicaciones/css/estilosFlex.css">
    </head>

    <body>
        <header>
            <input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
            <input type="hidden" id="modificador" value="<?php echo $usuario ?>">
            <input type="hidden" id="cli2" value="<?php echo $_GET['clibus'] ?>">
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
                    <h3 class="titulos">Data etiquetas ajustadas</h3>
                </div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/etiquetasAjustadas.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                </div>
                <div class="clienteselect">
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
                <div class="fechas">
                    <label for="" class="control-label">Del</label>
                    <input type="date" class="form-control" style="width:160px;padding-left:5px" id="dels" value="<?php echo $fedel ?>">
                    <label for="" class="control-label">Al</label>
                    <input type="date" class="form-control" style="width:160px;padding-left:5px" id="als" value="<?php echo $feal ?>">
                    <i id="ejecuta" class="fas fa-caret-right fa-3x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i>
                </div>
            </div>
        </header>

        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Documento</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Movimiento</th>
                            <th class="text-center">Etiqueta<br><sub>(Link)</sub></th>
                            <th class="text-center">Empaques</th>
                            <th class="text-center">Unidades</th>
                            <th class="text-center">Kilos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL etiquetasAjustadas('".$fedel."','".$feal."','".$_GET['clibus']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['documentoEvol'] ?></td>
                                            <td><?php echo $filas['tipo'] ?></td>
                                            <td><?php echo $filas['fechaDocumentoEvol'] ?></td>
                                            <td><?php echo $filas['movimientoEvol'] ?></td>
                                            <td align="center"><a href="javascript:mostrar(<?php echo $filas['etiquetaEvol']  ?>)" style="color:DodgerBlue;font-size:120%"><?php echo $filas['etiquetaEvol'] ?></a></td>
                                            <td align="right"><?php echo $filas['empaquesEvol']+0 ?></td>
                                            <td align="right"><?php echo $filas['unidades'] ?></td>
                                            <td align="right"><?php echo $filas['kilos'] ?></td>
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
         <!--Inicio modal nuevo-->
	<div class="form-group">
		<div class="modal fade" id="abreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h3 class="modal-title fondoLs" id="myModalLabel">Consulta etiquetas ajustadas</h3>
						<div class="respuesta" id="respuesta"></div>
					</div>
					<form id="formulario" class="form-horizontal" onsubmit="return agregarRegistro();">
						<div class="modal-body">
							<section class="modalProductos">
					    		<article class="ladoA">
									<div class="subladoA">
										<div id="etiquetas"></div>
      								</div>
								</article>	
							</section>
						</div>
						<div class="pieData bg-success">
							<div class="boton">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
                var f = new Date();
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
            <script src="../aplicaciones/js/etiquetasAjustadas.js"></script>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dataTables').dataTable({
                    "order": [[0, 'asc']],
                    "lengthMenu": [[15], [15]],
                });

            }); //fin ready

            $('#cliBusca').on('change',function(){
                var numClie = document.getElementById('cliBusca').value;
                document.location = 'etiquetasAjustadas.php?clibus=' + numClie + "&del=" + 0 + "&al=" + 0;
            });
            
            $('#ejecuta').on('click', function () {
                var dels = document.getElementById('dels').value;
                var als = document.getElementById('als').value;
                var numClie = document.getElementById('cli2').value;
                if(numClie>0){
                    document.location = 'etiquetasAjustadas.php?clibus=' + numClie + '&del='+ dels + '&al=' + als;
                }else{
                    swal("Data incompleta!", "Debe ingresar el cliente", "error");
                }
                
            });

            function mostrar(etique) {
                var url = 'etiquetasAjustadas_Funciones.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'proceso=' + 'dataEtiquetas' + '&etiqueta=' + etique,
                    success: function (datos) {
                        $('#abreModal').modal({
                                show: true,
                                backdrop: 'static'
                            });
                        $('#etiquetas').html(datos);
                    }

                });
            }

        </script>
    </body>

    </html>
