<?php
  require "aplicaciones/html/indexlogeo";
?>

    <body>
      <div class="container">
        <div class="img">
          <img src="aplicaciones/imagenes/asda.png">
        </div>
        <nav class="circular-menu">
            <div class="circle">
              <a href="index.php" class="fa fa-home fa-3x"></a>
              <a href="indexRegistro.php" class="fa fa-user-plus fa-3x"><span class="logi">Registro</span></a>
              <a href="indexLoguear.php" class="fa fa-user fa-3x"><span class="logi ingresar">Login</span></a>
            </div>
            
            <a href="" class="menu-button fa fa-bars fa-2x"></a>
        </nav>

        <!--reseteo-->
        <div id="reset" class="form-action topregist">
          
          <div class="alertas" id="alertasresetea"></div>
         
					<h1>Resetear contraseňa</h1>
					<p>
						Olvido su contraseña?, ingrese los siguientes datos.
					</p>
					<form id="formularioresetea" onsubmit="return resetea();">
						<input type="hidden" name="proceso" id="resetear" value="resetea"/>
						<input type="number" name="cedul" id="cedularesetear" placeholder="Cedula" autocomplete="off" />
						<input type="text" name="usuario" id="usuarioresetea" placeholder="Usuario" autocomplete="off" />
						<input type="password" name="clave" id="nuevopass"  placeholder="Nueva contraseňa" required="require" autocomplete="off" />
						<div class="mensajeindex">
							<input type="submit" value="Resetear" class="buttonindex" id="rest"/>
						</div>
						

					</form>
				</div>
				
    </div>
    <script src="aplicaciones/js/jquery-3.2.1.min.js"></script>
			
    <script type="text/javascript">
        $(document).ready(function(){
         

        });
        
        var items = document.querySelectorAll('.circle a');
        for(var i = 0, l = items.length; i < l; i++) {
          items[i].style.left = (50 - 35*Math.cos(-0.5 * Math.PI - 2*(1/l)*i*Math.PI)).toFixed(4) + "%";
          items[i].style.top = (50 + 35*Math.sin(-0.5 * Math.PI - 2*(1/l)*i*Math.PI)).toFixed(4) + "%";
        }

        document.querySelector('.menu-button').onclick = function(e) {
          e.preventDefault(); document.querySelector('.circle').classList.toggle('open');
        }
        
        //verifica si la cedula se encuentra registrada
        $('#cedularesetea').on('change', function () {
          var cedu = document.getElementById('cedularesetea').value;
          var url = 'index_funciones.php';
          $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=' + 'lineas' + '&cedula=' + cedu + '&clave=' + 'pera',
            success: function (valores) {
              var datos = eval(valores);
              var linea = datos[0]['lineas'];
              var cedub = datos[0]["cedulaUsuario"];
              if (linea == 0) {
                swal("Data incorrecta!", "La cedula ingresada no se encuentra registrada", "error");
                $('#usuarioresetea').hide();
                $('#nuevopass').hide();
              } else {
                $('#usuarioresetea').show();
              }
            }
          });
        });

        $('#usuarioresetea').on('change', function () {
          var cedu = document.getElementById('cedularesetea').value;
          var usua = document.getElementById('usuarioresetea').value;
          var url = 'index_funciones.php';
          $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=' + 'nCedu' + '&cedula=' + cedu + '&clave=' + 'pera',
            success: function (valores) {
              var datos = eval(valores);
              var cedub = datos[0]["cedulaUsuario"];
              var usuar = datos[0]["usuario"];
              if (usua != usuar) {
                swal("Data incorrecta!", "El usuario no se encuentra registrado", "error");
                $('#nuevopass').hide();
              } else {
                $('#nuevopass').show();
              }
            }
          });
        });

        function resetea() {
          var url = 'index_funciones.php';
          $.ajax({
            type: 'GET',
            url: url,
            data: $('#formularioresetea').serialize(),
            success: function (data) {
              if (data == 'Registro completado con exito') {
                $('#alertasresetea').addClass('mensaje').html('La contraseňa fue actualizada').show(200).delay(2500).hide(200);
                setTimeout('location.reload()', 3550);
              } else {
                $('#rest').show();
                $('#alertasresetea').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
              }
            }
          });
          return false;
        }

        function deshabilitaRetroceso(){
            window.location.hash="no-back-button";
            window.location.hash="Again-No-back-button" //chrome
            window.onhashchange=function(){window.location.hash="no-back-button";}
        }
    </script>
  </body>
</html>    