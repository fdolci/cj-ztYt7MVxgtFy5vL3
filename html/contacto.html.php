<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />
 
    <?php if(!empty($Pub['contenido'])){ echo '<p>'.stripslashes($Pub['contenido'])."</p>";} ?>
	
	<style>
		.ctitulo {
			line-height: 15px; 
			width:150px;
			display:inline-block;
		}
	</style>
	
    <form id="frm_contacto" class='formulario'>
        <h2 ><?php echo stripslashes($Pub['titulo']); ?></h2>

        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />

        <label class='ctitulo' ><?php echo $Traducciones['frm_apellido'];?><em>*</em></label>
        <input id="frm_apellido" name="data[apellido]" class="required" type='text' value="<?php echo $apellido;?>"/>
		<div class='clear'></div>
        <label class='ctitulo' ><?php echo $Traducciones['frm_nombre'];?><em>*</em></label>
        <input id="frm_nombre" name="data[nombre]" class="required" type='text' value="<?php echo $nombre;?>"/>
		<div class='clear'></div>
        
		<label class='ctitulo' ><?php echo $Traducciones['frm_email'];?><em>*</em></label>
        <input id="frm_email" name="data[email]" class="required email" type='text' value="<?php echo $email;?>"/>
		<div class='clear'></div>
		
        <label class='ctitulo' ><?php echo $Traducciones['frm_telefono'];?>&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input id="frm_telefono" name="data[telefono]" class="" type='text' value="<?php echo $telefono;?>" style='margin-top:5px;'/>
		<div class='clear'></div>


        <label class='ctitulo' style='line-height: 15px;'><?php echo $Traducciones['frm_mensaje'];?><em>*</em></label>
        <textarea id="frm_mensaje" name="data[comentario]" class="required" style='width:400px; height:100px;'><?php echo $mensaje;?></textarea>

        <div id="result_contacto" ></div>
        <em style='margin-left:150px;'>*</em> Datos Obligatorios<br>
			<input type='text' name='data[captcha]' id='captcha' value='' />
            <input type='submit' id="submit" name='submit' style='width:200px;margin-left:245px;'
                value='<?php echo $Traducciones['frm_enviar'];?>' 
                title="<?php echo $Traducciones['frm_enviar'];?>"/>

		
    </form>
	
	
<?php /*
    <h1 style="margin-top:10px;margin-left:20px;">Nuestra Ubicación</h1>
	<?php echo $Google['mapa_google'];?>
*/?>
    <?php if(!empty($Pub['copete'])){ echo '<p>'.stripslashes($Pub['copete']).'</p>';} ?>



<script type="text/javascript">
    $(document).ready(function() { 
        jQuery("#frm_contacto").validate({
                submitHandler: function(form) {
                    $('#result_contacto').html("<img src='<?php echo URL;?>/img/loading.gif' style='float:left;'> Enviando formulario....");
                    var variables =  $("#frm_contacto").serialize();
                    $.ajax({
                        type:"GET", //tipo de formato de envio de información
                        url: "ajax/enviar_formulario_contacto.php?var="+variables,
                        success:function(respuesta){
                            $('#result_contacto').html(respuesta);
                        }
                    });

                }
        });

    }); 
     
</script>

</div>
<div class='clear'></div>
<?php //pr($DatosEmpresa);?>