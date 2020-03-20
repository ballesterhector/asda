<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelectTodos('".$_GET['clibus']."')");
	$clientes = $data[0]['nombre_cli'];

    
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
                    <h4 class="titulos">Modificaciones de las etiquetas</h4>
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
                    <label for="" class="control-label">Del</label>
                    <input type="text" class="form-control" style="width:90px;" id="dels" value="<?php echo $_GET['del'] ?>">
                    <label for="" class="control-label">Al</label>
                    <input type="text" class="form-control" style="width:90px;" id="als" value="<?php echo $_GET['al'] ?>">
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
                            <th class="text-center">Etiqueta</th>
                            <th class="text-center">Ubicación</th>
                            <th class="text-center">Almacen</th>
                            <th class="text-center">Motivo</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Lote</th>
                            <th class="text-center">Vencimiento</th>
                            <th class="text-center">Modificador</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL etiquetasModificaciones('".$_GET['clibus']."','".$_GET['del']."','".$_GET['al']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['etiquetaEtiqueta'] ?></td>
                                            <td><?php echo $filas['ubicaEtiqueta'] ?></td>
                                            <td><?php echo $filas['almacenEtiqueta'] ?></td>
                                            <td style="text-transform: lowercase;"><?php echo $filas['motivoEtiqueta'] ?></td>
                                            <td style="text-transform: lowercase;"><?php echo $filas['codigoEtiqueta'] ?></td>
                                            <td><?php echo $filas['productoEtiqueta'] ?></td>
                                            <td><?php echo $filas['loteEtiqueta'] ?></td>
                                            <td><?php echo $filas['venceEtiqueta'] ?></td>
                                            <td><?php echo $filas['modificarEtiqueta'] ?></td>
                                            <td><?php echo $filas['movimientoData'] ?></td>
                                            <td><?php echo $filas['fechamodifica'] ?></td>
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
                    "lengthMenu": [[10], [10]],
                    "columnDefs": [ { "width": "7%", "targets": 10 } ] 
                });

            }); //fin ready
            
            $('#ejecuta').on('click', function () {
                    var dels = document.getElementById('dels').value;
                    var als = document.getElementById('als').value;
                    var numClie = document.getElementById('cliBusca').value;
                    document.location = 'modificacionesEtiquetas.php?clibus=' + numClie + '&del='+ dels + '&al=' + als;

            });
            
            function modificaExcel() {
                var dels = document.getElementById('dels').value;
                var als = document.getElementById('als').value;
                var numClie = <?php echo $_GET['clibus'] ?>;
                document.location.href = ('modificaEtiquetaExcel.php?clibus=' + numClie + '&del='+ dels + '&al=' + als);
            }
            
        </script>
    </body>

    </html>
