<?php

	$medios_de_pago = unserialize(base64_decode($Producto['medios_de_pago']));
	//-------------------------------------------------------------------------------
	//                                               Tiene medios de pago definidos??
	//-------------------------------------------------------------------------------
	$medios = array();
	if( isset($medios_de_pago['personalmente']) and !empty($medios_de_pago['personalmente']) ) {
		$medios['personalmente'] = 'Personalmente';
	}
	if( isset($medios_de_pago['transferencia']) and !empty($medios_de_pago['transferencia']) ) {
		$medios['transferencia'] = 'Transferencia Bancaria';
	}
	if( isset($medios_de_pago['dineromail']) and !empty($medios_de_pago['dineromail']) ) {
		$medios['dineromail'] = 'DineroMail';
	}
	if( isset($medios_de_pago['mp_account_id']) and !empty($medios_de_pago['mp_account_id']) 
		and isset($medios_de_pago['mp_enc']) and !empty($medios_de_pago['mp_enc']) ) {
		$medios['mercadopago'] = 'MercadoPago';
	}
	if( isset($medios_de_pago['paypal']) and !empty($medios_de_pago['paypal']) ) {
		$medios['paypal'] = 'Paypal';
	}

	$sql = "select * from productos_inscripcion where producto_id='{$Producto['id']}' and user_id='{$Producto['user_id']}' order by orden ASC";
	$rs  = $db->Execute($sql);
    $CamposBD = $rs->GetRows();
	
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

<form id="f_formulario_inscripcion">
<div id='formulario_de_inscripcion'>

	<table style='width:660px;' id='frm_inscripcion'>
		<tr><td colspan='2' ><h1>Formulario de Inscripción</h1>	</td></tr>

		<?php foreach($CamposPredefinidos as $z){?>
			<?php if($z['tipo_campo']==0 ) { ?>
				<?php if( ($z['nombre']=='posicion_arancelaria' and !empty($Aranceles)) or $z['nombre']!='posicion_arancelaria' ){ ?>
				<tr><td colspan='2'>
					<h2><?php echo $z['etiqueta'];?></h2>
					<input type='hidden' name='form_data[dummy]' value='Dummy Text'>	
				</td></tr>
				<?php } ?>
				
			<?php } else { ?>
			
					<?php 
							if($z['tipo_campo']==1 ) {
								//----------------------------------- INPUT
								$email = iif( $z['nombre']=='email' , 'email','');
								if(isset($z['placeholder'])){
									$placeholder = "placeholder='{$z['placeholder']}'";
								} else {
									$placeholder='';
								}
								echo "<tr>
										<td class='etiqueta'>{$z['etiqueta']} <em>*</em>:</td>
										<td ><input type='text' name='form_data[{$z['nombre']}]' class='required $email' $placeholder >
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
									
									//----------------------------------------------------------------------------
									// Si tiene medios de pago definidos, habilito el select
									//----------------------------------------------------------------------------
									if(!empty($medios)) {
										echo "<tr><td class='etiqueta'>Forma de Pago Preferida: </td>";
										echo "<td ><select name='form_data[forma_de_pago]'>";
										foreach($medios as $clave=> $med){
											echo "<option value='$clave'>$med</option>";
										}
										echo "</select><br>";
										echo "<small>Cuando finalice el proceso de registro, recibirá un mail con las indicaciones para realizar el pago.</small>";
										echo "</td></tr>";
									}
									
									
									
								} elseif ($z['nombre']=='como_se_entero' || $z['nombre']=='tipo_doc'){
									echo "<tr><td class='etiqueta'>{$z['etiqueta']} <em>*</em>: </td>";
									$texto = nl2br($z['valores']);
									$texto = explode("<br />",$texto);
									echo "<td><select name='form_data[{$z['nombre']}]'>";
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
				<input type="submit" id='btn_submit' style='height:48px;margin-left:300px;font-size:14px;' value='Registrarse'>
			</td>
		</tr>
		
	</table>

</div> <!-- formulario_de_inscripcion -->
</form>
<script type="text/javascript">
    $(document).ready(function() { 

			$("#f_formulario_inscripcion").validate({
					submitHandler: function(form) {
						$('#result').html("<img src='<?php echo URL;?>/img/loading.gif' style='float:left;'> Enviando formulario....");
						var variables =  $("#f_formulario_inscripcion").serialize();
						$.ajax({
							type:"GET", //tipo de formato de envio de información
							url: "<?php echo URL;?>/ajax/enviar_formulario_inscripcion.php?var="+variables,
							success:function(respuesta){
								$('#result').html(respuesta);
							}
						});

					}
			});

    }); 
     
</script>
