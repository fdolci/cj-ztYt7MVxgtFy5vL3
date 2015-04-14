<?php

    $item_menu[0] = 1; 
    $item_menu[1] = 10; $titulo='Redireccion URL'; $title = 'Redireccion URL';
    
	include('header.php');
    if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$submit = request('submit','');
    if (!empty($submit)) {
        
        $url_vieja = request('url_vieja','');
        $url_nueva = request('url_nueva','');
        $tipo      = request('tipo','');
        
        if (!empty($url_vieja) and !empty($url_nueva)) {
			$sql 	= "insert into redirecciones (url_vieja, url_nueva, tipo) value ('$url_vieja', '$url_nueva', '$tipo')";
			$rs 	= $db->Execute($sql);
            
        }
        
        $valor_post = request('valor','');
		foreach ($valor_post as $clave => $valor){
		    if (empty($valor['url_nueva'])) {
    			$sql 	= "delete from redirecciones where id='{$valor['id']}'";
    			$rs 	= $db->Execute($sql);
		      
		    } else {
    			$sql 	= "update redirecciones  set url_vieja='{$valor['url_vieja']}', url_nueva='{$valor['url_nueva']}', tipo='{$valor['tipo']}' where id='{$valor['id']}'";
    			$rs 	= $db->Execute($sql);
		      
		    } 
		}
        echo mensaje_ok("Los cambios se guardaron correctamente");
	}

	$sql 	= "select * from redirecciones order by url_vieja ASC";
	$rs 	= $db->Execute($sql);
	$stt	= $rs->GetRows();


?>
<h2><?php echo $titulo;?></h2>
<small>Para eliminar una redireccion, deje el campo 'Nueva URL' vacio</small>
<center>

<form action='redirigir.php' method='post'>
    <table width='100%'>
        <tr>
            <td width="350" class="th">URL Antigua</td>
            <td width='400' class="th" >URL Nueva</td>
            <td width='40' class="th">Tipo</td>
        </tr>

<?php    
	foreach ($stt as $clave => $valor){
		if ($bgcolor='#FFFFFF') {$bgcolor='#CCFFFF';} else {$bgcolor='#FFFFFF';}
?>        
        <tr>
            <td><?php echo $valor['id'];?> - 
                <input type="hidden" name="valor[<?php echo $clave;?>][id]" value="<?php echo $valor['id'];?>" />
                <input type="text" name="valor[<?php echo $clave;?>][url_vieja]" value="<?php echo $valor['url_vieja'];?>" size="40" />
            </td>        
            <td><input type="text" name="valor[<?php echo $clave;?>][url_nueva]" value="<?php echo $valor['url_nueva'];?>" size="60" /></td>
            <td><input type="text" name="valor[<?php echo $clave;?>][tipo]" value="<?php echo $valor['tipo'];?>" size="3" /></td>
        </tr>

<?php
	}
?>
		<tr>
			<td colspan="3" align="center"><br /><h2>Agregar nueva redireccion</h2></td>
		</tr>
        <tr>
            <td><input type="text" name="url_vieja" value="" size="40" /></td>
            <td><input type="text" name="url_nueva" value="<?php echo URL;?>/" size="60" /></td>
            <td><input type="text" name="tipo" value="301" size="3" /></td>
        </tr>
		<tr>
			<td colspan="3" align="center"><br />
			<input type="submit" name="submit" value="Guardar Cambios" />
			</td>
		</tr>

    </table>
</form>        
</center>
		</td>
    </tr>
</table>
</div>
</body></html>