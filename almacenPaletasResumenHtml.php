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
                    <label for="" class="control-label">INVENTARIO RESUMEN PALETAS</label>
                <!--    <u><?php echo 'Número ' .str_pad($data[0]['numPicking'], 9, "0", STR_PAD_LEFT) ?></u>-->
                </div>
                <img id="barcode" />
            </div>
        </header>
        <div class="data">
            <table border=1 style="border-collapse: collapse" class="tabla1" width="100%">
                <thead>
                    <tr class="bg-success">
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Llenas</th>
                        <th class="text-center">Vacias</th>
                        <th class="text-center">Malas</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL almacenPaletasResumen()");
                        $totalE=0;
                        $total=0;
                        $totalK=0;
                        foreach ($data as $filas) { 
                            $totalE=$totalE+$filas['llenas'];
                            $total=$total+$filas['vacias'];
                            $totalK=$totalK+$filas['malas'];
                    ?>
                        <tr>
                            <td><?php echo $filas['cliente_almpale'] ?></td>
                            <td align=right><?php echo $filas['llenas'] ?></td>
                            <td align=right><?php echo $filas['vacias'] ?></td>
                            <td align=right><?php echo $filas['malas'] ?></td>
                            <td align=right><?php echo $filas['total'] ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan=1 align=right><b>Totales</b></td>
                            <td align=right><?php echo number_format(($totalE),0) ?></td>
                            <td align=right><?php echo number_format(($total),0) ?></td>
                            <td align=right><?php echo number_format(($totalK),2) ?></td>
                        </tr>
                </tbody>
            </table>
        </div>
        
        <br/><br/>
        <div class="tablasEnc" ><b>Emitido por <?php echo $nombre ?> </b>

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
