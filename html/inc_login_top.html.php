<?php if (!$login) {?>
	<script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/jquery.validate.js"></script>
	<?php if(!empty($Idioma['errores_validacion'])): ?>
	    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/localization/<?php echo $Idioma['errores_validacion'];?>"></script>
	<?php endif; ?>

	<link rel="stylesheet" href="<?php echo URL;?>/css/formulario_rapido.css" type="text/css" media="screen" />

<?php } ?>

	<!-- Sliding effect -->
  	<link rel="stylesheet" href="<?php echo URL;?>/js/slide_login/css/style.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="<?php echo URL;?>/js/slide_login/css/slide.css" type="text/css" media="screen" />	
	<script src="<?php echo URL;?>/js/slide_login/js/slide.js" type="text/javascript"></script>
	
<!-- Panel -->
<div id="toppanel">
<?php if (!$login) {?>
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1 style='text-align:center;width:100%;overflow:visible;'>¿Desea Recibir las Ofertas y Promociones?</h1>
				
				<div id='ajax_formulario_rapido'>
				    <form id="frm_suscripcion" class="formulario">

				        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />

				        <label><?php echo $Traducciones['frm_apellido'];?> y <?php echo $Traducciones['frm_nombre'];?><em>*</em></label>
				        <input id="frm_apellido" name="data[apellido]" class="required" value="<?php echo $apellido;?>"/>

				        <label><?php echo $Traducciones['frm_email'];?><em>*</em></label>
				        <input id="frm_email" name="data[email]" class="required email" value="<?php echo $email;?>"/>

				        <div id="result" ></div>
							<input type='text' name='data[captcha]' id='captcha' value='' />
				            <input type='submit' id="submit" name='submit' 
				                value='Suscribirse al Boletín' 
				                title="<?php echo $Traducciones['frm_enviar'];?>"/>

						
				    </form>
				</div>	


			</div>
			<div class="left" style='text-align:center;'>
				<h1 style='text-align:center;width:100%;overflow:visible;'>¿Aún no es Anunciante?</h1>
				<a href='<?php echo URL;?>/registro.php'> Regístrese Gratis!!!</a>
				<br><br><br>
				<h1 style='text-align:center;padding:0px;width:100%;overflow:visible;'>¿Olvidó su contraseña?</h1>
				<div id='ajax_formulario_rapido'>				
				    <form id="frm_recordar_passw" class="formulario" method='post' action='<?php echo URL;?>/recordar_password.php'>
				        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />
				        <label><?php echo $Traducciones['frm_email'];?><em>*</em></label>
				        <input id="frm_email" name="data[email]" class="required email" value=""/>
						<input type='text' name='data[captcha]' id='captcha' value='' />
						<input type='hidden' name='accion' id='accion' value='recordar_password' />

			            <input type='submit' id="submit" name='submit' value='Recordar Contraseña' 
			                title="Recordar Contraseña"/>
				    </form>
				</div>    
			</div>
			<div class="left right">			
				<!-- Login Form -->
				<h1 style='text-align:center;width:100%;overflow:visible;'>Ingreso para Anunciantes</h1>

				<div id='ajax_formulario_rapido'>
				    <form id="frm_login" class="formulario">

				        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />

				        <label><?php echo $Traducciones['frm_email'];?><em>*</em></label>
				        <input id="frm_email" name="data[email]" class="required email" value=""/>

				        <label>Contraseña<em>*</em></label>
				        <input type='password' id="frm_password" name="data[password]" class="required" value=""/>

				        <div id="result1" ></div>
							<input type='text' name='data[captcha]' id='captcha' value='' />
				            <input type='submit' id="submit" name='submit' 
				                value='Ingresar' 
				                title="<?php echo $Traducciones['frm_enviar'];?>"/>

						
				    </form>
				</div>	

			</div>
		</div>
	</div> <!-- /login -->	

	<script type="text/javascript">
					    $(document).ready(function() { 
					        jQuery("#frm_login").validate({
					                submitHandler: function(form) {
					                    $('#result1').html("<img src='<?php echo URL;?>/img/loading.gif' style='float:left;'> Enviando formulario....");
					                    var variables =  $("#frm_login").serialize();
					                    $.ajax({
					                        type:"GET", //tipo de formato de envio de información
					                        url: "<?php echo URL;?>/ajax/login.php?var="+variables,
					                        success:function(respuesta){
					                            $('#result1').html(respuesta);
					                        }
					                    });

					                }
					        });

					        jQuery("#frm_suscripcion").validate({
					                submitHandler: function(form) {
					                    $('#result').html("<img src='<?php echo URL;?>/img/loading.gif' style='float:left;'> Enviando formulario....");
					                    var variables =  $("#frm_suscripcion").serialize();
					                    $.ajax({
					                        type:"GET", //tipo de formato de envio de información
					                        url: "<?php echo URL;?>/ajax/suscripcion_boletin.php?var="+variables,
					                        success:function(respuesta){
					                            $('#result').html(respuesta);
					                        }
					                    });

					                }
					        });

							jQuery("#frm_recordar_passw").validate();

					    }); 
					     
	</script>

<?php } ?>

	<!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
			<li class="left">&nbsp;</li>

			<?php /* if (!$login) {?>
				<li>Hola Invitado!!</li>
			<?php } else { ?>
				<li>Hola <?php echo $Usuario['titulo'];?></li>
			<?php } */?>


			<?php if (!$login) {?>
				<li id="toggle" style='width:330px;'>
					<a id="open" class="open" href="#">Suscribirse al Boletín&nbsp;&nbsp;-&nbsp;&nbsp;Ingreso de Anunciantes</a>
					<a id="close" style="display: none;" class="close" href="#">Cerrar Panel</a>			
				</li>
			<?php } else { ?>
				<li id="toggle">
					<table width='300'>
						<tr>
							<td style='width:150px;tex-align:left;'>
								<a id="close" class="close" href="logout.php" style='width:150px;'>Cerrar Sesión</a>
							</td>
							<td style='width:150px;tex-align:left;'>
								<a  href="<?php echo URL;?>/account/listar_anuncios.php" style='line-height:42px;'>Acceder a Mi Cuenta</a>			
							</td>
						</tr>
					</table>
				
				</li>
			<?php } ?>
			
			<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--panel -->
