<?php
    $cat_id = 0;
    $mostrar_en_home = 1;
    include_once(ROOT.'/inc/inc_publicidad.php');

    //list($url_amigable,$extension) = explode('.', end($ruta));

    $provincia_id  = $xurl['provincia']['id'];
    $ciudad_id     = $xurl['ciudad']['id'];
    $familia_id    = $xurl['familia']['id'];
    $subfamilia_id = $xurl['subfamilia']['id'];

    $familia_url   = $xurl['familia']['url'];
    $subfamilia_url   = $xurl['subfamilia']['url'];

    $prov_url         = "";
    $prov_condicion   = '';
    $ciudad_condicion = '';
    $ciudad_url       = "";
    $cond_familia     = '';
    $cond_subfamilia  = '';
    $orden            = '';


    $sql = "select usuarios.*, ciudades.locacion as ciudad, provincias.locacion as provincia 
            from usuarios 
            left join ciudades on usuarios.ciudad_id = ciudades.id
            left join ciudades as provincias on usuarios.provincia_id = provincias.id
            where url='{$ruta[1]}'";
    $rs  = $db->SelectLimit($sql,1);
    $Usuario = $rs->FetchRow();


    //------------------------------- Obtiene anuncios de Anunciantes Premium
    $sql = "select productos.*, pf.familia_id, pf.subfamilia_id, 
            fam.nombre1 as fam_nombre, fam.urlamigable1 as fam_url,
            subfam.nombre1 as subfam_nombre, subfam.urlamigable1 as subfam_url
            from productos
            left join productos_familias as pf on productos.id = pf.producto_id
            left join familias as fam on pf.familia_id = fam.id
            left join familias as subfam on pf.subfamilia_id = subfam.id
            where productos.activo=1 and productos.user_id={$Usuario['id']} ";
        $rs  = $db->Execute($sql);
        $Premium = $rs->GetRows();

        if($Premium){
            foreach($Premium as $clave=>$valor){

                // Obtiene la imagen en miniatura
                $sql = "select * from productos_imagenes where producto_id='{$valor['id']}' and cual='miniatura' ";
                $rs  = $db->SelectLimit($sql,1);
                $x   = $rs->FetchRow();
                if ($x) {
                    $Premium[$clave]['miniatura'] = VER_FOTOS.'/'.$x['imagen'];    
                } else {
                    $Premium[$clave]['miniatura'] = VER_FOTOS.'/sinfoto.jpg';
                }
                
                $Premium[$clave]['href'] = URL."/{$valor['fam_url']}/{$valor['subfam_url']}/{$valor['urlamigable']}-{$valor['id']}.html";
                
            }


        }
        
    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/html/lista_anunciante.html.php');
    include_once(ROOT.'/html/footer.html.php');
//pr($xurl);

    die();
?>