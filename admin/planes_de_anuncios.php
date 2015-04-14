<?php
    $item_menu[0] = 5; $item_menu[1] = 9;  $title = 'Administrar Planes de Anuncios';
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$id     = request('id',0);
	$accion = request('accion','listar');
	$activo = request('activo',1);
	
?>
<h2><?php echo $title;?></h2>

<?php

    $nombre = '';
	switch ($accion) {
		case 'defecto': /******************************************************************************** DEFECTO *********************/
			// Estable un plan como defecto
			$cond 	= "update planes_usuarios set defecto='0'";
			$ok		= $db->Execute($cond);
			$cond 	= "update planes_usuarios set defecto='1' where id='$id'";
			$ok		= $db->Execute($cond);

			if ($ok) { echo mensaje_ok("El Proceso se realizo correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudo realizar la accion solicitada."); }
			$id=0;
			break;

		case 'premium': /******************************************************************************** PREMIUM *********************/
			$cond 	= "select * from planes_usuarios where id='$id' ";
			$rs	= $db->SelectLimit($cond,1);
			$plan = $rs->FetchRow();

			if ($plan['es_premium']==1 ) { $plan['es_premium']=0; } else { $plan['es_premium']=1; }

			$ok = $db->Replace('planes_usuarios', $plan,'id', $autoquote = true); 

			if ($ok) { echo mensaje_ok("El Proceso se realizo correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudo realizar la accion solicitada."); }
			$id=0;
			break;


		case 'eliminar': /******************************************************************************** DELETE *********************/
			// Elimina la publicacion
			$cond 	= "delete from planes_usuarios where id='$id'";
			$ok		= $db->Execute($cond);

			if ($ok) { echo mensaje_ok("El Registro se elimin&oacute; correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudo eliminar el Registro."); }
			$id=0;
			break;


		case 'guardar': /******************************************************************************** GRABARNUEVA *********************/
			$data = $_POST;
			unset($data['accion']);
			unset($data['submit']);

			$db->debug = false;
			$ok = $db->Replace('planes_usuarios',$data,'id', $autoquote = true); 

			if ($ok) { echo mensaje_ok("Los datos se guardaron correctamente.");
			} else { echo mensaje_error("ERROR!! No se pudieron guardar los datos, intente nuevamente."); }

			$id = 0;
			$locacion = '';
			break;

		case 'editar': /******************************************************************************** EDITAR *********************/
			$cond 	= "select * from planes_usuarios where id=".$id;
			$rs 	= $db->SelectLimit($cond, 1);
			$xplan	= $rs->FetchRow();
			break;
	}

	$sql="select * from planes_usuarios order by plan_usuarios ASC";
	$rs = $db->Execute($sql);
	$planes = $rs->GetRows();

?>

	<script type="text/javascript" src="<?php echo URL;?>/js/table_sorter/jquery.tablesorter.js"></script> 
	<link rel="stylesheet" href="<?php echo URL;?>/js/table_sorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />


	<table width='1000' cellpadding='10'>
		<tr>
			<td width='600' style='vertical-align:top;'>

				<table id="myTable" class="tablesorter">
				<thead> 
					<tr >
						<th width='10'  >ID</th>
						<th width='50'  >Acción</th>
						<th >x Defecto</th>
						<th >Premium</th>
						<th >Nombre</th>
						<th >Importe</th>
						<th >Renovacion</th>
						<th >Avisos</th>
						<th >Días</th>
						<th >Anunciantes</th>
					</tr>
				</thead> 
				<tbody> 
			<?php 
				foreach($planes as $plan) { 
					$sql = "select count(id) as cuantos from usuarios where plan_usuario_id = '{$plan['id']}'";
					$rs = $db->SelectLimit($sql,1);
					$x = $rs->FetchRow();
					$cuantos = $x['cuantos'];

			?>
				
					<tr>
						<td><?php echo $plan['id'];?></td>
						<td  nowrap='nowrap'>
							<a href='planes_de_anuncios.php?accion=editar&id=<?php echo $plan['id'];?>' title='Editar este Registro'>
								<img src='img/edit.gif' border='0' style="margin-top:7px;" /></a>
							<?php if($cuantos<1){?>
							&nbsp;&nbsp;&nbsp;
							<a href='planes_de_anuncios.php?accion=eliminar&id=<?php echo $plan['id'];?>' title='Eliminar este Registro'
								onclick="return confirm('Est&aacute; seguro de eliminar este Registro?\n ');">
								<img src='img/del.gif' border='0' /></a>
							<?php } ?>

						</td>
						<td  style='text-align:center;'>
	                        <?php if ($plan['defecto'] == 1) { $imagen="img/activo.gif"; } else { $imagen='img/inactivo.gif'; } ?>
							<a href='planes_de_anuncios.php?accion=defecto&id=<?php echo $plan['id'];?>' title='Establecer como Plan por Defecto'>
								<img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0' style="margin-top:7px;" /></a>
						</td>
						<td  style='text-align:center;'>
	                        <?php if ($plan['es_premium'] == 1) { $imagen="img/activo.gif"; } else { $imagen='img/inactivo.gif'; } ?>
							<a href='planes_de_anuncios.php?accion=premium&id=<?php echo $plan['id'];?>' title='Establecer como Plan Premium'>
								<img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0' style="margin-top:7px;" /></a>
						</td>

						<td ><?php echo $plan['plan_usuarios'];?></td>
						<td style='text-align:right;'>$<?php echo number_format($plan['importe'],0,'.',',');?>.-</td>
						<td  style='text-align:right;'><?php echo $plan['renovacion'];?></td>
						<td  style='text-align:right;'><?php echo $plan['cantidad_avisos'];?></td>
						<td  style='text-align:right;'><?php echo $plan['vigencia'];?></td>
						<td  style='text-align:right;'><?php echo $cuantos;?></td>
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
		</tr>
	</table>

				<?php echo "<h2>".iif($id>0, 'Modificar Plan','Crear un nuevo Plan')."</h2>";?>
					<form action='planes_de_anuncios.php' method='post' id="formulario">
					<table>
						<tr>
							<td>Nombre:</td>
							<td><input type='text' name='plan_usuarios' value='<?php echo $xplan['plan_usuarios'];?>' style="width:250px;" class='required'/></td>
						</tr>
						<tr>
							<td>Cantidad de Avisos:</td>
							<td><input type='text' name='cantidad_avisos' value='<?php echo $xplan['cantidad_avisos'];?>' style="width:250px;" class='required'/>$</td>
						</tr>

						<tr>
							<td>Importe:</td>
							<td><input type='text' name='importe' value='<?php echo $xplan['importe'];?>' style="width:250px;" class='required'/>$</td>
						</tr>
						<tr>
							<td>Renovación del Plan:</td>
							<td><input type='text' name='renovacion' value='<?php echo $xplan['renovacion'];?>' style="width:250px;" class='required'/>días</td>
						</tr>
						<tr>
							<td>Vigencia de los Avisos:</td>
							<td><input type='text' name='vigencia' value='<?php echo $xplan['vigencia'];?>' style="width:250px;" class='required'/>días</td>
						</tr>
				
						<tr>
							<td colspan='2'>
								<input type='hidden' name='accion' value='guardar' />
								<input type='hidden' name='id' value='<?php echo $xplan['id'];?>' />
								<input type='submit' name='submit' value='Guardar Cambios' />
							</td>
						</tr>
					</table>
					</form>


<?php include('footer.php');