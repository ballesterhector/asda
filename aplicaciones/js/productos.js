$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[0, 'asc']],
		"lengthMenu": [[13], [13]]
	});
	autorizar();
}); //fin ready

function modal(id,niv) {
	$('#formulario')[0].reset();
	$('#reg').attr('disabled', false);
	var url = 'productos_Funciones.php';

	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'Edicion' + '&nomPro=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalLabel').html('Modificar data');
			$('#myModalLabel').addClass('text-danger');
			$('#codigo').attr('disabled', true);
			$('#name').attr('disabled', true);
			$('#proceso').val("Modifica");
			$('#reg').val('Modificar');
			$('#reg').addClass('btn-danger');
			$('#id-prod').val(id);
			$('#name').val(datos[0]['cliente_prod']);
			$('#codigo').val(datos[0]['codigo_prod']);
			$('#producto').val(datos[0]['descrip_prod']);
			$('#presenta').val(datos[0]['presen_prod']);
			$('#familia').val(datos[0]['familia_prod']);
			$('#tipo').val(datos[0]['tipo_prod']);
			$('#alimento').val(datos[0]['es_alimento']);
			$('#tolera').val(datos[0]['tolerancia_prod']);
			$('#ubicaci').val(datos[0]['almacen_prod']);
			$('#enkilo').val(datos[0]['ingreso_en_kilos']);
			$('#cesta').val(datos[0]['control_cestapaleta']);
			$('#neto').val(datos[0]['peso_neto']);
			$('#bruto').val(datos[0]['peso_bruto']);
			$('#unidades').val(datos[0]['unidades_empaque']);
			$('#pesounidad').val(datos[0]['peso_unidad']);
			$('#unidXpeso').val(datos[0]['totPesoUnidad']);
			$('#camada').val(datos[0]['camadas_prod']);
			$('#ruma').val(datos[0]['rumas_prod']);
			$('#empaque').val(datos[0]['empaques']);
			$('#estado').val(datos[0]['estado_prod']);

			if (niv > 3) {
				swal("Oops!", "Su nivel de usuario no le autoriza la actualización de la data", "error");
			} else {
				$('#abreModal').modal({
					show: true,
					backdrop: 'static'
				});
			}
		}
	});
}

function modificarData() {
	var url = 'productos_Funciones.php';
	$('#reg').attr('disabled', true);
	$.ajax({
		type: 'GET',
		url: url,
		data: $('#formulario').serialize(),
		success: function (data) {
			if (data == 'Registro completado con exito') {
				$('#clos').attr('disabled', true);
				$('#respuesta').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
				setTimeout('location.reload()', 1600);
			} else {
				$('#reg').attr('disabled', false)
				$('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
			}
		}
	});
	return false;
}

$('#nuevo').on('click', function () {
	var nivel = document.getElementById('nivelUsuario').value;
	if (nivel <= 3) {
		$('#formulario')[0].reset();
		$('#myModalLabel').html('Registrar data');
		$('#myModalLabel').removeClass('text-danger');
		$('#myModalLabel').addClass('text-info');
		$('#reg').removeClass('btn-danger');
		$('#reg').addClass('btn-success');
		$('#codigo').attr('disabled', false);	
		$('#proceso').val('Registro');
		$('#reg').val('Registro');
		$('#name').attr('disabled', false);
		$('#edi').hide();
		$('#arranq').attr('readonly', true);
		$('#reg').show();
		$('#abreModal').modal({
			show: true,
			backdrop: 'static'
		});
	} else {
		swal('Oops!', 'No tiene autorización para ingresar nueva data','error');
	}
});

$('#cliBusca').on('change',function(){
	var numClie = document.getElementById('cliBusca').value;
	document.location='productos.php?clibus=' + numClie;
});

$('#cliBuscamodificaciones').on('change',function(){
	var numClie = document.getElementById('cliBuscamodificaciones').value;
	document.location='productosModificaciones.php?clibus=' + numClie;
});

function excel() {
	var nCli = document.getElementById('nCliente').value;
	if (nCli == 0) {
		swal('Favor', 'Ingrese el cliente');
		$('#cliBusca').css('background-color', '#88FF88');
		return false;
	} else {
		document.location = 'productosExcel.php?clibus=' + nCli;
		
	}
}

function excelModificaciones() {
	var nCli = document.getElementById('nCliente').value;
	if (nCli == 0) {
		swal('Favor', 'Ingrese el cliente');
		$('#cliBusca').css('background-color', '#88FF88');
		return false;
	} else {
		document.location = 'productosModificacionesExcel.php?clibus=' + nCli;
		event.preventDefault();
		document.location = 'productosModificacionesExcel.php?clibus=' + nCli;
	}
}

function autorizar() {
	var nivel = document.getElementById('nivelUsuario').value;
	if (nivel > 3) {
		swal("No autorizado!", "Su nivel no lo autoriza para ingresar a este proceso.", "error");
		let actualiza = new Promise((resolve, reject) => {
			setTimeout(function () {
				document.location.href = "index_Entrada.php";
			}, 1800);
		});
	}
}
