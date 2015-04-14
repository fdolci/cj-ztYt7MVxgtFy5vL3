<?php
    $item_menu[0] = 4; 
    $item_menu[1] = 2;  
    $title = 'Usuarios';
	include('header.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

    $titulo         = 'Administracion de Usuarios';    

    echo $url;
	if(!empty($_SESSION['Msg'])) {
		echo '<center><div style="width:800px;height:30px;background-color:lightblue;border:2px solid blue;font-size:16px;font-weight;bold;text-align:center;margin-top:5px;padding-top:5px;color:blue;">';
		echo $_SESSION['Msg']."</div></center>";
		$_SESSION['Msg']='';
	}
    
	// ----------------------- Obtengo grupos activos
    $cond 	 = "select * from grupos where activo='1'";
	$rs 	 = $db->Execute($cond);
	$Grupos = $rs->GetRows();

	$id        = request('id',0);
	$accion    = request('accion','listar');
	$letra	   = request('letra','');
	$mostrar   = request('mostrar',1);  //0: inactivos, 1:activos, 2:todos  
	$grupo     = request('grupo',0);
	if ($grupo==0){
		foreach($Grupos as $g){  if ($g['defecto']==1){$grupo = $g['id']; break;}	}
	}

?>
<link href="<?php echo ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>
<h2>Listado de Usuarios Registrados</h2>
	<div id="grupo" title="Seleccionar Grupo"
		style="border:1px solid #333; padding:10px;font-size:15px;width:270px;text-align:center;background:#dcdcdc;left:650px;position:absolute;top:60px;cursor:pointer;border-radius:4px;" >
			Grupos:
			<select name='grupo' style='width:120px;' id='my-select'>
			<?php foreach($Grupos as $g){ ?>
				<option class='opcion' value='<?php echo $g['id'];?>'  <?php if ($grupo==$g['id']) { echo "selected";} ?> ><?php echo $g['nombre'];?></option>
			<?php }	?>
			</select>
			<script>
				$(document).ready(function() {
				    $("#my-select").change(function() {
				        var jsgrupo = $('#my-select option:selected').val();
						var href  = "usuarios.php?mostrar=<?php echo $mostrar;?>&letra=<?php echo $letra;?>&grupo="+jsgrupo;
						document.location.href = href;
				    });
				});
			</script>	
	</div>
	<div id="nuevo" title="Crear Usuario"
		style="border:1px solid #333; padding:10px;font-size:15px;width:120px;text-align:center;background:#dcdcdc;left:965px;position:absolute;top:60px;cursor:pointer;border-radius:4px;height:26px;" 
		onclick="TINY.box.show({iframe:'<?php echo URL;?>/admin/usuarios_editar.php?id=0',boxid:'frameless',width:700,height:550,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"
	>Crear Usuario</div>

<?php
    $Pertenece = array();
	switch ($accion) {

		case 'estado': /******************************************************************************** ESTADO *********************/
			// Cambio el estado: activo/inactivo
			$cond 	= "select * from usuarios where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Nota	= $rs->FetchRow();
			if ($Nota['activo']==1) {$Nota['activo']=0;} else {$Nota['activo']=1;}
			$cond 	= "update usuarios set activo=".$Nota['activo']." where id=".$id;
			$ok		= $db->Execute($cond);
			$id=0;
			break;

		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from usuarios where id='$id'";
			$rs 	= $db->SelectLimit($cond, 1);
			$ok		= $db->Execute($cond);
			if ($ok) { echo mensaje_ok("El Usuario se elimin&oacute; correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudo eliminar el Usuario."); echo $sql; }
			$id = 0;
			break;



		case 'enviar': /**************************************************************************** ENVIAR MAIL DE ACTIVACION **********/
			$cond 	= "select * from usuarios where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Reg	= $rs->FetchRow();

			//-- Envio mail al administrador
			$emailsend   = $DatosEmpresa['email'];
			$emailto = $Reg['email'];
			$subject = "[Activacion de cuenta en: ".$DatosEmpresa['nombre_empresa']."]";
			$message.= "Su cuenta ha sido activada. Los datos de acceso son:<br>";
			$message = "<b><u>Email:</u></b> ".$Reg['email']."<br>";
			$message.= "<b><u>Clave:</u></b> ".$Reg['clave']." <br>";
			$encabezados = "From: ".$emailsend."\nContent-Type: text/html; charset=iso-8859-1";
			
			if (mail($emailto,$subject,$message, $encabezados) ) {
				$_SESSION['Msg'] = 'Se ha enviado el mail de aviso de activacion';
			} else { $_SESSION['Msg'] = 'No se pudo enviar el mail de aviso.'; }
			//-- Fin envio de mail
			
			break;


	}


	if ($mostrar == 0) { $cual = 'and  usuarios.activo=0'; $cual2 = 'and activo=0';}
	if ($mostrar == 1) { $cual = 'and  usuarios.activo=1'; $cual2 = 'and activo=1';}
	if ($mostrar == 2) { $cual = ''; $cual2 = '';                          }
	
/*
	echo "<b>Mostrar usuarios: </b>";
	if ($mostrar==1) { $color='#FF9900';} else {$color='#D1E0F7';}
	echo "<a href='usuarios.php?letra=$letra&mostrar=1' style='padding:5px; border:1px solid #333;margin:2px;background:$color;color:#000;text-decoration:none;border-radius:6px;'>ACTIVOS</a>";
	if ($mostrar==0) { $color='#FF9900';} else {$color='#D1E0F7';}
	echo "<a href='usuarios.php?letra=$letra&mostrar=0' style='padding:5px; border:1px solid #333;margin:2px;background:$color;color:#000;text-decoration:none;border-radius:6px;'>INACTIVOS</a>";	
	if ($mostrar==2) { $color='#FF9900';} else {$color='#D1E0F7';}
	echo "<a href='usuarios.php?letra=$letra&mostrar=2' style='padding:5px; border:1px solid #333;margin:2px;background:$color;color:#000;text-decoration:none;border-radius:6px;'>TODOS</a> <br/><br>";	
*/

	$sql = "select * from planes_usuarios";
	$rs  = $db->Execute($sql);
	$x   = $rs->GetRows();
	$Planes = array();
	foreach($x as $clave=>$valor) {
		$Planes[$valor['id']] = $valor;
	}
	unset($x);

	$sql = "select * from usuarios where usuarios.id in (select usuario_id from usuarios_grupos where grupo_id='$grupo')";
	$rs = $db->Execute($sql);
	$Usuarios = $rs->GetRows();
	$cuantos = count($Usuarios);



?>
	<div id="nuevo" title="Cuantos Usuarios hay en el grupo"
		style="border:1px solid #333; padding:10px;font-size:15px;text-align:center;background:#FEFFCC;left:566px;position:absolute;top:60px;cursor:pointer;border-radius:4px;" 
	><?php echo $cuantos;?></div>

<?php 
	if (empty($letra) and !empty($Usuarios)){
		$letra = strtoupper(substr($Usuarios[0]['nombre_entidad'], 0,1) );
	}
	$a_letras = array();
	foreach($Usuarios as $u) { 
		if ( !in_array(strtoupper(substr($u['nombre_entidad'], 0,1) ), $a_letras)   ) { 
			$a_letras[] = strtoupper(substr($u['nombre_entidad'], 0,1) );
			if ($xletra != strtoupper(substr($u['nombre_entidad'], 0,1) ) ) { 
				$xletra = strtoupper(substr($u['nombre_entidad'], 0,1)); 
				if ($letra == strtoupper(substr($u['nombre_entidad'], 0,1) ) ) { $color='#FF9900';} else {$color='#D1E0F7';}
				echo "<a href='usuarios.php?letra=$xletra&mostrar=$mostrar&grupo=$grupo' 
				style='padding:5px; border:1px solid #333;margin:2px;background:$color;color:#000;text-decoration:none;border-radius:6px;'>$xletra</a>";
			}
		}
	}

    echo "<br/><br/>";	

?>
	<table width='1000' border='0' cellpadding='4' cellspacing='0'>
		<tr>
			<th width='40'  class='th'>Acción</th>
			<th width='10'  class='th' style='text-align:left;'>Premium</th>
			<th class='th' style='text-align:left;'>Entidad</th>
			<th width='30'  class='th'>Plan</th>			
			<th width='30'  class='th'>Anuncios</th>			
    		<th width='60'  class='th' style='text-align:right;'>Telefono</th>
    		<th width='60'  class='th' style='text-align:right;'>Email</th>
		</tr>
<?php 
	$count = 0;
	foreach($Usuarios as $c) { 

		if (strtoupper(substr($c['nombre_entidad'], 0,1)) == $letra) {
			if ($color=="#FFFFFF") {$color="#FEFFCC"; } else {$color="#FFFFFF";}
			$count++;
			$user_id = $c['id'];

			//---------------------------------------------- Cuantos anuncios tiene este usuario?
			$sql     = "select count(id) as cuantos from productos where user_id='$user_id' and activo='1'";
			$rs      = $db->SelectLimit($sql,1);
			$x       = $rs->FetchRow();
			$cuantos = $x['cuantos'];

			//----------------------------------------------Arma llave para edicion de anuncios
			$llave['admin_id']   = $_SESSION["admin"];
			$llave['user_id']    = $user_id;
			$llave['passphrase'] = $_SESSION["passphrase"];
			$keyword = base64_encode( serialize($llave) );

?>
			<tr bgcolor="<?php echo $color;?>">
				<td align='left' nowrap='nowrap'>
					<?php echo $count;?>&nbsp;&nbsp;&nbsp;
					<?php if($c['activo']==0){ ?>
					<a href='usuarios.php?accion=eliminar&id=<?php echo $c['id'];?>&letra=<?php echo $letra;?>&mostrar=<?php echo $mostrar;?>' title='Eliminar este Registro'
						onclick="return confirm('Est&aacute; seguro de eliminar este Registro?');">
						<img src='img/del.gif' border='0' ></a>
					<?php } else { ?>	
						<img src='img/del_inactivo.gif' border='0' >
					<?php } ?>	
					&nbsp;&nbsp;&nbsp;
					<a href='usuarios.php?accion=estado&id=<?php echo $c['id'];?>&letra=<?php echo $letra;?>&mostrar=<?php echo $mostrar;?>' title='Activar/Desactivar este Registro'>
						<?php $img = iif ($c['activo']=='1','img/activo.gif','img/inactivo.gif'); ?>
						<img src='<?php echo $img;?>' border='0'  style="margin-top:7px;"></a>&nbsp;&nbsp;&nbsp;
					<a href='#' title='Editar este Registro'
					onclick="TINY.box.show({iframe:'<?php echo URL;?>/admin/usuarios_editar.php?id=<?php echo $c['id'];?>',boxid:'frameless',width:700,height:550,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"	
					><img src='img/edit.gif' border='0' style="margin-top:7px;"></a>
					&nbsp;&nbsp;&nbsp;
					<?php if( $Planes[$c['plan_usuario_id']]['importe'] > 0 ) {?>
					<a href='#' title='Registro de Pagos'
					onclick="TINY.box.show({iframe:'<?php echo URL;?>/admin/usuarios_pagos.php?id=<?php echo $c['id'];?>',boxid:'frameless',width:700,height:550,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}})"	
					><img src='img/signo_pesos.gif' border='0' style="margin-top:7px;"></a>
					<?php } ?>

				</td>
				<td style='text-align:center;'>
					<?php if ($c['es_premium']=='1'){ 
						echo "<img src='".URL."/img/star_premium.gif' border='0'  style='margin-top:7px;height:16px;'>";
					} ?>
					
						
				</td>
				<td ><span title='<?php echo $c['nombre_entidad'];?>'><?php echo $c['sigla'];?></span>&nbsp;</td>
				<td><?php echo $Planes[$c['plan_usuario_id']]['plan_usuarios'];?></th>			
				<td >
					<a href='<?php echo URL;?>/account/listar_anuncios.php?keyword=<?php echo $keyword;?>' title='Listar Anuncios' target='_anuncios'>
					Listar Anuncios [<?php echo $cuantos;?>]</a>
				</td>
				<td style='text-align:right;'><?php echo $c['telefono'];?>&nbsp;</td>
				<td style='text-align:right;'><?php echo $c['email'];?>&nbsp;</td>
			</tr>

<?php
		}
?>
		

<?php } // foreach?>
	</table>

<?php /*
<?php echo "<hr><h2><a name='editar'>".iif($id>0, 'Modificacion de Datos','Crear nuevo registro')."</h2>";?>
	<form action='usuarios.php' method='post'>
	<table>
		<tr>
			<td>Apellido:</td>
			<td><input type='text' name='apellido' value='<?php echo $Reg['apellido'];?>' size='50' class="required" /></td>
            <td width="300" valign='top' style="padding-left:10px;" rowspan="4">Grupos de pertenencia:<br />
            <?php echo $select_grupos;?>
            </td>
		</tr>

		<tr>
			<td>Nombre:</td>
			<td><input type='text' name='nombre' value='<?php echo $Reg['nombre'];?>' size='50' class="required" /></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type='text' name='email' value='<?php echo $Reg['email'];?>' size='50'  class="required email" /></td>
		</tr>
		<tr>
			<td>Clave:</td>
			<td>
                <input type='text' name='clave' value='<?php echo $Reg['clave'];?>' />
                <br /><small>Si desea mantener la misma clave, deje este campo vacio.</small>
            </td>
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
*/?>

<script>
	function closeJS(){
		location.replace('<?php echo URL;?>/admin/usuarios.php?letra=<?php echo $letra;?>&mostrar=<?php echo $mostrar;?>');	
	}
</script>    

</body></html>