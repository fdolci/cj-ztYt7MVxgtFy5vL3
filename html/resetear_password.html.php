<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />

<?php if ($Mensaje['termina']!='si' and !$login) {  ?>

	<?php echo $ResultadoEnvio;?>

        
    

    <form action='<?php echo URL;?>/resetear_password.php?id=<?php echo $id;?>' method='post' name='frm_contacto' id='frm_contacto' class='formulario'>
		<h2 >Por favor, ingrese su nueva clave de acceso.</h2>
		
		<div class='grid_2 titulos_form' style='text-align:right;'>Clave:</div>
		<div class='grid_3'>
                <input type='text' name='data[nuevaclave]' value='' id='nuevaclave' class='required' size='20' />
        </div>
        <div class='clear'></div>
        
		<div class='grid_2 titulos_form' style='text-align:right;'>Reingrese Clave:</div>
        <div class='grid_4'><input type='password' name='data[re_clave]' value='' size='20' id='re_clave' class='required'  /></div>
        <div class='clear'></div>
            
        <div class='grid_2'>&nbsp;</div>
            <div class='grid_4'>
                <input type='hidden' name='accion' value='modificar_passw' />
                <input type='text' name='captcha' class='captcha' value='' style='display:none;'/>
                <input type='submit' name='submit' value='Cambiar Contraseña' />
        </div>
        <div class='clear'></div>
    </form>    
    <script>
        $(document).ready(function(){
            $("#frm_contacto").validate({
                rules: {
                       "data[nuevaclave]" : { required: true, minlength: 4 },
                       "data[re_clave]": { equalTo: "#nuevaclave" }
                    } 
            });
        });
    </script>

<?php } ?>

</div>
