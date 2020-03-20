$(document).ready(function () {
    $('#dataTables').dataTable({
        "order": [[1, 'asc'], [0, 'des']],
        "lengthMenu": [[10], [10]],
         "columnDefs": [{
            "width": "7%",
            "targets": 1
        }, {
            "width": "7%",
            "targets": 3
        }, {
            "width": "7%",
            "targets": 7
        }] 
    });

    despachadasCodigo();


}); //fin ready

var cod = document.getElementById('cod').value;
var enUrl = document.getElementById('valorUrl').value;
var idPick = document.getElementById('id_picking').value;
var idclient = document.getElementById('nCliente').value;
var pedida = document.getElementById('pedidaPicki').value;
var enBajadas = parseFloat(document.getElementById('bajadas').value);
var url = 'pickingList_Funciones.php';

$('#codiPicki').on('change', function () {
    var codigS = document.getElementById('codiPicki').value;

    
    document.location.href = "pickingListCodigos.php?cod=" + codigS + "&valor=" + 0 + "&id_picking=" + idPick + '&clienteID=' + idclient;
});

function solicitarCodigo() {
    var codigS = document.getElementById('codiPicki').value;
    var pedidS = parseFloat(document.getElementById('pedidaPicki').value);
    var enBajadas = parseFloat(document.getElementById('bajadas').value);

    if (codigS == '' || pedidS == 0) {
        alert('Ingrese datos de código y cantidad pedida');
    } else {

        if (pedidS < enBajadas) {
            alert('Las unidades pedidas deben ser mayores a las bajadas');
        } else {
            document.location.href = "pickingListCodigos.php?cod=" + cod + "&valor=" + pedidS + "&id_picking=" + idPick + '&clienteID=' + idclient;
        }
    }
}

function editar(id) {
    var enPedidas = parseFloat(document.getElementById('pedidaPicki').value);
    var enBajadas = parseFloat(document.getElementById('bajadas').value);
    var pedi = document.getElementById('pedidaPicki').value;
    if (enPedidas == 0 || enPedidas < enBajadas) {
        alert('Las unidades pedidas deben ser mayores a las bajadas');
        $('#pedidaPicki').css('background','#eb5');
    } else {
        if (enUrl == enPedidas) {
            $('#formulario')[0].reset();

            $.ajax({
                type: 'GET',
                url: url,
                data: 'proceso=' + 'editarM' + '&Etiqueta=' + id + '&codiPick=' + cod + '&pickNum=' + idPick,
                success: function (valores) {
                    var datos = eval(valores);

                    $('#alerta').hide();
                    $('#edi').show();
                    $('#proceso').val('pickinbajar');
                    $('#etiquetaS').val(id);
                    $('#pedidas').val($('#pedidaPicki').val());
                    $('#disponible').val(datos[0]["unidades"]);
                    $('#lotes').val(datos[0]["lote_produc"]);
                    $('#vencimi').val(datos[0]["vence"]);
                    $('#ubica').val(datos[0]["ubicacion_almacen"]);
                    $('#almacena').val(datos[0]["almacena_en"]);
                    $('#kilo').val(datos[0]["enkiloEtiqueta"]);
                    $('#motiv').val(datos[0]["almacena_motivo"]);
                    $('#bajadasevol').val(datos[0]["bajadas"]);
                    var pedidoC = $('#pedidas').val();
                    var disponiC = $('#disponible').val();
                    var bajadasC = $('#bajadasevol').val();
                    var diferen = pedidoC - bajadasC;
                    if (diferen == 0) {
                        $('#alerta').addClass('mensajeError').html('El pedido ha sido completado').show(200).delay(2500).hide(200);
                        $('#reg').attr("disabled", true);
                        setTimeout('location.reload()', 1500);
                    } else {
                        if (diferen <= disponiC) {
                            $('#abajar').val(diferen);
                        } else {
                            $('#abajar').val(disponiC);
                        }
                    }
                    $('#abreModal').modal({
                        show: true,
                        backdrop: 'static'
                    });

                }

            });
        } else {
            alert('Debe pulsar el boton de solicitar código');
             $('#solicita').css('background','#eb5');
        }
    }
}

function agregarRegistro() {
    $('#reg').attr('disabled', true);
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                $('#alerta').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
                location.reload();
            } else {
                $('#alerta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);

            }
        }
    });
    return false;
}

function despachadasCodigo() {
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=' + 'despachadas' + '&codiPick=' + cod + '&pickNum=' + idPick,
        success: function (valores) {
            var datos = eval(valores);
            $('#bajadas').val(datos[0]["unidades"]);
        }
    });
}

function imprimir() {
    window.open("pickinglisthtml.php?id_picking=" + idPick, "Reporte");
}
