$(document).ready(function () {
    $('#dataTables').dataTable({
        "order": [[0, 'asc'], [1, 'asc']],
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
            llena = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            vacia = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            mala = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            total = api
                .column(7)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            
            // Total en esta página
            pageTotal = api
                .column(3, {
                    page: 'current'
                })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Pie de página de colmna
            $(api.column(4).footer()).html(
                llena
            );

            $(api.column(5).footer()).html(
                vacia
            );
            
            $(api.column(6).footer()).html(
                mala
            );
            
            $(api.column(7).footer()).html(
                total
            );
        }

    });
    

}); //fin ready

var usuar = document.getElementById('usuari').value;
var nivel = document.getElementById('nivelUsuario').value;
var url = 'almacenPaletas_Funciones.php';

function reportepdf(id) {
    window.open('almacenPaletasHtml.php?id_cliente=' + id, 'reporte');
}

function modal(id, niv) {
	$('#formulario')[0].reset();
	$('#reg').attr('disabled', false);
	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'Edicion' + '&idcod=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalLabel').html('Modificar data');
			$('#myModalLabel').addClass('text-danger');
			$('#proceso').val("registra");
			$('#id-prod').val(id);
            $('#client').val(datos[0]['cliente_almpale']);
            $('#Movimi').val(datos[0]['movimiento_almpale']);
            $('#document').val(datos[0]['documento_cnd_almpale']);
            $('#llenas').val(datos[0]['llenas_almpale']);
            $('#vacias').val(datos[0]['vacias_almpale']);
            $('#malas').val(datos[0]['danadas_almpale']);
            $('#arranq').val(datos[0]['arranque_almpale']);
            $('#idclie').val(datos[0]['idcliente_almpale']);

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