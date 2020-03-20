<?php
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'nivel':
			$datos=$obj->actualizar('CALL usuarioNivel("'.$_GET['ids'].'","'.$_GET['nivel'].'")');
			break;	
			
		case 'estado':
			$datos=$obj->actualizar('CALL usuarioEstadoUpdate("'.$_GET['ids'].'")');
			break;		
		
		case 'Registro':
        	$data= $obj->actualizar("CALL usuarioModifica('".$_GET['id-prod']."','".$_GET['estado']."','".$_GET['sucursar']."','".$_GET['gerencia']."',
														'".$_GET['area']."','".$_GET['email']."','".$_GET['telefono']."','".$_GET['modificador']."'
									)");
			break;
	
		case 'Edicion':
				$datos = $obj->consultar('CALL usuarioPorCedula("'.$_GET['cedul'].'")');
					echo json_encode($datos);
			break;
            
        case 'modifica':
				$datos = $obj->consultar('CALL usuarioSelect("'.$_GET['num'].'")');
					echo json_encode($datos);
			break;    
	
			
		default:
			# code...
			break;
	}




 ?>
