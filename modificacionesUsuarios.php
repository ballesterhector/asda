<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    
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
                    <h4 class="titulos">Modificaciones a usuarios</h4>
                </div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/modificacionesProcesos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Manual"></i></a>
                </div>
            </div>
        </header>

        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables" style>
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Fecha modificación</th>
                            <th class="text-center">Modificado por</th>
                            <th class="text-center">Nivel</th>
                            <th class="text-center">Sucursar</th>
                            <th class="text-center">Gerencia</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Teléfono</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL usuariosModificaciones()");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['usuarioModifica'] ?></td>
                                            <td><?php echo $filas['fechaControl'] ?></td>
                                            <td><?php echo $filas['modificadoPor'] ?></td>
                                            <td><?php echo $filas['nivelModifica'] ?></td>
                                            <td><?php echo $filas['sucursarModifica'] ?></td>
                                            <td><?php echo $filas['gerenciaModifica'] ?></td>
                                            <td><?php echo $filas['areaModifica'] ?></td>
                                            <td><?php echo $filas['emailModifica'] ?></td>
                                            <td><?php echo $filas['telefonoModifica'] ?></td>
                                            <td><?php echo $filas['estadoModifica'] ?></td>
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
                    "order": [[2, 'asc']],
                    "lengthMenu": [[10], [10]]
                });

            }); //fin ready
            
            function modificaExcel() {
                document.location.href = ('modificaConductoresExcel.php');
            }
            
        </script>
    </body>

    </html>
