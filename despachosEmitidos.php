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
                    <h4 class="titulos">Data despachos emitidos</h4>
                </div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/consultaDespachos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                	<a href="javascript: onclick(emitidas())"><i class="fas fa-file-pdf fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte"></i></a>
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
                            <th class="text-center">Despacho <br><sub>(Link)</sub></th>
                            <th class="text-center">Fecha</th>
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
	                        $data= $obj->subconsulta("CALL despachosPorPeriodoCliene('".$fedel."','".$feal."','".$_GET['clibus']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <?php if ($filas['condicion']=='Confirmada') {?>
                                        <tr>
                                            <td><a href="javascript:documento(<?php echo $filas['num_retiro']  ?>)"><?php echo $filas['num_retiro'] ?></a></td>
                                            <td><?php echo $filas['fecha_retiro'] ?></td>
                                            <td><?php echo $filas['movimient_retir'] ?></td>
                                            <td><?php echo $filas['codigoEtiqueta'] ?></td>
                                            <td><?php echo $filas['productoEtiqueta'] ?></td>
                                            <td align="right"><?php echo $filas['empaques']+0 ?></td>
                                            <td align="right"><?php echo $filas['unidades'] ?></td>
                                            <td align="right"><?php echo $filas['kilos'] ?></td>
                                            <td><?php echo $filas['condicion'] ?></td>
                                        </tr>
                                        <?php }else{ ?>
                                        <tr>
                                            <td class="bg-danger"><a href="javascript:documento(<?php echo $filas['num_retiro']  ?>)"><?php echo $filas['num_retiro'] ?></a></td>
                                            <td class="bg-danger"><?php echo $filas['fecha_retiro'] ?></td>
                                            <td class="bg-danger"><?php echo $filas['movimient_retir'] ?></td>
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
            <script src="aplicaciones/js/jquery-1.11.1.min.js"></script>
            <script src="aplicaciones/js/bootstrap.min.js"></script>
            <script src="aplicaciones/js/bootstrap-submenu.min.js"></script>
            <script src="aplicaciones/js/jquery.dataTables.min.js"></script>
            <script src="aplicaciones/js/sweetalert.min.js"></script>
            <script src="aplicaciones/js/jsConstantes.js"></script>
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
                document.location = 'despachosEmitidos.php?clibus=' + numClie + "&del=" + 0 + "&al=" + 0  ;
            });

            $('#ejecuta').on('click', function () {
                var dels = document.getElementById('dels').value;
                var als = document.getElementById('als').value;
                var numClie = document.getElementById('cli2').value;
                if(numClie>0){
                    document.location = 'despachosEmitidos.php?clibus=' + numClie + '&del='+ dels + '&al=' + als;
                }else{
                    swal("Data incompleta!", "Debe ingresar el cliente", "error");
                }
                
            });

            function documento(docu){
                window.open("despachosHtml.php?num=" + docu, "Reporte")
            }
            
            function inventarioExcel() {
            var dat_Clien = idclie;
            document.location.href = ("inventarioDisponibleLoteExcel.php?id_cliente=" + dat_Clien);
        }

        function emitidas() {
            var dels = document.getElementById('dels').value;
            var als = document.getElementById('als').value;
            var numClie = <?php echo $_GET['clibus'] ?>;
            window.open('despachosEmitidosClienteHtml.php?id_cliente=' + numClie + '&del='+ dels + '&al=' + als, 'reporte');
        }
        </script>
    </body>

    </html>
