<?php 
    include ('../inc/config.php'); 

    if( !esta_login() ) { 
        $Mensaje["mensaje"]   = $Traducciones['login_requerido'];
        $Mensaje["tipo"]      = 'alert-error';
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['user_id']    = '';
        redirect(URL);   die();  
    }

    $id = request('id',0);

    $user_id = $_SESSION['user_id'];

    $vencimiento_avisos = $_SESSION['vencimiento_avisos'] ;

    if($_POST){

        $data = $_POST;

        $tabs_name = $data['tabs_name'];

        if (empty($tabs_name['organiza']) or !isset($tabs_name['organiza']))        { $tabs_name['organiza'] = 'Organización'; }
        if (empty($tabs_name['areas'])  or !isset($tabs_name['areas']) )            { $tabs_name['areas'] = 'Áreas Temáticas'; }
        if (empty($tabs_name['disertantes']) or !isset($tabs_name['disertantes']) ) { $tabs_name['disertantes'] = 'Expositores'; }
        if (empty($tabs_name['trabajos']) or !isset($tabs_name['trabajos']) )       { $tabs_name['trabajos'] = 'Pres.Trabajos'; }
        if (empty($tabs_name['autoridades']) or !isset($tabs_name['autoridades']) ) { $tabs_name['autoridades'] = 'Autoridades'; }
        if (empty($tabs_name['sponsors'])  or !isset($tabs_name['sponsors']) )      { $tabs_name['sponsors'] = 'Sponsors'; }
        if (empty($tabs_name['auspicios']) or !isset($tabs_name['auspicios']) )     { $tabs_name['auspicios'] = 'Auspicios'; }
        if (!isset($tabs_name['cronograma']) or empty($tabs_name['cronograma']) )   { $tabs_name['cronograma'] = 'Cronograma'; }

        $data['tabs_name'] = json_encode($tabs_name);

        unset($data['submit']);


        $data['modificado'] = time();

        $identificador = $data['identificador'];
        unset($data['identificador']);

        $familia = $data['familia'];
        unset($data['familia']);
        $subfamilia = $data['subfamilia'];
        unset($data['subfamilia']);

        $data['validator']   = time().'-'.$user_id;
        $data['urlamigable'] = str_replace('.html','', $data['urlamigable']);

        $data['desde'] = mktime(0,0,0,$data['desde_mes'],$data['desde_dia'],$data['desde_ano']);
        unset($data['desde_mes']);
        unset($data['desde_dia']);
        unset($data['desde_ano']);

        $data['hasta'] = mktime(23,59,59,$data['hasta_mes'],$data['hasta_dia'],$data['hasta_ano']);
        unset($data['hasta_mes']);
        unset($data['hasta_dia']);
        unset($data['hasta_ano']);


        $data['user_id'] = $_SESSION['user_id'];
        
        if ($data['id']==0) {$data['created'] = time(); }

//$db->debug = true;
        $ok = $db->Replace('productos', $data,'id', $autoquote = true); 
        if ($data['id']==0) {
            $rs = $db->SelectLimit("select id from productos where validator='{$data['validator']}'",1);
            $x  = $rs->FetchRow();
            $id = $x['id'];
            $data['id'] = $id;
			
			//--------------------- Agrego la relacion producto / familia / subfamilia
			$pf = array();
			$pf['id']            = 0;                
			$pf['producto_id']   = $data['id'];
			$pf['familia_id']    = $familia[0];
			$pf['subfamilia_id'] = $subfamilia[0];
			$ok = $db->AutoExecute('productos_familias', $pf, 'INSERT');     
			
			
			redirect(URL.'/account/aviso.php?id='.$id);
			die();
        }
//die();


        if( !empty($identificador) ) {
            //--Al ser un registro nuevo, tengo que actualizar el product_id de las imagenes
            $sql = "update productos_imagenes set producto_id = '{$data['id']}', identificador='' where producto_id=0 and identificador='$identificador'";
            $rs  = $db->Execute($sql);
        }


        //--------------------- Elimina las relaciones producto/familia
        $sql = "delete from productos_familias where producto_id='{$data['id']}'";
        $rs  = $db->Execute($sql);
		$pf = array();
        $pf['id']            = 0;                
        $pf['producto_id']   = $data['id'];
        $pf['familia_id']    = $familia[0];
        $pf['subfamilia_id'] = $subfamilia[0];
        $ok = $db->AutoExecute('productos_familias', $pf, 'INSERT');     

        $Mensaje["mensaje"]   = 'El Evento se guardo correctamente!';
        $Mensaje["tipo"]      = 'success';
        $Mensaje["autoclose"] = true;
        $_SESSION['Mensaje']  = $Mensaje;                

        redirect(URL.'/account/listar_anuncios.php');
        die();

    } // end $_POST



    $data = array();

    //----------------------------------------------------------------
	//                                                Busco el usuario
    //----------------------------------------------------------------	
    $cond    = "select * from usuarios where id='$user_id' ";
    $rs      = $db->SelectLimit($cond, 1);
    $Usuario = $rs->FetchRow();

    //----------------------------------------------------------------
    //                                                Busco el anuncio
    //----------------------------------------------------------------	
    $cond   = "select * from productos where id='$id' and user_id='$user_id' ";
    $rs     = $db->SelectLimit($cond, 1);
    $data   = $rs->FetchRow();

    //----------------------------------------------------------------
	//                         Obtengo y Asigno nombre a las pestañas
    //----------------------------------------------------------------
    if(!empty($data['tabs_name'])){
        $tabs_name = json_decode($data['tabs_name'],true);    
    }
    if (empty($tabs_name['organiza']) or !isset($tabs_name['organiza']))        { $tabs_name['organiza'] = 'Organización'; }
    if (empty($tabs_name['areas'])  or !isset($tabs_name['areas']) )            { $tabs_name['areas'] = 'Áreas Temáticas'; }
    if (empty($tabs_name['disertantes']) or !isset($tabs_name['disertantes']) ) { $tabs_name['disertantes'] = 'Expositores'; }
    if (empty($tabs_name['trabajos']) or !isset($tabs_name['trabajos']) )       { $tabs_name['trabajos'] = 'Pres.Trabajos'; }
    if (empty($tabs_name['autoridades']) or !isset($tabs_name['autoridades']) ) { $tabs_name['autoridades'] = 'Autoridades'; }
	if (empty($tabs_name['sponsors'])  or !isset($tabs_name['sponsors']) )      { $tabs_name['sponsors'] = 'Sponsors'; }
    if (empty($tabs_name['auspicios']) or !isset($tabs_name['auspicios']) )     { $tabs_name['auspicios'] = 'Auspicios'; }
    if (!isset($tabs_name['cronograma']) or empty($tabs_name['cronograma'])  )  { $tabs_name['cronograma'] = 'Cronograma'; }
    
    

    if($id == 0 ) { $identificador = microtime()."-".$_SERVER["REMOTE_ADDR"]; } else { $identificador = ''; }

    //----------------------------------------------------------------
    //                                              Busco las imagenes
    //----------------------------------------------------------------	
    $cond   = "select * from productos_imagenes where producto_id = '$id' order by id ASC";
    $rs     = $db->SelectLimit($cond,IMAGENES_POR_ANUNCIO);
    $productos_imagenes = $rs->GetRows();

    for ($i=0; $i < IMAGENES_POR_ANUNCIO; $i++) { 
        if (!isset($productos_imagenes[$i])){
            $productos_imagenes[$i]['id']          = 0;
            $productos_imagenes[$i]['producto_id'] = $id;
            $productos_imagenes[$i]['imagen']      = '';
        }
    }

    //----------------------------------------------------------------
    // Obtiene los Rubros/Sub-Rubros donde esta registrado este anuncio
    //----------------------------------------------------------------	
    $sql = "select * from productos_familias where producto_id = '$id' order by id ASC" ;
    $rs  = $db->SelectLimit($sql,CANTIDAD_DE_RUBROS);
    $Productos_Familias = $rs->GetRows();

    //----------------------------------------------------------------
    //                                          Arma combo de familias
    //----------------------------------------------------------------	
    $sql = "select * from familias where parent_id=0 and activo=1 order by nombre1 ASC";
    $rs  = $db->Execute($sql);
    $Rubros = $rs->GetRows();


    for($i=0;$i<CANTIDAD_DE_RUBROS;$i++){
        $select_rubro = "<select name='familia[$i]' id='familia_$i' style='line-height:20px; padding:3px;' class='required'>";
        $select_rubro.= "<option value='0' >Seleccione un Área</option>";
        foreach($Rubros as $ru){

            if(isset($Productos_Familias[$i]['familia_id']) and $Productos_Familias[$i]['familia_id']==$ru['id']) {
                $sel = 'selected=selected';
            } else {
                $sel = '';
            }
            $select_rubro.= "<option value='{$ru['id']}' $sel >{$ru['nombre1']}</option>";
        }
        $select_rubro.= "</select>";

        if( isset($Productos_Familias[$i]['subfamilia_id']) and $Productos_Familias[$i]['subfamilia_id']>0 ) {
            //Busco las subfamilias
            $sql = "select * from familias where parent_id={$Productos_Familias[$i]['familia_id']} and activo=1 order by nombre1 ASC";
            $rs  = $db->Execute($sql);
            $SubRubros = $rs->GetRows();
            $select_subrubro = "<select name='subfamilia[$i]' id='subfamilia_$i' style='line-height:20px; padding:3px;' class='required'>";
            foreach($SubRubros as $sru){
                if(isset($Productos_Familias[$i]['subfamilia_id']) and $Productos_Familias[$i]['subfamilia_id']==$sru['id']) {
                    $sel = 'selected=selected';
                } else {
                    $sel = '';
                }
                $select_subrubro.= "<option value='{$sru['id']}' $sel >{$sru['nombre1']}</option>";
            }
            $select_subrubro.= "</select>";
        } else {
            $select_subrubro = "<select name='subfamilia[$i]' id='subfamilia_$i' style='line-height:20px; padding:3px;' class='required'>
                                <option value='0'> Debe seleccionar un área</option>
                                </select>";
        }
        $Sel_Rubro[$i] = $select_rubro;
        $Sel_SubRubro[$i] = $select_subrubro;
    }



