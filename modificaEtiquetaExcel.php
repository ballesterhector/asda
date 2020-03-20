<?php 
	require 'conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=modificacionetiqueta.xls");
	
	
	
	
?>
<html>
	<head>
		<title>
			ASDA On-line
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8-8" />
	</head>
	<body onload="valida_vacio();">
		<article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Etiqueta evol</th>
                            <th class="text-center">Manual</th>
                            <th class="text-center">Coordenada</th>
                            <th class="text-center">Ubicación</th>
                            <th class="text-center">Almacen</th>
                            <th class="text-center">Motivo</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Lote</th>
                            <th class="text-center">Vencimiento</th>
                            <th class="text-center">Modificado por</th>
                            <th class="text-center">Modificación</th>
                            <th class="text-center">Fecha modificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL etiquetasModificaciones('".$_GET['clibus']."','".$_GET['del']."','".$_GET['al']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['clienteEtiqueta'] ?></td>
                                            <td><?php echo $filas['etiquetaEtiqueta'] ?></td>
                                            <td><?php echo $filas['manualEtiqueta'] ?></td>
                                            <td><?php echo $filas['coordenadaEtiqueta'] ?></td>
                                            <td><?php echo $filas['ubicaEtiqueta'] ?></td>
                                            <td><?php echo $filas['almacenEtiqueta'] ?></td>
                                            <td style="text-transform: lowercase;"><?php echo $filas['motivoEtiqueta'] ?></td>
                                            <td style="text-transform: lowercase;"><?php echo $filas['codigoEtiqueta'] ?></td>
                                            <td><?php echo $filas['productoEtiqueta'] ?></td>
                                            <td><?php echo $filas['loteEtiqueta'] ?></td>
                                            <td><?php echo $filas['venceEtiqueta'] ?></td>
                                            <td><?php echo $filas['modificarEtiqueta'] ?></td>
                                            <td><?php echo $filas['movimientoData'] ?></td>
                                            <td><?php echo $filas['fechamodifica'] ?></td>
                                        </tr>
                                    <?php } ?>        
                        <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
            </article>
	</body>
</html>