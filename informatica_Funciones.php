<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'Registro':
        	$data= $obj->actualizar('CALL informatica_EquiposInsert("'.$_GET['user'].'","'.$_GET['ubica'].'","'.$_GET['team'].'","'.$_GET['any'].'",
															"'.$_GET['tipo'].'","'.$_GET['siteoparat'].'","'.$_GET['ram'].'",
												            "'.$_GET['dd'].'","'.$_GET['ip'].'","'.$_GET['iconos'].'",
                                                            "'.$_GET['observa'].'","'.$_GET['email'].'","'.$_GET['estado'].'",
                                                            "'.$_GET['impremarca'].'","'.$_GET['impremodelo'].'","'.$_GET['toner'].'",
                                                            "'.$_GET['pc'].'","'.$_GET['mac'].'"
														)');
			break;
	
		case 'Modifica':
			$datos = $obj->actualizar('CALL informatica_EquiposUpdate("'.$_GET['id-prod'].'","'.$_GET['user'].'","'.$_GET['ubica'].'","'.$_GET['team'].'",
                                                            "'.$_GET['any'].'","'.$_GET['tipo'].'","'.$_GET['siteoparat'].'","'.$_GET['ram'].'",
												            "'.$_GET['dd'].'","'.$_GET['ip'].'","'.$_GET['iconos'].'",
                                                            "'.$_GET['observa'].'","'.$_GET['email'].'","'.$_GET['estado'].'",
                                                            "'.$_GET['impremarca'].'","'.$_GET['impremodelo'].'","'.$_GET['toner'].'",
                                                            "'.$_GET['pc'].'","'.$_GET['mac'].'"
										)');
			break;
			
		case 'Edicion':
				$data= $obj->subconsulta("CALL informatica_EquiposConsulta('".$_GET['correla']."')");
				echo json_encode($data);
			break;
            
        case 'Edicionred':
				$data= $obj->subconsulta("CALL informaticaRedSelect('".$_GET['correla']."')");
				echo json_encode($data);
			break; 
            
        case 'Registrored':
        	$data= $obj->actualizar('CALL informatica_RedInsert("'.$_GET['ubica'].'","'.$_GET['tipo'].'","'.$_GET['puerto'].'",
                                                           "'.$_GET['tipo2'].'","'.$_GET['estado'].'","'.$_GET['observa'].'"
														)');


        	$data= $obj->actualizar('call informatica_puertosInsert("'.$_GET['puerto'].'")');

			break;
            
        case 'Modificared':
        	$data= $obj->actualizar('CALL informatica_RedUpdate2("'.$_GET['id-prod'].'","'.$_GET['ubica'].'","'.$_GET['tipo'].'",
        															"'.$_GET['puerto'].'","'.$_GET['tipo2'].'","'.$_GET['estado'].'",
                                                           			"'.$_GET['observa'].'"
														)');
			break;  

		case 'asignaequiposred':
			$data = $obj->actualizar('CALL informatica_puertoAsigna("'.$_GET['id-prodequi'].'","'.$_GET['codequip'].'")');
			break;	

		default:
			# code...
			break;
	}




 ?>
