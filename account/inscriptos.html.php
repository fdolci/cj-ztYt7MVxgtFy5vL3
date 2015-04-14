<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>

<div class='grid_12' style='min-height:400px;'>    
	<b>Administración de Inscriptos</b>
	
	<a class="btn" href="<?php echo URL;?>/account/inscripcion_manual.php?producto_id=<?php echo $producto_id;?>" style='float:right;'>Inscripción Manual</a>	
	<div class="pagination" style='margin:0px;'>
	  <ul>
	<?php
		echo "<li class='".($letra=='todos' ? 'active' : '')."'><a href='inscriptos.php?letra=todos&producto_id=$producto_id'>Todos</a></li>";
		foreach($Letras as $l){
			echo "<li  class='".($letra==$l['letra'] ? 'active' : '')."' >";
			echo "<a href='inscriptos.php?letra={$l[letra]}&producto_id=$producto_id'>".strtoupper($l[letra])."</a></li>";
            if (empty($letra)) { $letra = $l['letra'];}
		}
		echo "<li><a href='inscriptos.php?accion=exportar&producto_id=$producto_id' title='Exportar a Excel'><img src='".ADMIN."/iconos/xls.gif'></a></li>";		
	?>
	  </ul>
	</div>


	<link href="<?php echo ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>
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
	<table class='table' style='font-size:12px;'>
		<tr>
			<th style='width:20px;'>&nbsp;</th>
			<th style='width:70px;'>Acción</th>
			<th style='width:70px;'>Fecha Inscripción</th>
			<th style='width:70px;'>Fecha Pago</th>		
			<th style='width:60px;'>Importe</th>		
			<th >Apellido, Nombre</th>
    		<th style='width:100px;' >Telefono</th>
    		<th style='width:150px;' >Email</th>
    		<th style='width:200px;text-align:right;' >Pais - Pcia - Ciudad</th>
		</tr>
<?php 
	$i = 0;
	foreach($Inscriptos as $c) { 
		$i++;
		if ($color=="#FFFFFF") {$color="#FEFFCC"; } else {$color="#FFFFFF";}
?>
		
		<tr bgcolor="<?php echo $color;?>" id='tr_<?php echo $c['id'];?>' >
			
			<td nowrap='nowrap' style='height:24px;vertical-align:middle;text-align:right;padding-right:5px;'><?php echo $i;?></td>
			
			<td nowrap='nowrap' style='height:24px;vertical-align:middle;'>
				
				<a href='#' title='Eliminar este Registro'
					class='toDelete' id='del_<?php echo $c['id'];?>'
					onclick="return confirm('Est&aacute; seguro de eliminar este Registro?');">
					<img src='<?php echo ADMIN;?>/img/del.gif' style='margin-right:10px;' ></a>
					
				<a href='inscripto_editar.php?id=<?php echo $c['id'];?>&letra=<?php echo $letra;?>' title='Editar este Registro'>
					<img src='<?php echo ADMIN;?>/img/edit.gif' style='margin-right:10px;' ></a>
				<?php if(!empty($c['anotaciones'])){?>
				<a href="#" data-toggle="popover" class='pop' 
					 data-content="<?php echo $c['anotaciones'];?>" 
					data-original-title="Mis Anotaciones">
					<img src='<?php echo ADMIN;?>/iconos/txt.gif' style='margin-right:10px;' title="Ver Anotaciones">
				</a>
				<?php } ?>
			</td>
			<td nowrap style='height:24px;vertical-align:middle;'><?php echo date("d.m.Y",$c['fecha']);?></td>
			<td nowrap style='height:24px;vertical-align:middle;'>
				<?php if($c['fecha_de_pago']>0 ){ echo date("d.m.Y",$c['fecha_de_pago']); }?>
			</td>
			<td nowrap style='height:24px;vertical-align:middle; text-align:right;padding-right:10px;'>
				<?php if($c['importe']>0 ){ echo number_format($c['importe'],2).' '.$Monedas[$c['moneda_id']]; }?>
			</td>
			
			<td nowrap style='height:24px;vertical-align:middle;'><?php echo $c['apellido'].", ".$c['nombre'];?>&nbsp;</td>
			<td  style='height:24px;vertical-align:middle;'><?php echo $c['telefono'];?>&nbsp;</td>
			<td  style='height:24px;vertical-align:middle;'><?php echo $c['email'];?>&nbsp;</td>
			<td  style='height:24px;vertical-align:middle;text-align:right;'><?php echo $c['pais'].' - '.$c['provincia'].' - '.$c['ciudad'];?></td>
		</tr>

<?php } ?>
	</table>
</div>

<script>
	$(document).ready(function() { 

		//---------------------------------------------------
		//                        para eliminar un inscripto
		//---------------------------------------------------
		$(".toDelete").click( function(e){		
			event.preventDefault();
			var actual_value = e['currentTarget']['value'];
			var chk_id       = e['currentTarget']['id'];
			var x            = chk_id.split('_');
			var inscripto_id = x[1];
			var tr_id        = 'tr_'+inscripto_id;
			$.ajax({
				url: "<?php echo URL;?>/account/inscriptos.php?accion=eliminar&id="+inscripto_id+"&producto_id=<?php echo $producto_id;?>&letra=<?php echo $letra;?>",
				success: function(data) {
					if(data==1){
						$("#"+tr_id).hide();
					}
				}
			});        
			
		});


	}); 

	$('.pop').popover();
</script>