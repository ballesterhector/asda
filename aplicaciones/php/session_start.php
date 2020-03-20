<?php
	session_start();
	if (empty($_SESSION["cedula"])) {
		header('location:index.html');
	}else {
		$nombre = $_SESSION["name"];
		$usuario = $_SESSION["usuario"];
		$cedula = $_SESSION["cedula"];
		$niveles = $_SESSION["nivel"];
        $esinformatico = $_SESSION["esinformatico"];
		$grup = $_SESSION["grupo"];
		$sucur = $_SESSION["sucursar"];
		$geren = $_SESSION["gerenc"];
		$area = $_SESSION["area"];
		$correo = $_SESSION["email"];
		$telefo = $_SESSION["telefo"];
		$estad = $_SESSION["estado"];
	}
?>
