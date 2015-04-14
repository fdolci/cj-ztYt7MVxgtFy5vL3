<?php 
    include ('../inc/config.php'); 
	
	$xdata = request('data','');
	if(empty($xdata)) { die('Hacking attemp!!'); }
/*
    $ajaxupload['tabla'] = 'productos_imagenes';
    $ajaxupload['campo'] = 'producto_id';
    $ajaxupload['id']    = $data['id'];
    $ajaxupload['cual']  = 'logo_evento';
    $ajaxupload['identificador']  = $identificador;
    $ajaxupload['donde_subir']    = SUBIR_FOTOS;
    $ajaxupload['donde_ver']      = VER_FOTOS;
    $ajaxupload['tn_ancho'] = 150;
    $ajaxupload['tn_alto']  = 110;
    $ajaxupload['ancho']    = 640;
    $ajaxupload['alto']     = 480;
*/	
	//$data = unserialize( base64_decode($xdata) ); 
	$data = json_decode($xdata,true ); 

    $sql  = "select * from {$data['tabla']} where {$data['campo']}='{$data['id']}' and cual='{$data['cual']}' and {$data['campo']}>0 ";
	$rs   = $db->SelectLimit($sql,1) ;
    $Foto = $rs->FetchRow();
		
    $producto_id = $data['id'];
    $user_id     = $data['user_id'];
    $accion      = request('accion','');
    
	
	switch ($accion) {
	    case 'guardar':
			if ($_FILES['imagen']['size'] != 0){
				$z             = explode('.',$_FILES['imagen']['name']);
				$extension     = strtolower( end($z) );
				$NombreArchivo = $user_id.'-'.$producto_id.'-'.time().'.'.$extension;

				if (! move_uploaded_file ($_FILES['imagen']['tmp_name'], $data['donde_subir']."/".$NombreArchivo)) {
					echo "<hr>ERROR al subir el archivo<HR>";
				} else {
				
					//---------------------- Ajustamos el tamaño de la imagen
					$ruta_imagen = $data['donde_subir']."/".$NombreArchivo;
					$im = imagecreatefromjpeg("$ruta_imagen");

					//Original sizes
					$ow = imagesx($im); 
					$oh = imagesy($im);

				    $width = $data['ancho'];
					$alto  = $data['alto'];
					//To fit the image in the new box by cropping data from the image, i have to check the biggest prop. in height and width
					if($width/$ow > $alto/$oh) {
						$nw = $width;
						$nh = ($oh*$nw)/$ow;
						$px = 0;
						$py = ($alto-$nh)/2;
					} else {
						$nh = $alto;
						$nw = ($ow * $nh) / $oh;
						$py = 0;
						$px = ($width-$nw) / 2;
					}
				   
					//Create a new image width requested size
					$new = imagecreatetruecolor($width,$alto);
				   
					//Copy the image loosing the least space
					imagecopyresampled($new, $im, $px, $py, 0, 0, $nw, $nh, $ow, $oh);
					$ok = imagejpeg( $new, $data['donde_subir'].'/'.$NombreArchivo, 90 );


					$foto = array();
					$foto['id']               = 0;
					$foto['imagen']           = $NombreArchivo;
					$foto["{$data['campo']}"] = $data['id'];
					$foto['cual']             = $data['cual'];
					$foto['identificador']    = $data['identificador'];

					$ok = $db->AutoExecute("{$data['tabla']}", $foto, 'INSERT');     
					
					$sql  = "select * from {$data['tabla']} where {$data['campo']}='{$data['id']}' and cual='{$data['cual']}' and {$data['campo']}>0 ";
					$rs   = $db->SelectLimit($sql,1) ;
					$Foto = $rs->FetchRow();
					
				}

			}

	        break;
	
		case 'eliminar':
		
			$id = $Foto['id'];
			$sql = "delete from {$data['tabla']} where id='$id' ";
			$rs  = $db->Execute($sql);
			
			unlink($data['donde_subir']."/".$Foto['imagen']);
			
			$sql  = "select * from {$data['tabla']} where {$data['campo']}='{$data['id']}' and cual='{$data['cual']}' and {$data['campo']}>0 ";
			$rs   = $db->SelectLimit($sql,1) ;
			$Foto = $rs->FetchRow();
			
			break;
	
	}

?>	
<form name='archivos' action='<?php echo URL;?>/account/upload.php' method='post' enctype="multipart/form-data" >
	<table>
		<tr>
			<td style='width:100px;height:100px;' rowspan='2'>
				<?php if(!empty($Foto['imagen'])){ ?>
					<img src='<?php echo $data['donde_ver'].'/'.$Foto['imagen'];?>' style='max-width:600px;max-height:100px;' />
				<?php } else { ?>
					<img src='<?php echo $data['donde_ver'].'/sinfoto.jpg';?>' style='width:100px;height:100px;' />
				<?php } ?>
			</td>
			<td>
				<?php if(empty($Foto['imagen'])){ ?>
					<input type='file' name='imagen' id='imagen' value='' style='padding:3px; height:30px; display:inline-block;'/>
					<br><small>Tamaño máximo permitido: 2Mb. <i>Ancho: <?php echo $data['ancho'];?>px - Alto:<?php echo $data['alto'];?>px</i> </small>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php if(empty($Foto['imagen'])){ ?>
					<input type='hidden' name='data' value='<?php echo $xdata;?>' />
					<input type='hidden' name='accion' value='guardar' />
					<input type='submit' name='subir_foto' value='Subir Imagen' style='float:right;padding:3px;height:30px;cursor:pointer;'/>	
				<?php } else {?>
					<a href='<?php echo URL;?>/account/upload.php?data=<?php echo $xdata;?>&accion=eliminar' title='Eliminar la imagen'
					onclick="return confirm('Confirma eliminar esta imagen?');">
					<img src='<?php echo URL;?>/img/del.gif' style='float:left;cursor:pointer;padding:6px;background:#F1F1F1;border:1px solid #333;border-radius:4px;' id='eliminar_foto'>
					</a>
				<?php } ?>
			</td>
		</tr>
	</table>
</form>