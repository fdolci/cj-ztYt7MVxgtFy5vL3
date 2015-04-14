<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />

<script type="text/javascript">
    function comprueba_email(){
        var email = $("#email").val();
        $.ajax({
                type:"GET", //tipo de formato de envio de información
                url: "<?php echo URL;?>/ajax/comprueba_email.php?id=0&email="+email,
                success:function(respuesta){
                    console.log(respuesta);
                    if(respuesta==0){
                        $("#email").css({'outline': '0px'});                        
                        $("#frm_registro").validate().element( "#email" );
                    } else {
                        $("#email").val('Ese email está en uso!!');
                        $("#email").css({'outline': '2px solid #FF0000'});
                    }
                    
                }
        });
    }

</script>


    <br><br>
    <form id="frm_contacto" method="post" class='formulario' action="<?php echo URL;?>/account/registro.php" >

        <h2>Formulario de Registro</h2>
        <div style='margin:20px auto;text-align:center;font-weight:bold;width:600px;'>Debe completar el siguiente formulario, con los datos de la Asociación o Entidad que organiza el evento.</div>
        

        <input type="hidden" name="accion" value="registro" />
        <h2>Datos de la Asociación o Entidad Organizadora</h2>

        <div class="grid_3 ctitulo" >Asociación / Entidad<em>*</em></div>
        <div class='grid_5'>
            <input id="nombre_entidad" type='text' name="nombre_entidad" class="required" value="<?php echo $data['nombre_entidad'];?>"
                title='Nombre de la Entidad o Asociación.' data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo" >Sigla<em>*</em></div>
        <div class='grid_5'>
            <input id="sigla" type='text' name="sigla" class="required" value="<?php echo $data['sigla'];?>"
                title='Sigla (abreviatura) que identifica a la Entidad Organizadora' data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo" >Página Web</div>
        <div class='grid_5'>
            <input id="web" type='text' name="web" value="<?php echo $data['web'];?>"
                title='Página Web de la Entidad Organizadora' data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Teléfono<em>*</em></div>
        <div class='grid_5'>
            <input type='text' id="telefono1" name="telefono" size="50" class="required" value="<?php echo $data['telefono'];?>"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class='grid_3 ctitulo' >Dirección<em>*</em></div>
        <div class='grid_5'>
            <input type='text'  name='direccion' id="direccion" value="<?php echo $data['direccion'];?>" class="required"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class='grid_3 ctitulo' >Código Postal<em>*</em></div>
        <div class='grid_5'>
            <input type='text'  name='codigo_postal' id="codigo_postal" value="<?php echo $data['codigo_postal'];?>" style='width:100px;' class="required"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class='grid_3 ctitulo' >Provincia<em>*</em></div>
        <div class='grid_5'><?php echo $select_provincia;?></div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class='grid_3 ctitulo' >Loalidad<em>*</em></div>
        <div class='grid_5'><?php echo $select_ciudad;?></div>
        <div class="clear" style='margin-bottom:10px;'></div>


        <h2 style='background:#ededed; line-height:50px;text-align:center;'>Datos para el ingreso al sitio</h2>
        <div class="clear" style='margin-bottom:10px;'></div>


        <div class="grid_3 ctitulo">Email Institucional<em>*</em></div>
        <div class='grid_5'>
            <input type='text' id="email" name="email" class="required email" value="<?php echo $data['email'];?>" onblur="comprueba_email();"
                title='Email de la institución (necesario para el ingreso al sitio)' data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Contraseña de Acceso<em>*</em></div>
        <div class='grid_5'>
            <input type='password' id="password" name="password"  class="required" value="<?php echo $data['password'];?>"
                title='Contraseña de Acceso (minimo 6 caracteres)' data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Reingrese la Contraseña<em>*</em></div>
        <div class='grid_5'>
            <input type='password' id="reingreso" name="reingreso" class="required" value="<?php echo $data['reingreso'];?>"
                title='Reingrese la contraseña de acceso' data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>



        <h2 style='background:#ededed; line-height:50px;text-align:center;'>Información de la Persona de Contacto</h2>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Apellido<em>*</em></div>
        <div class='grid_5'>
            <input id="apellido" name="apellido" type='text' class="required" value="<?php echo $data['apellido'];?>"
                title='Apellido de la persona responsable' data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>

        <div class="grid_3 ctitulo">Nombre<em>*</em></div>
        <div class='grid_5'>
            <input id="nombre" name="nombre" type='text'  class="required" value="<?php echo $data['nombre'];?>"
                title='Nombre de la persona responsable' data-placement="right"/>
        </div>
        <div class="clear" style='margin-bottom:10px;'></div>




        <div class='grid_3 ctitulo' >Términos y Condiciones<em>*</em></div>
        <div class='grid_5'>
            <input type='checkbox' name='acepta_toc' id='acepta_toc' class='required'  style='width:20px;'>
            <small style='text-align:left;'>He leído y aceptado los <a href='<?php echo URL;?>/terminos-y-condiciones.html' target='_blank'>Términos y Condiciones</a></small>
        </div>
        <div class='clear'></div>
            <div style='margin:20px auto;text-align:center;font-weight:bold;width:600px;'>
                Una vez completado y enviado el Formulario de Inscripción, recibirá un email con un enlace (link), 
                para que pueda activar su cuenta y comenzar a cargar los datos del evento.
            </div>

            <p style='margin:20px;'><em>*</em> Todos los datos son obligatorios.</p>
            <input type='submit' name='submit' value='Registrarse' title="Haciendo click aquí, enviará el formulario de inscripción. Asegúrese de haber completado todos los datos solicitados." 
            style='margin-left:380px;width:200px;'/>


        <div class="clear"></div>
    </form>
    
</div>


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
