<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL transferenciasSelect('".$_GET['transf']."')");
	$clientes = $data[0]['clienteTransfe'];
    $lleg = $data[0]['idclienteLlega'];

    
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
                    <h4 class="titulos" id="alerta">Transferencia de unidades entre clientes</h4>
                </div>
                <h4><div id="respuesta"></div></h4>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/modificacionesEtiquetas.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                    <a href="javascript: onclick(recepcionpdf())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir ingreso"></i></a>
                
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
                        <div class="usua"><p>Usuario</p> <input type="text" name="usua" id="modificador" class="form-control" value="<?php echo $usuario ?>" readonly></div>
                        <div class="usua"><p>Cliente sale</p> <input type="text" name="" id="client" class="form-control" value="<?php echo $data[0]['clienteTransfe'] ?>" disabled></div>
                        <div class="usua"><p>Cliente llega</p> 
                            <?php  
                                $obj= new conectarDB();
                                $data =$obj->subconsulta("CALL clientesSelect('".$lleg."')");
                            ?>
                        	<input type="text" class="form-control" value='<?php echo $data[0]['nombre_cli'] ?>' disabled>
                        </div>
                        <?php  
                           $obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL transferenciasSelect('".$_GET['transf']."')");
                        ?>
                            
                        <input type="hidden" name="idclient" id="clie" class="form-control" value="<?php echo $data[0]['idclienteTransfe'] ?>" readonly>
                        <div class="usua"><p>Transferencia</p> <input type="text" name="transfe" id="transf" class="form-control" value="<?php echo $data[0]['numeroTransfe'] ?>" readonly></div>
                        <div class="usua"><p>tipo</p> <input type="text"  name="tipo" class="form-control" value="<?php echo $data[0]['tipoTransfe'] ?>" readonly></div>
                        <div class="usua"><p>Fecha</p> <input type="text" name="fechatrasf" id="date" class="form-control" value="<?php echo $data[0]['fechaTrasfe'] ?>" readonly></div>
                        <div class="usua"><p>Movimiento</p> <input type="text" id="movim" class="form-control" value="transferencia" readonly></div>
                        <input type="hidden" name="idclientlleg" id="llega" class="form-control" value="<?php echo $data[0]['idclienteLlega'] ?>">
                    </div>
                      <div class="etique">
                        <div class=""><p>Etiqueta</p> 
                            <select class="form-control" name="etiqu" id="etiqu" required="require">
                                <option></option>
                                <?php
                                    $obj= new conectarDB();
                                    $data= $obj->subconsulta('CALL inv_DisponiblePorEtiqueta("'.$data[0]['idclienteTransfe'].'")');
                                    foreach ($data as $key) {
                                        echo "<option value='".$key['etiquetaEvol']."'>".$key['etiquetaEvol']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <?php  
                           $obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL transferenciasSelect('".$_GET['transf']."')");
                        ?>
                        <div class=""><p>Código</p> <input type="text" id="codg" class="form-control" readonly></div>
                        <div class=""><p>Producto</p> <input type="text" id="produc" class="form-control" readonly></div>
                        <div class=""><p>lote</p> <input type="text" name="lote0" id="lote" class="form-control" readonly></div>
                        <div class=""><p>Vencimiento</p> <input type="text" name="vencimi0" id="vence" class="form-control" readonly></div>
                        <div class=""><p>Empaques</p> <input type="text" id="empaq" class="form-control" readonly></div>
                        <div class=""><p>Unidades</p> <input type="text" id="unidades" class="form-control" readonly></div>
                        <div class=""><p>Almacen</p><input type="text" class="form-control" name="almacen" id="almacen" readonly></div>
                        <div class=""><p>Motivo</p><input type="text" class="form-control" name="motivo" id="motivo" readonly></div>
                        <div class=""><p>Precio</p> <input type="text" name="preci" id="preci" class="form-control" readonly></div>
                        <input type="hidden" class="" name="idcodig" id="idcodig">
                        <input type="hidden" name="proceso" value="evolinsert">
                        <input type="hidden" name="movimie" value="<?php echo $data[0]['tipoTransfe'] ?>">
                        <input type="hidden" name="etiquetas" value="1">
                        <input type="hidden" name="malas" value="0">
                    </div>
                </article>

                <aside class="transfe">
                    <div class="almacen">
                        <label for="" class="">Empaques</label>  
                       <input type="text" class="form-control" id="empaque" name="empaque" style="width:100px" value="0" autocomplete="off">
                    </div>
                    <div class="almacen">
                        <label for="" class="">Unidades</label>  
                       <input type="text" class="form-control" id="unidad" name="unidad" style="width:100px" value="0" autocomplete="off">
                        <i id="ejecuta" class="fas fa-caret-right fa-3x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i>
                    </div>
                </aside>
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
                var url = 'transferenciasClientes_Funciones.php';
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
                        $('#motivo').val(datos[0]['motivoEtiqueta']);
                    }
                });
                return false;
            });
            
            $('#ejecuta').on('click',function(){
                $('#ejecuta').hide();
                var url = 'transferenciasClientes_Funciones.php';
                var unid = document.getElementById('unidad').value;
                if(unid>0){
                    $.ajax({
            		type:'GET',
            		url:url,
            		data:$('#formulario').serialize(),
            		success: function(data){
            			if (data=='Registro completado con exitoRegistro completado con exitoRegistro completado con exitoRegistro completado con exitoRegistro completado con exito') {
            				$('#alerta').addClass('mensaje').html('Transferencia procesada').show(200).delay(2500).hide(200);
            				let actualiza= new Promise((resolve, reject) => {
                               setTimeout(function(){
                                    location.reload();
                                }, 1000);
                            });
            			}else {
            				$('#alerta').addClass('mensajeError').html('Transferencia fallida por datos incompletos').show(200).delay(2500).hide(200);
            			    let actualiza= new Promise((resolve, reject) => {
                               setTimeout(function(){
                                    location.reload();
                                }, 1700);
                            });     
                        }   
            		}
            	});
                }else{
                    swal("Oops!", "Debe indicar las unidades a transferir", "error");    
                }
            	  
            	return false;
            });
            
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
                        window.open("transferenciasClientesHtml.php?trasfe=" + inputValue, "Reporte")
                    });
            }
      
        </script>
    </body>

    </html>
