<link rel="stylesheet" href="<?php echo URL;?>/css/comentarios.css" type="text/css" media="screen" />

<div id='comentarios'>
<h3 id='ancla_comentarios' ><?php echo $Traducciones['comentarios'];?></h3>

	<?php if ($cuantos_comentarios > 0 ){ ?>
		<?php $color='#FFF';?>
		<?php foreach($Comentarios as $clave => $coment){?>
			<?php if ($color=="#FFF") { $color = "#F8F8F8";} else {$color='#FFF';} ?>
			<div class='comment' style='background:<?php echo $color;?>'>
				<div class='coment_number'>#<?php echo ($clave+1);?></div>
				<div class='coment_user'><b>Usuario:</b> <?php echo $coment['username'];?></div>
				<div class='coment_fecha'><b>Fecha:</b> <?php echo $coment['fecha'];?> hs.</div>
				<div class='comentario'><?php echo $coment['comentario'];?></div>
			</div>
		<?php } // end foreach ?>


	<?php } else { // comentarios>0 ?>
		<h4>No hay comentarios, quieres ser el primero?</h4>

	<?php } // endif comentarios > 0 ?>


	<p>Para dejar un comentario, debes completar el siguiente formulario.</p>
    <form id="frm_comentarios" class="formulario">

        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />

        <label>Nombre<em>*</em></label>
        <input id="frm_nombre" name="data[nombre]" class="required" value="<?php echo $nombre;?>"/>

        <label>Apellido<em>*</em></label>
        <input id="frm_apellido" name="data[apellido]" class="required" value="<?php echo $apellido;?>"/>

        <label><?php echo $Traducciones['frm_email'];?><em>*</em></label>
        <input id="frm_email" name="data[email]" class="required email" value="<?php echo $email;?>"/>

        <label><?php echo $Traducciones['comentarios'];?><em>*</em></label>
        <textarea id="frm_mensaje" name="data[comentario]" class="required"><?php echo $mensaje;?></textarea>

        <div id="result_comentarios" ></div>
			<input type='text' name='data[captcha]' id='captcha' value='' />
			<input type='hidden' name='data[publicacion_id]' id='publicacion_id' value='<?php echo $Pub['id'];?>' />
            <input type='submit' id="submit" name='submit' 
                value='<?php echo $Traducciones['frm_enviar'];?>' 
                title="<?php echo $Traducciones['frm_enviar'];?>"/>

    </form>
    <small>Los comentarios se publicarán una vez autorizados por el supervisor del sitio web</small>
</div>	
<script type="text/javascript">
    $(document).ready(function() { 
        jQuery("#frm_comentarios").validate({
                submitHandler: function(form) {
                    $('#result_comentarios').html("<img src='<?php echo URL;?>/img/loading.gif' style='float:left;'> Enviando formulario....");
                    var variables =  $("#frm_comentarios").serialize();
                    $.ajax({
                        type:"GET", //tipo de formato de envio de información
                        url: "<?php echo URL;?>/ajax/dejar_comentario.php?var="+variables,
                        success:function(respuesta){
                            $('#result_comentarios').html(respuesta);
                        }
                    });

                }
        });

    }); 
     
</script>


<?php //pr($Comentarios);?>

</div> <!-- id comentarios -->