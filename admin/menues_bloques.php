<?php
    $item_menu[0] = 3;
    $item_menu[1] = 3; 
    $title = 'Bloques de Menues';
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$submit = request('submit','');
    $accion = request('accion','');
    $id     = request('id','');
    if ($accion=='estado') {
		// Cambio el estado: activo/inactivo
		$cond 	= "select * from bloque_menu where id=".$id;
		$rs 	= $db->SelectLimit($cond, 1);
		$x	= $rs->FetchRow();
		if ($x['activo']==1) {$x['activo']=0;} else {$x['activo']=1;}
		$cond 	= "update bloque_menu set activo=".$x['activo']." where id=".$id;
		$ok		= $db->Execute($cond);

        
    } else {
        if (!empty($submit)) {
            $Bloque = $_POST['Bloque'];

    		foreach ($Bloque as $bb){
                if ($bb['id']>0) {
                    if (empty($bb['nombre'])) {
            			$sql 	= "delete from bloque_menu where id='".$bb['id']."'";
                        $rs 	= $db->Execute($sql);
                    } else {
            			$sql 	= "update bloque_menu  set nombre='".$bb['nombre']."', div_css='".$bb['div_css']."' where id='".$bb['id']."'";
                        $rs 	= $db->Execute($sql);
                    }
                } elseif (!empty($bb['nombre'])) {
        			$sql 	= "insert into bloque_menu  (nombre, div_css) values ('".$bb['nombre']."','".$bb['div_css']."')";
                    $rs 	= $db->Execute($sql);                    
                }
       			                
    		}
            echo mensaje_ok("Los cambios se guardaron correctamente");
    	}
        
    }

	$sql 	= "select * from bloque_menu order by id ASC";
	$rs 	= $db->Execute($sql);
	$stt	= $rs->GetRows();


?>
<h2><?=$title;?></h2>

    <pre>
        <u>DIV contenedor</u>: es el nombre del div a utilizar en el css (/css/menues.css)<br/>
        Para eliminar un bloque de menu, simplemente deje en blanco el nombre del mismo.
    </pre>
    

<?php

	echo "<table width='700' cellpadding='8' cellspacing='0'>\n";
	echo "<form action='menues_bloques.php' method='post'>\n";
    echo "<tr>\n";
	echo "<td width='200' class='th'>Nombre</td>\n";
	echo "<td width='20' class='th'>Estado</td>\n";
	echo "<td width='200' class='th'>DIV contenedor</td>\n";
	echo "<td width='200' class='th'>Editar items</td>\n";    
	echo "</tr>\n";

    $color='';
	foreach ($stt as $clave => $valor){
		  if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
   
		echo "<tr bgcolor='$color'>\n";
		echo '<td width="200" style="text-align:right;padding-right:5px;">';
        echo "<input type='text' name='Bloque[$clave][nombre]' value='".$valor['nombre']."'  size='10'/></td>\n";
		echo "<td width='20' align='center'>";
        echo "<input type='hidden' name='Bloque[$clave][id]' value='".$valor['id']."'/>";
        if ($valor['activo']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';}
?>
		<a href='menues_bloques.php?accion=estado&id=<?=$valor['id'];?>'
			title='Activar/Desactivar este Bloque'>
			<img src='<?=ADMIN;?><?=$imagen;?>' border='0'/></a>
<?php        
        echo "</td>\n";
		echo "<td width='200'><input type='text' name='Bloque[$clave][div_css]' value='".$valor['div_css']."'  size='30'/></td>\n";
	    echo "<td width='200' ><a href='menues.php?bloque_id=".$valor['id']."'>editar</a></td>\n";        
		echo "</tr>\n";

	}

		$clave++;
        echo "<tr>\n";
		echo '<td width="200" class="th" style="text-align:right;padding-right:5px;">';
        echo '<span style="color:white;">Nuevo: </span>';
        echo "<input type='text' name='Bloque[$clave][nombre]' value=''  size='10'/></td>\n";
		echo "<td width='20' align='center'></td>\n";
		echo "<td width='200'>";
        echo "<input type='text' name='Bloque[$clave][div_css]' value=''  size='30'/></td>\n";
		echo "</tr>\n";


?>
		<tr>
			<td colspan="4" align="center"><br />
			<input type="submit" name="submit" value="Guardar Cambios" />
			</td>
		</tr>

		</form>
		</table>

		</td>
    </tr>
</table>
</div>
</body></html>