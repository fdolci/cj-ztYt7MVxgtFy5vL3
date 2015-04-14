<?php
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }
    $xaccion = request('xaccion','');
    $id      = request('id',0);
        
    if (isset($_POST['agregar'])) {
        $nombre = request('nombre','');
        $alto   = request('alto',0);
        $ancho  = request('ancho',0);

        $data = $_POST['data'];
        
        foreach ($data as $key => $value ) {
            if (trim($value['imagen']) == ''){
                unset ($data[$key]);
            }
        }    

	} elseif (isset($_POST['guardar'])) {
        $nombre = request('nombre','');
        $alto   = request('alto',0);
        $ancho  = request('ancho',0);
		
        $data = $_POST['data'];
        foreach ($data as $key => $value ) {
            $data[$key]['texto'] = htmlentities(sanitize($value['texto'],1));
            if (trim($value['imagen']) == ''){
                unset ($data[$key]);
            }
        }    
        
        //$xdata = json_encode($data);
        $xdata = serialize($data);


    	if ($id==0) { //************** ES UN BANNER  NUEVO
    		$cond  = "insert into slides (nombre, data, ancho, alto) VALUES ( '$nombre', '$xdata', '$ancho', '$alto' )";
    		$ok		= $db->Execute($cond); 	
    	
    	} else { //********************** ES UNA MODIFICACION
    		$cond  = "update slides set nombre = '$nombre', data = '$xdata', alto = '$alto', ancho = '$ancho' where id='$id'";
    		$ok		= $db->Execute($cond); 	
    	}
    	if ($ok) { $_SESSION['Msg'] = 'El Banner se guardo correctamente.';
    	} else { $_SESSION['Msg'] = $cond."<hr>".'ERROR!! No se pudo guardar el Banner.';	}
    	redirect('banner.php');
//    	die();
        

    } else {
    	$rs 	= $db->SelectLimit("select * from slides where id='$id'", 1);
    	$Nota	= $rs->FetchRow();
        $nombre = $Nota['nombre'];
        $alto   = $Nota['alto'];
        $ancho  = $Nota['ancho'];
      
    	$x	= $Nota['data'];
        if (empty($x)) {
            $data = array();
        } else {

            $xdata = unserialize($x);
          
            $x = 0;
            foreach($xdata as $value) {
                $data[$x]['imagen']         = $value['imagen'];
                $data[$x]['posicion_texto'] = $value['posicion_texto'];
                $data[$x]['texto']          = html_entity_decode($value['texto']);
                $data[$x]['href']           = $value['href'];
                $x++;
            }
        }
        
    }


/*
    data[imagen]
    data[posicion_texto]
    data[texto]
    data[href]
*/

?>

<link href="<?=RUTA;?>/css/texto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo URL;?>/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/js/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/js/ckfinder/boton_ckfinder.js"></script>

<script type="text/javascript">
function cambia_foto(cual){
    nueva = document.getElementById( 'ximagen_'+cual ).value;
    document.getElementById( 'img'+cual ).src = nueva;
}

</script>

