<?php
	require 'conectarBD/conectarASDA.php';
	$obj= new conectarDB();

    $data= $obj->subconsulta("CALL coordSelectGalpon('".$_GET['galpon']."')");
    echo "<option>Seleccione galpon</option>";
    foreach($data as $filas){
        
        echo "<option value='".$filas['galpon']."'>".$filas['galpon']."</option>";
    }

	
?>