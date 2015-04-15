<?php
	include_once('./inc/config.php');

    $cat_id = 0;
    $mostrar_en_home = 1;
    include_once('./inc/inc_publicidad.php');

    $breadcrumb[0]['href']  = URL;
    $breadcrumb[0]['title'] = $Traducciones['home'];
    $breadcrumb[1]['href']  = URL.'/agenda.php';
    $breadcrumb[1]['title'] = 'Agenda de Eventos';
    $route = 'agenda.php';

    //------- Busco la publicacion
    $Pub = busco_publicacion('',10);
    $cat_id = $Pub['categoria_id'];

    $mTitle          = $Pub['titulo'];
    $mRobots         = $Pub['robots'];
    $mKeywords       = $Pub['keywords'];
    $mDescription    = $Pub['descripcion'];

    include_once('html/header.html.php');        

    include_once('html/agenda.html.php');        

    include_once('./html/footer.html.php');
?>