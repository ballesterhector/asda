<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL informatica_solicitudInsert("'.$_GET['solicit'].'","'.$_GET['equip'].'","'.$_GET['falla'].'",
																		"'.$_GET['observ'].'","'.$_GET['modifi'].'"
														)');
			break;
	
		case 'Modifica':
			$datos = $obj->actualizar('CALL informatica_EquiposUpdate("'.$_GET['solicit'].'","'.$_GET['equip'].'","'.$_GET['falla'].'",
																		"'.$_GET['observ'].'","'.$_GET['modifi'].'"
										)');
			break;
			
		case 'Edicion':
				$data= $obj->subconsulta("CALL informatica_solicitudSelect('".$_GET['correla']."')");
				echo json_encode($data);
			break;

		case 'cerrar':
				$datos = $obj->actualizar('CALL informatica_solicitudCerrar("'.$_GET['codi'].'","'.$_GET['usuar'].'",
																			"'.$_GET['facturacierre'].'","'.$_GET['tecni'].'",
																			"'.$_GET['costo'].'","'.$_GET['repara'].'"	

																			)');
			break;	
            
        
            
      	default:
			# code...
			break;
	}




 ?>
