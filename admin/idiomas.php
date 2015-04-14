<?php
    $item_menu[0] = 1;
    $item_menu[1] = 7; 
    $title = 'Idiomas';
	include('header.php');
	
    if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }
    
    $accion = request('accion','');

    
    
	$submit = request('submit','');
    if (!empty($submit)) {
        
        if(isset($_POST['data'])) {
            $data = $_POST['data'];
    		foreach ($data as $clave => $valor){
    			$sql 	= "update idiomas  set name = '".$valor['name']."',flag = '".$valor['flag']."',errores_validacion = '".$valor['errores_validacion']."' where id='".$valor['id']."'";
    			$rs 	= $db->Execute($sql);
    		}
        } elseif(isset($_POST['guardar_var'])) {
            $variable = request('variable','');
            $idioma1  = htmlspecialchars(request('idioma1',''), ENT_QUOTES,'UTF-8');
            $idioma2  = htmlspecialchars(request('idioma2',''), ENT_QUOTES,'UTF-8');
            $idioma3  = htmlspecialchars(request('idioma3',''), ENT_QUOTES,'UTF-8');
            $idioma4  = htmlspecialchars(request('idioma4',''), ENT_QUOTES,'UTF-8');
            $idioma5  = htmlspecialchars(request('idioma5',''), ENT_QUOTES,'UTF-8');
            
            if(!empty($variable)) { // Variable nueva
                $sql = "insert into archivo_traducciones (variable, idioma1, idioma2, idioma3, idioma4, idioma5) 
                        values ('$variable', '$idioma1', '$idioma2', '$idioma3', '$idioma4', '$idioma5')";
                $rs = $db->Execute($sql);
                
            }
            $data2 = $_POST['data2'];                                    
    		foreach ($data2 as $clave => $valor){
                $sql = "update archivo_traducciones  set idioma1='{$valor['idioma1']}',idioma2='{$valor['idioma2']}',idioma3='{$valor['idioma3']}'
                        ,idioma4='{$valor['idioma4']}',idioma5='{$valor['idioma5']}' where id='{$valor['id']}'";
                $rs 	= $db->Execute($sql);
    		}
        }    
        echo mensaje_ok("Los cambios se guardaron correctamente");
	
    } elseif($accion=='default') {
	   $id  = request('id',1);
       $sql = "update idiomas  set defecto= 0";
	   $rs 	= $db->Execute($sql);
       $sql = "update idiomas  set defecto=1 where id=$id";
	   $rs 	= $db->Execute($sql);
       
    } elseif($accion=='activo') {
	    $id = request('id',1);
        $rs = $db->SelectLimit("select * from idiomas where id=$id",1);
    	$x	= $rs->FetchRow();

        if ($x['activo']==0){$activo=1;} else {$activo=0;}
	    $rs = $db->Execute("update idiomas  set activo=$activo where id=$id");
       
	}

	$sql 	= "select * from idiomas order by id ASC";
	$rs 	= $db->Execute($sql);
	$stt	= $rs->GetRows();

	$sql 	= "select * from archivo_traducciones order by variable ASC";
	$rs 	= $db->Execute($sql);
	$ArchivoTraducciones = $rs->GetRows();


