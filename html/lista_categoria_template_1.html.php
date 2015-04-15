<div class="grid_12" style="margin-top:20px;">
	<h1><?php echo $Categoria['titulo'];?></h1>
	<?php if ($Categoria['muestra_cuerpo']==1){ echo $Categoria['cuerpo']; } ?>
</div>
<div class='clear'></div>
<div style='min-height:500px;display:block;clear:both;'>
	<?php if(!empty($Modulo_4)  or !empty($ConsultaRapida[4]) ) {  ?>
		<div class="grid_9 ">
	        <?php foreach($Publicaciones as $pub) { ?>        
	                <div class="grid_9" style="min-height:100px; width:650px;">
	                    <h2><a href="<?php echo URL;?><?php echo $pub['urlamigable'];?>" title="<?php echo $pub['titulo'];?>"><?php echo $pub['titulo'];?></a></h2>
							<?php if(!empty($pub['thumbs'])) { ?>
								<div class='grid_2'>
								<img src="<?php echo $pub['thumbs'];?>" style="width:140px;float:left; margin-right:10px;" >
								</div>
							<?php }?>
							<div class='grid_6'>
			                    <p class='texto'>
									<?php //echo substr(strip_tags(stripslashes($pub['copete']), ENT_NOQUOTES),0,450);?>
									<?php echo substr(stripslashes($pub['copete']),0,450);?>
								</p>
							</div>
	                    <div style="margin-top:-10px;">
	                       <a href="<?php echo URL;?><?php echo $pub['urlamigable'];?>" class='ampliar'><?php echo $Traducciones['mas_detalles'];?></a>
	                    </div>
	                
	                </div>
	                <div class="clear"></div>
	                <hr style="border-bottom: 1px dashed #CCC;margin:5px 0px 5px 0px;"/>
	        <?php } ?>
	    
		</div>

		<div class="grid_3 ">
			<?php if(!empty($Modulo_4)) {  echo $Modulo_4; } ?>
			
			<?php if ($Pub['form_contacto'] == 1 or !empty($ConsultaRapida[4]) ) {?>
				<div style="display:block;clear:both;margin-top:20px;">       
					<?php include('formulario_rapido.html.php');?>
				</div>
			<?php } ?>
		</div>
	<? } else { ?>

	       <?php foreach($Publicaciones as $pub) { ?>        
				
					<div class='grid_2'>
						<?php if(!empty($pub['thumbs'])) { ?>
							<a href="<?php echo $pub['href'];?>" title='<?php echo $pub['titulo'];?>'>
								<img src="<?php echo $pub['thumbs'];?>" alt='<?php echo $pub['titulo'];?>' class="img_listado" >
							</a>
						<?php }?>
					</div>
				
					<div class='grid_10'>
	                    <h3><a href="<?php echo $pub['href'];?>" title="<?php echo $pub['titulo'];?>"><?php echo $pub['titulo'];?></a></h2>
	                    <p class='texto'>
							<?php echo substr(stripslashes($pub['copete']),0,450);?>
							<a href="<?php echo $pub['href'];?>" class='ampliar'><?php echo $Traducciones['mas_detalles'];?></a>
						</p>
					</div>	
	                <div class="clear"></div>
	                <hr style="border-bottom: 1px dashed #CCC;margin:10px 0px 10px 0px;"/>
	        <?php } ?>

	<?php } ?>

</div> <!-- end min-height 500 -->
<div class='clear'></div>

