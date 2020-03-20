<?php
    session_start();
    require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
    $login=$_GET['usua'];
    $pass=$_GET['passw'];

    $contador=0;
    $datos = $obj->consultar('CALL indexValida("'.$login.'")');
    foreach ($datos as $row) {
        $_SESSION["cedula"]=$row['cedulaUsuario'];
		$_SESSION["usuario"]=$row['usuario'];
        $_SESSION["name"]=$row['nombreUsuario'];
        $_SESSION["nivel"]=$row['nivelAutorizado'];
        $_SESSION["esinformatico"]=$row['es_informatico'];
        $_SESSION["estado"]=$row['estadoUsuario'];
        $_SESSION["idusu"]=$row['idusuario'];
      	$_SESSION["grupo"]=$row['grupoUsuario'];
		$_SESSION["sucursar"]=$row['sucursar'];
		$_SESSION["gerenc"]=$row['gerencia'];
		$_SESSION["area"]=$row['area'];
		$_SESSION["email"]=$row['emailUsuario'];
		$_SESSION["telefo"]=$row['telefonoUsuario'];
		
		$_SESSION["ultimoAcceso"]=date("i:s");

    };

//echo json_encode($datos);

foreach ($datos as $key ) {
    $key['nombreUsuario'];
    $clave= $key['contrasena'];

    if (password_verify($pass,$clave)) {
        $contador++;
    }

}
if ($contador>0) {
    //echo 'Usuario registrado';
    header('Location: index_Entrada.php');
}else{
   header('Location:index_Fallido.php');
}

 ?>
