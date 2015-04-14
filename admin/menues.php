<?php

    $item_menu[0] = 3;
    $item_menu[1] = 3;    
    $title = 'Creador de Menues';	
    include_once('header.php');	
	if (!isset($_SESSION["admin"])) { redirect("login.php");	exit(); }

	$accion = request('accion','listar');
	$id     = request('id',0);
    $bloque_id = request('bloque_id',1);
?>
<table width="800">
<tr>
    <td><h2>Administrador de Menues</h2></td>
    <td align="right"></td>
</tr>
<tr>
    <td>
    <!-- Select de Bloques de Mennues -->
<?php if ($accion=='editar') { ?>
        <a href='menues.php?id=<?=$id;?>' class="boton1" title='Regresar'>Regresar</a>
<?php } else { ?>
    <a href='menues_bloques.php' class="boton1" title='Regresar'>Regresar</a>
<?php } ?>
    
    </td>
    <td align="right"><?php if ($accion!='editar') { echo "<a href='menues.php?accion=editar&id=0&bloque_id=$bloque_id' class='boton1'  title='Crear nuevo ítem de Menú'>Crear nuevo ítem de Menú</a>";}?></td>
</tr>

</table>


<?php


	if ($accion=='ordenar') {
		$cond 	= "select * from menues where id=".$id;
		$rs 	= $db->SelectLimit($cond, 1);
		$xx	= $rs->GetRows();

		if ($_GET['tipo']=='bajar') {
			$orden = $xx[0]['orden'] + '1.1';
			$nivel = $xx[0]['nivel'];

		} elseif ($_GET['tipo']=='subir'){
			$orden = $xx[0]['orden'] - '1.1';
			$nivel = $xx[0]['nivel'];

		} elseif ($_GET['tipo']=='subirnivel'){
			$orden = $xx[0]['orden'];
			$nivel = $xx[0]['nivel'] - 1;
			if ($nivel<1) { $nivel=1;}

		} else {
			$orden = $xx[0]['orden'];
			$nivel = $xx[0]['nivel'] + 1;
			if ($nivel>5) { $nivel=5;}


		}
		$cond 	= "update menues set orden = ".$orden.", nivel=".$nivel." where id='$id' and bloque_id='$bloque_id'";
		$rs 	= $db->Execute($cond);



		//---Reordeno todo
		$cond 	= "select * from menues where bloque_id='$bloque_id' order by orden ASC";
		$rs 	= $db->Execute($cond);
		$xx	= $rs->GetRows();
		$orden = 1;
		foreach ($xx as $item){
			$cond 	= "update menues set orden = ".$orden." where id=".$item['id'];
			$rs 	= $db->Execute($cond);
			$orden++;
		}
		$accion='listar';
	}



	switch ($accion) {

		case 'estado': /******************************************************************************** ESTADO *********************/
			// Cambio el estado: activo/inactivo
			$cond 	= "select * from menues where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Nota	= $rs->GetRows();
			if ($Nota[0][activo]==1) {$Nota[0][activo]=0;} else {$Nota[0][activo]=1;}
			$cond 	= "update menues set activo=".$Nota[0][activo]." where id=".$id;
			$ok		= $db->Execute($cond);
			$accion = 'listar';
			break;

		case 'delete': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from menues where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$ok		= $db->Execute($cond);
			if ($ok) {
				echo "<SCRIPT LANGUAGE='JavaScript'>alert('El menu se elimino correctamente.');</script>";
			} else {
				echo "<SCRIPT LANGUAGE='JavaScript'>alert('ERROR!! No se pudo eliminar el menu.');</script>";
			}
			$accion = 'listar';
			break;

		case 'grabar': /******************************************************************************** GRABARNUEVA *********************/
/*
			$TipoLink==0 Mostrar una Publicacion
			$TipoLink==1 Listar una Categoria
			$TipoLink==2 URL
*/

			// Guarda una nueva publicacion
			$data['id']         = $id;
			$data['nivel']      = request('nivel',1);
			$data['caption1']   = request('caption0','');
            $data['caption2']   = request('caption1','');
            $data['caption3']   = request('caption2','');
            $data['caption4']   = request('caption3','');
            $data['caption5']   = request('caption4','');
			$data['thumb1']     = request('thumb0','');
			$data['thumb2']     = request('thumb1','');
			$data['thumb3']     = request('thumb2','');
			$data['thumb4']     = request('thumb3','');
			$data['thumb5']     = request('thumb4','');
			$data['tipolink']   = request('tipolink',0);
			$Link	            = request('link','');
			$data['pub_id']     = request('pub_id',0);
			$cat_id             = request('cat_id',0);
			$cat_id2            = request('cat_id2',0);
			$clave              = request('clave',0);
			$data['orden']      = $_POST['orden']+0.01;
            $desde_familia_id   = request('desde_familia_id',0);
            $desde_familia1_id   = request('desde_familia1_id',0);

            if ($data['tipolink'] == 3) {
                $cat_id = $desde_familia_id;

            } elseif ($data['tipolink'] == 5) {
                $cat_id = $desde_familia1_id;
            
            } elseif ($data['tipolink'] == 4) {
                $Link1 = "/";
                $Link2 = "/";
                $Link3 = "/";
                $Link4 = "/";
                $Link5 = "/";
                $cat_id = $desde_familia_id;

            } elseif ($data['tipolink'] == 0) { //---------------------------------- Va a una publicacion
				$cat_id = $cat_id2; 
				$Target = 0;
                // Busco la categoria para obtener la url-amigable
                $sql = "select * from categorias where id='$cat_id'";
                $rs = $db->SelectLimit($sql,1);
                $cat = $rs->FetchRow();
                // Busco la publicacion para obtener la url-amigable
                $sql = "select * from publicaciones where id='$pub_id'";
                $rs = $db->SelectLimit($sql,1);
                $pub = $rs->FetchRow();
                
                if($cat_id>10) {
                    $Link1 = URL."/".$cat['urlamigable1']."/".$pub['urlamigable1'].".html";
                    $Link2 = URL."/".$cat['urlamigable2']."/".$pub['urlamigable2'].".html";
                    $Link3 = URL."/".$cat['urlamigable3']."/".$pub['urlamigable3'].".html";
                    $Link4 = URL."/".$cat['urlamigable4']."/".$pub['urlamigable4'].".html";
                    $Link5 = URL."/".$cat['urlamigable5']."/".$pub['urlamigable5'].".html";
                } else {
                    $Link1 = URL."/".$pub['urlamigable1'].".html";
                    $Link2 = URL."/".$pub['urlamigable2'].".html";
                    $Link3 = URL."/".$pub['urlamigable3'].".html";
                    $Link4 = URL."/".$pub['urlamigable4'].".html";
                    $Link5 = URL."/".$pub['urlamigable5'].".html";
                }
				
			} elseif ($data['tipolink'] == 1) { //------------------------------------- lista una categoria
                $sql = "select * from categorias where id='$cat_id'";
                $rs = $db->SelectLimit($sql,1);
                $cat = $rs->FetchRow();

				$pub_id=0; $cat_id2 = 0; $Target = 0;
                $Link1 = URL."/".$cat['urlamigable1'];
                $Link2 = URL."/".$cat['urlamigable2'];
                $Link3 = URL."/".$cat['urlamigable3'];
                $Link4 = URL."/".$cat['urlamigable4'];
                $Link5 = URL."/".$cat['urlamigable5'];
                
			} else {
				$cat_id = 0; $pub_id=0; $cat_id2 = 0;
				$Target = request('target',0);
                $Link1 = $Link;
                $Link2 = $Link;
                $Link3 = $Link;
                $Link4 = $Link;
                $Link5 = $Link;
			}
			$data['link1']  = $Link1;
			$data['link2']  = $Link2;
			$data['link3']  = $Link3;
			$data['link4']  = $Link4;
			$data['link5']  = $Link5;
			$data['cat_id'] = $cat_id;
			$data['target'] = $Target;
			$data['bloque_id'] = $bloque_id;
	
			$ok = $db->Replace('menues', $data,'id', $autoquote = true); 

			if (!$ok) {echo "<SCRIPT LANGUAGE='JavaScript'>alert('ERROR!! No se pudo guardar el menu.');</script>";	}
			//---Reordeno todo
			$cond 	= "select * from menues where bloque_id='$bloque_id' order by orden ASC";
			$rs 	= $db->Execute($cond);
			$xx	= $rs->GetRows();
			$orden = 1;
			foreach ($xx as $item){
				$cond 	= "update menues set orden = ".$orden." where id=".$item['id'];
				$rs 	= $db->Execute($cond);
				$orden++;
			}
			$accion='listar';

			redirect('menues.php?accion=listar&bloque_id='.$bloque_id); exit();
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
/*
			$TipoLink==0 Mostrar una Publicacion
			$TipoLink==1 Listar una Categoria
			$TipoLink==2 URL
*/

			//-- Trae el menu a editar
			$cond 	= "select * from menues where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$Nota	= $rs->FetchRow();
			$Caption[0]	= $Nota['caption1'];
            $Caption[1]	= $Nota['caption2'];
            $Caption[2]	= $Nota['caption3'];
            $Caption[3]	= $Nota['caption4'];
            $Caption[4]	= $Nota['caption5'];
			$Thumb[0]	= $Nota['thumb1'];
            $Thumb[1]	= $Nota['thumb2'];
            $Thumb[2]	= $Nota['thumb3'];
            $Thumb[3]	= $Nota['thumb4'];
            $Thumb[4]	= $Nota['thumb5'];

			$TipoLink	= $Nota['tipolink'];
			$Link		= $Nota['link1'];
            
			$pub_id		= $Nota['pub_id'];
			$cat_id		= $Nota['cat_id'];
			$Orden		= $Nota['orden'];
			$Nivel		= $Nota['nivel'];
			$clave		= $Nota['clave'];
			$target     = $Nota['target'];
			$cat_id2 = request('cat_id2',0);

			// Trae combo de Categorias
			$cond 	= "select * from categorias where activo=1 order by titulo1 ASC";
			$rs 	= $db->Execute($cond);
			$Cate 	= $rs->GetRows();
			// Select para listar categorias
			$combo_cate = "<select name='cat_id'>";
			foreach ($Cate as $c){
				if ($cat_id==$c['id']) {
					$combo_cate.="<option value=".$c['id']." selected='selected'>".$c['titulo1']."</option>";
				} else {
					$combo_cate.="<option value=".$c['id'].">".$c['titulo1']."</option>";
				}
			}
			$combo_cate.= "</select>";

			// Select para elegir categoria para mostrar una publicacion
			$combo_cate2 = "<select name='cat_id2' id='cat_id2' onChange='cargaContenido(this.value)'>";
			foreach ($Cate as $c){
				if ($cat_id==$c['id']) {
					$combo_cate2.="<option value=".$c['id']." selected='selected'>".$c['titulo1']."</option>";
				} else {
					$combo_cate2.="<option value=".$c['id'].">".$c['titulo1']."</option>";
				}
			}
			$combo_cate2.= "</select>";

			if ($TipoLink==0) {
				$sql	= "select id,titulo1 from publicaciones where activo=1 and categoria_id='$cat_id' order by titulo1 ASC";
				$rs 	= $db->Execute($sql);
				$zz		= $rs->GetRows();
				$combo = "<select name='pub_id' id='pub_id'>";
				foreach($zz as $item){
					if ($pub_id==$item['id']) {
						$combo.="<option value=".$item['id']." selected='selected'>".$item['titulo1']."</option>";
					} else {
						$combo.="<option value=".$item['id'].">".$item['titulo1']."</option>";
					}

				}
				$combo .= "</select>";
			} else {
				$combo = "<select disabled='pub_id' name='pub_id' id='pub_id'><option value='0'>Selecciona opci&oacute;n...</option></select>";
			}
			?>
			
			<link href="<?php echo RUTA;?>/css/texto.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="<?php echo URL;?>/admin/js/ckeditor/ckeditor.js"></script>
			<script type="text/javascript" src="<?php echo URL;?>/admin/js/ckfinder/ckfinder.js"></script>


			<script type="text/javascript">

				function BrowseServer( startupPath, functionData )
				{
					// You can use the "CKFinder" class to render CKFinder in a page:
					var finder = new CKFinder();
					// The path for the installation of CKFinder (default = "/ckfinder/").
					finder.basePath = '../';
					//Startup path in a form: "Type:/path/to/directory/"
					finder.startupPath = startupPath;
					// Name of a function which is called when a file is selected in CKFinder.
					finder.selectActionFunction = SetFileField;
					// Additional data to be passed to the selectActionFunction in a second argument.
					// We'll use this feature to pass the Id of a field that will be updated.
					finder.selectActionData = functionData;
					// Name of a function which is called when a thumbnail is selected in CKFinder.
					finder.selectThumbnailActionFunction = ShowThumbnails;
					// Launch CKFinder
					finder.popup();
				}

				// This is a sample function which is called when a file is selected in CKFinder.
				function SetFileField( fileUrl, data )
				{
					document.getElementById( data["selectActionData"] ).value = fileUrl;
				}

				// This is a sample function which is called when a thumbnail is selected in CKFinder.
				function ShowThumbnails( fileUrl, data )
				{
					// this = CKFinderAPI
					var sFileName = this.getSelectedFile().name;
					document.getElementById( 'thumbnails' ).innerHTML +=
							'<div class="thumb">' +
								'<img src="' + fileUrl + '" />' +
								'<div class="caption">' +
									'<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["filesize"] + 'KB)' +
								'</div>' +
							'</div>';

					document.getElementById( 'preview' ).style.display = "";
					// It is not required to return any value.
					// When false is returned, CKFinder will not close automatically.
					return false;
				}			
			</script>
			<script type="text/javascript" src="menues_select_dependientes.js"></script>
			<center>
			<form name='form1' action='menues.php?accion=grabar&id=$id' method='post'>
			<table width='90%' cellpadding='3' cellspacing='3' border='0' style="border-width:1px; border-style:solid; border-color:#000000">
				<tr height='20' bgcolor='#0271E3' >
					<td colspan='2' align='center'>
						<span style="color:#FFFFFF; font-weight:bold; font-size:14px;">Agregar / Modificar un Menu</span>
					</td>
				</tr>

				<tr><td colspan='2'>
					<table width='100%'>
						<tr height='20' bgcolor='#FFFFFF' >
							<td width='150' align='right'><span style="color:#000000; font-weight:bold; font-size:12px;">Nro.de Orden:</span></td>
							<td width='550' align='left'><input type='text' name='orden' value='<?php echo $Orden;?>' size='2' maxlength='3'></td>
						</tr>
						<tr><td colspan='2'><hr></td></tr>
			
						<?php for( $w=0 ; $w<=4 ; $w++ ) { ?>
							<?php if (!empty($Idiomas[$w]['name'])) { ?>
								<tr height='20' bgcolor='#FFFFFF' >
									<td width='100' align='right'>
										<span style="color:#000000; font-weight:bold; font-size:12px;">T&iacute;tulo <?php echo $Idiomas[$w]['name'];?>:</span>
									</td>
									<td width='550' align='left'>
										<input type='text' name='caption<?php echo $w;?>' value='<?php echo $Caption[$w];?>' size='90' maxlength='200' class='required'>
									</td>
								</tr>
								<tr height='20' bgcolor='#FFFFFF' >
									<td width='100' align='right'>
										<span style="color:#000000; font-weight:bold; font-size:12px;">Imagen <?php echo $Idiomas[$w]['name'];?>:</span>
									</td>
									<td width='550' align='left'>
										<input type='text' id='thumb<?php echo $w;?>' name='thumb<?php echo $w;?>' value='<?php echo $Thumb[$w];?>' size='70' maxlength='200'>
										<input type="button" value="Buscar en el servidor" onclick="BrowseServer( 'Images:/menues/', 'thumb<?php echo $w;?>' );" />
									</td>
								</tr>
					
								<tr><td colspan='2'><hr></td></tr>
							<? } //endif ?>
						<? } //endfor ?>


						<tr height='20' bgcolor='#FFFFFF'>
							<td width='100' align='right' ><span style="color:#000000; font-weight:bold; font-size:12px;">Enlace del Menu:</span></td>
							<td width='550' align='left' style="border-left:2px solid blue;">
								<input type='radio' name='tipolink' value='4' <?php echo iif($TipoLink==4,'checked=checked','');?>>Home (Pagina de Inicio)<br/>
			<?php			
			if($Config['admin_productos']=='S'){
				// LISTADO DE PRODUCTOS 
				$Familias = crearArbol(0);
				if ($TipoLink == 3 or $TipoLink == 5) {
					$desde_familia_id = $cat_id;
				} else {
					$desde_familia_id = 0;
				}
				
				$desde_familia = '<select name="desde_familia_id" class="required">';
				$desde_familia1 = '<select name="desde_familia1_id" class="required">';
				$opciones.= "<option value='0'>Raiz 1er.Nivel</option>";
				foreach($Familias as $dd){
						if ($desde_familia_id == $dd['id']) { $sel = "selected='selected'"; } else {$sel='';}
						$separador = "";
						if ($dd['nivel'] == 2 ) {
							$separador = "------";
						} elseif ($dd['nivel'] == 3 ) {
							$separador = "------------";
						} elseif ($dd['nivel'] == 4 ) {
							$separador = "------------------";
						}
						$opciones.= "<option value='{$dd['id']}' $sel >$separador {$dd['nombre1']}</option>";
				}
				$desde_familia.=$opciones;
				$desde_familia1.=$opciones;
				$desde_familia.= "</select>";
				$desde_familia1.= "</select>";
						
				echo "<br><input type='radio' name='tipolink' value=3 ".iif($TipoLink==3,'checked=checked','').">Listar Familias de Productos desde: $desde_familia<br/>";
				echo "<input type='radio' name='tipolink' value=5 ".iif($TipoLink==5,'checked=checked','').">Listar Productos desde: $desde_familia1<br/>";            
			}			
			?>
								<input type='radio' name='tipolink' value='2' <?php echo iif($TipoLink==2,'checked=checked','');?> >
								URL: <input type='text' name='link' value='<?php echo $Link;?>' size='30'/>&nbsp;&nbsp;&nbsp;
								Destino: <select name='target'>
									<option value='0' <?php echo iif($target==0,'selected=selected','');?> >--</option>
									<option value='1' <?php echo iif($target==1,'selected=selected','');?> >Misma ventana</option>
									<option value='2' <?php echo iif($target==2,'selected=selected','');?> >nueva ventana</option>
									<option value='3' <?php echo iif($target==3,'selected=selected','');?> >Efecto</option>
								</select>
								<br>
								<br><input type='radio' name='tipolink' value='1' <?php echo iif($TipoLink==1,'checked=checked','');?> >Listar una Categoria: <?php echo $combo_cate;?><br/>
								<br><input type='radio' name='tipolink' value='0' <?php echo iif($TipoLink==0,'checked=checked','');?> >Mostrar una Publicacion: <br>
								
								<i>Categoria:</i> <?php echo $combo_cate2;?><br>
								<i>Publicacion: </i><div style="display:inline;" id='demoDer'>
								<?php echo  $combo;?>
								</div>
							</td>
						</tr>

						<tr height='20' bgcolor='#FFFFFF' >
							<td width='100' align='right'> </td>
							<td width='550' align='center'>
								<input type='hidden' name='id' value='<?php echo $id;?>'>
								<input type='hidden' name='nivel' value='<?php echo $Nivel;?>'>
								<input type='hidden' name='bloque_id' value='<?php echo $bloque_id;?>'>
								<input type='submit' name='submit' value='<< Guardar los cambios >>' onclick="return procesar();">
							</td>
						</tr>
					</table>
				</form>
				</center>
				<script type=\"text/javascript\" src='js.js'></script>
			<?php 
			break;

	}

	if ($accion=='listar') { /******************************************************************************** LISTAR*********************/
		$cond 		= "select * from menues where bloque_id='$bloque_id' order by orden ASC";
		$rs 		= $db->Execute($cond);
		$Noticias 	= $rs->GetRows();

		if (!empty($Noticias)) {
			echo "<table width=100% cellpadding=3 cellspacing=3 style=\"border-width:1px; border-style:solid; border-color:#000000\">";
			echo "<tr height=20 bgcolor='#0271E3' >";
			echo "<td width=20 class='th'>Estado</td>";
			echo "<td width=110 class='th'>Acciones</td>";
			echo "<td width=20 class='th'>Orden</td>";
			echo "<td width=70 class='th'>N-1</td>";
			echo "<td width=70 class='th'>N-2</td>";
			echo "<td width=70 class='th'>N-3</td>";
			echo "<td width=20 class='th'>TipoLink</td>";
			echo "<td  class='th'>Enlace</td>";
			echo "<td width=20 class='th'>Eliminar</td>";            
			echo "</tr>";

			foreach($Noticias as $not) {
				echo "<tr height=20 bgcolor='#CCCCFF' >";
				echo "<td align=center>";
				if ($not['activo']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';}
				echo "<a href='menues.php?accion=estado&id=".$not['id']."&bloque_id=$bloque_id' alt='Activar/Desactivar este Menu' title='Activar/Desactivar este Menu'><img src='".$imagen."' border='0'></a></td>";


				echo "<td align=center>";
				echo "<a href='menues.php?accion=editar&id=".$not['id']."&bloque_id=$bloque_id' alt='Editar este Menu' title='Editar este Menu'><img src='img/edit.gif' border='0' width='14' height='14'></a>&nbsp;";
				echo "<a href='menues.php?id=".$not['id']."&accion=ordenar&tipo=subir&bloque_id=$bloque_id'><img src='img/arriba.gif' border='0' width='14' height='14' title='Subir una posicion'></a>";
				echo "<a href='menues.php?id=".$not['id']."&accion=ordenar&tipo=bajar&bloque_id=$bloque_id'><img src='img/abajo.gif' border='0' width='14' height='14' title='Bajar una posicion'></a>";
				if ($not['nivel']>1){
					echo "<a href='menues.php?id=".$not['id']."&accion=ordenar&tipo=subirnivel&bloque_id=$bloque_id'><img src='img/subirnivel.gif' width='14' height='14' border='0' title='Subir un nivel'></a>";
				} else {
					echo "<img src='img/subirnivel.gif' width='14' height='14' border='0' title='Subir un nivel'>";
				}

				if ($not['nivel']<3){
				echo "<a href='menues.php?id=".$not['id']."&accion=ordenar&tipo=bajarnivel&bloque_id=$bloque_id'><img src='img/bajarnivel.gif' width='14' height='14' border='0' title='Bajar un nivel'></a>";
				} else {
					echo "<img src='img/bajarnivel.gif' width='14' height='14' border='0' title='Bajar un nivel'>";
				}
				echo "</td>";
				echo "<td >";
				echo "&nbsp;&nbsp;".number_format($not['orden'],0)."</td>";
				if ($not['nivel']==1) {
					echo "<td colspan=3>".$not['caption1']."</td>";
				} elseif ($not['nivel']==2) {
					echo "<td colspan=1></td>";
					echo "<td colspan=2>".$not['caption1']."</td>";
				} elseif ($not['nivel']==3) {
					echo "<td colspan=1></td>";
					echo "<td colspan=1></td>";
					echo "<td colspan=1>".$not['caption1']."</td>";
				}

				echo "<td >".$not['tipolink']."</td>";
				echo "<td >".$not['link1']."</td>";
				echo "<td align=center>";
				echo "<a href='menues.php?accion=delete&id=".$not['id']."&bloque_id=$bloque_id' alt='Eliminar este Menu' title='Eliminar este Menu' onclick=\"return confirm('Est&aacute; seguro de eliminar este Menu?');\"><img src='img/del.gif' border='0'></a>&nbsp;&nbsp;";
                if ($not['clave']==1) { echo "<img src='img/candado.jpg'>"; }
				echo "</td>";

				echo "</tr>";
			}

			echo "</table>";
		} else {
			echo "<span class=titulo>No hay menues para mostrar</span>";
		}

	}
//pr($Config);
?>
		</td>
        </tr>
      </table></td>
    </tr>
</tbody></table>

</body></html>