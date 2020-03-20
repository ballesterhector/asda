<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL transferenciaInsert("'.$_GET['tipo'].'","'.$_GET['modificador'].'","'.$_GET['motivo'].'",
                                                                "'.$_GET['numCli'].'","'.$_GET['clillega'].'"
														)');
			break;
	
		case 'evolinsert':
				$datos = $obj->actualizar('CALL transferenciaDataInserEtiqOriginal("'.$_GET['etiqu'].'","'.$_GET['transfe'].'")');
                
                $datos = $obj->actualizar('CALL transferenciaInserEvol("'.$_GET['idclient'].'","'.$_GET['idcodig'].'","'.$_GET['transfe'].'",
                                                                        "'.$_GET['fechatrasf'].'","'.$_GET['etiqu'].'","'.$_GET['usua'].'",
                                                                        "'.$_GET['unidad'].'","'.$_GET['empaque'].'","'.$_GET['tipo'].'"                
                                            )');
            
                $datos = $obj->actualizar('CALL etiquetasInsert("'.$_GET['etiquetas'].'","'.$_GET['idclientlleg'].'","'.$_GET['usua'].'",
                                                            "'.$_GET['transfe'].'","'.$_GET['movimie'].'","'.$_GET['idcodig'].'",
															"'.$_GET['lote0'].'","'.$_GET['vencimi0'].'","'.$_GET['unidad'].'",
															"'.$_GET['malas'].'","'.$_GET['empaque'].'","'.$_GET['almacen'].'",
															"'.$_GET['motivo'].'","'.$_GET['preci'].'"
														)');
			
                $datos = $obj->actualizar('CALL transferenciaDataInser("'.$_GET['idclient'].'","'.$_GET['idcodig'].'","'.$_GET['transfe'].'",
                                                                        "'.$_GET['fechatrasf'].'","'.$_GET['etiqu'].'","'.$_GET['usua'].'",
                                                                        "'.$_GET['unidad'].'","'.$_GET['empaque'].'" ,"'.$_GET['tipo'].'"                
                                            )');
            
                	
                $datos = $obj->actualizar('CALL transferenciaDataInserEtiqNueva("'.$_GET['transfe'].'")');
                
                
            break;   

		case 'etiquetas':
				$data= $obj->subconsulta("CALL transferenciasInvDisponibleEtiqueta('".$_GET['id']."')");
					echo json_encode($data);
			break;	    
		
		
            
			
		default:
			# code...
			break;
	}




 ?>
