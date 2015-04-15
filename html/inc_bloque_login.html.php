<script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/jquery.validate.js"></script>
<?php if(!empty($Idioma['errores_validacion'])): ?>
    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/localization/<?php echo $Idioma['errores_validacion'];?>"></script>
<?php endif; ?>

<link rel="stylesheet" href="<?php echo URL;?>/css/formulario_login.css" type="text/css" media="screen" />

<div id='bloque_login'>
	<h3>Zona Privada</h3>
	<form action='<?php echo URL;?>/login.php' method='post' id="formulario_login">

        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />

        <label><?php echo $Traducciones['login_username'];?><em>*</em></label>
        <input type='text' id="frm_username" name="data[username]" class="required" value=""/>

        <label><?php echo $Traducciones['login_password'];?><em>*</em></label>
        <input type='password' id="frm_password" name="data[password]" class="required" value=""/>

        <div id="result" ></div>
			<input type='text' name='data[captcha]' id='captcha' value='' />
            <input type='submit' id="submit" name='submit' 
                value='<?php echo $Traducciones['login_login'];?>' 
                title="<?php echo $Traducciones['login_login'];?>"/>

	</form>

	<a href="" title="<?php echo $Traducciones['forgot_password'];?>" class='aa'><?php echo $Traducciones['forgot_password'];?></a>
</div>

<script type="text/javascript">
    $(document).ready(function() { 
        jQuery("#formulario_login").validate();

    }); 
     
</script>
