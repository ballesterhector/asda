<?php 
	require 'conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=modificacionproductos.xls");
	
	
	
	
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
                            <th class="text-center">Fecha modificación</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Presentación</th>
                            <th class="text-center">Familia</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Alimento</th>
                            <th class="text-center">Almacen</th>
                            <th class="text-center">Tolerancia</th>
                            <th class="text-center">En kilo</th>
                            <th class="text-center">Cestas</th>
                            <th class="text-center">Detal</th>
                            <th class="text-center">Unidades empaque</th>
                            <th class="text-center">Peso unidad</th>
                            <th class="text-center">Camadas</th>
                            <th class="text-center">Rumas</th>
                            <th class="text-center">Neto</th>
                            <th class="text-center">Bruto</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Modificado por</th>
                         </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL productosModificacion('".$_GET['clibus']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['productoControl'] ?></td>
                                            <td><?php echo $filas['clienteNomb'] ?></td>
                                            <td><?php echo $filas['codigoProd'] ?></td>
                                            <td><?php echo $filas['descripProd'] ?></td>
                                            <td><?php echo $filas['presenProd'] ?></td>
                                            <td><?php echo $filas['familiaProd'] ?></td>
                                            <td><?php echo $filas['tipoProd'] ?></td>
                                            <td><?php echo $filas['esAlimento'] ?></td>
                                            <td><?php echo $filas['almacenProd'] ?></td>
                                            <td><?php echo $filas['toleranciaProd'] ?></td>
                                            <td><?php echo $filas['ingresoEnKilos'] ?></td>
                                            <td><?php echo $filas['controlCestapaleta'] ?></td>
                                            <td><?php echo $filas['movimientoDetal'] ?></td>
                                            <td><?php echo $filas['unidadesEmpaque'] ?></td>
                                            <td><?php echo $filas['pesoUnidad'] ?></td>
                                            <td><?php echo $filas['camadasProd'] ?></td>
                                            <td><?php echo $filas['rumasProd'] ?></td>
                                            <td><?php echo $filas['pesoNeto'] ?></td>
                                            <td><?php echo $filas['pesoBruto'] ?></td>
                                            <td><?php echo $filas['estadoProd'] ?></td>
                                            <td><?php echo $filas['prodModificado'] ?></td>
                                        </tr>
                                    <?php } ?>        
                        <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
        </article>
	</body>
</html>