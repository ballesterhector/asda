<?php
	require 'conectarBD/conectarASDA.php';
	require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		  case 'confirmar':	
			$datos = $obj->actualizar('CALL suministrosFacturaConfirme("'.$_GET['id'].'"
														)');
			break;    
	
        
        case 'pedido':	
			$datos = $obj->actualizar('CALL suministrosPedidos_Insert("'.$_GET['fecha'].'","'.$_GET['name'].'",
															"'.$_GET['sucur'].'","'.$_GET['gerenc'].'","'.$_GET['area'].'",
                                                            "'.$_GET['proveedor'].'","'.$_GET['telef'].'",
                                                            "'.$_GET['contacto'].'","'.$_GET['motivo'].'"
														)');
			break;
            
        case 'pedidodata':	
			$datos = $obj->actualizar('CALL suministrosPedidoData_Insert("'.$_GET['reque'].'","'.$_GET['insumo'].'","'.$_GET['marca'].'","'.$_GET['modelo'].'",
                                                            "'.$_GET['color'].'","'.$_GET['presenta'].'",
															"'.$_GET['uso'].'","'.$_GET['tamano'].'",
															"'.$_GET['medida'].'","'.$_GET['requerida'].'"
														)');
			break;

		case 'rubroselect':
				$data= $obj->subconsulta("CALL suministroRubroSelect('".$_GET['dato']."')");
				echo json_encode($data);
			break;	
			
		default:
			# code...
			break;
	}




 ?>
