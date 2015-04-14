<?php
    $item_menu[0] = 1; $item_menu[1] = 13;  $title = 'Administrar Ciudades';
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$id     = request('id',0);
	$accion = request('accion','listar');
	$activo = request('activo',1);

	$sql="select * from ciudades where parent_id=0 order by locacion ASC";
	$rs = $db->Execute($sql);
	$provincias = $rs->GetRows();


	$parent_id = request('parent_id',$provincias[0]['id']);
?>


<?php

    $locacion = '';
    $url = '';
	switch ($accion) {
		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from ciudades where id='$id'";
			$ok		= $db->Execute($cond);

			if ($ok) { echo mensaje_ok("El Registro se elimin&oacute; correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudo eliminar el Registro."); }
			$id=0;
			break;


		case 'guardar': /******************************************************************************** GRABARNUEVA *********************/
			$locacion  = request('locacion','');
			$url       = request('url','');
			$id        = request('id',0);
			$parent_id = request('parent_id',0);

			$db->debug = false;
			$ok = $db->Replace('ciudades', 
								array(
									'id'       => $id,
									'parent_id' => $parent_id,
									'urlfriendly' => $url,
									'locacion' => $locacion
								),
								'id', $autoquote = true); 

			if ($ok) { echo mensaje_ok("Los datos se guardaron correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudieron guardar los datos, intente nuevamente."); }

			$id = 0;
			$parent_id = 0;
			$locacion = '';
			break;

		case 'estado': /******************************************************************************** ESTADO *********************/
			$cond 	= "select * from ciudades where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$x	= $rs->FetchRow();
			if($x['activo']==1) { $x['activo']=0; } else { $x['activo']=1; }
			$ok = $db->Replace('ciudades',$x,'id', $autoquote = true); 
			$parent_id  = $x['parent_id'];
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
			$cond 	= "select * from ciudades where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$x	= $rs->FetchRow();
            $locacion   = $x['locacion'];
            $url        = $x['urlfriendly'];
            $parent_id  = $x['parent_id'];
			break;
	}


	$sql="select * from ciudades where parent_id=$parent_id order by locacion ASC";
	$rs = $db->Execute($sql);
	$ciudades = $rs->GetRows();


    $select_provincias = "<select name='parent_id' id='selector_provincia' >";
    foreach ($provincias as $valor){
        if($parent_id == $valor['id']) { $sel='selected=selected'; } else { $sel=''; }
        $select_provincias.= "<option value='{$valor['id']}' $sel>{$valor['locacion']}</option>";
    }
    $select_provincias.= "</select>";

    echo $select_provincias;

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
						<th >URL</th>
					</tr>
				</thead> 
				<tbody> 
			<?php 
				foreach($ciudades as $ciudad) { 
			?>
				
					<tr>
						<td><A NAME="<?php echo $ciudad['id'];?>"><?php echo $ciudad['id'];?></a></td>
						<td  nowrap='nowrap'>
                        <?php if ($ciudad['activo'] == 1) { $imagen="img/activo.gif"; } else { $imagen='img/inactivo.gif'; } ?>
							<a href='<?php echo URL;?>/admin/habilitar_ciudades.php?accion=estado&id=<?php echo $ciudad['id'];?>#<?php echo $ciudad['id'];?>' title='Cambiar estado'>
								<img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0' style="margin-top:7px;" /></a>
							&nbsp;&nbsp;&nbsp;

							<a href='habilitar_ciudades.php?accion=editar&id=<?php echo $ciudad['id'];?>' title='Editar este Registro'>
								<img src='img/edit.gif' border='0' style="margin-top:7px;" /></a>
							&nbsp;&nbsp;&nbsp;
							<a href='habilitar_ciudades.php?accion=eliminar&id=<?php echo $ciudad['id'];?>' title='Eliminar este Registro'
								onclick="return confirm('Est&aacute; seguro de eliminar este Registro?\n ');">
								<img src='img/del.gif' border='0' /></a>

						</td>
						<td ><?php echo $ciudad['locacion'];?></td>
						<td ><?php echo $ciudad['urlfriendly'];?></td>
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

				<?php echo "<h2>".iif($id>0, 'Modificar Ciudad','Crear una nueva Ciudad')."</h2>";?>
					<form action='habilitar_ciudades.php' method='post' id="formulario">
					<table>
						<tr>
							<td>Nombre:</td>
							<td>
								<input type='text' name='locacion' value='<?php echo $locacion;?>' style="width:250px;" class='required'/>
							</td>
						</tr>
						<tr>
							<td>URL:</td>
							<td>
								<input type='text' name='url' value='<?php echo $url;?>' style="width:250px;" class='required'/>
							</td>
						</tr>
				
						<tr>
							<td colspan='2'>
								<input type='hidden' name='accion' value='guardar' />
								<input type='hidden' name='id' value='<?php echo $id;?>' />
								<input type='hidden' name='parent_id' value='<?php echo $parent_id;?>' />
								<input type='submit' name='submit' value='Guardar Cambios' />
							</td>
						</tr>
					</table>
					</form>

			</td>
		</tr>
	</table>

<script>
    $("#selector_provincia").change(function () {
        var jurl        = "<?php echo URL;?>/admin/habilitar_ciudades.php?parent_id";
        var jprovincia  = $("#selector_provincia").val();

        var redireccion = jurl+'='+jprovincia;
        document.location.href=redireccion;

     });
</script>
<?php include('footer.php');