<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
    $data= $obj->subconsulta("CALL recepcionesSelect('".$_GET['numRecep']."')");
	$clie = $data[0]['clienteName_recep'];
	$transp = $data[0]['transport_recep'];
	$conduc = $data[0]['conductor_recep'];
	$vehic = $data[0]['vehiculo_recp'];

    switch ($_GET['numCli']){
	       case 14:$idclient= 10;
        break;
			case 30:$idclient= 31;
        break;
		    default:$idclient=$_GET['numCli'];
           // echo $idclient;
    }


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
				<?php include "aplicaciones/nav/menuarriba.html" ?>
			</nav>
		</div>	
		<div class="recepcion">
			<div class="titulo">
				<h3 class="titulos">Incluir productos a recepción</h3>
			</div>
			<div class="ayudarecepcion">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/recepciones.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="javascript: onclick(recepcionpdf())"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir ingreso"></i></a>
                <a href="javascript: onclick(recepciondevolucionespdf())"><i class="fas fa-truck fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir devoluciones"></i></a>
 			</div>
		</div>
    </header>
    <div id='main'>
      <article class="tabla">
      	<form id="formulario" class="formdatos" onsubmit="return agregarRegistro();">
      		<input type="hidden" name="numCli" value="<?php echo $_GET['numCli']; ?>" readonly>
			<input type="hidden" name="modificador" value="<?php echo $usuario ?>">
			<input type="hidden" id="proceso" name="proceso" value="etiquetas">
  	  		<div class="recepcio">
				<label for="" class="">Recepción
					<input type="text" class="form-control " name="numRecep" id="numRecep" value="<?php echo $data[0]['num_recep'];?>" readonly>   
				</label>
				<label for="">Movimiento
					<input type="text" class="form-control" style="" name="movimient"  id="movimient" value="<?php echo $data[0]['movimient_recep'];?>" readonly>
				</label>
				<label for="">Fecha
					<input type="text" class="form-control" name=""  id="fechaingres" value="<?php echo $data[0]['fecha_recep'];?>" readonly>
				</label>
            </div>
            <br>
            <label for="" class="">Código
				<select  value="" class="form-control codigo" name='codi0' id="codi0" required="require">
					<option></option>
					<?php
						$obj= new conectarDB();
						$data= $obj->subconsulta('CALL productosActivosConsulta("'.$idclient.'")');
						foreach ($data as $key) {
								echo "<option value='".$key['num_prod']."'>".$key['codigo_prod']."&nbsp;&nbsp;".$key['descrip_prod']."</option>";
						}
					?>
				</select>
            </label>
            <div class="">   
                <label for="" class="">Lote
                    <input type="text" class="form-control lote" name="lote0" id="lote0">
                </label>
                <label for="" class="">Vencimiento
			        <input type="date" class="form-control" name="vencimi0" id="vencimi0" value="<?php echo date('Y-m-d'); ?>" title="fecha actual incrementada en 30 días" onchange="valida_vencimiento()">
			    </label>   
            </div>
            <div class="emitirCesta">
                <label for="" class="">Etiquetas
			        <input type="text" class="form-control" name="etiquet"  id="etiquet" value="1" style="width:80px">
                </label>
                <label for="" class="">Empaques
                    <input type="text" class="form-control" name="empaque" title="Empaques ingresados cuando el producto se controla en kilos" value=0 style="width:80px">
                </label>
                <label for="" class="">Unidades 
            		<input type="text" class="form-control" name="unidad"  id="unidad"	value="0" style="width:80px">
                </label>    
                <label for="" class="">Total     
                    <input type="text" class="form-control" name="" id="totalUnidades" value=0 readonly style="width:80px">
                </label>
                <label for="" class="">Devueltas
                    <input type="text" class="form-control" name="malas" value=0 style="width:80px">
                </label>
                <label for="" class="">Precio
                    <input type="text" class="form-control" name="precio" value=0 style="width:80px">
                </label>
				<label for="" class="">Tara paleta
                    <input type="text" class="form-control" name="tarapaleta" value=1 style="width:80px">
                </label>
				<label for="" class="">Tara cesta
                    <input type="text" class="form-control" name="taracesta" value=1 style="width:80px">
                </label>
			</div>
     		<div class="almac">
			    <label for="" class="">Almacen
                    <select class="form-control almacen" name="almacen" id="almacen" required="require">
                        <option>disponible</option>
                        <?php
                            $obj= new conectarDB();
							$data= $obj->subconsulta("CALL almacenSelect()");
                            foreach ($data as $key) {
                                echo "<option value='".$key['almacen_almac']."'>".$key['almacen_almac']."</option>";
                            }
                        ?>
                    </select> 
				</label>    
				<label for="" class="">Motivo
                    <select name="motivos0" class="form-control motivo motivo">
                        <option>Conforme</option>
                        <?php
                            $obj= new conectarDB();
                            $data= $obj->subconsulta("CALL almacenMotivos()");
                            foreach ($data as $key) {
								echo "<option class='option' value='".$key['motivo_almacenar']."'>".$key['motivo_almacenar']."</option>";
                            }
                        ?>
                    </select>
                </label>
            </div>
            <div class="boton">
            	<input type="submit" name="reg" id="reg" class="btn btn-success " value="Registrar">
            </div>
            
      	</form>
      </article>
      <nav>
      	<?php include "aplicaciones/nav/menuizquierda.html" ?>
      </nav>
   	  <aside>
   	  	    <label for="" class="">Cliente</label>
            <input type="text" class="form-control" name="" id="cliente_ing" value="<?php  echo $clie;?>" readonly>
            <label for="" class="">Transporte</label>
            <input type="text" class="form-control" name="" id="cliente_ing" value="<?php  echo $transp;?>" readonly>
            <label for="" class="">Conductor</label>
            <input type="text" class="form-control" name="" id="cliente_ing" value="<?php  echo $conduc;?>" readonly>
			<label for="" class="">Vehículo</label>
            <input type="text" class="form-control" name="" id="cliente_ing" value="<?php  echo $vehic;?>" readonly>
      </aside>	
    </div>
    
    <footer class="">
    	<?php echo date('D-d/M/Y') ?>
    	<div class="tablaEtiqueta">
    		<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
				<thead>
					<tr class="bg-success">
						<th class="text-center">Etiqueta</th>
						<th class="text-center">Código</th>
						<th class="text-center">Producto</th>
						<th class="text-center">Lote</th>
						<th class="text-center">Vence</th>
						<th class="text-center">Almacen</th>
						<th class="text-center">Movimiento</th>
						<th class="text-center">Empaques</th>
						<th class="text-center">Unidades</th>
						<th class="text-center">Kilos</th>
						<th class="text-center">Devueltas</th>
						<th class="text-center">Precio</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$obj= new conectarDB();
						$data= $obj->subconsulta("CALL etiquetasSelectRecepcion('".$_GET['numRecep']."')");
						$dat= json_encode($data);
						if ($dat=='null') {
							echo '';
						}else{
							foreach ($data as $filas) { ?>
								<tr>
									<td><?php echo $filas['etiquetaEtiqueta'] ?></td>
									<td><?php echo $filas['codigoEtiqueta'] ?></td>
									<td><?php echo $filas['productoEtiqueta'] ?></td>
									<td><?php echo $filas['loteEtiqueta'] ?></td>
									<td><?php echo $filas['venceEtiqueta'] ?></td>
									<td><?php echo $filas['almacenEtiqueta'] ?></td>
									<td><?php echo $filas['movimientoData'] ?></td>
									<td><?php echo $filas['empaquesEtiqueta'] ?></td>
									<td><?php echo $filas['unidades'] ?></td>
									<td><?php echo $filas['kilos'] ?></td>
									<td><?php echo $filas['malasEtiqueta'] ?></td>
									<td><?php echo $filas['precio'] ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
				</tbody>
			</table>
  	 	</div>
    </footer>
    <div>
		<?php require "aplicaciones/html/footer" ?>
		<script src="aplicaciones/js/recepcionesEtiquetas.js"></script>
	</div>
  </body>
</html>