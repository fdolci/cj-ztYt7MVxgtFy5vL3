<h3 style='text-align:left;margin-bottom:20px;'>Datos Generales de la Actividad a realizar</h3>
<div class='grid_2 ctitulo'>Tipo de Actividad:</div>
<div class='grid_5'>
	<?php 
		//-----------------------------------------------------------------
		//                                Combo de los tipos de actividades
		//-----------------------------------------------------------------
		$tipo_evento['Audicion']     = 'Audición';				
        $tipo_evento['Actualizacion']= 'Actualización';                      
		$tipo_evento['Charla']       = 'Charla';
		$tipo_evento['Congreso']     = 'Congreso';
		$tipo_evento['Disertacion']  = 'Disertación';
		$tipo_evento['Encuentro']    = 'Encuentro';
		$tipo_evento['Feria']        = 'Feria';
		$tipo_evento['Foro']         = 'Foro';
		$tipo_evento['Jornada']      = 'Jornada';
		$tipo_evento['Muestra']      = 'Muestra';
		$tipo_evento['Presentacion'] = 'Presentación';
		$tipo_evento['Seminario']    = 'Seminario';
		$tipo_evento['Simposio']     = 'Simposio';
		$tipo_evento['Workshop']     = 'Workshop';
	?>

    <select name='tipo_evento' style='line-height:20px; padding:3px;'>
		<?php foreach($tipo_evento as $clave=>$valor){?>
			<?php $sel = iif($data['tipo_evento']==$clave,'selected=selected',''); ?>
			<option value='<?php echo $clave;?>' <?php echo $sel;?> ><?php echo $valor;?></option>
		<?php } //end foreach ?>
    </select>
	
</div>
<div class='clear'></div>


	<?php for ($i=0; $i < CANTIDAD_DE_RUBROS; $i++) { ?>
		<div class='grid_1 ctitulo'>Área <?php echo $i+1;?>) <em>*</em>:</div>
		<div class='grid_2'>  <?php echo $Sel_Rubro[$i];?></div>
		<div class='grid_2 ctitulo'>Disciplina: <em>*</em></div>
		<div class='grid_3'>  
			<?php echo $Sel_SubRubro[$i];?>
		</div>
		<div class='clear'></div>
		
	<?php } ?>


<div class='grid_2 ctitulo' >Fecha Inicio:</div>
<div class='grid_5'><?php echo cb_fechas($data['desde'],'desde');?></div>
<div class='clear'></div>
<div class='grid_2 ctitulo' >Finalización:</div>
<div class='grid_5 '><?php echo cb_fechas($data['hasta'],'hasta');?></div>
<div class='clear'></div>



<div class='grid_2 ctitulo'>Nombre Corto:<em>*</em></div>
<div class='grid_5'>
    <input type='text'  name='titulo' id="titulo" value="<?php echo $data['titulo'];?>" class="required" style='width:480px;'/>
</div>
<div class='clear'></div>
<div class='grid_2 ctitulo' >URL local:</div>
<div class='grid_5'>
    <input type='text'  name='urlamigable' id="urlamigable" value="<?php echo $data['urlamigable'];?>.html" size='60' maxlength='60' style='font-weight:bold;color:#E77817;outline: 0px;'>
</div>
<div class='clear'></div>

<div class='grid_2 ctitulo'>Nombre Largo:</div>
<div class='grid_5'>
    <textarea name='subtitulo' id='subtitulo' style='width:480px; height:50px;' class='required'><?php echo $data['subtitulo'];?></textarea>    
