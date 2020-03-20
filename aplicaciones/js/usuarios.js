$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[1, 'asc']],
		"lengthMenu": [[10], [10]]
	});
	
	autorizar();
}); //fin ready

function asignaNivel(id, cedu) {
	if (cedu == 5010351) {
		swal("No autorizado!", "El registro corresponde al administrador del sistema", "error");
	} else {

		swal({
				title: "<span style='color:#F8BB86'>Insertar data a base de datos<span>",
				text: "<small class='text-info'><h3>Indica el nivel de usuario a asignar</h3></small>",
				type: "input",
				showCancelButton: true,
				closeOnConfirm: false,
				animation: "slide-from-top",
				inputPlaceholder: "Write something",
				html: true
			},
			function (inputValue) {
				if (inputValue === false) return false;

				if (inputValue === "") {
					swal.showInputError("<small class='text-danger'>No has ingresado ninguna data</small>");
					return false;
				}
				if (inputValue == 1 || inputValue == 5) {
					swal.showInputError("<small class='text-danger'>El nivel " + inputValue + " solokkk puede ser asignado por el administrador del ASDA</small>");
				} else {
					var url = 'usuarios_funciones.php';
					$.ajax({
						type: 'GET',
						url: url,
						data: 'proceso=' + 'nivel' + '&ids=' + id + '&nivel=' + inputValue,
						success: function (repuesta) {
							if (repuesta == 'Registro completado con exito') {
								swal("Proceso ejecutado", "Nivel " + inputValue + " actualizada en base de datos", "success");
								setInterval("location.reload()", 1500);
							} else {
								swal.showInputError("<small class='text-danger'>El nivel " + inputValue + " solo hhhhpuede ser asignado por el administrador del ASDA</small>");
								return false;
							}
						}
					});

				}
			});
	}
}

function modificaEstado(id, cedu) {
	if (cedu == 5010351) {
		swal("No autorizado!", "El registro corresponde al administrador del sistema", "error");
	} else {
		var url = 'usuarios_funciones.php';
		$.ajax({
			type: 'GET',
			url: url,
			data: 'proceso=' + 'estado' + '&ids=' + id,
			success: function (repuesta) {
				if (repuesta == 'Registro completado con exito') {
					swal("Proceso ejecutado", "Estado actualizado en base de datos", "success");
					setInterval("location.reload()", 2500);
				} else {
					swal.showInputError("<small class='text-danger'>El nivel  solo puede ser asignado por el gerente del area</small>");
					return false;
				}
			}
		});
	}
}

function modal(num,cedu) {
	$('#formulario')[0].reset();
	$('#myModalLabel').html('Datos del usuario');
	$('#titulo').removeClass('text-danger');
	$('#titulo').addClass('text-info');
	$('#reg').show();
	var url = 'usuarios_funciones.php';

	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'modifica' + '&num=' + num,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalLabel').html('Modificar data');
			$('#myModalLabel').addClass('text-danger');
			$('#proceso').val('Registro');
			$('#id-prod').val(num);
			$('#name').val(datos[0]['nombreUsuario']);
            $('#sucursar').val(datos[0]['sucursar']);
			$('#gerencia').val(datos[0]['gerencia']);
			$('#area').val(datos[0]['area']);
            $('#email').val(datos[0]['emailUsuario']);
            $('#telefono').val(datos[0]['telefonoUsuario']);
            $('#estado').val(datos[0]['estadoUsuario']);

			if (cedu == 5010351) {
				swal("No autorizado!", "El registro corresponde al administrador del sistema", "error");
			} else {
				$('#abreModal').modal({
					show: true,
					backdrop: 'static'
				});
			}
		}
	});
}

function modificarUsuario() {
	var url = 'usuarios_funciones.php';
	$('#reg').attr('disabled', true);
	$.ajax({
		type: 'GET',
		url: url,
		data: $('#formulario').serialize(),
		success: function (data) {
			if (data == 'Registro completado con exito') {
				$('#clos').attr('disabled', true);
				$('#respuesta').addClass('mensaje').html('Registro completado').show(200).delay(91500).hide(200);
				setTimeout('location.reload()', 1550);
			} else {
				$('#reg').show();
				$('#clos').show();
				$('#respuesta').addClass('mensajeError').html('Registro no modificado').show(200).delay(1500).hide(200);
			}
		}
	});
	return false;
}

function autorizar() {
	var nivel = document.getElementById('nivelUsuario').value;
	if (nivel > 2) {
		swal("No autorizado!", "Su nivel no lo autoriza para ingresar a este proceso.", "error");
		let actualiza = new Promise((resolve, reject) => {
			setTimeout(function () {
				document.location.href = "index_Entrada.php";
			}, 1800);
		});
	}
}

