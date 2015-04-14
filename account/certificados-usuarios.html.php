<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>
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


<div class='grid_12' style='min-height:400px;'>    
	<h3>Determinar que certificado le corresponde a cada Inscripto.</h3>
	<div class="pagination" style='margin:0px;'>

	  	<ul>
			<li><a href='certificados.php?producto_id=<?php echo $producto_id;?>'>Gestionar Certificados</a></li>
			<li class='active'><a href='certificados-usuarios.php?producto_id=<?php echo $producto_id;?>'>Habilitar Usuarios</a></li>
	  	</ul>

	  	<span  style='float:right;'>Tipos de Certificados:
		  	<select name='sel_certificado' id='sel_certificado'>
		  		<?php
		  		foreach($Certificados as $c){
		  			echo "<option value='{$c['id']}'".(($c['id']==$certificado_id) ? 'selected="selected"' : '').">{$c['nombre']}</option>";
		  		}
		  		?>
		  	</select>
	  	</span>

	</div>

	<div class="pagination" style='margin:0px; margin-top:10px;'>
	  <ul>
	<?php
		echo "<li class='".($letra=='todos' ? 'active' : '')."'><a href='certificados-usuarios.php?letra=todos&producto_id=$producto_id&certificado_id=$certificado_id'>Todos</a></li>";
		foreach($Letras as $l){
			echo "<li  class='".($letra==$l['letra'] ? 'active' : '')."' >";
			echo "<a href='certificados-usuarios.php?letra={$l[letra]}&producto_id=$producto_id&certificado_id=$certificado_id'>".strtoupper($l[letra])."</a></li>";
            if (empty($letra)) { $letra = $l['letra'];}
		}
	?>
	  </ul>
	</div>


	<table class='table' style='font-size:14px;'>
		<tr>
			<th style='width:20px;'>&nbsp;</th>
			<th style='width:70px;'>Fec.Inscripción</th>
			<th style='width:70px;'>Fec.Pago</th>		
			<th style='width:60px;'>Importe</th>		
			<th >Email</th>
			<th >Apellido, Nombre</th>
			<th nowrap style='height:24px;vertical-align:middle;'>
				<?php
					$todos = URL."/account/certificados-usuarios.php?accion=todos&letra=$letra&producto_id=$producto_id&certificado_id=$certificado_id";
					$ninguno = URL."/account/certificados-usuarios.php?accion=ninguno&letra=$letra&producto_id=$producto_id&certificado_id=$certificado_id";
				?>
				Certificado de <?php echo $certificado_nombre;?>
				<small style='float:right;font-weight:normal;'>Seleccionar: 
					<a href='<?php echo $todos;?>' class='btn btn-small' onclick="return confirm('Está seguro de seleccionar todos los de la lista?');">Todos</a>
					<a href='<?php echo $ninguno;?>' class='btn btn-small' onclick="return confirm('Está seguro de eliminar la selección a todos los de la lista?');">Ninguno</a>
				</small>
			</th>
		</tr>
<?php 
	$i = 0;
	foreach($Inscriptos as $c) { 
		$i++;
		if ($color=="#FFFFFF") {$color="#FEFFCC"; } else {$color="#FFFFFF";}
?>
		
		<tr bgcolor="<?php echo $color;?>" >
			
			<td nowrap='nowrap' style='height:24px;vertical-align:middle;text-align:right;padding-right:5px;'><?php echo $i;?> -</td>
			
			<td nowrap style='height:24px;vertical-align:middle;'><?php echo date("d.m.Y",$c['fecha']);?></td>
			<td nowrap style='height:24px;vertical-align:middle;'>
				<?php if($c['fecha_de_pago']>0 ){ echo date("d.m.Y",$c['fecha_de_pago']); }?>
			</td>
			<td nowrap style='height:24px;vertical-align:middle; text-align:right;padding-right:10px;'>
				<?php if($c['importe']>0 ){ echo number_format($c['importe'],2).' '.$Monedas[$c['moneda_id']]; }?>
			</td>
			
			<td nowrap style='height:24px;vertical-align:middle;'><?php echo $c['email'];?>&nbsp;</td>
			<td nowrap style='height:24px;vertical-align:middle;'><?php echo $c['apellido'].", ".$c['nombre'];?>&nbsp;</td>
			
			<td nowrap style='height:24px;vertical-align:middle; text-align:center;'>
				<?php
					if( isset($arrRegistrados[$c[id]])){
						echo "<input type='checkbox' class='sel_chk' id='sel_" . $c['id']. "' checked='checked' value='1'>";
					} else {
						echo "<input type='checkbox' class='sel_chk' id='sel_" . $c['id']. "' value='0'>";
					}
				?>
			</td>

		</tr>

<?php } ?>
	</table>
</div>

<script>
	$(document).ready(function() { 
		//----------------------------------------------------
		//                     Select de cambio de certificado
		//----------------------------------------------------
		$("#sel_certificado").change( function(){
			var nuevo_certificado = $("#sel_certificado").val();
			window.location.href = '<?php echo URL;?>/account/certificados-usuarios.php?letra=todos&producto_id=<?php echo $producto_id;?>&certificado_id='+nuevo_certificado;
		});


		//---------------------------------------------------
		//        Si clickeo algun check, actualizo el estado
		//---------------------------------------------------
		$(".sel_chk").click( function(e){		

			var actual_value = e['target']['value'];
			var chk_id       = e['target']['id'];

			$("#"+chk_id).attr('disabled', true);
			
			var x            = chk_id.split('_');
			var inscripto_id = x[1];

			$.ajax({
				url: '<?php echo URL;?>/account/certificados-usuarios.php?accion=cambiar-estado&inscripto_id='+inscripto_id+'&producto_id=<?php echo $producto_id;?>&certificado_id=<?php echo $certificado_id;?>',
				success: function(data) {
					console.log(data);
					if(data==1){
						$("#"+chk_id).val(1);
						$("#"+chk_id).attr('checked', true);
					} else {
						$("#"+chk_id).val(0);
						$("#"+chk_id).attr('checked', false);
					}
				}
			});        

			$("#"+chk_id).attr('disabled', false);

			
		});


	}); 

	$('.pop').popover();
</script>
