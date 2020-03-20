<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'dataEtiquetas':
			echo '
				<table class="table table-condensed table-bordered table-responsive letra1" id="dataTable">
					<thead>
                        <tr class="bg-info">
                            <th class="text-center">Etiqueta</th>
                            <th class="text-center">Movimiento</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Documento</th>
							<th class="text-center">Código</th>
							<th class="text-center">Producto</th>
							<th class="text-center">Lote</th>
							<th class="text-center">Vence</th>
                            <th class="text-center">Unidades</th>
                            <th class="text-center">kilos</th>
                            <th class="text-center">Empaques</th>
						</tr>
		            </thead>';
					$data= $obj->subconsulta("CALL etiquetasEvol('".$_GET['etiqueta']."')");
					$dat= json_encode($data);
						if ($dat=='null') {
							echo '';
						}else{			
		                    foreach ($data as $filas){
                                 echo '
                                    <tr>
                                        <td class="">'.$filas['etiquetaEvol'].'</td>
                                        <td class="">'.$filas['movimientoEvol'].'</td>
                                        <td class="">'.$filas['usuario_evol'].'</td>
                                        <td class="">'.$filas['documentoEvol'].'</td>
                                        <td class="">'.$filas['codigoEtiqueta'].'</td>
										<td class="">'.$filas['productoEtiqueta'].'</td>
                                        <td class="">'.$filas['loteEtiqueta'].'</td>
                                        <td class="">'.$filas['venceEtiqueta'].'</td>
                                        <td class="">'.$filas['unidades'].'</td>
                                        <td class="">'.$filas['kilos'].'</td>
                                        <td class="">'.$filas['empaquesEvol'].'</td>
									</tr>';
                                
                            }
		                }
		    echo  '</table>';		
		    break;
			
		default:
			# code...
			break;
	}




 ?>
