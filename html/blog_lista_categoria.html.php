<div style='min-height:500px;display:block;clear:both;'>

			<?php if ( $Categoria['slide_id']>0 ) { ?>
				    <?php echo slide($Categoria['slide_id']); ?>
				    <br><br>
			<?php } //end if slide ?>

	        <?php foreach($Publicaciones as $pub) { ?>        

	        			<?php $Pub['id'] = $pub['id'];?>
	        			<?php include('blog_comentarios.php');?>

	                    <h1 style='margin-bottom:1px;'><a href="<?php echo $pub['urlamigable'];?>" title="<?php echo $pub['titulo'];?>"><?php echo $pub['titulo'];?></a></h1>
	                    <div class='detalle_blog'>
	                    	<?php echo fecha_larga($pub['fecha']);?>&nbsp;|&nbsp;
	                    	<?php echo $cuantos_comentarios;?> comentarios&nbsp;|&nbsp;
							<a href="<?php echo $pub['urlamigable'];?>" title="permalink a: <?php echo $pub['titulo'];?>">permalink</a>
	                    </div>
	                    <p class='texto'>
								<?php if(!empty($pub['thumbs'])) { ?>
									<img src="<?php echo $pub['thumbs'];?>" style="width:150px;height:110px;float:left; margin-right:10px;" >
								<?php }?>
								<?php echo trim(stripslashes($pub['copete'])) ;?>
						</p>

						<!-- ........................................... TAGS ..................................... -->
						<?php if(!empty($pub['tags1']) ){ ?>
							<?php $xtags = explode(',',$pub['tags1']);?>
		                    <div class='detalle_blog' style='float:left;width:100%;background: #F7F7F7; margin:5px auto;'>
		                    	<b>Tags:</b>
		                    	<?php foreach($xtags as $tags) { ?>
		                    		<a href='<?php echo URL;?>/blog/tags/<?php echo urlencode(trim($tags));?>' title='<?php echo $tags;?>' ><?php echo trim($tags);?></a>&nbsp,
		                    	<?php } //end foreach tags ?>
		                    </div>
	                    <?php } ?>

	                    <div style="margin-top:-10px;claer:both;">
	                       <a href="<?php echo $pub['urlamigable'];?>" class='ampliar' style='font-style:oblique;font-size:13px;'><?php echo $Traducciones['seguir_leyendo'];?></a>
	                    </div>
	                

	                <div class="clear"></div>
	                <hr style="border-bottom: 1px dashed #CCC;margin:15px 0px 15px 0px;"/>
	        <?php } ?>
	    
<?php /*

	<div class="grid_3 ">
		<?php if (!empty($Modulo_4)) { echo $Modulo_4;  }?>
		<div style="display:block;clear:both;margin-top:-30px;">
			<?php include('formulario_rapido.html.php');?>
		</div>

		<?php include('html/compartir_en_redes_sociales.html.php'); ?>

	</div>
*/?>

	<?php include_once( ROOT.'/html/paginador.html.php');  ?>

</div> <!-- end min-height 500 -->
<div class='clear'></div>

</div>