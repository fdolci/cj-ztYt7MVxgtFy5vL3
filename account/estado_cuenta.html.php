<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>
<div class='grid_12' style='min-height:400px;'>    

	<?php if (isset($data)){ ?>
		
		<script type="text/javascript" src="<?php echo URL;?>/js/table_sorter/jquery.tablesorter.js"></script> 
		<link rel="stylesheet" href="<?php echo URL;?>/js/table_sorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
		<table id="myTable" class="tablesorter">
			<thead> 
				<tr>
					<th>Vencimiento</th>
					<th>Plan</th>
					<th style='width:100px;'>Cant.Avisos</th>
					<th>Vigencia</th>
					<th>Importe</th>
					<th style='text-align:center;'>Fecha de Pago</th>
				</tr>
			</thead>
			<tbody> 
				<?php $i=1; $class = 'odd'?>
				<?php foreach($data as $p){?>
					<?php $class = iif($class=='odd','even','odd');?>
					<tr style='border-bottom:1px solid #CCC;' class='<?php echo $class;?>' >
						<td><?php echo date("d/m/Y",$p['vencimiento']);?></td>
						<td><?php echo $p['plan_usuarios'];?></td>
						<td style='text-align:left;'><?php echo $p['cantidad_avisos'];?></td>
						<td style='text-align:left;'><?php echo $p['renovacion'];?> días</td>
						<td style='text-align:left;'><?php echo number_format($p['importe'],2,',','.').' '.$p['signo'];?></td>
						<td style='text-align:center;'>
							<?php 	
								if($p['fecha_pago'] > 0 ){ 
									echo date("d/m/Y",$p['fecha_pago']);
								} else {
									echo "<a href='estado_cuenta_pagar.php?estado_id={$p['id']}' title='Pagar Ahora'>Realizar el Pago</a>";
								}		
							?>
						</td>
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
					2: { sorter: false },
					3: { sorter: false },
					4: { sorter: false },
					5: { sorter: false },
					6: { sorter: false },

				} 
			});


		}); 
		</script>

	<?php } else {?>

		<h2>No tiene Anuncios vigentes</h2>

	<?php } ?>
</div>
<div class='clear'></div>
<?php //pr($data);?>