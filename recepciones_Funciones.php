<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL recepcionesInsert("'.$_GET['numCli'].'","'.$_GET['movimiento'].'","'.$_GET['modificador'].'",
                                                            "'.$_GET['factura'].'","'.$_GET['factfecha'].'","'.$_GET['transp'].'",
															"'.$_GET['conduct'].'","'.$_GET['vehicu'].'","'.$_GET['trailer'].'",
												            "'.$_GET['contenedor'].'","'.$_GET['llegada'].'","'.$_GET['horallegada'].'",
                                                            "'.$_GET['precint'].'",	"'.$_GET['tempera'].'","'.$_GET['observa'].'",
                                                            "'.$_GET['origen'].'","'.$_GET['clieorig'].'","'.$_GET['cobrar'].'",
                                                            "'.$_GET['granel'].'","'.$_GET['paletas'].'", "'.$_GET['llenas'].'",
                                                            "'.$_GET['vacia'].'", "'.$_GET['mala'].'", "'.$_GET['solopaleta'].'",
                                                           "'.$_GET['unidades'].'","'.$_GET['pesocarga'].'"
														)');
			break;
	
		case 'Modifica':
			$datos = $obj->actualizar('CALL recepcionesUpdate("'.$_GET['recepci'].'","'.$_GET['movimiento'].'","'.$_GET['modificador'].'",
                                                            "'.$_GET['factura'].'","'.$_GET['factfecha'].'","'.$_GET['transp'].'",
															"'.$_GET['conduct'].'","'.$_GET['vehicu'].'","'.$_GET['trailer'].'",
												            "'.$_GET['contenedor'].'","'.$_GET['llegada'].'","'.$_GET['horallegada'].'",
                                                            "'.$_GET['precint'].'",	"'.$_GET['tempera'].'","'.$_GET['observa'].'",
                                                            "'.$_GET['origen'].'","'.$_GET['clieorig'].'","'.$_GET['cobrar'].'",
                                                            "'.$_GET['granel'].'","'.$_GET['paletas'].'", "'.$_GET['llenas'].'",
                                                            "'.$_GET['vacia'].'", "'.$_GET['mala'].'", "'.$_GET['solopaleta'].'",
                                                           "'.$_GET['unidades'].'","'.$_GET['pesocarga'].'"				
										)');
			break;
			
		case 'Edicion':
				$data= $obj->subconsulta("CALL recepcionesActivas('".$_GET['nomPro']."')");
				echo json_encode($data);
			break;	
            
        case 'confirmar':
				$data= $obj->actualizar("CALL recepcionesConfirmar('".$_GET['nomPro']."')");
			break;	    
	
		case 'etiquetas':	
			$datos = $obj->actualizar('CALL etiquetasInsert("'.$_GET['etiquet'].'","'.$_GET['numCli'].'","'.$_GET['modificador'].'",
                                                            "'.$_GET['numRecep'].'","'.$_GET['movimient'].'","'.$_GET['codi0'].'",
															"'.$_GET['lote0'].'","'.$_GET['vencimi0'].'","'.$_GET['unidad'].'",
															"'.$_GET['malas'].'","'.$_GET['empaque'].'","'.$_GET['almacen'].'",
															"'.$_GET['motivos0'].'","'.$_GET['precio'].'","'.$_GET['tarapaleta'].'",
															"'.$_GET['taracesta'].'"
														)');
			
			$data= $obj->actualizar("CALL recepcionesConfirmar('".$_GET['numRecep']."')");
			
			break;
			
			case 'activacion':
				$data= $obj->actualizar("CALL recepcionesActivacion('".$_GET['numRecep']."')");
			break;
			
		default:
			# code...
			break;
	}




 ?>
