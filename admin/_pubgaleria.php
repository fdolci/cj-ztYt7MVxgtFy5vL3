<?php

    $item_menu[0] = 2;
    $item_menu[1] = 1;
    $title = 'Galeria de Fotos y Videos';

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
	<td><h2>Administraci&oacute;n de la Galeria de Fotos y Videos</h2></td>
	<td align='right'>
<?php if ($accion=='listar') { ?> 
       <a href="pubgaleria.php?accion=editar&id=0" title='Crear nueva Galeria' >Crear nueva Galeria</a>
<?php } ?>    
	</td>
</tr>
</table>

<?php
	switch ($accion) {

		case 'estado': /******************************************************************************** ESTADO *********************/
			// Cambio el estado: activo/inactivo
			$cond 	= "select * from galerias where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Nota	= $rs->GetRows();
			if ($Nota[0]['activo']==1) {$Nota[0]['activo']=0;} else {$Nota[0]['activo']=1;}
			$cond 	= "update galerias set activo={$Nota[0][activo]} where id=".$id;
			$ok		= $db->Execute($cond);
			$accion = 'listar';
			break;


		case 'delete': /******************************************************************************** DELETE *********************/
			// Elimina el departamento
			$cond 	= "delete from galerias where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$ok		= $db->Execute($cond);
			// Elimina las fotos
			$cond 	= "delete from galerias_fotos where galeria_id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$ok		= $db->Execute($cond);

			if ($ok) { $_SESSION['Msg'] = 'La Galeria se elimino correctamente.';
			} else { $_SESSION['Msg'] = $cond."<hr>".'ERROR!! No se pudo eliminar la galeria.';	}
			redirect('pubgaleria.php');
			die();

		case 'grabar': /******************************************************************************** GRABARNUEVA *********************/
			
            include('pubgaleria_guardar.php');
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
            include('pubgaleria_editar.php');
			break;

	}

	if ($accion=='listar') { /******************************************************************************** LISTAR*********************/

		include_once('pubgaleria_listar.html.php');
	}

?>
		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>
</center>
</body></html>