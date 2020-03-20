<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
        
        $obj= new conectarDB();
    	$data= $obj->subconsulta("CALL transferenciasSelect('".$_GET['transf']."')");
    	   $clientes = $data[0]['clienteTransfe'];
           $numclie = $data[0]['idclienteTransfe'];
    
    require "aplicaciones/html/head";
?>

    <body>
        <header>
            <input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
            <input type="hidden" id="modificador" value="<?php echo $usuario ?>">
            <div class="menu">
                <div class="logo">
                    <a href="#"><img src="aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
                </div>
                <nav class="enlaces" id="enlaces">
                    <?php include "aplicaciones/nav/menuarriba.html" ?>
                </nav>
            </div>
            <div class="recepcion">
                <div class="titulo">
                    <h4 class="titulos" id="alerta">Transferencia de unidades entre almacenes</h4>
                </div>
                <h4><div id="respuesta"></div></h4>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/transferencias.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                    <a href="javascript: onclick(recepcionpdf())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir reporte"></i></a>
                
                </div>
            </div>
        </header>
        <form action="" id="formulario">
            <div id='main'>
                <nav>
                    <?php include "aplicaciones/nav/menuizquierda.html" ?>
                </nav>
                <article class="tabla tablatransf">
                    <div class="datos">
                        <div class="usua"><input type="hidden" name="usua" id="modificador" class="form-control" value="<?php echo $usuario ?>" readonly></div>
                        <div class="usua"><input type="hidden" name="idclient" id="clie" class="form-control" value="<?php echo $data[0]['idclienteTransfe'] ?>" readonly></div>
                        <label>Cliente
                            <input type="text" class="form-control" value="<?php echo $clientes ?>" readonly>
                        </label>
                        
                        <label class="numero">Número
                            <input type="text" name="transfe" id="transf" class="form-control" value="<?php echo $data[0]['numeroTransfe'] ?>" style="text-align:center" readonly>
                        </label>
                        <label>tipo
                            <input type="text" name="tipo" id="tipo" class="form-control" value="<?php echo $data[0]['tipoTransfe'] ?>" readonly>
                        </label>
                        <input type="hidden" name="fechatrasf" id="date" class="form-control" value="<?php echo $data[0]['fechaTrasfe'] ?>" readonly>
                        <input type="hidden" id="movim" class="form-control" value="transferencia" readonly>
                        <input type="hidden" id="llega" class="form-control" value="<?php echo $data[0]['idclienteLlega'] ?>" readonly>
                        <label style="width:19rem">Etiqueta 
                            <select class="form-control" name="etiqu" id="etiqu" style="padding-left:5rem" required="require">
                                <option></option>
                                <?php
                                    $obj= new conectarDB();
                                    $data= $obj->subconsulta('CALL inv_DisponiblePorEtiqueta("'.$numclie.'")');
                                    foreach ($data as $key) {
                                    echo "<option value='".$key['etiquetaEvol']."'>".$key['etiquetaEvol']."</option>";
                                    }
                                ?>
                            </select>
                        </label>
                    </div>
                    <div class="etique">
                            <div class=""><input type="hidden" id="codg" class="form-control" readonly></div>
                            <div class=""><input type="hidden" id="produc" class="form-control" readonly></div>
                            <div class=""><input type="hidden" name="lote0" id="lote" class="form-control" readonly></div>
                            <div class=""><input type="hidden" name="vencimi0" id="vence" class="form-control" readonly></div>
                                <input type="hidden" id="empaq" class="form-control" readonly style="width:9rem;text-align:center">
                                <input type="hidden" id="unidades" class="form-control" readonly style="width:9rem;text-align:center">
                            <label>Almacen 
                                <select class="form-control" name="almacen" id="almacen" required="require">
                                    <option value="Averia">Averia</option>
                                    <?php
                                        $obj= new conectarDB();
                                        $data= $obj->subconsulta('CALL almacenSelect()');
                                        foreach ($data as $key) {
                                        echo "<option value='".$key['almacen_almac']."'>".$key['almacen_almac']."</option>";
                                        }
                                    ?>
                                </select>
                            </label>
                            <label>Motivo 
                                <select class="form-control" name="motivo" id="motivosE" required="require" style="width:30rem">
                                    <option value="Averia">Averia</option>
                                    <?php
                                        $obj= new conectarDB();
                                        $data= $obj->subconsulta('CALL almacenMotivos()');
                                        foreach ($data as $key) {
                                        echo "<option value='".$key['motivo_almacenar']."'>".$key['motivo_almacenar']."</option>";
                                        }
                                    ?>
                                </select>
                            </label>
                            <?php  
                               $obj= new conectarDB();
                                $data= $obj->subconsulta("CALL transferenciasSelect('".$_GET['transf']."')");
                            ?>
                            <input type="hidden" class="" name="idcodig" id="idcodig">
                            <input type="hidden" name="proceso" value="evolinsert">
                            <input type="hidden" name="movimie" value="<?php echo $data[0]['tipoTransfe'] ?>">
                            <input type="hidden" name="etiquetas" value="1">
                            <input type="hidden" name="malas" value="0">
                        <label for="" class="">Empaques  
                            <input type="text" class="form-control" id="empaque" name="empaque" style="width:100px" value="0" autocomplete="off">
                       </label>
                       <label for="" class="">Unidades  
                           <input type="text" class="form-control" id="unidad" name="unidad" style="width:100px" value="0" autocomplete="off">
                      </label> 
                      <i id="ejecuta" class="fas fa-caret-right fa-3x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i>
                    </div>
                </article>
            </div>
        </form>
        <footer class="dat">
            <script>
                var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
                var f = new Date();
                document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

            </script>
        </footer>
        <div>
            <?php require "aplicaciones/html/footer" ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dataTables').dataTable({
                    "order": [[0, 'asc']],
                    "lengthMenu": [[15], [15]],
                });
                
                $('#als').hide();

            }); //fin ready
            
            $('#etiqu').on('change',function(){
                var etiqueta = document.getElementById('etiqu').value;
                var url = 'transferencias_Funciones.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'proceso=' + 'etiquetas' + '&id=' + etiqueta,
                    success: function (valores) {
                        var datos = eval(valores);
                        $('#codg').val(datos[0]['codigoEtiqueta']);
                        $('#idcodig').val(datos[0]['idproductoEtiqueta']);
                        $('#produc').val(datos[0]['productoEtiqueta']);
                        $('#lote').val(datos[0]['loteEtiqueta']);
                        $('#vence').val(datos[0]['venceEtiqueta']);
                        $('#empaq').val(datos[0]['empaques']);
                        $('#unidades').val(datos[0]['unid']);
                        $('#almacen').val(datos[0]['almacenEtiqueta']);
                        $('#preci').val(datos[0]['precio']);
                    }
                });
                return false;
            });
            
            $('#ejecuta').on('click',function(){
                $('#ejecuta').hide();
                var url = 'transferencias_Funciones.php';
                var unid = document.getElementById('unidad').value;
                if(unid>0){
                    $.ajax({
            		type:'GET',
            		url:url,
            		data:$('#formulario').serialize(),
            		success: function(data){
            			if (data=='Registro completado con exito') {
            				$('#alerta').addClass('mensaje').html('Transferencia procesada').show(200).delay(2500).hide(200);
            				let actualiza= new Promise((resolve, reject) => {
                               setTimeout(function(){
                                //    location.reload();
                                
                                }, 1000);
                            });
            			}else {
            				$('#alerta').addClass('mensajeError').html('Transferencia fallida por datos incompletos').show(200).delay(2500).hide(200);
            			     let actualiza= new Promise((resolve, reject) => {
                               setTimeout(function(){
                                //    location.reload();
                                }, 1700);
                            });;    
                        }
            		}
            	});
                }else{
                    swal("Oops!", "Debe indicar las unidades a transferir", "error");    
                }
            	  
            	return false;
            });

            function ejecuta2(){
                var idcli = document.getElementById('clie').value;
                var idcodi = document.getElementById('idcodig').value;
                var transf = document.getElementById('transf').value;
                var fechtransf = document.getElementById('date').value;
                var etiq = document.getElementById('etiqu').value;
                var usua = document.getElementById('modificador').value;
                var unidad = document.getElementById('unidades').value;
                var empaque = document.getElementById('empaq').value;
                var tipo = document.getElementById('tipo').value;
                var url = 'transferencias_Funciones.php';
                    $.ajax({
            		type:'GET',
            		url:url,
                    data:'proceso=' + 'ejecuta2' + '&idclient=' + idcli + '&idcodig=' +  idcodi +
                            '&transfe='+ transf + '&fechatrasf=' +  fechtransf + '&etiqu=' + etiq +
                            '&usua=' + usua + '&unidad=' + unidad + '&empaque=' + '&tipo=' + tipo ,
            		success: function(data){
            			if (data=='Registro completado con exito') {
            				$('#alerta').addClass('mensaje').html('Evolución ajustada').show(200).delay(2500).hide(200);
            				let actualiza= new Promise((resolve, reject) => {
                               setTimeout(function(){
                                //    location.reload();
                                
                                }, 1000);
                            });
            			}else {
            				$('#alerta').addClass('mensajeError').html('Transferencia fallida por datos incompletos').show(200).delay(2500).hide(200);
            			     let actualiza= new Promise((resolve, reject) => {
                               setTimeout(function(){
                                //    location.reload();
                                }, 1700);
                            });;    
                        }
            		}
            	});
                 
            	return false;
            }

            function ejecuta3(){
                var transf = document.getElementById('transf').value;
                var etiq = document.getElementById('etiqu').value;
                var url = 'transferencias_Funciones.php';
                    $.ajax({
            		type:'GET',
            		url:url,
                    data:'proceso=' + 'ejecuta3' +'&transfe='+ transf + '&etiqu=' + etiq,
            		success: function(data){
            			if (data=='Registro completado con exitoRegistro completado con exito') {
            				$('#alerta').addClass('mensaje').html('Transferencia actualizada').show(200).delay(2500).hide(200);
            				let actualiza= new Promise((resolve, reject) => {
                               setTimeout(function(){
                                //    location.reload();
                                
                                }, 1000);
                            });
            			}else {
            				$('#alerta').addClass('mensajeError').html('Transferencia fallida por datos incompletos').show(200).delay(2500).hide(200);
            			     let actualiza= new Promise((resolve, reject) => {
                               setTimeout(function(){
                                //    location.reload();
                                }, 1700);
                            });;    
                        }
            		}
            	});
                 
            	return false;
            }
            
            $('#unidad').on('change',function(){
                var disponible = parseFloat(document.getElementById('unidades').value);
                var unid = parseFloat(document.getElementById('unidad').value);
                if(unid>disponible){
                    swal("Oops!", "Las unidades a transferir superan al disponible", "error"); 
                    $('#unidad').val(0);
                }
            });
            
            function recepcionpdf() {
                swal({
                        title: "<span style='color:#F8BB86'>Imprimir reporte<span>",
                        text: "<small class='text-info'><h3>Indica número de transferencia</h3></small>",
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
                        window.open("transferenciasHtml.php?trasfe=" + inputValue, "Reporte")
                    });
            }
      
        </script>
    </body>

    </html>
