<?php
	include_once("./inc/config.php"      );
   
    $Resultados = array();

    $route='buscar';
    $breadcrumb[0]['href']  = URL;
    $breadcrumb[0]['title'] = $Traducciones['home'];
    $breadcrumb[1]['href']  = URL;
    $breadcrumb[1]['title'] = $Traducciones['resultado_busqueda'];

        $cat_id = 0;
        $mostrar_en_home = 1;
        include_once(ROOT.'/inc/inc_publicidad.php');


    $buscar_nombre    = request('nombre','');
    $buscar_ubicacion = request('ubicacion',0);
    $buscar_categoria = request('categoria',0);


    if (!empty($buscar_nombre)) {

        if ( $buscar_ubicacion>0 ) {
            $s_ubicacion = " and productos.localidad='$buscar_ubicacion'";
        } else {
            $s_ubicacion = '';
        }

        if ( $buscar_categoria>0 ) {
            $s_categoria = "$and productos.familia_id='$buscar_categoria'";
        } else {
            $s_categoria = '';
        }


        $cond = "select productos.*, familias.urlamigable1 as fam_url , familias.thumbs1 as fam_img , familias.nombre1 as fam_nombre
                from productos 
                left join familias on productos.familia_id = familias.id 
                where productos.titulo like '%$buscar_nombre%'  $s_ubicacion $s_categoria and productos.activo= '1' 
                order by titulo ASC";
        //echo $cond;        

	} else {

        if ( $buscar_ubicacion>0 ) {
            $s_ubicacion = " productos.localidad='$buscar_ubicacion'";
            $and = ' and ';
        } else {
            $s_ubicacion = '';
            $and = '';
        }

        if ( $buscar_categoria>0 ) {
            $s_categoria = "$and productos.familia_id='$buscar_categoria'";
        } else {
            $s_categoria = '';
        }
        if ($buscar_categoria>0 or $buscar_ubicacion>0) {
            $and2 = ' and ';
        } else { $and2='';}

        $cond = "select productos.*, familias.urlamigable1 as fam_url , familias.thumbs1 as fam_img , familias.nombre1 as fam_nombre
                from productos 
                left join familias on productos.familia_id = familias.id 
                where $s_ubicacion $s_categoria $and2 productos.activo= '1' 
                order by titulo ASC";
        //echo $cond;        

    }
echo $cond;
    $rs = $db->SelectLimit($cond,20);   
    $Alojamientos = $rs->GetRows();
   
        if($Alojamientos){
            foreach($Alojamientos as $clave=>$valor){
                $href = URL.'/'.$valor['fam_url']."/".$valor['urlamigable'].'.html';
                $Alojamientos[$clave]['href'] = $href;
            }
        }
    
    //include_once('./inc/inc_publicidad.php');
    include_once('./html/header.html.php');
    include_once('./html/buscar.html.php');
    include_once('./html/footer.html.php');
    
    

?>