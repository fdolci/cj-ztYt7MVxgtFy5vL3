<div class='grid_3' style='vertical-align:top;'>
	
	
    <?php include('./inc/inc_menu_familias.php'); ?>  
</div>
<div class='grid_9' style='vertical-align:top;'>
    
    <!-- SLIDER -->
    <?php echo slide(1); ?>

    <?php include('./html/inc_barra_sharethis.html.php') ?>    

    <!--     <div class="fb-like" data-href="<?php echo $url_actual;?>" data-send="true" data-width="450" data-show-faces="false"></div> -->
    <?php if ($pagina==1) { include('./html/inc_alojamientos_destacados.html.php'); } ?>

    <?php include('./html/inc_listado_alojamientos.html.php') ?>    
</div>

<div class='clear'></div>


<hr style='border-bottom:1px solid #bbb;'>
<div class='clear' style='margin-bottom:15px;'></div>

<div class='grid_6' id='novedades'>
    <?php include('./inc/inc_ultimos_blog.php'); ?>
</div>
    
<div class='grid_2' style='vertical-align:top;'>
    <?php include('./html/botones_compartir.html.php'); ?>      
</div>



<div class='grid_4'>
    <?php include('./html/megusta_facebook.html.php'); ?>            
</div>