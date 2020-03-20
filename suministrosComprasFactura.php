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
                    <h3 class="titulos">Compra de insumos, ingreso de facturas</h3>
                </div>
                <div id="respuesta" class="respuesta"></div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:../aplicaciones/ayudas/suministrosCompras.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
                </div>
            </div>
        </header>
        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Factura</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Proveedor</th>
                             <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL suministrosFactura_Select()");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['factura'] ?></td>
                                            <td><?php echo $filas['fechafactura'] ?></td>
                                            <td><?php echo $filas['proveedor'] ?></td>
                                            <td class="text-center">
                                                <a href='javascript:insumos(<?php echo $filas['numfactura'] ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado'</a>
                                            </td>
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
            <div class="ladoA">
                <form action="" id="formulario" class="" onsubmit="return facturas();">
                    <input type="hidden" name="proceso" value="factu">
                   
                    <div class="comprasB">   
                        <label for="" class="">Factura
                            <input type="text" class="form-control tamano" name="factura" required autocomplete="off">
                        </label>
                        <label for="" class="">Fecha
                            <input type="date" class="form-control tamano" name="fecha" required autocomplete="off">
                        </label>
                        <label for="" class="">Proveedor
                            <input type="text" class="form-control comprasTamano tamano" name="proveedor" style="width:100%" required >
                        </label>
                    </div>
                  
                    <div class="comprasE">
                        <button type="submit" class="rubrobtn" id="reg" style="width:80px"><i class="fas fa-download fa-2x"></i></button>
                    </div> 
                </form>
            </div>
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
            <script src="../aplicaciones/js/suministros.js"></script>
        </div>
    </body>

    </html>
