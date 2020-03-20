<?php
    //Generar código aleatorio
    function generarCodigo($longitud){
        $key = '';
        $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($pattern)-1;
        for ($i=0; $i < $longitud; $i++)
            $key .= $pattern{mt_rand(0,$max)};
            return $key;

    }
    
	$codigo = generarCodigo(10);

?>
