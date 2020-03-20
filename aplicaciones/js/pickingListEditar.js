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
            empaq = api
                .column(9)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            unid = api
                .column(10)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            kilo = api
                .column(11)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total en esta página
            pageTotal = api
                .column(6, {
                    page: 'current'
                })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Pie de página de colmna
            $(api.column(9).footer()).html(
                empaq
            );

            $(api.column(10).footer()).html(
                unid
            );
            
             $(api.column(11).footer()).html(
                kilo
            );
        }

    });
    

}); //fin ready


function ajuste(id) {
    $('#formulario')[0].reset();
    $('#reg').attr('disabled', false);
    $.ajax({
        type: 'GET',
        url: 'pickingList_Funciones.php',
        data: 'proceso=' + 'ajustereti' + '&numevol=' + id,
        success: function (valores) {
            var datos = eval(valores);
            $('#myModalLabel').html('Editar data');
            $('#myModalLabel').addClass('text-danger');
            $('#proceso').val("ajustaretiqueta");
            $('#id-prod').val(datos[0]['idevol']);
            $('#etique').val(datos[0]['etiquetaEvol']);
            $('#unidad').val(datos[0]['unidades']);
            $('#empaqu').val(datos[0]['empaques']);
           $('#abreModal').modal({
                    show: true,
                    backdrop: 'static'
                });
        }
    });
}

$('#unidajuste').on('change', function () {
    var unidb = parseFloat(document.getElementById('unidad').value);
    var uniajdb = parseFloat(document.getElementById('unidajuste').value);
    if (uniajdb>=unidb || uniajdb<0) {
        swal('Data errada!', 'El valor a ajustar es incorrecto', 'error');
        $('#unidajuste').val(0);
    }
});


function modificarData() {
    var url = 'pickingList_Funciones.php';
    $('#reg').attr('disabled', true);
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                $('#clos').attr('disabled', true);
                $('#respuesta').addClass('mensaje').html(data).show(200).delay(1000).hide(200);
                location.reload();
            } else {
                $('#reg').attr('disabled', false)
                $('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
            }
        }
    });
    return false;
}

$('#anulacion').on('click',function(){
    if ($('#anular').val() == '') {
        alert('Indique el número de picking list a anular en forma masiva')
    }else if ($('#motiv').val() == '') {
        alert('Indique el motivo de la anulación')
    }else{
        var url = 'pickingList_Funciones.php';
        var pick = document.getElementById('anular').value;
        var motiv = document.getElementById('motiv').value;
        var usua = document.getElementById('usuari').value;
        $('#reg').attr('disabled', true);
        $.ajax({
            type: 'GET',
            url: url,
             data: 'proceso=' + 'anulamasivo' + '&pick=' + pick + '&usua=' + usua + '&motiv=' + motiv,
            success: function (data) {
                if (data == 'Registro completado con exito') {
                    $('#clos').attr('disabled', true);
                    $('#respuesta').addClass('mensaje').html(data).show(200).delay(1000).hide(200);
                    location.reload();
                } else {
                    $('#reg').attr('disabled', false)
                    $('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
                }
            }
        });
        return false;
  }  
});
