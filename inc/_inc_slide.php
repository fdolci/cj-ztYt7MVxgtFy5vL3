<?php
	$cond  = "select * from slides where activo=1 and id='$slide_id'";
	$rs    = $db->SelectLimit($cond,1);
	$x 	   = $rs->FetchRow();
    $xdata = unserialize($x['data']);	
    $ancho = $x['ancho'];
    $alto  = $x['alto'];
    
    $x = 0;
    $slides = array();
    
    foreach($xdata as $value) {
        $slides[$x]['imagen'] = $value['imagen'];
        $slides[$x]['posicion_texto'] = $value['posicion_texto'];
        $slides[$x]['texto'] = html_entity_decode($value['texto']);
        $slides[$x]['href'] = $value['href'];
        $x++;
    }
	foreach($slides as $clave=>$valor) {
		if($valor['posicion_texto']=='Centro'){ $slides[$clave]['donde']="top:0px;text-align:center;margin:0px auto;"; }
		if($valor['posicion_texto']=='Derecha'){ $slides[$clave]['donde']="top:0px;float:right;text-align:right; margin-right:70px;"; }
		if($valor['posicion_texto']=='Izquierda'){ $slides[$clave]['donde']="float:left;text-align:left;margin-left:30px;"; }
	}


    $return_slide = '';
    
    
    $xalto = $alto.'px';
    $xancho = $ancho.'px';

	
    $return_slide = "<link href='".URL."/js/jsImgSlider/themes/1/js-image-slider.css' rel='stylesheet' type='text/css' />";
    $return_slide.= "<script src='".URL."/js/jsImgSlider/themes/1/js-image-slider.js' type='text/javascript'></script>";
    $return_slide.= "<link href='".URL."/js/jsImgSlider/generic.css' rel='stylesheet' type='text/css' />";
    $botonera = $alto-50;
    $return_slide.="<style>
    #slider { width:".$ancho."px;height:".$alto."px;}
    #sliderFrame { width:".$ancho."px; margin-bottom:50px;}
    div.navBulletsWrapper  {  top:".$botonera."px;}
    </style>";

	$return_slide.= "
    <div id='sliderFrame' >
        <div id='slider'>";
    foreach($slides as $s) { 

		if(!empty($s['href'])){
			$return_slide.= "		<a href='{$s['href']}' >";
		}
		$return_slide.= "		<img src='{$s['imagen']}' alt='{$s['texto']}'>";			
		if(!empty($s['href'])){
			$return_slide.= "		</a>";
		}

	}	

	$return_slide.= "
        </div>
    </div><br><br>
    ";

?>