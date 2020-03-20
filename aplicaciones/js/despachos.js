$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[0, 'asc'], [2, 'desc']],
		"lengthMenu": [[13], [13]]
	});
}); //fin ready

var nivel = document.getElementById('nivelUsuario').value;
$('#nuevo').on('click', function () {
	var nivel = document.getElementById('nivelUsuario').value;
    $('#paletas').attr('readonly',false);
    $('#mala').attr('readonly',false);
    $('#llenas').attr('readonly',false);
    $('#vacia').attr('readonly',false);
	$('.origi').hide();
	if (nivel <= 3) {
		$('#formulario')[0].reset();
		$('#myModalLabel').html('Registrar data');
		$('#myModalLabel').removeClass('text-danger');
		$('#myModalLabel').addClass('text-info');
		$('.confirm').hide();
		$('#reg').removeClass('btn-danger');
		$('#reg').addClass('btn-success');
		$('#codigo').attr('disabled', false);
		$('#proceso').val('Registro');
		$('#reg').val('Registro');
		$('#name').attr('disabled', false);
		$('#edi').hide();
		$('.recep').hide();
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

function agregarRegistro() {
	var url = 'despachos_Funciones.php';
	$('#reg').attr('disabled', true);
	$.ajax({
		type: 'GET',
		url: url,
		data: $('#formulario').serialize(),
		success: function (data) {
			if (data == 'Registro completado con exito') {
				$('#clos').attr('disabled', true);
				$('#mensaje').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
				let actualiza = new Promise((resolve, reject) => {
					setTimeout(function () {
						location.reload();
					}, 1000);
				});

			} else {
				$('#reg').show();
				$('#clos').show();
				$('#mensaje').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
				//location.reload();
			}
		}
	});
	return false;
}

function modal(id, niv) {
	$('#formulario')[0].reset();
	$('#reg').attr('disabled', false);
	$('#name').attr('disabled', true);
    $('#paletas').attr('readonly',true);
    $('#mala').attr('readonly',true);
    $('#llenas').attr('readonly',true);
    $('#vacia').attr('readonly',true);
	$('.confirm').show();
	var url = 'despachos_Funciones.php';

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
			$('#despacho').val(datos[0]['num_retiro']);
			$('#movimiento').val(datos[0]['movimient_retir']);
			$('#name').val(datos[0]['cliente_num_retir']);
			$('#transp').val(datos[0]['transporte']);
			$('#conduct').val(datos[0]['conductor']);
			$('#vehicu').val(datos[0]['vehiculo_retiro_palcas']);
			$('#trailer').val(datos[0]['trailer']);
			$('#contenedor').val(datos[0]['contenedor']);
			$('#precint').val(datos[0]['precintos_retir']);
			$('#ciudest').val(datos[0]['ciudad_dest_retiro']);
			$('#tempera').val(datos[0]['temperatura_rece']);
			$('#cliedesti').val(datos[0]['client_destin_retiro']);
			$('#factura').val(datos[0]['documento_client_retiro']);
			$('#factfecha').val(datos[0]['fechaFactura']);
			$('#tempera').val(datos[0]['temperatura_retiro']);
			$('#pesocarga').val(datos[0]['kilos_pedidos']);
			$('#pedidas').val(datos[0]['unidades_pedidas']);
			$('#paletas').val(datos[0]['paletas_retiro']);
			$('#llenas').val(datos[0]['paletas_llena_retir']);
			$('#vacia').val(datos[0]['paletas_vacia_retir']);
			$('#mala').val(datos[0]['paletas_malas_retir']);
			$('#salida').val(datos[0]['salida']);
			$('#horasalida').val(datos[0]['salida_hora']);
			$('#cobrar').val(datos[0]['valido_contabi_retiro']);
			$('#granel').val(datos[0]['agranel_retir']);
			$('#solopaleta').val(datos[0]['solo_paleta_retiro']);
			$('#observa').val(datos[0]['observa_retir']);

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

function modalpicking(id, niv) {
	$('#formulariopickin')[0].reset();
	$('#reg').attr('disabled', false);
	$('#name').attr('disabled', true);
	var url = 'despachos_Funciones.php';

	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'Edicion' + '&nomPro=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalpicking').html('Asignar picking list');
			$('#myModalpicking').addClass('text-danger');
			$('#procesos').val("bajarpicking");
			$('#regsp').val('Masivo');
			$('#regsp').addClass('btn-danger');
			$('#despachos').val(datos[0]['num_retiro']);
			$('#movimientos').val(datos[0]['movimient_retir']);
			$('#names').val(datos[0]['cliente_num_retir']);
			$('#fechdesp').val(datos[0]['fecha_retiro']);
			
			if (niv > 3) {
				swal("Oops!", "Su nivel de usuario no le autoriza la actualización de la data", "error");
			} else {
				$('#abreModalPicking').modal({
					show: true,
					backdrop: 'static'
				});
			}
		}
	});
	return false;
}

