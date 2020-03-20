<?php
	session_start();
	if (empty($_SESSION["cedula"])) {
		header('location:index.html');
	}else {
		$nombre = $_SESSION["name"];
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

<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="utf-8-8">
		<meta name="description" content="Aplicación para control de bienes y suministros">
		<meta name="keywords" content="asda">
		<meta name="author" content="Ballester Héctor @ballesterhector">
		<meta name="viewport" content="width=device-width, user-scalable=0,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
		<title>ASDA On Line</title>
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/bootstrap-submenu.min.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/font-awesome/css/fontawesome-all.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/sweetalert.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/estilosFlex.css">
	</head>
  <body>
    <header>
		<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
		<input type="hidden" value="<?php echo $estad ?>" id="estadoUsua">
		<input type="hidden" value="<?php echo $esinformatico ?>" id="esinformatico">
		<div class="menu">
			<div class="logo">
				<a href="#"><img src="aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
			</div>
			<nav class="enlaces" id="enlaces">
				<?php include "aplicaciones/nav/menuarriba.html" ?>
			</nav>
		</div>	
		<div class="enlinea">
			<div class="titulo">
				<h3 class="titulos">Bienvenido al sistema ASDA</h3>
			</div>
		</div>
    </header>
    <div id='main'>
      <article class="usuario">
            <div class="usuA">
                <input type="text" class="form-control" value="USUARIO"><br>
                <input type="text" class="form-control" value="CEDULA"><br>
                <input type="text" class="form-control" value="SUCURSAL"><br>
                <input type="text" class="form-control" value="GERENCIA"><br>
                <input type="text" class="form-control" value="AREA"><br>
                <input type="text" class="form-control" value="NIVEL"><br>
            </div> 
            <div class="usuB">
                <input type="text" class="form-control" value="<?php echo $nombre ?>"><br>
                <input type="text" class="form-control" value="<?php echo $cedula ?>"><br>
                <input type="text" class="form-control" value="<?php echo $sucur ?>"><br>
                <input type="text" class="form-control" value="<?php echo $geren ?>"><br>
                <input type="text" class="form-control" value="<?php echo $area ?>"><br>
                <input type="text" class="form-control" value="<?php echo $niveles ?>"><br>
            </div>    
			<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
	  </article>
      <nav>
      	<?php include "aplicaciones/nav/menuizquierda.html" ?>
      </nav>
      <aside>
      	<img src="aplicaciones/fotos/<?php echo $cedula ?>.jpg   " alt="">
      </aside>
    </div>
    <footer class="dat">
    	<script>
			var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
			var f=new Date();
			document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		</script>
    </footer>
    <div>
		<script src="aplicaciones/js/jquery-1.11.1.min.js"></script>
		<script src="aplicaciones/js/bootstrap.min.js"></script>
		<script src="aplicaciones/js/bootstrap-submenu.min.js"></script>
		<script src="aplicaciones/js/jquery.dataTables.min.js"></script>
		<script src="aplicaciones/js/sweetalert.min.js"></script>
		<script src="aplicaciones/js/jsConstantes.js"></script>
		<script src="aplicaciones/js/indexEntrada.js"></script>
	</div>
  </body>
</html>