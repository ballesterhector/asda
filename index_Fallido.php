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
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/estilos.css">
	</head>

	<body class="body">
		<div class="logo">
			<img src="aplicaciones/imagenes/asda.png" alt="" class="" style="">
		</div>

		<div class="fallido-form">
			<div class="">
				<h3 class="fondoLs">DISCULPE</h3>
			</div>
			<div class="form-group">
				<div class="">
					<p class="">
						No se ha podido verificar su información de conexión
					</p>
				</div>
			</div>
			<div class="form-group">
				<input type="button" class="btn btn-info boton" name="salir" id="salir" value="salir" onclick="salir()">
			</div>
		</div>

		<script src="aplicaciones/js/jquery-1.11.1.min.js"></script>
		<script src="aplicaciones/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				$('.dropdown-submenu > a').submenupicker();
				initControls(); //Para evitar devolverse

			});

			function salir() {
				document.location.href = 'index.html';
			}
			//evitar devolverse
			function initControls() {
				window.location.hash = "red";
				window.location.hash = "Red" //chrome
				window.onhashchange = function() {
					window.location.hash = "red";
				}
			}

		</script>

	</body>

</html>
