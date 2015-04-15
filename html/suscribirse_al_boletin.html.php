<html lang="<?php echo $MetaTags['language'];?>" xml:lang="<?php echo $MetaTags['language'];?>">
<head>
<?php include('_javascript.html.php'); ?>

<?php include('_css.html.php'); ?>

</head>

<body style='min-width:700px;'>
<script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/jquery.validate.js"></script>
<?php if(!empty($Idioma['errores_validacion'])): ?>
    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/localization/<?php echo $Idioma['errores_validacion'];?>"></script>
<?php endif; ?>
<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />

<img src='<?php echo URL;?>/img/logo.png'>

    <div style='border:1px solid #CCC; padding:10px; border-radius:4px;margin:10px auto;width:600px;'>
        <!-- Login Form -->
        <h1 style='text-align:center;width:100%;overflow:visible;'>Suscripción al Boletín</h1>
        <p style='text-align:center;'>Si desea estar informado de las últimas novedades, por favor completa el siguiente formulario de suscripción al boletín de noticias.</p>
        <form id="frm_suscripcion" class="formulario" method='post' action='<?php echo URL;?>/suscribirse_al_boletin.php'>
            <table  style='width:350px;margin:10px auto;'>
                <tr>
                    <td style='text-align:right;padding:3px;'>Apellido:<em>*</em>
                    </td>   
                    <td>
                        <input id="frm_apellido" name="data[apellido]" class="required" value="" style='width:250px;padding:3px;'/>
                    </td>
                </tr>

                <tr>
                    <td style='text-align:right;padding:3px;'>Nombre:<em>*</em>
                    </td>   
                    <td>
                        <input id="frm_nombre" name="data[nombre]" class="required" value="" style='width:250px;padding:3px;'/>
                    </td>
                </tr>
                <tr>
                    <td style='text-align:right;padding:3px;'>Email:<em>*</em>
                    </td>   
                    <td>
                        <input id="frm_email" name="data[email]" class="required email" value="" style='width:250px;padding:3px;'/>
                    </td>
                </tr>

                <tr>
                    <td colspan='2'>
                        <input type='submit' id="submit" name='submit' value='Suscribirme al Boletín' title="Suscribirme al Boletín"/>
                    </td>
                </tr>
            </table>
            <?php if(!empty($msg)){?>
                <div style='width:500px;margin-left:50px;border:2px solid #CCC; padding:5px;font-size:12px;text-align:center;'><?php echo $msg;?></div>
            <?php } ?>
        </form>
    </div>

<script>
$(document).ready(function(){
    $("#frm_suscripcion").validate();
});
</script>
</body>
</html>