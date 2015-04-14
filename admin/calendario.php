<?php

	$mipath='../';
	include ('../inc/config.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }


	$dpto_id   = request('dpto_id',0);
    $tarifa_id = request('tarifa_id',0);
	$accion    = request('accion','');    

    if($dpto_id == 0) {
        echo "<h1>Debe seleccionar un Departamento</h1>";
        die();
    }


		switch ($accion) {
			case 'guardar':
	            $ingreso = request('ingreso','');
                $egreso  = request('egreso' ,'');
	            $tarifa1 = request('tarifa1','');
                $tarifa2 = request('tarifa2','');
                $tarifa3 = request('tarifa3','');
                $tarifa4 = request('tarifa4','');
                $tarifa5 = request('tarifa5','');            
	            $duracion_minima1 = request('duracion_minima1','');
                $duracion_minima2 = request('duracion_minima2','');
                $duracion_minima3 = request('duracion_minima3','');
                $duracion_minima4 = request('duracion_minima4','');
                $duracion_minima5 = request('duracion_minima5','');            


                if ($tarifa_id == 0) {
                    $cond = "insert into departamentos_tarifas (departamento_id, tarifa1,tarifa2,tarifa3,tarifa4,tarifa5,
                            duracion_minima1,duracion_minima2,duracion_minima3,duracion_minima4,duracion_minima5,
                            ingreso, egreso) values 
    				        ('$dpto_id', '$tarifa1','$tarifa2','$tarifa3','$tarifa4','$tarifa5',
                             '$duracion_minima1','$duracion_minima2','$duracion_minima3','$duracion_minima4','$duracion_minima5',
                             '$ingreso', '$egreso')";
    				$ok   = $db->Execute($cond);
                } else {
                    $cond = "update departamentos_tarifas set tarifa1='$tarifa1', tarifa2='$tarifa2',tarifa3='$tarifa3',tarifa4='$tarifa4',tarifa5='$tarifa5', 
                            duracion_minima1='$duracion_minima1', duracion_minima2='$duracion_minima2',
                            duracion_minima3='$duracion_minima3',duracion_minima4='$duracion_minima4',duracion_minima5='$duracion_minima5',
                            ingreso = '$ingreso', egreso='$egreso' where id='$tarifa_id'";
                    $ok   = $db->Execute($cond);                            
                 }

				if ($ok) {
				    $_SESSION['Msg'] = 'Los cambios se realizaron correctamente';
                } else {
				    $_SESSION['Msg'] = 'No se pudo guardar, intente nuevamente';
                }

				break;


			case 'eliminar':
				$sql = "delete from departamentos_tarifas where id='$tarifa_id'";
				$rs  = $db->Execute($sql);
				$_SESSION['Msg'] = 'Registro eliminado correctamente';
				break;

			case 'estado':
				if ($tarifa_id>0){
					$sql = "select * from departamentos_tarifas where id='$tarifa_id'";
					$rs  = $db->SelectLimit($sql,1);
					$x   = $rs->FetchRow();
					$activo = iif($x['estado']==0,1,0);
					$sql = "update departamentos_tarifas set estado='$activo' where id='$tarifa_id'";
					$rs 	= $db->Execute($sql);
				}
				break;

			case 'editar':
				if ($tarifa_id>0){
					$cond 	= "select * from departamentos_tarifas where id=".$tarifa_id;
					$rs 	= $db->SelectLimit($cond, 1);
					$Tarifa	= $rs->FetchRow();
				}

				break;

		}

?>
<link href="<?=ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>


<body style="background-color:#EEE;">
<center>
<table width='100%' style="border:1px solid #000000; background-color: none;" cellpadding='8' cellspacing="1">
	<tr bgcolor='#000'>
		<td width='80' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Ingreso</td>
		<td width='80' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Egreso</td>
        <td  align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Tarifa</td>
        <td  align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Duracion Minima</td>
        <td width='120px' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Acciones</td>        
	</tr>
