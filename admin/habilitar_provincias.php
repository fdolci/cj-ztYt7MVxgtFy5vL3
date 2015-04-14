<?php
    $item_menu[0] = 1; $item_menu[1] = 12;  $title = 'Administrar Provincias';
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$id     = request('id',0);
	$accion = request('accion','listar');
	$activo = request('activo',1);
	
?>


<?php

    $nombre = '';
	switch ($accion) {
		case 'estado': /******************************************************************************** ESTADO *********************/
			$cond 	= "select * from ciudades where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$x	= $rs->FetchRow();
			if($x['activo']==1) { $x['activo']=0; } else { $x['activo']=1; }
			$ok = $db->Replace('ciudades',$x,'id', $autoquote = true); 
			$id = 0;
			break;

		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from ciudades where id='$id'";
			$ok		= $db->Execute($cond);

			$cond 	= "delete from ciudades where parent_id='$id'";
			$ok		= $db->Execute($cond);

			if ($ok) { echo mensaje_ok("El Registro se elimin&oacute; correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudo eliminar el Registro."); }
			$id=0;
			break;


		case 'guardar': /******************************************************************************** GRABARNUEVA *********************/
			$locacion = request('locacion','');
			$id       = request('id',0);

			$db->debug = false;
			$ok = $db->Replace('ciudades', 
								array(
									'id'       => $id,
									'locacion' => $locacion
								),
								'id', $autoquote = true); 

			if ($ok) { echo mensaje_ok("Los datos se guardaron correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudieron guardar los datos, intente nuevamente."); }

			$id = 0;
			$locacion = '';
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
			$cond 	= "select * from ciudades where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$provincia	= $rs->FetchRow();
            $locacion   = $provincia['locacion'];
			break;
	}

	$sql="select * from ciudades where parent_id=0 order by locacion ASC";
	$rs = $db->Execute($sql);
	$provincias = $rs->GetRows();

?>

	<script type="text/javascript" src="<?php echo URL;?>/js/table_sorter/jquery.tablesorter.js"></script> 
	<link rel="stylesheet" href="<?php echo URL;?>/js/table_sorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />


	<table width='1000' cellpadding='10'>
		<tr>
			<td width='500' style='vertical-align:top;'>

				<table id="myTable" class="tablesorter">
				<thead> 
					<tr >
						<th width='10'  >ID</th>
						<th width='110'  >Acción</th>
						<th >Nombre</th>
					</tr>
				</thead> 
				<tbody> 
				<?php foreach($provincias as $provincia) { ?>
				
					<tr>
						<td><?php echo $provincia['id'];?></td>
						<td  nowrap='nowrap'>
	                        <?php if ($provincia['activo'] == 1) { $imagen="img/activo.gif"; } else { $imagen='img/inactivo.gif'; } ?>
								<a href='habilitar_provincias.php?accion=estado&id=<?php echo $provincia['id'];?>' title='Cambiar estado'>
									<img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0' style="margin-top:7px;" /></a>
								&nbsp;&nbsp;&nbsp;

							<a href='habilitar_provincias.php?accion=editar&id=<?php echo $provincia['id'];?>' title='Editar este Registro'>
								<img src='img/edit.gif' border='0' style="margin-top:7px;" /></a>
							&nbsp;&nbsp;&nbsp;
							<a href='habilitar_provincias.php?accion=eliminar&id=<?php echo $provincia['id'];?>' title='Eliminar este Registro'
								onclick="return confirm('Est&aacute; seguro de eliminar este Registro? Tambien eliminaran las ciudades que contega\n ');">
								<img src='img/del.gif' border='0' /></a>

						</td>
						<td ><?php echo $provincia['locacion'];?></td>
					</tr>

				<?php } ?>
				</tbody> 
				</table>
				<script>
				$(document).ready(function() { 
					$("#myTable").tablesorter({ 
						headers: { 
							1: { 
								// disable it by setting the property sorter to false 
								sorter: false 
							} 
						} 
					});


				}); 
				</script>


			</td>
			<td style='vertical-align:top;'>	

				<?php echo "<h2>".iif($id>0, 'Modificar Provincia','Crear una nueva Provincia')."</h2>";?>
					<form action='habilitar_provincias.php' method='post' id="formulario">
					<table>
						<tr>
							<td>Nombre:</td>
							<td>
								<input type='text' name='locacion' value='<?php echo $locacion;?>' style="width:250px;" class='required'/>
							</td>
						</tr>
				
						<tr>
							<td colspan='2'>
								<input type='hidden' name='accion' value='guardar' />
								<input type='hidden' name='id' value='<?php echo $id;?>' />
								<input type='submit' name='submit' value='Guardar Cambios' />
							</td>
						</tr>
					</table>
					</form>

			</td>
		</tr>
	</table>

<?php include('footer.php');