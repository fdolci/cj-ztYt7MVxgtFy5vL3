<div id="content_gallery3">
    <table>
        <tr>
            <td><a href="javascript:;" id="upload3">Subir Foto</a></td>
            <td>
                <ul id="gallery3">
                        <!-- Cargar Fotos -->
                </ul>
            </td>
        </tr>
    </table>
</div>

<?php 
/*
    $ajaxupload['tabla'] = 'publicaciones_imagenes';
    $ajaxupload['campo'] = 'publicacion_id';
    $ajaxupload['id']    = $Pub['id'];
    $ajaxupload['cual']  = 'miniatura';
    $ajaxupload['identificador']  = $identificador;
    $ajaxupload['donde_subir']    = PUB_SUBIR_FOTOS;
    $ajaxupload['donde_ver']      = PUB_VER_FOTOS;
*/
    $rs = $db->SelectLimit("select * from {$ajaxupload['tabla']} where {$ajaxupload['campo']}='{$ajaxupload['id']}' and cual='{$ajaxupload['cual']}' and {$ajaxupload['campo']}>0 ",1) ;
    $Foto = $rs->FetchRow();

    if ($Foto){ $oculta_boton_subir = true; } else { $oculta_boton_subir = false; }

?>

<script type="text/javascript">
    $(document).ready(function(){
 
 
        var button = $('#upload3'), interval;
        new AjaxUpload(button,{
            action: '<?php echo URL;?>/modules/AjaxUpload/ajax/subir_un_afiche.php?datos_ajaxupload=<?php echo $datos_ajaxupload;?>',
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
                $("#upload3").hide();
 
                // Añadiendo las imagenes a mi lista
 
                if($('#gallery3 li').length == 0){
                    $('#gallery3').html(response).fadeIn("fast");
                    $('#gallery3 li').eq(0).hide().show("slow");
                }else{
                    $('#gallery3').prepend(response);
                    $('#gallery3 li').eq(0).hide().show("slow");
                }

            }
        });
 
        // Listar  fotos que hay en mi tabla
        $("#gallery3").load("<?php echo URL;?>/modules/AjaxUpload/ajax/subir_un_afiche.php?action=listFotos&datos_ajaxupload=<?php echo $datos_ajaxupload;?>");        


        // Eliminar
/*        
        $("#gallery2 li a").live("click",function(){
            var a = $(this)
            
            $.get("<?php echo URL;?>/modules/AjaxUpload/ajax/subir_una_imagen.php?&datos_ajaxupload=<?php echo $datos_ajaxupload;?>&action=eliminar",{id:a.attr("id")},function(){
                a.parent().fadeOut("fast")
                $("#upload2").fadeIn("slow");
            })
            
        })
*/
        <?php if($oculta_boton_subir==true){ ?>
            $("#upload3").hide();
        <?php } ?>

    });
    function eliminar_afiche(id){
           
        $.get("<?php echo URL;?>/modules/AjaxUpload/ajax/subir_un_afiche.php?&datos_ajaxupload=<?php echo $datos_ajaxupload;?>&action=eliminar",{id:id},function(){
            $("#img_"+id).fadeOut("fast")
            $("#upload3").fadeIn("slow");
            $("#upload3").show();
        })

    }
 
</script>

