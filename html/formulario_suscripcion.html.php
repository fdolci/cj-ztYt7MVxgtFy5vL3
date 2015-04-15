<script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/jquery.validate.js"></script>
<?php if(!empty($Idioma['errores_validacion'])): ?>
    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/localization/<?php echo $Idioma['errores_validacion'];?>"></script>
<?php endif; ?>
<link rel="stylesheet" href="<?php echo URL;?>/css/formulario_suscripcion.css" type="text/css" media="screen" />

<div id='ajax_formulario_suscripcion'>
<h3><?php echo $Traducciones['suscripcion_titulo'];?></h3>
    <form id="frm_suscripcion" class="formulario">

        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />

        <label><?php echo $Traducciones['frm_email'];?><em>*</em></label>
        <input id="frm_email" name="data[email]" class="required email" value="<?php echo $email;?>"/>
        <div id="result_suscripcion" ></div>
			<input type='text' name='data[captcha]' id='captcha' value='' />
            <input type='submit' id="submit" name='submit' 
                value='<?php echo $Traducciones['suscripcion_boton'];?>' 
                title="<?php echo $Traducciones['suscripcion_boton'];?>"/>
		
    </form>
</div>	
<script type="text/javascript">
    $(document).ready(function() { 
        jQuery("#frm_suscripcion").validate({
                submitHandler: function(form) {
                    $('#result_suscripcion').html("<img src='<?php echo URL;?>/img/loading.gif' style='float:left;'> Enviando formulario....");
                    var variables =  $("#frm_suscripcion").serialize();
                    $.ajax({
                        type:"GET", //tipo de formato de envio de información
                        url: "<?php echo URL;?>/ajax/enviar_formulario_suscripcion.php?var="+variables,
                        success:function(respuesta){
                            $('#result_suscripcion').html(respuesta);
                        }
                    });

                }
        });

    }); 
     
</script>
