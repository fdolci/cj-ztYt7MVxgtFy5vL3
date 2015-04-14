<?php
	include_once('../../inc/config.php');

	$producto_id = request('id',0);
	if( $producto_id<1 ) { die('Evento no encontrado'); }
	
    $sql = "select productos.*, ciudades.locacion as ciudad, provincias.locacion as provincia, 
            usuarios.url, usuarios.nombre_entidad
            from productos 
            left join ciudades on productos.ciudad_id = ciudades.id
            left join ciudades as provincias on productos.provincia_id = provincias.id
            left join usuarios on productos.user_id = usuarios.id 
            where productos.id='$producto_id' and productos.activo=1";
    $rs  = $db->SelectLimit($sql,1);
    $Producto = $rs->FetchRow();
    if (!$Producto or (empty($Producto))) {
        redirect(URL);
        die();
    }


    if( !empty($Producto['tabs_name']) ){
        $tabs_name = json_decode($Producto['tabs_name'],true);    
    }

        if (empty($tabs_name['organiza']) or !isset($tabs_name['organiza']))        { $tabs_name['organiza'] = 'Organización'; }
        if (empty($tabs_name['areas'])  or !isset($tabs_name['areas']) )            { $tabs_name['areas'] = 'Áreas Temáticas'; }
        if (empty($tabs_name['disertantes']) or !isset($tabs_name['disertantes']) ) { $tabs_name['disertantes'] = 'Expositores'; }
        if (empty($tabs_name['trabajos']) or !isset($tabs_name['trabajos']) )       { $tabs_name['trabajos'] = 'Pres.Trabajos'; }
        if (empty($tabs_name['autoridades']) or !isset($tabs_name['autoridades']) ) { $tabs_name['autoridades'] = 'Autoridades'; }
        if (empty($tabs_name['comite_cientifico'])  or !isset($tabs_name['comite_cientifico']) ) { $tabs_name['comite_cientifico'] = 'Comité Científico'; }
        if (empty($tabs_name['auspicios']) or !isset($tabs_name['auspicios']) )     { $tabs_name['auspicios'] = 'Auspicios'; }
        if (!isset($tabs_name['cronograma']) or empty($tabs_name['cronograma'])  )  { $tabs_name['cronograma'] = 'Cronograma'; }
        if (empty($tabs_name['sponsors'])  or !isset($tabs_name['sponsors']) )      { $tabs_name['sponsors'] = 'Sponsors'; }



    $ok = $db->Execute("update productos set lecturas=(lecturas+1) where id='$producto_id'");


    $sql = "select usuarios.*, productos_imagenes.imagen 
            from usuarios 
            left join productos_imagenes on productos_imagenes.user_id = usuarios.id 
            where usuarios.id='{$Producto['user_id']}'";
    $rs  = $db->SelectLimit($sql,1);
    $Usuario = $rs->FetchRow();



    if(!empty($Producto['metatitle'])) {
        $mTitle    = $Producto['metatitle'];    
    } else {
        $mTitle    = $Producto['titulo'];
    }
    $mRobots         = '';
    $mKeywords       = $Producto['keywords'];
    if(!empty($Producto['metadescripcion'])) {
        $mDescription    = $Producto['metadescripcion'];    
    } else {
        $mDescription    = $Producto['subtitulo'];
    }
    


    //----------------------------------------------------------------
    //                                            Obtiene las imagenes
    //----------------------------------------------------------------
    if (!empty($Usuario['imagen'])){
        $Producto['miniatura'] = VER_FOTOS.'/'.$Usuario['imagen'];        
    } else {
        $Producto['miniatura'] = VER_FOTOS.'/sinfoto.jpg';        
    }
    $Producto['banner_top'] = '';    
    $sql = "select * from productos_imagenes where producto_id='$producto_id'";
    $rs  = $db->Execute($sql);
    $Imagenes = $rs->GetRows();

    foreach($Imagenes as $clave=>$valor){
        if ($valor['cual']=='logo_evento'){
            $Producto['miniatura'] = VER_FOTOS.'/'.$valor['imagen'];    
            unset($Imagenes[$clave]);
        } elseif ($valor['cual']=='afiche'){
            $Producto['afiche'] = VER_FOTOS.'/'.$valor['imagen'];    
            unset($Imagenes[$clave]);
        }
    }


    //----------------------------------------------------------------
    //                                   Hay archivos para descargar ?
    //----------------------------------------------------------------
    $sql = "select * from productos_archivos where producto_id='$producto_id' and activo='1' order by orden ASC";
    $rs  = $db->Execute($sql);
    $Archivos = $rs->GetRows();

    //----------------------------------------------------------------
    //                                               Hay Autoridades ?
    //----------------------------------------------------------------
    $sql = "select * from productos_autoridades where producto_id='$producto_id' and activo='1' order by orden ASC";
    $rs  = $db->Execute($sql);
    $Autoridades = $rs->GetRows();
	
    //----------------------------------------------------------------
    //                                  Hay Disertantes /Expositores ?
    //----------------------------------------------------------------
    $sql = "select * from productos_disertantes where producto_id='$producto_id' and activo='1' order by orden ASC";
    $rs  = $db->Execute($sql);
    $Disertantes = $rs->GetRows();

    //----------------------------------------------------------------
    //                                   Hay Auspiciantes / Sponsors ?
    //----------------------------------------------------------------
    $sql = "select * from productos_auspicios where producto_id='$producto_id' and activo='1' order by orden ASC";
    $rs  = $db->Execute($sql);
    $Sponsors = $rs->GetRows();

	
    //----------------------------------------------------------------
    //                                   Hay Aranceles ?
    //----------------------------------------------------------------
    $sql = "select * from productos_aranceles where producto_id='$producto_id' order by orden ASC";
    $rs  = $db->Execute($sql);
    $Aranceles = $rs->GetRows();

    $cat_id = 0;
    $mostrar_en_home = 1;
 //   include_once(ROOT.'/inc/inc_publicidad.php');
//pr($xurl);
        
    $oculta_todo = true;
    include_once(ROOT.'/api/evento/header.html.php');
    include_once(ROOT.'/api/evento/muestra_comercio.html.php');
//    include_once(ROOT.'/html/footer.html.php');
//pr($xurl);
    die();
?>