<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>
<div class='grid_12' style='min-height:400px;'>    

	<?php if (isset($Productos)){ ?>
		
		<script type="text/javascript" src="<?php echo URL;?>/js/table_sorter/jquery.tablesorter.js"></script> 
		<link rel="stylesheet" href="<?php echo URL;?>/js/table_sorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
		<table id="myTable" class="tablesorter">
			<thead> 
				<tr>
					<th>Nro</th>
					<th>Acciones</th>
					<th>Modificado</th>
					<th>Titulo</th>
					<th>Inicio</th>
					<th>Fin</th>
					<th>Visualizado</th>
					<th>Inscriptos</th>
				</tr>
			</thead>
			<tbody> 
				<?php $i=1; $class = 'odd'?>
				<?php foreach($Productos as $p){?>
					<?php $class = iif($class=='odd','even','odd');?>
					<tr style='border-bottom:1px solid #CCC;' class='<?php echo $class;?>' >
						<td ><?php echo $i;?></td>
						<td>

        					<a href='<?php echo URL;?>/account/listar_anuncios.php?accion=delete&anuncio_id=<?php echo $p['id'];?>'
        						title='Eliminar esta Actividad' onclick="return confirm('Est&aacute; seguro de eliminar este Anuncio?\n Para deshacer esta acción deberá comunicarse con contacto@CongresosyJornadas.net');">
        						<img src='<?php echo URL;?>/img/del.gif' border='0' /></a>

							&nbsp;&nbsp;
							<a href='<?php echo URL;?>/account/aviso.php?id=<?php echo $p['id'];?>' title='Modificar Actividad'><img src='<?php echo URL;?>/img/edit.gif'></a>

							&nbsp;&nbsp;
	        				<a href='<?php echo URL;?>/account/inscriptos.php?producto_id=<?php echo $p['id'];?>'
	        					title='Administrar Lista de Inscriptos' >
	        					<img src='<?php echo ADMIN;?>img/admin_inscriptos.jpg' border='0' /></a>

							&nbsp;&nbsp;
	        				<a href='<?php echo URL;?>/account/certificados.php?producto_id=<?php echo $p['id'];?>'
	        					title='Administrar Certificados' >
	        					<img src='<?php echo ADMIN;?>img/icono_certificado.png' style='border:0px; height:24px;' /></a>


						</td>
						<td><?php echo date("d/m/Y",$p['modificado']);?></td>
						<td><?php echo $p['titulo'];?></td>
						<td><?php echo date("d/m/Y",$p['desde']);?></td>
						<td><?php echo date("d/m/Y",$p['hasta']);?></td>
						<td style='text-align:right;'><?php echo $p['lecturas'];?></td>
						<td style='text-align:right;'><?php echo $p['inscriptos'];?></td>
					</tr>
					<?php $i++;?>

				<?php } //end foreach ?>


			</tbody> 
		</table>
		<script>
		$(document).ready(function() { 
			$("#myTable").tablesorter({ 
				// pass the headers argument and assing a object 
				headers: { 
					0: { sorter: false },
					1: { sorter: false },

				} 
			});


		}); 
		</script>

	<?php } else {?>

		<h2>No tiene Anuncios vigentes</h2>

	<?php } ?>
</div>
<div class='clear'></div>