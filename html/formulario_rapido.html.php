<script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/jquery.validate.js"></script>
<?php if(!empty($Idioma['errores_validacion'])): ?>
    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/localization/<?php echo $Idioma['errores_validacion'];?>"></script>
<?php endif; ?>
<link rel="stylesheet" href="<?php echo URL;?>/css/formulario_rapido.css" type="text/css" media="screen" />

<div id='ajax_formulario_rapido'>
<h3 style='margin-top:30px;'><?php echo $Traducciones['consulta_rapida_titulo'];?></h3>
    <form id="frm_contacto" class="formulario">

        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />

        <label><?php echo $Traducciones['frm_apellido'];?> y <?php echo $Traducciones['frm_nombre'];?><em>*</em></label>
        <input id="frm_apellido" name="data[apellido]" class="required" value="<?php echo $apellido;?>"/>

        <label><?php echo $Traducciones['frm_email'];?><em>*</em></label>
        <input id="frm_email" name="data[email]" class="required email" value="<?php echo $email;?>"/>

        <label><?php echo $Traducciones['frm_mensaje'];?><em>*</em></label>
        <textarea id="frm_mensaje" name="data[comentario]" class="required"><?php echo $mensaje;?></textarea>

        <div id="result" ></div>
			<input type='text' name='data[captcha]' id='captcha' value='' />
            <input type='submit' id="submit" name='submit' 
                value='<?php echo $Traducciones['frm_enviar'];?>' 
                title="<?php echo $Traducciones['frm_enviar'];?>"/>

		
    </form>
</div>	
<script type="text/javascript">
    $(document).ready(function() { 
        jQuery("#frm_contacto").validate({
                submitHandler: function(form) {
                    $('#result').html("<img src='<?php echo URL;?>/img/loading.gif' style='float:left;'> Enviando formulario....");
                    var variables =  $("#frm_contacto").serialize();
                    $.ajax({
                        type:"GET", //tipo de formato de envio de información
                        url: "<?php echo URL;?>/ajax/enviar_formulario_rapido.php?var="+variables,
                        success:function(respuesta){
                            $('#result').html(respuesta);
                        }
                    });

                }
        });

    }); 
     
</script>
