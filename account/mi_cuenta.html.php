<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>

<style>
    label { float: left; }
    label.error { float: none; color: red; padding-left:0px; vertical-align: top; display: block;font-size:12px;}
    p { clear: both; }
    em { font-weight: bold; padding-right: 1em; vertical-align: top; color:red;}

    input {margin:5px;}
    .ctitulo {
        text-align:right;
        font-weight:bold;
        line-height:30px;
        font-size:12px;
    }
    .required { 
        border:1px solid #FF9900; 
        background:#eee;
    }
</style>


<!-- AjaxUpload -->
<link rel="stylesheet" href="<?php echo URL;?>/modules/AjaxUpload/css/ajaxupload.css" type="text/css" media="screen" />    
<script type="text/javascript" src="<?php echo URL;?>/modules/AjaxUpload/js/ajaxupload.js"></script>

<div class='grid_2'>&nbsp;</div>
<div class="grid_8">

    <form id="frm_contacto" method="post" action="<?php echo URL;?>/account/mi_cuenta.php" style='border:1px solid #CCC;width:560px;' >

        <div class='grid_7'><h2 style='background:#ededed; line-height:50px;text-align:center;'>Datos de la Asociación o Entidad Organizadora</h2></div>

        <div class="grid_3 ctitulo" >Asociación / Entidad<em>*</em></div>
        <div class='grid_4'>
            <input id="nombre_entidad" type='text' name="nombre_entidad" title='Nombre de la Asociación Organizadora.'
                class="required" value="<?php echo $data['nombre_entidad'];?>" data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo" >Sigla<em>*</em></div>
        <div class='grid_4'>
            <input id="sigla" type='text' name="sigla" title='Sigla (abreviatura) que identifica a la Entidad Organizadora'
                class="required" value="<?php echo $data['sigla'];?>" data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class='grid_3 ctitulo' >
            Logo de la Asociación:
            <small><br>Formato: JPG<br>Tamaño: 150px x 110px</small>
        </div>
        <div class='grid_4 ctitulo' >
            <?php 
                $ajaxupload['tabla'] = 'productos_imagenes';
                $ajaxupload['campo'] = 'user_id';
                $ajaxupload['id']    = $data['id'];
                $ajaxupload['cual']  = 'miniatura';
                $ajaxupload['identificador']  = $identificador;
                $ajaxupload['donde_subir']    = SUBIR_FOTOS;
                $ajaxupload['donde_ver']      = VER_FOTOS;
                $ajaxupload['tn_ancho'] = 150;
                $ajaxupload['tn_alto']  = 110;
                $ajaxupload['ancho']    = 640;
                $ajaxupload['alto']     = 480;
                $datos_ajaxupload = base64_encode( serialize($ajaxupload) );
                include(ROOT.'/modules/AjaxUpload/sube_miniatura.html.php'); 
            ?>

        </div>
        <div class='clear'></div>



        <div class="grid_3 ctitulo" >Página Web</div>
        <div class='grid_4'>
            <input id="web" type='text' name="web" title='Página Web de la Entidad Organizadora'
                value="<?php echo $data['web'];?>"  data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>


        <div class="grid_3 ctitulo">Teléfono<em>*</em></div>
        <div class='grid_4'>
            <input type='text' id="telefono1" name="telefono" class="required" value="<?php echo $data['telefono'];?>"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class='grid_3 ctitulo' >Dirección<em>*</em></div>
        <div class='grid_4'>
            <input type='text'  name='direccion' id="direccion" value="<?php echo $data['direccion'];?>" class="required"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class='grid_3 ctitulo' >Código Postal<em>*</em></div>
        <div class='grid_4'>
            <input type='text'  name='codigo_postal' id="codigo_postal" value="<?php echo $data['codigo_postal'];?>" style='width:100px;' class="required"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class='grid_3 ctitulo' >Provincia<em>*</em></div>
        <div class='grid_4'><?php echo $select_provincia;?></div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class='grid_3 ctitulo' >Loalidad<em>*</em></div>
        <div class='grid_4'><?php echo $select_ciudad;?></div>
        <div class="clear" style='margin-bottom:10px;'></div>

<?php /*
        <div class='grid_7'><h2 style='background:#ededed; line-height:50px;text-align:center;'>Datos para el ingreso al sitio</h2></div>
        <div class="clear" style='margin-bottom:10px;'></div>


        <div class="grid_3 ctitulo">Email Institucional<em>*</em></div>
        <div class='grid_4'>
            <input id="email" name="email" size="50"  title='Email de la institución (necesario para el ingreso al sitio)'
                class="required email" value="<?php echo $data['email'];?>" onblur="comprueba_email();"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Contraseña de Acceso<em>*</em></div>
        <div class='grid_4'>
            <input type='password' id="password" name="password"  title='Contraseña de Acceso (minimo 6 caracteres)'
                size="50" class="required" value="<?php echo $data['password'];?>"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Reingrese la Contraseña<em>*</em></div>
        <div class='grid_4'>
            <input type='password' id="reingreso" name="reingreso"  title='Reingrese la contraseña de acceso'
                size="50" class="required" value="<?php echo $data['reingreso'];?>"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>
*/?>


        <div class='grid_7'><h2 style='background:#ededed; line-height:50px;text-align:center;'>Información de la Persona de Contacto</h2></div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Apellido<em>*</em></div>
        <div class='grid_4'>
            <input id="apellido" name="apellido" title='Apellido de la persona responsable' type='text'
                class="required" value="<?php echo $data['apellido'];?>" data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Nombre<em>*</em></div>
        <div class='grid_4'>
            <input id="nombre" name="nombre" title='Nombre de la persona responsable' type='text'
                class="required" value="<?php echo $data['nombre'];?>" data-placement="right"/>
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

<script>
$(document).ready(function(){
    $("#frm_contacto").validate({
              rules: {
                "frm_password" : { required: true, minlength: 4 },
                "frm_repeat_passw": { equalTo: "#frm_password" }
              }        
    });


   $("#provincia_id").change(function () {
        var provincia_id = $("#provincia_id").val();
        $.ajax({
            type:"GET", //tipo de formato de envio de información
            url: "<?php echo URL;?>/ajax/actualizar_ciudades.php?provincia_id="+provincia_id,
            success:function(respuesta){
                $('#ciudad_id').html(respuesta);
            }
        });

    });

    $('.required').tooltip();
    $('#web').tooltip();



})

</script>
<div class='clear'></div>