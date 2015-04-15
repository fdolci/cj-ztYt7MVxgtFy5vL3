<?php
    $cat_id = 0;
    $mostrar_en_home = 1;
    //include_once(ROOT.'/inc/inc_publicidad.php');

    //list($url_amigable,$extension) = explode('.', end($ruta));

    $provincia_id  = $xurl['provincia']['id'];
    $ciudad_id     = $xurl['ciudad']['id'];
    $familia_id    = $xurl['familia']['id'];
    $subfamilia_id = $xurl['subfamilia']['id'];

    $familia_url   = $xurl['familia']['url'];
    $subfamilia_url   = $xurl['subfamilia']['url'];

    $prov_url         = '';
    $prov_condicion   = '';
    $ciudad_condicion = '';
    $ciudad_url       = '';
    $cond_familia     = '';
    $cond_subfamilia  = '';
    $orden            = '';

    if($provincia_id>0){
        $prov_url = "/{$xurl['provincia']['url']}";
        $prov_condicion = "and productos.provincia_id = '$provincia_id' ";

        if($ciudad_id>0){
            $ciudad_url       = "/{$xurl['ciudad']['url']}";
            $ciudad_condicion = "and productos.ciudad_id = '$ciudad_id' ";            
        }
    }



    if($familia_id>0) {
        $cond_familia = " and pf.familia_id = '$familia_id' ";
    }

    if($subfamilia_id>0) {
        $cond_subfamilia = " and pf.subfamilia_id = '$subfamilia_id' ";
    }


    if($familia_id==0){
        $orden = " order by destacado_home DESC, desde DESC";
    } else {
        $orden = " order by destacado_home DESC, desde DESC";
    }

    //-----------------------------------------------------------------------------------
	//                                                        Listado de Eventos futuros
	//-----------------------------------------------------------------------------------
    $hoy = time();
    $sql = "select productos.*,pf.familia_id, pf.subfamilia_id, usuarios.es_premium,
                usuarios.nombre_entidad,usuarios.sigla, usuarios.url as anunciante_url
                from productos
                left join productos_familias as pf on pf.producto_id = productos.id 
                left join usuarios on usuarios.id = productos.user_id 
                where productos.activo=1 and hasta>='$hoy'
                $cond_familia $cond_subfamilia $prov_condicion $ciudad_condicion $orden";


    $rs  = $db->Execute($sql);
    $comercios = $rs->GetRows();

    foreach($comercios as $clave=>$valor){

        
        $sql = "select urlamigable1,nombre1 from familias where id='{$valor['familia_id']}'";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        $familia_url = $x['urlamigable1'];
        $comercios[$clave]['familia'] = $x['nombre1'];
        


            $sql = "select urlamigable1,nombre1 from familias where id='{$valor['subfamilia_id']}'";
            $rs  = $db->SelectLimit($sql,1);
            $x   = $rs->FetchRow();
            $subfamilia_url = $x['urlamigable1'];
            $comercios[$clave]['subfamilia'] = $x['nombre1'];
        

        // Obtiene la ciudad donde se realizara el evento
        $sql = "select * from ciudades where id='{$valor['ciudad_id']}'";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        $comercios[$clave]['ciudad'] = $x['locacion'];

        // Obtiene la provincia donde se realizara el evento
        $sql = "select * from ciudades where id='{$valor['provincia_id']}'";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        $comercios[$clave]['provincia'] = $x['locacion'];

        // Obtiene el logo del evento
        $sql = "select * from productos_imagenes where producto_id='{$valor['id']}' and cual='logo_evento' ";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        if ($x) {
            $comercios[$clave]['miniatura'] = VER_FOTOS.'/'.$x['imagen'];    
        } else {
            // El evento no tiene, busco el logo de la asociacion
            $sql = "select * from productos_imagenes where user_id='{$valor['user_id']}' and cual='miniatura' ";
            $rs  = $db->SelectLimit($sql,1);
            $x   = $rs->FetchRow();
            if ($x) {
                $comercios[$clave]['miniatura'] = VER_FOTOS.'/'.$x['imagen'];    
            } else {
                $comercios[$clave]['miniatura'] = VER_FOTOS.'/sinfoto.jpg';
            }
            
        }
        
        $comercios[$clave]['href'] = URL.$prov_url.$ciudad_url."/$familia_url/$subfamilia_url/{$valor['urlamigable']}-{$valor['id']}.html";
        
    }

	
	
	
	
    //-----------------------------------------------------------------------------------
	//                                                        Listado de Eventos Pasados
	//-----------------------------------------------------------------------------------
    
    $sql = "select 
				productos.*,pf.familia_id, pf.subfamilia_id, usuarios.es_premium,
                usuarios.nombre_entidad,usuarios.sigla, usuarios.url as anunciante_url
            from 
				productos
                left join productos_familias as pf on pf.producto_id = productos.id 
                left join usuarios on usuarios.id = productos.user_id 
            where 
				productos.activo=1 and hasta<'$hoy'
                $cond_familia $cond_subfamilia $prov_condicion $ciudad_condicion order by hasta DESC";

    $rs  = $db->SelectLimit($sql,10);
    $EventosPasados = $rs->GetRows();
    foreach($EventosPasados as $clave=>$valor){

        
        $sql = "select urlamigable1,nombre1 from familias where id='{$valor['familia_id']}'";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        $familia_url = $x['urlamigable1'];
        $EventosPasados[$clave]['familia'] = $x['nombre1'];
        


        $sql = "select urlamigable1,nombre1 from familias where id='{$valor['subfamilia_id']}'";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        $subfamilia_url = $x['urlamigable1'];
        $EventosPasados[$clave]['subfamilia'] = $x['nombre1'];
        

        // Obtiene la ciudad donde se realizara el evento
        $sql = "select * from ciudades where id='{$valor['ciudad_id']}'";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        $EventosPasados[$clave]['ciudad'] = $x['locacion'];

        // Obtiene la provincia donde se realizara el evento
        $sql = "select * from ciudades where id='{$valor['provincia_id']}'";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        $EventosPasados[$clave]['provincia'] = $x['locacion'];

        // Obtiene el logo del evento
        $sql = "select * from productos_imagenes where producto_id='{$valor['id']}' and cual='logo_evento' ";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        if ($x) {
            $EventosPasados[$clave]['miniatura'] = VER_FOTOS.'/'.$x['imagen'];    
        } else {
            // El evento no tiene, busco el logo de la asociacion
            $sql = "select * from productos_imagenes where user_id='{$valor['user_id']}' and cual='miniatura' ";
            $rs  = $db->SelectLimit($sql,1);
            $x   = $rs->FetchRow();
            if ($x) {
                $EventosPasados[$clave]['miniatura'] = VER_FOTOS.'/'.$x['imagen'];    
            } else {
                $EventosPasados[$clave]['miniatura'] = VER_FOTOS.'/sinfoto.jpg';
            }
            
        }
        
        $EventosPasados[$clave]['href'] = URL.$prov_url.$ciudad_url."/$familia_url/$subfamilia_url/{$valor['urlamigable']}-{$valor['id']}.html";
        
    }

    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/html/lista_comercios.html.php');
    include_once(ROOT.'/html/footer.html.php');
//pr($xurl);

    die();
?>