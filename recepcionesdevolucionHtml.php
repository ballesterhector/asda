<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL recepcionesSelect('".$_GET['numRecep']."')");

    $user = $data[0]['usuario_recep'];
    $observ = $data[0]['observac_recep'];
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
                    <label for="" class="control-label">ACTA DE DEVOLUCIÓN</label>
                    <u><?php echo 'Número ' .str_pad($data[0]['num_recep'], 9, "0", STR_PAD_LEFT) ?></u>
                </div>
                <cnavas><img id="barcode2" /></cnavas>
            </div>
        </header>
        <div id='main'>
            <article class="ladoA">
                <div><b>Cliente </b><?php echo $data[0]['clienteName_recep']  ?></div>
                <div><b>Fecha </b><?php echo $data[0]['fecha_recep']  ?></div>
                <div><b>Movimiento </b><?php echo $data[0]['movimient_recep']  ?></div>
                <div><b>Elaborado por </b><?php echo $data[0]['usuario_recep']  ?></div>
                <div><b>Documento cliente </b><?php echo $data[0]['documento_clie_recep']  ?></div>
                <div><b>Valido contabilidad  </b><?php echo $data[0]['valido_contabili']  ?></div>
                <div><b>Paletas recibidas </b><?php echo $data[0]['paletas_ingreso']  ?></div>
            </article>
            <div class="ladoB">
                <div><b>Transporte </b><?php echo $data[0]['transport_recep']  ?></div>
                <div><b>Conductor </b><?php echo $data[0]['conductor_recep']  ?></div>
                <div><b>Vehículo </b> <?php echo $data[0]['vehiculo_recp']  ?><b>Trailer</b><?php echo $data[0]['trailer_recp']?></div>
                <div><b>Contenedor </b><?php echo $data[0]['vehiculo_contenedor_recp']  ?></div>
                <div><b>Llegada </b>  <?php echo date("d-m-Y",strtotime($data[0]['vehiculo_llegada_recp']))?> <b>Hora </b><?php echo $data[0]['vehiculohora_llegada_recp']?></div>
                <div><b>Peso </b>     <?php echo $data[0]['kilos_transportados']  ?></div>
                <div><b>Temperatura </b><?php echo $data[0]['temperatura_rece']  ?></div>
                <div><b>Precintos </b><?php echo $data[0]['vehiculo_precinto_recp']  ?></div>
            </div>
        </div>
        <div class="data">
            <table border=1 style="border-collapse: collapse" width="100%">
                <thead>
                    <tr class="bg-success">
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Lote</td>
                        <th>Vencimiento</th>
                        <th>Empaques</th>
                        <th>Unidades</th>
                        <th>Kilos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL etiquetasDevolucion('".$_GET['numRecep']."')");
                        $totalE=0;
                        $total=0;
                        $totalK=0;
                        foreach ($data as $filas) { 
                           	$totalE=$totalE+$filas['empaques'];
                            $total=$total+$filas['unidades'];
				            $totalK=$totalK+$filas['kilos'];
                    ?>
                        <tr>
                            <td><?php echo $filas['codigoEtiqueta'] ?></td>
                            <td><?php echo $filas['productoEtiqueta'] ?></td>
                            <td><?php echo $filas['loteEtiqueta'] ?></td>
                            <td align='center'><?php echo $filas['venceEtiqueta'] ?></td>
                            <td align='right' class="unidades"><?php echo $filas['empaques'] ?></td>
                            <td align='right' class="unidades"><?php echo $filas['unidades'] ?></td>
                            <td align='right' class="unidades"><?php echo $filas['kilos'] ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan=4 align=right><b>Totales</b></td>
                            <td align=right><?php echo number_format($totalE,0) ?></td>
                            <td align=right><?php echo number_format($total,2) ?></td>
                            <td align=right><?php echo number_format($totalK,2) ?></td>
                        </tr>
                </tbody>
            </table>
        </div>
         <div class="cesta" align="right">
            <table border=1 style="border-collapse: collapse; width:600px" class="tablacesta">
                <thead>
                    <tr class="bg-success">
                        <th>Código</th>
					    <th>Producto</th>
                        <th>Unidades</th>
					    <th>Kilos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL etiquetasCestas('".$_GET['numRecep']."')");
                        $totalcest=0;
			            $totalKcest=0;
                        foreach ($data as $filas) { 
                           	$totalcest=$totalcest+$filas['cestas'];
                            $totalKcest=$totalKcest+$filas['kilos'];
                        ?>
                        <tr>
                            <td><?php echo $filas['codigoEtiqueta'] ?></td>
                            <td><?php echo $filas['productoEtiqueta'] ?></td>
                            <td align='right' class="unidades"><?php echo $filas['cestas'] ?></td>
                            <td align='right' class="unidades"><?php echo number_format($filas['kilos'],2) ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan=2 align=right><b>Total cesta</b></td>
                            <td align=right><?php echo number_format($totalcest,0) ?></td>
                            <td align=right><?php echo number_format($totalKcest,2) ?></td>
                        </tr>
                        <tr style="height: 20px">
                            <td colspan=2 align=right><b>Total recepción</b></td>
                            <td align=right><?php echo number_format($total+$totalcest,0) ?></td>
                            <td align=right><?php echo number_format($totalK+$totalKcest,2) ?></td>
                        </tr>
                </tbody>
            </table>
        </div>
        
        <div class="firma">  
            <div id="capa1"> 
                <b>Elaborado por:<?php echo $user ?> Chequado por__________________ Supervisado por:__________________</b><br/><br><br><br>
                <b>Firmada conductor____________________________________</b><br><br>
                <h3>Observaciones </h3><span><?php echo $observ ?></span>
            </div>

            <div id="capa2"> 
                <img src="aplicaciones/imagenes/logo.png" width="80" height="85" style="filter:alpha(opacity=38);-moz-opacity:.38;opacity:.38"> 
            </div>
        </div>
        <div class="fixed letras"> Acta de recepción <?php echo $_GET['numRecep'] ?>&nbsp;&nbsp; Emitido el <?php echo date('d/m/Y h:i:s') ?></div>
	
        <footer class="dat">

        </footer>
        <div>
            <?php  require "aplicaciones/html/footer" ?>                    

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
