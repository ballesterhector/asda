$(document).ready(function () {
	$('#dataTables').dataTable({
		"order": [[0, 'asc']],
		"lengthMenu": [[13], [13]]
	});
	autorizar();
}); //fin ready

$(".pue").click(function(){
    //tomamos el valor de la clase .pue y lo convertimos en número
    var val = parseInt($(this).val());
    //pasamos el valor val por data: 'proceso=' + 'Edicion' + '&correla=' + val,
    //y ejecutamos el nuevo modal con los datos solicitados.
    $('#formulario')[0].reset();
	var url = 'informatica_Funciones.php';
    if(val==0){
        swal("Data inconsistente!", "Equipo no tiene asignado un ordenador")
    }else{
        $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=' + 'Edicion' + '&correla=' + val,
            success: function (valores) {
                var datos = eval(valores);
                $('#myModalLabeld').html('Ordenador data');
                $('#myModalLabeld').addClass('text-danger');
                $('#regd').val('Consulta');
                $('#regd').addClass('btn-info');
                $('#regd').attr('disabled', true);
                $('#id-prodd').val(val);
                $("#userd").val(datos[0]['asignadoA']);
                $("#ubicad").val(datos[0]['ubicacion']);
                $("#emaild").val(datos[0]['email']);
                $("#teamd").val(datos[0]['idteamviewer']);
                $("#anyd").val(datos[0]['anydesk']);
                $("#tipod").val(datos[0]['tipoEquipo']);
                $("#siteoparatd").val(datos[0]['sistemaoperativo']);
                $("#ramd").val(datos[0]['ramGB']);
                $("#ddd").val(datos[0]['dicoDuroGB']);
                $("#ipd").val(datos[0]['ipFija']);
                $("#iconosd").val(datos[0]['iconosActivos']);
                $("#observad").val(datos[0]['observacion']);
                $("#estadod").val(datos[0]['estado']);
               
                    $('#abreModald').modal({
                        show: true,
                        backdrop: 'static'
                    });
               
            }
        });
        return false;
    }
});

