<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['clibus']."')");
	$clientes = $data[0]['nombre_cli'];
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
		<input type="hidden" value="<?php echo $clientes ?>" id="nivelUsuario">
		<input type="hidden" id="usuari" value="<?php echo $usuario ?>">
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
				<h3 class="titulos" id="">Data para ciclicos</h3>
			</div>
			<div>
				<select class="form-control" name="" id="cliBusca" autofocus>
					<option value=""><?php echo $clientes ?></option>
					<?php
						$obj = new conectarDB();
						$data = $obj->consultar("CALL clientesSelect('0')");
						foreach($data as $key){
							echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
							}
					?>
				</select>
			</div>
			<div>	
				<select class="form-control" title="Ingrese código identificador" style="width:190px" id="data">                                 </select> 
			</div>
			<div class="nuevo">
				<a href="#" onclick="window.open('http:../aplicaciones/ayudas/ciclicosdata.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="javascript: onclick(ciclicodatapdf())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Resultado de conteo"></i></a>
                <a href="#" onclick="window.open('http:../aplicaciones/ayudas/ciclicoEnBlanco.xlsx')" /><i class="fas fa-file-excel fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte para toma de datos"></i></a>
                <a href="javascript: onclick(data())"><i class="fas fa-download fa-2x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i></a>
                <a href="javascript: onclick(cerrar())"><i class="fab fa-expeditedssl fa-2x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Culminar proceso"></i></a>
 			</div>
		</div>
    </header>
    <div id='main'>
      <article class="tablaciclico">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
				<tr class="bg-success">
					<th class="text-center">Coordenada</th>
					<th class="text-center">Area</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL coordSelect()");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<tr>
								<td><?php echo $filas['coordenada'] ?></td>
								<td><?php echo $filas['area_coord'] ?></td>
							</tr>
						<?php } ?>
				<?php } ?>
			</tbody>
		</table>
      </article>
      <nav>
      	<?php include "aplicaciones/nav/menuizquierda.html" ?>
      </nav>
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
		<script src="aplicaciones/js/ciclico.js"></script>
	</div>
  </body>
</html>