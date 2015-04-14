<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>

<?php /*
<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo URL;?>/css/tooltip.css" type="text/css" media="screen" />
*/ ?>

<style>
    label { float: left; }
    label.error { float: none; color: red; padding-left:0px; vertical-align: top; display: block;font-size:12px;}
    p { clear: both; }
    em { font-weight: bold; padding-right: 1em; vertical-align: top; color:red;}

    .ctitulo {
        text-align:right;
        font-weight:bold;
        line-height:30px;
        font-size:12px;
    }
</style>

<script type="text/javascript">
    function comprueba_email(){
        var email = $("#email").val();
        $.ajax({
                type:"GET", //tipo de formato de envio de información
                url: "<?php echo URL;?>/ajax/comprueba_email.php?id=<?php echo $id;?>&email="+email,
                success:function(respuesta){
                    console.log(respuesta);
                    if(respuesta==0){
                        $("#email").css({'outline': '0px'});                        
                        $("#frm_contacto").validate().element( "#email" );
                    } else {
                        $("#email").val('Ese email está en uso!!');
                        $("#email").css({'outline': '2px solid #FF0000'});
                    }
                    
                }
        });
    }

</script>

<div class='grid_2'>&nbsp;</div>
<div class="grid_8">
    <form id="frm_contacto" method="post" action="<?php echo URL;?>/account/cambiar_password.php" style='border:1px solid #CCC;width:560px;' >

        <div class='grid_7'><h2 style='background:#ededed; line-height:50px;text-align:center;'>Modificar los Datos para el ingreso al sitio</h2></div>
        <div class="clear" style='margin-bottom:10px;'></div>


        <div class="grid_3 ctitulo">Email Institucional<em>*</em></div>
        <div class='grid_4'>
            <input id="email" name="email" title='Email de la institución (necesario para el ingreso al sitio)'
                type='text' class="required email" value="<?php echo $data['email'];?>" onblur="comprueba_email();" data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Contraseña de Acceso<em>*</em></div>
        <div class='grid_4'>
            <input type='password' id="clave_nueva" name="clave_nueva"  title='Contraseña de Acceso (minimo 6 caracteres)'
                class="required" value="" data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Reingrese la Contraseña<em>*</em></div>
        <div class='grid_4'>
            <input type='password' id="reingreso" name="reingreso"  title='Reingrese la contraseña de acceso'
                class="required" value="" data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_7" style='text-align:center;'>
            <p><em>*</em> Todos los datos son obligatorios.</p>
            <input type='hidden' name='id' value='<?php echo $data['id'];?>' />
            <input type='submit' name='submit' value='Guardar Datos' style='margin-bottom:10px;'/>

        </div>
        <div class="clear"></div>
    </form>
    
</div>
<div class='grid_2'>&nbsp;</div>

<div class='clear'></div>



<script>

    $(document).ready(function(){
        $("#frm_contacto").validate({
              rules: {
                "clave_nueva" : { required: true, minlength: 6 },
                "reingreso": { equalTo: "#clave_nueva" }
              }        
        });

        $('.required').tooltip();


    });
</script>
