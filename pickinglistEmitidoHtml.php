<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['id_cliente']."')");

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
    </head>

    <body>
        <header>
            <div class="tablaPdf">
                <img src="aplicaciones/imagenes/logo.png" width="105" height="105">
                <div class="acta">
                    <label for="" class="control-label">PICKING LIST EMITIDOS</label>
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
                    <tr class="bg-success">
                        <th class="text-center">Picking</th>
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
                        $data= $obj->subconsulta("CALL pickingPorPeriodo('".$fedel."','".$feal."','".$_GET['id_cliente']."')");
                        foreach ($data as $filas) { 
                    ?>
                            <tr>
                                <td><?php echo $filas['numPicking'] ?></td>
                                <td align="center"><?php echo $filas['fechaPicking'] ?></td>
                                <td><?php echo $filas['movimientoPicking'] ?></td>
                                <td><?php echo $filas['codigoEtiqueta'] ?></td>
                                <td><?php echo $filas['productoEtiqueta'] ?></td>
                                <td align='right' class="unidades"><?php echo number_format($filas['empaques'],0) ?></td>
                                <td align='right' class="unidades"><?php echo number_format($filas['unidades'],0) ?></td>
                                <td align='right' class="unidades"><?php echo number_format($filas['kilos'],2) ?></td>
                                <td align='right' class="unidades"><?php echo $filas['condicion'] ?></td>
                            </tr>
                            
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
