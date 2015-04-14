<?php
    $item_menu[0]   = 1; 
    $panel          = 2;
    $item_menu[1]   = 4;
    $title = 'Meta Tags';
    $titulo         = 'Configuración de Meta Tags por defecto';    
    
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
        }
        
        $serializado = serialize($valor);
        
		$sql 	= "update setting  set valor = '".$serializado."' where name='meta_tags'";
		$rs 	= $db->Execute($sql);

        echo mensaje_ok("Los cambios se guardaron correctamente");
	}

	$sql 	= "select * from setting where name='meta_tags' order by orden ASC";
	$rs 	= $db->SelectLimit($sql,1);
	$rs	= $rs->FetchRow();

    if (!empty($rs['valor'])) {
        $rs['valor'] = unserialize($rs['valor']);
    }
//pr($rs);
?>
<h2><?=$titulo;?></h2>
Para eliminar un meta tag, simplemente deje vacio el campo 'Nombre' y presione 'Guardar Cambios'
<center>
<?php

	echo "<table width='800'>\n";
	echo "<form action='meta_tags.php' method='post'>\n";
	if (!empty($rs['valor'])) {
        foreach ($rs['valor'] as $clave => $valor){
    		if ($bgcolor='#FFFFFF') {$bgcolor='#CCFFFF';} else {$bgcolor='#FFFFFF';}
    		echo "<tr>\n";
    		echo '<td width="300" valign="top" class="th" style="text-align:right;padding-right:5px;font-size:14px;">'.$valor['nombre']."<br/><br>";
            echo "</td>\n";
    		echo "<td width='500'><table>";
            echo "<tr><td align='right'><strong>Nombre:</strong></td><td> <input type='text' name='valor[".$clave."][nombre]' size='40' value='".$valor['nombre']."' /></td></tr>";
            echo "<tr><td align='right'><strong>".$Idiomas[0]['name'].":</strong></td><td> <input type='text' name='valor[".$clave."][idioma1]' size='60' value='".$valor['idioma1']."' /></td></tr>";
            if (!empty($Idiomas[1]['name'])) {
                echo "<tr><td align='right'><strong>".$Idiomas[1]['name'].":</strong></td><td> <input type='text' name='valor[".$clave."][idioma2]' size='60' value='".$valor['idioma2']."' /></td></tr>";    
            } else {
                echo "<input type='hidden' name='valor[".$clave."][idioma2]' size='60' value='' />";
            }
            if (!empty($Idiomas[2]['name'])) {
                echo "<tr><td align='right'><strong>".$Idiomas[2]['name'].":</strong></td><td> <input type='text' name='valor[".$clave."][idioma3]' size='60' value='".$valor['idioma3']."' /></td></tr>";    
            } else {
                echo "<input type='hidden' name='valor[".$clave."][idioma3]' size='60' value='' />";
            }
            if (!empty($Idiomas[3]['name'])) {
                echo "<tr><td align='right'><strong>".$Idiomas[3]['name'].":</strong></td><td> <input type='text' name='valor[".$clave."][idioma4]' size='60' value='".$valor['idioma4']."' /></td></tr>";    
            } else {
                echo "<input type='hidden' name='valor[".$clave."][idioma4]' size='60' value='' />";
            }
            if (!empty($Idiomas[4]['name'])) {
                echo "<tr><td align='right'><strong>".$Idiomas[4]['name'].":</strong></td><td> <input type='text' name='valor[".$clave."][idioma5]' size='60' value='".$valor['idioma5']."' /></td></tr>";    
            } else {
                echo "<input type='hidden' name='valor[".$clave."][idioma5]' size='60' value='' />";
            }


            echo "</table></td>\n";
    		echo "</tr>\n";
            echo "<tr><td colspan='3'><hr></td></tr>";
    
    	}
    }
?>
		<tr>
		<td width="300" valign="top" class="th" style="text-align:right;padding-right:5px;font-size:14px;">Agregar Nuevo Meta Tag</td>
		<td width='500'><table>
        <tr><td align='right'><strong>Nombre:</strong></td><td> <input type='text' name="nuevo[nombre]" size='40' value='' /></td></tr>
        <tr><td align='right'><strong><?=$Idiomas[0]['name'];?>:</strong></td><td> <input type='text' name='nuevo[idioma1]' size='60' value='' /></td></tr>
<?php
        if (!empty($Idiomas[1]['name'])) {
            echo "<tr><td align='right'><strong>".$Idiomas[1]['name'].":</strong></td><td> <input type='text' name='nuevo[idioma2]' size='60' value='' /></td></tr>";    
        } else {
            echo "<input type='hidden' name='nuevo[idioma2]' size='60' value='' />";
        }
        if (!empty($Idiomas[2]['name'])) {
            echo "<tr><td align='right'><strong>".$Idiomas[2]['name'].":</strong></td><td> <input type='text' name='nuevo[idioma3]' size='60' value='' /></td></tr>";    
        } else {
            echo "<input type='hidden' name='nuevo[idioma3]' size='60' value='' />";
        }
        if (!empty($Idiomas[3]['name'])) {
            echo "<tr><td align='right'><strong>".$Idiomas[3]['name'].":</strong></td><td> <input type='text' name='nuevo[idioma4]' size='60' value='' /></td></tr>";    
        } else {
            echo "<input type='hidden' name='nuevo[idioma4]' size='60' value='' />";
        }
        if (!empty($Idiomas[4]['name'])) {
            echo "<tr><td align='right'><strong>".$Idiomas[4]['name'].":</strong></td><td> <input type='text' name='nuevo[idioma5]' size='60' value='' /></td></tr>";    
        } else {
            echo "<input type='hidden' name='nuevo[idioma5]' size='60' value='' />";
        }

?>
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