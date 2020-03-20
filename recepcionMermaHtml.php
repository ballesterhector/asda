<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL mermaCarculo('".$_GET['numcli']."','".$_GET['del']."','".$_GET['al']."')");

    
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
        <link rel="stylesheet" type="text/css" href="aplicaciones/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="aplicaciones/css/pdf.css">
        <script src="aplicaciones/js/jsBarcode.all.min.js"></script>
    </head>

    <body>
        <header>
            <div class="tablaPdf">
                <img src="aplicaciones/imagenes/logo.png" width="105" height="105">
                <div class="acta">
                    <label for="" class="control-label">RELACIÓN DE MERMAS EN PRODUCTOS</label>
                </div>
                <cnavas><img id="barcode2" /></cnavas>
            </div>
        </header>
        <div id='main'>
            <article class="ladoA">
                <div><b>Cliente </b><?php echo $data[0]['nombre_cli']  ?></div>
                 <div><b>del </b>  <?php echo date("d-m-Y",strtotime($_GET['del']))?></div>
                <div><b>al </b>  <?php echo date("d-m-Y",strtotime($_GET['al']))?></div>
            </article>
        </div>
        <div class="data">
            <table border=1 style="border-collapse: collapse" width="100%">
                <thead>
                    <tr>
                        <th colspan="6">DATOS DE LA RECEPCIÓN</th>
                        <th colspan="3">KILOS</th>
                    </tr>
                    <tr class="bg-success">
                        <th>Movimiento</th>
                        <th>Documento</th>
                        <th>Recibido</td>
                        <th>Transporte</th>
                        <th>Conductor</th>
                        <th>Vehículo</th>
                        <th>transportados</th>
                        <th>recibidos</th>
                        <th>Diferencia</th>
                        <th>Merma</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL mermaCarculo('".$_GET['numcli']."','".$_GET['del']."','".$_GET['al']."')");
                        foreach ($data as $filas) { 
                    ?>
                        <?php if ($filas['movimientoEvol']=='Totales') {?> 
                            <tr style="background:#DFDBDA">
                                <td><?php echo $filas['movimientoEvol'] ?></td>
                                <td align="center"><?php echo $filas['documentoEvol'] ?></td>
                                <td align="center"><?php echo $filas['recibido'] ?></td>
                                <td><?php echo $filas['transport_recep'] ?></td>
                                <td><?php echo $filas['conductor_recep'] ?></td>
                                <td align='center'><?php echo $filas['vehiculo_recp'] ?></td>
                                <td align='right' class="unidades"><?php echo number_format($filas['kilos_transportados'],2) ?></td>
                                <td align='right' class="unidades"><?php echo number_format($filas['kilosrecibidos'],2) ?></td>
                                <td align='right' class="unidades"><?php echo number_format($filas['diferencia'],2) ?></td>
                                <td align='right' class="unidades"><?php echo $filas['merma'] ?></td>
                            </tr>
                        <?php } else {?>
                            <tr>
                                <td><?php echo $filas['movimientoEvol'] ?></td>
                                <td align="center"><?php echo $filas['documentoEvol'] ?></td>
                                <td align="center"><?php echo $filas['recibido'] ?></td>
                                <td><?php echo $filas['transport_recep'] ?></td>
                                <td><?php echo $filas['conductor_recep'] ?></td>
                                <td align='center'><?php echo $filas['vehiculo_recp'] ?></td>
                                <td align='right' class="unidades"><?php echo number_format($filas['kilos_transportados'],2) ?></td>
                                <td align='right' class="unidades"><?php echo number_format($filas['kilosrecibidos'],2) ?></td>
                                <td align='right' class="unidades"><?php echo number_format($filas['diferencia'],2) ?></td>
                                <td align='right' class="unidades"><?php echo $filas['merma'] ?></td>
                            </tr>    
                        <?php } ?>    
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        
        
        <footer class="dat">

        </footer>
        <div>
            <?php require "aplicaciones/html/footer" ?>
            
            <script>
                JsBarcode("#barcode2", "<?php echo str_pad($_GET['numRecep'], 7, "0", STR_PAD_LEFT) ?>", {
                    format: "CODE39",
                    displayValue: true,
                    fontSize: 24,
                    height: 50
                });

            </script>
        </div>
    </body>

    </html>
