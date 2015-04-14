<?php
    $item_menu[0] = 5;
    $item_menu[1] = 2 ;
    $title = 'Productos';    

	if (!defined('URL')) { include('header.php'); }
    
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	if(!empty($_SESSION['Msg'])) { echo mensaje_ok($_SESSION['Msg']);$_SESSION['Msg']='';	}
    
    
	$id          =  request('id',0);
    $familia     = request('familia',0);
    $subfamilia  = request('subfamilia',0);
	$accion      = request('accion','listar');



	switch ($accion) {
		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from productos where id='$id'";
			$ok		= $db->Execute($cond);
			if ($ok) { $_SESSION['Msg'] = 'El Producto se elimin&oacute; correctamente.';
			} else { $_SESSION['Msg'] = $cond."<hr>".'ERROR!! No se pudo eliminar el producto.';	}
			redirect("productos.php?accion=listar&familia_id=$familia_id");
			die();

			break;

	}

	if ($accion=='listar') { /******************************************************************************** LISTAR*********************/

		include_once('productos_listar.html.php');
        
	}

?>
		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>

</body></html>