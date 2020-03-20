<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL despachosInsert("'.$_GET['modificador'].'","'.$_GET['movimiento'].'","'.$_GET['numCli'].'",
															"'.$_GET['factura'].'","'.$_GET['cliedesti'].'","'.$_GET['ciudest'].'",
															"'.$_GET['cobrar'].'","'.$_GET['salida'].'","'.$_GET['horasalida'].'",
															"'.$_GET['precint'].'","'.$_GET['tempera'].'","'.$_GET['vehicu'].'",
															"'.$_GET['paletas'].'", "'.$_GET['llenas'].'", "'.$_GET['vacia'].'",
															"'.$_GET['mala'].'","'.$_GET['observa'].'","'.$_GET['granel'].'",
															"'.$_GET['solopaleta'].'","'.$_GET['pedidas'].'","'.$_GET['pesocarga'].'",
															"'.$_GET['conduct'].'","'.$_GET['transp'].'","'.$_GET['trailer'].'",
															"'.$_GET['contenedor'].'","'.$_GET['factfecha'].'","'.$_GET['original'].'"
														)');
			break;
	
		case 'Modifica':
			$datos = $obj->actualizar('CALL despachosUpdate("'.$_GET['id-prod'].'","'.$_GET['movimiento'].'",
															"'.$_GET['factura'].'","'.$_GET['factfecha'].'","'.$_GET['cliedesti'].'",
															"'.$_GET['ciudest'].'","'.$_GET['cobrar'].'","'.$_GET['salida'].'",
															"'.$_GET['horasalida'].'","'.$_GET['precint'].'","'.$_GET['tempera'].'",
															"'.$_GET['vehicu'].'","'.$_GET['paletas'].'", "'.$_GET['llenas'].'",
															"'.$_GET['vacia'].'","'.$_GET['mala'].'","'.$_GET['observa'].'",
															"'.$_GET['granel'].'","'.$_GET['confirme'].'","'.$_GET['solopaleta'].'",
															"'.$_GET['modificador'].'","'.$_GET['observa'].'",
															"'.$_GET['pedidas'].'","'.$_GET['pesocarga'].'",
															"'.$_GET['conduct'].'","'.$_GET['transp'].'","'.$_GET['trailer'].'",
															"'.$_GET['contenedor'].'"				
										)');
			break;
			
		case 'Edicion':
				$data= $obj->subconsulta("CALL despachosActivos('".$_GET['nomPro']."')");
				echo json_encode($data);
			break;	
            
        case 'despachar':	
			$datos = $obj->actualizar('CALL evolucionDespachar("'.$_GET['idevol'].'","'.$_GET['despacho'].'","'.$_GET['fech'].'"
														)');
			break;
            
        case 'masivo':	
			$datos = $obj->actualizar('CALL evolucionDespacharMasivo("'.$_GET['picki'].'","'.$_GET['despacho'].'","'.$_GET['fech'].'"
														)');
			break;    
			
		case 'confirmar':
				$data= $obj->actualizar("CALL despachosConfirmar('".$_GET['despacho']."')");
			break;
			
		case 'dataEtiquetas':
			echo '
				<table class="table table-condensed table-bordered table-responsive letras3" id="dataTable">
					<thead>
                        <tr class="bg-info letras3">
                            <th class="text-center">Picking</th>
                            <th class="text-center">Despacho</th>
                            <th class="text-center">Etiqueta</th>
							<th class="text-center">Código</th>
							<th class="text-center">Producto</th>
							<th class="text-center">Lote</th>
							<th class="text-center">Vence</th>
                            <th class="text-center">Unidades</th>
                            <th class="text-center">kilos</th>
                            <th class="text-center">Empaques</th>
							<th class="text-center">Accion</th>
                        </tr>
		            </thead>';
					$data= $obj->subconsulta("CALL pickinglistEtiquetas('".$_GET['pickingSelect']."')");
					$dat= json_encode($data);
						if ($dat=='null') {
							echo '';
						}else{			
		                    foreach ($data as $filas){
                                if ($filas['documentoEvol']=='0') {
                                    echo '
                                        <tr>
                                            <td class="">'.$filas['pickingEvol'].'</td>
                                            <td class="">'.$filas['documentoEvol'].'</td>
                                            <td class="">'.$filas['etiquetaEvol'].'</td>
                                            <td class="">'.$filas['codigoEtiqueta'].'</td>
											<td class="">'.$filas['productoEtiqueta'].'</td>
                                            <td class="">'.$filas['loteEtiqueta'].'</td>
                                            <td class="">'.$filas['venceEtiqueta'].'</td>
                                            <td class="">'.$filas['unidades'].'</td>
                                            <td class="">'.$filas['kilos'].'</td>
                                            <td class="">'.$filas['empaquesEvol'].'</td>
											<td class="text-center">
												<a href="javascript:despachar('.$filas['idevol'].')" class="fas fa-download" title="Despachar etiqueta" >
											</td>
                                        </tr>';
                                }else{
                                    echo '
                                        <tr>
                                            <td class="text-danger bg-danger">'.$filas['pickingEvol'].'</td>
                                            <td class="text-danger bg-danger">'.$filas['documentoEvol'].'</td>
                                            <td class="text-danger bg-danger">'.$filas['etiquetaEvol'].'</td>
                                            <td class="text-danger bg-danger">'.$filas['codigoEtiqueta'].'</td>
											<td class="text-danger bg-danger">'.$filas['productoEtiqueta'].'</td>
                                            <td class="text-danger bg-danger">'.$filas['loteEtiqueta'].'</td>
                                            <td class="text-danger bg-danger">'.$filas['venceEtiqueta'].'</td>
                                            <td class="text-danger bg-danger">'.$filas['unidades'].'</td>
                                            <td class="text-danger bg-danger">'.$filas['kilos'].'</td>
                                            <td class="text-danger bg-danger">'.$filas['empaquesEvol'].'</td>
											<td class="text-center">
											</td>
                                        </tr>';
                                }
                            }
		                }
		    echo  '</table>';		
		    break;
			
		case 'activar':
				$data= $obj->actualizar("CALL despachosActivar('".$_GET['despacho']."')");
			break;
            
        case 'despachomanual':
            $data= $obj->actualizar('CALL despachomanual("'.$_GET['modificador'].'","'.$_GET['movimientosm'].'","'.$_GET['numClism'].'",
															"'.$_GET['manualetiqueta'].'","'.$_GET['manualcantidad'].'",
                                                            "'.$_GET['despachom'].'","'.$_GET['fechdesm'].'","'.$_GET['manualtipo'].'"
														)');
            break;    
			
		default:
			# code...
			break;
	}




 ?>
