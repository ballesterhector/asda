$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[0, 'asc']],
		"lengthMenu": [[13], [13]],
        "columnDefs": [
            {"targets": [ 0 ], "visible": false /*ocultar columna*/}
          ]
	});
	
}); //fin ready

var url = 'informatica_SolicitudesFunciones.php';
var usua = document.getElementById('usumodifi').value;

function ponerCeros() {
  var numero=  document.getElementById('id-prodd').value; 
    resultado = numero.padStart(7, "0");
    console.log(resultado);
    $('#id-prodd').val(resultado);
}


$('#nuevo').on('click', function () {
    $('#formulario')[0].reset();
	$('#myModalLabel').html('Registrar data');
	$('#myModalLabel').addClass('text-info');
    $('#falla').attr('disabled', false);
    $('#equip').attr('disabled', false);
    $('#reg').val('Registro');
	$('#reg').addClass('btn-info');
    $('#proceso').val("Registro");
    $('#detalleimpre').hide();
		$('#abreModal').modal({
			show: true,
			backdrop: 'static'
		});
});

function registroData() {
    $('#reg').attr('disabled', true);
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                $('#clos').attr('disabled', true);
                    $('#myModalLabel').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
                    setTimeout('location.reload()', 1600);
                } else {
                    $('#reg').attr('disabled', false)
                    $('#respuesta').addClass('mensajeError').html('Registro rechazado').show(200).delay(1500).hide(200);
                }
            }
        });
        return false;
}

function modifica(id, niv) {
    $('#formulario')[0].reset();
    $('#reg').attr('disabled', false);
    $('#falla').attr('disabled', true);
    $('#equip').attr('disabled', true);    
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=' + 'Edicion' + '&correla=' + id,
        success: function (valores) {
            var datos = eval(valores);
            $('#myModalLabel').html('Modificar data');
            $('#myModalLabel').addClass('text-danger');
            $('#proceso').val("Modifica");
            $('#reg').val('Modificar');
            $('#reg').addClass('btn-danger');
            $('#id-prod').val(id);
            $('#equip').val(datos[0]['correlativo']);
            $('#falla').val(datos[0]['falla']);
                       
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
    return false;
}

function cerrarmodal(idcod){
    $('#codi').val([idcod]);
    $('#reg').attr('disabled', false);
    $('#abreModalcerrar').modal({
        show: true,
        backdrop: 'static'
    });
}

function cerrar(idce) {
    $('#reg').attr('disabled', true);
   $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                $('#clos').attr('disabled', true);
                $('#respuesta').addClass('Solicitud cerrada').html(data).show(200).delay(1500).hide(200);
                setTimeout('location.reload()', 600);
            } else {
                    $('#reg').attr('disabled', false)
                    $('#respuesta').addClass('mensajeError').html('Registro rechazado').show(200).delay(1500).hide(200);
            }
        }
    });
    return false;
}