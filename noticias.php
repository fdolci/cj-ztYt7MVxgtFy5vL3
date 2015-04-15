<?php
	include_once('./inc/config.php');
    include_once('./inc/xml_parser.php');

    $cat_id = 0;
    $mostrar_en_home = 1;


    $mTitle = 'Noticias de Rosario y la Región';


	$breadcrumb[0]['href']  = URL;
    $breadcrumb[0]['title'] = $Traducciones['home'];
    $breadcrumb[1]['href']  = URL.'/noticias.php';
    $breadcrumb[1]['title'] = 'Noticias de Rosario y la Región';

    $route = 'noticias.php';

    //------- Busco la publicacion
    $Pub = busco_publicacion('',11);
    $cat_id = $Pub['categoria_id'];

    $mTitle          = $Pub['titulo'];
    $mRobots         = $Pub['robots'];
    $mKeywords       = $Pub['keywords'];
    $mDescription    = $Pub['descripcion'];

    include_once('./inc/inc_publicidad.php');

    include_once('html/header.html.php');        

    include_once('html/noticias.html.php');        

    include_once('./html/footer.html.php');

/* http://www.rosariocultura.gob.ar/ferias */

?>