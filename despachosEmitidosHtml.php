<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
    $fecha = date("d-m-Y H:i:s");
    set_time_limit(320); 
    
    
    if($_GET['del']==0){
        $fedel = date('Y-m-d');
        $feal = date('Y-m-d');
    }else{
        $fedel = $_GET['del'];
        $feal = $_GET['al'];
    }
    
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
                    <label for="" class="control-label">DESPACHOS EMITIDOS</label>
                </div>
                <img id="barcode" />
            </div>
        </header>
        <div id='main'>
            <article class="ladoA">
                <div><b>Fecha </b>Del <?php echo $fedel  ?> Al <?php echo $feal  ?></div>
                <div><b>Generado por </b><?php echo $nombre  ?></div>
            </article>
            
        </div>
        
        <div class="data">
            <table border=1 style="border-collapse: collapse" class="tabla1" width="100%">
                <thead>
                    <tr class="bg-success">
                    <th class="text-center">Despacho</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Movimiento</th>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Empaques</th>
                <th class="text-center">Unidades</th>
                <th class="text-center">Kilos</th>
                <th class="text-center">Condición</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $obj= new conectarDB();
                        $data= $obj->subconsulta("CALL despachosPorPeriodo('".$fedel."','".$feal."')");
                        $dat= json_encode($data);
                        if ($dat=='null') {
                            echo '';
                        }else{
                            foreach ($data as $filas) { ?>
                                <tr>
                                <td><?php echo $filas['cliente_retiro'] ?></td>
                                <td><?php echo $filas['num_retiro'] ?></td>
                                    <td><?php echo $filas['fecha_retiro'] ?></td>
                                    <td><?php echo $filas['movimient_retir'] ?></td>
                                    <td><?php echo $filas['codigoEtiqueta'] ?></td>
                                    <td><?php echo $filas['productoEtiqueta'] ?></td>
                                    
                                    <td align="right"><?php echo $filas['empaques'] ?></td>
                                    <td align="right" style="width:10px"><?php echo $filas['unidades'] ?></td>
                                    <td align="right"><?php echo $filas['kilos'] ?></td>
                                    <td><?php echo $filas['condicion'] ?></td"right">
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