<center>
<form name='form1' action='banner.php?accion=editar&id=<?php echo $id;?>' method='post'>
<table width='1000' cellpadding='3' cellspacing='3' border='0' style="border-width:1px; border-style:solid; border-color:#000000">
	<tr bgcolor='#0271E3' >
		<td colspan='2' align='center'>
			<span style="color:#FFFFFF; font-weight:bold; font-size:14px;">Agregar / Modificar un Banner</span></td>
	</tr>
    <tr><td colspan="2"><strong>Nombre del Banner:</strong> <input type='text' name="nombre" value="<?php echo $nombre;?>" size='80'/></td></tr>
    <tr><td colspan="2">
		<strong>Ancho del Banner:</strong> <input type='text' name="ancho" value="<?php echo $ancho;?>" size='10'/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<strong>Alto del Banner:</strong> <input type='text' name="alto" value="<?php echo $alto;?>" size='10'/>
		
	</td></tr>

    <tr><td colspan="2"><hr/></td></tr>
    <?php foreach($data as $key => $value) { ?>
    	<tr><td colspan='1'>
    		<table width='100%'>
    			<tr bgcolor='#FFFFFF' >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Imagen:</span></td>
                    <td align='left'>
                        <input type='text' name="data[<?php echo $key;?>][imagen]" id="ximagen_<?php echo $key;?>" value='<?php echo $value['imagen'];?>' size='90' maxlength='200' />
                		<input type="button" value="Buscar en el servidor" onclick="BrowseServer( 'Images:/', 'ximagen_<?php echo $key;?>' );" onblur="cambia_foto(<?php echo $key;?>);" />
                    </td>
    			</tr>
    			<tr bgcolor='#FFFFFF' >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Posición Texto:</span></td>
                    <td align='left'>
                        <select name="data[<?php echo $key;?>][posicion_texto]">
                        <option value='Izquierda' <?php echo iif($value['posicion_texto'] == 'Izquierda','selected=selected','');?>  >Izquierda</option>
                        <option value='Centro' <?php echo iif($value['posicion_texto'] == 'Centro','selected=selected','');?>  >Centro</option>
                        <option value='Derecha' <?php echo iif($value['posicion_texto'] == 'Derecha','selected=selected','');?>  >Derecha</option>
                        </select>
                    </td>
    			</tr>
    			<tr bgcolor='#FFFFFF' >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Texto:</span></td>
    				<td align='left'><textarea name="data[<?php echo $key;?>][texto]"  rows='5' cols='110'><?php echo $value['texto'];?></textarea></td>
    			</tr>
    			<tr bgcolor='#FFFFFF' >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Enlace:</span></td>
    				<td align='left'><input type='text' name="data[<?php echo $key;?>][href]" value="<?php echo $value['href'];?>" size='80'/></td>
    			</tr>
    
        	</table>
    	   </td>
            <td><img id='img<?php echo $key;?>' src="<?php echo $value['imagen'];?>" height='80' width='80' /></td>
        </tr>
        <tr><td colspan="2"><hr/></td></tr>
    <?php } ?>


    	<tr><td colspan='2'>
    		<table width='100%'>
    			<tr bgcolor='#FFFFFF' >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Imagen:</span></td>
                    <td align='left'>
                        <input type='text' name="data[<?php echo $key+1;?>][imagen]" id="ximagen_<?php echo $key+1;?>" value='' size='90' maxlength='200'/>
                		<input type="button" value="Buscar en el servidor" onclick="BrowseServer( 'Images:/', 'ximagen_<?php echo $key+1;?>' );" />
                    </td>
    			</tr>
    			<tr bgcolor='#FFFFFF' >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Posición Texto:</span></td>
                    <td align='left'>
                        <select name="data[<?php echo $key+1;?>][posicion_texto]">
                        <option value='Izquierda' >Izquierda</option>
                        <option value='Centro' >Centro</option>
                        <option value='Derecha' >Derecha</option>
                        </select>
                    </td>
    			</tr>
    			<tr bgcolor='#FFFFFF' >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Texto:</span></td>
    				<td align='left'><textarea name="data[<?php echo $key+1;?>][texto]"  rows='5' cols='110'></textarea></td>
    			</tr>
    			<tr bgcolor='#FFFFFF' >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Enlace:</span></td>
    				<td align='left'><input type='text' name="data[<?php echo $key+1;?>][href]" value="" size='80'/></td>
    			</tr>
    
        	</table>
    	</td></tr>


	<tr bgcolor='#FFFFFF' >
		<td align='center'>
			<input type='hidden' name='id' value='<?=$id;?>' />
            <input type='hidden' name='xaccion' value='Agregar_Nuevo' />
			<input type='submit' name='agregar' value='<< Agregar nuevo banner >>'/>
        </td>
		<td align='center'>
            <input type='hidden' name='xaccion' value='Guardar' />
			<input type='submit' name='guardar' value='<< Guardar los cambios >>'/>

		</td>
	</tr>
</table>
</form>
</center>