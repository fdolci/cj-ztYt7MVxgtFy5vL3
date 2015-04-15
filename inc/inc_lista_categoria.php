<?php
    $idioma_elegido = $_SESSION['idioma'];

    $xCategoria      = busco_categoria_por_id($categoria_id);
    $cat_urlamigable = iif(!empty($xCategoria['urlamigable'.$idioma_elegido]), $xCategoria['urlamigable'.$idioma_elegido], $xCategoria['urlamigable'.$idioma_default]);

	$cantidad_publicaciones = $xCategoria['pub_a_mostrar'];
    $orden                  = $xCategoria['ordenar_publicaciones'];
    
    // Busco todas las publicaciones de esa categoria                
    $cond 	= "select * from publicaciones where categoria_id='$categoria_id' and activo=1 order by $orden";
    $rs 	= $db->SelectLimit($cond, $cantidad_publicaciones);
    $xPublicaciones	= $rs->GetRows();
            
    foreach($xPublicaciones as $key=>$value){
        $titulo      = iif(!empty($value['titulo'.$idioma_elegido]), $value['titulo'.$idioma_elegido], $value['titulo'.$idioma_default]);
        $copete      = iif(!empty($value['copete'.$idioma_elegido]), $value['copete'.$idioma_elegido], $value['copete'.$idioma_default]);
        $urlamigable = iif(!empty($value['urlamigable'.$idioma_elegido]), $value['urlamigable'.$idioma_elegido], $value['urlamigable'.$idioma_default]);
        $thumbs      = iif(!empty($value['thumbs'.$idioma_elegido]), $value['thumbs'.$idioma_elegido], $value['thumbs'.$idioma_default]);		
                             
        $xPublicaciones[$key]['titulo']      = $titulo;
        $xPublicaciones[$key]['urlamigable'] = "/$cat_urlamigable/$urlamigable.html";
        $xPublicaciones[$key]['copete']      = substr(strip_tags($copete),0,$cantidad_caracteres);
        if (empty($thumbs)) { 
			$xPublicaciones[$key]['thumbs'] = URL.'/archivos/images/nofoto.jpg'; 
		} else {
			$xPublicaciones[$key]['thumbs'] = $thumbs; 
		}
		
    }

    $lista = "<div id='$nombre_div'>";

    if($muestra_titulo == 1){ $lista.= "<h3 style='margin-top:30px;'>{$xCategoria['titulo']}</h3>"; }

    $lista.= "<ul>";
    foreach($xPublicaciones as $m){
        $lista.= "<li>"; 
		
		if ($muestra_miniatura==1 and !empty($m['thumbs'])){
			$lista.= "<img src='{$m['thumbs']}'>";
		}
		$lista.="<a href='".URL.$m['urlamigable']."' title='{$m['titulo']}'>{$m['titulo']}</a>";
		if (!empty($m['copete'])) {
			$lista.= "{$m['copete']}";
		}
        $lista.= "</li>";
    }
        
    $lista= $lista."</ul>\n</div>\n";
        
?>