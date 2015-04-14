<?php
	//--------------------------------------------------------------------------------------
	//                                      Gestiona el Formulario de Inscripcion
	//--------------------------------------------------------------------------------------
	include ('../inc/config.php'); 
    $producto_id = request('producto_id',0);
    $user_id     = request('user_id',0);
    $accion      = request('accion','');
    $id          = request('id',0);

	//----------------------------------------------------------------
	// Defino el array de los tipo de campos
	//----------------------------------------------------------------
	$tipocampo[1] = 'Texto';
	$tipocampo[0] = 'Título separador';
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

	if(isset($_GET['listItem'])){ 
		$accion = 'ordenar';
	}
	
	switch ($accion) {
	    case 'guardar':
		    if($_POST){
		    	$data = $_POST;
				unset($data['accion']);

				if($data['id']==0){
					$sql = "select * from productos_inscripcion where producto_id='$producto_id' and user_id='$user_id' order by orden DESC";
					$rs  = $db->SelectLimit($sql,1);
					$x   = $rs->FetchRow();
					$data['orden'] = iif( isset($x), $x['orden']+1, 1) ;
				}		
				
				$ok = $db->Replace('productos_inscripcion', $data,'id', $autoquote = true); 				

		        unset($data);

		    }
		    $id = 0;
	        break;


	    case 'eliminar':
	    	$ok = $db->Execute("delete from productos_inscripcion where id='$id' and producto_id='$producto_id' and user_id='$user_id'");
			$id = 0;	        
	        break;
			
	    case 'editar':
	    	$sql = "select * from productos_inscripcion where id='$id' and producto_id='$producto_id' and user_id='$user_id'";
			$rs  = $db->SelectLimit($sql,1);
			$data = $rs->FetchRow();
			$id = $data['id'];
	        break;

	    case 'ordenar':
	    	foreach($_GET['listItem'] as $clave=>$valor){
				$ok = $db->Execute("update productos_inscripcion set orden='$clave' where id='$valor'");	    		
	    	}
	    	die();
			$id = 0;	        
	        break;

	    default:
			$data['id']          = 0;
			$data['tipo_campo']  = 1;
			$data['producto_id'] = $producto_id;
			$data['user_id']     = $user_id;
			$id = 0;	        
	        break;
			
			
			
	}

	$sql = "select * from productos where id='$producto_id' and user_id='$user_id'";
	$rs  = $db->SelectLimit($sql,1);
    $evento = $rs->FetchRow();
	
	
	$sql = "select * from productos_inscripcion where producto_id='$producto_id' and user_id='$user_id' order by orden ASC";
	$rs  = $db->Execute($sql);
    $ax = $rs->GetRows();
	
	
	
	

?>

<script type="text/javascript" src="<?php echo URL;?>/js/jquery-1.9.1.min.js"></script>
<link href="<?php echo URL;?>/js/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"  >
<script src="<?php echo URL;?>/js/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo URL;?>/css/muestra_producto.css" type="text/css" media="screen" />


<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

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


