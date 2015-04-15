<table width='100%'>
    <tr>
        <td style='width:390px;'>
            <div style='width:390px;background:#F4F4F4; border-top:1px solid #DDD; border-bottom:1px solid #DDD;padding:5px;margin-top:5px;margin-bottom:10px;'>
                Para contactarse con los organizadores, por favor complete el siguiente formulario.
            </div>
<?php /*
            <style>
                label {font-weight:bold;font-size:11px;width:90px;display: inline-block;text-align:left;}
            </style>
*/ ?>
            <form id="frm_contacto" class="formulario" style='border:0px;'>
                <div style='margin-bottom:5px;'>
					<label class='ctitulo' style='width:100px;display:inline-block;padding-right:10px;'>Apellido:</label>
                    <input type="text" id="frm_apellido" name="apellido" value="" class='required' style='width:270px;display:inline-block;'/>
                </div>

                <div style='margin-bottom:5px;'>
					<label class='ctitulo' style='width:100px;display:inline-block;padding-right:10px;'>Nombre:</label>
					<input type="text" id="frm_nombre" name="nombre" value="" class='required' style='width:270px;'/>
                </div>
                
				<div style='margin-bottom:5px;'>
					<label class='ctitulo' style='width:100px;display:inline-block;padding-right:10px;'>Email:</label>
                    <input type="text" id="frm_email" name="email" value="" class='required email' style='width:270px;'/>
                </div>    
                
				<div style='margin-bottom:5px;'>
					<label class='ctitulo' style='width:100px;display:inline-block;padding-right:10px;'>Teléfono:</label>
                    <input type="text" id="frm_telefono" name="telefono" value="" class='required' style='width:270px;'/>
                </div>    
                
				<div style='margin-bottom:5px;'>
					<label class='ctitulo' style='width:100px;display:inline-block;padding-right:10px;'>Ciudad:</label>
                    <input type="text" id="frm_ciudad" name="ciudad" value="" class='required' style='width:270px;'/>
                </div>    
                
				<div style='margin-bottom:5px;'>
					<label class='ctitulo' style='width:100px;display:inline-block;padding-right:10px;'>Provincia:</label>
                    <input type="text" id="frm_provincia" name="provincia" value="" class='required' style='width:270px;'/>
                </div>    

                <div style='margin-bottom:5px;'>
					<label class='ctitulo' style='width:230px;text-align:left;margin-top:0px;'>Consulta / Comentario:</label>
                    <textarea id="frm_mensaje" name="comentario" style="width:385px;height:100px;margin:0px;" class='required'></textarea>        
                </div>

                <div id="resultado_form" style='width:220px;height:50px;display:none;clear:both;'></div>

                (*) Todos los datos son obligatorios.
                <input type="hidden" value="<?php echo $Producto['id'];?>" name='producto_id' id='producto_id'/>    
                <input type="submit" value="Enviar" style="cursor:pointer;width:185px;"/>
                    
            </form>
        </td>
        <td style='padding-left:20px;'>
            <table style='border-bottom:1px solid #CCC;'>
                <tr>
                    <td style='width:30px;'><img src='<?php echo URL;?>/img/icono_asociacion.jpg'>&nbsp;</td>
                    <td><?php echo $Usuario['sigla'];?> - <?php echo $Usuario['nombre_entidad'];?></td>
                </tr>
                
                <?php if (!empty($Usuario['web'])) { ?>
                    <tr>
                        <td><img src='<?php echo URL;?>/img/icono_asociacion_web.jpg'>&nbsp;</td>
                        <td>
                            <a href='<?php echo $Usuario['web'];?>' target='_blank' title='Acceder a la Web del Organizador'>
                                        <?php echo $Usuario['web'];?></a>
                        </td>
                    </tr>
                <?php } ?>                          
                
                <tr>
                    <td style='width:30px;'><img src='<?php echo URL;?>/img/icono_asociacion_direccion.jpg'>&nbsp;</td>
                    <td><?php echo $Usuario['direccion'];?></td>
                </tr>
                <tr>
                    <td><img src='<?php echo URL;?>/img/icono_asociacion_telefono.jpg'>&nbsp;</td>
                    <td><?php echo $Usuario['telefono'].' - '.$Producto['fax'];?> </td>
                </tr>
            </table>

			<br>
            <table style='width:100%;'>
                <tr>
                    <td style='border-bottom:1px solid #CCC;padding-bottom:10px;'>Teléfono de Consultas:<b style='float:right;'><?php echo $Producto['telefono'];?></b></td>
                </tr>
                <?php if (!empty($Producto['fax'])){ ?>
                <tr>
                    <td style='border-bottom:1px solid #CCC;padding-bottom:10px;'>Fax para Consultas:<b style='float:right;'><?php echo $Producto['fax'];?></b></td>
                </tr>
                <?php } ?>
                <?php if (!empty($Producto['email_informes'])){ ?>
                <tr>
                    <td style='border-bottom:1px solid #CCC;padding-bottom:10px;'>Email para Consultas:<b style='float:right;'><?php echo $Producto['email_informes'];?></b></td>
                </tr>
                <?php } ?>

                <?php if (!empty($Producto['email_inscripcion'])){ ?>
                <tr>
                    <td style='border-bottom:1px solid #CCC;'>Email para Inscripción:<b style='float:right;'><?php echo $Producto['email_inscripcion'];?></b></td>
                </tr>
                <?php } ?>

            </table>


        </td>
    </tr>
</table>



<script type="text/javascript">
    $(document).ready(function() { 
        $("#frm_contacto").validate({
                submitHandler: function(form) {
                    $('#resultado_form').html("<img src='<?php echo URL;?>/img/loading.gif' style='float:left;'> Enviando formulario....");
                    $('#resultado_form').show();
                    var variables =  $("#frm_contacto").serialize();
                    
                    $.ajax({
                        type:"GET", //tipo de formato de envio de información
                        url: "<?php echo URL;?>/ajax/enviar_formulario_contacto_anunciante.php?"+variables,
                        success:function(respuesta){
                            $('#resultado_form').html(respuesta);
                        }
                    });

                }
        });

    }); 
     
</script>

