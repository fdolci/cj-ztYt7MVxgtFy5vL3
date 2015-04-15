<?php
	$sel01 = $sel02 = $sel03 = $sel04 = $sel05 = $sel06 = $sel07 = '';
	$pcia_url = $xurl['provincia']['url'];
	if ($pcia_url=='guanacaste' ) {
		$sel01 = "data-maphilight='{\"alwaysOn\":true}'";
	} elseif ($pcia_url=='alajuela' ) {
		$sel02 = "data-maphilight='{\"alwaysOn\":true}'";
	} elseif ($pcia_url=='heredia' ) {
		$sel03 = "data-maphilight='{\"alwaysOn\":true}'";
	} elseif ($pcia_url=='limon' ) {
		$sel04 = "data-maphilight='{\"alwaysOn\":true}'";
	} elseif ($pcia_url=='cartago' ) {
		$sel05 = "data-maphilight='{\"alwaysOn\":true}'";
	} elseif ($pcia_url=='san-jose' ) {
		$sel06 = "data-maphilight='{\"alwaysOn\":true}'";
	} elseif ($pcia_url=='puntarenas' ) {
		$sel07 = "data-maphilight='{\"alwaysOn\":true}'";
	}
	
	if($xurl['familia']['id']>0){
		$url_rubros = '/'.$xurl['familia']['url'];
		if($xurl['subfamilia']['id']>0){
			$url_rubros.= '/'.$xurl['subfamilia']['url'];
		}
	} else {
		$url_rubos = '';
	}



?>

<div class="grid_3" style="min-height:250px;">


	<script type="text/javascript" src="<?php echo URL;?>/js/jquery.maphilight.min.js"></script>
	
	<img src="<?php echo URL;?>/img/mapa.jpg" style="width:230px;height:230px;border:none;" ismap usemap="#mapa.jpg" class="map" alt="Costa Rica">

	<map name="mapa.jpg">
	<area shape="polygon" 
		coords="39,18,30,13,26,26,26,32,16,33,14,32,15,35,27,41,28,48,29,54,24,61,20,61,20,67,19,71,15,74,16,81,21,94,30,105,42,107,48,109,52,112,53,114,54,112,54,108,48,107,46,105,46,101,50,100,53,99,55,98,55,94,50,91,50,87,52,86,52,82,50,80,50,77,52,77,55,79,55,82,57,84,59,85,62,84,64,86,68,86,74,85,74,83,74,79,76,77,77,74,80,73,81,71,80,65,78,61,75,60,73,60,71,58,69,55,66,50,63,49,59,46,56,45,54,44,52,46,46,42,46,40,42,39,39,33,39,32,50,22"
		href="<?php echo URL;?>/guanacaste<?php echo $url_rubros;?>" title="Provincia de Guanacaste" <?php echo $sel01;?>/>

	<area shape="polygon" 
		coords="43,33,54,23,72,31,78,31,89,21,111,31,120,45,120,98,116,101,110,103,100,103,97,106,95,107,92,105,94,103,97,101,99,98,93,93,91,88,92,78,84,76,84,67,82,61,79,58,75,57,72,56,68,46,63,46,59,42,51,41,48,37,43,36"
		href="<?php echo URL;?>/alajuela<?php echo $url_rubros;?>" title="Provincia de Alajuela" <?php echo $sel02;?> >

	<area shape="polygon" 
		coords="124,44,123,99,127,98,130,97,129,93,128,89,128,85,133,83,137,81,139,77,140,74,140,69,140,65,141,63,142,52,142,50,147,47,148,44,145,45,142,47,135,47,132,44" 
		href="<?php echo URL;?>/heredia<?php echo $url_rubros;?>" title="Provincia de Heredia" <?php echo $sel03;?> >

	<area shape="polygon" 
		coords="138,85,142,79,143,68,144,66,145,54,152,49,150,43,153,42,155,35,156,36,156,40,158,47,161,55,166,66,170,73,180,87,190,100,193,98,196,106,204,116,210,123,220,125,221,128,224,129,223,134,220,135,216,132,213,128,207,126,202,131,200,136,200,160,196,158,193,154,190,149,186,146,183,144,171,144,164,131,176,112,176,104,177,103,177,99,173,98,159,98,155,97,151,93,147,92,139,89"
		href="<?php echo URL;?>/limon<?php echo $url_rubros;?>" title="Provincia de Limon" <?php echo $sel04;?> >

	<area shape="polygon" 
		coords="140,92,146,95,151,97,157,101,159,101,174,102,173,110,164,128,161,130,159,131,157,128,152,127,151,128,146,125,138,120,130,113,133,110,133,106,140,102,142,101,141,96,140,92"
		href="<?php echo URL;?>/cartago<?php echo $url_rubros;?>" title="Provincia de Cartago" <?php echo $sel05;?> >
		
	<area shape="polygon" 
		coords="135,87,130,88,132,93,132,97,130,102,123,102,120,102,111,106,107,106,102,105,99,109,97,112,98,115,99,121,100,126,105,126,110,122,116,122,122,124,130,131,147,150,152,151,155,153,159,160,166,161,165,158,164,155,164,152,166,148,167,145,164,138,163,135,161,134,157,133,155,130,151,131,149,132,132,118,127,116,125,114,126,111,129,109,130,104,139,100,135,86"
		href="<?php echo URL;?>/san-jose<?php echo $url_rubros;?>" title="Provincia de San José" <?php echo $sel06;?> >
		
	<area shape="polygon" alt="puntarenas" 
		coords="155,190,151,192,150,196,159,206,167,207,177,210,177,201,171,198,168,196,167,192,164,190,165,187,175,187,176,191,188,195,190,203,192,207,189,213,193,217,199,210,205,208,206,206,207,195,205,192,203,190,202,184,205,179,210,177,215,174,206,165,198,164,192,160,189,154,185,150,181,147,171,147,167,154,169,157,168,161,168,164,162,165,158,163,152,154,146,153,122,128,119,127,113,125,108,128,106,129,99,130,96,127,95,122,95,116,95,112,90,105,90,102,94,99,91,93,88,88,89,81,84,80,80,76,79,78,78,83,76,86,72,93,78,98,86,100,92,116,90,119,91,125,94,129,99,132,106,133,114,134,122,137,122,141,129,143,135,146,156,166,158,173,161,177,159,183,156,185"
		href="<?php echo URL;?>/puntarenas<?php echo $url_rubros;?>" title="Provincia de Puntarenas" <?php echo $sel07;?> >
		
	<area shape="polygon" alt="puntarenas" 
		coords="53,102,58,99,66,101,67,103,73,104,73,113,70,116,66,116,65,120,63,121,62,126,59,126,55,118,56,115,58,112,57,107,52,102"
		href="<?php echo URL;?>/puntarenas<?php echo $url_rubros;?>" title="Provincia de Puntarenas" <?php echo $sel07;?> >
	</map>


	<script type="text/javascript">
	$(function() {
		$.fn.maphilight.defaults = {
			fill: true,
			fillColor: 'FF9900',
			fillOpacity: 0.2,
			stroke: true,
			strokeColor: 'ff9900',
			strokeOpacity: 1,
			strokeWidth: 3,
			fade: true,
			alwaysOn: false,
			neverOn: false,
			groupBy: 'alt',
			wrapClass: true,
			shadow: false,
			shadowX: 0,
			shadowY: 0,
			shadowRadius: 6,
			shadowColor: '000000',
			shadowOpacity: 0.8,
			shadowPosition: 'outside',
			shadowFrom: false
		}

		$('.map').maphilight();
		
	
	});
	</script>

	
</div>
