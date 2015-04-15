<link rel="stylesheet" href="<?php echo URL;?>/css/lector_rss.css"  type="text/css" media="screen" /> 
<div class='grid_3' style='vertical-align:top;'>
    <?php include('./inc/inc_menu_familias.php'); ?>  
</div>
<div class='grid_9' style='vertical-align:top;' id='noticias'>
    
    <!-- SLIDER -->
    <?php echo slide(1); ?>

    <div class="fb-like" data-href="<?php echo $url_actual;?>" data-send="true" data-width="450" data-show-faces="false"></div>


    <h1 style='margin-top:30px;margin-bottom:20px;'>Canales de Comunicación RSS</h1>

    <p>Los canales RSS de <b><?php echo $DatosEmpresa['nombre_empresa'];?></b> le permiten agregar noticias en su sitio del modo que le resulte más conveniente. <b>(<?php echo $DatosEmpresa['nombre_empresa'];?> en tu sitio)</b><br></p>

         
    <h2>¿Qué es el RSS? </h2>
    <p>El RSS ("Really Simple Syndication") es un formato que permite emitir contenidos desde un sitio para que sean agregados fácilmente en aplicaciones o sitios web. Los contenidos que se publican en este formato incluyen titulares y sumarios.</p>
     
    <h2>Modo de uso </h2>
    <p>Se accede a este servicio a través de programas conocidos como "Lectores de noticias", que organizan, actualizan y muestran el contenido de los canales. Para agregar canales, se debe ingresar la url del canal deseado en los programas lectores. Se pueden crear grupos de canales, agrupando todas las secciones del diario bajo un mismo grupo.</p>
     
    <p>También se pueden agregar canales desde buscadores como El sindicón, Syndic8, BlogStreet, y NewsIsFree.</p>


    <ul>
        <li>Blog: <a href='<?php echo URL;?>/rss/blog' target='_blank'><?php echo URL;?>/rss/blog</a></li>
        <li>Nuevos Alojamientos Incorporados: <a href='<?php echo URL;?>/rss/new' target='_blank'><?php echo URL;?>/rss/new</a></li>

        <?php $Familias = MenuFamilias( 0 );?>
        <?php foreach($Familias as $clave=>$valor){ ?>
            <?php if (!empty($valor['child'])){ ?>
                    <?php foreach($valor['child'] as $clave2=>$valor2){ ?>
                     <li><?php echo $valor2['nombre'];?>: <a href='<?php echo URL;?>/rss/<?php echo $valor2['url'];?>' target='_blank'><?php echo URL;?>/rss/<?php echo $valor2['url'];?></a></li>
                    <?php } // end foreach $Familias ?>
            <?php } else {?>
                <li><?php echo $valor['nombre'];?>: <a href='<?php echo URL;?>/rss/<?php echo $valor['url'];?>' target='_blank'><?php echo URL;?>/rss/<?php echo $valor['url'];?></a></li>
            <?php } ?>
        <?php } // end foreach $Familias ?>
    </ul>

</div>
<?php /*
<div class='grid_2' style='vertical-align:top;'>
    <?php include('./html/inc_bloque_login.html.php'); ?>    
</div>
*/ ?>
<div class='clear'></div>

<?php //pr($destacados);?>




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