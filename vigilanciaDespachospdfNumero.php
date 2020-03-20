<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';

    require "aplicaciones/html/head";
?>
 
    <body>
    	<div class="container">
      <nav>
    		<div class="">
    			<?php include "menu_submenu.php"; ?>
    		</div>
    	</nav>
      <header>
         <h1></h1>
      </header>
      <section>
         <article>
            <div class="form-inline">
                <div class="form-group col-sm-9">
                    <label for="" class="col-sm-9 control-label"><h4>Indique número de retiro de inicio del control de salida de vehículos</h4></label>
                    <div class="col-sm-3">
                        <input type="text" name="nuevo" id="despacho" class="form-control text-center" value="0">
                    </div>
                </div>
            </div>
         </article>
      </section>
      
       <div class="">
        <!--linck a plantillas js-->
        <?php require "aplicaciones/html/footer"  ?>
        <script src="aplicaciones/js/cerrar.js"></script>
      </div>
      <script type="text/javascript">
           $('#despacho').keyup(function(e) {
                if(e.keyCode == 13) {

                    var desp = document.getElementById('despacho').value;
                    window.open('vigilanciaDespachospdf.php?id_codigo=' + desp,target='new');
                }
            });
        </script>
    </body>
</html>