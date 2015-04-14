<!-- LightBox Jquery -->
<script type="text/javascript" src="<?php echo URL;?>/js/lightbox/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>/js/lightbox/jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript">
	$(function() {
		$('#galeria_aviso a').lightBox({fixedNavigation:true});
	});
</script>    

<div id="galeria_aviso">
	<?php foreach ($Imagenes as $f){ ?>
		<a href="<?php echo VER_FOTOS.'/'.$f['imagen'];?>" title="<?php echo $Producto['titulo'].' img:'.$i ;?>">
		<img src="<?php echo VER_FOTOS.'/mini/tn_'.$f['imagen'];?>"  alt="<?php echo $Producto['titulo'].' img:'.$i;?>" /></a>            
	<?php } ?>    
</div>
