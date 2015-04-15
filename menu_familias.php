<?php
    $cat_id = 0;
    $mostrar_en_home = 1;
    //include_once(ROOT.'/inc/inc_publicidad.php');
    if (isset($ruta)) {
        list($url_amigable,$extension) = explode('.', end($ruta));    
    }
    

    $ubicacion = $xurl['provincia']['nombre'];
    $familia_id = $xurl['familia']['id'];

    if ( $familia_id==0 ) {
        $Sumario = $DatosEmpresa['sumario_home'];

        $mTitle          = '';
        $mRobots         = '';
        $mKeywords       = '';
        $mDescription    = '';

    } else {
        $Sumario = "<h3>Directorio de {$xurl['familia']['nombre']} en $ubicacion </h3>";
        if(!empty($xurl['familia']['sumario'])) {
            $Sumario.="<b>".$xurl['familia']['nombre'].' en '.$ubicacion."</b> ".$xurl['familia']['sumario'];
        } else {
            $Sumario.="";
        }
        
        $mTitle          = $xurl['familia']['meta-title'];
        $mRobots         = $xurl['familia']['meta-robots'];
        $mKeywords       = $xurl['familia']['meta-keywords'];
        $mDescription    = $xurl['familia']['meta-description'];

    }


    if($xurl['provincia']['id']>0){
        $prov_url = "/{$xurl['provincia']['url']}";
    } else {
        $prov_url = "";
    }



    $sql = "select * from familias where parent_id='0' and activo=1 order by orden ASC";
    $rs  = $db->Execute($sql);
    $xFam = $rs->GetRows();
//pr($xFam);
    foreach($xFam as $x){
        $z = array();
        $z['id']      = $x['id'];
        $z['nombre']  = $x['nombre1'];
        $z['cuantos'] = 0;
        $z['url']     = URL.$prov_url.$ciudad_url.'/'.$x['urlamigable1'];            
        //------------------------------------------------------------------
        //                                            Listado de SbFamilias
        //------------------------------------------------------------------
        $sql = "select id, nombre1 as nombre, urlamigable1 from familias where parent_id='{$z['id']}'  and activo=1 order by orden ASC";
        $rs  = $db->Execute($sql);  
        $child = $rs->GetRows();

        if($child and !empty($child)) {

            foreach($child as $clave=>$valor) {

                if( $xurl['provincia']['id']==0 ){
                    $cond_pcia = '';
                    $cond_ciudad = '';
/*                    
                        // Cuantos anuncios hay por familia ??
                        $sql = "select count(distinct producto_id) as cuantos 
                                from productos_familias
                                where subfamilia_id='{$valor['id']}' ";
                        $rs  = $db->SelectLimit($sql,1);
                        $hay = $rs->FetchRow();

                        $child[$clave]['cuantos'] = $hay['cuantos']; 
                        $z['cuantos']             = $z['cuantos'] + $hay['cuantos']; 
                        $child[$clave]['url']     = $z['url'].'/'.$valor['urlamigable1'];                
*/   
                } else {

                    $cond_pcia = "and productos.provincia_id = '{$xurl['provincia']['id']}'" ;

                    if($xurl['ciudad']['id']>0){
                        $cond_ciudad = "and productos.ciudad_id='{$xurl['ciudad']['id']}'";
                        $ciudad_url = "/{$xurl['ciudad']['url']}";
                    } else {
                        $cond_ciudad = '';
                    }    

                }    
                // Cuantos anuncios hay por familia ??
                $sql = "select count(distinct producto_id) as cuantos from productos_familias
                                left join productos on productos_familias.producto_id = productos.id 
                                where productos_familias.subfamilia_id='{$valor['id']}' $cond_pcia $cond_ciudad";
//echo $sql;
                $rs  = $db->SelectLimit($sql,1);
                $hay = $rs->FetchRow();
                $child[$clave]['cuantos'] = $hay['cuantos']; 
                $child[$clave]['url']     = URL.$prov_url.$ciudad_url.'/'.$x['urlamigable1'].'/'.$valor['urlamigable1'];
                $z['cuantos']             = $z['cuantos'] + $hay['cuantos']; 


            } // end foreach $child

            $z['child'] = $child;

        }
            

        
        $Familias[]  = $z;
    }
    


    include_once(ROOT.'/html/menu_familias.html.php');
//pr($xurl);
?>