/*

        // Estadisticas de Visita
        $sql = "select count(id) as cuantos, semana from visitas_unicas where producto_id='{$data['id']}' and visualizacion=1 group by semana order by fecha ASC";
        $rs  = $db->Execute($sql);
        $Visitas = $rs->GetRows();
        $total_visitas = 0;
        foreach($Visitas as $v){ $total_visitas = $total_visitas + $v['cuantos']; }

        // Estadisticas de Click
        $sql = "select count(id) as cuantos, semana from visitas_unicas where producto_id='{$data['id']}' and click=1 group by semana order by fecha ASC";
        $rs  = $db->Execute($sql);
        $Click = $rs->GetRows();
        $total_clicks = 0;
        foreach($Click as $v){ $total_clicks = $total_clicks + $v['cuantos']; }

        // Estadisticas de Enlaces Externos
        $sql = "select count(id) as cuantos, semana from enlaces_externos where producto_id='{$data['id']}' group by semana order by fecha ASC";
        $rs  = $db->Execute($sql);
        $Enlaces = $rs->GetRows();
        $total_enlaces = 0;
        foreach($Enlaces as $v){ $total_enlaces = $total_enlaces + $v['cuantos']; }

        // Estadisticas de Envios de Formularios
        $sql = "select count(id) as cuantos, semana from envio_formularios where producto_id='{$data['id']}' group by semana order by fecha ASC";
        $rs  = $db->Execute($sql);
        $Formularios = $rs->GetRows();
        $total_formularios = 0;
        foreach($Formularios as $v){ $total_formularios = $total_formularios + $v['cuantos']; }
*/

		//----------------------------------------------------------------
		//                                                Combo Provincias
		//----------------------------------------------------------------		
		if ( !isset($data['provincia_id']) or $data['provincia_id']==0 ) {$data['provincia_id']= PROVINCIA; }
        $select_provincia = '<select name="provincia_id" id="provincia_id" class="required" style="line-height:20px;padding:3px;">';
        foreach($Provincias as $dd){
                if ( $data['provincia_id'] == $dd['id'] ) { 
                    $sel = "selected='selected'"; 
                    $data['provincia_id']   = $dd['id'];
                    $data['provincia_name'] = $dd['locacion'];                    
                } else {
                    $sel='';
                }
                $select_provincia.= "<option value='{$dd['id']}' $sel >{$dd['locacion']}</option>";
        }
        $select_provincia.= "</select>";
		
		//----------------------------------------------------------------
        //                                                  Combo ciudades
		//----------------------------------------------------------------		
        $sql = "select * from ciudades where parent_id='{$data['provincia_id']}' and activo='1' order by locacion ASC";
        $rs  = $db->Execute($sql);
        $Ciudades = $rs->GetRows();

		if ( !isset($data['ciudad_id']) or $data['ciudad_id']==0 ) {$data['ciudad_id']= CIUDAD; }
        $select_ciudad = '<select name="ciudad_id" id="ciudad_id" class="required"  style="line-height:20px;padding:3px;">';
        foreach($Ciudades as $dd){
                if ( $data['ciudad_id'] == $dd['id'] ) { 
                    $sel = "selected='selected'"; 
                } else {
                    $sel='';
                }
                $select_ciudad.= "<option value='{$dd['id']}' $sel >{$dd['locacion']}</option>";
        }
        $select_ciudad.= "</select>";

    //------------------------------------------------------------ Arma Combo Tipo de Moneda
    $select_moneda = '<select name="moneda" id="moneda" class="required">';
    foreach($Monedas as $clave=>$valor){
        if ( $data['moneda'] == $clave ) { $sel = "selected='selected'"; } else { $sel=''; }
        $select_moneda.= "<option value='$clave' $sel >$valor</option>";
    }
    $select_moneda.= "</select>";


    $cat_id = 0;
    $mostrar_en_home = 0;
    $menu_cta = 'listar_anuncios';

    include_once(ROOT.'/inc/inc_publicidad.php');

    include_once(ROOT.'/html/header.html.php');

    include_once(ROOT.'/account/aviso.html.php');

    include_once(ROOT.'/html/footer.html.php');
    die();


?>