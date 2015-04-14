<?php
    $item_menu[0] = 2;
    $item_menu[1] = 3 ;
    $title = 'Publicaciones';  

    $mipath='../';
	include('header.php');    
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

    $de_donde     = '';
    $categoria_id = request('categoria_id',2);
	$id           = request('id',0);
	$accion       = request('accion','listar');

	$Categoria    = busco_categoria_por_id($categoria_id);
	echo "<h1>Sección: {$Categoria['titulo']}</h1>";


	switch ($accion) {
		case 'estado': /******************************************************************************** ESTADO *********************/
			$rs = $db->SelectLimit("select * from publicaciones where id='$id'", 1);
			$x	= $rs->FetchRow();

			if ($x['activo']==1) {$x['activo']=0;} else {$x['activo']=1;}

			$ok		= $db->Execute("update publicaciones set activo={$x['activo']} where id='$id'");
			$accion = 'listar';
			break;

		case 'duplicar': /******************************************************************************** DUPLICAR *********************/
			$rs = $db->SelectLimit("select * from publicaciones where id='$id'", 1);
			$x	= $rs->FetchRow();

			$x['id']         = 0;
			$x['activo']     = 0;
			$x['fecha']      = time();
			$x['modificado'] = time();

			$ok = $db->Autoexecute('publicaciones', $x,'INSERT'); 

			$accion = 'listar';
			break;

		case 'delete': /******************************************************************************** DELETE *********************/
			$ok 	= $db->Execute("delete from publicaciones where id='$id' and categoria_id='$categoria_id'");
			if ($ok) { $_SESSION['Msg'] = 'La publicacion se elimin&oacute; correctamente.';
			} else { $_SESSION['Msg'] = $cond."<hr>".'ERROR!! No se pudo eliminar la publicacion.';	}
			$accion = 'listar';
			break;
/*
		case 'grabar': /******************************************************************************** GRABARNUEVA ******************** *  /
			include('contenidos_guardar.php');
			break;
*/
		case 'editar': /******************************************************************************** EDITAR *********************/
			include('contenidos_editar.php');
			break;

	}

	if ($accion=='listar') { /******************************************************************************** LISTAR*********************/

		$orden = $Categoria['ordenar_publicaciones'];
		if ($orden=='orden DESC' or $orden=='orden ASC'){
			$muestra_botones_orden=true;
		} else {
			$muestra_botones_orden=false;
		}

		$cond 		= "select * from publicaciones where categoria_id = '$categoria_id' order by $orden";
		echo $cond;
		$rs 		= $db->Execute($cond);
		$Noticias 	= $rs->GetRows();
		include_once('contenidos_listar.html.php');
        
	}

?>
		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>

</body></html>