$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[0, 'asc']],
		"lengthMenu": [[10], [10]]
	});
	autorizar();

}); //fin ready

function modal(id,niv) {
	$('#formulario')[0].reset();
	$('#reg').attr('disabled', false);
	$('#rif').attr('disabled', true);
	$('.estad').show();
	var url = 'transportes_Funciones.php';

	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'transportes' + '&id=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalLabel').html('Modificar data');
			$('#myModalLabel').addClass('text-danger');
			$('#proceso').val("Modifica");
			$('#reg').val('Modificar');
			$('#reg').addClass('btn-danger');
			$('#id-prod').val(id);
			$('#transp').val(datos[0]['nombre_trans']);
			$('#rif').val(datos[0]['rif_transp']);
				if(datos[0]['transEstado']==1){
					$('#estado').css('background','rgba(234, 212, 226, 0.83)').css('color','#fa4848');
				}else{
					$('#estado').css('background','#fff').css('color','#0a29d1');
				}
			$('#estado').val(datos[0]['transEstado']);
			
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
	$('.estad').hide();
	if (nivel <= 3) {
		$('#formulario')[0].reset();
		$('#myModalLabel').html('Registrar data');
		$('#myModalLabel').removeClass('text-danger');
		$('#myModalLabel').addClass('text-info');
		$('#reg').removeClass('btn-danger');
		$('#reg').addClass('btn-success');
		$('#proceso').val('Registro');
		$('#rif').attr('disabled', false);
		$('#reg').val('Registro');
		$('#estad').hide();
		$('#abreModal').modal({
			show: true,
			backdrop: 'static'
		});
	} else {
		swal('Oops!', 'No tiene autorización para ingresar nueva data', 'error');
	}
});

function agregarRegistro() {
	var url = 'transportes_Funciones.php';
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
				$('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
			}
		}
	});
	return false;
}

function conductorEstado() {
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