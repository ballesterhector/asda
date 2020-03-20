<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
     $obj= new conectarDB();
    $data= $obj->subconsulta("CALL despachosCestasPdftot('".$_GET['num']."')");
    $totcestasUni = $data[0]['cestas'];
    $totcestasKil = $data[0]['kilos'];

    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL despachosEncabezado('".$_GET['num']."')");

    $user = $data[0]['usuario_retiro'];
    $chofer = $data[0]['conductor'];
    $observ = $data[0]['observa_retir'];
    $movi = $data[0]['movimient_retir'];

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
                    <label for="" class="control-label">PASE DE SALIDA</label>
                    <u><?php echo 'Número ' .str_pad($data[0]['num_retiro'], 9, "0", STR_PAD_LEFT) ?></u>
                </div>
                <img id="barcode" />
            </div>
        </header>
        <div id='main'>
            <article class="ladoA">
               <input type="hidden" value="<?php echo $movi ?>" id="movis">
                <div><b>Cliente </b><?php echo $data[0]['cliente_retiro']  ?></div>
                <div><b>Fecha </b><?php echo $data[0]['fecha_retiro']  ?></div>
                <div><b>Movimiento </b><?php echo $data[0]['movimient_retir']  ?></div>
                <div><b>Elaborado por </b><?php echo $data[0]['usuario_retiro']  ?></div>
                <div><b>Documento cliente </b><?php echo $data[0]['documento_client_retiro']  ?></div>
                 <div><b>Destino </b><?php echo $data[0]['client_destin_retiro']  ?><b> Ciudad </b><?php echo $data[0]['ciudad_dest_retiro']  ?></div>
                <div><b>Valido contabilidad  </b><?php echo $data[0]['valido_contabi_retiro']  ?></div>
                <div><b>Paletas recibidas </b><?php echo $data[0]['paletas_retiro']  ?></div>
            </article>
            <div class="ladoB">
                <div><b>Transporte </b><?php echo $data[0]['transporte']  ?></div>
                <div><b>Conductor </b><?php echo $data[0]['conductor']  ?></div>
                <div><b>Vehículo </b> <?php echo $data[0]['vehiculo_retiro_palcas']  ?><b>Trailer</b><?php echo $data[0]['trailer']?></div>
                <div><b>Contenedor </b><?php echo $data[0]['contenedor']  ?></div>
                <div><b>Llegada </b>  <?php echo date("d-m-Y",strtotime($data[0]['fecha_retiro']))?> <b>Hora </b><?php echo $data[0]['salida_hora']?></div>
                <div><b>Peso </b>     <?php echo $data[0]['kilos_pedidos']  ?></div>
                <div><b>Temperatura </b><?php echo $data[0]['temperatura_retiro']  ?></div>
                <div><b>Precintos </b><?php echo $data[0]['precintos_retir']  ?></div>
            </div>
        </div>
        <div class="data">
            <table border=1 style="border-collapse: collapse" class="tabla1" width="100%">
                <thead>
                    <tr class="bg-success">
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Lote</td>
                        <th>Vencimiento</th>
                        <th>Picking</td>
                        <th>Empaques</th>
                        <th>Unidades</th>
                        <th>Kilos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL despachosPdf('".$_GET['num']."')");
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
                            <td class="productos"><?php echo $filas['productoEtiqueta'] ?></td>
                            <td><?php echo $filas['loteEtiqueta'] ?></td>
                            <td align='center'><?php echo $filas['venceEtiqueta'] ?></td>
                            <td align='center'><?php echo $filas['pickingEvol'] ?></td>
                            <td align='right' class="unidades"><?php echo $filas['empaques'] ?></td>
                            <td align='right' class="unidades"><?php echo ABS($filas['unidades']) ?></td>
                            <td align='right' class="unidades"><?php echo number_format(ABS($filas['kilos']),2) ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan=5 align=right><b>Totales</b></td>
                            <td align=right><?php echo number_format(ABS($totalE),0) ?></td>
                            <td align=right><?php echo number_format(ABS($total),0) ?></td>
                            <td align=right><?php echo number_format(ABS($totalK),2) ?></td>
                        </tr>
                </tbody>
            </table>
        </div>
        
        <div class="cesta" align="right">
            <table border=1 style="border-collapse: collapse" class="tablacesta">
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
                        $data= $obj->subconsulta("CALL despachosCestasPdf('".$_GET['num']."')");
                        foreach ($data as $filas) { 
                    ?>
                        <tr>
                            <td class="codigo"><?php echo $filas['codigoEtiqueta'] ?></td>
                            <td class="producto"><?php echo $filas['productoEtiqueta'] ?></td>
                            <td align='right' class="unidades"><?php echo number_format(ABS($filas['cestas']),0) ?></td>
                            <td align='right' class="unidades"><?php echo number_format(ABS($filas['kilos']),2) ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan=2 align=right><b>Total cesta</b></td>
                            <td align=right><?php echo number_format(ABS($totcestasUni+0),0) ?></td>
                            <td align=right><?php echo number_format(ABS($totcestasKil+0),2) ?></td>
                        </tr>
                        <tr style="height: 20px">
                            <td colspan=2 align=right><b>Total despacho</b></td>
                            <td align=right><?php echo ABS($total+$totcestasUni) ?></td>
                            <td align=right><?php echo number_format(ABS($totalK+$totcestasKil),2) ?></td>
                        </tr>
                </tbody>
            </table>
        </div>
        
        <div class="firma">  
            <div id="capa1"> 
               <h4>Conductor:&nbsp;<?php echo $chofer ?>&nbsp;Hago constar que he verificado los productos y estoy de acuerdo con su cantidad y estado</h4><br/>
            
                <b>Elaborado por:<?php echo $user ?> Chequado por__________________ Supervisado por:__________________</b><br/>
                <h3>Observaciones </h3><span><?php echo $observ ?></span>
            </div>
            
            <div id="capa2"> 
                <img src="aplicaciones/imagenes/logo.png" width="80" height="85" style="filter:alpha(opacity=38);-moz-opacity:.38;opacity:.38"> 
            </div>
        </div>
        <div><p id="mensajedespmanual" style="margin-top:120px;font-size: 24px"></p></div>
        <div class="fixed letras"> Pase de salida <?php echo $_GET['num'] ?>&nbsp;&nbsp; Emitido el <?php echo date('d/m/Y h:i:s') ?></div>
	
        <footer class="dat">

        </footer>
        <div>
            <script src="aplicaciones/js/jquery-1.11.1.min.js"></script>
            <script>
                $(document).ready(function(){
                   manual();
                });
                
                function manual(){
                    
                    if(document.getElementById('movis').value=='despachomanual'){
                        
                     $('#mensajedespmanual').addClass('mensaje').html('Este despacho no tiene incidencia en los inventarios');
                    }
                    
                }
                
                JsBarcode("#barcode", "<?php echo str_pad($_GET['num'], 7, "0", STR_PAD_LEFT) ?>", {
                    format: "CODE39",
                    displayValue: true,
                    fontSize: 24,
                    height: 50
                });

            </script>
        </div>
    </body>

    </html>
