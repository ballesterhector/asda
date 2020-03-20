<?php
	require '../aplicaciones/php/session_start.php';
	
	require '../conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['id_cliente']."')");
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
		<link rel="stylesheet" type="text/css" href="../aplicaciones/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../aplicaciones/css/bootstrap-submenu.min.css">
		<link rel="stylesheet" type="text/css" href="../aplicaciones/font-awesome/css/fontawesome-all.css">
		<link rel="stylesheet" type="text/css" href="../aplicaciones/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="../aplicaciones/css/sweetalert.css">
		<link rel="stylesheet" type="text/css" href="../aplicaciones/css/estilosFlex.css">
	</head>
  <body>
    <header>
		<input type="hidden" value="<?php echo $_GET['id_cliente'] ?>" id="idclien">
		<input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
		<input type="hidden" id="usuari" value="<?php echo $usuario ?>">
		<div class="menu">
			<div class="logo">
				<a href="#"><img src="../aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
			</div>
			<nav class="enlaces" id="enlaces">
				<?php include "../aplicaciones/nav/menuarriba.html" ?>
			</nav>
		</div>	
		<div class="enlinea">
			<div class="titulo">
				<h3 class="titulos" id="">Picking List pendientes por despachar</h3>
			</div>
			<div class="nuevo">
				<a href="#" onclick="window.open('http:../aplicaciones/ayudas/InventariosTeoricos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="javascript: onclick(inventariopdf())"><i class="fas fa-file-pdf fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte por código"></i></a>
                <a href="javascript: onclick(inventarioExcel())"><i class="fas fa-file-excel fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="archivo por código"></i></a>
            </div>
		</div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
			    <tr class="">
					<th class="text-center">Cliente</th>
					<th class="text-center">Picking</th>
					<th class="text-center">Código</th>
					<th class="text-center">Producto</th>
					<th class="text-center">Empaques</th>
					<th class="text-center">Unidades</th>
					<th class="text-center">Kilos</th>
				</tr>
			</thead>
			<tfoot>
                <tr>
                    <th colspan="4" style="text-align:right">Total:</th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                    <th class="dt-right"></th>
                </tr>
            </tfoot>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL pickinglistPorBajarSelect('0')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<tr>
                                <td><?php echo $filas['clienteEtiqueta'] ?></td>
                                <td><?php echo $filas['fechaDocumentoEvol'] ?></td>
                                <td><a href="javascript:documento(<?php echo $filas['ingDesp'] ?>,<?php echo $filas['documentoEvol'] ?>)"><?php echo $filas['documentoEvol'] ?></a></td>
                                <td><a href="javascript:documento(<?php echo $filas['pickingEvol'] ?>)"><?php echo $filas['pickingEvol'] ?></a></td>
                                <td><?php echo $filas['codigoEtiqueta'] ?></td>
                                <td><?php echo $filas['productoEtiqueta'] ?></td>
                                <td class="text-right"><?php echo $filas['empaques'] ?></td>
                                <td class="text-right"><?php echo $filas['unidades'] ?></td>
                                <td class="text-right"><?php echo $filas['kilos'] ?></td>
							</tr>
											
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
      </article>
        <nav>
		    <?php include "../aplicaciones/nav/menuizquierda.html" ?>
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
		<script src="../plantillas/bootstrap/js/jquery-1.11.1.min.js"></script>
		<script src="../plantillas/bootstrap/js/bootstrap.min.js"></script>
		<script src="../aplicaciones/js/bootstrap-submenu.min.js"></script>
		<script src="../plantillas/bootstrap/js/jquery.dataTables.min.js"></script>
		<script src="../aplicaciones/js/sweetalert.min.js"></script>
		<script src="../aplicaciones/js/jsConstantes.js"></script>
	</div>
	    
    <script type="text/javascript">
        $(document).ready(function () {
            $('#dataTables').dataTable({
                "order": [[0, 'asc'],[1, 'asc']],
                "lengthMenu": [[15], [15]],

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Eliminar el formato para obtener datos enteros para la suma
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total en todas las páginas
                    empaq = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    unid = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    kilo = api
                        .column(6)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total en esta página
                    pageTotal = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Pie de página de colmna
                    $(api.column(4).footer()).html(
                        empaq
                    );

                    $(api.column(5).footer()).html(
                        unid
                    );

                     $(api.column(6).footer()).html(
                        kilo
                    );
                }

            });


        }); //fin ready
    </script>    
  </body>
</html>