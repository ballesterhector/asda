$(document).ready(function () {
    autorizar();
    $('#dataTables').dataTable({
        "order": [[0, 'asc'], [2, 'desc']],
        "lengthMenu": [[13], [13]],
        
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
				.column(2)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			totalb = api
				.column(4)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			
			
			// Total en esta página
			pageTotal = api
				.column(1, {
					page: 'current'
				})
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			// Pie de página de colmna
			$(api.column(2).footer()).html(
				total
			);

			$(api.column(4).footer()).html(
				totalb
			);
		}
    });
    
}); //fin ready

var url = 'suministros_Funciones.php';

function rubros() {
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
                $('#respuesta').addClass('mensajeError').html('Registro no procesado').show(200).delay(10500).hide(200);
            }
        }
    });
    return false;
}

function clases() {
    $('#reg').attr('disabled', true);
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario1').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                $('#clos').attr('disabled', true);
                $('#respuesta').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
                setTimeout('location.reload()', 1000);
            } else {
                $('#reg').attr('disabled', false)
                $('#respuesta').addClass('mensajeError').html('Registro no procesado').show(200).delay(1500).hide(200);
            }
        }
    });
    return false;
}

function subclase() {
    $('#reg').attr('disabled', true);
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario2').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                $('#clos').attr('disabled', true);
                $('#respuesta').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
                setTimeout('location.reload()', 1000);
            } else {
                $('#reg').attr('disabled', false)
                $('#respuesta').addClass('mensajeError').html('Registro no procesado').show(200).delay(1500).hide(200);
            }
        }
    });
    return false;
}

function compra() {
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                $('#reg').hide();
                $('#respuesta').addClass('mensaje').html(data).show(200).delay(900).hide(200);
                let actualiza = new Promise((resolve, reject) => {
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                });
            } else {
                $('#reg').show();
                $('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
            }
        }
    });
    return false;
}

function facturas() {
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                $('#reg').attr("disabled", true);
                $('#close').attr("disabled", true);
                $('#edi').attr("disabled", true);
                $('#respuesta').addClass('mensaje').html(data).show(200).delay(2500).hide(200);
                let actualiza = new Promise((resolve, reject) => {
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                });
            } else {
                $('#reg').show();
                $('#clos').show();
                $('#respuesta').addClass('mensajeError').html(data).show(200).delay(2500).hide(200);
            }
        }
    });
    return false;
}

function modal(id) {
    $('#formulario')[0].reset();
    var url = 'suministros_Funciones.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=' + 'transportes' + '&id=' + id,
        success: function (valores) {
            var datos = eval(valores);
            $('#myModalLabel').html('Modificar data');
            $('#myModalLabel').addClass('text-danger');
            $('#proceso').val("Modifica");

            $('#abreModal').modal({
                show: true,
                backdrop: 'static'
            });

        }
    });
    return false;
}

function insumos(fac) {
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=' + 'confirmar' + '&id=' + fac,
        success: function () {
            document.location = 'suministrosCompras.php?clibus=' + fac;
        }
    });
    
    
}

$('#rubro').on('change', function () {
    var data = document.getElementById('rubro').value;
    var str = ("000000000" + data).slice(-4) ;
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=' + 'rubroselect' + '&dato=' + data,
        success: function (valores) {
            var datos = eval(valores);
            if (datos[0]['sumirubro'] == str) {
                swal({
                    title: "Ooops!",
                    text: "El rubro " + data + " indicado ya se encuentra asignado",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Enterado",
                    closeOnConfirm: false
                },
                function () {
                    location.reload();
                });
            }
        }
    });
});

$('#clase').on('change', function () {
    var data = document.getElementById('clase').value;
    var str = ("000000000" + data).slice(-4) ;
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=' + 'claseselect' + '&dato=' + data,
        success: function (valores) {
            var datos = eval(valores);
            if (datos[0]['sumiclase'] == str) {
                swal({
                    title: "Ooops!",
                    text: "La clase " + data + " indicada ya se encuentra asignada",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Enterado",
                    closeOnConfirm: false
                },
                function () {
                    location.reload();
                });
            }
        }
    });
});

function autorizar() {
    var nivel = document.getElementById('nivelUsuario').value;
    if (nivel != 1 & nivel != 5) {
        swal("No autorizado!", "Su nivel no lo autoriza para ingresar a este proceso.", "error");
        let actualiza = new Promise((resolve, reject) => {
            setTimeout(function () {
                document.location.href = "index_Entrada.php";
            }, 1800);
        });
    }
}
