$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[0, 'asc']],
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
			wmsEmp = api
				.column(5)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			clieEmp = api
				.column(6)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			fisiEmp = api
				.column(7)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			difWmsEmp = api
				.column(8)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			difClieEmp = api
				.column(9)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			wmsUni = api
				.column(10)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			clieUni = api
				.column(11)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			fisiUni = api
				.column(12)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			difWmsUni = api
				.column(13)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			difCcliUni = api
				.column(14)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);


			// Total en esta página
			pageTotal = api
				.column(4, {
					page: 'current'
				})
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			// Pie de página de colmna
			$(api.column(5).footer()).html(
				wmsEmp
			);

			$(api.column(6).footer()).html(
				clieEmp
			);

			$(api.column(7).footer()).html(
				fisiEmp
			);

			$(api.column(8).footer()).html(
				difWmsEmp
			);

			$(api.column(9).footer()).html(
				difClieEmp
			);

			$(api.column(10).footer()).html(
				wmsUni
			);

			$(api.column(11).footer()).html(
				clieUni
			);

			$(api.column(12).footer()).html(
				fisiUni
			);

			$(api.column(13).footer()).html(
				difWmsUni
			);

			$(api.column(14).footer()).html(
				difCcliUni
			);
            
		}
         
	});
	autorizar();
    cerradocodig();
	//para el select anidado
	//verificamos cuando cambie el cliente
	$('#cliBusca').change(function () {
		$('#cliBusca option:selected').each(function () {
			idcliente = $(this).val();
			identific = document.getElementById('data').value;
			$.get("conteoDataAnidada_Funciones.php", {
				id_cliente: idcliente,
			}, function (data) {
				$('#data').html(data)
			});
		});
	});


}); //fin ready

var url = 'conteo_Funciones.php';
var usuar = document.getElementById('usuari').value;
var nivel = document.getElementById('nivelUsuario').value;


$('#data').on('change', function () {
	var numClie = document.getElementById('cliBusca').value;
	var date = document.getElementById('data').value;
    document.location = 'conteo.php?clibus=' + numClie + '&identificador=' + date;
});

function data() {
	if (nivel > 2) {
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
						title: "<span style='color:#F8BB86'>Generar data para conteos<span>",
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
                                setInterval("location.reload()", 2500);
                            }
						});
					});
			} else {
				swal("Cancelado", "No se ha efectuado ninguna actualización", "error");
			}
		});
	}
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
			$('#empaquewms').val(datos[0]['empaquesFisico']);
			$('#empaquecli').val(datos[0]['empaquesCliente']);
			$('#unidwms').val(datos[0]['unidadesFisico']);
			$('#unidcli').val(datos[0]['unidadesCliente']);
			$('#observa').val(datos[0]['observacion']);

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
				$('#respuesta').addClass('mensaje').html(data).show(200).delay(2500).hide(200);
				setTimeout('location.reload()', 1550);
			} else {
				$('#reg').show();
				$('#clos').show();
				$('#respuesta').addClass('mensajeError').html(data).show(200).delay(2500).hide(200);
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
			text: "<small class='text-info'><h3>Indica código identificador del conteo</h3></small>",
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
			window.open("conteoPdf.php?codigo=" + inputValue, "Reporte")
		});
}

function cerrar() {
	if (nivel > 2) {
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
						title: "<span style='color:#F8BB86'>Generar nuevo arranque>",
						text: "<small class='text-info'><h3>Indica código identificador del conteo</h3></small>",
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
								setInterval("location.reload()", 500);
							}
						});
					});
			} else {
				swal("Cancelado", "No se ha efectuado ninguna actualización", "error");
			}
		});
	}
}

function cerradocodig(){
    var cierra = document.getElementById('cerradodata').value;
  if(cierra==1){
        $('#cerradocodig').hide();  
   }else {
         $('#cerradocodig').show();  
   } 
}



