<?php

    // Busco la publicacion a mostrar
    $pub_id = intval( $identificador );
            
    $Pub = busco_publicacion('', $pub_id);
        $mTitle          = $Pub['titulo'];
        $mRobots         = $Pub['robots'];
        $mKeywords       = $Pub['keywords'];
        $mDescription    = $Pub['descripcion'];


    if (empty($Pub)) {
        $breadcrumb[0]['href']  = URL;
        $breadcrumb[0]['title'] = $Traducciones['home'];
        $breadcrumb[1]['href']  = URL."/".$Traducciones['sitemap']."~2";
        $breadcrumb[1]['title'] = $Traducciones['sitemap'];

        // No se encontro la url, re-envio al sitemap
        $cat_id = -2;
        include_once('./inc/inc_publicidad.php');
        include_once('./html/header.html.php');
        include_once('./html/site-map.html.php');
                                            
    } else {
        
        $cat_id    = $Pub['categoria_id'];
//		$Categoria = busco_categoria_por_id($cat_id);

        $breadcrumb[0]['href']  = URL;
        $breadcrumb[0]['title'] = $Traducciones['home'];
        if ($Pub['categoria_id']>9) {
            $breadcrumb[1]['href']  = URL."/".$Pub['Categoria']['urlamigable']."~c".$Pub['Categoria']['id'];
            $breadcrumb[1]['title'] = $Pub['Categoria']['titulo'];
        }
        $breadcrumb[2]['href']  = URL."/".$Pub['urlamigable']."~".$Pub['id'];
        $breadcrumb[2]['title'] = $Pub['titulo'];
                
        if ($Pub['pagina_inicio'] == 1) { $mostrar_en_home = 1;}

        if($Pub['id'] == 1) {
            
            $mostrar_en_contacto = 1;
            include_once('./inc/inc_publicidad.php');
            include_once('./html/header.html.php');
//            include_once('./html/contacto.html.php');
            include_once('contacto.php');

        } elseif($Pub['id'] == 2) {
        
            $mostrar_en_sitemap = 1;
            include_once('./inc/inc_publicidad.php');
            include_once('./html/header.html.php');
            include_once('./html/site-map.html.php');

        } elseif($Pub['id'] == 3) {
            
            include_once('./inc/inc_publicidad.php');
            include_once('./html/header.html.php');
            include_once('./html/resultado_busqueda.html.php');

        } elseif($Pub['id'] == 11) {
            
            include_once('./inc/inc_publicidad.php');
            include_once('./html/header.html.php');
            include_once('./html/listado_medicos.html.php');

        } elseif($Pub['id'] == 12) {
            
            include_once('./inc/inc_publicidad.php');
            include_once('./html/header.html.php');
            include_once('./html/catalogo_historico.html.php');

        } else {
            
            include_once('./inc/inc_publicidad.php');
            include_once('./html/header.html.php');
                    
            //-- Tiene galeria de fotos?
            $cond  = "select * from galerias_fotos where galeria_id = '{$Pub['id']}' and activo = '1' order by orden ASC";
            $rs    = $db->Execute($cond);
            $Fotos = $rs->GetRows();
            include_once('./html/ver.html.php');    
        }    
                    
    }
    include_once('./html/footer.html.php');    
?>