<?php

    $url = explode('.',end($ruta));
	$oculta_publicidad_top = true;
    if ( $ruta[1]=='tags' ) {

        include('blog_busca_tags.php');


    } elseif ( (count($ruta)==1 and $url[1]!='html') or substr($url[0],0,4)=='pag:' ) {

        include('blog_lista_categoria.php');

    } else {


        //------- Busco la publicacion
        $Pub = busco_publicacion($url[0]);
        $cat_id = $Pub['categoria_id'];

        $mTitle          = $Pub['Categoria']['titulo1'].' '.$Pub['titulo'];
        $mRobots         = $Pub['robots'];
        $mKeywords       = $Pub['keywords'];
        $mDescription    = $Pub['descripcion'];


        $breadcrumb[0]['href']  = URL;
        $breadcrumb[0]['title'] = $Traducciones['home'];
        $breadcrumb[1]['href']  = URL.'/'.$ruta[0];
        $breadcrumb[1]['title'] = $Pub['Categoria']['titulo1'];
        $breadcrumb[2]['href']  = URL.'/'.$ruta[0].'/'.$ruta[1];
        $breadcrumb[2]['title'] = $Pub['titulo1'];


        include_once('./inc/inc_publicidad.php');
        include_once('./html/header.html.php');
        include_once('./html/blog_ver.html.php');


    }

    include_once('./html/footer.html.php');
  
?>