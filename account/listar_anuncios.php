<?php
    include ('../inc/config.php'); 

	if( isset($_SESSION['admin'])  and isset($_GET['keyword']) ) {
		
		unset($_SESSION['user_id']);
	}
	
	if( !esta_login() ) { 

		if( isset($_SESSION['admin'])  ) {
            $llave = unserialize( base64_decode($_GET['keyword']) );

			
            if( ($llave['admin_id'] == $_SESSION['admin']) and ($llave['passphrase'] == $_SESSION['passphrase']) ) {
                $_SESSION['user_id'] = $llave['user_id']; 
				
                //-----------------------------------------------------------------------------
                //                                Cual es el plan que tiene activo el usuario??
                //-----------------------------------------------------------------------------
                $sql   = "select * from usuarios where id='{$llave['user_id']}'";
                $rs    = $db->SelectLimit($sql,1);
                $Usuario = $rs->FetchRow();

                $sql = "select * from planes_usuarios where id='{$Usuario['plan_usuario_id']}'";
                $rs  = $db->SelectLimit($sql,1);
                $planes_usuarios    = $rs->FetchRow();
                $limite_avisos      = $planes_usuarios['cantidad_avisos'];
                $vencimiento_avisos = $planes_usuarios['vigencia'];

                $_SESSION['limite_avisos']       = $limite_avisos;
                $_SESSION['vencimiento_avisos']  = $vencimiento_avisos;
				

            }

        } else {
			
			redirect(URL);
			die();
        }
		
    }




    $id = $_SESSION['user_id'];


    if(isset($_GET['accion']) and $_GET['accion']=='delete' and $_GET['anuncio_id']>0){
        $anuncio_id = $_GET['anuncio_id'];

		$ok = $db->Execute("update productos set activo=0 where id='$anuncio_id'");
		
/*		
        $sql = "select * from productos where id='$anuncio_id'";
        $rs  = $db->Execute($sql);
        $Aviso = $rs->GetRows();

        $sql = "delete from productos where user_id='$id' and id='$anuncio_id'";
        $rs  = $db->Execute($sql);

        $sql = "delete from productos_familias where producto_id='$anuncio_id'";
        $rs  = $db->Execute($sql);

        $ruta_alojamiento = SUBIR_FOTOS.$id.'/'.$anuncio_id;
        if(!empty($Aviso['thumbs'])){
            $archivo = $ruta_alojamiento.'/'.$Aviso['thumbs'];
            unlink($archivo);
        }

        $sql = "select * from productos_imagenes where producto_id='$anuncio_id'";
        $rs  = $db->Execute($sql);
        $Imagenes = $rs->GetRows();

        foreach($Imagenes as $im){
            $archivo = $ruta_alojamiento.'/'.$im['imagen'];
            unlink($archivo);
        }

        $sql = "delete from productos_imagenes where producto_id='$anuncio_id'";
        $rs  = $db->Execute($sql);
*/
        $Mensaje["mensaje"] = 'El Aviso se eliminó correctamente!';
        $Mensaje["tipo"]    = 'alert-success';
        $Mensaje["autoclose"] = true;
        $_SESSION['Mensaje'] = $Mensaje;                


    }


    /* Obtiene todos los anuncios del usuario */
    $sql = "select productos.*,familias.nombre1 as fam_nombre 
            from productos 
            left join productos_familias on productos.id=productos_familias.producto_id
            left join familias on productos_familias.familia_id=familias.id
            where user_id='$id' and productos.activo='1' group by productos.id order by id DESC";
    $rs  = $db->Execute($sql);
    $Productos = $rs->GetRows();
    
	if($Productos){
		foreach($Productos as $clave=>$valor){
			$sql = "select count(id) as cuantos from inscripciones where producto_id='{$valor['id']}' and eliminado='0'";
			$rs  = $db->Execute($sql);
			$x   = $rs->FetchRow();
			if($x){
				$Productos[$clave]['inscriptos'] = $x['cuantos'];
			} else {
				$Productos[$clave]['inscriptos'] = 0;
			}
		}
	}

	
    $cat_id = 0;
    $mostrar_en_home = 0;
    $menu_cta = 'listar_anuncios';
//    include_once(ROOT.'/inc/inc_publicidad.php');
	
    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/account/listar_anuncios.html.php');
    include_once(ROOT.'/html/footer.html.php');
?>