<?php
	require 'aplicaciones/php/session_start.php';
	
    require 'conectarBD/conectarASDA.php';
    
    require "aplicaciones/html/head";

?>
    <body>
        <header>
            <input type="text" value="<?php echo $niveles ?>" id="nivelUsuario">
            <input type="text" value="<?php echo $nomClie ?>" id="nCliente">
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
                    <h3 class="titulos">Registro de insumos</h3>
                </div>
                <div class="ayuda">
                    <a href="#" onclick="window.open('http:aplicaciones/ayudas/suministrosInsumos.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
                    <a href='suministrosProductosExcel.php'><i class="fas fa-file-excel fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Reporte excel"></i></a>
                </div>
            </div>
                <div id="respuesta" class="respuesta"></div>
        </header>
        <div id='main'>
            <nav>
                <?php include "aplicaciones/nav/menuizquierdaSuministros.html" ?>
            </nav>
            <div class="ladoA">
                <form id="formulario" class="form-horizontal compras" onsubmit="return rubro();">   
                    <input type="hidden" name="proceso" value="rubros">
                    <div>
                        <label for="" class="">Rubro
                            <input type="number" class="form-control" name="rubro" id="rubro" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Indique el rubro" min="0" max="9999" placeholder="0000" required="require">
                        </label>
                        <label for="" class="">Detalle
                            <input type="text" class="form-control" name="rubrodetall" id="rubrodetall"  maxlength="50" required="require">
                        </label>
                        <button type="submit" class="rubrobtn"><i class="fas fa-download fa-2x"></i></button>
                    </div>
                </form>
                <form id="formulario1" class="form-horizontal compras" onsubmit="return clases();">   
                    <input type="hidden" name="proceso" value="clase">        
                    <div>    
                        <label for="" class="tamano3">Clase 
                           <input type="number" class="form-control" name="clase" id="clase"  min="0" max="9999" placeholder="0000" required="require"> 
                        </label>   
                        <label for="" class="">Detalle
                            <input type="text" class="form-control" name="clasedetall" id="clasedetall"  maxlength="80" required="require">
                        </label>
                        <button type="submit" class="rubrobtn"><i class="fas fa-download fa-2x"></i></button>
                    </div>
                </form>
                <form id="formulario2" class="form-horizontal compras" onsubmit="return subclase();">    
                    <input type="hidden" name="proceso" value="subclase">                 
                    <div class="clseselectsub">
                        <label for="" class="">Rubro  
                            <select class="form-control" name="rubro" id="rubro" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Indique el rubro" min="0" max="9999" placeholder="0000" required="require">
                                <option></option>
                                <?php
                                    $obj= new conectarDB();
                                    $data= $obj->subconsulta("CALL suministroRubroSelect(0)");
                                    foreach ($data as $key) {
                                        echo "<option value='".$key['sumirubro']."'>".$key['rubro']."</option>";
                                    }
                                ?>
                            </select>
                        </label>
                        <label for="" class="">Clase  
                            <select class="form-control" name="clase" id="clase"  min="0" max="9999" placeholder="0000" required="require">
                                <option></option>
                                <?php
                                    $obj= new conectarDB();
                                    $data= $obj->subconsulta("CALL suministorClaseSelect(0)");
                                    foreach ($data as $key) {
                                        echo "<option value='".$key['sumiclase']."'>".$key['clase']."</option>";
                                    }
                                ?>
                            </select>  
                        </label>   
                        <label for="" class="">Detalle
                            <input type="text" class="form-control" name="subclassdetall" id="subclassdetall"  maxlength="180" required="require">
                        </label>
                         <button type="submit" class="rubrobtn"><i class="fas fa-download fa-2x"></i></button>
                    </div>

                </form>
            </div>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Código</th>
                            <th class="text-center">Rubro</th>
                            <th class="text-center">Clase</th>
                            <th class="text-center">Subclase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							$obj= new conectarDB();
	                        $data= $obj->subconsulta("CALL suministrosSelect()");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{
                                    foreach ($data as $filas) { ?>
                                        <tr>
                                            <td><?php echo $filas['codigo'] ?></td>
                                            <td><?php echo $filas['rubros'] ?></td>
                                            <td><?php echo $filas['clases'] ?></td>
                                            <td ><?php echo $filas['subclase'] ?></td>
                                        </tr>
                                        
                                <?php } ?>
                            <?php } ?>
                            <!--Fin del if $dat-->
                    </tbody>
                </table>
            </article>
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
            <script src="aplicaciones/js/suministros.js"></script>
        </div>
    </body>

    </html>
