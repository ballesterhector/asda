<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['clibus']."')");
	$clientes = $data[0]['nombre_cli'];

    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL conteoCerrado('".$_GET['identificador']."')");
	$cerrado = $data[0]['culminado'];

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
		<input type="hidden" value="<?php echo $clientes ?>" id="">
		<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
		<input type="hidden" id="usuari" value="<?php echo $usuario ?>">
		<input type="hidden" id="cerradodata" value="<?php echo $cerrado ?>">
		<div class="menu">
			<div class="logo">
				<a href="#"><img src="aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
			</div>
			<nav class="enlaces" id="enlaces">
				<?php include "aplicaciones/nav/menuarriba.html" ?>
			</nav>
		</div>	
		<div class="recepcion">
			<div class="titulo">
				<h3 class="titulos" id="">Data para conteos</h3>
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
			<div class="ayudaciclico">
				<a href="#" onclick="window.open('http:../aplicaciones/ayudas/conteos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="javascript: onclick(ciclicodatapdf())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Resultado de conteo"></i></a>
                <a href="#" onclick="window.open('http:../aplicaciones/ayudas/ciclicoEnBlanco.xlsx')" /><i class="fas fa-file-excel fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte para toma de datos"></i></a>
                <a href="javascript: onclick(data())" ><i class="fas fa-download fa-2x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i></a>
                <a href="javascript: onclick(cerrar())" id="cerradocodig"><i class="fab fa-expeditedssl fa-2x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Culminar proceso"></i></a>
 			</div>
		</div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
			    <tr>
		        	<th border="0" class="th identif">Identificador</th><td class="identif"><?php echo $_GET['identificador'] ?></td>
			        <th border="0" class="th"></th>
			        <th class="th"></th>
			        <th class="th"></th>
			        <th class="text-center empaque" colspan="5">Empaques</th>
			         <th class="text-center unidades" colspan="5">Unidades</th>
			    </tr>
				<tr class="">
					<th class="text-center">Etiqueta</th>
					<th class="text-center">Código</th>
					<th class="text-center">Producto</th>
					<th class="text-center">Lote</th>
					<th class="text-center">Vence</th>
					<th class="text-center empaque">WMS</th>
					<th class="text-center empaque">Cliente</th>
					<th class="text-center empaque">Fisico</th>
					<th class="text-center empaque">Diferencia WMS fisico</th>
					<th class="text-center empaque">Diferencia cliente fisico</th>
					<th class="text-center unidades">WMS</th>
					<th class="text-center unidades">Cliente</th>
					<th class="text-center unidades">Fisico</th>
					<th class="text-center unidades">Diferencia WMS fisico</th>
					<th class="text-center unidades">Diferencia cliente fisico</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tfoot>
                <tr>
                    <th colspan="4" style="text-align:right">Total:</th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                </tr>
            </tfoot>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL conteodataSelect('".$_GET['clibus']."','".$_GET['identificador']."')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
						<?php if($filas['culminado']==0){?>
							<tr>
								<td><?php echo $filas['etiqueta'] ?></td>
								<td><?php echo $filas['codigo'] ?></td>
								<td><?php echo $filas['producto'] ?></td>
								<td><?php echo $filas['lote'] ?></td>
								<td><?php echo $filas['vence'] ?></td>
								<td class="text-right empaque"><?php echo $filas['empaquesWms'] ?></td>
								<td class="text-right empaque"><?php echo $filas['empaquesCliente'] ?></td>
								<td class="text-right empaque"><?php echo $filas['empaquesFisico'] ?></td>
								<td class="text-right empaque tamano"><?php echo $filas['diferEmpaWmsFisico'] ?></td>
								<td class="text-right empaque tamano"><?php echo $filas['diferEmpaClieFisico'] ?></td>
								<td class="text-right unidades"><?php echo $filas['unidadesWms'] ?></td>
								<td class="text-right unidades"><?php echo $filas['unidadesCliente'] ?></td>
								<td class="text-right unidades"><?php echo $filas['unidadesFisico'] ?></td>
								<td class="text-right unidades tamano"><?php echo $filas['diferUniWmsFisico'] ?></td>
								<td class="text-right unidades tamano"><?php echo $filas['diferUniClieFisico'] ?></td>
								
								<td class="icono">
									<a href='javascript:modal(<?php echo $filas['idconteos'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Modificar estado' </a>
								</td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td><?php echo $filas['etiqueta'] ?></td>
								<td><?php echo $filas['codigo'] ?></td>
								<td><?php echo $filas['producto'] ?></td>
								<td><?php echo $filas['lote'] ?></td>
								<td><?php echo $filas['vence'] ?></td>
								<td class="text-right bg-success"><?php echo $filas['empaquesWms'] ?></td>
								<td class="text-right bg-danger"><?php echo $filas['empaquesCliente'] ?></td>
								<td class="text-right "><?php echo $filas['empaquesFisico'] ?></td>
								<td class="text-right bg-success tamano"><?php echo $filas['diferEmpaWmsFisico'] ?></td>
								<td class="text-right bg-danger tamano"><?php echo $filas['diferEmpaClieFisico'] ?></td>
								<td class="text-right bg-info"><?php echo $filas['unidadesWms'] ?></td>
								<td class="text-right bg-danger"><?php echo $filas['unidadesCliente'] ?></td>
								<td class="text-right "><?php echo $filas['unidadesFisico'] ?></td>
								<td class="text-right bg-success tamano"><?php echo $filas['diferUniWmsFisico'] ?></td>
								<td class="text-right bg-danger tamano"><?php echo $filas['diferUniClieFisico'] ?></td>
								<td class="icono">
								</td>
							</tr>
						<?php } ?>						
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
      </article>
      
    </div>
    <!--Inicio modal nuevo-->
	<div class="form-group">
		<div class="modal fade" id="abreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h3 class="modal-title fondoLs" id="myModalLabel">Registro data ciclico</h3>
						<div class="respuesta" id="respuesta"></div>
					</div>
					<form id="formulario" class="form-horizontal" onsubmit="return agregarRegistro();">
						<div class="modal-body">
							<input type="hidden" id="id-prod" name="id-prod">
							<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
							<input type="hidden" id="proceso" name="proceso">
							<section class="modalconteos">
								<article class="ladoA">
									<div class="subladoEmp">
										<label for="" class="text-center">Empaques</label>
										<label for="">Fisico</label>
										<input type="text" class="form-control text-right" name="empaquewms" id="empaquewms" style="width:95px" value="0">
										<label for="" class="tops">Cliente</label>
										<input type="text" class="form-control text-right" name="empaquecli" id="empaquecli" style="width:95px" value="0">
									</div>	
									<div class="subladoUni">
										<label for="" class="text-center">Uniades</label>
										<label for="">Fisico</label>
										<input type="text" class="form-control text-right" name="unidwms" id="unidwms" style="width:95px" value="0">
										<label for="" class="tops">Cliente</label>
										<input type="text" class="form-control text-right" name="unidcli" id="unidcli" style="width:95px" value="0">
									</div>	
								</article>	
							</section>
							<section class="pie">
								<label for="" class="control-label ">Observaciones</label>
									<input type="text" class="form-control observa"  name="observa" id="observa">
							</section>
						</div>
						<div class="pieData bg-success">
							<div class="boton">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							<div class="submit">
								<input type="submit" value="Modificar" class="btn btn-success" id="reg" />
							</div>
						</div>
					</form>
				</div>
				<!--fin modal-content-->
			</div>
			<!--fin modal-dialog-->
		</div>
		<!--fin modal-fade-->
	</div>
	<!--Fin modal nuevo-->
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
		<script src="aplicaciones/js/conteo.js"></script>
	</div>
  </body>
</html>