function modalmanual(id, niv,cli) {
	$('#formulariomanual')[0].reset();
	$('#reg').attr('disabled', false);
	$('#name').attr('disabled', true);
	var url = 'despachos_Funciones.php';

	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'Edicion' + '&nomPro=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalmanual').html('Despacho manual');
			$('#myModalmanual').addClass('text-danger');
			$('#regspm').val('Registrar');
			$('#regspm').addClass('btn-danger');
			$('#despachosm').val(datos[0]['num_retiro']);
			$('#movimientosm').val(datos[0]['movimient_retir']);
			$('#namesm').val(datos[0]['cliente_num_retir']);
			$('#fechdespm').val(datos[0]['fecha_retiro']);
            $('#idclientes').val(datos[0]['cliente_num_retir']);
			
			if (niv > 3) {
				swal("Oops!", "Su nivel de usuario no le autoriza la actualización de la data", "error");
			} else {
				$('#abreModalManual').modal({
					show: true,
					backdrop: 'static'
				});
			}
		}
	});
	return false;
}

function mostrar() {
	var url = 'despachos_Funciones.php';
	var picki = document.getElementById('picking').value;
	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'dataEtiquetas' + '&pickingSelect=' + picki,
		success: function (datos) {
			$('#etiquetas').html(datos);
		}

	});
}

function despachar(evol){
	var url = 'despachos_Funciones.php';
	var retir = document.getElementById('despachos').value;
	var fech = document.getElementById('fechdesp').value;
	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'despachar' + '&idevol=' + evol + '&despacho=' + retir + '&fech=' + fech,
		success: function (data) {
			if (data == 'Registro completado con exito') {
				$('#clos').attr('disabled', true);
				$('#mensajepick').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
				mostrar();
				confirmar();
			} else {
				$('#reg').show();
				$('#clos').show();
				$('#mensajepick').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
				//location.reload();
			}
		}

	});
	return false;
}

function confirmar(){
	var url = 'despachos_Funciones.php';
	var retir = document.getElementById('despachos').value;
	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'confirmar' + '&despacho=' + retir,
		success: function (data) {
		}
	});
	return false;
}

function confirmarm(){
	var url = 'despachos_Funciones.php';
	var retirm = document.getElementById('despachosm').value;
    
	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'confirmar' + '&despacho=' + retirm,
		success: function (data) {
		}
	});
	return false;
}

$('#close').on('click',function(){
	location.reload();
});

function despachospdf() {
	swal({
			title: "<span style='color:#F8BB86'>Imprimir reporte<span>",
			text: "<small class='text-info'><h3>Indica número de despacho</h3></small>",
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
			window.open("despachosHtml.php?num=" + inputValue, "Reporte");
		});
}

$('#regsp').on('click',function(){
    var url = 'despachos_Funciones.php';
	var pick = document.getElementById('picking').value;
    var retir = document.getElementById('despachos').value;
	var fech = document.getElementById('fechdesp').value;
    var movi = document.getElementById('movimientos').value;
    if(movi=='despachomanual'){
        swal("Oops!", "El movimiento es despacho manual", "error");
        setTimeout(function () {
		    location.reload();
		}, 2000);
        
    }else{
    
        $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=' + 'masivo' + '&picki=' + pick + '&despacho=' + retir + '&fech=' + fech,
            success: function (data) {
                if (data == 'Registro completado con exito') {
                    $('#clos').attr('disabled', true);
                    $('#mensajepick').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
                    mostrar();
                    confirmar();
                } else {
                    $('#reg').show();
                    $('#clos').show();
                    $('#mensajepick').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
                    //location.reload();
                }
            }

        });
        return false;
    }
});

$('#regspm').on('click',function(){
    var url = 'despachos_Funciones.php';
	var movi = document.getElementById('movimientosm').value;
    var retirm = document.getElementById('despachosm').value;
    if(movi!='despachomanual'){
        swal("Oops!", "El movimiento no es despacho manual", "error");
        setTimeout(function () {
		    location.reload();
		}, 2000);
        
    }else{
        
	   $.ajax({
		type: 'GET',
		url: url,
		data: $('#formulariomanual').serialize(),
		success: function (data) {
			if (data == 'Registro completado con exito') {
				$('#clos').attr('disabled', true);
				$('#mensajemanual').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
				mostrar();
				confirmarm();
			} else {
				$('#reg').show();
				$('#clos').show();
				$('#mensajemanual').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
				//location.reload();
			}
		}

	});
	   return false;
    }
});

function activar() {
	if (nivel > 3) {
		swal('Oops!', 'No tiene autorización para modificar data', 'error');
	} else {
	
	swal({
			title: "<span style='color:#F8BB86'>Activar despacho<span>",
			text: "<small class='text-info'><h3>Indica número de despacho</h3></small>",
			type: "input",
			showCancelButton: true,
			closeOnConfirm: false,
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
			var url = 'despachos_Funciones.php';
			$.ajax({
				type: 'GET',
				url: url,
				data: 'proceso=' + 'activar' + '&despacho=' + inputValue,
				success: function (repuesta) {
					if (repuesta == 'Registro completado con exito') {
						swal("Proceso ejecutado", "despacho  " + inputValue + " activado en base de datos", "success");
						setInterval("location.reload()", 2500);
					} else {
						swal.showInputError("<small class='text-danger'>Fecha de despacho " + inputValue + " se encuentra fuera de rango</small>");
						return false
					}
				}
			});
		});
	}
}

$('#movimiento').on('change',function(){
	var movimi = document.getElementById('movimiento').value;
	if(movimi=='complemento'){
		$('.origi').show();
		$('#original').css('background-color','#e0f890');
	}else{
	
	}
});
