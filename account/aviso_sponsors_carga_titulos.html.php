<form name='archivos' action='<?php echo URL;?>/account/aviso_sponsors.html.php?producto_id=<?php echo $producto_id;?>' method='post'  >
<fieldset>
	<label for='cargo' style='display:inline-block;line-height:30px;height:30px;'>Nombre del Titulo/Cargo:</label>
	<input type='text' name='nombre' id='nombre' value='<?php echo $data['nombre'];?>' style='padding:3px; line-height:30px; height:30px; display:inline-block;width:300px;'/>
</fieldset>

<fieldset>
	<label for='estilo' style='display:inline-block;line-height:30px;height:30px;'>Estilo del Titulo:</label>
	<select name='estilo' id='estilo'>
		<option value='h1' <?php if($data['estilo']=='h1'){ echo 'selected';}?> > Título Principal</option>
		<option value='h2' <?php if($data['estilo']=='h2'){ echo 'selected';}?> > Título Secundario</option>
		<option value='h3' <?php if($data['estilo']=='h3'){ echo 'selected';}?> > Título Terciario</option>
	</select>	

	<input type='hidden' name='producto_id' value='<?php echo $producto_id;?>' />
	<input type='hidden' name='id' value='<?php echo $data['id'];?>' />	
	<input type='hidden' name='accion' value='guardar_titulo' />

	<input type='submit' name='submit' value='Guardar Titulo' style='float:right;padding:3px; height:30px;'/>
</fieldset>
</form>
