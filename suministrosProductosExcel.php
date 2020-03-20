<?php 
	require '../conectarBD/conectarASDA.php';
	include "acciones.php"; 
	
	header('Content-type: application/octet-stream');
	header("Content-Disposition: attachment; filename=codigosdeinsumos.xls");
	
	
	$cliente_inv=$_GET['id_cliente'];
	
	
	
?>
<html>
	<head>
		<title>
			ASDA On-line
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8-8" />
	</head>
	<body onload="valida_vacio();">
		<article class="col-sm-9">
		    <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Código</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL suministrosSelect()");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['codigo'] ?></td>
                                            <td><?php echo $filas['rubros'] ?></td>
                                            <td><?php echo $filas['clases'] ?></td>
                                            <td align="right"><?php echo $filas['subclase'] ?></td>
                                        </tr>
                                        
                                <?php } ?>
                            <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
        </article>
	</body>
</html>