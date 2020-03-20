<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'generar':
        	$data= $obj->actualizar('CALL conteosInsert("'.$_GET['idcliente'].'","'.$_GET['usuario'].'","'.$codigo.'"
														)');
			
			$datos = $obj->actualizar('CALL clientesModificaArranque("'.$_GET['idcliente'].'","'.$_GET['usuario'].'","'.$codigo.'"
										)');
			break;
	
		case 'Edicion':
				$data= $obj->subconsulta("CALL conteodataSelectiId('".$_GET['idcicli']."')");
				echo json_encode($data);
			break;	
			
		case 'registra':
				$datos = $obj->actualizar('CALL conteoUpdate("'.$_GET['id-prod'].'","'.$_GET['empaquewms'].'","'.$_GET['empaquecli'].'",
																"'.$_GET['unidwms'].'","'.$_GET['unidcli'].'",
																"'.$_GET['observa'].'","'.$_GET['modificador'].'"
										)');
			break;
			
		case 'cerrar':
				$datos = $obj->actualizar('CALL arranqueNuevoConteos("'.$_GET['cierra'].'","'.$_GET['identifi'].'"
										)');
			
			
				$datos = $obj->actualizar('CALL conteoCerrar("'.$_GET['cierra'].'","'.$_GET['identifi'].'"
										)');
			break;		
		
			
		default:
			# code...
			break;
	}



 ?>
