<?php
    $item_menu[0] = 3;
    $item_menu[1] = 1;
    $title = 'Slide | Banners';

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
<table width='800'>
<tr>
	<td><h2>Administraci&oacute;n de Slides</h2></td>
	<td align='right'>
<?php if ($accion=='listar') { ?> 
       <a href="banner.php?accion=editar&id=0" title='Crear nuevo Banner' class='boton1' >Crear nuevo Banner</a>
<?php } ?>    
	</td>
</tr>
</table>

<?php
	switch ($accion) {

		case 'estado': /******************************************************************************** ESTADO *********************/
			// Cambio el estado: activo/inactivo
			$cond 	= "select * from slides where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Nota	= $rs->GetRows();
			if ($Nota[0][activo]==1) {$Nota[0][activo]=0;} else {$Nota[0][activo]=1;}
			$cond 	= "update slides set activo=".$Nota[0][activo]." where id=".$id;
			$ok		= $db->Execute($cond);
			$accion = 'listar';
			break;


		case 'delete': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from slides where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$ok		= $db->Execute($cond);

			if ($ok) { $_SESSION['Msg'] = 'El Banner se elimino correctamente.';
			} else { $_SESSION['Msg'] = $cond."<hr>".'ERROR!! No se pudo eliminar el Banner.';	}
			redirect('banner.php');
			die();

		case 'grabar': /******************************************************************************** GRABARNUEVA *********************/
			include_once('banner_guardar.php');
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
			include_once('banner_editar.php');
			break;

	}

	if ($accion=='listar') { /******************************************************************************** LISTAR*********************/

		include_once('banner_listar.html.php');
	}

?>
		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>
</center>
</body></html>