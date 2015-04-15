<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<style type="text/css">
.info_map {
	width:300px;
}
	.info_map h1{
		line-height:15px;
		font-size:15px;
		font-weight:bold;
		font-family:'Arial';
		margin:0px;
	}
	.info_map p{
		font-family:'Arial';
		font-size:11px; 
		text-align:left;
	}
	.info_map p img{
		width:50px;
		height:50px; 
		margin:5px; 
		float:left;
	}
	.info_map p a{
		clear:both;
		color:#FF9900;
		font-weight:bold;
	}


</style>

<script type="text/javascript">

	var geocoder;
	var map;

    function initialize_mapa() {

		geocoder = new google.maps.Geocoder();
		var myOptions = {
			zoom:11,
			mapTypeId : google.maps.MapTypeId.ROADMAP	
		};

		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	
		<?php foreach($Alojamientos as $clave=>$m){ ?>
			<?php if (!empty($m['direccion'])) { ?>

			geocoder.geocode (
				{'address': '<?php echo $m["direccion"];?>, <?php echo $Localidades[$m["localidad"]];?>, <?php echo $m["provincia"];?>, <?php echo $m["pais"];?>'},
				function ( results, status ) {
					if ( status == google.maps.GeocoderStatus.OK ) {
						//map = new google.maps.Map( document.getElementById("map_canvas"), myOptions );
						//console.log(results[0].geometry);
						map.setCenter (results[0].geometry.location );

						var marker_<?php echo $clave;?> = new google.maps.Marker ({
									map: map,
									position: results[0].geometry.location,
									title: '<?php echo $m["titulo"];?>',
									<?php if (!empty($m['fam_img'])) { ?>
										icon: '<?php echo $m['fam_img'];?>' ,
									<?php }?>
									zIndex: <?php echo $clave;?>

						});

						var contentString = "<div class='info_map'>"+
											"<h1><?php echo $m['titulo'];?></h1>"+
											"<p><img src='<?php echo $m['logo'];?>' alt='Logo de: <?php echo $m['titulo'];?>'>"+
											"<?php echo substr($m['subtitulo'],0,45);?>"+
											"<br>Categoría: <?php echo $m['fam_nombre'];?>"+
											"<br><a href='<?php echo $m['href'];?>' title='Ver más información de <?php echo $m['titulo'];?>'>[+] Ver más información </a>"+
											"</p></div>";

			
						var infowindow_<?php echo $clave;?> = new google.maps.InfoWindow({
							content: contentString,
							maxWidth : 400
						});

						google.maps.event.addListener(marker_<?php echo $clave;?>, 'click', function() {
						  infowindow_<?php echo $clave;?>.open(map,marker_<?php echo $clave;?>);
						});


					} 

				}

			);
			<?php } //endif !emoty direccion ?>
		
		<?php } //end foreach ?>



    }
    
    
	window.onload = initialize_mapa;
</script>

<div id="map_canvas" style="width:620px; height:250px; border:1px solid #D5C7B8; overflow:hidden;margin-bottom:20px;"></div>