<?php

    $item_menu[0] = 4; $item_menu[1] = 1;  $title = 'Grupos';
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$id     		= request('id',0);
	$accion 		= request('accion','listar');

?>

<table width='100%'>
<tr>
	<td><h2>Grupos de Usuarios</h2></td>
	<td align='right'>
	</td>
</tr>
</table>

<?php

    $nombre = '';
	switch ($accion) {
		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from grupos where id='$id' and activo=0";
			$ok		= $db->Execute($cond);
			if ($ok) { echo mensaje_ok("El Grupo se elimin&oacute; correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudo eliminar el Grupo."); }
			$id=0;
			break;

		case 'estado': /******************************************************************************** ESTADO *********************/
			// Cambio el estado: activo/inactivo
		    if ($id > 1) {
				$cond 	= "select * from grupos where id=".$id;
				$rs 	= $db->SelectLimit($cond, 1);
				$Grupo	= $rs->FetchRow();
				if ($Grupo['activo'] == 1) {$Grupo['activo'] = 0;} else {$Grupo['activo'] = 1;}
				$cond 	= "update grupos set activo={$Grupo['activo']} where id=$id";
				$ok		= $db->Execute($cond);
				$accion = 'listar';
		    }
            $id = 0;
			break;

		case 'default': /******************************************************************************** DEFAULT *********************/
			// Especifica elgupo por defecto
			$ok 	= $db->Execute("update grupos set defecto=0");

			$cond 	= "update grupos set defecto='1', activo='1' where id=$id";
			$ok		= $db->Execute($cond);
			$accion = 'listar';
            $id = 0;
			break;

		case 'comentarista': /*********************************************** GRUPO PARA LOS COMENTARISTAS DEL BLOG *********************/
			// Especifica elgupo por defecto
			$ok 	= $db->Execute("update grupos set comentarista=0");

			$cond 	= "update grupos set comentarista='1', activo='1' where id='$id'";
			$ok		= $db->Execute($cond);
			$accion = 'listar';
            $id = 0;
			break;

		case 'suscriptor': /*********************************************** GRUPO PARA LOS SUSCRIPTORES *********************/

			$ok 	= $db->Execute("update grupos set suscriptores=0");

			$cond 	= "update grupos set suscriptores='1', activo='1' where id='$id'";
			$ok		= $db->Execute($cond);
			$accion = 'listar';
            $id = 0;
			break;


		case 'guardar': /******************************************************************************** GRABARNUEVA *********************/
			$nombre  = request('nombre','');
			$id      = request('id',0);
		
			if ($id==0){
				$sql = "insert into grupos (nombre) values ('$nombre')";				
			} else {
				$sql = " update grupos set nombre='$nombre' where id='$id'";
			}
			$ok 	= $db->Execute($sql);
			if ($ok) { echo mensaje_ok("Los datos se guardaron correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudieron guardar los datos, intente nuevamente."); }

			$id=0;
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
			$cond 	= "select * from grupos where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$grupo	= $rs->FetchRow();
            $nombre = $grupo['nombre'];
		
			break;

	}


	$sql="select * from grupos order by nombre ASC";
	$rs = $db->Execute($sql);
	$grupos = $rs->GetRows();

?>
	<table width='650' border='0' cellpadding='8' cellspacing='0'>
		<tr >
			<th width='10' class='th' >Editar</th>			
			<th width='10' class='th' >Activar</th>						
			<th width='10' class='th' >Defecto</th>			
			<th width='10' class='th' >Comentaristas</th>			
			<th width='10' class='th' >Suscriptores</th>			
			<th width='330' class='th'>Grupo</th>
            <th width='20' class='th'>Usuarios</th>
            <th width='100' class='th'>Integrantes</th>
            <th width='10' class='th' >Eliminar</th>
		</tr>
<?php 
	foreach($grupos as $grupo) { 
    	$sql="select count(id) as cuantos from usuarios_grupos where grupo_id = '{$grupo['id']}'";
    	$rs = $db->Execute($sql);
    	$x = $rs->FetchRow();
        $cuantos_usuarios = $x['cuantos'];
	   
		if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
?>
		
		<tr bgcolor="<?php echo $color;?>">
			<td align='center' nowrap='nowrap'>
				<a href='grupos.php?accion=editar&id=<?php echo $grupo['id'];?>' title='Editar este Registro'>
					<img src='img/edit.gif' border='0' style="margin-top:7px;" /></a>
			</td>
			<td align='center' nowrap='nowrap'>
                <?php if ($grupo['activo']==1 ) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
                <?php if ($grupo['defecto']==0){ ?>
                    <a href='grupos.php?accion=estado&id=<?php echo $grupo[id];?>'
        			 title='Activar/Desactivar este Grupo'>
                     <img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0'/></a>
                <?php } else { ?>
					<img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0'/>
            	<?php } ?>
			</td>
			<td align='center' nowrap='nowrap'>
                <?php if ($grupo['defecto']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
                    <a href='grupos.php?accion=default&id=<?php echo $grupo[id];?>' title='Establecer como Grupo por Defecto'>
                     <img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0'/></a>
			</td>
			<td align='center' nowrap='nowrap'>
                <?php if ($grupo['comentarista']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
                    <a href='grupos.php?accion=comentarista&id=<?php echo $grupo[id];?>' title='Grupo para los Comentaristas'>
                     <img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0'/></a>
			</td>

			<td align='center' nowrap='nowrap'>
                <?php if ($grupo['suscriptores']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
                    <a href='grupos.php?accion=suscriptor&id=<?php echo $grupo[id];?>' title='Grupo para los suscriptores'>
                     <img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0'/></a>
			</td>

			<td ><?php echo $grupo['nombre'];?></td>
            <td align='right'><?php echo $cuantos_usuarios;?></td>
            <td align='center'><a href="usuarios.php?grupo=<?php echo $grupo['id'];?>" >Ver</a>
            </td>
			<td align='center' nowrap='nowrap'>
				<?php if ($cuantos_usuarios == 0 and $grupo['activo']==0  and $grupo['id']>1) { ?>
					<a href='grupos.php?accion=eliminar&id=<?php echo $grupo['id'];?>' title='Eliminar este Registro'
						onclick="return confirm('Est&aacute; seguro de eliminar este Registro?');">
						<img src='img/del.gif' border='0' />
					</a>
				<?php } else { ?>
					<img src='img/del_inactivo.gif' border='0' title='Para eliminarlo, el grupo debe estar inactivo y sin integrantes'/>
				<?php } ?>
			</td>

		</tr>

<?php } ?>
	</table>

<?php echo "<br><h2>".iif($id>0, 'Modificacion de Datos','Crear un nuevo grupo')."</h2>";?>
	<form action='grupos.php' method='post'>
	<table>
		<tr>
			<td>Nombre:</td>
			<td>
				<input type='text' name='nombre' value='<?php echo $nombre;?>' style="width:250px;" class='required'/>
			</td>
		<tr>
			<td colspan='2'>
				<input type='hidden' name='accion' value='guardar' />
				<input type='hidden' name='id' value='<?php echo $id;?>' />
				<input type='submit' name='submit' value='Guardar Cambios' />
			</td>
		</tr>
	</table>
	</form>

<?php include('footer.php');