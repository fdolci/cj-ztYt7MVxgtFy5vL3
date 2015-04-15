<?php if (!empty($Mensaje["mensaje"])) { ?>
    <br><br><h1 style='text-align:center;'><?php echo $Mensaje["mensaje"];?></h1>
    <?php if ($Mensaje['termina']=='si') { die();}?>
<?php } ?>
<?php if (!$login) { ?>

    <script type="text/javascript" src="<?php echo URL;?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.9.0/jquery.validate.js"></script>
    <?php if(!empty($Idioma['errores_validacion'])): ?>
        <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.9.0/localization/<?php echo $Idioma['errores_validacion'];?>"></script>
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />


    <script>
        $(document).ready(function(){
            $("#frm_account").validate();
            $("#frm_change_password").validate({
                  rules: {
                    "frm_password" : { required: true, minlength: 4 },
                    "frm_repeat_passw": { equalTo: "#frm_password" }
                  }        
            });
            
        });
    </script>

    <?php echo $ResultadoEnvio;?>

    <br>
    <h1><?php echo $Pub['titulo'];?></h1>
    <hr/>
    <?php echo $Pub['copete'];?>
      
        
    <form id="frm_account" method="post" action="<?php echo URL;?>/forgot_password.php" style="border:1px solid #dcdcdc;padding:20px;border-radius:6px;background:#EEEEEE;">
        <table width='100%'>
            <tr>
                <td style='padding:5px;text-align:right;'><?php echo $Traducciones['frm_email'];?></td>
                <td style='padding:5px;'><input type="text" name="data[email]" id="email" class="required email"  value='' style='width:300px;'/></td>
            </tr>
            <tr>
                <td colspan='2' style='padding:5px;text-align:center;'>
                    <input type="submit" name="submit" value="<?php echo $Traducciones['frm_enviar'];?>" style="cursor:pointer;padding:5px;"/>
                </td>
            </tr>
        </table>
    </form>
<?php } ?>