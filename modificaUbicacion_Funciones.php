<?php
	require 'conectarBD/conectarASDA.php';
    require 'aplicaciones/php/codigoAleatorio.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'modifica':
				$datos = $obj->actualizar('CALL  etiquetasActualizaUbicacion("'.$_GET['clie'].'","'.$_GET['del'].'","'.$_GET['al'].'",
																	"'.$_GET['ubic'].'","'.$_GET['usua'].'","'.$codigo.'"
										)');
			break;
            
        case 'modificaAlmacen':
				$datos = $obj->actualizar('CALL etiquetasActualizaAlmacen("'.$_GET['clie'].'","'.$_GET['del'].'","'.$_GET['al'].'",
																	"'.$_GET['ubic'].'","'.$_GET['usua'].'","'.$codigo.'",
                                                                    "'.$_GET['motiv'].'"
										)');
			break;
            
        case 'modificaLote':
				$datos = $obj->actualizar('CALL etiquetasActualizaLote("'.$_GET['clie'].'","'.$_GET['del'].'","'.$_GET['al'].'",
																	"'.$_GET['lote'].'","'.$_GET['usua'].'","'.$codigo.'",
                                                                    "'.$_GET['vence'].'"
										)');
			break;    
			
		default:
			# code...
			break;
	}



 ?>