</div>
<div class='clear'></div>


	<?php if ($data['id']>0){?>	
		<!----------------------------------------------------------------------------
		//                                                             Logo del evento
		-------------------------------------------------------------------------- -->
        <div class='grid_2 ctitulo' >
            Logo de la Actividad:
			(300px * 220px)
        </div>
        <div class='grid_6 ctitulo' >
			<?php 
                $ajaxupload['tabla'] = 'productos_imagenes';
                $ajaxupload['campo'] = 'producto_id';
                $ajaxupload['id']    = $data['id'];
                $ajaxupload['user_id'] = $data['user_id'];
                $ajaxupload['cual']  = 'logo_evento';
                $ajaxupload['identificador']  = $identificador;
                $ajaxupload['donde_subir']    = SUBIR_FOTOS;
                $ajaxupload['donde_ver']      = VER_FOTOS;
                $ajaxupload['tn_ancho'] = 0;
                $ajaxupload['tn_alto']  = 0;
                $ajaxupload['ancho']    = 800;
                $ajaxupload['alto']     = 600;
                //$datos_ajaxupload = base64_encode( serialize($ajaxupload) );
                $datos_ajaxupload = json_encode( $ajaxupload) ;
            ?>
			<iframe src='<?php echo URL;?>/account/upload.php?data=<?php echo $datos_ajaxupload;?>' width='500' height='130'></iframe>
        </div>
        <div class='clear'></div>

		
		<!----------------------------------------------------------------------------
		//                                                           Banner del evento
		-------------------------------------------------------------------------- -->
		<div class='grid_2 ctitulo' style='text-align:left;'>Banner para el encabezado de la web:</div>
        <div class='grid_6 ctitulo' >
			<?php 
                $ajaxupload['tabla'] = 'productos_imagenes';
                $ajaxupload['campo'] = 'producto_id';
                $ajaxupload['id']    = $data['id'];
                $ajaxupload['user_id'] = $data['user_id'];
                $ajaxupload['cual']  = 'banner';
                $ajaxupload['identificador']  = $identificador;
                $ajaxupload['donde_subir']    = SUBIR_FOTOS;
                $ajaxupload['donde_ver']      = VER_FOTOS;
                $ajaxupload['tn_ancho'] = 0;
                $ajaxupload['tn_alto']  = 0;
                $ajaxupload['ancho']    = 950;
                $ajaxupload['alto']     = 220;
                $datos_ajaxupload = json_encode( $ajaxupload) ;
            ?>
			<iframe src='<?php echo URL;?>/account/upload.php?data=<?php echo $datos_ajaxupload;?>' width='500' height='130'></iframe>
        </div>
		<div class='clear'></div>

		<!----------------------------------------------------------------------------
		//                                                           Afiche del evento
		-------------------------------------------------------------------------- -->
		<div class='grid_2 ctitulo' style='text-align:left;'>Afiche de la Actividad: Ancho 680px</div>
        <div class='grid_6 ctitulo' >
			<?php 
                $ajaxupload['tabla'] = 'productos_imagenes';
                $ajaxupload['campo'] = 'producto_id';
                $ajaxupload['id']    = $data['id'];
                $ajaxupload['user_id'] = $data['user_id'];
                $ajaxupload['cual']  = 'afiche';
                $ajaxupload['identificador']  = $identificador;
                $ajaxupload['donde_subir']    = SUBIR_FOTOS;
                $ajaxupload['donde_ver']      = VER_FOTOS;
                $ajaxupload['tn_ancho'] = 0;
                $ajaxupload['tn_alto']  = 0;
                $ajaxupload['ancho']    = 0;
                $ajaxupload['alto']     = 0;
                $datos_ajaxupload = json_encode( $ajaxupload) ;
            ?>
			<iframe src='<?php echo URL;?>/account/upload.php?data=<?php echo $datos_ajaxupload;?>' width='500' height='130'></iframe>
        </div>
		<div class='clear'></div>

	<?php } ?>

<div class='clear'></div>

<div class='grid_2 ctitulo'>Keywords:</div>
<div class='grid_5'>
    <textarea name='keywords' id='keywords' style='width:480px; height:50px;' ><?php echo $data['keywords'];?></textarea>    
    <small><br>Palabras claves que ayudarán a la busqueda y localización de su evento. <br>Deben ir separadas por coma (,) - 
        Disponible: <span id='disponible_keywords'></span> de 150 caracteres.</small>
</div>
<div class='clear'></div>

<script>
$(document).ready(function(){
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

    <?php for ($i=0; $i < CANTIDAD_DE_RUBROS; $i++) { ?>
       $("#familia_<?php echo $i;?>").change(function () {
            var familia_id = $("#familia_<?php echo $i;?>").val();
            $.ajax({
                type:"GET", //tipo de formato de envio de información
                url: "<?php echo URL;?>/ajax/actualizar_subfamilia.php?familia_id="+familia_id+"&cual=<?php echo $i;?>",
                success:function(respuesta){
                    var data = jQuery.parseJSON(respuesta);
                    $('#subfamilia_<?php echo $i;?>').html(data.select_subfamilia);
                    var plantilla = '#plantilla_'+data.plantilla;
                    $(".plantillas").hide();
                    $(plantilla).show();                
                    $("#plantilla_id").val(data.plantilla);

                }
            });

        });
    <?php } ?>    


               

})

</script>



