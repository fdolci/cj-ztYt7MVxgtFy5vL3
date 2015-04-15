<?php 
    // Top 20 de anuncios home
    $sql = "select usuarios.id,nombre_entidad, url, pi.imagen
            from usuarios
				left join productos_imagenes as pi on usuarios.id = pi.user_id
            where activo = '1' and pi.cual='miniatura'
			order by rand()";
    $rs  = $db->SelectLimit($sql,30);
    $Ultimos = $rs->GetRows();

?>

<script type="text/javascript" src="<?php echo URL;?>/js/caroufredsel/jquery.caroufredsel.js"></script>
<link href="<?php echo URL;?>/js/caroufredsel/jquery.caroufredsel.css" type="text/css" rel="stylesheet"/>


    <div class="image_carousel" style="width:940px;">
	<h2 style='margin-top:15px;'>Algunas Asociaciones que utilizan CongresosyJornadas.net</h2>
	   <div id="foo1" >
<?php
    foreach ($Ultimos as $u){
        $href = URL."/{$u['url']}";
        $logo = "<img src='".VER_FOTOS."/mini/tn_{$u['imagen']}' width='150' height='76' title='{$u['nombre_entidad']}' alt='{$u['nombre_entidad']}' style='width:150px;height:76px;'  />";
        echo $logo;
    }
?>
	   </div>
	   <div class="clearfix"></div>
    </div>
    
<script type="text/javascript" language="javascript">
$(document).ready(function() {
		
    $("#foo1").carouFredSel({
	   width: '150',
	   height: '76',
	   align: true,
	   auto: true,
	   direction: 'left',
	   duration: '20'
    });
});                    
</script>
<div class="clear"></div>