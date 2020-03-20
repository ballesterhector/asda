$(document).ready(function () {
	$('#dataTables').dataTable({
		"lengthMenu": [[10], [10]]
	});


}); //fin ready

var nivel = document.getElementById('nivelUsuario').value;

function modal(id, niv) {
	$('#formulario')[0].reset();
	$('#reg').attr('disabled', false);
	$('#estad').attr('disabled', false);
	var url = 'conductores_Funciones.php';

	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'condcutores' + '&id=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalLabel').html('Modificar data');
			$('#myModalLabel').addClass('text-danger');
			$('#proceso').val("Modifica");
			$('#reg').val('Modificar');
			$('#reg').addClass('btn-danger');
			$('#id-prod').val(id);
			$('#conduct').val(datos[0]['conductor']);
			$('#cedula').val(datos[0]['cedula_cond']);
			if (datos[0]['condestado'] == 1) {
				$('#estad').css('background', 'rgba(234, 212, 226, 0.83)').css('color', '#fa4848');
			} else {
				$('#estad').css('background', '#fff').css('color', '#0a29d1');
			}
			$('#estad').val(datos[0]['condestado']);

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
		$('#proceso').val('Registro');
		$('#reg').val('Registro');
		$('#estad').hide();
		$('#labelEstado').hide();
		$('#abreModal').modal({
			show: true,
			backdrop: 'static'
		});
	} else {
		swal('Oops!', 'No tiene autorización para ingresar nueva data', 'error');
	}
});

function agregarRegistro() {
	var url = 'conductores_Funciones.php';
	$('#reg').attr('disabled', true);
	$.ajax({
		type: 'GET',
		url: url,
		data: $('#formulario').serialize(),
		success: function (data) {
			if (data == 'Registro completado con exito') {
				$('#clos').attr('disabled', true);
				$('#respuesta').addClass('mensaje').html(data).show(200).delay(91500).hide(200);
				setTimeout('location.reload()', 1550);
			} else {
				$('#reg').attr('disabled', false);
				$('#respuesta').addClass('mensajeError').html('La cedula se encuentra registrada').show(200).delay(1500).hide(200);
			}
		}
	});
	return false;
}

function conductorEstado() {
	if (nivel > 3) {
		swal('Oops!', 'No tiene autorización para modificar data', 'error');
	} else {
		swal({
				title: "<span style='color:#F8BB86'>Actualizar estado<span>",
				text: "<small class='text-info'><h3>Indica cedula del conductor</h3></small>",
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
				var url = 'conductores_Funciones.php';
				var usua = document.getElementById('modificador').value;

				$.ajax({
					type: 'GET',
					url: url,
					data: 'proceso=' + 'estado' + '&cedul=' + inputValue + '&usuar=' + usua,
					success: function (repuesta) {
						if (repuesta == 'Registro completado con exito') {
							swal("Proceso ejecutado", "Estado de la cedula N° " + inputValue + " actualizado en base de datos", "success");
							setInterval("location.reload()", 2500);
						} else {
							swal.showInputError("<small class='text-danger'>Estado de la cedula N° " + inputValue + " no pudo ser actualizado en base de datos</small>");
							return false
						}
					}
				});

			});
	}
}
