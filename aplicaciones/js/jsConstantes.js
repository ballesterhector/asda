$(document).ready(function () {
	initControls(); //Para evitar devolverse
	$('.dropdown-submenu > a').submenupicker();
	
}); //fin ready

$('#usuar').on('click', function () {
	var nivel = parseInt(document.getElementById('nivelUsuario').value);
	if (nivel > 2) {
		swal("No tiene autorización para ingresar a este proceso");
		$(".enlace .ocultar").css("visibility", "hidden");

	}
});

$(function () {
	$('[data-toggle="tooltip"]').tooltip();
});

$(function () {
	$('[data-toggle="popover"]').popover();
});


//evitar devolverse
function initControls() {
	window.location.hash = "red";
	window.location.hash = "Red" //chrome
	window.onhashchange = function () {
		window.location.hash = "red";
	}
}
