<?php

    $item_menu[0] = 1; $item_menu[1] = 1;  $title = 'Administradores';
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }



	$id     		= request('id',0);
	$accion 		= request('accion','listar');

?>

<table width='100%'>
<tr>
	<td><h2>Listado de Administradores</h2></td>
	<td align='right'>
	</td>
</tr>
</table>

<?php


	switch ($accion) {
		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from admin where id='$id'";
			$rs 	= $db->SelectLimit($cond, 1);
			$ok		= $db->Execute($cond);
			if ($ok) { echo mensaje_ok("El Administrador se elimin&oacute; correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudo eliminar el Administrador."); }
			$id=0;
			break;

		case 'guardar': /******************************************************************************** GRABARNUEVA *********************/
			$nombre  = request('nombre','');
			$usuario = request('usuario','');
			$clave   = request('clave','');
            $pwd_md5 = md5($clave);
			$email   = request('email','');
			$id      = request('id',0);
			
			if ($id==0){
				$sql = "insert into admin (username, nombre, password, email, pwd_md5 ) values (";
				$sql.= "'$usuario', '$nombre', '$clave', '$email', '$pwd_md5')";				
			} else {
				$sql = " update admin set nombre='$nombre', username='$usuario', password='$clave', email='$email', pwd_md5 = '$pwd_md5' ";
				$sql.= " where id='$id'";
			}
			$ok 	= $db->Execute($sql);
			if ($ok) { echo mensaje_ok("Los datos se guardaron correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudieron guardar los datos, intente nuevamente."); }

			$id=0;
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
			$cond 	= "select * from admin where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Reg	= $rs->FetchRow();
		
			break;

	}


	$sql="select * from admin where id>1 order by nombre ASC";
	$rs = $db->Execute($sql);
	$Camaras = $rs->GetRows();

?>
	<table width='100%' border='0' cellpadding='8' cellspacing='0'>
		<tr >
			<th width='70' class='th' >Acción</th>
			<th width='50' class='th'>Usuario</th>
			<th width='50' class='th'>Password</th>            
			<th  class='th'>Nombre y Apellido</th>
			<th width='20' class='th'>Email</th>
		</tr>
<?php 
	foreach($Camaras as $c) { 
		if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
?>
		
		<tr bgcolor="<?=$color;?>">
			<td align='center' nowrap='nowrap'>
				<a href='administradores.php?accion=eliminar&id=<?=$c['id'];?>' title='Eliminar este Registro'
					onclick="return confirm('Est&aacute; seguro de eliminar este Registro?');">
					<img src='img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;
				<a href='administradores.php?accion=editar&id=<?=$c['id'];?>' title='Editar este Registro'>
					<img src='img/edit.gif' border='0' style="margin-top:7px;" /></a>
					
			</td>
			<td ><?=$c['username'];?></td>
			<td ><?=$c['password'];?>&nbsp;</td>
			<td ><?=$c['nombre'];?>&nbsp;</td>
			<td ><?=$c['email'];?>&nbsp;</td>
		</tr>

<?php } ?>
	</table>

<?php echo "<br><h2>".iif($id>0, 'Modificacion de Datos','Crear un nuevo administrador')."</h2>";?>
	<form action='administradores.php' method='post'>
	<table>
		<tr>
			<td>Usuario:</td>
			<td>
				<input type='text' name='usuario' value='<?=$Reg['username'];?>' />
			</td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type='text' name='clave' value='<?=$Reg['password'];?>' /></td>
		</tr>
		<tr>
			<td>Nombre y Apellido:</td>
			<td><input type='text' name='nombre' value='<?=$Reg['nombre'];?>' size='50' /></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type='text' name='email' value='<?=$Reg['email'];?>' size='50' /></td>
		</tr>
		<tr>
			<td colspan='2'>
				<input type='hidden' name='accion' value='guardar' />
				<input type='hidden' name='id' value='<?=$id;?>' />
				<input type='submit' name='submit' value='Guardar Cambios' />
			</td>
		</tr>
	</table>
	</form>

<?php include('footer.php');