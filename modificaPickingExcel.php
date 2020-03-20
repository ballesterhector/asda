<?php 
	require 'conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=modificacionpickinglist.xls");
	
	
	
	
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
                            <th class="text-center">Picking</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Modificado por</th>
                            <th class="text-center">Arranque</th>
                            <th class="text-center">Movimiento</th>
                            <th class="text-center">Pedido</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Destino</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Motivo</th>
                         </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL pickinglistModificaciones('".$_GET['clibus']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['clientePickingNomb'] ?></td>
                                            <td><?php echo $filas['numPicking'] ?></td>
                                            <td><?php echo $filas['fechaPicking'] ?></td>
                                            <td><?php echo $filas['modificauserpicki'] ?></td>
                                            <td><?php echo $filas['arranquePicking'] ?></td>
                                            <td><?php echo $filas['movimientoPicking'] ?></td>
                                            <td><?php echo $filas['documentoPedido'] ?></td>
                                            <td><?php echo $filas['fechaDocumento'] ?></td>
                                            <td><?php echo $filas['destinoCiudadPicking'] ?></td>
                                            <td><?php echo $filas['destinoClientPicking'] ?></td>
                                            <td><?php echo $filas['modificadoMotivo'] ?></td>
                                        </tr>
                                    <?php } ?>        
                        <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
        </article>
	</body>
</html>