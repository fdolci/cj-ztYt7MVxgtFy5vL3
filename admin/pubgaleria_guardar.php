<?php
	// Guarda una nueva publicacion

	$id 		  = request('id',0);
	$nombre 	  = request('nombre','');
   	$abstract 	  = request('abstract','');
    $descripcion  = request('descripcion','');
	$url_amigable = request('url_amigable','');
	$keywords 	  = request('keywords','');
    
    $thumbs 	  = request('thumbs','');
    $ubicacion    = request('ubicacion','');
    $mapa         = request('mapa','');

    $nombre1 = iif( isset($nombre[1]), htmlspecialchars($nombre[1], ENT_QUOTES,'UTF-8'), '');
    $nombre2 = iif( isset($nombre[2]), htmlspecialchars($nombre[2], ENT_QUOTES,'UTF-8'), '');
    $nombre3 = iif( isset($nombre[3]), htmlspecialchars($nombre[3], ENT_QUOTES,'UTF-8'), '');
    $nombre4 = iif( isset($nombre[4]), htmlspecialchars($nombre[4], ENT_QUOTES,'UTF-8'), '');
    $nombre5 = iif( isset($nombre[5]), htmlspecialchars($nombre[5], ENT_QUOTES,'UTF-8'), '');

    $abstract1 = iif( isset($abstract[1]), $abstract[1], '');
    $abstract2 = iif( isset($abstract[2]), $abstract[2], '');
    $abstract3 = iif( isset($abstract[3]), $abstract[3], '');
    $abstract4 = iif( isset($abstract[4]), $abstract[4], '');
    $abstract5 = iif( isset($abstract[5]), $abstract[5], '');

    $descripcion1 = iif( isset($descripcion[1]), $descripcion[1], '');
    $descripcion2 = iif( isset($descripcion[2]), $descripcion[2], '');
    $descripcion3 = iif( isset($descripcion[3]), $descripcion[3], '');
    $descripcion4 = iif( isset($descripcion[4]), $descripcion[4], '');
    $descripcion5 = iif( isset($descripcion[5]), $descripcion[5], '');

    $url_amigable1 = iif( isset($url_amigable[1]), $url_amigable[1], '');
    $url_amigable2 = iif( isset($url_amigable[2]), $url_amigable[2], '');
    $url_amigable3 = iif( isset($url_amigable[3]), $url_amigable[3], '');
    $url_amigable4 = iif( isset($url_amigable[4]), $url_amigable[4], '');
    $url_amigable5 = iif( isset($url_amigable[5]), $url_amigable[5], '');            

    $keywords1 = iif( isset($keywords[1]), sanitize($keywords[1]), '');    
    $keywords2 = iif( isset($keywords[2]), sanitize($keywords[2]), '');
    $keywords3 = iif( isset($keywords[3]), sanitize($keywords[3]), '');
    $keywords4 = iif( isset($keywords[4]), sanitize($keywords[4]), '');
    $keywords5 = iif( isset($keywords[5]), sanitize($keywords[5]), '');    

    
	if ($id==0) { //************** ES UNA PUBLICACION  NUEVA
		$cond = "insert into galerias (nombre1, nombre2, nombre3, nombre4, nombre5, ";
        $cond.= " abstract1, abstract2, abstract3, abstract4, abstract5, "; 
        $cond.= " descripcion1, descripcion2, descripcion3, descripcion4, descripcion5, ";        
        $cond.= " urlamigable1, urlamigable2, urlamigable3, urlamigable4, urlamigable5, ";
        $cond.= " keywords1, keywords2, keywords3, keywords4, keywords5, ";
        $cond.= " thumbs, ubicacion, mapa ) VALUES ";
		$cond.= " ('$nombre1','$nombre2','$nombre3','$nombre4','$nombre5', ";
        $cond.= " '$abstract1', '$abstract2','$abstract3','$abstract4','$abstract5', ";
        $cond.= " '$descripcion1', '$descripcion2','$descripcion3','$descripcion4','$descripcion5', ";        
        $cond.= " '$url_amigable1', '$url_amigable2','$url_amigable3','$url_amigable4','$url_amigable5', ";
        $cond.= " '$keywords1', '$keywords2','$keywords3','$keywords4','$keywords5', ";
        $cond.= " '$thumbs', '$ubicacion', '$mapa' )";
		$ok		= $db->Execute($cond); 	
	
	} else { //********************** ES UNA MODIFICACION
		$cond  = "update galerias set ";
		$cond.= " nombre1 	= '$nombre1', ";
		$cond.= " nombre2 	= '$nombre2', ";
		$cond.= " nombre3 	= '$nombre3', ";
		$cond.= " nombre4 	= '$nombre4', ";
		$cond.= " nombre5 	= '$nombre5', ";                                
        $cond.= " abstract1 	= '$abstract1', ";        
        $cond.= " abstract2 	= '$abstract2', ";
        $cond.= " abstract3 	= '$abstract3', ";
        $cond.= " abstract4 	= '$abstract4', ";
        $cond.= " abstract5 	= '$abstract5', ";
        $cond.= " descripcion1 	= '$descripcion1', ";        
        $cond.= " descripcion2 	= '$descripcion2', ";
        $cond.= " descripcion3 	= '$descripcion3', ";
        $cond.= " descripcion4 	= '$descripcion4', ";
        $cond.= " descripcion5 	= '$descripcion5', ";
	    $cond.= " urlamigable1	= '$url_amigable1', ";                                        
		$cond.= " urlamigable2	= '$url_amigable2', ";
		$cond.= " urlamigable3  = '$url_amigable3', ";
		$cond.= " urlamigable4	= '$url_amigable4', ";
		$cond.= " urlamigable5	= '$url_amigable5', ";
		$cond.= " keywords1 	= '$keywords1', ";
		$cond.= " keywords2 	= '$keywords2', ";
		$cond.= " keywords3 	= '$keywords3', ";
		$cond.= " keywords4 	= '$keywords4', ";
		$cond.= " keywords5 	= '$keywords5', ";                                
		$cond.= " thumbs        = '$thumbs', ";
        $cond.= " ubicacion     = '$ubicacion', ";
        $cond.= " mapa          = '$mapa' ";
		$cond.= " where id='$id'";
		$ok		= $db->Execute($cond); 	
		
	}

	if ($ok) { $_SESSION['Msg'] = 'La Galeria se guardo correctamente.';
	} else { $_SESSION['Msg'] = "<hr>".'ERROR!! No se pudo guardar la Galeria.';	}
	redirect('pubgaleria.php');
	die();



			
?>