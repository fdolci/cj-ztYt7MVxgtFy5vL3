<?php
	include_once('./inc/config.php');

    $cat_id = 0;
    $mostrar_en_home = 1;

	$breadcrumb[0]['href']  = URL;
    $breadcrumb[0]['title'] = $Traducciones['home'];
    $breadcrumb[1]['href']  = URL.'/videos.php';
    $breadcrumb[1]['title'] = 'Rosario en Videos';

    $route = 'videos.php';

    //------- Busco la publicacion
    $Pub = busco_publicacion('',12);
    $cat_id = $Pub['categoria_id'];

    $mTitle          = $Pub['titulo'];
    $mRobots         = $Pub['robots'];
    $mKeywords       = $Pub['keywords'];
    $mDescription    = $Pub['descripcion'];


    include_once('./inc/inc_publicidad.php');

    include_once('html/header.html.php');        

    include_once('html/videos.html.php');        

    include_once('./html/footer.html.php');
?>