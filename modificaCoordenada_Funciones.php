<?php
	require 'conectarBD/conectarASDA.php';
   $obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Modifica':
				$datos = $obj->actualizar('CALL  etiquetasActualizaCoordenada("'.$_GET['id-prod'].'",
                "'.$_GET['galpon'].$_GET['galnum'].-$_GET['rack'].-$_GET['estante'].-$_GET['piso'].-$_GET['posicion'].'",
                "'.$_GET['modificador'].'"        
										)');
			break;
            
        case 'coordenada':
				$datos = $obj->subconsulta('CALL coordenadasNoNulas("'.$_GET['coord'].'")');
                echo json_encode($datos);
			break;
            
        case 'libera':
				$datos = $obj->actualizar('CALL coordenadaLibera("'.$_GET['del'].'","'.$_GET['al'].'","'.$_GET['clie'].'",
                                            "'.$_GET['usua'].'"
										)');
			break;    
			
		default:
			# code...
			break;
	}



 ?>
