<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL transferenciasSelectReporte('".$_GET['trasfe']."')");

    $user = $data[0]['usuarioTransfe'];
    $observ = $data[0]['motivoTransfe'];

    
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
                    <label for="" class="control-label">ACTA DE TRANSFERENCIA</label>
                    <u><?php echo 'Número ' .str_pad($data[0]['numeroTransfe'], 9, "0", STR_PAD_LEFT) ?></u>
                </div>
                <img id="barcode2" />
            </div>
        </header>
        <div id='main'>
            <article class="ladoA">
                <div><b>Cliente sale </b><?php echo $data[0]['idclienteTransfe'],'-' ,$data[0]['clienteTransfe']  ?></div>
                <div><b>Cliente llega </b><?php echo $data[0]['idclienteLlega'],'-' ,$data[0]['clienteLlega']  ?></div>
                <div><b>Fecha </b><?php echo $data[0]['fechaTrasfe']  ?></div>
                <div><b>Movimiento </b><?php echo $data[0]['tipoTransfe']  ?></div>
                <div><b>Elaborado por </b><?php echo $data[0]['usuarioTransfe']  ?></div>
                <div><b>Motivo </b><?php echo $data[0]['motivoTransfe']  ?></div>
            </article>
            
        </div>
        <div class="data">
            <table border=1 style="border-collapse: collapse" class="tabla1" width="100%">
                <thead>
                    <tr class="bg-success">
                        <th>Cliente</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Lote</td>
                        <th>Vencimiento</th>
                        <th>Movimiento</th>
                        <th>Etiquetas</td>
                        <th>Almacen</td>
                        <th>Motivo</td>
                        <th>Empaques</th>
                        <th>Unidades</th>
                        <th>Kilos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL transferenciasDataSelect('".$_GET['trasfe']."')");
                        $totalE=0;
                        $total=0;
                        $totalK=0;
                        foreach ($data as $filas) { 
                           	$totalE=$totalE+$filas['empaquesEvol'];
                            $total=$total+$filas['unidades'];
				            $totalK=$totalK+$filas['kilos'];
                    ?>
                        <tr>
                            <td><?php echo $filas['idcliEvol'] ?></td>
                            <td><?php echo $filas['codigoEtiqueta'] ?></td>
                            <td class="productos"><?php echo $filas['productoEtiqueta'] ?></td>
                            <td><?php echo $filas['loteEtiqueta'] ?></td>
                            <td align='center'><?php echo $filas['venceEtiqueta'] ?></td>
                            <td align=''><?php echo $filas['movimientoEvol'] ?></td>
                            <td align='center'><?php echo $filas['etiquetaEvol'] ?></td>
                            <td align=''><?php echo $filas['almacenEtiqueta'] ?></td>
                            <td style="text-transform: lowercase"><?php echo $filas['motivoEtiqueta'] ?></td>
                            
                            <td align='right' class="unidades"><?php echo $filas['empaquesEvol'] ?></td>
                            <td align='right' class="unidades"><?php echo number_format($filas['unidades'],0) ?></td>
                            <td align='right' class="unidades"><?php echo $filas['kilos'] ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="9" align=right><b>Totales</b></td>
                            <td align=right><?php echo number_format($totalE,0) ?></td>
                            <td align=right><?php echo number_format($total,0) ?></td>
                            <td align=right><?php echo number_format($totalK,2) ?></td>
                        </tr>
                </tbody>
            </table>
        </div>
                
        <div class="firma">  
            <div id="capa1"> 
                <b>Elaborado por:<?php echo $user ?> Chequado por__________________ Supervisado por:__________________</b><br/>
                <h3>Observaciones </h3><span><?php echo $observ ?></span>
            </div>

            <div id="capa2"> 
                <img src="aplicaciones/imagenes/logo.png" width="80" height="85" style="filter:alpha(opacity=38);-moz-opacity:.38;opacity:.38"> 
            </div>
        </div>
        <div class="fixed letras"> Acta de transferencia <?php echo $_GET['trasfe'] ?>&nbsp;&nbsp; Emitida el <?php echo date('d/m/Y h:i:s') ?></div>
	
        <footer class="dat">

        </footer>
        <div>
            <script src="aplicaciones/js/jquery-1.11.1.min.js"></script>
            <script>
                JsBarcode("#barcode2", "<?php echo str_pad($_GET['trasfe'], 7, "0", STR_PAD_LEFT) ?>", {
                    format: "CODE39",
                    displayValue: true,
                    fontSize: 24,
                    height: 50
                });

            </script>
        </div>
    </body>

    </html>
