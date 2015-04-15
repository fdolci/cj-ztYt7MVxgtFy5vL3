		<?php if ( $Pub['slide_id']>0 ) { ?>
		    <?php echo slide($Pub['slide_id']); ?>
		    <br><br>
		<?php } //end if slide ?>


		<h1><?php echo stripslashes($Pub['titulo']); ?></h1>
		<div class='grid_2 alpha'>
				<?php if(!empty($Pub['thumbs'])) { ?>
					<img src="<?php echo $Pub['thumbs'];?>" alt='<?php echo $Pub['titulo'];?>' class="img_listado" >
				<?php }?>
		</div>
		<div class='grid_7 alpha' style='font-weight:bold;'>
			<?php echo $Pub['copete'];?>
		</div>
		<div class='clear'></div>

			<?php if(!empty($Pub['contenido'])){ echo stripslashes($Pub['contenido'])."<br><br>";} ?>
					
			<?php if (!empty($Pub['galeria_fotos'])) { ?>
			<div class='clear'></div>
			<div class="separador" style='display:block;'>&nbsp;&nbsp;&nbsp;<?php echo $Traducciones['titulo_galeria'];?></div>
				<script type="text/javascript">
					$(function() {
					$('#gallery a').lightBox({fixedNavigation:true});
					});
				</script>    

				<div id="gallery">
					<?php foreach ($Pub['galeria_fotos'] as $f){ ?>
						<a href="<?php echo $f['archivo'];?>" title="<?php echo htmlspecialchars_decode($f['nombre'], ENT_NOQUOTES);?>">
						<img src="<?php echo $f['archivo'];?>" width="100" height="100" alt="<?php echo htmlspecialchars_decode($f['nombre'], ENT_NOQUOTES);?>" class="foto_galeria"/></a>            
					<?php } ?>    
				</div>
				</div class='clear'></div>
			<?php } ?>
		

</div>
<div class='clear'></div>
<?php //pr($RedesSociales);?>