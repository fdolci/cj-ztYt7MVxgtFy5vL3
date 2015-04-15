<?php include('blog_comentarios.php');?>
	
	<?php 
		if ( $Pub['slide_id']>0 ) {
			// La publicacion tiene marcado que debe mostrar un slide
			echo slide($Pub['slide_id']);
			echo "<br><br>";
		} //end if slide 
	?>

	<h1><?php echo stripslashes($Pub['titulo']); ?></h1>
	
	<div class='detalle_blog' style='text-align:right;'>
		<?php echo fecha_larga($Pub['fecha']);?>&nbsp;|&nbsp;
	    	<a href="#ancla_comentarios" title='Ver Comentarios'><?php echo $cuantos_comentarios;?> comentarios</a>&nbsp;|&nbsp;
			<a href="<?php echo $Pub['urlamigable'];?>" title="permalink a: <?php echo $Pub['titulo'];?>">permalink</a>
			<br>
			<!-- ........................................... TAGS ..................................... -->
			<?php if(!empty($Pub['tags1']) ){ ?>
				<?php $xtags = explode(',',$Pub['tags1']);?>
		        	<div class='detalle_blog' style='float:left;width:100%;background: #F7F7F7; margin:5px auto;'>
		            	<b>Tags:</b>
		                <?php foreach($xtags as $tags) { ?>
		                	<a href='<?php echo URL;?>/blog/tags/<?php echo urlencode(trim($tags));?>' title='<?php echo $tags;?>' ><?php echo trim($tags);?></a>&nbsp,
		                <?php } //end foreach tags ?>
		            </div>
	        <?php } ?>

	</div>
	<div class='clear'></div>

	<div style='margin:15px 0px;'><?php include(ROOT.'/html/inc_barra_sharethis.html.php') ?>    </div>	
	<div class='clear'></div>
	
	
	<p style='margin-bottom:20px;'>
		<?php /* if(!empty($Pub['thumbs'])) { ?>
			<img src="<?php echo $Pub['thumbs'];?>" alt='<?php echo $Pub['titulo'];?>' class="img_listado" style='margin-right:10px;'>
		<?php }*/ ?>
		<?php echo $Pub['copete'];?>
	</p>
	<p>	
		<?php if(!empty($Pub['contenido'])){ echo stripslashes($Pub['contenido'])."<br><br>";} ?>
	</p>
					
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
	<?php } // end if galeria de fotos?>
		

	<?php if ($Pub['comentarios'] == 1) {?>

		<?php include('html/blog_comentarios.html.php');?>

	<?php } ?>

</div> <!-- end div grid_9 -->



<div class='clear'></div>
<?php //pr($RedesSociales);?>