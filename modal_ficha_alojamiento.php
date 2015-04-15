<?php
	include('./inc/config.php');
	$alojamiento_id = $_GET['alojamiento_id'];
	$url_api = "http://www.RosarioAlojamientos.com/api/promo_cj/ficha.php?alojamiento_id=$alojamiento_id";
	$a       = file_get_contents($url_api);
	$r       = base64_decode($a);
	$result  = json_decode($r,true);
	pr($result);
		
?>