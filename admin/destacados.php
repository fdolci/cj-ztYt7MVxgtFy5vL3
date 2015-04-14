<?php
    $mipath='../';
	include ('../inc/config.php');
    $de_donde = '';
    $categoria_id = request('categoria_id',2);

        $item_menu[0] = 2;
        $item_menu[1] = 3 ;
        $title = 'Destacados';  

	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	if(!empty($_SESSION['Msg'])) {
	   echo mensaje_ok($_SESSION['Msg']);
		$_SESSION['Msg']='';
	}
    
    
	$id     		= request('id',0);
	$accion 		= request('accion','listar');


	echo "<h1>Sección: Publicaciones Destacadas</h1>";

	switch ($accion) {
		case 'destacado': /******************************************************************************** DESTACADO *********************/
			$ok		= $db->Execute("update publicaciones set destacado='0' where id='$id'");
			$accion = 'listar';
			break;
	}

	if ($accion=='listar') { /******************************************************************************** LISTAR*********************/

		$cond 		= "select publicaciones.*, categorias.titulo1 as categoria 
						from publicaciones left join categorias on publicaciones.categoria_id=categorias.id 
						where destacado = '1' order by publicaciones.fecha DESC";
		$rs 		= $db->Execute($cond);
		$Noticias 	= $rs->GetRows();
		include_once('destacados_listar.html.php');
        
	}

?>
		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>

</body></html>