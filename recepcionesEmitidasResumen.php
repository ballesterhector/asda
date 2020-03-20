<?php
	require 'aplicaciones/php/session_start.php';
	
    require 'conectarBD/conectarASDA.php';
    
    if($_GET['del']==0){
        $fedel = date('Y-m-d',strtotime("first day of this month"));
        $feal =  date('Y-m-d',strtotime("last day of this month")); 
    }else{
        $fedel = $_GET['del'];
        $feal = $_GET['al'];
    }

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
                    <h3 class="titulos">Data recepciones emitidas resumen</h3>
                </div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/consultaRecepcion.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                <!--<a href="javascript: onclick(inventariopdf())"><i class="fas fa-file-pdf fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte"></i></a>-->
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
                            <th class="text-center">Movimiento</th>
                            <th class="text-center">recp</th>
                            <th class="text-center">Recepción <br><sub>(Link)</sub></th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Clien</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Empaques</th>
                            <th class="text-center">Unidades</th>
                            <th class="text-center">Kilos</th>
                            <th class="text-center">Etiquetas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL recepcionesPorPeriodoResumen('".$fedel."','".$feal."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <?php if ($filas['num_recep']<>99999999) {?>
                                        <tr>
                                            <td><?php echo $filas['movimient_recep'] ?></td>
                                            <td><?php echo $filas['num_recep'] ?></td>
                                            <td><a href="javascript:documento(<?php echo $filas['num_recep']  ?>)"><?php echo $filas['num_recep'] ?></a></td>
                                            <td><?php echo $filas['fecha_recep'] ?></td>
                                            <td><?php echo $filas['clienteName_recep'] ?></td>
                                            <td><?php echo $filas['clienteName_recep'] ?></td>
                                            <td align="right"><?php echo $filas['empaques']+0 ?></td>
                                            <td align="right"><?php echo $filas['unidades'] ?></td>
                                            <td align="right"><?php echo $filas['kilos'] ?></td>
                                            <td class="bg-warning" align="right"><?php echo $filas['etiquetas'] ?></td>
                                        </tr>
                                       
                                        <?php }else{ ?>
                                        <tr>
                                            <td class="bg-info"><?php echo $filas['movimient_recep'] ?></td>
                                            <td class="bg-info"><?php echo $filas['num_recep'] ?></td>
                                           
                                            <?php if ($filas['num_recep']<>99999999) {?>   
                                                <td class="bg-info"><a href="javascript:documento(<?php echo $filas['movimient_recep']  ?>)"><?php echo $filas['num_recep'] ?></a></td>
                                            <?php }else{ ?>
                                                <td class="bg-info"><?php echo $filas['movimient_recep'] ?></td>
                                            <?php } ?>   

                                            <td class="bg-info"><?php echo $filas['fecha_recep'] ?></td>
                                            <td><?php echo $filas['clienteName_recep'] ?></td>
                                            <td class="bg-info" style="color:red;font-size:12px"><?php echo $filas['clienteName_recep'] ?></td>
                                            <td class="bg-info" align="right"><?php echo $filas['empaques']+0 ?></td>
                                            <td class="bg-info" align="right"><?php echo $filas['unidades'] ?></td>
                                            <td class="bg-info" align="right"><?php echo $filas['kilos'] ?></td>
                                            <td class="bg-info" align="right"><?php echo $filas['etiquetas'] ?></td>
                                        </tr>
                                    <?php } ?>
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
            <?php require "aplicaciones/html/footer" ?>
    </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dataTables').dataTable({
                    "order": [[4, 'asc'],[1, 'asc']],
                    "lengthMenu": [[15], [15]],
                    "columnDefs": [
                                    {
                                        "targets": [ 1 ],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    {
                                        "targets": [ 4 ],
                                        "visible": false
                                    }
                                ]
                });

            }); //fin ready

            $('#ejecuta').on('click', function () {
                var dels = document.getElementById('dels').value;
                var als = document.getElementById('als').value;
                document.location = 'recepcionesEmitidasResumen.php?del='+ dels + '&al=' + als;
            });

            function documento(docu){
                window.open("recepcionesHtml.php?numRecep=" + docu, "Reporte")
            }
            
            

        </script>
    </body>

    </html>
