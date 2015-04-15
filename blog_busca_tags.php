<?php
	include_once("./inc/config.php" );

    $x = explode('/',$route);

    $Palabras = end($x);

    $Resultados = array();

    $breadcrumb[0]['href']  = URL;
    $breadcrumb[0]['title'] = $Traducciones['home'];
    $breadcrumb[1]['href']  = URL.'/blog';
    $breadcrumb[1]['title'] = 'Blog';
    $breadcrumb[2]['href']  = '#';
    $breadcrumb[2]['title'] = $Traducciones['resultado_busqueda'];

  
    if (!empty($Palabras)) {

        // CONTENIDOS

        $cond = "select publicaciones.*, categorias.urlamigable1 as cat_url
                from publicaciones 
                left join categorias on publicaciones.categoria_id = categorias.id 
                WHERE tags1 like '%$Palabras%' 
                ORDER BY fecha DESC";
        $rs         = $db->SelectLimit($cond,40);   

    	$Publicaciones = $rs->GetRows();


    	if (!empty($Publicaciones)){
    
    		foreach ($Publicaciones as $clave => $valor){
    
                if ( empty($valor['titulo'.$idioma_elegido])    ) { $valor['titulo']    = $valor['titulo'.$idioma_default];    } else { $valor['titulo']    = $valor['titulo'.$idioma_elegido];    }
                if ( empty($valor['copete'.$idioma_elegido])    ) { $valor['copete']    = $valor['copete'.$idioma_default];    } else { $valor['copete']    = $valor['copete'.$idioma_elegido];    }
                if ( empty($valor['contenido'.$idioma_elegido]) ) { $valor['contenido'] = $valor['contenido'.$idioma_default]; } else { $valor['contenido'] = $valor['contenido'.$idioma_elegido]; }
                if ( empty($valor['urlamigable'.$idioma_elegido]) ) { $valor['urlamigable'] = $valor['urlamigable'.$idioma_default]; } else { $valor['urlamigable'] = $valor['urlamigable'.$idioma_elegido]; }
                $Publicaciones[$clave]['thumbs']      = iif(!empty($valor['thumbs'.$idioma_elegido]     ),$valor['thumbs'.$idioma_elegido]     ,$valor['thumbs1']     );
                if (empty($Publicaciones[$clave]['thumbs'])) { $Publicaciones[$clave]['thumbs'] = INST_DIR.'/archivos/images/nofoto.jpg'; }
                 
                $Publicaciones[$clave]['titulo']    = htmlspecialchars_decode( stripslashes( $valor['titulo']) ,ENT_QUOTES);
                $Publicaciones[$clave]['copete']    = htmlspecialchars_decode( stripslashes( $valor['copete']),ENT_QUOTES);
                $Publicaciones[$clave]['contenido'] = htmlspecialchars_decode( stripslashes( $valor['contenido']),ENT_QUOTES);
                $Publicaciones[$clave]['urlamigable'] = URL.'/'.$valor['cat_url'].'/'.$valor['urlamigable'].".html";    
                
    		}
    
    	}

   

	}
    
    include_once('./inc/inc_publicidad.php');
    include_once('./html/header.html.php');
    include_once('./html/blog_lista_categoria.html.php');
    include_once('./html/footer.html.php');
    
    

?>