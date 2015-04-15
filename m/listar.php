<?php
    $mipath='../';
    include ('../inc/config.php');
    $de_donde = '';

    $familia_id = request('familia_id',0);
    $pagina     = request('pagina',1);

    $pub_a_mostrar = 10;
    
    if ($familia_id>0){             
        // Cuantas publicaciones tiene la categoria?
        $cond    = "select count(id) as cuantas from productos where familia_id='$familia_id' and activo=1  and productos.resumen!='' ";
        $rs      = $db -> SelectLimit($cond,1);
        $cuantas_publicaciones = $rs -> FetchRow();

        if ( $cuantas_publicaciones['cuantas'] > 0 ) {
            $cantidad_de_paginas = ceil( $cuantas_publicaciones['cuantas'] / $pub_a_mostrar);    
        } else {
            $cantidad_de_paginas = 0;
        }
                         
        $desde = ($pagina - 1) * $pub_a_mostrar;

        $cond = "select productos.*, familias.urlamigable1 as fam_url , familias.thumbs1 as fam_img , familias.nombre1 as fam_nombre
                    from productos 
                    left join familias on productos.familia_id = familias.id 
                    where productos.activo=1 and productos.resumen!=''
                        and productos.familia_id='$familia_id' 
                    order by productos.titulo ASC";
    } else {

            // Cuantas publicaciones tiene la categoria?
            $cond    = "select count(id) as cuantas from productos where productos.activo= '1'  and productos.resumen!='' ";
            $rs      = $db -> SelectLimit($cond,1);
            $cuantas_publicaciones = $rs -> FetchRow();

            if ( $cuantas_publicaciones['cuantas'] > 0 ) {
                $cantidad_de_paginas = ceil( $cuantas_publicaciones['cuantas'] / $pub_a_mostrar);    
            } else {
                $cantidad_de_paginas = 0;
            }
                         
            $desde = ($pagina - 1) * $pub_a_mostrar;

            $cond = "select productos.*, familias.urlamigable1 as fam_url , familias.thumbs1 as fam_img , familias.nombre1 as fam_nombre
                        from productos 
                        left join familias on productos.familia_id = familias.id 
                        where productos.activo= '1'  and productos.resumen!=''
                        order by productos.titulo ASC";
    }
         
    $rs  = $db -> SelectLimit( $cond, $pub_a_mostrar, $desde );
    $Alojamientos = $rs->GetRows();

    // -ARMA LOS SELECT DE LAS FAMILIAS
    $Familias = MenuFamilias(0);
//    pr($Familias);
    $parent_id = 0;
    $select_familia = "<select name='familia_id' onChange='document.cambia_familia.submit();'>";
    $select_familia.= "<option value='0' >Todas las Categorias</option>";
    foreach($Familias as $dd){
            if ($familia_id == $dd['id']) { $sel = "selected='selected'"; } else {$sel='';}
            $separador = "";
            if (!empty($dd['child']) ) {
                $select_familia.= "<optgroup label='{$dd['nombre']}'>";
                foreach($dd['child'] as $dc){
                    if ($familia_id == $dc['id']) { $sel = "selected='selected'"; } else {$sel='';}
                    $select_familia.= "<option value='{$dc['id']}' $sel >{$dc['nombre']}</option>"; 
                }
                $select_familia.= "</optgroup>";
            } else {
                $select_familia.= "<option value='{$dd['id']}' $sel >{$dd['nombre']}</option>";
            }   
    }
    $select_familia.= "</select>";

    
    include_once('html/m_header.html.php');
    if($pagina<=1){
        $destacados = productos_destacados($familia_id, 4);    
        include('html/m_inc_alojamientos_destacados.html.php');
    }

    include('html/m_inc_listado_alojamientos.html.php');
    include_once('html/m_footer.html.php');

?>