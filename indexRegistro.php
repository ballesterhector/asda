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
              <a href="indexLoguear.php" class="fa fa-user-plus fa-3x"><span class="logi">Login</span></a>
              <a href="indexReseteo.php" class="fa fa-address-card fa-3x"><span class="logi">Resetear</span></a>
            </div>
            
            <a href="" class="menu-button fa fa-bars fa-2x"></a>
        </nav>

        <!--registro-->
        <div id="register" class="form-action topregist">
          
          <div class="alertas" id="alertas"></div>
        
          <h1>Registro</h1>
          <form id="formularioregistro" onsubmit="return registro();">
						<div class="registro">
							<article class="a">
								<input type="hidden" name="proceso" id="registra" value="Registro" autocomplete="off"/>
								<input type="text" name="name" id="nameregistrar" placeholder="Nombre" required="require" autocomplete="off" />
								<input type="number" name="cedul" id="cedula" placeholder="cedula" required="require" autocomplete="off"  />
								<input type="text" name="usua" placeholder="Usuario" required="require" autocomplete="off"  />
								<input type="email" name="email" placeholder="Email"  autocomplete="off" />
							</article>
							<article class="b">
								<input type="text" name="telef" placeholder="Teléfono" autocomplete="off" />
                <input type="password" name="clave" id="clave" placeholder="Contraseňa" required="require" autocomplete="off" />
								<input type="password" id="claveR" placeholder="Repita contraseňa" required="require" autocomplete="off"/>
							</article>
						</div>
						<div class="mensajeindex">
							<input type="submit" value="Registrar" class="buttonindex" id="reg" />
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
        
        function registro() {
          var claveA = document.getElementById('clave').value;
          var claveB = document.getElementById('claveR').value;

          if (claveA != claveB) {
            alert('Los password ingresados no concuerdan');
            $('#clave').css('background-color', '#88FF88');
            $('#claveR').css('background-color', '#88FF88');
            return false;
          } else {
            var url = 'index_funciones.php';
            $.ajax({
              type: 'GET',
              url: url,
              data: $('#formularioregistro').serialize(),
              success: function (data) {
                if (data == 'Registro completado con exito') {
                  $('#reg').attr('disabled', true);
                  $('#alertas').addClass('mensaje').html(data).show(200).delay(91500).hide(200);
                  let actualiza = new Promise((resolve, reject) => {
                    setTimeout(function () {
                      location.reload();
                    }, 2000);
                  });
                } else {
                  $('#reg').disabled = false;
                  $('#alertas').addClass('mensajeError').html(data).show(200).delay(1500).hide(200);
                }
              }
            });
            return false;
          }
        }

        //verifica si la cedula se encuentra registrada
        $('#cedula').on('change', function () {
          var cedu = document.getElementById('cedula').value;
          var url = 'index_funciones.php';
          $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=' + 'nCedu' + '&cedula=' + cedu + '&clave=' + 'pera',
            success: function (valores) {
              var datos = eval(valores);
              var cedub = datos[0]["cedulaUsuario"];
              if (cedu == cedub) {
                $('#alertas').addClass('mensajeError').html('La cedula ya se encuentra registrada').show(200).delay(3500).hide(200);
                document.getElementById('cedula').value = '';
              }
            }
          });
        });


        //evitar devolverse
        function deshabilitaRetroceso(){
            window.location.hash="no-back-button";
            window.location.hash="Again-No-back-button" //chrome
            window.onhashchange=function(){window.location.hash="no-back-button";}
        }

    </script>
  </body>
</html>    