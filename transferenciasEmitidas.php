<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	
    if($_GET['del']==0){
        $fedel = date('Y-m-d');
        $feal = date('Y-m-d');
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
                    <h3 class="titulos">Data transferencias emitidas</h3>
                </div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/consultaTransferencia.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
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
                            <th class="text-center">Transferencia <br><sub>(Link)</sub></th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Cliente sale</th>
                            <th class="text-center">Cliente llega</th>
                            <th class="text-center">Movimiento</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Empaques</th>
                            <th class="text-center">Unidades</th>
                            <th class="text-center">Kilos</th>
                            <th class="text-center">Condición</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL transferenciasPorPeriodo('".$fedel."','".$feal."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <?php if ($filas['condicion']=='Confirmada') {?>
                                        <tr>
                                            <td><a href="javascript:documento(<?php echo $filas['pri']  ?>,<?php echo $filas['transfe'] ?>)"><?php echo $filas['transfe'] ?></a></td>
                                            <td><?php echo $filas['fechaDocumentoEvol'] ?></td>
                                            <td><?php echo $filas['usuarioTransfe'] ?></td>
                                            <td><?php echo $filas['clienteTransfe'] ?></td>
                                            <td><?php echo $filas['clienteLlega'] ?></td>
                                            <td><?php echo $filas['movimientoEvol'] ?></td>
                                            <td><?php echo $filas['codigoEtiqueta'] ?></td>
                                            <td><?php echo $filas['productoEtiqueta'] ?></td>
                                            <td align="right"><?php echo $filas['empaques']+0 ?></td>
                                            <td align="right"><?php echo $filas['unidades'] ?></td>
                                            <td align="right"><?php echo $filas['kilos'] ?></td>
                                            <td><?php echo $filas['condicion'] ?></td>
                                        </tr>
                                        <?php }else{ ?>
                                        <tr>
                                            <td class="bg-danger"><a href="javascript:documento(<?php echo $filas['pri']  ?>,<?php echo $filas['transfe'] ?>)"><?php echo $filas['transfe'] ?></a></td>
                                            <td class="bg-danger"><?php echo $filas['fechaDocumentoEvol'] ?></td>
                                            <td class="bg-danger"><?php echo $filas['usuarioTransfe'] ?></td>
                                            <td class="bg-danger"><?php echo $filas['clienteTransfe'] ?></td>
                                            <td class="bg-danger"><?php echo $filas['clienteLlega'] ?></td>
                                            <td class="bg-danger"><?php echo $filas['movimientoEvol'] ?></td>
                                            <td class="bg-danger"><?php echo $filas['codigoEtiqueta'] ?></td>
                                            <td class="bg-danger"><?php echo $filas['codigoEtiqueta'] ?></td>
                                            <td class="bg-danger"><?php echo $filas['productoEtiqueta'] ?></td>
                                            <td class="bg-danger" align="right"><?php echo $filas['empaques']+0 ?></td>
                                            <td class="bg-danger" align="right"><?php echo $filas['unidades'] ?></td>
                                            <td class="bg-danger" align="right"><?php echo $filas['kilos'] ?></td>
                                            <td class="bg-danger"><?php echo $filas['condicion'] ?></td>
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
                    "order": [[0, 'asc']],
                    "lengthMenu": [[9], [9]],
                });

            }); //fin ready

            $('#ejecuta').on('click', function () {
                var dels = document.getElementById('dels').value;
                var als = document.getElementById('als').value;
                document.location = 'transferenciasEmitidas.php?del=' + dels + '&al=' + als;
            });

            function inventarioExcel() {
            var dat_Clien = idclie;
            document.location.href = ("inventarioDisponibleLoteExcel.php?id_cliente=" + dat_Clien);
        }

        function documento(movi,docu){
            if(movi==3){
                window.open("transferenciasClientesHtml.php?trasfe=" + docu, "Reporte");
             }else{
                window.open("transferenciasHtml.php?trasfe=" + docu, "Reporte"); 
             }
        }    
        </script>
    </body>

    </html>
