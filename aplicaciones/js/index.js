$(document).ready(function () {
	initControls(); //Para evitar devolverse
	/*asignar  css al recibir el foco*/
}); //fin ready

//verifica si la cedula se encuentra registrada
$('#cedula').on('change', function () {
	var cedu = document.getElementById('cedula').value;
	var url = 'index_funciones.php';
	$.ajax({
		type: 'GET',
		url: url,
		data: 'proceso=' + 'nCedu' + '&cedula=' + cedu + '&clave=' + 'pera',
		success: function (valores) {
			var datos = eval(valores);
			var cedub = datos[0]["cedulaUsuario"];
			if (cedu == cedub) {
				$('#alertas').addClass('mensajeError').html('La cedula ya se encuentra registrada').show(200).delay(3500).hide(200);
				document.getElementById('cedula').value = '';
			}
		}
	});
});

//registra nuevos usuarios en base de datos
function registro() {
	var claveA = document.getElementById('clave').value;
	var claveB = document.getElementById('claveR').value;

	if (claveA != claveB) {
		alert('Los password ingresados no concuerdan');
		$('#clave').css('background-color', '#88FF88');
		$('#claveR').css('background-color', '#88FF88');
		return false;
	} else {
		var url = 'index_funciones.php';
		$.ajax({
			type: 'GET',
			url: url,
			data: $('#formularioregistro').serialize(),
			success: function (data) {
				if (data == 'Registro completado con exito') {
					$('#reg').attr('disabled', true);
					$('#alertas').addClass('mensaje').html(data).show(200).delay(91500).hide(200);
					let actualiza = new Promise((resolve, reject) => {
						setTimeout(function () {
							location.reload();
						}, 2000);
					});
				} else {
					$('#reg').disabled = false;
					$('#alertas').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
				}
			}
		});
		return false;
	}
}

//evitar devolverse
function initControls() {
	window.location.hash = "red";
	window.location.hash = "Red" //chrome
	window.onhashchange = function () {
		window.location.hash = "red";
	}
}


//controla las etiquetas de ingreso,registro yresetear
(function ($) {
	// constants
	var SHOW_CLASS = 'show',
		HIDE_CLASS = 'hide',
		ACTIVE_CLASS = 'active';

	$('.tabs').on('click', 'a', function (e) {
		e.preventDefault();
		var $tab = $(this),
			href = $tab.attr('href');

		if (href == '#register') {
			$('.flat-form').height(470).width(470);
		} else {
			$('.flat-form').height(390).width(390);
		}

		$('.active').removeClass(ACTIVE_CLASS);
		$tab.addClass(ACTIVE_CLASS);

		$('.show')
			.removeClass(SHOW_CLASS)
			.addClass(HIDE_CLASS)
			.hide();

		$(href)
			.removeClass(HIDE_CLASS)
			.addClass(SHOW_CLASS)
			.hide()
			.fadeIn(550);
	});
})(jQuery);



//control para el reseteo de password=================================================================================

