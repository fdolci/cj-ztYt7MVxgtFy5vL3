<?php
	//--------------------------------------------------------------------------------------
	//             Previsualizar el Formulario de Inscripcion
	//--------------------------------------------------------------------------------------
	include ('../inc/config.php'); 
    $producto_id = request('producto_id',0);
    $user_id     = request('user_id',0);

	//----------------------------------------------------------------
	// Defino el array de los tipo de campos
	//----------------------------------------------------------------
	$tipocampo[0] = 'Título separador';
	$tipocampo[1] = 'Texto';
	$tipocampo[2] = 'Area de Texto';
	$tipocampo[3] = 'Select';
	$tipocampo[4] = 'Boton Radio';
	$tipocampo[5] = 'CheckBox';
	$tipocampo[6] = 'Tabla de Aranceles';
	
	
    if( !esta_login() ) { 
        $Mensaje["mensaje"]   = $Traducciones['login_requerido'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['user_id']  = '';
        redirect(URL);   die();  
    }

	$sql = "select titulo, vencimiento1, vencimiento2, vencimiento3 from productos where id='$producto_id' and user_id='$user_id'";
	$rs  = $db->SelectLimit($sql,1);
    $Producto = $rs->FetchRow();
	
	
	$sql = "select * from productos_aranceles where producto_id='$producto_id' and user_id='$user_id' order by orden ASC";
	$rs  = $db->Execute($sql);
    $Aranceles = $rs->GetRows();


	$sql = "select * from productos_inscripcion where producto_id='$producto_id' and user_id='$user_id' order by orden ASC";
	$rs  = $db->Execute($sql);
    $CamposBD = $rs->GetRows();
	
	//------------------------------------------------------------------------
	// Arma el array con los campos predifinidos del Formulario de Inscripcion
	// $CamposPredefinidos
	//------------------------------------------------------------------------
	include(ROOT.'/account/aviso_campos_fijos_inscripcion.html.php');
?>

<script type="text/javascript" src="<?php echo URL;?>/js/jquery-1.9.1.min.js"></script>
<link href="<?php echo URL;?>/js/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"  >
<script src="<?php echo URL;?>/js/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo URL;?>/css/layout.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo URL;?>/css/muestra_producto.css" type="text/css" media="screen" />

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

body {
	background:none;
	line-height:0px;
	height:100%;
}
</style>

<a href="<?php echo URL;?>/account/aviso_ver_inscripcion.html.php?producto_id=<?php echo $producto_id;?>&user_id=<?php echo $user_id;?>" 
class='botones' style='background:#e5e5e5;padding-left:5px;float:right;'>Actualizar Vista</a>
<table style='width:660px;' id='frm_inscripcion'>
	<tr><td colspan='2' >
		<h1>Formulario de Inscripción</h1>
	</td></tr>

	<?php foreach($CamposPredefinidos as $z){?>
		<?php if($z['tipo_campo']==0 ) { ?>
			<tr><td colspan='2'><h2><?php echo $z['etiqueta'];?></h2></td></tr>
		<?php } else { ?>
		
				<?php 
						if($z['tipo_campo']==1 ) {
							//----------------------------------- INPUT
							echo "<tr>
									<td style='width:220px;'><label>{$z['etiqueta']}: </label></td>
									<td ><input type='text' name='{$z['nombre']}' class='required' >
								</tr>";
					
						} elseif($z['tipo_campo']==3 ) {
							//----------------------------------- SELECT       	
							if($z['nombre']=='categoria_aranceles' and !empty($Aranceles) ){
								echo "<tr><td style='width:220px;'><label>{$z['etiqueta']}: </label></td>";								
								echo "<td ><select name='categoria_aranceles'>";
								foreach($Aranceles as $ara){
										if($Producto['vencimiento1']>0 and time()<$Producto['vencimiento1']){
											$que_vencimiento = 'vto_1';
										} elseif($Producto['vencimiento2']>0 and time()<$Producto['vencimiento2']){	
											$que_vencimiento = 'vto_2';
										} else {
											$que_vencimiento = 'vto_3';
										}
										$option = $ara['descripcion'].' - '.$ara[$que_vencimiento].$Monedas[$ara['moneda_id']];
										echo "<option value='$option'>$option</option>";
								}
								echo "</select></td></tr>";
								
							} elseif ($z['nombre']=='como_se_entero'){
								echo "<tr><td style='width:220px;'><label>{$z['etiqueta']}: </label></td>";
								$texto = nl2br($z['valores']);
								$texto = explode("<br />",$texto);
								echo "<td><select name='como_se_entero'>";
								foreach($texto as $option){
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
						echo "<tr><td style='width:220px;'><label>{$z['etiqueta']}: </label></td>";
						echo "<td><input type='text' name='c_{$z['id']}' class='required' ></td></tr>";
					
					} elseif($z['tipo_campo']==2 ) {
						//----------------------------------- TEXTAREA
						echo "<tr><td style='width:220px;'><label>{$z['etiqueta']}: </label></td>
								<td >
									<textarea name='c_{$z['id']}'  id='c_{$z['id']}' style='width:400px;padding:10px;height:150px;' >{$z['valores']}</textarea>
								</td></tr>";

					} elseif($z['tipo_campo']==3 ) {
						//----------------------------------- SELECT       	
						echo "<tr><td style='width:220px;'><label>{$z['etiqueta']}: </label></td>";
						$texto = nl2br($z['valores']);
						$texto = explode("<br />",$texto);
						echo "<td><select name='c_{$z['id']}'>";
						foreach($texto as $option){
							echo "<option value='$option'>$option</option>";
						}
						echo "</select></td></tr>";
						
					} elseif($z['tipo_campo']==4 ) {
						//----------------------------------- RADIO BUTTON
						echo "<tr><td style='width:220px;'><label>{$z['etiqueta']}: </label></td>";
						$texto = nl2br($z['valores']);
						$texto = explode("<br />",$texto);
						echo "<td>";
						foreach($texto as $option){
							echo "<input type='radio' name='c_{$z['id']}' value='$option' style='width:auto;'>$option<br>";
						}
						echo "</td></tr>";
						
					} elseif($z['tipo_campo']==5 ) {
						//----------------------------------- CHECKBOX
						echo "<tr><td style='width:220px;'><label>{$z['etiqueta']}: </label></td>";
						$texto = nl2br($z['valores']);
						$texto = explode("<br />",$texto);
						echo "<td>";
						foreach($texto as $option){
							echo "<input type='checkbox' name='c_{$z['id']}[]' value='$option' style='width:auto;margin-right:5px;'>$option<br>";
						}
						echo "</td></tr>";
					}
				?>
					
		<?php } ?>
	<?php } //endforeach?>
	
	<tr>
		<td style='width:220px;'><label>Comentarios / Dudas: </label></td>
		<td ><textarea name='comentarios'  id='comentarios' style='width:400px;padding:10px;height:150px;' ></textarea></td>
	</tr>

</table>