<div class='muestra_aviso '>
	<table style='width:97%;'>
		<tr>
			<td style='width:450px;'>
				<h1 ><?php echo $Producto['titulo'];?></h1>
				<h2 style='text-align:center;font-size:16px;'><?php echo nl2br($Producto['subtitulo']);?></h2>
			</td>
			<td style='padding:10px;text-align:center;border:1px solid #DDD;vertical-align:middle;background:#F9F9F9;'>
   				<div id='banner_ra'>¿Buscas alojamiento en Rosario?</div>
				<a href='http://www.RosarioAlojamientos.com' target='_blank' title='Guía de Hoteles y Alojamientos de Rosario'>
				<img src='<?php echo URL;?>/img/rosario_alojamientos.png' style='width:200px;'></a>
				<div id='banner_ra_2'>La más completa <b>Guía de Hoteles y Alojamientos de Rosario</b></div>
   			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<?php //include(ROOT."/api/evento/inc_barra_sharethis.html.php");?>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				Menú de Navegación: 
					<select name='menu_navegacion' id='menu_navegacion'>
						<?php if(!empty($Producto['afiche'])){ ?>
							<option value='p_afiche'>Afiche Promocional</option>
						<?php } ?>
						<option value='p_ficha'>Ficha Técnica</option>						
						<option value='p_organiza'><?php echo $tabs_name['organiza'];?></option>
						<?php if(!empty($Producto['auspicios'])){?>
							<option value='p_auspicios'><?php echo $tabs_name['auspicios'];?></option>
						<?php } ?>
						<?php if(!empty($Autoridades)){?>
							<option value='p_autoridades'><?php echo $tabs_name['autoridades'];?></option>
						<?php } ?>		        	
						<?php if(!empty($Disertantes)){?>
							<option value='p_disertantes'><?php echo $tabs_name['disertantes'];?></option>
						<?php } ?>
						<?php if(!empty($Producto['cronograma'])){?>
							<option value='p_cronograma'><?php echo $tabs_name['cronograma'];?></option>
						<?php } ?>
						<?php if(!empty($Producto['areas_tematicas'])){?>
							<option value='p_areas'><?php echo $tabs_name['areas'];?></option>
						<?php } ?>		        	
						<?php if(!empty($Producto['trabajos'])){?>
							<option value='p_trabajos'><?php echo $tabs_name['trabajos'];?></option>						
						<?php } ?>
						<?php if(!empty($Sponsors)){?>
							<option value='p_sponsors'><?php echo $tabs_name['sponsors'];?></option>						
						<?php } ?>		        	
						<?php if(!empty($Producto['inscripcion'])){?>
							<option value='p_inscripcion'>Inscripción</option>
						<?php } ?>
						<?php if(!empty($Imagenes)){?>
							<option value='p_imagenes'>Galería de Imágenes</option>						
						<?php } ?>
						<?php if(!empty($Archivos)){?>
							<option value='p_archivos'>Material para Descargar</option>
						<?php } ?>
						<option value='p_alojamientos'>Alojamientos</option>
						<option value='p_contacto'>Formulario de Contacto</option>

					</select>
			</td>
		</tr>
   	</table>
	<div class='clear'></div>
	<div class="tab_container" style='margin-bottom:30px;' >
		
			<?php if(!empty($Producto['afiche'])){ ?>
				<div id="p_afiche" class="tab_content" style='display:block;'>
       			    <img src='<?php echo $Producto['afiche'];?>' style='width:695px;max-width:695px;' >
		        </div>
		        <div id="p_ficha" class="tab_content">
		            <?php include(ROOT.'/api/evento715/muestra_comercio_ficha.html.php'); ?>
		        </div>
				
			<?php } else { ?>
		        <div id="p_ficha" class="tab_content" style='display:block;'>
		            <?php include(ROOT.'/api/evento715/muestra_comercio_ficha.html.php'); ?>
		        </div>
			<?php } ?>

			<div id="p_organiza" class="tab_content" style='min-height:407px;'>
		            <?php echo $Producto['organiza'];?>
		        </div>
		        <?php if(!empty($Producto['auspicios'])){?>
			        <div id="p_auspicios" class="tab_content" style='min-height:407px;'>
			            <?php echo $Producto['auspicios'];?>
			        </div>
			    <?php } ?>


		        <?php if(!empty($Producto['areas_tematicas'])){?>
			        <div id="p_areas" class="tab_content" style='min-height:407px;'>
			            <?php echo $Producto['areas_tematicas'];?>
			        </div>
			    <?php } ?>
		        <?php if(!empty($Autoridades)){?>
			        <div id="p_autoridades" class="tab_content flexcroll" style='height:900px;'>
			            <?php include(ROOT.'/html/muestra_comercio_autoridades.html.php'); ?>
			        </div>
			    <?php } ?>

		        <?php if(!empty($Producto['trabajos'])){?>
		        	<div id="p_trabajos" class="tab_content flexcroll" style='height:600px;'>
		            	<?php echo $Producto['trabajos'];?>
		            </div>
		    	<?php } ?>
				<?php if(!empty($Disertantes)){?>
			        <div id="p_disertantes" class="tab_content flexcroll" style='height:600px;'>
			            <?php include(ROOT.'/html/muestra_comercio_disertantes.html.php'); ?>
			        </div>
			    <?php } ?>
				<?php if(!empty($Producto['cronograma'])){?>
			        <div id="p_cronograma" class="tab_content flexcroll" style='height:600px;'>
			            <?php echo $Producto['cronograma'];?>
			        </div>
			    <?php } ?>

		        <?php if(!empty($Sponsors)){?>
			        <div id="p_sponsors" class="tab_content flexcroll" style='height:600px;'>
			            <?php include(ROOT.'/html/muestra_comercio_sponsors.html.php'); ?>
			        </div>
			    <?php } ?>

			    <?php if(!empty($Producto['inscripcion'])){?>
			        <div id="p_inscripcion" class="tab_content flexcroll" style='height:600px;'>
			            <?php include(ROOT.'/html/muestra_comercio_inscripcion.html.php'); ?>
						
			        </div>
			    <?php } ?>
		        <?php if(!empty($Imagenes)){?>
		        	<div id="p_imagenes" class="tab_content flexcroll" style='height:600px;'>
		            	<?php include(ROOT.'/html/muestra_comercio_imagenes.html.php'); ?>
		            </div>
		    	<?php } ?>
		        <?php if(!empty($Archivos)){?>
		        	<div id="p_archivos" class="tab_content flexcroll" style='height:600px;'>
		            	<?php include(ROOT.'/html/muestra_comercio_archivos.html.php'); ?>
		            </div>
		    	<?php } ?>

		        	<div id="p_alojamientos" class="tab_content flexcroll" style='height:600px;'>
		            	<?php include(ROOT.'/html/muestra_comercio_alojamientos.html.php'); ?>
		            </div>


	        	<div id="p_contacto" class="tab_content flexcroll" style='height:600px;'>
	            	<?php include(ROOT.'/html/muestra_comercio_contacto.html.php'); ?>
	            </div>

		    </div>


	    </div>	

		<?php //include(ROOT."/api/evento/inc_barra_sharethis.html.php");?>						    
	</div>
	
	
<script>
    $(document).ready(function(){
		$('#menu_navegacion').change(function() {
			var valor = $('#menu_navegacion').val();
			$('.tab_content').hide();
			$('#'+valor).show();
		});
	
	
	
	});
</script>	
	<div class='clear' style="margin-bottom:10px;"></div>
	

<?php //pr($Producto);?>

</body>
