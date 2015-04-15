<?php

    // lista una categoria
    $Familia = ObtieneFamilia($familia_id);
pr($Familia);
    if ($familia_id>0) {
        //-- Hay productos en esa familia?
        $sql  = "select count(id) as cuantos from productos where familia1_id = '$familia_id' or  familia2_id = '$familia_id' or  familia3_id = '$familia_id' order by orden ASC";
        $rs 	 = $db -> SelectLimit($sql,1);
        $cuantos_productos = $rs -> FetchRow();
        if ( $cuantos_productos['cuantos'] > 0 ) {
            $cantidad_de_paginas = ceil( $cuantos_productos['cuantos'] / 10);    
        } else {
            $cantidad_de_paginas = 0;
        }
        $desde = ($pagina - 1) * 10;
    
        	
        $sql  = "select * from productos  
                where familia1_id = '$familia_id' or  familia2_id = '$familia_id' or  familia3_id = '$familia_id' order by orden ASC";
        $rs   = $db -> SelectLimit( $sql, 10, $desde );
        $Products 	= $rs->GetRows();
        
//    pr($Products);
        $lista_familia = "<ul class='$nombre_div'>";
        foreach($Products as $clave => $valor) {
            
            // Obtiene los grupos de pertenencia
            $producto_id = $valor['id'];
            $sql = "select * from productos_grupos where producto_id = '$producto_id'";
            $rs   = $db -> Execute( $sql);
            $Producto_Grupos	= $rs->GetRows();
            
            if ($Config['acceso_productos'] == 2){
                $accede = accede_a_familias(serialize($Producto_Grupos));    
            } else {
                $accede = true;    
            }

            if($accede === true) {             
                $Productos[$clave]['id'] = $valor['id'];
                $Productos[$clave]['titulo'] = iif(!empty($valor['titulo'.$idioma_elegido]),$valor['titulo'.$idioma_elegido],$valor['titulo1']);
                $Productos[$clave]['thumbs'] = iif(!empty($valor['thumbs'.$idioma_elegido]),$valor['thumbs'.$idioma_elegido],$valor['thumbs1']);
                $Productos[$clave]['contenido'] = iif(!empty($valor['contenido'.$idioma_elegido]),$valor['contenido'.$idioma_elegido],$valor['contenido1']);
                $Productos[$clave]['urlamigable'] = iif(!empty($valor['urlamigable'.$idioma_elegido]),$valor['urlamigable'.$idioma_elegido],$valor['urlamigable1']).'~p'.$valor['id'];
                $Productos[$clave]['titulo'] = htmlspecialchars_decode(stripslashes($Productos[$clave]['titulo']),ENT_QUOTES);
                $Productos[$clave]['contenido'] = htmlspecialchars_decode(stripslashes($Productos[$clave]['contenido']),ENT_QUOTES);
                if (empty($Productos[$clave]['thumbs'])) {
                    $Productos[$clave]['thumbs'] = INST_DIR.'/archivos/images/nofoto.jpg';
                }
                
                $lista_familia.= "<li><a href='{$Productos[$clave]['urlamigable']}' title='{$Productos[$clave]['titulo']}' >{$Productos[$clave]['titulo']}</a></li>";
                
            } //accede = true
    
        }
        $lista_familia.="</ul>";
        
    } else {
        $Productos = array();
        $cantidad_de_paginas = 0;
    }

    //pr($Productos);
?>