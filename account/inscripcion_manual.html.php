<?php

	include(ROOT.'/account/menu_mi_cuenta.html.php');
	
	
	//------------------------------------------------------------------------
	// Arma el array con los campos predifinidos del Formulario de Inscripcion
	// $CamposPredefinidos
	//------------------------------------------------------------------------
	include(ROOT.'/account/aviso_campos_fijos_inscripcion.html.php');
?>

<style>
	#test-list {
		list-style: none;
	}

	#test-list li {
		display: block;
		/* padding: 20px 10px;  */
		margin-bottom: 3px;
		background-color: #efefef;
	}

	#test-list li img.handle {
		margin-right: 20px;
		cursor: move;
	}

table{
	font-size:12px;
	font-family:Arial;
}

</style>
<a class="btn" href="<?php echo URL;?>/account/inscriptos.php?producto_id=<?php echo $producto_id;?>" style='float:right;'>Regresar al Listado de Inscriptos</a>	

<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />

<form id="f_formulario_inscripcion" action='<?php echo URL;?>/account/inscripcion_manual.php?producto_id=<?php echo $producto_id;?>' method='post' style='margin-top:40px;'>
<div id='formulario_de_inscripcion'>

	<table style='width:660px;margin-left:200px;' id='frm_inscripcion'>
		<tr><td colspan='2' ><h1>Formulario de Inscripción</h1>	</td></tr>
			<tr>
				<td class='ctitulo'>Fecha Inscripción:</td>
				<td><?php echo cb_fechas(time(),'x','');?></td>
			</tr>

			<tr>
				<td class='ctitulo'>Fecha de Pago:</td>
				<td style='text-align:left;'>
					<input type='checkbox' style='width:30px;height:14px;padding:0px;margin-bottom:10px;' id='habilita_pago'>Realizó el pago<br>
					<?php echo cb_fechas(0,'fecha_pago','disable',true);?>
				</td>
			</tr>

			<tr>	
				<td class='ctitulo'>
					Mis Anotaciones:
					<div style='font-weight:normal;font-size:11px;'>Ud. puede realizar anotaciones particulares en ese campo.
						<br>Ej: Nro.de comprobante de pago, <br>consideraciones especiales, etc.
					</div>	
				</td>
				<td>
					<textarea name='form_data[anotaciones]' style='width:300px;height:150px;'><?php echo $data['anotaciones'];?></textarea>
				</td>
			</tr>

		<?php foreach($CamposPredefinidos as $z){?>
			<?php if($z['tipo_campo']==0 ) { ?>
				<tr><td colspan='2'>
					<h2><?php echo $z['etiqueta'];?></h2>
					<input type='hidden' name='form_data[dummy]' value='Dummy Text'>	
				</td></tr>
			<?php } else { ?>
			
					<?php 
							if($z['tipo_campo']==1 ) {
								//----------------------------------- INPUT
								$email = iif( $z['nombre']=='email' , 'email','');
								echo "<tr>
										<td class='etiqueta'>{$z['etiqueta']} <em>*</em>:</td>
										<td ><input type='text' name='form_data[{$z['nombre']}]' class='required $email' >
									</tr>";
						
							} elseif($z['tipo_campo']==3 ) {
								//----------------------------------- SELECT       	
								if($z['nombre']=='categoria_aranceles' and !empty($Aranceles) ){
									echo "<tr><td class='etiqueta'>{$z['etiqueta']} <em>*</em>: </td>";
									echo "<td ><select name='form_data[categoria_aranceles]'>";
									foreach($Aranceles as $ara){
											if($Producto['vencimiento1']>0 and time()<$Producto['vencimiento1']){
												$que_vencimiento = 'vto_1';
											} elseif($Producto['vencimiento2']>0 and time()<$Producto['vencimiento2']){	
												$que_vencimiento = 'vto_2';
											} else {
												$que_vencimiento = 'vto_3';
											}
											$option_value = trim($ara['id']).'|'.$ara[$que_vencimiento].'|'.$ara['moneda_id'];
											$option = trim($ara['descripcion']).' - '.$ara[$que_vencimiento].$Monedas[$ara['moneda_id']];
											echo "<option value='$option_value'>$option</option>";
									}
									echo "</select></td></tr>";
									
								} elseif ($z['nombre']=='como_se_entero'){
									echo "<tr><td class='etiqueta'>{$z['etiqueta']} <em>*</em>: </td>";
									$texto = nl2br($z['valores']);
									$texto = explode("<br />",$texto);
									echo "<td><select name='form_data[como_se_entero]'>";
									foreach($texto as $option){
										$option = trim($option);
										echo "<option value='$option'>$option</option>";
									}
									echo "</select></td></tr>";
									
								}
							}
						?>
				
			<?php } ?>
		<?php } //endforeach?>
		

		
		<?php foreach($CamposBD as $z){?>
			<?php if($z['tipo_campo']==0 ) { ?>
				<tr><td colspan='2'><h2><?php echo $z['etiqueta'];?></h2></td></tr>
			<?php } else { ?>
			
					<?php 
						if($z['tipo_campo']==1 ) {
							//----------------------------------- INPUT
							echo "<tr><td class='etiqueta'>{$z['etiqueta']}: </td>";
							echo "<td><input type='text' name='form_data[c_{$z['id']}]' ></td></tr>";
						
						} elseif($z['tipo_campo']==2 ) {
							//----------------------------------- TEXTAREA
							echo "<tr><td class='etiqueta'>{$z['etiqueta']}: </td>
									<td >
										<textarea name='form_data[c_{$z['id']}]'  id='c_{$z['id']}' style='width:400px;padding:10px;height:150px;' >{$z['valores']}</textarea>
									</td></tr>";

						} elseif($z['tipo_campo']==3 ) {
							//----------------------------------- SELECT       	
							echo "<tr><td class='etiqueta'>{$z['etiqueta']}: </td>";
							$texto = nl2br($z['valores']);
							$texto = explode("<br />",$texto);
							echo "<td><select name='form_data[c_{$z['id']}]'>";
							foreach($texto as $option){
								$option = trim($option);
								echo "<option value='$option'>$option</option>";
							}
							echo "</select></td></tr>";
							
						} elseif($z['tipo_campo']==4 ) {
							//----------------------------------- RADIO BUTTON
							echo "<tr><td class='etiqueta'>{$z['etiqueta']}: </td>";
							$texto = nl2br($z['valores']);
							$texto = explode("<br />",$texto);
							echo "<td>";
							foreach($texto as $option){
								$option = trim($option);
								echo "<input type='radio' name='form_data[c_{$z['id']}]' value='$option' style='width:auto;'>$option<br>";
							}
							echo "</td></tr>";
							
						} elseif($z['tipo_campo']==5 ) {
							//----------------------------------- CHECKBOX
							echo "<tr><td class='etiqueta'>{$z['etiqueta']}: </td>";
							$texto = nl2br($z['valores']);
							$texto = explode("<br />",$texto);
							echo "<td>";
							foreach($texto as $option){
								$option = trim($option);
								echo "<input type='checkbox' name='form_data[c_{$z['id']}][]' value='$option' style='width:auto;margin-right:5px;'>$option<br>";
							}
							echo "</td></tr>";
						}
					?>
						
			<?php } ?>
		<?php } //endforeach?>
		
		<tr>
			<td class='etiqueta'>Comentarios / Dudas:: </td>
			<td ><textarea name='form_data[comentario]'  id='comentario' style='width:400px;padding:10px;height:150px;' ></textarea></td>
		</tr>

		<tr>
			<td colspan='2'>
				<div id='result'></div>
				<input type='hidden' name='form_data[producto_id]' value='<?php echo $Producto['id'];?>' >
				<input type='hidden' name='form_data[user_id]' value='<?php echo $Producto['user_id'];?>' >
				<input type="submit" name='submit' id='btn_submit' style='height:48px;margin-left:300px;font-size:14px;' value='Registrarse'>
			</td>
		</tr>
		
	</table>

</div> <!-- formulario_de_inscripcion -->
</form>
<script type="text/javascript">
    $(document).ready(function() { 
		$("#f_formulario_inscripcion").validate();

		$('#habilita_pago').click(function(){
			if($("#habilita_pago").is(':checked')) {  
				$('#fecha_pago_dia').val(<?php echo date("d",time());?>);
				$('#fecha_pago_mes').val(<?php echo date("m",time());?>);
				$('#fecha_pago_ano').val(<?php echo date("Y",time());?>);
			
				$('#fecha_pago_dia').attr('disabled', false);
				$('#fecha_pago_mes').attr('disabled', false);
				$('#fecha_pago_ano').attr('disabled', false);
			} else {  
				$('#fecha_pago_dia').val(0);
				$('#fecha_pago_mes').val(0);
				$('#fecha_pago_ano').val(0);
				$('#fecha_pago_mes').attr('disabled', false);
				$('#fecha_pago_ano').attr('disabled', false);
			
				$('#fecha_pago_dia').attr('disabled', true);
				$('#fecha_pago_mes').attr('disabled', true);
				$('#fecha_pago_ano').attr('disabled', true);
			}  		
		});
		
    }); 
     
</script>
