<?php 
	require 'conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=modificacioncliente.xls");
	
	
	
	
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
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Modificado por</th>
                            <th class="text-center">Rif</th>
                            <th class="text-center">Teléfono</th>
                            <th class="text-center">Contacto</th>
                            <th class="text-center">Teléfono</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Kilos tolerancia</th>
                            <th class="text-center">Kilos paleta</th>
                            <th class="text-center">Paletas contratadas</th>
                            <th class="text-center">Bloqueo automático</th>
                            <th class="text-center">Dirección</th>
                            <th class="text-center">Observaciones</th>
                            <th class="text-center">Arranque</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL clientesmodificaciones('".$_GET['clibus']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['nombreCli'] ?></td>
                                            <td><?php echo $filas['fechaControl'] ?></td>
                                            <td><?php echo $filas['modificaCli'] ?></td>
                                            <td><?php echo $filas['rifCli'] ?></td>
                                            <td><?php echo $filas['telefonoCli'] ?></td>
                                            <td><?php echo $filas['contactoCli'] ?></td>
                                            <td><?php echo $filas['telefCli'] ?></td>
                                            <td><?php echo $filas['emailCli'] ?></td>
                                            <td><?php echo $filas['kilosTolerancia'] ?></td>
                                            <td><?php echo $filas['kilosPaletaCli'] ?></td>
                                            <td><?php echo $filas['paletasContratadas'] ?></td>
                                            <td><?php echo $filas['bloqueo'] ?></td>
                                            <td><?php echo $filas['direciCli'] ?></td>
                                            <td><?php echo $filas['observCli'] ?></td>
                                            <td><?php echo $filas['arranqueCli'] ?></td>
                                            <td><?php echo $filas['estado'] ?></td>
                                        </tr>
                                    <?php } ?>        
                        <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
        </article>
	</body>
</html>