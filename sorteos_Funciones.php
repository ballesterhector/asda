<?php
	require '../conectarBD/conectarloterias.php';
	$obj= new conectarDB();

	switch ($_GET['proceso']) {
		case 'registro':
        	$data= $obj->actualizar('CALL sorteoInsert("'.$_GET['hor'].'","'.$_GET['loter'].'","'.$_GET['animal'].'"
														)');
			break;
	
		case 'Edicion':
				$data= $obj->subconsulta("CALL almacenPaletasSelect('".$_GET['idcod']."')");
				echo json_encode($data);
			break;	
			
		case 'registra':
				$datos = $obj->actualizar('CALL ciclicoDataUpdate("'.$_GET['id-prod'].'","'.$_GET['empaque'].'","'.$_GET['unidades'].'",
																"'.$_GET['observa'].'","'.$_GET['modificador'].'"
										)');
			break;
			
		case 'cerrar':
				$datos = $obj->actualizar('CALL ciclicosCerrar("'.$_GET['identifi'].'","'.$_GET['cierra'].'"
										)');
			break;		
		
        case 'registro':
                switch($_GET['sale_de'])
            {
                case 'llena':
                    $llenos=$_GET['paletas']*-1;
                    $vacios=0;
                    $malas=0;
                 break;
                case 'vacia':
                    $llenos=0;
                    $vacios=$_GET['paletas']*-1;
                    $malas=0;
                 break; 
                case 'malas':
                    $llenos=0;
                    $vacios=0;
                    $malas=$_GET['paletas']*-1;
                break; 
            }

        switch($_GET['llegan_a'])
            {
                case 'llena':
                    $llenos_ll=$_GET['paletas'];
                    $vacios_ll=0;
                    $malas_ll=0;
                 break;
                case 'vacia':
                    $llenos_ll=0;
                    $vacios_ll=$_GET['paletas'];
                    $malas_ll=0;
                 break; 
                case 'malas':
                    $llenos_ll=0;
                    $vacios_ll=0;
                    $malas_ll=$_GET['paletas'];
                break; 
            }
                $tot_llena=$llenos+$llenos_ll;
                $tot_vacia=$vacios+$vacios_ll;
                $tot_mala=$malas+$malas_ll;
            
				$datos = $obj->actualizar('CALL almacenPaletasInsert("'.$_GET['numCli'].'","'.$_GET['motivo'].'","'.$tot_llena.'",
																"'.$tot_vacia.'","'.$tot_mala.'"
										)');
			break;    
			
		default:
			# code...
			break;
	}



 ?>
