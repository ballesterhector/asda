<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL conductoresInsert("'.$_GET['conduct'].'","'.$_GET['cedula'].'","'.$_GET['modificador'].'"
                                                            
														)');
			break;
	
		case 'estado':
				$datos = $obj->actualizar('CALL conductoresModificarEsdo("'.$_GET['cedul'].'","'.$_GET['usuar'].'")');
			break;

		case 'condcutores':
				$data= $obj->subconsulta("CALL conductoresSelect('".$_GET['id']."')");
					echo json_encode($data);
			break;	    
		
		case 'Modifica':
				$datos = $obj->actualizar('CALL conductoresUpdate("'.$_GET['id-prod'].'","'.$_GET['modificador'].'","'.$_GET['conduct'].'",
																"'.$_GET['estad'].'"									
										)');
			break;
			
		default:
			# code...
			break;
	}




 ?>