function modifica(id, niv) {
    $('#formulario')[0].reset();
	$('#reg').attr('disabled', false);
	    
	var url = 'informatica_Funciones.php';

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
			$('#estado').val(datos[0]['estado']);
            $("#ubica").val(datos[0]['ubicacion']);
           
            $("#observa").val(datos[0]['observacion']);
            if(datos[0]['tipoEquipo']=='Impresora'){
                $('#detalleimpre').show();
                $("#impremarca").val(datos[0]['impremarca']);
                $("#impremodelo").val(datos[0]['impremodelo']);
                $("#toner").val(datos[0]['toner']);
            }else{
                $('#detalleimpre').hide();
            }
			
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

function modificared(id, niv) {
    var url = 'informatica_Funciones.php';
    $('#reg').attr('disabled', false);
    $('#puerto').attr('readonly', true);
	$('#formulario')[0].reset();
	$.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=' + 'Edicionred' + '&correla=' + id,
        success: function(valores){
            var datos = eval(valores);
            $('#myModalLabel').html('Modificar dispositivo de red');
			$('#myModalLabel').addClass('text-danger');
			$('#proceso').val("Modificared");
			$('#reg').val('Modificar');
			$('#reg').addClass('btn-danger');
			$('#id-prod').val(id);
            $('#estado').val(datos[0]['estadoredes']);
            $('#ubica').val(datos[0]['ubicacionredes']);
            $('#tipo').val(datos[0]['Equipored']);
            $('#puerto').val(datos[0]['puertos']);
            $('#conetadoa').val(datos[0]['depende']);
            $('#tipo2').val(datos[0]['tipodispositivo']);
            $("#observa").val(datos[0]['observacionredes']);
            var datos = eval(valores);
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

function complemento(id, niv) {
   var url = 'informatica_Funciones.php';

	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'Edicion' + '&correla=' + id,
		success: function (valores) {
			var datos = eval(valores);
			$('#myModalLabelc').html('Complementos data');
			$('#myModalLabelc').addClass('text-danger');
            $('#regc').val('Complementos');
            $('#regc').attr('disabled', true);
            $('#regc').addClass('btn-info');
            $('#id-prodc').val(datos[0]['correlativo']);
			$('#estadoc').val(datos[0]['estado']);
			$("#userc").val(datos[0]['asignadoA']);
            $("#teamc").val(datos[0]['idteamviewer']);
            $("#anyc").val(datos[0]['anydesk']);
            $("#tipoc").val(datos[0]['tipoEquipo']); 
            $("#ramc").val(datos[0]['ramGB']);
            $("#ddc").val(datos[0]['dicoDuroGB']);
            $("#ipc").val(datos[0]['ipFija']);
            $("#mac").val(datos[0]['macaddress']);
            $("#observac").val(datos[0]['observacion']);
            if(datos[0]['tipoEquipo']=='Impresora'){
                $('#detalleimprec').show();
                $("#impremarcac").val(datos[0]['impremarca']);
                $("#impremodeloc").val(datos[0]['impremodelo']);
                $("#tonerc").val(datos[0]['toner']);
            }else{
                $('#detalleimprec').hide();
            }
			
            if (niv > 3) {
				swal("Oops!", "Su nivel de usuario no le autoriza la actualización de la data", "error");
			} else {
				$('#abreModalcomplemento').modal({
					show: true,
					backdrop: 'static'
				});
			}
		}
	});
	return false;
}

function complementored(id,niv){
    var url = 'informatica_Funciones.php';
    $.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'Edicionred' + '&correla=' + id,
        success: function (valores){
            var datos = eval(valores);
            $('#myModalLabelr').html('Complemento data');
			$('#myModalLabelr').addClass('text-danger');
            $('#regr').val('Complementos');
            $('#regr').attr('disabled', true);
            $('#regr').addClass('btn-info');
            $('#pu12c').val(datos[0]['ordenador11']);
            $('#pu13c').val(datos[0]['ordenador12']);
            $('#pu14c').val(datos[0]['ordenador13']);
            $('#pu15c').val(datos[0]['ordenador14']);
            $('#pu16c').val(datos[0]['ordenador15']);
            $('#pu17c').val(datos[0]['ordenador16']);
            $('#pu18c').val(datos[0]['ordenador17']);
            $('#pu19c').val(datos[0]['ordenador18']);
            $('#pu20c').val(datos[0]['ordenador19']);
            $('#pu21c').val(datos[0]['ordenador20']);
            $("#observac").val(datos[0]['observacion']);
            if (niv > 3) {
				swal("Oops!", "Su nivel de usuario no le autoriza la actualización de la data", "error");
			} else {
				$('#abreModalcomplered').modal({
					show: true,
					backdrop: 'static'
				});
			}
        }
    });
}

function ordenador(id, niv) {
    $('#formulario')[0].reset();
	var url = 'informatica_Funciones.php';
    if(id==0){
        swal("Data inconsistente!", "Equipo no tiene asignado un ordenador")
    }else{
        $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=' + 'Edicion' + '&correla=' + id,
            success: function (valores) {
                var datos = eval(valores);
                $('#myModalLabeld').html('Ordenador data');
                $('#myModalLabeld').addClass('text-danger');
                $('#regd').val('Consulta');
                $('#regd').addClass('btn-info');
                $('#regd').attr('disabled', true);
                $('#id-prodd').val(id);
                $("#userd").val(datos[0]['asignadoA']);
                $("#ubicad").val(datos[0]['ubicacion']);
                $("#emaild").val(datos[0]['email']);
                $("#teamd").val(datos[0]['idteamviewer']);
                $("#anyd").val(datos[0]['anydesk']);
                $("#tipod").val(datos[0]['tipoEquipo']);
                $("#siteoparatd").val(datos[0]['sistemaoperativo']);
                $("#ramd").val(datos[0]['ramGB']);
                $("#ddd").val(datos[0]['dicoDuroGB']);
                $("#ipd").val(datos[0]['ipFija']);
                $("#iconosd").val(datos[0]['iconosActivos']);
                $("#observad").val(datos[0]['observacion']);
                $("#estadod").val(datos[0]['estado']);
                ponerCeros();

                if (niv > 3) {
                    swal("Oops!", "Su nivel de usuario no le autoriza la actualización de la data", "error");
                } else {
                    $('#abreModald').modal({
                        show: true,
                        backdrop: 'static'
                    });
                }
            }
        });
        return false;
    }
}

