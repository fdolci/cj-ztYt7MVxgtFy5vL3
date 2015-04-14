<?php
    $item_menu[0]   = 1; 
    $panel          = 6;
    $item_menu[1]   = 9;
    $title = 'Configuracion del Sitio';
    $titulo         = 'Configuración General del Sitio';    
    
	include('header.php');
	if ($_SESSION['god'] != 1 ) {redirect("login.php");	exit(); }


	$submit = request('submit','');
    
    if (!empty($submit)) {
        $nuevo = $_POST['nuevo'];
        $valor = request('valor','');
        if (!empty($nuevo['nombre'])) {
            $clave = saca_espacios($nuevo['nombre']);
            $valor[$clave] = $nuevo;   
        }

        foreach($valor as $clave=>$contenido) {

            if (empty($contenido['valor'])) {
                unset($valor[$clave]);
            }

        }
        
        $serializado = serialize($valor);
        
		$sql 	= "update setting  set valor = '".$serializado."' where name='seteo_general'";
		$rs 	= $db->Execute($sql);

        echo mensaje_ok("Los cambios se guardaron correctamente");
	}

	$sql 	= "select * from setting where name='seteo_general' order by orden ASC";
	$rs 	= $db->SelectLimit($sql,1);
	$rs	= $rs->FetchRow();

    if (!empty($rs['valor'])) {
        $rs['valor'] = unserialize($rs['valor']);
    }
//pr($rs);
?>
<h2><?php echo $titulo;?></h2>
Configuraciones Generales del Sitio
<center>

<form action='seteo_general.php' method='post'>
	<table width='400' border='0'>
	<?php
	if (!empty($rs['valor'])) {
        foreach ($rs['valor'] as $clave => $valor){
    		if ($bgcolor=='#CCFFFF') {$bgcolor='#FFF';} else {$bgcolor='#CCFFFF';}
			?>
				<tr bgcolor="<?php echo $bgcolor;?>" style="height:30px;">
					<td align='right' width='200'> <b><?php echo $valor['nombre'];?></b></td>
					<td>
						<input type='hidden' name='valor[<?php echo $clave;?>][nombre]' value='<?php echo $valor['nombre'];?>' />
						<input type='text' name='valor[<?php echo $clave;?>][valor]' size='20' value='<?php echo $valor['valor'];?>' />
					</td>
				</tr>
		<?php } ?>
           

	<?php } ?>	
	</table>

	<h2>Agregar Nuevo Valor</h2>
	<table>
		<tr>
			<td align='right'> <input type='text' name='nuevo[nombre]' size='20' value='' /></td>
			<td align='left'> <input type='text' name='nuevo[valor]' size='20' value='' /></td>
		</tr>

		<tr>
			<td colspan="2" align="center"><br />
            <input type="hidden" name="panel" value="<?=$panel;?>" />
			<input type="submit" name="submit" value="Guardar Cambios" />
			</td>
		</tr>
	</table>
<form>
</center>

</div>
</body></html>