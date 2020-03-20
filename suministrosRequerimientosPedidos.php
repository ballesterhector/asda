<?php
	require 'aplicaciones/php/session_start.php';
	
    require 'conectarBD/conectarASDA.php';
    
    require "aplicaciones/html/head";

?>

    <body>
        <header>
            <input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
            <div class="menu">
                <div class="logo">
                    <a href="#"><img src="aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
                </div>
                <nav class="enlaces" id="enlaces">
                    <?php include "aplicaciones/nav/menuarribaSuministros.html" ?>
                </nav>
            </div>
            <div class="enlinea">
                <div class="titulo">
                    <h3 class="titulos">Suministros solicitud de insumos</h3>
                </div>
                <div id="respuesta" class="respuesta"></div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/suministrosSolicitudInsumos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
                </div>
            </div>
        </header>
        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Número</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Sucursar</th>
                            <th class="text-center">Gerencia</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL suministrosPedidos_Select()");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['numrequerimiento'] ?></td>
                                            <td><?php echo $filas['fecha'] ?></td>
                                            <td><?php echo $filas['usuariopedido'] ?></td>
                                            <td><?php echo $filas['sucursar'] ?></td>
                                            <td><?php echo $filas['gerencia'] ?></td>
                                            <td><?php echo $filas['area'] ?></td>
                                            <td class="text-center">
                                                <a href='javascript:insumos(<?php echo $filas['numrequerimiento'] ?>)' class='glyphicon glyphicon-folder-open' title='Incluir insumos'</a>
                                            </td>
                                        </tr>
                                        
                                <?php } ?>
                            <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
            </article>
            <nav>
                <?php include "aplicaciones/nav/menuizquierdaSuministros.html" ?>
            </nav>
            <div class="ladoA">
                <form action="" id="formulario" class="" onsubmit="return pedidos();">
                    <input type="hidden" name="proceso" value="pedido">
                    <input type="hidden" value="<?php echo $nombre ?>" name="name">
                    <input type="hidden" value="<?php echo $sucur ?>" name="sucur">
                    <input type="hidden" value="<?php echo $geren ?>" name="gerenc">
                    <input type="hidden" value="<?php echo $area ?>" name="area">
                   
                    <div class="comprasB">   
                        <label for="" class="">Fecha
                            <input type="text" class="form-control tamano" name="fecha" value="<?php echo date('Y-m-d') ?>" style="width:120px" readonly autocomplete="off">
                        </label>
                        <label for="" class="">Proveedor sugerido
                            <input type="text" class="form-control comprasTamano tamano" name="proveedor" style="width:370px">
                        </label>
                    </div>
                    <div class="comprasG">   
                        <label for="" class="">Teléfono
                            <input type="text" class="form-control" style="width:120px;text-align:center" name="telef">
                        </label>
                        <label for="" class="">Contacto
                            <input type="text" class="form-control" name="contacto" style="width:370px">
                        </label>
                    </div>
                    <div class="comprasF">
                        <label for="" class="control-label">Exposición de motivos </label>
                        <textarea size="20" name="motivo" rows="3" cols="15" style="width:100%;height:70px" required></textarea>
                    </div>  
                    <div class="comprasE">
                        <button type="submit" class="rubrobtn" id="reg" style="width:80px"><i class="fas fa-download fa-2x"></i></button>
                    </div> 
                </form>
            </div>
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
            <?php require "aplicaciones/html/footer"  ?>
            <script src="aplicaciones/js/suministrosRequerimientos.js"></script>
        </div>
    </body>

    </html>
