<?php
    if(isset($xurl['subfamilia']['id'])) {
        $familia_id = $xurl['subfamilia']['id'];
    } elseif(isset($xurl['familia']['id'])) {
        $familia_id = $xurl['familia']['id'];
    } else {
        $familia_id = 0;
    }


    $sql = "select * from publicidades where familia_id='$familia_id' and activo='1' and ubicacion='top' and (thumbs!='' or script!='')  order by orden ASC";

    $rs  = $db->SelectLimit($sql,10);
    $xdata = $rs->GetRows();

	if($xdata){

		$x = 0;
		$slides = array();
		
		foreach($xdata as $value) {
			$slides[$x]['imagen'] = VER_PUBLICIDAD.'/'.$value['thumbs'];
			$slides[$x]['href']   = $value['web'];
			$slides[$x]['texto']  = $value['titulo'];
			$x++;
		}

		$return_slide = '';

		$xalto  = '200px';
		$xancho = '700px';
		
		$return_slide = "<link href='".URL."/js/jsImgSlider/themes/1/js-image-slider.css' rel='stylesheet' type='text/css' />";
		$return_slide.= "<script src='".URL."/js/jsImgSlider/themes/1/js-image-slider.js' type='text/javascript'></script>";
		$return_slide.= "<link href='".URL."/js/jsImgSlider/generic.css' rel='stylesheet' type='text/css' />";            


		$botonera = '4px';
		$return_slide.="<style>
		#slider { width:$xancho;height:$xalto;}
		#sliderFrame { width:$xancho;}
		div.navBulletsWrapper  {  top:$botonera; }
		</style>";

		$return_slide.= "
		<div id='sliderFrame' style='margin-bottom:10px;'>
			<div id='slider'>";

		foreach($slides as $s) { 

			if(!empty($s['href'])){
				$return_slide.= "       <a href='{$s['href']}' target='_blank'>";
			}
			$return_slide.= "       <img src='{$s['imagen']}' alt='{$s['texto']}'>";            
			if(!empty($s['href'])){
				$return_slide.= "       </a>";
			}

		}   

		$return_slide.= "
			</div>
		</div><div class='clear'></div>
		";
		
		echo $return_slide;
	
	}
?>