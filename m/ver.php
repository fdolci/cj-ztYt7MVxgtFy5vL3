<?php
    $mipath='../';
    include ('../inc/config.php');

    $id         = request('id',0);
    $familia_id = request('familia_id',0);
    $pagina     = request('pagina',1);
    if ($id==0){
    	redirect("listar.php?familia_id=$familia_id&pagina=$pagina");
    	die();
    }


    //----------------------------------------------------------------------------
    //                                          Muestra el Producto
    //----------------------------------------------------------------------------
    $sql = "select productos.*, familias.nombre1 as fam_nombre 
    		from productos 
    		left join familias on productos.familia_id = familias.id
    		where productos.id = '$id' and productos.activo=1";
    $rs  = $db->SelectLimit($sql,1);
    $Producto = $rs->FetchRow();


//    include('modulo_estadistica.php');

    if(!$Producto) {

    	redirect("listar.php?familia_id=$familia_id&pagina=$pagina");
    	die();
    }

    //------------ Obtiene Servicios
    $sql = "select productos_servicios.*, servicios.servicio , servicios.icono
            from productos_servicios 
            left join servicios on productos_servicios.servicio_id = servicios.id
            where productos_servicios.producto_id = '{$Producto['id']}' ";

    $familia_id = $Producto['familia_id'];        
        
    $rs  = $db->Execute($sql);
    $Producto['servicios'] = $rs->GetRows();

        $_SESSION['alojamiento']['latitud'] = $Producto['latitud'];
        $_SESSION['alojamiento']['longitud'] = $Producto['longitud'];
        $_SESSION['alojamiento']['icono'] = $Fam['thumbs1'];

/*
    //------------ Obtiene Actividades
    $sql = "select productos_actividades.*, actividades.actividad , actividades.icono
            from productos_actividades 
            left join actividades on productos_actividades.actividad_id = actividades.id
            where productos_actividades.producto_id = '{$Producto['id']}' ";
        
    $rs  = $db->Execute($sql);
    $Producto['actividades'] = $rs->GetRows();
*/

    $sql = "select * from productos_imagenes where producto_id = '{$Producto['id']}' ";
    $rs  = $db->Execute($sql);
    $Producto['imagenes'] = $rs->GetRows();


    //----------------------------------------------------------------------------
    //                                                               Arma MEtaTags
    //----------------------------------------------------------------------------
    $mTitle       = $Fam['nombre1'].' - '.$Producto['metatitle'];
    $mKeywords    = $Producto['keywords'];
    $mDescription = $Producto['metadescripcion'];
    $mImagen      = $Producto['logo'];    

    if(!empty($Producto['fecha'])){
        $mCreated = date("Y-m-d H:i",$Producto['fecha']);    
    } else {
        $mCreated = date("Y-m-d H:i",time());    
    }
    $mModified = date("Y-m-d H:i",time());    
    $mSection = $Fam['nombre1'];


    // -ARMA LOS SELECT DE LAS FAMILIAS
    $Familias = MenuFamilias(0);
//    pr($Familias);
    $parent_id = 0;
    $select_familia = "<select name='familia_id' onChange='document.cambia_familia.submit();'>";
    $select_familia.= "<option value='0' >Todas las Categorias</option>";
    foreach($Familias as $dd){
            if ($familia_id == $dd['id']) { $sel = "selected='selected'"; } else {$sel='';}
            $separador = "";
            if (!empty($dd['child']) ) {
                $select_familia.= "<optgroup label='{$dd['nombre']}'>";
                foreach($dd['child'] as $dc){
                    if ($familia_id == $dc['id']) { $sel = "selected='selected'"; } else {$sel='';}
                    $select_familia.= "<option value='{$dc['id']}' $sel >{$dc['nombre']}</option>"; 
                }
                $select_familia.= "</optgroup>";
            } else {
                $select_familia.= "<option value='{$dd['id']}' $sel >{$dd['nombre']}</option>";
            }   
    }
    $select_familia.= "</select>";




	include_once('html/m_header.html.php');                
	include_once('html/m_ver.html.php');
	include_once('html/m_footer.html.php');
?>