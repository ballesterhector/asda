<?php
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();

    $data= $obj->subconsulta("CALL ciclicosdataIdentificador('".$_GET['id_cliente']."')");
    echo "<option>Seleccione fecha</option>";
    foreach($data as $filas){
        
        echo "<option value='".$filas['identificador']."'>".$filas['fechaCiclico']."</option>";
    }

	
?>