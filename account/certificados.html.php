<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>
<style>
	table{ 
		width:950px;
		border-collapse:collapse;
	}
	th{
		background:#90AFFA;
		padding:3px;
	}
</style>

<div class='grid_12' style='min-height:400px;'>    
	<h3>Administración de Certificados para el: <?php echo $Evento['titulo'];?></h3>
	
	<div class="pagination" style='margin:0px;'>

	  	<ul>
			<li  class='active'><a href='certificados.php?producto_id=<?php echo $producto_id;?>'>Gestionar Certificados</a></li>
			<li><a href='certificados-usuarios.php?producto_id=<?php echo $producto_id;?>'>Habilitar Usuarios</a></li>
	  	</ul>
		

			<a href='certificados.php?producto_id=<?php echo $producto_id;?>&accion=editar&certificado_id=0' 
				class = 'btn btn-primary' style='float:right; margin-bottom:20px;'
				title="Desea Crear un Tipo de Certificado para este Evento?">
				Crear Nuevo Certificado</a>
	</div>

	<link href="<?php echo ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>


	<table class='table' style='font-size:14px;'>
		<tr>
			<th style='width:120px;'>Acción</th>
			<th style='width:200px;'>Modificado</th>
			<th>Certificado</th>
		</tr>
<?php
	$i = 0;
	foreach($Certificados as $c) { 
		if ($color=="#FFFFFF") {$color="#FEFFCC"; } else {$color="#FFFFFF";}
?>
		
		<tr bgcolor="<?php echo $color;?>" >
			
			<td nowrap='nowrap' style='height:24px;vertical-align:middle;'>
				
				<a href='certificados.php?accion=eliminar&id=<?php echo $c['id'];?>&producto_id=<?php echo $c['producto_id'];?>' title='Eliminar este Registro'
					onclick="return confirm('Est&aacute; seguro de eliminar este Registro?');">
					<img src='<?php echo ADMIN;?>/img/del.gif' style='margin-right:10px;' ></a>

				<a href='certificados.php?accion=editar&certificado_id=<?php echo $c['id'];?>&producto_id=<?php echo $producto_id;?>' title='Editar este Registro'>
					<img src='<?php echo ADMIN;?>/img/edit.gif' style='margin-right:10px;' ></a>

				<a href='certificado-demo.php?certificado_id=<?php echo $c['id'];?>' title='Ver una muestra' target='_demo'>
					<img src='<?php echo ADMIN;?>/img/fm_mas.jpg' style='margin-right:10px;' ></a>
			</td>
			<td nowrap style='height:24px;vertical-align:middle;'><?php echo date("d.m.Y",$c['updated']);?></td>

			<td nowrap style='height:24px;vertical-align:middle;'><?php echo $c['nombre'];?>&nbsp;</td>
		</tr>
<?php } ?>

	</table>
</div>