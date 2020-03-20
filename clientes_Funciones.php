<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';

	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL clientesRegistra("'.$_GET['name'].'","'.$_GET['rif'].'","'.$_GET['telef'].'","'.$_GET['estado'].'","'.$_GET['direcc'].'",
																"'.$_GET['contacto'].'","'.$_GET['teleContacto'].'","'.$_GET['email'].'",
																"'.$_GET['observ'].'","'.$_GET['tolera'].'","'.$_GET['paleta'].'",
																"'.$_GET['contratada'].'","'.$_GET['modificador'].'",
																"'.$_GET['bloqueo'].'","'.$codigo.'"
														)');
			break;
	
		case 'Modifica':
				$datos = $obj->actualizar('CALL clientesModifica("'.$_GET['rif'].'","'.$_GET['telef'].'","'.$_GET['estado'].'","'.$_GET['direcc'].'",
																"'.$_GET['contacto'].'","'.$_GET['teleContacto'].'","'.$_GET['email'].'",
																"'.$_GET['observ'].'","'.$_GET['tolera'].'",
																"'.$_GET['paleta'].'","'.$_GET['contratada'].'","'.$_GET['modificador'].'",
																"'.$_GET['bloqueo'].'","'.$_GET['id-prod'].'"
				
										)');
			break;
			
		case 'Edicion':
				$data= $obj->subconsulta("CALL clientesSelectTodos('".$_GET['nomCli']."')");
				echo json_encode($data);
			break;	
			
		case 'arranque':
			
			$datos = $obj->actualizar('CALL clientesModificaArranque("'.$_GET['numCli'].'","'.$_GET['usuar'].'","'.$codigo.'"
				
										)');
			echo json_encode($datos);
			break;		
	
			
		default:
			# code...
			break;
	}




 ?>
