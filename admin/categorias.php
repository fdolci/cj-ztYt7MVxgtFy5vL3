<?php
    $item_menu[0] = 2;
    $item_menu[1] = 2;
    $title = 'Categorias';
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
	<td><h2>Administraci&oacute;n de Categor&iacute;as</h2></td>
	<td align='right'>
		<?php if ( $accion=='listar' and ( $_SESSION['god'] == 1 or $Config['crea_categorias'] == 'S' ) ) { ?> 
       		<a href="categorias.php?accion=editar&id=0" class="boton1"  title='Crear nueva Categoria' >Crear nueva Categoria</a>
		<?php } ?>    
	</td>
</tr>
</table>

<?php
	switch ($accion) {

		case 'estado': /******************************************************************************** ESTADO *********************/
			// Cambio el estado: activo/inactivo
			$cond 	= "select * from categorias where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Nota	= $rs->GetRows();
			if ($Nota[0][activo]==1) {$Nota[0][activo]=0;} else {$Nota[0][activo]=1;}
			$cond 	= "update categorias set activo=".$Nota[0][activo]." where id=".$id;
			$ok		= $db->Execute($cond);
			$accion = 'listar';
			break;


		case 'delete': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from categorias where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$ok		= $db->Execute($cond);

			if ($ok) { $_SESSION['Msg'] = 'La categoria se elimino correctamente.';
			} else { $_SESSION['Msg'] = $cond."<hr>".'ERROR!! No se pudo eliminar la publicacion.';	}
			redirect('categorias.php');
			die();

		case 'grabar': /******************************************************************************** GRABARNUEVA *********************/
			include_once('categorias_guardar.php');
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
			include_once('categorias_editar.php');
			break;

	}

	if ($accion=='listar') { /******************************************************************************** LISTAR*********************/
		include_once('categorias_listar.html.php');
	}

?>
		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>
</center>
</body></html>