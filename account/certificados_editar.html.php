<style>
	table{ 
		width:900px !important;
		border-collapse:collapse;
	}
	.w-100 {
		width:100%;
	}
	.td-label {
		font-weight: bold;
		text-align: right !important;
		width:200px !important;
	}
	label { color:red;}
</style>

<div class='grid_12' style='min-height:400px;'>  

	<h2 style='margin:10px; text-align:center;'>Editar/Crear un Certificado para el: <?php echo $Evento['titulo'];?></h2>
	

	<link href="<?php echo ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>

	<form name='frm_certificados' id='frm_certificados' class='formulario' action='<?php echo URL;?>/account/certificados-guardar.php' method='post' accept-charset="utf-8" enctype="multipart/form-data"> 

		<table class='table'>

			<tr>
				<td class='td-label'>Certificado de:</td>
				<td>
					<input type='text' name='data[nombre]' id='c_nombre' value='<?php echo $Certificado['nombre'];?>' class="required w-100" 
					placeholder='Ej: Asistencia, Expositor, Comité Científico, etc.'>
				</td>
			</tr>

			<tr>
				<td class='td-label'>Orientación de la Página:</td>
				<td>
					<select name='data[orientacion]' id='orientacion'>
						<option value='L' <?php if($Certificado['orientacion']=='L'){ echo "selected='selected'";}?> >Apaisado</option>
						<!-- <option value='P' <?php if($Certificado['orientacion']=='P'){ echo "selected='selected'";}?> >Vertical</option> -->
					</select> 
				</td>
			</tr>

			<tr>
				<td class='td-label'>Título del Evento:</td>
				<td>
					<textarea name='data[titulo]' id='c_titulo' class="required w-100" style='height:150px;'><?php echo $Certificado['titulo'];?></textarea>
					<br>Caracteres Disponibles: <span id='disponible_c_titulo'></span> de 250 caracteres.</small>
				</td>
			</tr>

			<tr>
				<td class='td-label'>
					Cuerpo del Certificado:
					<br>
					<a href='#' class='btn btn-primary' data-toggle="modal" data-target="#basicModal">Ver ejemplos de certificados</a>
				</td>
				<td>
					<textarea name='data[cuerpo]' id='c_cuerpo' class="required w-100" style='height:150px;'><?php echo $Certificado['cuerpo'];?></textarea>
					<div style='line-height:15px; padding:10px; text-align:left;background:#BCF0F7;'>
						<b>Nota:</b> Los campos personalizables que se toman de la base de datos de inscripciones deben estar entre signos #. Ej: #NOMBRE#:<br>
						<br>
						<b>#NOMBRE#</b> -> Nombre de la persona inscripta.<br>
						<b>#APELLIDO#</b> -> Apellido de la persona inscripta.<br>
						<b>#DOCUMENTO#</b> -> Tipo y Nro.de Documento de la persona inscripta.
					</div>
				</td>
			</tr>

			<tr>
				<td class='td-label'>Imagen de Fondo:
					<br>A4 apaisado: 1170x770 píxeles
				</td>
				<td>
					<table style='width:100% !important;'>
						<tr>
							<td>
								<?php if(!empty($Certificado['imagen'])){
									echo "<img src='".VER_CERTIFICADOS."/{$Certificado['imagen']}' style='width:200px; height:150px; float:left; margin-right:20px;'>";
								} ?>
							</td>
							<td style='vertical-align:top;'>
								<input type='file'  name='img_certificado' id="img_certificado" value="" />
								<input type='hidden'  name='data[imagen_original]' id="c_imagen_original" value="<?php echo $Certificado['imagen'];?>"/>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan='2' style='text-align:center;'>
	            	<input type='hidden' name='producto_id' value='<?php echo $producto_id;?>'>
	            	<input type='hidden' name='certificado_id' value='<?php echo $certificado_id;?>'>
					
					<a href="<?php echo URL.'/account/certificados.php?producto_id='.$producto_id;?>" class='btn' title='Regresar sin Guardar'>Regresar sin Guardar</a>
					&nbsp;&nbsp;
					<input type='submit' class='btn btn-success' value='Guardar Cambios'>
				</td>
			</tr>

		</table>


	</form>	
</div>

<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">[X]</button>
            <h3 class="modal-title" id="myModalLabel">Ejemplos de Certificados</h3>
            </div>
            <div class="modal-body">
                <h4>Certificado de Asistente</h4>
                <p>
					Se deja constancia que #NOMBRE# #APELLIDO# participó en carácter de ASISTENTE al CONGRESO DE MEDICINA CLINICA 2015 desarrollado en la ciudad de ROSARIO entre los días 9 y 10 de Abril de 2015.
                </p>
                <br>
                <h4>Certificado de Expositor</h4>
                <p>
					Se deja constancia que #NOMBRE# #APELLIDO# participó en carácter de EXPOSITOR al CONGRESO DE MEDICINA CLINICA 2015 desarrollado en la ciudad de ROSARIO entre los días 9 y 10 de Abril de 2015.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	</div>
    	</div>
  	</div>
</div>


<script>
	$(document).ready(function() { 
		$("#frm_certificados").validate();
	}); 

		$('#c_titulo').keyup(function() {
			var longitud = $(this).val().length;
	        var resto = 250 - longitud;
	        $('#disponible_c_titulo').html(resto);
	        if(resto <= 0){
	        	var str= $("#c_titulo").val();
	            str = str.substr(0,250);
	            $("#c_titulo").val( str );
	            $("#disponible_c_titulo").html("0");
	        }
	    });

	$('#c_titulo').keyup();
</script>