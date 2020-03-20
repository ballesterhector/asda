<?php 
	require '../conectarBD/conectarASDA.php';
    $obj= new conectarDB();

	$data= $obj->subconsulta("CALL etiquetasEvolucion('".$_GET['recep']."')");
    
	header('Content-type: application/txt');
	header('Content-Disposition: attachment; filename="93'.$_GET['recep'].'.txt"');


		foreach ($data as $key ) {
			echo $key['documento_clie_recep'].";".$key['etiquetaEtiqueta'].";".$key['codigoEtiqueta'].";".$key['productoEtiqueta'].";".$key['loteEtiqueta'].";".$key['vence'].";".$key['presentacionPord'].";".$key['unidadesEtiqueta']."\r\n";
			
		}





	
?>