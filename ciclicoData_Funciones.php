<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'generar':
        	$data= $obj->actualizar('CALL ciclicoDataInsert("'.$_GET['idcliente'].'","'.$_GET['usuario'].'","'.$codigo.'"
														)');
			break;
	
		case 'Edicion':
				$data= $obj->subconsulta("CALL ciclicosdataSelectiIdciclico('".$_GET['idcicli']."')");
				echo json_encode($data);
			break;	
			
		case 'registra':
				$datos = $obj->actualizar('CALL ciclicoDataUpdate("'.$_GET['id-prod'].'","'.$_GET['empaque'].'","'.$_GET['unidades'].'",
																"'.$_GET['observa'].'","'.$_GET['modificador'].'"
										)');
			break;
			
		case 'cerrar':
				$datos = $obj->actualizar('CALL ciclicosCerrar("'.$_GET['identifi'].'","'.$_GET['cierra'].'"
										)');
			break;		
		
			
		default:
			# code...
			break;
	}



 ?>
