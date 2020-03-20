$(document).ready(function () {
    $('#dataTables').dataTable({
        "order": [[0, 'asc']],
        "lengthMenu": [[15], [15]],
    });

}); //fin ready

var usuar = document.getElementById('usuari').value;
var nivel = document.getElementById('nivelUsuario').value;
var idclie = document.getElementById('idclien').value;


$('#cliBusca').on('change', function () {
    var numClie = document.getElementById('cliBusca').value;
    document.location = 'inventarioEvolucion.php?id_cliente=' + numClie;
});

$('#etiqBusca').on('change', function () {
    var numetiq = document.getElementById('etiqBusca').value;
    document.location.href = 'etiquetasEvolucion.php?id_etiq=' + numetiq;
});

function inventarioExcel() {
    var dat_Clien = idclie;
    document.location.href = ("inventarioEvolucionExcel.php?id_cliente=" + dat_Clien);
}

function inventariopdf() {
    var data_Clien = idclie;
    window.open('inventarioEvolucionPdf.php?id_cliente=' + data_Clien, 'reporte');
}

function documento(movi,docu){
    if(movi==0){
        window.open("recepcionesHtml.php?numRecep=" + docu, "Reporte")
     }else if(movi==1){
        window.open("despachosHtml.php?num=" + docu, "Reporte");
     }else if(movi==3){
        window.open("transferenciasClientesHtml.php?trasfe=" + docu, "Reporte");
     }else{
        window.open("transferenciasHtml.php?trasfe=" + docu, "Reporte"); 
     }
        
}
