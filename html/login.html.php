<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />

    <div class="grid_8" >           
        <!-- Login Form -->


        <form id="frm_login" class="formulario" method='post' action='<?php echo URL;?>/login.php'>
            <h2 >Ingreso para las Entidades / Organizaciones</h2>
            <table  style='width:350px;margin:10px auto;'>
                <tr>
                    <td style='text-align:right;padding:3px;'>Correo Electrónico:<em>*</em>
                        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />
                    </td>   
                    <td>
                        <input id="frm_email" type='text'  name="data[email]" class="required email" value="" style='width:200px;padding:3px;'/>
                    </td>
                </tr>
                <tr>
                    <td style='text-align:right;padding:3px;'>Contraseña<em>*</em>
                    </td>   
                    <td>
                        <input type='password' id="frm_password" name="data[password]" class="required" value=""  style='width:200px;padding:3px;'/>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <input type='text' name='data[captcha]' id='captcha' value='' />
                        <input type='submit' id="submit" name='submit' value='Ingresar' title="<?php echo $Traducciones['frm_enviar'];?>"/>
                    </td>
                </tr>
            </table>
        </form>
        
    </div>


    <div class="grid_8" >           
            <!-- Login Form -->
        <form id="frm_recordar_passw" class="formulario" method='post' action='<?php echo URL;?>/recordar_password.php' style='margin-top:30px;'>
                <h2>Olvidó su contraseña?</h2>
                <p style='text-align:center;'>Por favor, ingrese la dirección de correo electrónico de la Entidad / Organización a la que pertenece, 
                    y le enviaremos un instructivo para que puedas reestablecerla.</p>

                <table  style='width:350px;margin:10px auto;'>
                    <tr>
                        <td style='text-align:right;padding:3px;'>Correo Electrónico:<em>*</em>
                            <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />
                        </td>   
                        <td>
                            <input id="frm_email" name="data[email]" type='text' class="required email" value="" style='width:200px;padding:3px;'/>
                            <input type='text' name='data[captcha]' id='captcha' value='' />
                            <input type='hidden' name='accion' id='accion' value='recordar_password' />
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input type='submit' id="submit" name='submit' value='Recordar Contraseña' title="Recordar Contraseña"/>
                        </td>
                    </tr>
                </table>
        </form>

    </div>


    <div class="grid_8" >           
        <!-- Login Form -->

        <form id="frm_reenviar_passw" class="formulario" method='post' action='<?php echo URL;?>/reenvio_mail_activacion.php' style='margin-top:30px;'>
            <h2 >Reenviar el mail de activación de la cuenta</h2>
            <p style='text-align:center;'>
                Si no ha recibido el mail de activación, ingrese la dirección de correo electrónico<br> que utilizó al momento de registrarse y se la enviaremos nuevamente.<br>
                Revise que el mail no haya quedado en la bandeja de spam o correo basura de su servidor de correo.<br>
                El mail de activación se envía desde la siguiente cuenta: <?php echo $DatosEmpresa['email'];?>.
            </p>            
            <table  style='width:350px;margin:10px auto;'>
                <tr>
                    <td style='text-align:right;padding:3px;'>Correo Electrónico:<em>*</em>
                        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />
                    </td>   
                    <td>
                        <input id="frm_email" name="data[email]" type='text' class="required email" value="" style='width:200px;padding:3px;'/>
                        <input type='text' name='data[captcha]' id='captcha' value='' />
                        <input type='hidden' name='accion' id='accion' value='reenvio_mail_activacion' />
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <input type='submit' id="submit" name='submit' value='Reenviar mail de activación de Cuenta' title="Reenviar mail de activación de Cuenta"/>
                    </td>
                </tr>
            </table>
        </form>

    </div>

<script type="text/javascript">
    $(document).ready(function() { 
        jQuery("#frm_login").validate();
        jQuery("#frm_recordar_passw").validate();
        jQuery("#frm_reenviar_passw").validate();

    }); 
     
</script>


</div>
<div class='clear'></div>