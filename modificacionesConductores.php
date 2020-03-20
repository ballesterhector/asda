<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
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
                    <h4 class="titulos">Modificaciones a conductores</h4>
                </div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/modificacionesProcesos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                </div>
                <div class="fechas">
                    <a href="javascript: onclick(modificaExcel())"><i class="fas fa-file-excel fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Archivo excel"></i></a>
                </div>
            </div>
        </header>

        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables" style>
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Modificado por</th>
                            <th class="text-center">Conductor</th>
                            <th class="text-center">Cedula</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL conductoresModificaciones()");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['fechacontrol'] ?></td>
                                            <td><?php echo $filas['conductor_Modificado'] ?></td>
                                            <td><?php echo $filas['conductor'] ?></td>
                                            <td><?php echo $filas['cedula_cond'] ?></td>
                                            <td><?php echo $filas['condestado'] ?></td>
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
                    "order": [[2, 'asc']],
                    "lengthMenu": [[10], [10]]
                });

            }); //fin ready
            
            function modificaExcel() {
                document.location.href = ('modificaConductoresExcel.php');
            }
            
        </script>
    </body>

    </html>
