<?php
    include ('../inc/config.php'); 
	
  
    $producto_id = request('producto_id',0);
    $accion      = request('accion','');
    $id          = request('id',0);


	if(isset($_GET['listItem'])){ 
		$accion = 'ordenar';
	}

/*
	if( !$login or $producto_id==0 ) { 
        $Mensaje["mensaje"]   = $Traducciones['login_requerido'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['login']    = '';
        echo "<h1>Error, acceso solo a usuarios registrados!!";
        die();  
    }
*/
    $rs      = $db->SelectLimit( "select user_id from productos where id='$producto_id'" ,1);
    $x       = $rs->FetchRow();
    $user_id = $x['user_id'];

	switch ($accion) {
	    case 'guardar':
		    if($_POST){
		    	$data = $_POST;

				if ($_FILES['archivo']['size'] != 0){
					$z             = explode('.',$_FILES['archivo']['name']);
					$extension     = strtolower( end($z) );
					$NombreArchivo = $user_id.'-'.$producto_id.'-'.time().'.'.$extension;

					if (! move_uploaded_file ($_FILES['archivo']['tmp_name'], SUBIR_ARCHIVOS."/".$NombreArchivo)) {
						echo "<hr>ERROR al subir el archivo<HR>";
					} else {
						$data['archivo'] = $NombreArchivo;
					}

				}

				$data['user_id'] = $user_id;

				unset($data['subir_foto']);
				unset($data['accion']);
				$db->debug = false;
		        $ok = $db->Replace('productos_archivos', $data,'id', $autoquote = true); 

		        unset($data);

		    }
		    $id = 0;
	        break;

	    case 'estado':
	    	$rs = $db->SelectLimit("select activo from productos_archivos where id='$id'",1);
	    	$x  = $rs->FetchRow();
	    	$estado = iif($x['activo']==1,0,1);

	    	$ok = $db->Execute("update productos_archivos set activo='$estado' where id='$id'");
			$id = 0;	        
	        break;

	    case 'editar':
	    	$rs = $db->SelectLimit("select * from productos_archivos where id='$id'",1);
	    	$data  = $rs->FetchRow();
	        break;

	    case 'eliminar':
	    	$rs = $db->SelectLimit("select archivo from productos_archivos where id='$id'",1);
	    	$x  = $rs->FetchRow();
	    	$archivo = $x['archivo'];

	    	$ok = $db->Execute("delete from productos_archivos where id='$id'");

	    	if (file_exists ( SUBIR_ARCHIVOS.'/'.$archivo) ) {
	    		unlink(SUBIR_ARCHIVOS.'/'.$archivo);
	    	}

			$id = 0;	        
	        break;

	    case 'ordenar':

	    	foreach($_GET['listItem'] as $clave=>$valor){
				$ok = $db->Execute("update productos_archivos set orden='$clave' where id='$valor'");	    		
	    	}
	    	die();
			$id = 0;	        
	        break;

	}




	$sql = "select * from productos_archivos where producto_id='$producto_id' and user_id='$user_id' order by orden ASC";
	$rs  = $db->Execute($sql);
    $ax = $rs->GetRows();

?>

<script type="text/javascript" src="<?php echo URL;?>/js/jquery-1.9.1.min.js"></script>
<link href="<?php echo URL;?>/js/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"  >
<script src="<?php echo URL;?>/js/bootstrap/js/bootstrap.min.js"></script>

<form name='archivos' action='<?php echo URL;?>/account/aviso_descargas.html.php?producto_id=<?php echo $producto_id;?>' method='post' enctype="multipart/form-data" >
<fieldset>
	<label for='titulo' style='display:inline-block;line-height:30px;height:30px;'>Título del Documento:</label>
	<input type='text' name='titulo' id='titulo' value='<?php echo $data['titulo'];?>' style='padding:3px; line-height:30px; height:30px; display:inline-block;width:300px;'/>
</fieldset>

<fieldset>
	<label for='descripcion' style='line-height:30px;height:30px;display:inline-block;'>Descripción:</label>
	<input type='text' name='descripcion' id='descripcion' value='<?php echo $data['descripcion'];?>' style='padding:3px; line-height:30px; height:30px; width:636px;'/>
</fieldset>

