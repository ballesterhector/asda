<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL ciclicosdataPorIdentificador('".$_GET['codigo']."')");

    
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
                    <label for="" class="control-label">CICLICO DATA</label>
                    <u><?php echo 'Número ' .str_pad($data[0]['identificador'], 9, "0", STR_PAD_LEFT) ?></u>
                </div>
                <img id="barcode" />
            </div>
        </header>
        <div id='main'>
            <article class="ladoA">
                <div><b>Cliente </b><?php echo $data[0]['clienteCiclico']  ?></div>
                <div><b>Fecha </b><?php echo $data[0]['fechaCiclico']  ?></div>
                <div><b>Generado por </b><?php echo $nombre  ?></div>
            </article>
            
        </div>
        
        <div class="data">
            <table border=1 style="border-collapse: collapse" class="tabla1" width="100%">
                <thead>
                    <tr class="bg-success">
                        <th class="text-center">Coordenada</th>
                        <th class="text-center">Etiqueta</th>
                        <th class="text-center">Código</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Lote</th>
                        <th class="text-center">Vence</th>
                        <th class="text-center">Empaques</th>
                        <th class="text-center">Fisico</th>
                        <th class="text-center">Diferencia</th>
                        <th class="text-center">Unidades</th>
                        <th class="text-center">Fisico</th>
                        <th class="text-center">Diferencia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL ciclicosdataSelecPorIdentificador('".$_GET['codigo']."')");
                        $dat= json_encode($data);
                        if ($dat=='null') {
                            echo '';
                        }else{
                            foreach ($data as $filas) { ?>
                                <tr>
                                    <td><?php echo $filas['coordenada'] ?></td>
                                    <td><?php echo $filas['etiqueta'] ?></td>
                                    <td style="font-size:2px;width:15px;text-transform:lowercase"><?php echo $filas['codigo'] ?></td>
                                    <td style="font-size:2px;width:25px;text-transform:lowercase"><?php echo $filas['producto'] ?></td>
                                    <td><?php echo $filas['lote'] ?></td>
                                    <td><?php echo $filas['vence'] ?></td>
                                    <td align="right"><?php echo $filas['empaques'] ?></td>
                                    <td align="right"><?php echo $filas['empaquesFisico'] ?></td>
                                    <td align="right"><?php echo $filas['diferEmpaq'] ?></td>
                                    <td align="right" style="width:10px"><?php echo $filas['unidades'] ?></td>
                                    <td align="right"><?php echo $filas['unidadesFisico'] ?></td>
                                    <td align="right" style="width:10px"><?php echo $filas['diferUnid'] ?></td>
                                </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <h1 class="saltoDePagina"> </h1>
        
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
