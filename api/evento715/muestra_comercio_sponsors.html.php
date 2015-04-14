<?php if (!empty($Sponsors)) { ?>
	<?php foreach($Sponsors as $x){ ?>

		<?php  $color = iif ($color=='#FFF', '#F2F2F2', '#FFF'); ?>
		<?php if(!empty($x['estilo'])){ $color='#FFF'; ?>
				
				<div class='clear'></div>
				<<?php echo $x['estilo'];?> class='autoridades' style='width:100%;display:block;' ><?php echo $x['nombre'];?></<?php echo $x['estilo'];?> >

		<?php } else { ?>
				
				<div class='sponsor'>

					<?php $foto_perfil = iif(!empty($x['archivo']) , VER_ARCHIVOS.'/'.$x['archivo'] , URL.'/img/sin_foto_perfil.jpg' );?>
					<?php if(!empty($x['web']) ) { ?>
						<a href='<?php echo $x['web'];?>' target='_blank' title='Visitar la página web'>
							<img src='<?php echo $foto_perfil;?>' class='sponsor_logo' title='<?php $x['nombre'];?>' />
						</a>
					<?php } else { ?>
						<img src='<?php echo $foto_perfil;?>' class='sponsor_logo' title='<?php $x['nombre'];?>' />
					<?php } ?>
					<div class='sponsor_nombre'>
						<?php echo trim($x['nombre']);?> 
					</div>
					<div class='sponsor_descripcion' ><?php echo trim($x['descripcion']);?></div>
				
				
				</div>
			
		<?php } ?>		

	<?php  } //endforeach ?>
	

<?php } //endif ?>
