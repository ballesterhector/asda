<?php 
	require 'conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=modificacionrecepciones.xls");
	
	
	
	
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
                            <th class="text-center">Recepción</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Movimiento</th>
                            <th class="text-center">Documento</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Modificado por</th>
                            <th class="text-center">Transporte</th>
                            <th class="text-center">Conductor</th>
                            <th class="text-center">Vehículo</th>
                            <th class="text-center">Trailer</th>
                            <th class="text-center">Contenedor</th>
                            <th class="text-center">Origen</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Valido contabilidad</th>
                           
                           <th class="text-center">Peso paleta</th>
                           <th class="text-center">Granel</th>
                           <th class="text-center">Paletas</th>
                           <th class="text-center">Unidades</th>
                           <th class="text-center">Kilos</th>
                           <th class="text-center">Observaciones</th>
                           <th class="text-center">Arranque</th>
                         </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL recepcionesModificaciones('".$_GET['clibus']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['clienteName_recep'] ?></td>
                                            <td><?php echo $filas['num_recep'] ?></td>
                                            <td><?php echo $filas['fecha_recep'] ?></td>
                                            <td><?php echo $filas['movimient_recep'] ?></td>
                                            <td><?php echo $filas['documento_clie_recep'] ?></td>
                                            <td><?php echo $filas['fecha_document_cliente'] ?></td>
                                            <td><?php echo $filas['modifica_recp'] ?></td>
                                            <td><?php echo $filas['transport_recep'] ?></td>
                                            <td><?php echo $filas['conductor_recep'] ?></td>
                                            <td><?php echo $filas['vehiculo_recp'] ?></td>
                                            <td><?php echo $filas['trailer_recp'] ?></td>
                                            <td><?php echo $filas['vehiculo_contenedor_recp'] ?></td>
                                            <td><?php echo $filas['ciudad_origen'] ?></td>
                                            <td><?php echo $filas['cliente_origen'] ?></td>
                                            <td><?php echo $filas['valido_contabili'] ?></td>
                                            <td><?php echo $filas['peso_paleta'] ?></td>
                                            <td><?php echo $filas['a_granel'] ?></td>
                                            <td><?php echo $filas['paletas_ingreso'] ?></td>
                                            <td><?php echo $filas['unidades_transportadas'] ?></td>
                                            <td><?php echo $filas['kilos_transportados'] ?></td>
                                            <td><?php echo $filas['observac_recep'] ?></td>
                                            <td><?php echo $filas['arranque_recep'] ?></td>
                                        </tr>
                                    <?php } ?>        
                        <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
        </article>
	</body>
</html>