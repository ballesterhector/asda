<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL clientesSelect('".$_GET['clibus']."')");
	$clientes = $data[0]['nombre_cli'];

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
                    <h4 class="titulos">Actualizar almacen de las etiquetas</h4>
                </div>
                <h4><div id="respuesta"></div></h4>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:.plicaciones/ayudas/modificacionesEtiquetas.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                </div>
            </div>
        </header>

        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Etiqueta</th>
                            <th class="text-center">Ubicación</th>
                            <th class="text-center">Almacen</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Lote</th>
                            <th class="text-center">Vencimiento</th>
                             <th class="text-center">Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL etiquetasPorRango('".$_GET['clibus']."','".$_GET['del']."','".$_GET['al']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['etiquetaEvol'] ?></td>
                                            <td><?php echo $filas['ubicaEtiqueta'] ?></td>
                                            <td ><?php echo $filas['almacenEtiqueta'] ?></td>
                                            <td><?php echo $filas['codigoEtiqueta'] ?></td>
                                            <td><?php echo $filas['productoEtiqueta'] ?></td>
                                            <td><?php echo $filas['loteEtiqueta'] ?></td>
                                            <td><?php echo $filas['venceEtiqueta'] ?></td>
                                            <td><?php echo $filas['codimodificacion'] ?></td>
                                        </tr>
                                    <?php } ?>        
                        <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
            </article>
            <nav>
                <?php include "aplicaciones/nav/menuizquierda.html" ?>
            </nav>
            <aside>
               <div class="clienteselect">
                    <select class="form-control" name="" id="cliBusca" autofocus>
                        <option value="<?php echo $_GET['clibus'] ?>"><?php echo $clientes ?></option>
                        <?php
                            $obj = new conectarDB();
                            $data = $obj->consultar("CALL clientesSelect('0')");
                            foreach($data as $key){
                                echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
                                }
                        ?>
                    </select>
                </div>
                <div class="del">
                    <label for="" class="">Del</label>
                    <input type="text" class="form-control" style="width:90px;" id="dels" value="<?php echo $_GET['del'] ?>">
                    <label for="" class="">Al</label>
                    <input type="text" class="form-control" style="width:90px;" id="als" value="<?php echo $_GET['al'] ?>">
                    <i id="ejecuta" class="fas fa-caret-right fa-3x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i>
                </div>
                <div class="almacen">
                    <label for="" class="control-label">Almacen</label>
                	<select class="form-control" name="almacen" id="almacen" style="width:250px" required="require">
                		<option></option>
                		<?php
                			$obj= new conectarDB();
                			$data =$obj->subconsulta("CALL almacenSelect()");
                    		foreach ($data as $key) {
                	    		echo "<option value='".$key['almacen_almac']."'>".$key['almacen_almac']."</option>";
                			}
                 		?>
                	</select>
                </div>
                <div class="almacen">
                    <label for="" class="control-label">Motivo</label>
                	<select class="form-control" name="motivo" id="motivo" style="width:240px;text-transform: lowercase;" required="require">
                		<option></option>
                		<?php
                			$obj= new conectarDB();
                			$data =$obj->subconsulta("CALL almacenMotivos()");
                    		foreach ($data as $key) {
                	    		echo "<option value='".$key['motivo_almacenar']."'>".$key['motivo_almacenar']."</option>";
                			}
                 		?>
                	</select>
                	    <i id="modifica" class="fas fa-caret-right fa-3x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i>
                </div>
                											
            </aside>
        </div>
        
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

            }); //fin ready

            $('#ejecuta').on('click', function () {
                var dels = document.getElementById('dels').value;
                var als = document.getElementById('als').value;
                var numClie = document.getElementById('cliBusca').value;
                if(numClie>0){
                    document.location = 'modificarAlmacen.php?clibus=' + numClie + '&del='+ dels + '&al=' + als;
                }else{
                    swal("Data incompleta!", "Debe ingresar el cliente", "error");
                }
                
            });
            
            $('#modifica').on('click',function(){
                var url = 'modificaUbicacion_Funciones.php';
                var clien = <?php echo $_GET['clibus'] ?>;
                var del = <?php echo $_GET['del'] ?>;
                var al = <?php echo $_GET['al'] ?>;
                var ubic = document.getElementById('almacen').value;
                var user = document.getElementById('modificador').value;
                var motiv = document.getElementById('motivo').value;
                $('#modifica').hide();
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'proceso=' + 'modificaAlmacen' + '&clie=' + clien + '&del=' + del + '&al=' + al + '&ubic=' + ubic + '&usua=' + user + '&motiv=' + motiv,
                    success: function(data) {
                        if (data == 'Registro completado con exito') {
                            $('#respuesta').addClass('mensaje').html(data).show(200).delay(500).hide(200);
                            setTimeout('location.reload()', 550);
                        } else {
                            $('#respuesta').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
                        }
                    }
                });
                return false;
            });
            
            function documento(docu){
                window.open("despachosHtml.php?num=" + docu, "Reporte")
            }
            
            function inventarioExcel() {
            var dat_Clien = idclie;
            document.location.href = ("inventarioDisponibleLoteExcel.php?id_cliente=" + dat_Clien);
        }

        function emitidas() {
            var dels = document.getElementById('dels').value;
            var als = document.getElementById('als').value;
            var numClie = <?php echo $_GET['clibus'] ?>;
            window.open('despachosEmitidosPdf.php?id_cliente=' + numClie + '&del='+ dels + '&al=' + als, 'reporte');
        }
        </script>
    </body>

    </html>
