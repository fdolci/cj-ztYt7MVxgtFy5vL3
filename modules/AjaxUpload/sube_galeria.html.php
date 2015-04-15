<h3>El tamaño de las imágenes se ajustará a <?php echo $ajaxupload['ancho'];?>px de ancho por <?php echo $ajaxupload['alto'];?>px de alto</h3>


<div id="content_gallery">
    <a href="javascript:;" id="upload">Subir Foto</a>
    <ul id="gallery">
            <!-- Cargar Fotos -->
    </ul>
</div>



<script type="text/javascript">
    $(document).ready(function(){
 
        var button = $('#upload'), interval;
        new AjaxUpload(button,{
            action: '<?php echo URL;?>/modules/AjaxUpload/ajax/subir_imagenes_galeria.php?datos_ajaxupload=<?php echo $datos_ajaxupload;?>',
            name: 'image',
            onSubmit : function(file, ext){
                // cambiar el texto del boton cuando se selecicione la imagen
                button.text('Subiendo');
                // desabilitar el boton
                this.disable();
 
                interval = window.setInterval(function(){
                    var text = button.text();
                    if (text.length < 11){
                        button.text(text + '.');
                    } else {
                        button.text('Subiendo');
                    }
                }, 200);
            },
            onComplete: function(file, response){
                button.text('Subir Foto');
 
                window.clearInterval(interval);
 
                // Habilitar boton otra vez
                this.enable();
 
                // Añadiendo las imagenes a mi lista
 
                if($('#gallery li').length == 0){
                    $('#gallery').html(response).fadeIn("fast");
                    $('#gallery li').eq(0).hide().show("slow");
                }else{
                    $('#gallery').prepend(response);
                    $('#gallery li').eq(0).hide().show("slow");
                }
            }
        });
 
        // Listar  fotos que hay en mi tabla
        $("#gallery").load("<?php echo URL;?>/modules/AjaxUpload/ajax/subir_imagenes_galeria.php?action=listFotos&datos_ajaxupload=<?php echo $datos_ajaxupload;?>");        

        // Eliminar
/*        
        $("#gallery li a").live("click",function(){
            var a = $(this)
            $.get("<?php echo URL;?>/modules/AjaxUpload/ajax/subir_imagenes_galeria.php?&datos_ajaxupload=<?php echo $datos_ajaxupload;?>&action=eliminar",{id:a.attr("id")},function(){
                a.parent().fadeOut("fast")
            })

        })
*/

    });

    function eliminar_gal(id){
        $.get("<?php echo URL;?>/modules/AjaxUpload/ajax/subir_una_imagen.php?&datos_ajaxupload=<?php echo $datos_ajaxupload;?>&action=eliminar",{id:id},function(){
            $("#img_"+id).fadeOut("fast")
            $("#upload").fadeIn("slow");
            $("#upload").show();
        })

    }

 
</script>