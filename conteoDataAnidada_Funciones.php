<?php
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();

    $data= $obj->subconsulta("CALL conteodataIdentificador('".$_GET['id_cliente']."')");
    echo "<option>Seleccione código</option>";
    foreach($data as $filas){
        
        echo "<option value='".$filas['identificador']."'>".$filas['fecha']."</option>";
    }

	
?>