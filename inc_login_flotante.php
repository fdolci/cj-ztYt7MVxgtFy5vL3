<?php
    $muestra = ''; 
    if( isset($_SESSION['login']) and  $_SESSION['login']['id'] > 0 ) { 
        $muestra = 'salir';
    } else {
        $muestra = 'login';
    }

    if ($pagina_login){  $muestra = ''; }
    
?>

<?php if ($muestra == 'login'){ ?>
    <!-- Login Starts Here -->
    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.9.0/jquery.validate.js"></script>
    <?php if(!empty($Idioma['errores_validacion'])): ?>
        <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.9.0/localization/<?php echo $Idioma['errores_validacion'];?>"></script>
    <?php endif; ?>
                                    
    <script>
        $(document).ready(function(){
            $("#loginForm").validate();
        });
    </script>
            
    <div id="loginContainer">
        <a href="#" id="loginButton"><span><?php echo $Traducciones['login'];?></span></a>
        <div style="clear:both"></div>
        
        <div id="loginBox">                
            <form id="loginForm" method="post" action="<?php echo URL;?>/login.php">
                <fieldset id="body">
                    <fieldset>
                        <label for="email"><?php echo $Traducciones['login_email'];?></label>
                        <input type="text" name="email" id="email" class="required email"/>
                    </fieldset>
                    <fieldset>
                        <label for="password"><?php echo $Traducciones['login_password'];?></label>
                        <input type="password" name="password" id="password" class="required"/>
                    </fieldset>
                                
                    <input type="submit" id="login" value="<?php echo $Traducciones['login_login'];?>" />
            
                </fieldset>
                            
                <span><a href="<?php echo URL;?>/forgot_password.php"><?php echo $Traducciones['forgot_password'];?></a></span>
                <span><a href="<?php echo URL;?>/registro.php"><?php echo $Traducciones['register'];?></a></span>
            </form>
        </div>
    </div>
    <!-- Login Ends Here -->

<?php } elseif ( $muestra == 'salir' ) { ?>
    
    <div id="loginContainer">
        <a href="#" id="loginButton"><span><?php echo $Traducciones['perfil'];?></span></a>
        <div style="clear:both"></div>
        <div id="loginBox">                
            <form id="loginForm" method="post" action=""   style="width:84px;">
                <span><a href="<?php echo URL;?>/mi_cuenta.php"><?php echo $Traducciones['mi_cuenta'];?></a></span>
                <span><a href="<?php echo URL;?>/logout.php"><?php echo $Traducciones['logout'];?></a></span>
            </form>
        </div>
    </div>
    
<?php } ?>