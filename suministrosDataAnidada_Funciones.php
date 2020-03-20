<?php
	require '../conectarBD/conectarASDA.php';
	$obj= new conectarDB();

    $data= $obj->subconsulta("CALL suministros_InvetarioPorCodigo('".$_GET['id_codigo']."')");
    echo "<option>Seleccione características</option>";
    foreach($data as $filas){
        
        echo "<option value='".$filas['etiqueta']."'>".$filas['caracteristica']."</option>";
    }

	
?>