<div id="info"></div> 
	<h3 style='text-align:left;margin-top:20px;margin-bottom:10px;'>Agregar campos al formulario de inscripción:</h3>
	
	<form action='<?php echo URL;?>/account/aviso_inscripcion.html.php' method='post'>
	
	<table style='width:650px; margin-left:50px; border-left:1px solid #CCC;'>
		<tr style='border-bottom:1px solid #CCC;background:#F2F2F2;'>
			<td>Tipo de Campo: </td>
			<td style='padding:5px;'>
				<select name='tipo_campo' id='ftipocampo'>
					<?php foreach($tipocampo as $clave=>$valor){?>
						<?php if($clave!=6){?>
							<?php $sel = iif( $clave==$data['tipo_campo'],'selected','' );?>
							<option value='<?php echo $clave;?>' <?php echo $sel;?> ><?php echo $valor;?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</td>
		</tr>

		<tr style='border-bottom:1px solid #CCC;background:#F2F2F2;'>
			<td>Etiqueta: </td>
			<td style='padding:5px;'>
				<input type='text' name='etiqueta'  id='fetiqueta' value='<?php echo $data['etiqueta'];?>' style='width:300px;padding:10px;height:30px;'>
				<br><small>La etiqueta es el nombre que se mostrará al lado del campo.</small>
			</td>
		</tr>

		<tr style='border-bottom:1px solid #CCC;background:#FFF;'>
			<td>Lista de Opciones: </td>
			<td style='padding:5px;'>
				<textarea name='valores'  id='fvalores' style='width:400px;padding:10px;height:150px;' ><?php echo $data['valores'];?></textarea>
				<br><small>Escriba cada opción en un renglón distinto.</small>
			</td>
		</tr>
				
		<tr style='border-bottom:1px solid #CCC;background:#F2F2F2;'>
			<td style='padding:5px; text-align:center;' colspan='2'>						
				<input type='hidden' name='id' value='<?php echo $id;?>'>
				<input type='hidden' name='user_id' value='<?php echo $user_id;?>'>
				<input type='hidden' name='producto_id' value='<?php echo $producto_id;?>'>
				<input type='hidden' name='accion' value='guardar'>
				<input type='submit' value='Guardar'>
			</td>
		</tr>
	</table>	
	</form>
	
	
	
<table class="table table-condensed">
	<tr>
		<th >Acciones</th>
		<th >Etiqueta</th>
		<th style="width:150px;">Tipo de Campo</th>
	</tr>
</table>

	<ul id="test-list" style='margin:0 0 10px 0;'> 		
	<?php if($ax){?>
		<?php foreach($ax as $clave=>$valor){?>
		<li id="listItem_<?php echo $valor['id'];?>">
			<table class="table table-condensed">
			<tr>
				<td width='20' style="color:#000000; font-weight:bold; font-size:12px;text-align:center;">
					<img src="<?php echo URL;?>/img/arrow.png" alt="move" width="16" height="16" class="handle" title='Arrastre para ordenar'/>
				</td>

				<td width='80' align='center' style="color:#000000; font-weight:bold; font-size:12px;">
					<a href='aviso_inscripcion.html.php?accion=eliminar&producto_id=<?php echo $producto_id;?>&user_id=<?php echo $user_id;?>&id=<?php echo $valor['id'];?>'
						title='Eliminar este Item'	onclick="return confirm('Est&aacute; seguro de eliminar este Item?');">
						<img src='<?php echo ADMIN;?>img/del.gif' border='0' style='margin-right:10px;'/></a>
					
					<a href='aviso_inscripcion.html.php?accion=editar&producto_id=<?php echo $producto_id;?>&user_id=<?php echo $user_id;?>&id=<?php echo $valor['id'];?>'
						title='Editar este Item'><img src='<?php echo ADMIN;?>img/edit.gif' border='0' /></a>
						
				</td>
			
				<td >
					<?php if($valor['tipo_campo']==0){
						echo "<b>{$valor['etiqueta']}</b>";
						} else {
						echo $valor['etiqueta'];
						}
					?>
				</td>
				<td style="width:150px;text-align:right;"><?php echo $tipocampo[$valor['tipo_campo']];?></td>
			</tr>
			</table>
		</li>
		
		<?php } //endofreach ?>
	</ul>
	<?php } ?>
	
	
</table>	

<script>
$(document).ready(function(){  

    $("#test-list").sortable({
      handle : '.handle',
      update : function () {
		var order = $('#test-list').sortable('serialize');
		$("#info").load("<?php echo URL;?>/account/aviso_inscripcion.html.php?producto_id=<?php echo $producto_id;?>&user_id=<?php echo $user_id;?>&"+order);
      }
    });
	
	$("#ftipocampo").change(function(event){
		
		var j_tipocampo = $('#ftipocampo option:selected').val();	

/*
	$tipocampo[0] = 'Título separador';
	$tipocampo[1] = 'Texto';
	$tipocampo[2] = 'Area de Texto';
	$tipocampo[3] = 'Select';
	$tipocampo[4] = 'Boton Radio';
	$tipocampo[5] = 'CheckBox';
	$tipocampo[6] = 'Tabla de Aranceles';
*/

		
		if( j_tipocampo==0 ){
			//-----------------------------Titulo
			$('#fvalores').val('');
			$('#fvalores').prop('disabled', true);
		} else if( j_tipocampo==1 ){
			//-----------------------------Texto
			$('#fvalores').val('');
			$('#fvalores').prop('disabled', true);
		} else if( j_tipocampo==2 ){
			//-----------------------------Area de Texto
			$('#fvalores').prop('disabled', false);
		} else if( j_tipocampo==3 ){
			//-----------------------------Select
			$('#fvalores').prop('disabled', false);
		} else if( j_tipocampo==4 ){
			//-----------------------------Radio
			$('#fvalores').prop('disabled', false);
		} else if( j_tipocampo==5 ){
			//-----------------------------Check
			$('#fvalores').prop('disabled', false);
		}
	
	});
	
	
	

	
});
</script>
