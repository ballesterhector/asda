$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[0, 'asc'], [1, 'asc']],
		"lengthMenu": [[13], [13]]
	});
	autorizar();
}); //fin ready

$('#nuevo').on('click', function () {
	var nivel = document.getElementById('nivelUsuario').value;
    $('.llegar').hide();
	if (nivel <= 3) {
		$('#formulario')[0].reset();
		$('#myModalLabel').html('Registrar data');
		$('#myModalLabel').removeClass('text-danger');
		$('#myModalLabel').addClass('text-info');
		$('#reg').removeClass('btn-danger');
		$('#reg').addClass('btn-success');
		$('#proceso').val('Registro');
		$('#reg').val('Registro');
		$('.recep').hide();
		$('#reg').show();
		$('#abreModal').modal({
			show: true,
			backdrop: 'static'
		});
	} else {
		swal('Oops!', 'No tiene autorización para ingresar nueva data', 'error');
	}
});

function agregarRegistro() {
	var url = 'transferencias_Funciones.php';
	$('#reg').attr('disabled', true);
	$.ajax({
		type: 'GET',
		url: url,
		data: $('#formulario').serialize(),
		success: function (data) {
			if (data == 'Registro completado con exito') {
				$('#clos').attr('disabled', true);
				$('#respuesta').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
				let actualiza = new Promise((resolve, reject) => {
					setTimeout(function () {
						location.reload();
					}, 1000);
				});

			} else {
				$('#reg').show();
				$('#clos').show();
				$('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
				location.reload();
			}
		}
	});
	return false;
}

function transferenciaspdf() {
	swal({
			title: "<span style='color:#F8BB86'>Imprimir reporte<span>",
			text: "<small class='text-info'><h3>Indica número de transferencia</h3></small>",
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
			window.open("transferenciasHtml.php?trasfe=" + inputValue, "Reporte")
		});
}

function recepcionesEtiquetasPdf() {
	swal({
			title: "<span style='color:#F8BB86'>Imprimir etiquetas<span>",
			text: '<small class="text-info"><h3>Indica recepción</h3></small>',
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
			window.open("recepcionesEtiquetasPdf.php?recep=" + inputValue);
		});
}

function confirma(num) {
	var url = "recepciones_Funciones.php";
	$.ajax({
		type: 'GET',
		url: url,
		data: "proceso=" + 'confirmar' + '&nomPro=' + num,
		success: function (data) {
			if (data == 'Registro completado con exito') {
				$('#clos').attr('disabled', true);
				$('#respuesta').addClass('mensaje').html(data).show(200).delay(1800).hide(200);
				let actualiza = new Promise((resolve, reject) => {
					setTimeout(function () {
						location.reload();
					}, 500);
				});
			} else {
				$('#reg').show();
				$('#clos').show();
				$('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
				// location.reload();
			}
		}
	});
}

function unidades(idtrasf){
	var url = 'transferencias_Funciones.php';
	$.ajax({
		type: 'GET',
		url: url,
		data: 'transf=' + idtrasf,
		success: function (data) {
			document.location.href="transferenciaUnidades.php?transf=" + idtrasf;
		}
	});
	return false;
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