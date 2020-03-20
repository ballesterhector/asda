<?php
	require 'aplicaciones/php/session_start.php';
	
	require 'conectarBD/conectarASDA.php';

    $fecha = date("d-m-Y H:i:s");
    
?>
<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="utf-8-8">
		<meta name="description" content="Aplicación para control de bienes y suministros">
    	<meta name="keywords" content="asda">
    	<meta name="author" content="Ballester Héctor @ballesterhector">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<title>ASDA On Line</title>
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="aplicaciones/css/dataTables.bootstrap.min.css">
		
		<script type="text/javascript" src="librerias/funtion.js"></script>
		<style>
           .logo {
                border: 0px solid #fff;
                border-top:0;
            }
            
            .td{
                border: 2px solid #000;
            }
            
          
        </style>
	</head>
 
    <body>
    	<div class="container">
           
            
            <section>
                <article>
                    <table class="table " width="100%" border="0">
                        <thead>
                           <tr>
                               <td colspan="3" class="logo">
                                    <img src="../plantillas/imagenes/logo.png" width="120px">
                               </td>
                               <td colspan="3" class="logo">
                                    <p>CONTROL DE SALIDA DE VEHÍCULOS</p>   
                               </td>
                           </tr>
                            <tr class="td">
                                <th class="text-center td" style="width:20px">Despacho</th>
                                <th class="text-center td" style="width:170px">Salida</th>
                                <th class="text-center td" style="width:100px">Hora</th>
                                <th class="text-center td">Cliente</th>
                                <th class="text-center td">Conductor</th>
                                <th class="text-center td">Vehículo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                for ($i = $_GET['id_codigo']; $i <= $_GET['id_codigo']+143; $i++) {
                                    echo' 
                                        <tr class="td" height="40px">
                                            <td class="td">'.$i.'</td>
                                            <td class="td"></td>
                                            <td class="td"></td>
                                            <td class="td"></td>
                                            <td class="td"></td>
                                            <td class="td"></td>
                                        </tr>     
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                </article>    
            </section>
        </div>        
        <div class="">
            <!--linck a plantillas js-->
            <script src="aplicaciones/js/jquery-1.11.1.min.js"></script>
            <script src="aplicaciones/js/bootstrap.min.js"></script>
        </div>
    </body>
</html>