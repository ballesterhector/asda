<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL pickinglistPorNumero('".$_GET['id_picking']."')");


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

        <style>
            /* cuando vayamos a imprimir ... */
            @media print{
                /* indicamos el salto de pagina */
                .saltoDePagina{
                    display:block;
                    page-break-before:always;
                }
            }
        </style>
    </head>

    <body>
        <header>
            <div class="tablaPdf">
                <img src="aplicaciones/imagenes/logo.png" width="105" height="105">
                <div class="acta">
                    <label for="" class="control-label">PICKING LIST</label>
                    <u><?php echo 'Número ' .str_pad($data[0]['numPicking'], 9, "0", STR_PAD_LEFT) ?></u>
                </div>
                <img id="barcode" />
            </div>
        </header>
        <div id='main'>
            <article class="ladoA">
                <div><b>Picking List </b><?php echo $data[0]['numPicking']  ?></div>
                <div><b>Cliente </b><?php echo $data[0]['clientePickingNomb']  ?></div>
                <div><b>Fecha </b><?php echo $data[0]['fechaPicking']  ?></div>
                <div><b>Elaborado por </b><?php echo $data[0]['usuarioPicking']  ?></div>
            </article>
            <div class="ladoB">
                <div><b>Destino </b><?php echo $data[0]['destinoCiudadPicking']  ?></div>
                <div><b>Cliente </b><?php echo $data[0]['destinoClientPicking']  ?></div>
                <div><b>Factura </b><?php echo $data[0]['documentoPedido']  ?></div>
            </div>
        </div>
        <div class="data">
            <table border=1 style="border-collapse: collapse" class="tabla1" width="100%">
                <thead>
                    
                    <tr class="bg-success">
                        <th class="text-center">Coordenada</th>
                        <th class="text-center">Código</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Lote</th>
                        <th class="text-center">Vencimiento</th>
                        <th class="text-center">Etiqueta nueva</th>
                        <th class="text-center">Etiqueta anterior</th>
                        <th class="text-center">Etiqueta manual</th>
                        <th class="text-center">Empaques</th>
                        <th class="text-center">Unidades</th>
                        <th class="text-center">kilos</th>
                        <th class="text-center">Ubicación</th>
                        <th class="text-center">Almacen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL pickinglistEtiquetas('".$_GET['id_picking']."')");
                        $totalE=0;
                        $total=0;
                        $totalK=0;
                        foreach ($data as $filas) { 
                            $totalE=$totalE+$filas['empaques'];
                            $total=$total+$filas['unidades'];
                            $totalK=$totalK+$filas['kilos'];
                    ?>
                        <tr>
                            <td><?php echo $filas['coordenadaEtiqueta'] ?></td>
                            <td><?php echo $filas['codigoEtiqueta'] ?></td>
                            <td><?php echo $filas['productoEtiqueta'] ?></td>
                            <td><?php echo $filas['loteEtiqueta'] ?></td>
                            <td align='center'><?php echo $filas['venceEtiqueta'] ?></td>
                            <td align='center'><?php echo $filas['etiquetaEvol'] ?></td>
                            <td align='center'><?php echo $filas['etiquetavieja'] ?></td>
                            <td align='center'><?php echo $filas['manualEtiqueta'] ?></td>
                            <td align='right' class="unidades"><?php echo $filas['empaques'] ?></td>
                            <td align='right' class="unidades"><?php echo ABS($filas['unidades']) ?></td>
                            <td align='right' class="unidades"><?php echo number_format(ABS($filas['kilos']),2) ?></td>
                            <td><?php echo $filas['ubicaEtiqueta'] ?></td>
                            <td><?php echo $filas['almacenEtiqueta'] ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan=8 align=right><b>Totales</b></td>
                            <td align=right><?php echo number_format(ABS($totalE),0) ?></td>
                            <td align=right><?php echo number_format(ABS($total),0) ?></td>
                            <td align=right><?php echo number_format(ABS($totalK),2) ?></td>
                        </tr>
                </tbody>
            </table>
        </div>
        
        <h1 class="saltoDePagina"> </h1>

        <!--Segunda página resumen---------------------------------------------------------------------------------------------->
	    <STRONG>RESUMEN</STRONG>   
        <?php
            $obj= new conectarDB();
			$data= $obj->subconsulta("CALL pickinglistPorNumero('".$_GET['id_picking']."')");
        ?>                 
        <div id='main'>
            <article class="ladoA">
                <div><b>Picking List </b><?php echo $data[0]['numPicking']  ?></div>
                <div><b>Cliente </b><?php echo $data[0]['clientePickingNomb']  ?></div>
                <div><b>Fecha </b><?php echo $data[0]['fechaPicking']  ?></div>
                <div><b>Elaborado por </b><?php echo $data[0]['usuarioPicking']  ?></div>
            </article>
            <div class="ladoB">
                <div><b>Destino </b><?php echo $data[0]['destinoCiudadPicking']  ?></div>
                <div><b>Cliente </b><?php echo $data[0]['destinoClientPicking']  ?></div>
                <div><b>Factura </b><?php echo $data[0]['documentoPedido']  ?></div>
            </div>
        </div>
        <div class="data">
            <table border=1 style="border-collapse: collapse" class="tabla1" width="100%">
                <thead>
                    <tr class="bg-success">
                        <th class="text-center">Código</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Lote</th>
                        <th class="text-center">Vencimiento</th>
                        <th class="text-center">Empaques</th>
                        <th class="text-center">Unidades</th>
                        <th class="text-center">kilos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL pickinglistResumenCodigo('".$_GET['id_picking']."')");
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
                            <td align='right' class="unidades"><?php echo ABS($filas['unidades']) ?></td>
                            <td align='right' class="unidades"><?php echo number_format(ABS($filas['kilos']),2) ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan=4 align=right><b>Totales</b></td>
                            <td align=right><?php echo number_format(ABS($totalE),0) ?></td>
                            <td align=right><?php echo number_format(ABS($total),0) ?></td>
                            <td align=right><?php echo number_format(ABS($totalK),2) ?></td>
                        </tr>
                </tbody>
            </table>
        </div>
        <br/><br/>
        <div class="tablasEnc" ><b>Conductor:_____________________________________cedula___________________</b><br/><br/><br/>
			<b>Hago constar que he verificado la carga y doy fe que los productos se encuentran en buen estado 
		    e igualmente que personalmente he anotado la cantidades de empaques que voy a transportar</b><br/><br/>
        </div>

        <div class="">
            <table border="1" cellspacing=0 cellpadding=2 class="tablasEnc" style="width:50%;padding-top:40px">
                <thead>
                    <tr><th colspan="5">REPORTE POR FAMILIA</th></tr>        
                        <tr class="bg-success">
                        <th class="text-center">Familia</th>
                        <th class="text-center">Empaques</th>
                        <th class="text-center">Unidades</th>
                        <th class="text-center">kilos</th>
                        <th class="text-center">Toneladas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL pickinglistResumenFamilia('".$_GET['id_picking']."')");
                        $totalEmpaq=0;
                        $total=0;
                        $totalK=0;
                        $totalT=0;
                        foreach ($data as $filas) { 
                            $totalEmpaq=$totalEmpaq+$filas['empaques'];
                            $total=$total+$filas['unidades'];
                            $totalK=$totalK+$filas['kilos'];
                            $totalT=$totalT+$filas['toneladas'];
                    ?>
                        <tr>
                            <td><?php echo $filas['familiaEtiqueta'] ?></td>
                            <td align='right' class="unidades"><?php echo $filas['empaques'] ?></td>
                            <td align='right' class="unidades"><?php echo ABS($filas['unidades']) ?></td>
                            <td align='right' class="unidades"><?php echo number_format(ABS($filas['kilos']),2) ?></td>
                            <td align='right' class="unidades"><?php echo number_format(ABS($filas['toneladas']),4) ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan=1 align=right><b>Totales</b></td>
                            <td align=right><?php echo number_format(ABS($totalEmpaq),0) ?></td>
                            <td align=right><?php echo number_format(ABS($total),2) ?></td>
                            <td align=right><?php echo number_format(ABS($totalK),2) ?></td>
                            <td align=right><?php echo number_format(ABS($totalT),4) ?></td>
                        </tr>
                </tbody>
            </table>
        </div>                    

        
        <div>
            <script src="aplicaciones/js/jquery-1.11.1.min.js"></script>
            <script>
                $(document).ready(function(){
                   manual();
                });
                
                JsBarcode("#barcode", "<?php echo str_pad($_GET['id_picking'], 7, "0", STR_PAD_LEFT) ?>", {
                    format: "CODE39",
                    displayValue: true,
                    fontSize: 24,
                    height: 50
                });

            </script>
        </div>
    </body>

    </html>
