<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL tansportesInsert("'.$_GET['transp'].'","'.$_GET['rif'].'","'.$_GET['modificador'].'"
                                                            
														)');
			break;
	
		case 'estado':
				$datos = $obj->actualizar('CALL conductoresModificarEsdo("'.$_GET['id'].'","'.$_GET['usuar'].'")');
			break;

		case 'transportes':
				$data= $obj->subconsulta("CALL transportesId('".$_GET['id']."')");
					echo json_encode($data);
			break;	    
		
		case 'Modifica':
				$datos = $obj->actualizar('CALL transportesUpdate("'.$_GET['id-prod'].'","'.$_GET['transp'].'","'.$_GET['estad'].'",
																"'.$_GET['modificador'].'"								
										)');
			break;
			
		default:
			# code...
			break;
	}




 ?>
