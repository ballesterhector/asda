$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[0, 'desc'], [1, 'asc']],
		"lengthMenu": [[40], [40]]
	});
}); //fin ready

function modal(id, niv) {
	$('#formulario')[0].reset();
	$('#reg').attr('disabled', false);
	$('#name').attr('disabled', true);
	var url = 'recepciones_Funciones.php';

	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'Edicion' + '&nomPro=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalLabel').html('Modificar data');
			$('#myModalLabel').addClass('text-danger');
			$('.recep').show();
			$('#proceso').val("Modifica");
			$('#reg').val('Modificar');
			$('#reg').addClass('btn-danger');
			$('#id-prod').val(id);
			$('#name').val(datos[0]['cliente_recep']);
			$('#transp').val(datos[0]['transport_recep']);
			$('#conduct').val(datos[0]['conductor_recep']);
			$('#vehicu').val(datos[0]['vehiculo_recp']);
			$('#trailer').val(datos[0]['trailer_recp']);
			$('#contenedor').val(datos[0]['vehiculo_contenedor_recp']);
			$('#origen').val(datos[0]['ciudad_origen']);
			$('#clieorig').val(datos[0]['cliente_origen']);
			$('#precint').val(datos[0]['vehiculo_precinto_recp']);
			$('#tempera').val(datos[0]['temperatura_rece']);
			$('#pesocarga').val(datos[0]['kilos_transportados']);
			$('#unidades').val(datos[0]['unidades_transportadas']);
			$('#paletas').val(datos[0]['paletas_ingreso']);
			$('#llenas').val(datos[0]['paleta_llena']);
			$('#vacia').val(datos[0]['paleta_vacia']);
			$('#mala').val(datos[0]['paleta_mala']);
			$('#cobrar').val(datos[0]['valido_contabili']);
			$('#granel').val(datos[0]['a_granel']);
			$('#solopaleta').val(datos[0]['solo_paletas']);
			$('#movimiento').val(datos[0]['movimient_recep']);
			$('#recepci').val(datos[0]['num_recep']);
			$('#recepfecha').val(datos[0]['fecha_recep']);
			$('#factura').val(datos[0]['documento_clie_recep']);
			$('#factfecha').val(datos[0]['fecha_document_cliente']);
			$('#llegada').val(datos[0]['vehiculo_llegada_recp']);
			$('#horallegada').val(datos[0]['vehiculohora_llegada_recp']);
			$('#observa').val(datos[0]['observac_recep']);


			if (niv > 2) {
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

function modificarData() {
	var paletas = parseInt(document.getElementById('paletas').value);
	var llenas = parseInt(document.getElementById('llenas').value);
	var vacias = parseInt(document.getElementById('vacia').value);
	var malas = parseInt(document.getElementById('mala').value);
	var suma = paletas - (llenas + vacias + malas);
	if (suma != 0) {
		swal("Oops!", "La cantidad de paletas registradas es incorrecta", "error");
		$('#paletas').css('background-color', '#cef5ce');
		$('#llenas').css('background-color', '#cef5ce');
		$('#vacia').css('background-color', '#cef5ce');
		$('#mala').css('background-color', '#cef5ce');
		return false;
	} else {
		var url = 'recepciones_Funciones.php';
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
					$('#respuesta').addClass('mensajeError').html('prueba de asda').show(200).delay(1500).hide(200);
				}
			}
		});
		return false;
	}
}

$('#nuevo').on('click', function () {
	var nivel = document.getElementById('nivelUsuario').value;
	if (nivel == 1 || nivel == 2) {
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
		$('.recep').hide();
		$('#arranq').attr('readonly', true);
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
	var url = 'recepciones_Funciones.php';
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

function recepcionpdf() {
	swal({
			title: "<span style='color:#F8BB86'>Imprimir reporte<span>",
			text: "<small class='text-info'><h3>Indica número de recepción</h3></small>",
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
			window.open("recepcionesHtml.php?numRecep=" + inputValue, "Reporte")
		});
}

function recepciondevolucionespdf() {
	swal({
			title: "<span style='color:#F8BB86'>Imprimir reporte<span>",
			text: "<small class='text-info'><h3>Indica número de recepción</h3></small>",
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
			window.open("recepcionesdevolucionHtml.php?numRecep=" + inputValue, "Reporte")
		});
}

function ftp() {
	swal({
			title: "<span style='color:#F8BB86'>Transferir data<span>",
			text: '<small class="text-info"><h3>Indica recepción a transferir</h3></small>',
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
			document.location.href = "recepcionesFtpBurger.php?recep=" + inputValue;
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

function completarRecep() {
	swal({
			title: "<span style='color:#F8BB86'>Imprimir reportes<span>",
			text: '<small class="text-info"><h3>Indica número de recepción</h3></small>',
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
				return false
			}
			//window.open("recepciones_etiqueta_pdf.php?recepcion=" + inputValue, "Reporte");
			var url = "recepciones_Funciones.php";
			$.ajax({
				type: "GET",
				url: url,
				data: "proceso=" + "dataRecepcion" + "&recep=" + inputValue,
				success: function (valores) {
					var datos = eval(valores);
					var idcli = datos[0]['idcliente'];
					var fecharec = datos[0]['fecha'];
					var f = new Date();
					var hoy = (f.getDate() + "/" + 0 + (f.getMonth() + 1) + "/" + f.getFullYear());
					if (fecharec >= hoy) {
						document.location = "recepciones_BajarCodigos.php?id_recepcodigo=" + inputValue + "&id=" + idcli;
					} else {
						alert('La recepción no es de este día');
					}
				}
			});
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

function activar() {
	swal({
			title: "<span style='color:#F8BB86'>Insertar data a base de datos<span>",
			text: "<small class='text-info'><h3>Indica el nuevo tipo de seguro</h3></small>",
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
				return false
			}
			var url = 'recepciones_F	unciones.php';
			$.ajax({
				type: 'GET',
				url: url,
				data: 'proceso=' + 'activacion' + '&numRecep=' + inputValue,
				success: function (repuesta) {
					if (repuesta == 'Registro completado con exito') {
						swal("Proceso ejecutado", "recepción  " + inputValue + " activada en base de datos", "success");
						setInterval("location.reload()", 2500);
					} else {
						swal.showInputError("<small class='text-danger'>Fecha de recepción " + inputValue + " se encuentra fuera de rango</small>");
						return false
					}
				}
			});
		});
}

$('#unidad').on('change',function(){
    var etiqu = document.getElementById('etiquet').value;
    var pedida = document.getElementById('unidad').value;
    $('#totalUnidades').val(etiqu*pedida);
});

