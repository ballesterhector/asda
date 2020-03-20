$(document).ready(function () {
    $('#dataTables').dataTable({
        "order": [[1, 'asc'], [0, 'des']],
        "lengthMenu": [[10], [10]],
         "columnDefs": [{"width": "7%","targets": 1},{"width": "7%","targets": 3},{"width": "7%","targets": 7}] 
    });
	autorizar();
}); //fin ready

$('#nuevo').on('click', function () {
    var nivel = document.getElementById('nivelUsuario').value;
    if (nivel <= 3) {
        $('#formulario')[0].reset();
        $('#myModalLabel').html('Registrar data');
        $('#myModalLabel').removeClass('text-danger');
        $('#myModalLabel').addClass('text-info');
        $('#reg').removeClass('btn-danger');
        $('#reg').addClass('btn-success');
        $('#codigo').attr('disabled', false);
        $('#proceso').val('Registro');
        $('#reg').val('Registro');
        $('#numcli').attr('disabled', false).css('background-color', '#b1f88b');
        $('#edi').hide();
        $('#motivo, .labelE').hide();
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
                setTimeout('location.reload()', 150);
            } else {
                $('#reg').attr('disabled', false)
                $('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
            }
        }
    });
    return false;
}

$('#cliBusca').on('change', function () {
    var numClie = document.getElementById('cliBusca').value;
    document.location = 'pickingList.php?clibus=' + numClie;
});

function modal(id, niv) {
    $('#formulario')[0].reset();
    $('#reg').attr('disabled', false);
    var url = 'pickingList_Funciones.php';

    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=' + 'Edicion' + '&nomPro=' + id,
        success: function (valores) {
            var datos = eval(valores);
            $('#myModalLabel').html('Modificar data');
            $('#myModalLabel').addClass('text-danger');
            $('#proceso').val("Modifica");
            $('#reg').val('Modificar');
            $('#reg').addClass('btn-danger');
            $('#id-prod').val(id);
            $('#numcli').val(datos[0]['clientePicking']);
            $('#movimientoPic').val(datos[0]['movimientoPicking']);
            $('#pedido').val(datos[0]['documentoPedido']);
            $('#pedidofecha').val(datos[0]['fechaDocumento']);
            $('#desticlie').val(datos[0]['destinoClientPicking']);
            $('#desticiuda').val(datos[0]['destinoCiudadPicking']);
            $('#motivo').val(datos[0]['modificadoMotivo']);

            if (niv <= 3) {
                $('#abreModal').modal({
                    show: true,
                    backdrop: 'static'
                });
            } else {
                swal("Oops!", "Su nivel de usuario no le autoriza la actualización de la data", "error");
            }
        }
    });
}

function cerrar(id) {
    var url = 'pickingList_Funciones.php';
    var usuari = document.getElementById('modificador').value;
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=' + 'cerrar' + '&numpik=' + id + '&usuario=' +  usuari,
        success: function (valores) {
            var datos = eval(valores);
            location.reload()
        }
    });
}

$('#cliBuscaModifica').on('change', function () {
    var numClie = document.getElementById('cliBuscaModifica').value;
    document.location = 'pickingListModificaciones.php?clibus=' + numClie;
});


$('#cliBuscamodificaciones').on('change', function () {
    var numClie = document.getElementById('cliBuscamodificaciones').value;
    document.location = 'productosModificaciones.php?clibus=' + numClie;
});


function excel(num) {
    var nCli = document.getElementById('nCliente').value;
    if (num == 0) {
        swal('Favor', 'Ingrese el cliente');
        $('#cliBusca').css('background-color', '#88FF88');
        return false;
    } else {
        document.location = 'productosExcel.php?clibus=' + nCli;
        event.preventDefault();
        document.location = 'productosExcel.php?clibus=' + nCli;
    }
}

function excelModificaciones() {
    var nCli = document.getElementById('nCliente').value;
    if (nCli == 0) {
        swal('Favor', 'Ingrese el cliente');
        $('#cliBusca').css('background-color', '#88FF88');
        return false;
    } else {
        document.location = 'productosModificacionesExcel.php?clibus=' + nCli;
        event.preventDefault();
        document.location = 'productosModificacionesExcel.php?clibus=' + nCli;
    }
}

function imprimir() {
    swal({
            title: "<span style='color:#F8BB86'>Imprimir reportes<span>",
            text: '<small class="text-info"><h3>Indica picking list a imprimir</h3></small>',
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
            window.open("pickinglisthtml.php?id_picking=" + inputValue, "Reporte");
        });
}

function imprimir2() {
    swal({
            title: "<span style='color:#F8BB86'>Imprimir reportes<span>",
            text: '<small class="text-info"><h3>Indica picking list a imprimir</h3></small>',
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
            window.open("pickinglisthtmlModificado.php?id_picking=" + inputValue, "Reporte");
        });
}

function codigos(pickingID,clienteID){
	location.href='pickingListCodigos.php?id_picking=' + pickingID + '&clienteID=' + clienteID + '&valor=' + 0 + '&cod=' + 0  ;
}

function autorizar() {
	var nivel = document.getElementById('nivelUsuario').value;
	if (nivel > 3) {
		swal("No autorizado!", "Su nivel no lo autoriza para ingresar a este proceso.", "error");
		let actualiza = new Promise((resolve, reject) => {
			setTimeout(function () {
				document.location.href = "index_Entrada.php";
			}, 1800);
		});
	}
}