$(document).ready(function () {
    $('#dataTables').dataTable({
        "order": [[1, 'asc']],
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
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            vacia = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            mala = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            total = api
                .column(5)
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
                llena
            );

            $(api.column(3).footer()).html(
                vacia
            );

            $(api.column(4).footer()).html(
                mala
            );

            $(api.column(5).footer()).html(
                total
            );
        }

    });


}); //fin ready

var usuar = document.getElementById('usuari').value;
var nivel = document.getElementById('nivelUsuario').value;
var url = 'almacenPaletas_Funciones.php';

function resumen(idcli) {
    document.location.href = ('almacenPaletas.php?id_cliente=' + idcli);
}

function inventarioExcel() {
    var dat_Clien = idclie;
    document.location.href = ("inventarioTeoricoCodigoExcel.php?id_cliente=" + dat_Clien);
}

function reportepdf() {
    window.open('almacenPaletasResumenHtml.php', 'reporte');
}

$('#nuevo').on('click', function () {
    if (nivel > 3) {
        swal('Oops!', 'No tiene autorización para ingresar nueva data', 'error');
    } else {
        $('#formulario')[0].reset();
        $('#proceso').val('Registro');
        
        $('#abreModal').modal({
            show: true,
            backdrop: 'static'
        });
    }
});

function agregarRegistro(){
    var url = 'almacenPaletas_Funcion.php';
	$.ajax({
		type:'GET',
		url:url,
		data:$('#formulario').serialize(),
		success: function(data){
			if (data=='Registro completado con exito') {
				$('#reg').attr("disabled", true);
				$('#close').attr("disabled", true);
				$('#edi').attr("disabled", true);
				$('#alerta').addClass('mensaje').html(data).show(200).delay(2500).hide(200);
				let actualiza= new Promise((resolve, reject) => {
                   setTimeout(function(){
                        location.reload();
                    }, 1000);
                });
			}else {
				$('#reg').show();
				$('#clos').show();
				$('#alerta').addClass('mensajeError').html(data).show(200).delay(2500).hide(200);
			}
		}
	});
	return false;
}
