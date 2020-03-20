<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
    $obj= new conectarDB();
    $data= $obj->subconsulta("CALL clientesSelect('".$_GET['clibus']."')");
	$clientes = $data[0]['nombre_cli'];

    if($_GET['del']==0){
        $fedel = date('Y-m-d',strtotime("first day of this month"));
        $feal =  date('Y-m-d',strtotime("last day of this month")); 
    }else{
        $fedel = $_GET['del'];
        $feal = $_GET['al'];
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
				<h4 class="titulos" id="">Control de mermas en recepción</h4>
			</div>
			
            <div class="clienteselect">
                <select class="form-control" name="" id="cliBusca" autofocus>
                    <option value=""></option>
                    <?php
                        $obj = new conectarDB();
                        $data = $obj->consultar("CALL clientesSelect('0')");
                        foreach($data as $key){
                            echo "<option value='".$key['num_cli']."'>".$key['nombre_cli']."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="fechas">
                <label for="" class="control-label">Del</label>
                <input type="date" class="form-control" style="width:160px;padding-left:5px" id="dels" value="<?php echo $fedel ?>">
                <label for="" class="control-label">Al</label>
                <input type="date" class="form-control" style="width:160px;padding-left:5px" id="als" value="<?php echo $feal ?>">
                <i id="ejecuta" class="fas fa-caret-right fa-3x " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar data"></i>
            </div>
            <div class="ayuda">
				<a href="#" onclick="window.open('http:aplicaciones/ayudas/consultaRecepcion.pdf')" /><i class="fas fa-book fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
				<a href="recepcionMermaHtml.php?numcli=<?php echo $_GET['clibus']?>&del=<?php echo $_GET['del'] ?>&al=<?php echo $_GET['al'] ?>"  target="framename"><i class="fas fa-print fa-2x fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir ingreso"></i></a>
            </div> 
       </div>
              
    </header>
    <div id='main'>
      <article class="tabla">
      	<table class="table table-condensed table-bordered table-responsive display compact" id="dataTables">
			<thead>
				<tr class="bg-success">
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Movimiento</th>
					<th class="text-center">Recibido</th>
					<th class="text-center">Recepcion</th>
					<th class="text-center">Transportados</th>
					<th class="text-center">Recibidos</th>
					<th class="text-center">Diferencia</th>
                    <th class="text-center">Merma</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$obj= new conectarDB();
					$data= $obj->subconsulta("CALL mermaCarculo('".$_GET['clibus']."','".$fedel."','".$feal."')");
					$dat= json_encode($data);
					if ($dat=='null') {
						echo '';
					}else{
						foreach ($data as $filas) { ?>
							<tr>
                                <td><?php echo $filas['nombre_cli'] ?></td>
                                <td><?php echo $filas['movimientoEvol'] ?></td>
								<td><?php echo $filas['recibido'] ?></td>
                                <td align="center"><?php echo $filas['documentoEvol'] ?></td>
                              
                                <?php if ($filas['movimientoEvol']=='Totales') {?>    
                                    <td class="bg-danger" align="right"><?php echo number_format($filas['kilos_transportados'],2) ?></td>
                                    <td class="bg-danger" align="right"><?php echo number_format($filas['kilosrecibidos'],2) ?></td>
                                    <td class="bg-danger" align="right"><?php echo number_format($filas['diferencia'],2) ?></td>
                                    <td class="bg-danger" align="right"><?php echo $filas['merma'] ?></td>
                                <?php } else {?>
                                    <td align="right"><?php echo number_format($filas['kilos_transportados'],2) ?></td>
                                    <td align="right"><?php echo number_format($filas['kilosrecibidos'],2) ?></td>
                                    <td align="right"><?php echo number_format($filas['diferencia'],2) ?></td>
                                    <td align="right"><?php echo $filas['merma'] ?></td>    
                                <?php } ?>   
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
    <footer class="dat">
    	<script>
			var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
			var f=new Date();
			document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		</script>
    </footer>
    <div>
        <?php require "aplicaciones/html/footer" ?>
    </div>
    <script type="text/javascript">
            $(document).ready(function () {
                $('#dataTables').dataTable({
                    "order": [[1, 'asc']],
                    "lengthMenu": [[15], [15]],
                });

            }); //fin ready

            $('#ejecuta').on('click', function () {
                var numClie = document.getElementById('cliBusca').value;
                var dels = document.getElementById('dels').value;
                var als = document.getElementById('als').value;
                if(numClie>0){
                    document.location = 'recepcionesMerma.php?clibus=' + numClie + '&del=' + dels + '&al=' + als;
                }else{
                    swal("Data incompleta!", "Debe ingresar el cliente", "error");
                }
            });
            
            

            function documento(docu){
                window.open("recepcionesHtml.php?numRecep=" + docu, "Reporte")
            }
            
            function inventarioExcel() {
            var dat_Clien = idclie;
            document.location.href = ("inventarioDisponibleLoteExcel.php?id_cliente=" + dat_Clien);
        }
    </script>    
  </body>
</html>