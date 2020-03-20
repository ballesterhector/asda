<?php 
	require 'conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=modificaciondespachos.xls");
	
	
	
	
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
                            <th class="text-center">Despacho</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Movimiento</th>
                            <th class="text-center">Documento</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Modificado por</th>
                            <th class="text-center">Arranque</th>
                            <th class="text-center">Movimiento</th>
                            <th class="text-center">Pedido</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Destino</th>
                            <th class="text-center">Ciudad</th>
                            <th class="text-center">Vehículo</th>
                            <th class="text-center">Trailer</th>
                            <th class="text-center">Contenedor</th>
                            <th class="text-center">Conductor</th>
                            <th class="text-center">Transporte</th>
                            <th class="text-center">Precintos</th>
                            <th class="text-center">Temperatura</th>
                            <th class="text-center">Paletas</th>
                            <th class="text-center">Unidades pedidas</th>
                            <th class="text-center">Kilos pedidos</th>
                            <th class="text-center">Valido contabilidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL despachosModificaciones('".$_GET['clibus']."')");
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
                                            <td><?php echo $filas['documento_client_retiro'] ?></td>
                                            <td><?php echo $filas['fechaFactura'] ?></td>
                                            <td><?php echo $filas['ultima_modificaci_por'] ?></td>
                                            <td><?php echo $filas['arranque_retiro'] ?></td>
                                            <td><?php echo $filas['movimient_retir'] ?></td>
                                            <td><?php echo $filas['documento_client_retiro'] ?></td>
                                            <td><?php echo $filas['fechaFactura'] ?></td>
                                            <td><?php echo $filas['client_destin_retiro'] ?></td>
                                            <td><?php echo $filas['ciudad_dest_retiro'] ?></td>
                                            <td><?php echo $filas['vehiculo_retiro_palcas'] ?></td>
                                            <td><?php echo $filas['trailer'] ?></td>
                                            <td><?php echo $filas['contenedor'] ?></td>
                                            <td><?php echo $filas['conductor'] ?></td>
                                            <td><?php echo $filas['transporte'] ?></td>
                                            <td><?php echo $filas['precintos_retir'] ?></td>
                                            <td><?php echo $filas['temperatura_retiro'] ?></td>
                                            <td><?php echo $filas['paletas_retiro'] ?></td>
                                            <td><?php echo $filas['unidades_pedidas'] ?></td>
                                            <td><?php echo $filas['kilos_pedidos'] ?></td>
                                            <td><?php echo $filas['valido_contabi_retiro'] ?></td>
                                           
                                        </tr>
                                    <?php } ?>        
                        <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
        </article>
	</body>
</html>