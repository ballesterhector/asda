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
              <a href="indexLoguear.php" class="fa fa-user fa-3x"><span class="logi ingresar">Login</span></a>
              <a href="indexRegistro.php" class="fa fa-user-plus fa-3x"><span class="logi">Registro</span></a>
              <a href="indexReseteo.php" class="fa fa-address-card fa-3x"><span class="logi">Resetear</span></a>
            </div>
            
            <a href="" class="menu-button fa fa-bars fa-2x"></a>
        </nav>

        <!--login-->
        <div id="forloguear" class="form-action ">
					<form action="index_valida.php" id='loguear' method="get">
						<input type="text" name="usua" id="usua" placeholder="Usuario" required="require" autocomplete="off" autofocus="autofocus"/>
						<input type="password" name="passw" placeholder="Contraseňa" required="require" />
						<div class="ayud">
              <input type="submit" value="Login" class="buttonindex" />
              <a href="#" onclick="window.open('http:aplicaciones/ayudas/login.pdf')" /><i class="fas fa-book fa-3x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Manual"></i></a>
					    </div>
					</form>    
				</div>
    </div>
    <script src="aplicaciones/js/jquery-3.2.1.min.js"></script>
			
    <script type="text/javascript">
        $(document).ready(function(){
         
          initControls(); //Para evitar devolverse

         $('#loguear').hide();

        });
        
        var items = document.querySelectorAll('.circle a');
        for(var i = 0, l = items.length; i < l; i++) {
          items[i].style.left = (50 - 35*Math.cos(-0.5 * Math.PI - 2*(1/l)*i*Math.PI)).toFixed(4) + "%";
          items[i].style.top = (50 + 35*Math.sin(-0.5 * Math.PI - 2*(1/l)*i*Math.PI)).toFixed(4) + "%";
        }

        document.querySelector('.menu-button').onclick = function(e) {
          e.preventDefault(); document.querySelector('.circle').classList.toggle('open');
        }
        

        //evitar devolverse
        function initControls() {
          window.location.hash = "red";
          window.location.hash = "Red" //chrome
          window.onhashchange = function () {
            window.location.hash = "red";
          }
        }

    </script>
  </body>
</html>    