<?php
	$sql = "select * from departamentos_tarifas where departamento_id='$dpto_id' order by ingreso ASC";
	$rs  = $db->Execute($sql);
    $ax = $rs->GetRows();
	if (empty($ax)) {
		echo "<tr><td colspan='4'><h3><center>No existen tarifas definidas para ese Departamento</center></h3></td></tr>";
	} else {
		foreach($ax as $x){
			if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
?>
	<tr bgcolor='<?=$color;?>' >
		<td style="color:#000000; font-weight:bold; font-size:12px;"><?=$x['ingreso'];?></td>
        <td style="color:#000000; font-weight:bold; font-size:12px;"><?=$x['egreso'];?></td>
        <td style="color:#000000; font-weight:bold; font-size:12px;"><?=$x['tarifa1'];?></td>
        <td style="color:#000000; font-weight:bold; font-size:12px;"><?=$x['duracion_minima1'];?></td>
		<td width='20' align='center' style="color:#000000; font-weight:bold; font-size:12px;">
			<a href='calendario.php?accion=eliminar&dpto_id=<?=$dpto_id;?>&tarifa_id=<?=$x[id];?>'
				title='Eliminar esta Tarifa'
				onclick="return confirm('Est&aacute; seguro de eliminar esta Tarifa?');">
				<img src='<?=ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='calendario.php?accion=estado&dpto_id=<?=$dpto_id;?>&tarifa_id=<?=$x[id];?>' title='Ocupado / Disponible' >
				<?php if ($x['estado']==1){ echo "<img src='".ADMIN."img/activo.gif' border='0' />";
				} else { echo "<img src='".ADMIN."img/inactivo.gif' border='0' />"; }
				?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='calendario.php?accion=editar&dpto_id=<?=$dpto_id;?>&tarifa_id=<?=$x[id];?>' title='Editar esta Tarifa'>
				<img src='<?=ADMIN;?>img/edit.gif' border='0' /></a>

		</td>

	</tr>


<?php

		}
	}

?>

</table>
</center>

<br/>
<center><h2>Agregar / Modificar Tarifa</h2></center>
<form name='foto' action='calendario.php?accion=<?=$accion;?>' method='post' >
<center>
<table width='60%' style="border-width:1px; border-style:solid; border-color:#000000;" cellpadding='8' cellspacing="1">
	<tr bgcolor='#000'>
		<td width='80' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Idioma</td>
		<td width='50%' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Tarifa</td>
        <td width='50%' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Duracion Minima</td>
	</tr>
    <tr>
        <td align='right'><strong>Fechas</strong></td>
        <td>Ingreso:<input type='text' name='ingreso' size='10' value='<?=$Tarifa['ingreso'];?>' /></td>
        <td>Egreso:<input type='text' name='egreso' size='10' value='<?=$Tarifa['egreso'];?>' /></td>    
    </tr>

    <tr>
        <td align='right'><strong><?=$Idiomas[0]['name'];?></strong></td>
        <td> <input type='text' name='tarifa1' size='30' value='<?=$Tarifa['tarifa1'];?>' /></td>
        <td><input type='text' name='duracion_minima1' size='30' value='<?=$Tarifa['duracion_minima1'];?>' /></td>    
    </tr>
<?php  if (!empty($Idiomas[1]['name'])) { ?>
    <tr>
        <td align='right'><strong><?=$Idiomas[1]['name'];?></strong></td>
        <td> <input type='text' name='tarifa2' size='30' value='<?=$Tarifa['tarifa2'];?>' /></td>
        <td><input type='text' name='duracion_minima2' size='30' value='<?=$Tarifa['duracion_minima2'];?>' /></td>    
    </tr>
<?php  } ?>

<?php  if (!empty($Idiomas[2]['name'])) { ?>
    <tr>
        <td align='right'><strong><?=$Idiomas[2]['name'];?></strong></td>
        <td> <input type='text' name='tarifa3' size='30' value='<?=$Tarifa['tarifa3'];?>' /></td>
        <td><input type='text' name='duracion_minima3' size='30' value='<?=$Tarifa['duracion_minima3'];?>' /></td>    
    </tr>
<?php  } ?>

<?php  if (!empty($Idiomas[3]['name'])) { ?>
    <tr>
        <td align='right'><strong><?=$Idiomas[3]['name'];?></strong></td>
        <td> <input type='text' name='tarifa4' size='30' value='<?=$Tarifa['tarifa4'];?>' /></td>
        <td><input type='text' name='duracion_minima4' size='30' value='<?=$Tarifa['duracion_minima4'];?>' /></td>    
    </tr>
<?php  } ?>

<?php  if (!empty($Idiomas[4]['name'])) { ?>
    <tr>
        <td align='right'><strong><?=$Idiomas[4]['name'];?></strong></td>
        <td> <input type='text' name='tarifa5' size='30' value='<?=$Tarifa['tarifa5'];?>' /></td>
        <td><input type='text' name='duracion_minima5' size='30' value='<?=$Tarifa['duracion_minima5'];?>' /></td>    
    </tr>
<?php  } ?>
</table>
<input type='hidden' name='accion' value='guardar' />
<input type='hidden' name='dpto_id' value='<?=$dpto_id;?>' />
<input type='hidden' name='tarifa_id' value='<?=$tarifa_id;?>' />
<input type='submit' name='subir_foto' value='Guardar' /></center>
</form>
</body>