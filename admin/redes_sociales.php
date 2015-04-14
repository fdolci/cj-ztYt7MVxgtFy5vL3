<?php
    $item_menu[0]   = 1; 
    $panel          = 5;
    $item_menu[1]   = 3;
    $title = 'Redes Sociales';
    $titulo         = 'Configuración de Redes Sociales';    
    
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$submit = request('submit','');
    if (!empty($submit)) {
        $nuevo = $_POST['nuevo'];
        $valor = $_POST['valor'];
        if (!empty($nuevo['nombre'])) {
            $clave = saca_espacios($nuevo['nombre']);
            $valor[$clave] = $nuevo;   
        }
        foreach($valor as $clave=>$contenido) {
            if (empty($contenido['nombre'])) {
                unset($valor[$clave]);
            } 
            if (!empty($contenido['script'])) {
                $script = str_replace("%3A",":",$contenido['script']);
                $script = str_replace("%2F","/",$script);
                $valor[$clave]['script'] = htmlentities($script);
            } 
        }

        $serializado = base64_encode(serialize($valor));
        
		$sql 	= "update setting  set valor = '".$serializado."' where name='redes_sociales'";
		$rs 	= $db->Execute($sql);

        echo mensaje_ok("Los cambios se guardaron correctamente");
	}

	$sql 	= "select * from setting where name='redes_sociales' order by orden ASC";
	$rs 	= $db->SelectLimit($sql,1);
	$rs	= $rs->FetchRow();

    if (!empty($rs['valor'])) {
        $rs['valor'] = unserialize(base64_decode($rs['valor']));

        foreach($rs['valor'] as $clave=>$contenido) {
            if (!empty($contenido['script'])) {
                $rs['valor'][$clave]['script'] = html_entity_decode($contenido['script']);
                $rs['valor'][$clave]['script'] = str_replace('\"','"',$rs['valor'][$clave]['script']);
                $rs['valor'][$clave]['script'] = str_replace("\'","'",$rs['valor'][$clave]['script']);
            } 
             
        }
        
    }
    

?>
<h2><?php echo $titulo;?></h2>
Para eliminar una red social, simplemente deje vacio el campo 'Nombre' y presione 'Guardar Cambios'
<script type="text/javascript" src="<?php echo URL;?>/admin/js/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/admin/boton_ckfinder.js"></script>
<center>
<?php

	echo "<table width='1000'>\n";
	echo "<form action='redes_sociales.php' method='post'>\n";
	if (!empty($rs['valor'])) {
        foreach ($rs['valor'] as $clave => $valor){
    		if ($bgcolor='#FFFFFF') {$bgcolor='#CCFFFF';} else {$bgcolor='#FFFFFF';}
?>
    		<tr>
                <td width="200" valign="top" class="th" style="text-align:right;padding-right:5px;font-size:14px;"><?php echo $valor['nombre'];?><br/><br>
                    <?php if (!empty($valor['logo'])) { echo "<img src='".$valor['logo']."'  height=50 >";} ?>
                </td>
                <td width='500' valign='top'>
                    <table>
                    <tr>
                        <td align='right'><strong>Nombre:</strong></td>
                        <td> <input type='text' name='valor[<?php echo $clave;?>][nombre]' size='40' value='<?php echo $valor['nombre'];?>' /></td>
                    </tr>
                    <tr>
                        <td align='right' nowrap><strong>ID (username):</strong></td>
                        <td> <input type='text' name='valor[<?php echo $clave;?>][username]' size='60' value='<?php echo $valor['username'];?>' /></td>
                    </tr>
                    <tr>
                        <td align='right'><strong>URL (link):</strong></td>
                        <td> <input type='text' name='valor[<?php echo $clave;?>][url]' size='60' value='<?php echo $valor['url'];?>' /></td>
                    </tr>
                    <tr>
                        <td align='right'><strong>Logo:</strong></td>
                        <td> 
                            <input type="text" name="valor[<?php echo $clave;?>][logo]" id="thumbs<?php echo $clave;?>" size='90' maxlength='255' value="<?php echo $valor['logo'];?>" />
                            <input type="button" value="Buscar en el servidor" onclick="BrowseServer( 'Images:/', 'thumbs<?php echo $clave;?>' );" />
                    </tr>
<?php /*
                    <tr>
                        <td align='right'><strong>Script :</strong></td>
                        <td> <textarea name='valor[<?php echo $clave;?>][script]' cols='55' rows='5' ><?php echo $valor['script'];?></textarea></td>
                    </tr>
*/ ?>                    
                    </table>
                </td>
                <td valign='top'><?php echo $valor['script'];?></td>
            </tr>
            <tr><td colspan='3'><hr></td></tr>
<?php    
    	}
    }
    
?>
		<tr>
		<td width="300" valign="top" class="th" style="text-align:right;padding-right:5px;font-size:14px;">Nueva Red Social</td>
		<td width='500'><table>
        <tr><td align='right'><strong>Nombre:</strong></td><td> <input type='text' name="nuevo[nombre]" size='40' value='' /></td></tr>
        <tr><td align='right'><strong>ID (username):</strong></td><td> <input type='text' name="nuevo[username]" size='40' value='' /></td></tr>        
        <tr><td align='right'><strong>URL (link):</strong></td><td><input type='text' name="nuevo[url]" size='60' value='' /></td></tr>
        <tr><td align='right'><strong>Logo (url absoluta):</strong></td><td><input type='text' name="nuevo[logo]" size='60' value='' /></td></tr>
<?php /*
        <tr><td align='right'><strong>Script :</strong></td><td> <textarea name='nuevo[script]' cols='55' rows='5' ></textarea></td></tr>      
*/ ?>        
        </table></td>
		</tr>


		<tr>
			<td colspan="2" align="center"><br />
            <input type="hidden" name="panel" value="<?=$panel;?>" />
			<input type="submit" name="submit" value="Guardar Cambios" />
			</td>
		</tr>

		</form>
		</table>
</center>
		</td>
    </tr>
</table>
</div>
</body></html>