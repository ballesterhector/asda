$(document).ready(function () {
    $('#dataTables').dataTable({
        "order": [[2, 'asc']],
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
            empaq = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            unid = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            kilo = api
                .column(7)
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
                empaq
            );

            $(api.column(6).footer()).html(
                unid
            );
            
             $(api.column(7).footer()).html(
                kilo
            );
        }

    });
    

}); //fin ready

var usuar = document.getElementById('usuari').value;
var nivel = document.getElementById('nivelUsuario').value;
var idclie = document.getElementById('idclien').value;

$('#cliBusca').on('change', function () {
    var numClie = document.getElementById('cliBusca').value;
    document.location = 'inventarioDisponibleLote.php?id_cliente=' + numClie;
});

function inventarioExcel() {
    var dat_Clien = idclie;
    document.location.href = ("inventarioDisponibleLoteExcel.php?id_cliente=" + dat_Clien);
}

function inventariopdf() {
    var data_Clien = idclie;
    window.open('inventarioDisponibleLotePdf.php?id_cliente=' + data_Clien, 'reporte');
}
