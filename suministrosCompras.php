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
                    <h3 class="titulos">Compra de insumos</h3>
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
                            <th class="text-center">Unidades</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Costo</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="2" style="text-align:right">Total:</th>
                            <th class="dt-right"></th>
                            <th class="dt-right"></th>
                            <th class="dt-right"></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL suministros_CompradasFactura('".$_GET['clibus']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['codigo'] ?></td>
                                            <td><?php echo $filas['insumos'] ?></td>
                                            <td align="right"><?php echo $filas['compradas'] ?></td>
                                            <td align="right"><?php echo $filas['precio'] ?></td>
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
           
            <div class="ladoA">
               <form action="" id="formulario" class="compras" onsubmit="return compra();">
                    <input type="hidden" name="proceso" value="compra">
                    <input type="hidden" name="nufactu" value="<?php echo $_GET['clibus'] ?>">
                    <div class="comprasA">
                        <label for="" class="">Insumo
                            <select class="form-control" name="insumo" id="insumo" autofocus style="width:510px" required>
                                <option value=""></option>                                   
                                <?php
                                    $obj = new conectarDB();
                                    $data = $obj->consultar("CALL suministrosSelect()");
                                    foreach($data as $key){
                                        echo "<option value='".$key['codigo']."'>".$key['insumo']."</option>";
                                    }
                                ?>
                            </select>
                        </label>
                    </div>
                    <div class="comprasB">   
                        <label for="" class="">Marca
                            <input type="text" class="form-control tamano" name="marca" autocomplete="off">
                        </label>
                        <label for="" class="">Modelo
                            <input type="text" class="form-control tamano" name="modelo">
                        </label>
                        <label for="" class="">Color
                            <input type="text" class="form-control comprasTamano tamano" name="color">
                        </label>
                        <label for="" class="">Almacen
                            <input type="text" class="form-control tamano" name="almacen">
                        </label> 
                    </div>
                    <div class="comprasC"> 
                        <label for="" class="">Presentación
                            <select class="form-control tamano2" name="presenta" required="require" style="padding-left:2px">
                                <option value="Unidades">Unidades</option>
                                <?php
                                    $obj= new conectarDB();
                                    $data= $obj->subconsulta("CALL suministrospresentacion()");
                                    foreach ($data as $key) {
                                        echo "<option value='".$key['unidadmedias']."'>".$key['unidadmedias']."</option>";
                                    }
                                ?>
                            </select>
                        </label>
                        <label for="" class="">Uso
                           <select class="form-control tamano2" name="uso" required="require">
                               <option value=""></option>
                                <?php
                                    $obj= new conectarDB();
                                    $data= $obj->subconsulta("CALL suministros_uso()");
                                    foreach ($data as $key) {
                                        echo "<option value='".$key['uso']."'>".$key['uso']."</option>";
                                    }
                                ?>
                           </select>
                        </label>        
                        <label for="" class="">Tamaño
                            <input type="text" class="form-control tamano2" name="tamano">
                        </label>
                        <label for="" class="">Capacidad
                            <input type="text" class="form-control tamano2" value="0" name="capacidad">
                        </label>
                    </div>
                    <div class="comprasD"> 
                        <label for="" class="">Medida
                            <select class="form-control tamano2"  name="medida" required="require">
                               <option value=""></option>
                                <?php
                                    $obj= new conectarDB();
                                    $data= $obj->subconsulta("CALL suministrosMedidas()");
                                    foreach ($data as $key) {
                                        echo "<option value='".$key['medidas']."'>".$key['medidas']."</option>";
                                    }
                                ?>
                            </select>    
                        </label>
                        <label for="" class="">Compradas
                            <input type="text" class="form-control tamano2" name="compradas" required="require">
                        </label>
                        <label for="" class="">Precio
                            <input type="text" class="form-control tamano2" name="precio" required="require">
                        </label>
                    </div>
                    <div class="comprasE">
                        <button type="submit" class="rubrobtn" id="reg"><i class="fas fa-download fa-2x"></i></button>
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
