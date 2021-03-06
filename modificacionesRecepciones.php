<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelectTodos('".$_GET['clibus']."')");
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
                    <h4 class="titulos">Modificaciones a las recepciones</h4>
                </div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/modificacionesProcesos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                </div>
                <div class="clienteselect">
                    <select class="form-control" name="" id="cliBusca" autofocus style="width:270px;">
                        <option value="<?php echo $_GET['clibus'] ?>"><?php echo $clientes ?></option>
                        <?php
                            $obj = new conectarDB();
                            $data = $obj->consultar("CALL clientesSelectTodos('0')");
                            foreach($data as $key){
                                echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
                                }
                        ?>
                    </select>
                </div>
                <div class="fechas">
                    <i id="ejecuta" class="fas fa-caret-right fa-3x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i>
                    <a href="javascript: onclick(modificaExcel())"><i class="fas fa-file-excel fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Archivo excel"></i></a>
                </div>
            </div>
        </header>

        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Recepción</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Movimiento</th>
                            <th class="text-center">Documento</th>
                            <th class="text-center">Modificado por</th>
                            <th class="text-center">Transporte</th>
                            <th class="text-center">Conductor</th>
                            <th class="text-center">Vehículo</th>
                         </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL recepcionesModificaciones('".$_GET['clibus']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['num_recep'] ?></td>
                                            <td><?php echo $filas['fecha_recep'] ?></td>
                                            <td><?php echo $filas['movimient_recep'] ?></td>
                                            <td><?php echo $filas['documento_clie_recep'] ?></td>
                                            <td><?php echo $filas['modifica_recp'] ?></td>
                                            <td><?php echo $filas['transport_recep'] ?></td>
                                            <td><?php echo $filas['conductor_recep'] ?></td>
                                            <td><?php echo $filas['vehiculo_recp'] ?></td>
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
                var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
                var f = new Date();
                document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

            </script>
        </footer>
        <div>
            <?php require "aplicaciones/html/footer"  ?>;                            

        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dataTables').dataTable({
                    "order": [[0, 'asc']],
                    "lengthMenu": [[10], [10]],
                });

            }); //fin ready
            
            $('#ejecuta').on('click', function () {
                    var numClie = document.getElementById('cliBusca').value;
                    document.location = 'modificacionesRecepciones.php?clibus=' + numClie;

            });
            
            function modificaExcel() {
                var numClie = <?php echo $_GET['clibus'] ?>;
                document.location.href = ('modificaRecepcionesExcel.php?clibus=' + numClie);
            }
            
        </script>
    </body>

    </html>
