<?php

    //--Obtengo Categorias
	$cond 	 = "select * from categorias where activo=1";
	$rs 	 = $db->Execute($cond);
	$sCategorias = $rs->GetRows();
    foreach($sCategorias as $key=>$value){
        $cat_id = $value['id'];
    	$cond 	 = "select * from publicaciones where categoria_id = '$cat_id' and activo=1 order by orden ASC";
    	$rs 	 = $db->Execute($cond);
    	$Publicaciones = $rs->GetRows();
            $i = 0;
            $xPub = array();
            foreach($Publicaciones as $key2=>$value2){
                $titulo      = iif(!empty($value2['titulo'.$idioma_elegido]), $value2['titulo'.$idioma_elegido], $value2['titulo'.$idioma_default]);
                $urlamigable = iif(!empty($value2['urlamigable'.$idioma_elegido]), $value2['urlamigable'.$idioma_elegido], $value2['urlamigable'.$idioma_default]);
                 
                $cat_urlamigable = iif(!empty($value['urlamigable'.$idioma_elegido]), $value['urlamigable'.$idioma_elegido], $value['urlamigable'.$idioma_default]);
                $cat_titulo = iif(!empty($value['titulo'.$idioma_elegido]), $value['titulo'.$idioma_elegido], $value['titulo'.$idioma_default]);
        
                $xPub[$i]['titulo'] = $titulo;
                $xPub[$i]['urlamigable'] = URL."/$cat_urlamigable/$urlamigable";
                $i++;
            }
        $sCategorias[$key]['publicaciones'] = $xPub;
        $sCategorias[$key]['titulo']        = $cat_titulo;
        
    }
?>