<?php

    $sql  = "select * from productos where id = '$producto_id'";
    $rs   = $db -> SelectLimit( $sql, 1);
    $Producto 	= $rs->FetchRow();

    
    $sql = "select * from productos_grupos where producto_id = '$producto_id'";
    $rs   = $db -> Execute( $sql);
    $Producto_Grupos	= $rs->GetRows();
            
    if ($Config['acceso_productos'] == 2){
        $accede = accede_a_familias(serialize($Producto_Grupos));    
    } else {
        $accede = true;    
    }


    if ($accede === false or !$accede) {
        
        $Mensaje["mensaje"]   = $Traducciones['no_tiene_acceso'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['login']    = '';
        redirect( URL.'/index.php'); die();
        
        
    }
            
    $Producto['titulo']      = iif(!empty($Producto['titulo'.$idioma_elegido]     ),$Producto['titulo'.$idioma_elegido]     ,$Producto['titulo1']     );
    $Producto['thumbs']      = iif(!empty($Producto['thumbs'.$idioma_elegido]     ),$Producto['thumbs'.$idioma_elegido]     ,$Producto['thumbs1']     );
    $Producto['contenido']   = iif(!empty($Producto['contenido'.$idioma_elegido]  ),$Producto['contenido'.$idioma_elegido]  ,$Producto['contenido1']  );
    $Producto['urlamigable'] = iif(!empty($Producto['urlamigable'.$idioma_elegido]),$Producto['urlamigable'.$idioma_elegido],$Producto['urlamigable1']);
    $Producto['titulo']      = htmlspecialchars_decode(stripslashes( $Producto['titulo']),ENT_QUOTES);
    $Producto['contenido']   = htmlspecialchars_decode(stripslashes( $Producto['contenido']),ENT_QUOTES);
    if (empty($Producto['thumbs'])) { $Producto['thumbs'] = INST_DIR.'/archivos/images/nofoto.jpg'; }


    //- Obtiene Galeria de Fotos
    $sql  = "select * from galerias_fotos where galeria_id = '$producto_id' and activo=1 order by orden ASC";
    $rs   = $db -> Execute( $sql);
    $Fotos 	= $rs->GetRows();
    foreach($Fotos as $clave=>$valor){
        $Fotos[$clave]['nombre'] = iif(!empty($valor['nombre'.$idioma_elegido] ),$valor['nombre'.$idioma_elegido] ,$valor['nombre1']     );        
    }

    
    if ($Config['acceso_productos'] == 1){
        $accede = accede_a_familias(serialize($Producto_Grupos));    
    }

    if ($accede){
        //- Obtiene Solapas
        $sql  = "select * from solapas where producto_id = '$producto_id' and activo=1 order by orden ASC";
        $rs   = $db -> Execute( $sql);
        $Solapas 	= $rs->GetRows();
        foreach($Solapas as $clave=>$valor){
            $Solapas[$clave]['titulo'] = iif(!empty($valor['titulo'.$idioma_elegido] ),$valor['titulo'.$idioma_elegido] ,$valor['titulo1']     );        
            $Solapas[$clave]['solapa'] = iif(!empty($valor['solapa'.$idioma_elegido] ),$valor['solapa'.$idioma_elegido] ,$valor['solapa1']     );
        }
        
    } else {
        $Mensaje["mensaje"]   = $Traducciones['no_tiene_acceso'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['login']    = '';
        
    }
        

    // Obtiene fmilias y relaciones para el breadcrumb
    $Familia = ObtieneFamilia($familia_id);
    $Familias = MenuFamilias( $familia_id );

    if ( !empty($Familias) ) {
        
        foreach($Familias as $clave=>$valor){
            $Familias[$clave]['nombre'] = iif(!empty($valor['nombre'.$idioma_elegido]),$valor['nombre'.$idioma_elegido],$valor['nombre1']);
            $Familias[$clave]['urlamigable'] = iif(!empty($valor['urlamigable'.$idioma_elegido]),$valor['urlamigable'.$idioma_elegido],$valor['urlamigable1']);
        }

    }

    //--- BreadCrumb
    $breadcrumb[0]['href']  = URL;
    $breadcrumb[0]['title'] = $Traducciones['home'];
    $breadcrumb[1]['href']  = URL."/productos~f0";
    $breadcrumb[1]['title'] = $Traducciones['productos'];
    
    if ($Familia['parent_id'] == 0 ) {
        $breadcrumb[2]['href']  = URL."/".$Familia['urlamigable']."~f".$Familia['id'];
        $breadcrumb[2]['title'] = $Familia['nombre'];
        $url = "/{$Familia['urlamigable']}~f{$Familia['id']}";

    } else {
        $parent_id = $Familia['parent_id'];
        $arbol = array();
        $indice = 99;
        $arbol[$indice] = $familia_id;
        while($parent_id != 0){
            $indice--;
            $sql = "select * from familias where id = '$parent_id'";
            $rs = $db->SelectLimit($sql,1);
            $fam = $rs->FetchRow();
            $arbol[$indice] = $fam['id'];    
            $parent_id = $fam['parent_id'];
        }
        sort($arbol);
        $url = $rutas = '';
        $contador = 2;
        
        foreach($arbol as $ar){
            $sql = "select * from familias where id = '$ar'";
            $rs = $db->SelectLimit($sql,1);
            $fam = $rs->FetchRow();
            $fam['nombre'] = iif(!empty($fam['nombre'.$idioma_elegido]),$fam['nombre'.$idioma_elegido],$fam['nombre1']);
            $fam['urlamigable'] = iif(!empty($fam['urlamigable'.$idioma_elegido]),$fam['urlamigable'.$idioma_elegido],$fam['urlamigable1']);
            $fam['nombre'] = htmlspecialchars_decode(stripslashes($fam['nombre']),ENT_QUOTES);
            $url = $url."/".$fam['urlamigable'];
            $href = URL."$url~f{$fam['id']}";
            $breadcrumb[$contador]['href']  = $href;
            $breadcrumb[$contador]['title'] = $fam['nombre'];
            $contador++;
        }
    }


    $cat_id = -4; // ficha de Producto
    include_once( './inc/inc_publicidad.php' );
    include_once( './html/header.html.php'   );

    include_once('./html/producto.html.php');  
  

?>