<?php
	require '../aplicaciones/php/session_start.php';
	
	require '../conectarBD/conectarASDA.php';

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
        <link rel="stylesheet" type="text/css" href="../aplicaciones/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../aplicaciones/css/bootstrap-submenu.min.css">
        <link rel="stylesheet" type="text/css" href="../aplicaciones/font-awesome/css/fontawesome-all.css">
        <link rel="stylesheet" type="text/css" href="../aplicaciones/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="../aplicaciones/css/sweetalert.css">
        <link rel="stylesheet" type="text/css" href="../aplicaciones/css/estilosSuministros.css">
    </head>

    <body>
        <header>
            <input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
            <input type="hidden" value="<?php echo $nomClie ?>" id="nCliente">
            <div class="menu">
                <div class="logo">
                    <a href="#"><img src="../aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
                </div>
                <nav class="enlaces" id="enlaces">
                    <?php include "../aplicaciones/nav/menuarribaSuministros.html" ?>
                </nav>
            </div>
            <div class="enlinea">
                <div class="titulo">
                    <h3 class="titulos">Inventario de insumos resumen</h3>
                </div>
                <div id="respuesta" class="respuesta"></div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:../aplicaciones/ayudas/SuministrosCompras.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
                    <a href='javascript: onclick(excel(<?php echo $nomClie ?>))'><i class="fas fa-file-excel fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte excel"></i></a>
                </div>
            </div>
        </header>
        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Código</th>
                            <th class="text-center">Insumo</th>
                            <th class="text-center">Color</th>
                            <th class="text-center">Uso</th>
                            <th class="text-center">Tamaño</th>
                            <th class="text-center">Unidades</th>
                            <th class="text-center">Costo</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align:right">Total:</th>
                            <th class="dt-right"></th>
                            <th class="dt-right"></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL suministros_InvetarioResumen()");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['codigo'] ?></td>
                                            <td><?php echo $filas['insumos'] ?></td>
                                            <td><?php echo $filas['color'] ?></td>
                                            <td><?php echo $filas['uso'] ?></td>
                                            <td><?php echo $filas['tamano'] ?></td>
                                            <td align="right"><?php echo $filas['compra'] ?></td>
                                            <td align="right"><?php echo $filas['costo'] ?></td>
                                        </tr>
                                        
                                <?php } ?>
                            <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
            </article>
            <nav>
                <?php include "../aplicaciones/nav/menuizquierdaSuministros.html" ?>
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
            <script src="../plantillas/bootstrap/js/jquery-1.11.1.min.js"></script>
            <script src="../plantillas/bootstrap/js/bootstrap.min.js"></script>
            <script src="../aplicaciones/js/bootstrap-submenu.min.js"></script>
            <script src="../plantillas/bootstrap/js/jquery.dataTables.min.js"></script>
            <script src="../aplicaciones/js/sweetalert.min.js"></script>
            <script src="../aplicaciones/js/jsConstantes.js"></script>
            <script src="../aplicaciones/js/suministrosInventarioResumen.js"></script>
        </div>
    </body>

    </html>
