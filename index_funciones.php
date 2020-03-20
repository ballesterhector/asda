<?php
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();
	$fecha = date("Y-m-d");
	$clav = $_GET['clave'];
	$claves = password_hash($clav,PASSWORD_DEFAULT);

	switch ($_GET['proceso']) {
		case 'Registro':
			$datos=$obj->actualizar('CALL usuarioRegistro("'.$_GET['name'].'","'.$_GET['cedul'].'","'.$_GET['usua'].'","'.$claves.'",
															"'.$_GET['email'].'","'.$_GET['telef'].'","'.$fecha.'")
									');
			break;

		case 'nCedu':
			$datos = $obj->consultar('CALL usuarioPorCedula("'.$_GET['cedula'].'")');
				echo json_encode($datos);

			break;
			
		case 'lineas':
			$datos = $obj->consultar('CALL usuarioContarLineas("'.$_GET['cedula'].'")');
				echo json_encode($datos);
			break;
			
			
		case 'resetea':
			$datos=$obj->actualizar('CALL usuarioResetear("'.$_GET['cedul'].'","'.$claves.'")');
			break;	
		
		default:
			# code...
			break;
	}




 ?>
