<?php
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL productosInsert("'.$_GET['numcli'].'","'.$_GET['codigo'].'","'.$_GET['producto'].'",
															"'.$_GET['presenta'].'","'.$_GET['familia'].'","'.$_GET['tipo'].'",
															"'.$_GET['alimento'].'","'.$_GET['ubicaci'].'","'.$_GET['tolera'].'",
															"'.$_GET['enkilo'].'","'.$_GET['cesta'].'","'.$_GET['unidades'].'",
															"'.$_GET['camada'].'","'.$_GET['ruma'].'","'.$_GET['neto'].'",
															"'.$_GET['bruto'].'","'.$_GET['modificador'].'","'.$_GET['pesounidad'].'",
															"'.$_GET['estado'].'"
														)');
			break;
	
		case 'Modifica':
				$datos = $obj->actualizar('CALL productosModifica("'.$_GET['id-prod'].'","'.$_GET['producto'].'",
															"'.$_GET['presenta'].'","'.$_GET['familia'].'","'.$_GET['tipo'].'",
															"'.$_GET['alimento'].'","'.$_GET['ubicaci'].'","'.$_GET['tolera'].'",
															"'.$_GET['enkilo'].'","'.$_GET['cesta'].'","'.$_GET['unidades'].'",
															"'.$_GET['camada'].'","'.$_GET['ruma'].'","'.$_GET['neto'].'",
															"'.$_GET['bruto'].'","'.$_GET['modificador'].'","'.$_GET['pesounidad'].'",
															"'.$_GET['estado'].'"
																		
										)');
			break;
			
		case 'Edicion':
				$data= $obj->subconsulta("CALL productosConsultaProducto('".$_GET['nomPro']."')");
				echo json_encode($data);
			break;	
	
			
		default:
			# code...
			break;
	}