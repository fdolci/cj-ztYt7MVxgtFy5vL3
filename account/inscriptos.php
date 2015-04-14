<?php

    include ('../inc/config.php'); 

    if( !esta_login() ) { 
        $Mensaje["mensaje"]   = $Traducciones['login_requerido'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['user_id']    = '';
        redirect(URL);   die();  
    }

	
	$id          = request('id',0);
	$user_id     = $_SESSION['user_id'];	
	$producto_id = request('producto_id',0);
	$accion      = request('accion','listar');
	$letra	     = request('letra','todos');
	$mostrar     = request('mostrar',0);    


    $Pertenece = array();
	switch ($accion) {

		case 'exportar': /******************************************************************************** ESTADO *********************/
            $nombre_temporal = time().'_inscriptos.xls';
			$destino = ROOT.'/temp/'.$nombre_temporal;
			
			$sql = "select titulo from productos where id='$producto_id'";
			$rs  = $db->SelectLimit($sql,1);
			$x   = $rs->FetchRow();
			$titulo = $x['titulo'];
			
			$cond = "select * from inscripciones where eliminado='0' and producto_id='$producto_id' order by apellido ASC";
			$rs   = $db->Execute($cond);
			$Base = $rs->GetRows();

			$fp = fopen("$destino", 'w');
			$renglon = "<table><tr style='background:#683D85;color:#FFF;'>";
				$renglon.= "<td style='height:24px;'>Apellido</td>";  
				$renglon.= "<td>Nombre</td>"; 
				$renglon.= "<td>Documento</td>";   
				$renglon.= "<td>Domicilio</td>";
				$renglon.= "<td>Ciudad</td>";
				$renglon.= "<td>Provincia</td>";
				$renglon.= "<td>Pais</td>";
				$renglon.= "<td>Telefono</td>";
				$renglon.= "<td>Email</td>";    
				$renglon.= "<td>F.Inscripcion</td>";
				$renglon.= "<td>Fecha de Pago</td>";  
				$renglon.= "<td>Arancel</td>";    
				$renglon.= "<td>Como se entero</td>";    
				$renglon.= "<td>Comentario</td>";
				$renglon.= "<td>Mis Anotaciones</td>";
				$renglon.= "<td>Datos Personalizados</td></tr>";
			fwrite($fp, $renglon);

			foreach($Base as $b) {
				$color = iif($color=='FEFFCC','FFF','FEFFCC');
				$renglon = "<tr style='background:#$color;color:#000;'>";
				$renglon.= "<td>{$b['apellido']}</td>";  
				$renglon.= "<td>{$b['nombre']}</td>"; 
				$renglon.= "<td>{$b['documento']}</td>";   
				$renglon.= "<td>{$b['domicilio']}</td>";
				$renglon.= "<td>{$b['ciudad']}</td>";
				$renglon.= "<td>{$b['provincia']}</td>";
				$renglon.= "<td>{$b['pais']}</td>";
				$renglon.= "<td>{$b['telefono']}</td>";
				$renglon.= "<td>{$b['email']}</td>";    
				$renglon.= "<td>".date("d/m/Y",$b['fecha'])."</td>";				
				$renglon.= "<td>";
				$renglon.= iif($b['fecha_de_pago']>0,date("d/m/Y",$b['fecha_de_pago']),'');
				$renglon.= "</td>";				
				$renglon.= "<td>{$b['categoria_aranceles']}</td>";    				
				$renglon.= "<td>{$b['como_se_entero']}</td>";
				$renglon.= "<td>{$b['comentario']}</td>";
				$renglon.= "<td>{$b['anotaciones']}</td>";
				$renglon.= "<td>{$b['resto']}</td></tr>";
				fwrite($fp, $renglon);
			}

			fclose($fp);
			$file = URL.'/temp/'.$nombre_temporal;
			$fecha = date("d-m-Y");
			$nombre = $titulo.'_inscripciones_al_'.$fecha.'.xls';
			header("Content-disposition: attachment; filename=$nombre");
			header("Content-type: application/octet-stream");
			readfile($file);
			
			unlink($destino);
			
			die();
			
			break;




		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion mediante ajax
			$cond 	= "update inscripciones set eliminado='".time()."' where id='$id'";
			$ok		= $db->Execute($cond);
			if($ok){
				echo 1;
			} else {
				echo 0;
			}
			die();
			break;

	}



		$sql="select LEFT(TRIM(apellido),1) as letra 
				from inscripciones 
				where producto_id='$producto_id' and eliminado=0 group by LEFT(apellido,1)";
		$rs = $db->Execute($sql);
		$Letras = $rs->GetRows();

    if ($letra=='todos'){
    	$sql="select * from inscripciones where producto_id='$producto_id' and eliminado='0' order by apellido ASC, nombre ASC";	
    } else {
    	$sql="select * from inscripciones where LEFT(apellido,1)='$letra' and producto_id='$producto_id' and eliminado='0' order by apellido ASC, nombre ASC";
    }
	$rs = $db->Execute($sql);
	$Inscriptos = $rs->GetRows();
	
	
	
	
    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/account/inscriptos.html.php');
    include_once(ROOT.'/html/footer.html.php');

?>
