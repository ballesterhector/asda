<?php
	require 'conectarBD/conectarASDA.php';
   $obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Modifica':
				$datos = $obj->actualizar('CALL  etiquetaManualAsigna("'.$_GET['id-prod'].'","'.$_GET['manual'].'",
                                                                    "'.$_GET['modificador'].'"        
										)');
			break;
            
        case 'manual':
				$datos = $obj->subconsulta('CALL etiquetaManual("'.$_GET['manual'].'")');
                echo json_encode($datos);
			break;
            
        case 'libera':
				$datos = $obj->actualizar('CALL etiquetaManualLibera("'.$_GET['del'].'","'.$_GET['al'].'","'.$_GET['clie'].'",
                                            "'.$_GET['usua'].'"
										)');
			break;    
			
		default:
			# code...
			break;
	}



 ?>
