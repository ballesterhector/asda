<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';
	
	
?>
<?php require "aplicaciones/html/head"; ?>
<body>
    <header>
    	<input type="text" value="<?php echo $niveles ?>" id="nivelUsuario">
		<input type="text" id="usuari" value="<?php echo $usuario ?>">
		
		<div class="menu">
			<div class="logo">
				<a href="#"><img src="aplicaciones/imagenes/asda.png" alt="" class="" style=""><sub>CND</sub></a>
			</div>
			<nav class="enlaces" id="enlaces">
				<?php include "aplicaciones/nav/menuarriba.html" ?>
			</nav>
		</div>
		<div>
		    <div class="enlinea">
		    	<div class="titulo">
			    	<h3 class="titulos" id="">Etiquetas evolución</h3>
			    </div>
		    </div>
			
		<div>
				<select class="form-control" name="" id="cliBusca" autofocus>
						<option value=""></option>
							<?php
								$obj = new conectarDB();
								$data = $obj->consultar("CALL etiquetaPorEtiqueta('3762')");
								foreach($data as $key){
									echo "<option value='".$key['etiquetaEtiqueta']."'>".$key['etiquetaEtiqueta']."</option>";
								}
							?>
						</select>
			</div>
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
		<script src="../aplicaciones/js/inventarioEvolucion.js"></script>
	</div>
  </body>
</html>            