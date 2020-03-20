$(document).ready(function () {
    autorizar();
    $('#dataTables').dataTable({
        "order": [[0, 'asc'], [2, 'desc']],
        "lengthMenu": [[13], [13]]
    });

}); //fin ready

$('#insumo').change(function () {
    $('#insumo option:selected').each(function () {
        codigo = $(this).val();
        $.get("suministrosDataAnidada_Funciones.php", {
            id_codigo: codigo
        }, function (data) {
            $('#productos').html(data)
        });
    });
});


function autorizar() {
    var nivel = document.getElementById('nivelUsuario').value;
    if (nivel != 1 & nivel != 5) {
        swal("No autorizado!", "Su nivel no lo autoriza para ingresar a este proceso.", "error");
        let actualiza = new Promise((resolve, reject) => {
            setTimeout(function () {
                document.location.href = "index_Entrada.php";
            }, 1800);
        });
    }
}
