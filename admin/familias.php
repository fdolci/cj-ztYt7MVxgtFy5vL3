<?php
    $item_menu[0] = 5;
    $item_menu[1] = 1;
    $title = 'Familias de Productos';
	include('header.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	if(!empty($_SESSION['Msg'])) {
	   echo mensaje_ok($_SESSION['Msg']);
		$_SESSION['Msg']='';
	}


	$id     = request('id',0);
	$accion = request('accion','listar');

?>

<center>
<table width='1000'>
<tr>
	<td><h2>Administraci&oacute;n de Familias de Productos</h2></td>
	<td align='right'>
	</td>
</tr>
</table>

<?php
	switch ($accion) {

		case 'estado': /******************************************************************************** ESTADO *********************/
			// Cambio el estado: activo/inactivo
			$cond 	= "select activo from familias where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Nota	= $rs->FetchRow();
			if ($Nota['activo'] == 1) {$Nota['activo'] = 0;} else {$Nota['activo'] = 1;}
			$cond 	= "update familias set activo=".$Nota['activo']." where id=".$id;
			$ok		= $db->Execute($cond);
			$accion = 'listar';
			break;


		case 'delete': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "select * from familias where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$x		= $rs->FetchRow();
			$parent_id = $x['parent_id'];



			$cond 	= "delete from familias where id=".$id;
			$ok		= $db->Execute($cond);

			if ($ok) { $_SESSION['Msg'] = 'La familia se elimino correctamente.';
			} else { $_SESSION['Msg'] = $cond."<hr>".'ERROR!! No se pudo eliminar la familia.';	}
			redirect("familias.php?parent_id=$parent_id");
			die();

		case 'editar': /******************************************************************************** EDITAR *********************/
            include('familias_editar.php');
			break;

	}

	if ($accion=='listar') { /******************************************************************************** LISTAR*********************/

		include_once('familias_listar.html.php');
	}

?>
		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>
</center>
</body></html>