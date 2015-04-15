<div class='grid_3' style='vertical-align:top;'>
    <?php include('./inc/inc_menu_familias.php'); ?>  
</div>
<div class='grid_9' style='vertical-align:top;'>
    
    <!-- SLIDER -->
    <?php echo slide(2); ?>

  <?php if(!empty($Alojamientos)) { ?>

        <?php include("mapa_google_home.html.php");?>

        <h3 style='background:#F1A837;color:#000;line-height:20px;font-size:14px;padding-left:5px;'>Resultado de la búsqueda</h3>  

        <?php foreach ($Alojamientos as $d){ ?>
            <div class='c1' style='background:#F5F2EA;height:130px;'>
                <div class='lista_alojamientos_imagen'>
                   <a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?>'>
                        <img src='<?php echo $d['thumbs'];?>' style='width:150px;height:113px;margin:5px;'>
                    </a>
                </div>
                <div class='lista_alojamientos_detalle'>
                   <h1><?php echo $d['titulo'];?></h1>
                   <p style='height:30px;'><?php echo substr($d['resumen'],0,150);?></p>
                    <div class='datos_contacto_top' style='height:45px;overflow:hidden;'>
                        <span style='float:right;'>Categoría: <?php echo $d['fam_nombre'];?></span><br>
                        <?php if (!empty($d['telefono1'])) { echo "<img src='".URL."/img/telefono01.jpg' style='height:12px;width:22px;'> {$d['telefono1']}"; } ?>
                        <?php if (!empty($d['telefono2'])) { echo " / {$d['telefono2']}"; }?>
                        <br><img src='<?php echo URL;?>/img/postal01.jpg'  style='height:12px; width:22px;'>
                        <?php echo $d['direccion'];?> | <?php echo $Localidades[$d['localidad']];?> (<?php echo $d['codigo_postal'];?>)
                         | <?php echo $d['provincia'];?> | <?php echo $d['pais'];?>

                    </div>
                   <a href='<?php echo $d['href'];?>' title='ver detalles' class='boton'>ver detalles</a>
                </div>
            </div>
            <div class="cl-sombra-grande"></div>
            <div class='clear' style='margin-bottom:10px;'></div>          
      <?php } // endforeach  ?>

  <?php } else {  ?>

          <h1>No se encontraron resultados</h1>
          <h2>Disculpe las molestias, estamos incorporando nuevos alojamientos.<br>En breve estarán disponibles todas las categorías</h2>


  <?php }  ?>


</div>
<div class='clear'></div>
