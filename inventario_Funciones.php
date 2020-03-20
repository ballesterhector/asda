<?php
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();

    $data= $obj->subconsulta("CALL inv_DisponiblePorCodigo('".$_GET['id_cliente']."')");
    echo "<option>Seleccione la etiqueta</option>";
    foreach($data as $filas){
        
        echo "<option value='".$filas['etiquetaEvol']."'>".$filas['etiquetaEvol']."</option>";
    }
	
?>