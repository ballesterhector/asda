<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
	$data= $obj->subconsulta("CALL productosConsultaProducto('".$_GET['cod']."')");
	$codigProdc = $data[0]['codigo_prod'];

    $obj= new conectarDB();
	$datapicking= $obj->subconsulta("CALL pickinglistPorNumero('".$_GET['id_picking']."')");
	

    require "aplicaciones/html/head";

?>

    <body>
        <header>
            <input type="hidden" value="<?php echo $niveles ?>" id="nivelUsuario">
            <input type="hidden" value="<?php echo $_GET['id_picking'] ?>" id="id_picking">
            <input type="hidden" value="<?php echo $_GET['cod'] ?>" id="cod">
            <input type="hidden" value="<?php echo $_GET['valor'] ?>" id="valorUrl">
            <div class="menu">
                <div class="logo">
                    <a href="#"><img src="aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
                </div>
                <nav class="enlaces" id="enlaces">
                    <?php include "aplicaciones/nav/menuarriba.html" ?>
                </nav>
            </div>
            <div class="enlinea">
                <div class="titulo">
                    <h3 class="titulos">Asignar etiquetas a piking list</h3>
                </div>
                <div class="nuevo">
					<a href="#" onclick="window.open('http:aplicaciones/ayudas/pickinglist.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				</div>
            </div>
        </header>
        <div id='main'>
            <article class="tabla">
                <table class="table table-condensed table-bordered table-responsive letras3 display compact" id="dataTables">
                    <thead>
                        <tr class="bg-info">
                            <th class="text-center">Ubicación</th>
                            <th class="text-center">Almacen</th>
                            <th class="text-center">Coordenada</th>
                            <th class="text-center">Etiqueta</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Lote</th>
                            <th class="text-center">Vencimiento</th>
                            <th class="text-center">Unidades</th>
                            <th class="text-center">Empaques</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $obj= new conectarDB();
							    $data= $obj->subconsulta("CALL inv_Disponible('".$_GET['cod']."','".$_GET['clienteID']."')");
                                $dat= json_encode($data);
                                if ($dat=='null') {
                                    echo '';
                                }else{		
                                    foreach ($data as $filas){ if($filas['almacenEtiqueta']=='disponible'){ ?>
                            <tr>
                                <td class=""><?php echo $filas['ubicaEtiqueta'] ?></td>
                                <td class=""><?php echo $filas['almacenEtiqueta'] ?></td>
                                <td class=""><?php echo $filas['coordenadaEtiqueta'] ?></td>
                                <td class=""><?php echo $filas['etiquetaEvol'] ?></td>
                                <td class=""><?php echo $filas['codigoEtiqueta'] ?></td>
                                <td class=""><?php echo $filas['productoEtiqueta'] ?></td>
                                <td class=""><?php echo $filas['loteEtiqueta'] ?></td>
                                <td class=""><?php echo $filas['venceEtiqueta'] ?></td>
                                <td class=""><?php echo $filas['unidades'] ?></td>
                                <td class=""><?php echo $filas['empaques'] ?></td>
                                <td class="text-center">
                                    <a href=javascript:editar(<?php echo $filas[ 'etiquetaEvol'] ?>,<?php echo $filas['empaques'] ?>) class="glyphicon glyphicon-edit" title="Bajar data" ></a></td>
                                </td>
                            </tr>
                            <?php }else{ ?>
                            <tr>
                                <td class="text-danger bg-danger"><?php echo $filas['ubicaEtiqueta'] ?></td>
                                <td class="text-danger bg-danger"><?php echo $filas['almacenEtiqueta'] ?></td>
                                <td class="text-danger bg-danger"><?php echo $filas['coordenadaEtiqueta'] ?></td>
                                <td class="text-danger bg-danger"><?php echo $filas['etiquetaEvol'] ?></td>
                                <td class="text-danger bg-danger"><?php echo $filas['codigoEtiqueta'] ?></td>
                                <td class="text-danger bg-danger"><?php echo $filas['productoEtiqueta'] ?></td>
                                <td class="text-danger bg-danger"><?php echo $filas['loteEtiqueta'] ?></td>
                                <td class="text-danger bg-danger"><?php echo $filas['venceEtiqueta'] ?></td>
                                <td class="text-danger bg-danger"><?php echo $filas['unidades'] ?></td>
                                <td class="text-danger bg-danger"><?php echo $filas['empaques'] ?></td>
                                <td class="text-center">
                                    <a href=javascript:editar(<?php echo $filas[ 'etiquetaEvol'] ?>,<?php echo $filas['empaques'] ?>) class="glyphicon glyphicon-edit" title="Bajar data" ></a></td>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>

                    </tbody>
                </table>
            </article>
            <nav>
                <?php include "aplicaciones/nav/menuizquierda.html" ?>
            </nav>
            <aside>
                <?php 
                    $obj= new conectarDB();
					$data= $obj->subconsulta("CALL 	pickinglistPorNumero('".$_GET['id_picking']."')");
					foreach ($data as $filas) { ?>
                <div class="datospcicking">
                    <label class="">Picking List</label>
                    <input type="text" name="" class="form-control" value="<?php echo $_GET['id_picking'] ?>" disabled><br>
                    <label class="">Cliente</label>
                    <input type="text" name="" class="form-control" value="<?php echo $filas['clientePickingNomb'] ?>" disabled><br>
                    <label class="">Código</label>
                    <div class="">
                        <select class="form-control " name="codiPicki" id="codiPicki" value="">
                                    <option><?php echo $codigProdc; ?></option>
                                    <?php 
                                        $obj= new conectarDB();
                                        $data= $obj->subconsulta("CALL inv_DisponibleParaSelecPiking('".$_GET['clienteID']."')");
                                        foreach ($data as $key) {
                                            echo "<option value='".$key['idproductoEtiqueta']."'>".$key['codigoEtiqueta']."</option>";
                                        }	
                                    ?>
                                </select>
                    </div>
                    <div class="pedidas">
                        <label class="control-label">Pedidas
                            <input type="text" class="form-control" style="width: 80px" name="pedidaPicki" id="pedidaPicki" value="<?php echo $_GET['valor']; ?>">
                        </label>
                        <label class="control-label">Bajadas
                            <input type="text" class="form-control" style="width: 80px" name="bajadas" id="bajadas" value="0" disabled="">
                        </label>
                    </div><br>
                    <div class="nuevo">
                        <a class='glyphicon glyphicon-export btn-lg' id="solicita" title="Solicitar código" href="javascript: onclick(solicitarCodigo())"></a>
                        <a class='glyphicon glyphicon-print btn-lg' title="Imprimir picking list" href="#" onclick="imprimir()"></a>
                    </div>
                </div>

                <?php } ?>
            </aside>
        </div>
        <article>
            <!-- Inicio Modal-->
            <div class="modal fade" id="abreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h4 class="modal-title" id="myModalLabel"><b>Bajar data</b></h4>
                             <h2><div id="alerta"></div></h2>
                        </div>

                        <form id="formulario" class="form-horizontal martop2 hover" onsubmit="return agregarRegistro();" style="margin-top:-30px">
                            <div class="modal-body">
                                <div class="form-group" style="margin-top:30px">
                                    <div class="form-group col-sm-12">
                                        <label for="" class="col-sm-4 control-label">Proceso</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-center" required="required" readonly="readonly" id="proceso" name="proceso">
                                            <input type="hidden" class="form-control" name="movimiento" id="movimiento" value="<?php echo $datapicking[0]['movimientoPicking'] ?>">
                                            <input type="hidden" class="form-control" name="arranq" id="arranq" value="<?php echo $datapicking[0]['arranquePicking'] ?>">
                                            <input type="hidden" class="form-control" name="fechapick" id="fechapick" value="<?php echo $datapicking[0]['fechaPicking'] ?>">
                                            <input type="hidden" class="form-control" name="ingrKilo" id="kilo">
                                            <input type="hidden" id="usuamodi" name="usuamodi" value="<?php echo $usuario;?>">
                                            <input type="hidden" class="form-control" value="<?php echo $_GET['cod'] ?>" name="codigoid" id="codigoid">
                                            <input type="hidden" value="<?php echo $_GET['clienteID'] ?>" name="nCliente" id="nCliente">
                                        </div>

                                        <label for="" class="col-sm-2 control-label">Picking</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?php echo $_GET['id_picking'] ?>" name="idpPick" id="idpPick" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="" class="col-sm-4 control-label">Etiqueta</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="etiquetaS" id="etiquetaS" readonly>
                                        </div>
                                        <label for="" class="col-sm-2 control-label">Disponibles</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="" id="disponible" value="0" readonly>
                                        </div>
                                    </div>    
                                    <div class="form-group col-sm-12">
                                        <label for="" class="col-sm-4 control-label">Unidades Pedidas</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="" id="pedidas" readonly>
                                        </div>
                                        <label for="" class="col-sm-2 control-label">Bajadas</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="" id="bajadasevol" value="0" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="" class="col-sm-4 control-label">Empaques pedidos</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="empaque" id="empaque" value="0" onchange="verEmpaque()">
                                        </div>
                                        <label for="" class="col-sm-2 control-label">A bajar</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="abajar" id="abajar" value="0" readonly>
                                        </div>
                                    </div>
                                </div>
                                <!--fin div modal body-->
                                <div class="modal-footer bg-info">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" id='clos' style="text-align: right; ">Close</button>
                                    <input type="submit" value="Despachar" class="btn btn-warning" id="reg" style="width: 90px">
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Modal-->
        </article>
        <footer class="dat">
            <?php echo date('D-d/M/Y') ?>
        </footer>
        <div>
            <?php require "aplicaciones/html/footer" ?>
            <script src="aplicaciones/js/pickingListCodigos.js"></script>
        </div>
    </body>

    </html>
