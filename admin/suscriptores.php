<?php
    $item_menu[0] = 6; 
    $item_menu[1] = 1;  
    $title = 'Suscriptores';
	include('header.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

    $titulo         = 'Administracion de Suscriptores';    
    
	if(!empty($_SESSION['Msg'])) {
		echo '<center><div style="width:800px;height:30px;background-color:lightblue;border:2px solid blue;font-size:16px;font-weight;bold;text-align:center;margin-top:5px;padding-top:5px;color:blue;">';
		echo $_SESSION['Msg']."</div></center>";
		$_SESSION['Msg']='';
	}
    

	$id        = request('id',0);
	$accion    = request('accion','listar');
	$letra	   = request('letra','');
	$mostrar   = request('mostrar',1,'int');    



?>
<link href="<?php echo ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>
<table width='100%'>
<tr>
	<td><h2>Listado de Suscriptores Registrados</h2></td>
	<td align='right'>
	</td>
</tr>
</table>

<?php

    $Pertenece = array();
	switch ($accion) {

		case 'estado': /******************************************************************************** ESTADO *********************/
			// Cambio el estado: activo/inactivo
			$cond 	= "select * from suscriptores where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Nota	= $rs->FetchRow();
			if ($Nota['activo']==1) {$Nota['activo']=0;} else {$Nota['activo']=1;}
			$cond 	= "update suscriptores set activo=".$Nota['activo']." where id=".$id;
			$ok		= $db->Execute($cond);
			$id=0;
			break;

		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from suscriptores where id='$id'";
			$rs 	= $db->SelectLimit($cond, 1);
			$ok		= $db->Execute($cond);
			if ($ok) { echo mensaje_ok("El Suscriptor se elimin&oacute; correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudo eliminar el Suscriptor."); echo $sql; }
			$id = 0;
			break;

		case 'guardar': /******************************************************************************** GRABARNUEVA *********************/
			$email  = strtolower(request('email',''));
			$id     = request('id',0);
			
			if ($id == 0){
				$sql = "insert into suscriptores (email, activo ) values ('$email', '1' )";
                $id  = mysql_insert_id();				
			} else {
				$sql = " update suscriptores set email='$email' where id='$id'";
			}
			$ok 	= $db->Execute($sql);


			if ($ok) { echo mensaje_ok("Los datos se guardaron correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudieron guardar los datos, intente nuevamente."); echo $sql; }



			$id = 0;
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
			$cond 	= "select * from suscriptores where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Reg	= $rs->FetchRow();
            
			break;

	}

    $sql = "select count(id) as cuantos from suscriptores where activo=1";
    $rs = $db->SelectLimit($sql,1);
    $cuantos_activos = $rs->FetchRow();

    $sql = "select count(id) as cuantos from suscriptores where activo=0";
    $rs = $db->SelectLimit($sql,1);
    $cuantos_inactivos = $rs->FetchRow();

	echo "<b>Mostrar Suscriptores: ";
	echo "<a href='suscriptores.php?letra=$letra&mostrar=1' >ACTIVOS [ ".$cuantos_activos['cuantos']." ]</a> - ";
	echo "<a href='suscriptores.php?letra=$letra&mostrar=0' >INACTIVOS [ ".$cuantos_inactivos['cuantos']." ]</a> </b> <br/>";	


	
		$sql="select LEFT(TRIM(email),1) as letra from suscriptores where activo='$mostrar' group by LEFT(email,1)";
		$rs = $db->Execute($sql);
		$Letras = $rs->GetRows();
        echo "Letras: ";
		foreach($Letras as $l){
			echo "<a href='suscriptores.php?letra=$l[letra]&mostrar=$mostrar' ><b>".strtoupper($l['letra'])."</b></a> - ";
            if (empty($letra)) { $letra = $l['letra'];}
		}
    
    echo "<br/><br/>";	

	$sql="select * from suscriptores where LEFT(email,1)='$letra' and activo='$mostrar' order by email ASC";
	$rs = $db->Execute($sql);
	$Usuarios = $rs->GetRows();

?>
	<table width='100%' border='0' cellpadding='8' cellspacing='0'>
		<tr>
			<th width='70'  class='th'>Acción</th>
    		<th width='20'  class='th'>Email</th>
		</tr>
<?php 
	foreach($Usuarios as $c) { 
		if ($c['lista']==1) {$color="#FEFFCC"; } else {$color="#FFFFFF";}
?>
		
		<tr bgcolor="<?php echo $color;?>">
			<td align='center' nowrap='nowrap'>
				<a href='suscriptores.php?accion=eliminar&id=<?php echo $c['id'];?>&letra=<?php echo $letra;?>&mostrar=<?php echo $mostrar;?>' title='Eliminar este Registro'
					onclick="return confirm('Est&aacute; seguro de eliminar este Registro?');">
					<img src='img/del.gif' border='0' ></a>&nbsp;&nbsp;&nbsp;
				<a href='suscriptores.php?accion=estado&id=<?php echo $c['id'];?>&letra=<?php echo $letra;?>&mostrar=<?php echo $mostrar;?>' title='Activar/Desactivar este Registro'>
<?php				$img = iif ($c['activo']=='1','img/activo.gif','img/inactivo.gif'); ?>
					<img src='<?php echo $img;?>' border='0'  style="margin-top:7px;"></a>&nbsp;&nbsp;&nbsp;
				<a href='suscriptores.php?accion=editar&id=<?php echo $c['id'];?>&letra=<?php echo $letra;?>&mostrar=<?php echo $mostrar;?>#editar' title='Editar este Registro'>
					<img src='img/edit.gif' border='0' style="margin-top:7px;"></a>
				&nbsp;&nbsp;&nbsp;

			</td>
			<td ><?php echo $c['email'];?>&nbsp;</td>
		</tr>

<?php } ?>
	</table>

<?php echo "<hr><h2><a name='editar'>".iif($id>0, 'Modificacion de Datos','Crear nuevo registro')."</h2>";?>
	<form action='suscriptores.php' method='post'>
	<table>
		<tr>
			<td>Email:</td>
			<td><input type='text' name='email' value='<?php echo $Reg['email'];?>' size='50'  class="required email" /></td>
		</tr>

		<tr>
			<td colspan='2'>
				<input type='hidden' name='accion' value='guardar' />
				<input type='hidden' name='letra' value='<?php echo $letra;?>' />
				<input type='hidden' name='mostrar' value='<?php echo $mostrar;?>' />
				<input type='hidden' name='id' value='<?php echo $id;?>' />
				<input type='submit' name='submit' value='Guardar Cambios' />
			</td>
		</tr>
	</table>
	</form>

		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>

</body></html>