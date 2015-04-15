<?php
	include_once("inc/config.php");

    if (!isset($idioma_elegido)) { $idioma_elegido = 1;}
    if (!isset($idioma_default)) { $idioma_default = 1;}    

    //----- Busco la categorias
    $sql = "select * from familias where parent_id='0' and activo=1 order by orden ASC";
    $rs  = $db->Execute($sql);
    $Familias = $rs->GetRows();
    foreach($Familias as $clave=>$x){
        //------------------------------------------------------------------
        //                                            Listado de SbFamilias
        //------------------------------------------------------------------
        $sql = "select id, nombre1 as nombre, urlamigable1 from familias where parent_id='{$x['id']}'  and activo=1 order by orden ASC";
        $rs  = $db->Execute($sql);  
        $Familias[$clave]['child'] = $rs->GetRows();
	}
	
	
    // Listado de Eventos
    $sql = "select productos.*,pf.familia_id, pf.subfamilia_id, fam.urlamigable1 as fam_url,sub.urlamigable1 as sub_url
                from productos
                left join productos_familias as pf on pf.producto_id = productos.id 
                left join familias as fam on pf.familia_id = fam.id 
                left join familias as sub on pf.subfamilia_id = sub.id 
                
                where productos.activo=1 and hasta>='".time()."' order by destacado_home DESC, desde ASC ";

	$rs 	    = $db->Execute($sql);
    $Publicaciones	= $rs->GetRows();

    //----- Busco los blogs
    $cond  = "select * from publicaciones where activo=1 and categoria_id = 3 order by fecha DESC";
    $rs    = $db->SelectLimit($cond,50);
    $Blog  = $rs->GetRows();

    $ruta_fichero="sitemap.xml"; 
    unlink($ruta_fichero);

    $fp = fopen($ruta_fichero,"w");

    $texto = "<?xml version='1.0' encoding='UTF-8'?>
    <urlset
          xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'
          xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
          xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9
                http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'>\n";
    fwrite($fp, $texto);

    $texto ="<url><loc>".URL."</loc><priority>1.00</priority></url>\n";
    fwrite($fp, $texto);            

    foreach ($Familias as $fam){
        $texto ="<url><loc>".URL."/{$fam['urlamigable1']}</loc><priority>1.00</priority></url>\n";
        fwrite($fp, $texto);            
		if(!empty($fam['child'])){
			foreach ($fam['child'] as $child){
				$texto ="<url><loc>".URL."/{$fam['urlamigable1']}/{$child['urlamigable1']}</loc><priority>1.00</priority></url>\n";
				fwrite($fp, $texto);            
			}
		}
    }

    foreach ($Publicaciones as $pub){
        $pub['href'] = URL."/".$pub['fam_url']."/".$pub['sub_url']."/".$pub['urlamigable']."-".$pub['id'].".html";        
        $texto ="<url><loc>{$pub['href']}</loc><priority>0.90</priority></url>\n";
        fwrite($fp, $texto);            
    }    

    $texto ="<url><loc>".URL."/blog</loc><priority>1.00</priority></url>\n";    
    fwrite($fp, $texto);            
	
    foreach ($Blog as $pub){
        $pub['href'] = URL."/blog/".$pub['urlamigable1'].".html";        
        $texto ="<url><loc>{$pub['href']}</loc><priority>0.80</priority></url>\n";
        fwrite($fp, $texto);            
    }    

    $texto ="<url><loc>".URL."/noticias.php</loc><priority>1.00</priority></url>\n";    
    fwrite($fp, $texto);            
    $texto ="<url><loc>".URL."/agenda.php</loc><priority>1.00</priority></url>\n";    
    fwrite($fp, $texto);            
    $texto ="<url><loc>".URL."/videos.php</loc><priority>1.00</priority></url>\n";    
    fwrite($fp, $texto);            

    $fecha = date("Y-m-d")."T".date("H:i:s")."-03:00";

    $texto = "<url><loc>".URL."/terminos-y-condiciones-de-rosarioalojamientos.html</loc><priority>0.80</priority></url>\n";
    $texto.= "<url><loc>".URL."/rss/blog</loc><lastmod>$fecha</lastmod><priority>0.70</priority></url>\n";
    $texto.= "<url><loc>".URL."/rss/new</loc><lastmod>$fecha</lastmod><priority>0.80</priority></url>\n";
    fwrite($fp, $texto);            

    foreach ($Familias as $fam){
        $texto= "<url><loc>".URL."/rss/{$fam['urlamigable1']}</loc><lastmod>$fecha</lastmod><priority>0.70</priority></url>\n";
        fwrite($fp, $texto);            
    }

    fwrite($fp, "</urlset>");
    fclose($fp);
	die();
?>