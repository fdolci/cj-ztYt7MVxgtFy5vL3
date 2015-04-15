<?php echo $Producto['inscripcion'];?>


<?php if (!empty($Aranceles)) { ?>
	
	<h3 style='margin-top:30px;'>Tabla de Aranceles</h3>
	<table class="table table-condensed">
		<tr>
			<th >Descripción</th>
			<?php if($Producto['vencimiento1']>0){?>
				<th style="width:70px;text-align:center">Vencimiento<br><?php echo date("d/m/Y",$Producto['vencimiento1']);?></th>
			<?php } ?>
			<?php if($Producto['vencimiento2']>0){?>
				<th style="width:70px;text-align:center">Vencimiento<br><?php echo date("d/m/Y",$Producto['vencimiento2']);?></th>
			<?php } ?>

			<th style="width:70px;text-align:center;">Vencimiento<br><?php echo date("d/m/Y",$Producto['vencimiento3']);?></th>
			<th style="width:20px;text-align:center;">Moneda</th>
		</tr>

		<?php foreach($Aranceles as $x){ ?>

			<?php  $color = iif ($color=='#FFF', '#F2F2F2', '#FFF'); ?>
			<tr style='background:<?php echo $color;?>'>
				<td ><?php echo $x['descripcion'];?></td>
				<?php if($Producto['vencimiento1']>0){?>
					<td style="text-align:center"><?php echo number_format($x['vto_1'],2);?></td>
				<?php } ?>
				<?php if($Producto['vencimiento2']>0){?>
					<td style="text-align:center"><?php echo number_format($x['vto_2'],2);?></td>
				<?php } ?>

				<td style="text-align:center"><?php echo number_format($x['vto_3'],2);?></td>
				<td style="text-align:center;"><?php echo $Monedas[$x['moneda_id']];?></td>
			</tr>

			
		<?php  } //endforeach ?>
	</table>	
<?php } //endif ?>

<?php if( !empty($Producto['email_inscripcion']) ){ ?>
	<?php include(ROOT.'/html/formulario_inscripcion.html.php');?>
<?php } ?>