<fieldset>
	<?php if($id==0) {?>
		<input type='file' name='archivo' id='archivo' value='' style='padding:3px; height:30px; display:inline-block;'/>
		<br><small>Tamaño máximo permitido: 3Mb. <i>De ser mayor, deberá dividirlo en  varios archivos.</i></small>
	<?php } ?>
	<input type='hidden' name='producto_id' value='<?php echo $producto_id;?>' />
	<input type='hidden' name='id' value='<?php echo $data['id'];?>' />
	<input type='hidden' name='accion' value='guardar' />

	<input type='submit' name='subir_foto' value='Guardar Documento' style='float:right;padding:3px; height:30px;'/>
</fieldset>
</form>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>


<script type="text/javascript">
  // When the document is ready set up our sortable with it's inherant function(s)
  $(document).ready(function() {
    $("#test-list").sortable({
      handle : '.handle',
      update : function () {
		var order = $('#test-list').sortable('serialize');
		$("#info").load("<?php echo URL;?>/account/aviso_descargas.html.php?producto_id=<?php echo $producto_id;?>&"+order);
      }
    });
});
</script>

<style>
	#test-list {
		list-style: none;
	}

	#test-list li {
		display: block;
		padding: 20px 10px; margin-bottom: 3px;
		background-color: #efefef;
	}

	#test-list li img.handle {
		margin-right: 20px;
		cursor: move;
	}
</style>


<?php if (!empty($ax)) { ?>
	<div id="info">Waiting for update</div> 
	
	<table width='100%' style="border-width:1px; border-style:solid; border-color:#001860;" cellpadding='8' cellspacing="1">
		<tr bgcolor='#001860'>
			<td width='20' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Orden</td>
			<td width='80' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Acci&oacute;n</td>
			<td style="color:#FFFFFF; font-weight:bold; font-size:12px; width:40px;">Archivo</td>
			<td style="color:#FFFFFF; font-weight:bold; font-size:12px;">Título | Descripción</td>
			<td style="color:#FFFFFF; font-weight:bold; font-size:12px; text-align:right;">Descargas</td>
		</tr>
	</table>	
	<ul id="test-list" style='margin:0 0 10px 0;'> 	
	<?php foreach($ax as $x){ ?>
		<li id="listItem_<?php echo $x['id'];?>">
		<?php  $color = iif ($color=='#DFECFF', '#D3DFF1', '#DFECFF'); ?>

			<table width='100%' >
				<tr>

					<td width='20' style="color:#000000; font-weight:bold; font-size:12px;text-align:center;">
						<img src="<?php echo URL;?>/img/arrow.png" alt="move" width="16" height="16" class="handle" title='Arrastre para ordenar'/>
<?php /*
						<input type='text' name='data[orden][<?php echo $x[id];?>]' id='orden_<?php echo $x['id'];?>' 
							value='<?php echo $x['orden'];?>' style='padding:1px; width:40px;line-height:30px;height:30px;text-align:right;' onclick='select();'/>	
*/?>							
					</td>

					<td width='80' align='center' style="color:#000000; font-weight:bold; font-size:12px;">
						<a href='aviso_descargas.html.php?accion=eliminar&producto_id=<?php echo $producto_id;?>&id=<?php echo $x['id'];?>'
							title='Eliminar este Archivo'
							onclick="return confirm('Est&aacute; seguro de eliminar este Archivo?');">
							<img src='<?php echo ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;

						<a href='aviso_descargas.html.php?accion=estado&producto_id=<?php echo $producto_id;?>&id=<?php echo $x['id'];?>' title='Activar / Desactivar' >
							<?php if ($x['activo']==1){ echo "<img src='".ADMIN."img/activo.gif' border='0' />";
							} else { echo "<img src='".ADMIN."img/inactivo.gif' border='0' />"; }?>
						</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href='aviso_descargas.html.php?accion=editar&producto_id=<?php echo $producto_id;?>&id=<?php echo $x['id'];?>' title='Editar este Archivo'>
							<img src='<?php echo ADMIN;?>img/edit.gif' border='0' /></a>
					</td>

					<td style="text-align:center;" valign='middle'>
						<?php 
							$z     = explode('.',$x['archivo']);
							$icono = obtiene_icono(end($z));
						?>
						<img src='<?php echo $icono;?>' height='20' width='20' title="<?php $x['descripcion'];?>" />
					</td>
					<td style="color:#000000; font-weight:bold; font-size:12px;" valign='middle'>
						<?php echo $x['titulo'];?><small><br><?php echo $x['descripcion'];?></small>
					</td>
					<td style="color:#000000; font-weight:bold; font-size:12px; text-align:right;margin-right:20px;" valign='middle'>
						<?php echo $x['descargas'];?>
					</td>

				</tr>
			</table>
		</li>
	<?php  } //endforeach ?>
	<ul>

	
<?php } //endif ?>