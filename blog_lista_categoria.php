<?php
    $paginado = end(explode( '/',$route ));
            
    $pagina  = 0;    
    if( substr($paginado,0,4) == 'pag:'  ) {
        $pagina = end(explode(':',$paginado));
    } else {
        $pagina = 1;
    }
           
            
    // lista una categoria
    $Categoria = busco_categoria_por_url($ruta[0]);


    if ( empty($Categoria) ) {

        redirect(URL);
        die();

    } else {

        //--- Listar una categoria
        $breadcrumb[0]['href']  = URL;
        $breadcrumb[0]['title'] = $Traducciones['home'];
        $breadcrumb[1]['href']  = URL."/".$Categoria['urlamigable'];
        $breadcrumb[1]['title'] = $Categoria['titulo'];


        $pub_a_mostrar = $Categoria['pub_a_mostrar']; //-- Cantidad de publicaciones a mostrar
        $orden         = $Categoria['ordenar_publicaciones'];

                                                
        // Cuantas publicaciones tiene la categoria?
        $cond 	 = "select count(id) as cuantas from publicaciones where categoria_id='{$Categoria['id']}' and activo=1";
        $rs 	 = $db -> SelectLimit($cond,1);
        $cuantas_publicaciones = $rs -> FetchRow();

        if ( $cuantas_publicaciones['cuantas'] > 0 ) {
            $cantidad_de_paginas = ceil( $cuantas_publicaciones['cuantas'] / $pub_a_mostrar);    
        } else {
            $cantidad_de_paginas = 0;
        }
                 
        $desde = ($pagina - 1) * $pub_a_mostrar;
                        
        // Busco todas las publicaciones de esa categoria            
        //$orden = 'orden DESC';   
            
        $cond 	        = "select * from publicaciones where categoria_id='{$Categoria['id']}' and activo=1 order by $orden";
        $rs 	        = $db -> SelectLimit( $cond, $pub_a_mostrar, $desde );
        $Publicaciones	= $rs -> GetRows();
                
        //--- Valores a pasar para armar los meta
        $mTitle          = $Categoria['titulo1'];
        if($pagina>1) { $mTitle = $mTitle.' pag.'.$pagina;}
        $mRobots         = $Categoria['robots'];
        $mKeywords       = $Categoria['keywords1'];
        $mDescription    = $Categoria['descripcion1'];
        $cat_urlamigable = iif( !empty($Categoria['urlamigable'.$idioma_elegido]), $Categoria['urlamigable'.$idioma_elegido], $Categoria['urlamigable'.$idioma_default] );
        $categoria_href  = URL."/".$cat_urlamigable;

                
            
        foreach($Publicaciones as $key=>$value){
            $titulo      = iif(!empty($value['titulo'.$idioma_elegido]), $value['titulo'.$idioma_elegido], $value['titulo'.$idioma_default]);
            $thumbs      = iif(!empty($value['thumbs'.$idioma_elegido]), $value['thumbs'.$idioma_elegido], $value['thumbs'.$idioma_default]);
            $copete      = iif(!empty($value['copete'.$idioma_elegido]), $value['copete'.$idioma_elegido], $value['copete'.$idioma_default]);
            $urlamigable = iif(!empty($value['urlamigable'.$idioma_elegido]), $value['urlamigable'.$idioma_elegido], $value['urlamigable'.$idioma_default]);
                             
            $cat_urlamigable = iif(!empty($Categoria['urlamigable'.$idioma_elegido]), $Categoria['urlamigable'.$idioma_elegido], $Categoria['urlamigable'.$idioma_default]);
            if (empty($thumbs)) {
                $thumbs = URL.'/archivos/images/nofoto_chico.jpg';
            }                    
            $Publicaciones[$key]['titulo']      = $titulo;
            $Publicaciones[$key]['thumbs']      = $thumbs;
            $Publicaciones[$key]['copete']      = $copete;
            $Publicaciones[$key]['urlamigable'] = URL."/$cat_urlamigable/$urlamigable.html";
            $Publicaciones[$key]['href']        = URL."/$cat_urlamigable/$urlamigable.html";
            
                            
        }
    
        $template = $Categoria['template'];
        //-- Listado de categoria
        include_once( ROOT.'/inc/inc_publicidad.php' );
        include_once( ROOT.'/html/header.html.php'   );

        include_once( ROOT.'/html/blog_lista_categoria.html.php');      
       
        
    }
?>