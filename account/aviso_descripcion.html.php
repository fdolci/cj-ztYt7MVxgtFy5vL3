
<?php /*
<div class='grid_2 ctitulo' >Banner Superior:<br>600x100</div>
<div class='grid_8'>
            <?php 
                $ajaxupload['tabla'] = 'productos_imagenes';
                $ajaxupload['campo'] = 'producto_id';
                $ajaxupload['id']    = $data['id'];
                $ajaxupload['cual']  = 'banner_top';
                $ajaxupload['identificador']  = $identificador;
                $ajaxupload['donde_subir']    = SUBIR_FOTOS;
                $ajaxupload['donde_ver']      = VER_FOTOS;
                $ajaxupload['tn_ancho'] = 0;
                $ajaxupload['tn_alto']  = 0;
                $ajaxupload['ancho']    = 600;
                $ajaxupload['alto']     = 100;
                $datos_ajaxupload = base64_encode( serialize($ajaxupload) );
                include(ROOT.'/modules/AjaxUpload/sube_banner.html.php'); 
            ?>

</div>
<div class='clear'></div>

*/?>

<h3 style='text-align:left;margin-bottom:20px;'>Resumen: <small>Esta información se mostrará en el listado de los Anuncios</small></h3>
<div class='ayuda'>
<h4>Resumen: Importante</h4>
<p>En esta opción Ud. completará el sumario que se aplicará al recuadro del anuncio, tal como lo remarcamos en la imagen a continuación. Este apartado reviste real importancia junto a la imágen en miniatura que suba, ya que lo que trata es de "Captar" el interés de los visitantes por encima del de sus competidores.</p>
<img src='<?php echo URL;?>/img/ayuda_resumen_anuncio.jpg' style='margin-left:150px; margin-bottom:20px;width:600px;border:1px solid #CCC;'>
</div>

<div class='grid_3 ctitulo' >Imagen Miniatura:<br>
            <?php 
                $ajaxupload['tabla'] = 'productos_imagenes';
                $ajaxupload['campo'] = 'producto_id';
                $ajaxupload['id']    = $data['id'];
                $ajaxupload['cual']  = 'miniatura';
                $ajaxupload['identificador']  = $identificador;
                $ajaxupload['donde_subir']    = SUBIR_FOTOS;
                $ajaxupload['donde_ver']      = VER_FOTOS;
                $ajaxupload['tn_ancho'] = 150;
                $ajaxupload['tn_alto']  = 110;
                $ajaxupload['ancho']    = 440;
                $ajaxupload['alto']     = 323;
                $datos_ajaxupload = base64_encode( serialize($ajaxupload) );
                include(ROOT.'/modules/AjaxUpload/sube_miniatura.html.php'); 
            ?>
            (150px x 110px)
</div>

<div class='grid_7 ctitulo'>Resumen:<em>*</em> <small>Max.150caract</small><br>
    <textarea name='resumen' id='resumen' style='width:586px; height:50px;' ><?php echo $data['resumen'];?></textarea>
    <br><small>Disponible: <span id='disponible_resumen'></span> de 150.</small>
</div>
<div class='clear'></div>

<hr style='border-top:1px solid #333;margin:20px 0px;'>

<h3 style='text-align:left;'>Descripción completa del anuncio</h3>
<div class='ayuda'>
<h4>Descripción: Importante</h4>
<p>Recuerde que para obtener un anuncio correctamente "optimizado" es necesario que complete con textos orignales y únicos, con información relevante e interesante para que los visitantes se sientan atraidos hacia su establecimiento.
<br>Recuerde que en Internet, todos los usuarios buscan "Información", por lo tanto, cuanto más específico y claro es la que Ud. proporcione, más satisfechos estarán los visitantes de su anuncio.</p>
</div>

<div class='grid_1'>&nbsp;</div>
<div class='grid_8'>
<textarea name='descripcion' id='descripcion'   style='margin-left:20px;width:700px;height:300px;'><?php echo strip_tags($data['descripcion']);?></textarea>
</div>