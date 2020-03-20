$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[1, 'asc'], [0, 'des']],
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
			total = api
				.column(6)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			totalb = api
				.column(7)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			totalc = api
				.column(8)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			totald = api
				.column(9)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			totale = api
				.column(10)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			totalf = api
				.column(11)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);



			// Total en esta página
			pageTotal = api
				.column(5, {
					page: 'current'
				})
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			// Pie de página de colmna
			$(api.column(6).footer()).html(
				total
			);

			$(api.column(7).footer()).html(
				totalb
			);

			$(api.column(8).footer()).html(
				totalc
			);

			$(api.column(9).footer()).html(
				totald
			);

			$(api.column(10).footer()).html(
				totale
			);

			$(api.column(11).footer()).html(
				totalf
			);
		}
	});
	autorizar();

	//para el select anidado
	//verificamos cuando cambie el cliente
	$('#cliBusca').change(function () {
		$('#cliBusca option:selected').each(function () {
			idcliente = $(this).val();
			identific = document.getElementById('data').value;
			$.get("ciclicoDataAnidada_Funciones.php", {
				id_cliente: idcliente,
			}, function (data) {
				$('#data').html(data)
			});
		});
	});


}); //fin ready

var url = 'ciclicoData_Funciones.php';
var usuar = document.getElementById('usuari').value;

$('#data').on('change', function () {
	var numClie = document.getElementById('cliBusca').value;
	var date = document.getElementById('data').value;
	document.location = 'ciclicoData.php?clibus=' + numClie + '&identificador=' + date;
});

function data() {
	swal({
			title: "<span style='color:#F8BB86'>Generar data para ciclicos<span>",
			text: "<small class='text-info'><h3>Indica el número de cliente</h3></small>",
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
				data: 'proceso=' + 'generar' + '&idcliente=' + inputValue + '&usuario=' + usuar,
				success: function (repuesta) {
					if (repuesta == 'Registro completado con exito') {
						swal("Proceso ejecutado", "Data " + inputValue + " actualizada en base de datos", "success");
						setInterval("location.reload()", 2500);
					} else {
						swal.showInputError("<small class='text-danger'>La data " + inputValue + " ya existe en base de datos</small>");
						return false
					}
				}
			});
		});
}

function modal(id, niv) {
	$('#formulario')[0].reset();
	$('#reg').attr('disabled', false);
	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'Edicion' + '&idcicli=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalLabel').html('Modificar data');
			$('#myModalLabel').addClass('text-danger');
			$('#proceso').val("registra");
			$('#id-prod').val(id);

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

function agregarRegistro() {
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
				$('#reg').show();
				$('#clos').show();
				$('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
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

function ciclicodatapdf() {
	swal({
		title: "<span style='color:#F8BB86'>Imprimir reporte<span>",
		text: "<small class='text-info'><h3>Indica código identificador del ciclico</h3></small>",
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
		window.open("ciclicoDataHtml.php?codigo=" + inputValue, "Reporte")
	});
}

function cerrar() {
	swal({
		title: "<span style='color:#F8BB86'>Generar data para ciclicos<span>",
		text: "<small class='text-info'><h3>Indica código identificador del ciclico</h3></small>",
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
			data: 'proceso=' + 'cerrar' + '&identifi=' + inputValue + '&cierra=' + usuar,
			success: function (repuesta) {
				if (repuesta == 'Registro completado con exito') {
					swal("Proceso ejecutado", "Data " + inputValue + " actualizada en base de datos", "success");
					setInterval("location.reload()", 1500);
				} else {
					swal.showInputError("<small class='text-danger'>La data " + inputValue + " no actualizada</small>");
					return false
				}
			}
		});
	});
}

