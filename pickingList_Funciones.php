<?php
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL pickinglistInsert("'.$_GET['modificador'].'","'.$_GET['numcli'].'","'.$_GET['pedido'].'",
															"'.$_GET['pedidofecha'].'","'.$_GET['movimiento'].'","'.$_GET['desticlie'].'",
															"'.$_GET['desticiuda'].'"
														)');
			break;
	
		case 'Modifica':
				$datos = $obj->actualizar('CALL pickinglistUpdate("'.$_GET['modificador'].'","'.$_GET['pedido'].'","'.$_GET['pedidofecha'].'",
																	"'.$_GET['movimiento'].'","'.$_GET['desticlie'].'","'.$_GET['desticiuda'].'",
																	"'.$_GET['motivo'].'","'.$_GET['id-prod'].'"
																		
										)');
			break;
			
		case 'Edicion':
				$data= $obj->subconsulta("CALL pickinglistPorNumero('".$_GET['nomPro']."')");
				echo json_encode($data);
			break;	
	
        case 'editarM':
				$data= $obj->subconsulta("CALL inv_DisponibleEtiqueta('".$_GET['Etiqueta']."','".$_GET['codiPick']."','".$_GET['pickNum']."')");
					echo json_encode($data);
				break;
            
        case 'despachadas':
				$data= $obj->subconsulta("CALL inv_DisponibleBajadas('".$_GET['codiPick']."','".$_GET['pickNum']."')");
					echo json_encode($data);
				break;

		case 'cerrar':
				$data= $obj->subconsulta("CALL pickinglistCerrar('".$_GET['numpik']."','".$_GET['usuario']."')");
				break;		    
                
        case 'pickinbajar':
	        $datos=$obj->actualizar("CALL pickinglistDespachar('".$_GET['usuamodi']."','".$_GET['movimiento']."','".$_GET['nCliente']."',
                                                            '".$_GET['codigoid']."','".$_GET['arranq']."', '".$_GET['idpPick']."',
                                                            '".$_GET['fechapick']."','".$_GET['etiquetaS']."','".$_GET['ingrKilo']."',
                                                            '".$_GET['abajar']."','".$_GET['empaque']."'
                                                            
										)");
		    break;

		case 'ajustereti':
				$data= $obj->subconsulta("CALL pickinglistAjustar('".$_GET['numevol']."')");
				echo json_encode($data);
			break;		    
           
        case 'ajustaretiqueta':
	        $datos=$obj->actualizar("CALL pickinglistAjustesUnidades('".$_GET['id-prod']."','".$_GET['unidajuste']."','".$_GET['empaquajuste']."',
                                                            '".$_GET['modificador']."','".$_GET['movimi']."'
										)");
		    break; 

		 case 'anulamasivo':
	        $datos=$obj->actualizar("CALL pickinglistAnularMasivo('".$_GET['pick']."','".$_GET['usua']."',
	        	                                            	'".$_GET['motiv']."'
										)");
		    break;        
			
		default:
			# code...
			break;
	}



 ?>
