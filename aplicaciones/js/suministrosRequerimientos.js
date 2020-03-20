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

function insumos(fac) {
   document.location = 'suministrosRequerimientos.php?pedido=' + fac;
}

function asigna(ped) {
   document.location = 'suministrosAsignaciones.php?idpedido=' + ped;
}

function pedido() {
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                $('#reg').hide();
                $('#respuesta').addClass('mensaje').html(data).show(200).delay(900).hide(200);
                setTimeout('location.reload()', 1000);
                
            } else {
                $('#reg').show();
                $('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
            }
        }
    });
    return false;
}


function autorizar() {
    var nivel = document.getElementById('nivelUsuario').value;
    if (nivel !=1 & nivel !=2 & nivel != 5) {
        swal("No autorizado!", "Su nivel no lo autoriza para ingresar a este proceso.", "error");
        let actualiza = new Promise((resolve, reject) => {
            setTimeout(function () {
                document.location.href = "index_Entrada.php";
            }, 1800);
        });
    }
}
