<?php

    $Modulo[1] = $Modulo[2] = $Modulo[3] = $Modulo[4] = $Modulo[5] = $Modulo[6] = $Modulo[7] = $Modulo[8] = $Modulo[9] = $Modulo[10] = array();
    $Modulo[11] = $Modulo[12] = $Modulo[13] = $Modulo[14] = $Modulo[15] = array();    
    $Modulo_1 = $Modulo_2 = $Modulo_3 = $Modulo_4 = $Modulo_5 = $Modulo_6 = $Modulo_7 = $Modulo_8 = $Modulo_9 = $Modulo_10 = '';
    $Modulo_11 = $Modulo_12 = $Modulo_13 = $Modulo_14 = $Modulo_15 = '';    

    if( isset($mostrar_en_home) and $mostrar_en_home == 1 ) {
        $cond 	= "select * from modulos where activo=1 and mostrar_en_home = 1 and (idioma_id='$idioma_elegido' or idioma_id=0) order by ubicacion ASC, orden ASC";

    } elseif( isset($mostrar_en_contacto) and $mostrar_en_contacto == 1 ) {
        $cond 	= "select * from modulos where activo=1 and mostrar_en_contacto = 1  and (idioma_id='$idioma_elegido' or idioma_id=0) order by ubicacion ASC, orden ASC";

    } elseif( isset($mostrar_en_sitemap) and $mostrar_en_sitemap == 1 ) {
        $cond 	= "select * from modulos where activo=1 and mostrar_en_sitemap = 1 and (idioma_id='$idioma_elegido' or idioma_id=0) order by ubicacion ASC, orden ASC";

    } else { 
        $cond 	= "select * from modulos where activo=1 and (categorias=0 or categorias='$cat_id') and (idioma_id='$idioma_elegido' or idioma_id=0) order by ubicacion ASC, orden ASC";
    }

	$rs 	= $db->Execute($cond);
	$Publi = $rs->GetRows();
//pr($Publi);
	$a = count($Publi);
 
	if ($a>0){

        foreach($Publi as $p) {
            
            $z = '';
            $muestra_titulo = $p['muestra_titulo'];
            
			if (!empty($p['script'])) {
                $Descripcion = stripslashes( $p['script']);
				$z.='<div id="'.$p['nombre_div'].'">';
				$z.= $Descripcion;
				$z.="<img src='".IMG."/spacer.gif' width=10 height=5 ".'style="border:0px;" >';
				$z.="</div>";

            } elseif(!empty($p['descripcion'])) {
                $z.="<div>".stripslashes($p['descripcion'])."</div>";

            } elseif($p['bloque_menu']>0) {
                $bloque_menu_id = $p['bloque_menu'];
                $xtitulo        = $p['titulo'];
                include('inc_crea_menues.php');
                $z.= $mnu;

            } elseif($p['listar_categoria']>0) {
                $bloque_menu_id           = $p['bloque_menu'];
                $categoria_id             = $p['listar_categoria'];
                $cantidad_publicaciones   = $p['cantidad_publicaciones'];
                $cantidad_caracteres      = $p['cantidad_caracteres'];
                $nombre_div               = $p['nombre_div'];
				$muestra_miniatura        = $p['muestra_miniatura'];
                $xtitulo                  = $p['titulo'];
                include('inc_lista_categoria.php');
                $z.= $lista;

            } elseif($p['listar_familia']>0) {
                $bloque_menu_id           = $p['bloque_menu'];
                $familia_id               = $p['listar_familia'];
                $cantidad_productos       = $p['cantidad_productos'];
                $nombre_div               = $p['nombre_div'];
                $xtitulo                  = $p['titulo'];
                include('inc_mod_lista_familia.php');
                $z.= $lista_familia;


            } elseif($p['mostrar_destacados']>0) {
                $bloque_menu_id      = $p['bloque_menu'];
                $cantidad_destacados = $p['cantidad_destacados'];
                $nombre_div          = $p['nombre_div'];
                $xtitulo             = $p['titulo'];
                $cantidad_publicaciones = $p['cantidad_destacados']; 
                include('inc_destacados.php');
                $z.= $destacados;


            } elseif($p['slide']>0) {
                $bloque_menu_id  = $p['bloque_menu'];
                $slide_id        = $p['slide'];
                $nombre_div      = $p['nombre_div'];
                $xtitulo         = $p['titulo'];
                include('inc_slide.php');
                $z.= $return_slide;
				
            } elseif($p['consulta_rapida']>0) {
                $ConsultaRapida[$p['ubicacion']][] = 'consulta_rapida';			    

            }

            $Modulo[$p['ubicacion']][] = $z;			    
            
               
        }
        
        foreach($Modulo[1]  as $x ) { $Modulo_1  = $Modulo_1  . $x; }
        foreach($Modulo[2]  as $x ) { $Modulo_2  = $Modulo_2  . $x; }
        foreach($Modulo[3]  as $x ) { $Modulo_3  = $Modulo_3  . $x; }
        foreach($Modulo[4]  as $x ) { $Modulo_4  = $Modulo_4  . $x; }
        foreach($Modulo[5]  as $x ) { $Modulo_5  = $Modulo_5  . $x; }
        foreach($Modulo[6]  as $x ) { $Modulo_6  = $Modulo_6  . $x; }
        foreach($Modulo[7]  as $x ) { $Modulo_7  = $Modulo_7  . $x; }
        foreach($Modulo[8]  as $x ) { $Modulo_8  = $Modulo_8  . $x; }
        foreach($Modulo[9]  as $x ) { $Modulo_9  = $Modulo_9  . $x; }
        foreach($Modulo[10] as $x ) { $Modulo_10 = $Modulo_10 . $x; }
        foreach($Modulo[11] as $x ) { $Modulo_11 = $Modulo_11 . $x; }
        foreach($Modulo[12] as $x ) { $Modulo_12 = $Modulo_12 . $x; }        
        foreach($Modulo[13] as $x ) { $Modulo_13 = $Modulo_13 . $x; }        
        foreach($Modulo[14] as $x ) { $Modulo_14 = $Modulo_14 . $x; }        
        foreach($Modulo[15] as $x ) { $Modulo_15 = $Modulo_15 . $x; }
        
    }
?>