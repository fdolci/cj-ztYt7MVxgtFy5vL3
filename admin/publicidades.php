<?php
    $item_menu[0] = 5;
    $item_menu[1] = 5 ;
    $title = 'Administrador de Publicidades';    

	if (!defined('URL')) { include('header.php'); }
    
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	if(!empty($_SESSION['Msg'])) { echo mensaje_ok($_SESSION['Msg']);$_SESSION['Msg']='';	}
    
    
	$id     		= request('id',0);
    $familia_id     = request('familia_id',0);
    $ubicacion      = request('ubicacion','left');
	$accion 		= request('accion','listar');



	switch ($accion) {
		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from publicidades where id='$id'";
			$ok		= $db->Execute($cond);
			if ($ok) { $_SESSION['Msg'] = 'La Publicidad se elimin&oacute; correctamente.';
			} else { $_SESSION['Msg'] = $cond."<hr>".'ERROR!! No se pudo eliminar la publicidad.';	}
			$accion = 'listar';

			break;

		case 'orden':
			$sube     = request('sube','no');
			$cond 	= "select activo,orden from publicidades where id='$id' ";
			$rs 	= $db->SelectLimit($cond, 1);
			$x		= $rs->FetchRow();

			$orden_actual = $x['orden'];

			if ($sube=='si') {
				$nuevo_orden = ($orden_actual - 1.5); 
			} else { 
				$nuevo_orden = ($orden_actual + 1.5); 
			}
			$cond 	= "update publicidades set orden='$nuevo_orden' where id='$id' ";
			$ok		= $db->Execute($cond);

			$sql = "select * from publicidades where familia_id = '$familia_id' order by orden ASC";
			$rs 	= $db->Execute($sql);
			$x	= $rs->GetRows();
			$orden = 1;
			foreach ($x as $r){
				$cond 	= "update publicidades set orden='$orden' where id='{$r['id']}' ";
				$ok		= $db->Execute($cond);
				$orden++;
			}	

			$accion='listar';			

			break;	

		case 'estado':

		    $sql = "select * from publicidades where id='$id'";
		    $rs  = $db->SelectLimit($sql,1);
		    $Publi   = $rs->FetchRow();
		    $valor = $Publi['activo'];
		    if ($valor==0) { $Publi['activo']=1; } else { $Publi['activo']=0; }

		    if ($Publi['activo']==1) {

	            // Tengo que registrar la fecha de caducidad
	            $sql = "select vigencia,importe from planes where id='{$Publi['plan_id']}'";
	            $rs  = $db->SelectLimit($sql,1);
	            $x   = $rs->FetchRow();
	            if ($x['vigencia']==0){
	                $Publi['caduca'] = 0;
	            } else {
	                $Publi['caduca'] = time()+(60*60*24*$x['vigencia']);    
	            }

                // es una publicidad nueva, creo el registro en pagos
                $Pagos['id'] = 0;
                $Pagos['publicidad_id'] = $id;
                $Pagos['desde']         = time();
                $Pagos['hasta']         = $Publi['caduca'];
                $Pagos['importe']       = $x['importe'];
                $Pagos['plan_id']       = $Publi['plan_id'];
                $ok = $db->Replace('pagos', $Pagos,'id', $autoquote = true); 
		    }


            $ok = $db->Replace('publicidades', $Publi,'id', $autoquote = true); 
			$accion='listar';			

		break;

	}

	if ($accion=='listar') { /******************************************************************************** LISTAR*********************/

		include_once('publicidades_listar.html.php');
        
	}

?>
		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>

</body></html>