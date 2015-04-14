<form name='archivos' action='<?php echo URL;?>/account/aviso_autoridades.html.php?producto_id=<?php echo $producto_id;?>' method='post' enctype="multipart/form-data" >

<fieldset>
	<label for='titulo' style='display:inline-block;line-height:30px;height:30px;'>Nombre de la Persona:</label>
	<input type='text' name='nombre' id='nombre' value='<?php echo $data['nombre'];?>' style='padding:3px; line-height:30px; height:30px; display:inline-block;width:300px;'/>
	<?php echo $paises_autoridades;?>
</fieldset>

<fieldset>
	<label for='descripcion' style='line-height:30px;height:30px;display:inline-block;'>Descripción:</label>
	<textarea name='descripcion' id='descripcion' style='padding:3px;width:500px;height:100px;'><?php echo $data['descripcion'];?></textarea>
		
</fieldset>

<fieldset>

	<?php if(!empty($data['archivo'])){ ?>
		<img src='<?php echo VER_ARCHIVOS.'/'.$data['archivo'];?>' class='autoridades_imagen_perfil' title='<?php $x['nombre'];?>' />
		<input type='checkbox' name='eliminar_foto'> Tilde esta opción si desea eliminar la fotografía y luego guarde los cambios.
		<div class='clear'></div>
	<?php } ?>

	<input type='file' name='archivo' id='archivo' value='' style='padding:3px; height:30px; display:inline-block;'/>
	<br><small>Tamaño máximo permitido: 2Mb. <i>La imagen se mostrará a un tamaño de 50px de ancho por 50px de alto</i></small>

	<input type='hidden' name='producto_id' value='<?php echo $producto_id;?>' />
	<input type='hidden' name='id' value='<?php echo $data['id'];?>' />
	<input type='hidden' name='accion' value='guardar' />

	<input type='submit' name='subir_foto' value='Guardar Datos' style='float:right;padding:3px;height:30px;'/>
</fieldset>
</form>
