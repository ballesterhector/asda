<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';

    require "aplicaciones/html/head";
?>

    <body>
        <header>
            <input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
            <input type="hidden" id="usuari" value="<?php echo $usuario ?>">

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
                    <h3 class="titulos" id="respuesta">Data resumen almacen paletas</h3>
                </div>
                <div class="ayudarecepcion">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/almacenPaletas.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
                    <a href="javascript: onclick(reportepdf())"><i class="fas fa-file-pdf fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte resumen"></i></a>
                    <input type="button" name="nuevo" id="nuevo" class="btn btn-success " value="Transferir">
                </div>
        </header>
        <div id='main' >
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Número</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Llenas</th>
                            <th class="text-center">Vacias</th>
                            <th class="text-center">Dañadas</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="2" style="text-align:right">Total:</th>
                            <th class="dt-right"></th>
                            <th class="dt-right"></th>
                            <th class="dt-right"></th>
                            <th class="dt-right"></th>
                        </tr>
                    </tfoot>

                    <tbody>
                        <?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL almacenPaletasResumen()");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
                            <tr>
                                <td><?php echo $filas['idcliente_almpale'] ?></td>
                                <td><?php echo $filas['cliente_almpale'] ?></td>
                                <td class="dt-right"><?php echo $filas['llenas'] ?></td>
                                <td class="dt-right"><?php echo $filas['vacias'] ?></td>
                                <td class="dt-right"><?php echo $filas['malas'] ?></td>
                                <td class="dt-right"><?php echo $filas['total'] ?></td>
                                <td class="icono">
                                    <a href='javascript:resumen(<?php echo $filas['idcliente_almpale'] ?>,<?php echo $niveles ?>)' class='glyphicon glyphicon-folder-open' title='Evolución paletas' </a>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                    </tbody>
                </table>
            </article>
            <nav>
                <?php include "aplicaciones/nav/menuizquierda.html" ?>
            </nav>
        </div>
        <!--Inicio modal nuevo-->
        <div class="form-group">
            <div class="modal fade" id="abreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width:420px">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h3 class="modal-title" id="myModalLabel">Transferencia de paletas</h3>
                            <h2 class="mensajepick" id="mensajepick"></h2>
                        </div>
                        <form id="formulario" class="form-horizontal" onsubmit="return agregarRegistro();">
                           <input type="hidden" name="modificador" value="<?php echo $usuario ?>">
                            <div class="modal-body">
                               <input type="hidden" id="proceso" name="proceso">
                                <section class="paletas">
                                    <article class="modaldata">
                                        <div class="ladoA">
                                            <label for="" class="">Cliente</label>
                                            <div class="">
                                                <select class="form-control" name="numCli" id="numCli" required="require">
												<option value=""></option>
												<?php
													$obj = new conectarDB();
													$data = $obj->consultar("CALL clientesActivosConsulta('0')");
													foreach($data as $key){
														echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
													}
												?>
											</select>
                                            </div>
                                        </div>
                                        <div class="ladoB">
                                            <label for="inputEmail6" class="">Salen de</label>
                                            <div class="">
                                                <select name="sale_de" class="form-control" id="sale_de" required>
                                                <option></option>
                                                <option value="llena">Llena</option>
                                                <option value="vacia">Vacia</option>
                                                <option value="malas">Dañadas</option>
                                            </select>
                                            </div>
                                            <label for="inputEmail6" class="">Llegan a</label>
                                            <div class="">
                                                <select name="llegan_a" id="llegan_a" class="form-control" required>
                                                <option></option>
                                                <option value="llena">Llena</option>
                                                <option value="vacia">Vacia</option>
                                                <option value="malas">Dañadas</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="ladoC" style="padding-top:10px">
                                            <label for="inputEmail6" class="control-label" style="padding-right:30px">Cantidad</label>
                                            <div class="">
                                                <input type="text" id="palet" name="paletas" class="form-control" style="width:90px" value="0">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="" class="control-label">Motivo</label>
                                            <input type="text" class="form-control" name="motivo" required>
                                        </div>
                                    </article>
                                </section>
                            </div>
                            <div class="pieData bg-success">
                                <div class="boton">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
                                </div>
                                <div class="submit">
                                    <input type="submit" class="btn btn-success" id="regsp" value="Procesar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin modal nuevo-->
        <footer class="dat">
            <script>
                var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
                var f = new Date();
                document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

            </script>
        </footer>
        <div>
            <?php require "aplicaciones/html/footer"  ?>
            <script src="aplicaciones/js/almacenPaletasResumen.js"></script>
        </div>
    </body>
    
</html>
