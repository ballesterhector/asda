<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL vehiculosInsert("'.$_GET['placas'].'","'.$_GET['estad'].'","'.$_GET['modificador'].'"
                                                            
														)');
			break;
	
		case 'Modifica':
				$datos = $obj->actualizar('CALL vehiculosUpdate("'.$_GET['id-prod'].'","'.$_GET['estad'].'",
																"'.$_GET['modificador'].'","'.$_GET['placas'].'"								
										)');
			break;
		
		case 'vehiculos':
			$data= $obj->subconsulta("CALL vehiculosId('".$_GET['id']."')");
				echo json_encode($data);
			break;
			
		default:
			# code...
			break;
	}




 ?>
