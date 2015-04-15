<?php
    $idioma_elegido = $_SESSION['idioma'];

    // Busco todas las publicaciones marcadas como destacado
	$xPublicaciones	= obtiene_destacados(0, $cantidad_publicaciones);
	//pr($xPublicaciones);
    $destacados = "<div id='$nombre_div'>";

    if($muestra_titulo == 1){ $destacados.= "<h2>$xtitulo</h2>"; }

    $destacados.= "<ul>";
    foreach($xPublicaciones as $m){
/*        if ($color=='style="background-color:#D2E2EE;"') { $color='style="background-color:#FFF;"';} else {$color='style="background-color:#D2E2EE;"'; } 
        $destacados.= "<li $color><a href='".URL.$m['urlamigable']."' title='".$m['titulo']."'>".$m['titulo']."</a></li>";
*/        
        $destacados.= "<li><b>".date($Traducciones['formato_fecha'],$m['fecha'])."</b> <a href='{$m['href']}' title='{$m['titulo']}'>{$m['titulo']}</a>{$m['copete']}</li>";
    }
        
    $destacados.="</ul>\n</div>\n";
       
?>