function ponerCeros() {
  var numero=  document.getElementById('id-prodd').value; 
    resultado = numero.padStart(7, "0");
    console.log(resultado);
    $('#id-prodd').val(resultado);
}

function registroData() {
	var url = 'informatica_Funciones.php';
  	$('#reg').attr('disabled', true);
	$.ajax({
		type: 'GET',
		url: url,
		data: $('#formulario').serialize(),
		success: function (data) {
	        if (data == 'Registro completado con exito') {
		        $('#clos').attr('disabled', true);
					$('#respuesta').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
					setTimeout('location.reload()', 1600);
				} else {
					$('#reg').attr('disabled', false)
					$('#respuesta').addClass('mensajeError').html('Registro rechazado').show(200).delay(1500).hide(200);
				}
			}
		});
		return false;
}

function registroDataRed() {
	var url = 'informatica_Funciones.php';
  	$('#reg').attr('disabled', true);
	$.ajax({
		type: 'GET',
		url: url,
		data: $('#formulario').serialize(),
		success: function (data) {
	        if (data == 'Registro completado con exitoRegistro completado con exito') {
		        $('#clos').attr('disabled', true);
					$('#respuesta').addClass('mensaje').html(data).show(200).delay(1500).hide(200);
					setTimeout('location.reload()', 1600);
				} else {
					$('#reg').attr('disabled', false)
					$('#respuesta').addClass('mensajeError').html('Registro rechazado').show(200).delay(1500).hide(200);
				}
			}
		});
		return false;
}

$('#nuevo').on('click', function () {
    $('#formulario')[0].reset();
	var nivel = document.getElementById('nivelUsuario').value;
    $('#myModalLabel').html('Registrar data');
	$('#myModalLabel').addClass('text-info');
    $('#reg').val('Registro');
	$('#reg').addClass('btn-info');
    $('#proceso').val("Registro");
    $('#detalleimpre').hide();
		$('#abreModal').modal({
			show: true,
			backdrop: 'static'
		});
});

$('#nuevoRed').on('click', function () {
    $('#formulario')[0].reset();
    $('#puerto').attr('readonly', false);
	var nivel = document.getElementById('nivelUsuario').value;
    $('#myModalLabel').html('Registrar data');
	$('#myModalLabel').addClass('text-info');
    $('#reg').val('Registro');
	$('#reg').addClass('btn-info');
    $('#proceso').val("Registrored");
    $('#detalleimpre').hide();
		$('#abreModal').modal({
			show: true,
			backdrop: 'static'
		});
});

$('#tipo').on('change',function(){
	var tipos = document.getElementById('tipo').value;
  	if(tipos=='Impresora'){
		$('#detalleimpre').show();
    }else{
	   $('#detalleimpre').hide();
	}
});

function autorizar() {
	var informatico = document.getElementById('esinformatico').value;
    if (informatico == 0) {
		swal("No autorizado!", "Su nivel no lo autoriza para ingresar a este proceso.", "error");
       let actualiza = new Promise((resolve, reject) => {
			setTimeout(function () {
				document.location.href = "index_Entrada.php";
			}, 1800);
		});
	}
}

function equiposred(id){
    location.href="informaticaRed.php?nivel=" + 0 + '&correl=' + id ;
}

function ingresaequipos(id){
    $('#formulario')[0].reset();
    $('#myModalLabelequi').html('Registrar dispositivo');
    $('#myModalLabelequi').addClass('text-info');
    $('#regequi').val('Asigna');
    $('#regequi').addClass('btn-info');
    $('#id-prodequi').val(id);
        $('#abreModalasignadispositivo').modal({
            show: true,
            backdrop: 'static'
        });
}

function ingresaequipo() {
    var url = 'informatica_Funciones.php';
    $('#reg').attr('disabled', true);
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formularioequi').serialize(),
        success: function (data) {
            if (data == 'Registro completado con exito') {
                    $('#clos').attr('disabled', true);
                    $('#respuestaequi').addClass('mensaje').html('Equipo asignado').show(200).delay(1500).hide(200);
                    setTimeout('location.reload()', 1600);
                } else {
                    $('#reg').attr('disabled', false)
                    $('#respuestaequi').addClass('mensajeError').html('Equipo asignado previamente').show(200).delay(1500).hide(200);
                }
            }
        });
        return false;
}

