$(document).ready(function () {
	var nivel = parseInt(document.getElementById('nivelUsuario').value);
	var estado = parseInt(document.getElementById('estadoUsua').value);
	
	if (nivel == 0) {
		swal({
				title: "No tiene autorización!",
				text: "Solicite a su supervisor la asignación de un nivel de usuario",
				type: "warning",
				showCancelButton: false,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Enterado",
				closeOnConfirm: false
			},
			function () {
				window.location.href = "index.html";
			});
	}
	if (estado == 1) {
		swal({
			title: "Usuario inactivo",
			text: "Solicite a su supervisor active su cuenta",
			type: "warning",
			showCancelButton: false,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Enterado",
			closeOnConfirm: false
		},
		function () {
			window.location.href = "index.html";
		});
	}

}); //fin ready
