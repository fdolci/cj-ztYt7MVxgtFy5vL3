<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>
<link rel="stylesheet" href="<?php echo URL;?>/css/muestra_producto.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />

<div class='grid_2' >   &nbsp;</div>
<div class='grid_10'> 

	<?php 
		echo "<hr><h2>Administrar Ficha de: {$data['apellido']}, {$data['nombre']}</h2>";
	?>

	<style>
		table td{
			height:30px;
			line-height:30px;
			padding:3px;
		}
	</style>
	
	<form name='editar_ficha' id='editar_ficha' action='inscripto_editar.php' method='post'>
				
		<table style='width:660px;' id='frm_inscripcion'>
			<tr>
				<td class='ctitulo'>Fecha Inscripción:</td>
				<td><?php echo cb_fechas($data['fecha'],'x','disabled');?></td>
			</tr>

			<tr>
				<td class='ctitulo'>Fecha de Pago:</td>
				<td><?php echo cb_fechas($data['fecha_de_pago'],'fecha_pago','',true);?></td>
			</tr>

			<tr>	
				<td class='ctitulo'>
					Mis Anotaciones:
					<div style='font-weight:normal;font-size:11px;'>Ud. puede realizar anotaciones particulares en ese campo.
						<br>Ej: Nro.de comprobante de pago, <br>consideraciones especiales, etc.
					</div>	
				</td>
				<td>
					<textarea name='data[anotaciones]' style='width:300px;height:150px;'><?php echo $data['anotaciones'];?></textarea>
				</td>
			</tr>
			
			<tr>
				<td class='ctitulo'>Apellido (*):</td>
				<td><input type='text' name="data[apellido]" value="<?php echo $data['apellido'];?>" class="required"></td>
			</tr>

			<tr>
				<td class='ctitulo'>Nombre (*):</td>
				<td><input type='text' name="data[nombre]" value="<?php echo $data['nombre'];?>" class="required"></td>
			</tr>

			<tr>
				<td class='ctitulo'>Tipo de Documento (*):</td>
				<td>
					<select name="data[tipo_doc]" class="required">
						<option value="DNI" <?php if($data['tipo_doc']=='DNI'){ echo 'selected="selected"'; }?> >DNI</option>
						<option value="LC" <?php if($data['tipo_doc']=='LC'){ echo 'selected="selected"'; }?> >LC</option>
						<option value="LE" <?php if($data['tipo_doc']=='LE'){ echo 'selected="selected"'; }?> >LE</option>
						<option value="CI" <?php if($data['tipo_doc']=='CI'){ echo 'selected="selected"'; }?> >CI</option> 
						<option value="PAS" <?php if($data['tipo_doc']=='PAS'){ echo 'selected="selected"'; }?> >PAS</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='ctitulo'>Nro.de Documento (*):</td>
				<td><input type='text' name="data[nro_doc]" value="<?php echo $data['nro_doc'];?>" class="required"></td>
			</tr>
			
			<tr>
				<td class='ctitulo'>Teléfono (*):</td>
				<td><input type='text' name="data[telefono]" value="<?php echo $data['telefono'];?>" class="required"></td>
			</tr>

			<tr>	
				<td class='ctitulo'>Email (*):</td>
				<td><input type='text' name="data[email]" value="<?php echo $data['email'];?>" class="required email"></td>
			</tr>

			<tr>
				<td class='ctitulo'>Domicilio (*):</td>
				<td><input type='text' name="data[domicilio]" value="<?php echo $data['domicilio'];?>" class="required"></td>
			</tr>

			<tr>
				<td class='ctitulo'>Ciudad (*):</td>
				<td><input type='text' name="data[ciudad]" value="<?php echo $data['ciudad'];?>" class="required"></td>
			</tr>

			<tr>
				<td class='ctitulo'>Provincia (*):</td>
				<td><input type='text' name="data[provincia]" value="<?php echo $data['provincia'];?>" class="required"></td>
			</tr>

			<tr>	
				<td class='ctitulo'>País (*):</td>
				<td><input type='text' name="data[pais]" value="<?php echo $data['pais'];?>" class="required"></td>
			</tr>

			<tr>
				<td class='ctitulo'>Como se enteró?:</td>
				<td><?php echo $data['como_se_entero'];?></td>
			</tr>
			
			<?php if(!empty($data['categoria_aranceles'])){?>
			<tr>
				<td class='ctitulo'>Posición Arancelaria:</td>
				<td><?php echo $data['categoria_aranceles'];?></td>
			</tr>
			<?php } ?>

			<?php if(!empty($data['resto'])){?>
			<tr>
				<td class='ctitulo'>Campos Personalizados:</td>
				<td><?php echo $data['resto'];?></td>
			</tr>
			<?php } ?>

			<?php if(!empty($data['comentario'])){?>
			<tr>
				<td class='ctitulo'>Comentarios:</td>
				<td><?php echo $data['comentario'];?></td>
			</tr>
			<?php } ?>
			<tr>
				<td class='ctitulo'></td>
				<td>
					<input type='hidden' name='accion' value='guardar' />
					<input type='hidden' name='letra' value='<?php echo $letra;?>' />
					<input type='hidden' name='data[producto_id]' value='<?php echo $data['producto_id'];?>' />
					<input type='hidden' name='data[id]' value='<?php echo $data['id'];?>' />
					<input type='hidden' name='id' value='<?php echo $data['id'];?>' />					
					<input type='submit' name='submit' value='Guardar Cambios' style='height:50px;'/>	
				</td>
			</tr>
		</table>
		
	</form>
	<script type="text/javascript">
		$(document).ready(function() { 
			jQuery("#editar_ficha").validate();
		}); 
		 
	</script>
	
</div>