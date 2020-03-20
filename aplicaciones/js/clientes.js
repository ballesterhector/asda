$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[7, 'asc'],[0, 'asc']],
		"lengthMenu": [[10], [10]]
	});
}); //fin ready
var nivel = document.getElementById('nivelUsuario').value;
var usua = document.getElementById('modificador').value;
var url = 'clientes_Funciones.php';

function modal(id, niv) {
	$('#formulario')[0].reset();
	$('#myModalLabel').html('Datos del usuario');
	$('#titulo').removeClass('text-danger');
	$('#titulo').addClass('text-info');
	$('#reg').attr('disabled', false);
	$('#arranq').attr('readonly', true);

	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'Edicion' + '&nomCli=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalLabel').html('Modificar data');
			$('#myModalLabel').addClass('text-danger');
			$('#proceso').val("Modifica");
			$('#id-prod').val(id);
			$('#name').val(datos[0]['nombre_cli']);
			$('#rif').val(datos[0]['rif_cliente']);
			$('#direcc').val(datos[0]['direci_cli']);
			$('#contacto').val(datos[0]['contacto']);
			$('#telef').val(datos[0]['telefono_cli']);
			$('#email').val(datos[0]['email_cliContacto']);
			$('#teleContacto').val(datos[0]['telef_cliContacto']);
			$('#tolera').val(datos[0]['kilos_tolerancia']);
			$('#paleta').val(datos[0]['kilos_paleta_cli']);
			$('#contratada').val(datos[0]['paletas_contratada_cli']);
			$('#bloqueo').val(datos[0]['bloqueo_automa_cli']);
			$('#arranq').val(datos[0]['arranque_cli']);
			$('#estado').val(datos[0]['estatus_cli']);
			$('#observ').val(datos[0]['observ_cli']);

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

function modificarCliente() {
	$('#reg').attr('disabled', true);
	$.ajax({
		type: 'GET',
		url: url,
		data: $('#formulario').serialize(),
		success: function (data) {
			if (data == 'Registro completado con exito') {
				$('#clos').attr('disabled', true);
				$('#respuesta').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
				setTimeout('location.reload()', 1000);
			} else {
				$('#reg').attr('disabled', false)
				$('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
			}
		}
	});
	return false;
}

$('#nuevo').on('click', function () {
	$('.toler').hide();
	if (nivel > 3) {
		swal('Oops!', 'No tiene autorización para ingresar nueva data', 'error');

	} else {
		$('#formulario')[0].reset();
		$('#titulo').val('Registrar');
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
	}
});

/*Pagina clientes modificaciones*/
$('#cliBusca').on('change', function () {
	var numClie = document.getElementById('cliBusca').value;
	document.location = 'clientesModificaciones.php?clibus=' + numClie;
});

function excel() {
	var nCli = document.getElementById('nCliente').value;
	if (nCli == 0) {
		swal('Favor', 'Ingrese el cliente');
		$('#cliBusca').css('background-color', '#88FF88');
		return false;
	} else {
		document.location = 'clientesModificacionesExcel.php?clibus=' + nCli;
		event.preventDefault();
		document.location = 'clientesModificacionesExcel.php?clibus=' + nCli;
	}
}

function arranque() {
	if (nivel > 3) {
		swal('Oops!', 'No tiene autorización para modificar data', 'error');
	} else {
		swal({
			title: "Esta usted seguro?",
			text: "Esta acción bloqueará la data actual y no podrá utilizarla en ningún proceso",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Si, ejecutelo",
			cancelButtonText: "No, cancelelo",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function (isConfirm) {
			if (isConfirm) {
				swal({
					title: "<span style='color:#F8BB86'>Actualizar arranque<span>",
					text: "<small class='text-info'><h3>Indica número del cliente</h3></small>",
					type: "input",
					showCancelButton: true,
					closeOnConfirm: true,
					animation: "slide-from-top",
					inputPlaceholder: "Write something",
					html: true
				},
				function (inputValue) {
					if (inputValue === false) return false;

					if (inputValue === "") {
						swal.showInputError("<small class='text-danger'>No has ingresado ninguna data</small>");
						return false
					}
					
					$.ajax({
						type: 'GET',
						url: url,
						data: 'proceso=' + 'arranque' + '&numCli=' + inputValue + '&usuar=' + usua,
						success: function (repuesta) {
							if (repuesta == 'Registro completado con exitonull') {
								swal("Proceso ejecutado", "Arranque actualizado al cliente N° " + inputValue + " inicie proceso de conteo", "success");
								setInterval("location.reload()", 2500);
							} else {
								swal.showInputError("<small class='text-danger'>Arranque no actualizado al cliente N° " + inputValue + " </small>");
								return false
							}
						}
					});
				});
			} else {
				swal("Cancelado", "No se ha efectuado ninguna actualización", "error");
			}
		});
	}
}