?>
<h2>Idiomas</h2>
<center>
<?php if($_SESSION['god'] == 1 ) { 

	echo "<table width='700'>\n";
	echo "<form action='idiomas.php' method='post'>\n";
    echo "<tr>\n";
	echo '<td width="200" >';
	echo "<td width='200'><strong>Nombre</strong></td>\n";
	echo "<td width='200'><strong>Icono Bandera</strong></td>\n";
	echo "<td width='200'><strong>Validator Error</strong></td>\n";    
	echo "<td ><strong>Default</strong></td>\n";                
    echo "<td ><strong>Activo</strong></td>\n";
	echo "</tr>\n";

	foreach ($stt as $clave => $valor){
	   
		if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
		echo "<tr bgcolor='$color'>\n";
		echo '<td width="200" style="color:#000;text-align:right;padding-right:5px;background-color:'.$color.'"><b>Idioma '.$valor['id']."</b>\n";
		echo "<input type='hidden' name='data[$clave][id]' value='".$valor['id']."' />";
        echo "<td width='200'><input type='text' name='data[$clave][name]' value='".$valor['name']."' size='30'/></td>\n";
		echo "<td width='200'><input type='text' name='data[$clave][flag]' value='".$valor['flag']."'  size='30'/></td>\n";
        echo "<td width='200'><input type='text' name='data[$clave][errores_validacion]' value='".$valor['errores_validacion']."'  size='30'/></td>\n";
		echo "<td align='center'>";
        if($valor['activo']==1) {
            if ($valor['defecto']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} 
            echo "<a href='idiomas.php?accion=default&id=".$valor['id']."' title='Establecer como predeterminado'><img src='".ADMIN.$imagen."' border='0'/></a>";
        }
        echo "</td>\n";                
		echo "<td align='center'>";
        if ($valor['activo']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} 
        echo "<a href='idiomas.php?accion=activo&id=".$valor['id']."' title='Activar este idioma'><img src='".ADMIN.$imagen."' border='0'/></a>";
        echo "</td>\n";                

		echo "</tr>\n";

	}
?>
		<tr>
			<td colspan="4" align="center"><br />
			<input type="submit" name="submit" value="Guardar Cambios" />
			</td>
		</tr>

		</form>
		</table>
<?php } ?>        
        <form action='idiomas.php' method='post'>
        <table  border='0' cellpadding='8' cellspacing='0'>
            <tr>
                <td width="100" class="th">Variable</td>
                <td class="th"  width='20%' ><?php echo $stt[0]['name'];?></td>
                <?php if($stt[1]['activo'] == 1 ) { echo "<td class='th' width='20%' >{$stt[1]['name']}</td>"; } ?>
                <?php if($stt[2]['activo'] == 1 ) { echo "<td class='th' width='20%' >{$stt[2]['name']}</td>"; } ?>
                <?php if($stt[3]['activo'] == 1 ) { echo "<td class='th' width='20%' >{$stt[3]['name']}</td>"; } ?>
                <?php if($stt[4]['activo'] == 1 ) { echo "<td class='th' width='20%' >{$stt[4]['name']}</td>"; } ?>
            </tr>

        <?php foreach($ArchivoTraducciones as $at) { 
                if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}    
        ?>
            <tr bgcolor="<?=$color;?>">
                <td><strong>
                    <?php echo $at['variable'];?></strong>
                    <input type='hidden' name='data2[<?php echo $at['id'];?>][id]' value='<?php echo $at['id'];?>'/>
                </td>
                <td><input type='text' name='data2[<?php echo $at['id'];?>][idioma1]' value='<?php echo $at['idioma1'];?>'  size='28'/></td>
                <?php if($stt[1]['activo'] == 1 ) { echo "<td ><input type='text' name='data2[{$at['id']}][idioma2]' value='{$at['idioma2']}'  size='28' /></td>"; } ?>
                <?php if($stt[2]['activo'] == 1 ) { echo "<td ><input type='text' name='data2[{$at['id']}][idioma3]' value='{$at['idioma3']}'  size='28' /></td>"; } ?>
                <?php if($stt[3]['activo'] == 1 ) { echo "<td ><input type='text' name='data2[{$at['id']}][idioma4]' value='{$at['idioma4']}'  size='28' /></td>"; } ?>
                <?php if($stt[4]['activo'] == 1 ) { echo "<td ><input type='text' name='data2[{$at['id']}][idioma5]' value='{$at['idioma5']}'  size='28' /></td>"; } ?>
            </tr>
        <?php } ?>

<?php if($_SESSION['god'] == 1 ) { ?>                    
			<tr>
                <td><input type='text' name='variable' value=''  size='20'/></td>
                <td><input type='text' name='idioma1' value=''  size='28'/></td>
                <?php if($stt[1]['activo'] == 1 ) { echo "<td ><input type='text' name='idioma2' value=''  size='28' /></td>"; } ?>
                <?php if($stt[2]['activo'] == 1 ) { echo "<td ><input type='text' name='idioma3' value=''  size='28' /></td>"; } ?>
                <?php if($stt[3]['activo'] == 1 ) { echo "<td ><input type='text' name='idioma4' value=''  size='28' /></td>"; } ?>
                <?php if($stt[4]['activo'] == 1 ) { echo "<td ><input type='text' name='idioma5' value=''  size='28' /></td>"; } ?>
            </tr>
<?php }?>       
        </table>
    	<input type="hidden" name="guardar_var" value="guardar_var" />
        <input type="submit" name="submit" value="Guardar Cambios" />

        </form>

</center>
		</td>
    </tr>
</table>

</div>
</body></html>