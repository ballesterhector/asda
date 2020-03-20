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
            <input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
            <input type="hidden" id="modificador" value="<?php echo $usuario ?>">
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
                    <h4 class="titulos" id="mensaj">Actualizar etiqueta manual</h4>
                </div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/modificacionesEtiquetas.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                </div>
                <div class="clienteselect">
                    <select class="form-control" name="" id="cliBusca" autofocus style="width:270px;">
                        <option value="<?php echo $_GET['clibus'] ?>"><?php echo $clientes ?></option>
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
                    <label for="" class="control-label">Etiqueta del</label>
                    <input type="text" class="form-control" style="width:90px;" id="dels" value="<?php echo $_GET['del'] ?>">
                    <label for="" class="control-label">al</label>
                    <input type="text" class="form-control" style="width:90px;" id="als" value="<?php echo $_GET['al'] ?>">
                    <i id="ejecuta" class="fas fa-caret-right fa-3x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i>
                    <i id="libera" class="fas fa-quidditch fa-2x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Liberar etiqueta manual"></i>
                </div>
            </div>
        </header>

        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Etiqueta</th>
                            <th class="text-center">Manual</th>
                            <th class="text-center">Coordenada</th>
                            <th class="text-center">Ubicación</th>
                            <th class="text-center">Almacen</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Lote</th>
                            <th class="text-center">Vencimiento</th>
                             <th class="text-center">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL etiquetasPorRango('".$_GET['clibus']."','".$_GET['del']."','".$_GET['al']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['etiquetaEvol'] ?></td>
                                            <td><?php echo $filas['manualEtiqueta'] ?></td>
                                            <td><?php echo $filas['coordenadaEtiqueta'] ?></td>
                                            <td><?php echo $filas['ubicaEtiqueta'] ?></td>
                                            <td ><?php echo $filas['almacenEtiqueta'] ?></td>
                                            <td><?php echo $filas['codigoEtiqueta'] ?></td>
                                            <td><?php echo $filas['productoEtiqueta'] ?></td>
                                            <td><?php echo $filas['loteEtiqueta'] ?></td>
                                            <td><?php echo $filas['venceEtiqueta'] ?></td>
                                            <td class="text-center">
                                                <a href='javascript:modal(<?php echo $filas['etiquetaEvol'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado' </a>
                                            </td>
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
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header bg-info cabeza">
							<h3 class="modal-title fondoLs" id="myModalLabel"><b>Registro de Coordenadas</b></h3>
							<div class="respuesta" id="respuesta"></div>
						</div>
						<form id="formulario" class="form-horizontal" onsubmit="return agregarRegistro();">
							<div class="modal-body">
								<input type="hidden" id="id-prod" name="id-prod">
								<input type="hidden" name="modificador" id="modificador" value="<?php echo $usuario ?>">
								<input type="hidden" id="proceso" name="proceso">
								<section class="datosCliente">
									<article class="datosA">
										<label for="" class="labelA">Etiqueta
										    <input type="text" class="form-control names" name="etiqueta" id="etiqueta" disabled style="width:100px;text-align:center">
								        </label>
									    <label for="" class="labelB">Manual
											<input type="number" name="manual" id="manual" class="form-control center rack" autocomplete="off" required="require" min="1"  style="width:100px;text-align:center" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Etiqueta manual" value="1">
								        </label>
									</article>
								</section>
							</div>
							<div class="modal-footer bg-info abajo">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<input type="button" value="Verificar" class="btn btn-success text-center" style="width:90px" id="veri" />
								<input type="submit" value="Modificar"  class="btn btn-success text-center" style="width:90px" id="reg" />
							</div>
						</form>
					</div>
					<!--fin modal-content-->
				</div>
				<!--fin modal-dialog-->
			</div>
			<!--fin modal-fade-->
		</div>
		<!--Fin form-group id=formG1-->
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
            <?php require "aplicaciones/html/footer" ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dataTables').dataTable({
                    "order": [[0, 'asc']],
                    "lengthMenu": [[10], [10]],
                });

            }); //fin ready

            $('#ejecuta').on('click', function () {
                var dels = document.getElementById('dels').value;
                var als = document.getElementById('als').value;
                var numClie = document.getElementById('cliBusca').value;
                if(numClie>0){
                    document.location = 'modificarManual.php?clibus=' + numClie + '&del='+ dels + '&al=' + als;
                }else{
                    swal("Data incompleta!", "Debe ingresar el cliente", "error");
                }
                
            });
            
            $('#libera').on('click', function () {
                var dels = document.getElementById('dels').value;
                var als = document.getElementById('als').value;
                var usua = document.getElementById('modificador').value;
                var numClie = <?php echo $_GET['clibus'] ?>;
                $.ajax({
                    type:'GET',
                    url:'modificaManual_Funciones.php',
                    data:'proceso=' + 'libera' + '&clie=' + numClie + '&del='+ dels + '&al=' + als + '&usua=' + usua,
                    success:function(data){
                        if (data == 'Registro completado con exito') {
                            $('#mensaj').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
                            setTimeout('location.reload()', 1000);
                        } else {
                            $('#mensaj').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
                          //  setTimeout('location.reload()', 1550);
                        }
                    }
                });
                
                
                
                
            });
            
            $('#veri').on('click',function(){
                var manual =document.getElementById('manual').value;
                $.ajax({
                    type:'GET',
                    url:'modificaManual_Funciones.php',
                    data:'proceso=' + 'manual' + '&manual=' + manual,
                    success: function(valores){
                        var datos = eval(valores);
                        if(datos[0]['manual'] > 0){
                            swal("Etiqueta manual asignada a la etiqueta evol "+datos[0]['etiq'] , "Debe liberarla para reasignarla", "error");
                        }else{
                            $('#reg').attr('disabled', false);
                            $('#reg').addClass('btn-danger');
                        }   
                    }
                });
            });
            
            function modal(id, niv) {
                $('#formulario')[0].reset();
                $("#manual").css('background-color','#a6cff2');
                $('#reg').attr('disabled', true);
                var url = 'modificaManual_Funciones.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'proceso=' + 'Edicion' + '&nomCli=' + id,
                    success: function (valores) {
                        var datos = eval(valores);
                        $('#myModalLabel').html('Asignar etiqueta manual');
                        $('#myModalLabel').addClass('text-danger');
                        $('#proceso').val("Modifica");
                        $('#etiqueta').val(id);
                        $('#id-prod').val(id);
                        if (niv > 3) {
                            swal("Oops!", "Su nivel de usuario no le autoriza la actualización de la data", "error");
                        } else {
                            $('#abreModal').modal({
                                show: true,
                                backdrop: 'static'
                            });
                        }
                    }
                });
            }
            
            function agregarRegistro() {
                var url = 'modificaManual_Funciones.php';
                $('#reg').attr('disabled', true);
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: $('#formulario').serialize(),
                    success: function(data) {
                        if (data == 'Registro completado con exito') {
                            $('#clos').attr('disabled', true);
                            $('#respuesta').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
                            setTimeout('location.reload()', 100);
                        } else {
                            $('#reg').show();
                            $('#clos').show();
                            $('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
                        }
                    }
                });
                return false;
            }
        
        </script>
    </body>

    </html>
