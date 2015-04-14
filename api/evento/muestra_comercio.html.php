<div class='muestra_aviso '>
	<img src='<?php echo $Producto['miniatura'];?>' style='float:left;margin-right:20px; width:180px;min-width:180px !important;'>
	<h1 style='float:right;width:auto;'><?php echo $Producto['titulo'];?></h1>
	<h2 style='text-align:right;font-size:16px;float:right;width:auto;margin-top:70px;'><?php echo nl2br($Producto['subtitulo']);?></h2>

	<div class='clear'></div>
			
    <ul class="tabs" style='margin-bottom:40px;'>
	
		<?php if(!empty($Producto['afiche'])){ ?>
			<!-- Ficha Tecnica -->
			<li style='margin-left:0px;border-left:none;'>
				<a href="#p_afiche">
					<img src='<?php echo URL;?>/img/p_afiche.png'  class='img_pesta'> Afiche
				</a>
			</li>
		<?php } ?>
	
	
		<!-- Ficha Tecnica -->
        <li style='margin-left:0px;border-left:none;'>
			<a href="#p_ficha">
				<img src='<?php echo URL;?>/img/p_ficha.png'  class='img_pesta'> Ficha
			</a>
		</li>
		
		<!-- Organizacion -->
        <li>
			<a href="#p_organiza">
				<img src='<?php echo URL;?>/img/p_organiza.png' class='img_pesta'> <?php echo $tabs_name['organiza'];?>
			</a>
		</li>
				
   		<?php if(!empty($Producto['auspicios'])){?>
			<!-- Auspicios -->
		   	<li>
				<a href="#p_auspicios">
					<img src='<?php echo URL;?>/img/p_auspicios.png' class='img_pesta'> <?php echo $tabs_name['auspicios'];?>
				</a>
			</li>
        <?php } ?>
				
        <?php if(!empty($Autoridades)){?>
			<!-- Autoridades -->
        	<li>
				<a href="#p_autoridades">
					<img src='<?php echo URL;?>/img/p_autoridades.png' class='img_pesta'> <?php echo $tabs_name['autoridades'];?>
				</a>
			</li>
		<?php } ?>		        	

   		<?php if(!empty($Disertantes)){?>
			<!-- Disertantes -->
		   	<li>
				<a href="#p_disertantes">
					<img src='<?php echo URL;?>/img/p_disertantes.png' class='img_pesta'> <?php echo $tabs_name['disertantes'];?>
				</a>
			</li>
		<?php } ?>
   		
        <?php if(!empty($Producto['cronograma'])){?>
			<!-- Cronograma -->
        	<li>
				<a href="#p_cronograma">
					<img src='<?php echo URL;?>/img/p_cronograma.png' class='img_pesta'> <?php echo $tabs_name['cronograma'];?>
				</a>
			</li>
        <?php } ?>

		<?php if(!empty($Producto['areas_tematicas'])){?>
			<!-- Areas Tematicas -->
		   	<li>
				<a href="#p_areas">
					<img src='<?php echo URL;?>/img/p_areas.png' class='img_pesta'> <?php echo $tabs_name['areas'];?>
				</a>
			</li>
		<?php } ?>		        	
   		
        <?php if(!empty($Producto['trabajos'])){?>
			<!-- Presentación de Trabajos -->
        	<li>
				<a href="#p_trabajos">
					<img src='<?php echo URL;?>/img/p_trabajos.png' class='img_pesta'> <?php echo $tabs_name['trabajos'];?>
				</a>
			</li>
   		<?php } ?>

		<?php if(!empty($Sponsors)){?>
			<!-- Sponsors -->
			<li>
				<a href="#p_sponsors">
					<img src='<?php echo URL;?>/img/p_sponsors.png' class='img_pesta'> <?php echo $tabs_name['sponsors'];?>
				</a>
			</li>
		<?php } ?>		        	

		<?php if(!empty($Producto['inscripcion'])){?>
			<!-- Inscripcion -->
			<li>
				<a href="#p_inscripcion">
					<img src='<?php echo URL;?>/img/p_inscripcion.png' class='img_pesta'> Inscripción</a>
				</li>
		<?php } ?>

		<?php if(!empty($Imagenes)){?>
			<!-- Galeria de Imagenes -->
			<li>
				<a href="#p_imagenes">
					<img src='<?php echo URL;?>/img/p_imagenes.png' class='img_pesta'> Imagenes
				</a>
			</li>
    	<?php } ?>

		<?php if(!empty($Archivos)){?>
			<!-- Descarga de Archivos -->
			<li>
				<a href="#p_archivos">
					<img src='<?php echo URL;?>/img/p_descarga.png' class='img_pesta'>  Material para Descargar
				</a>
			</li>		    	
		<?php } ?>

		<!-- Alojamientos -->
		<li>
			<a href="#p_alojamientos">
				<img src='<?php echo URL;?>/img/p_alojamientos.png' class='img_pesta'> Alojamientos
			</a>
		</li>		    	

		<!-- Contacto -->
        <li>
			<a href="#p_contacto">
				<img src='<?php echo URL;?>/img/p_contacto.png' class='img_pesta'> Consulta
			</a>
		</li>

	</ul>

	<div class="tab_container" style='margin-bottom:30px;' >
			
			
			<?php if(!empty($Producto['afiche'])){ ?>
				<div id="p_afiche" class="tab_content">
       			    <img src='<?php echo $Producto['afiche'];?>' style='width:100%;' >
		        </div>
			<?php } ?>
			
			
			
			
		        <div id="p_ficha" class="tab_content">
		            <?php include(ROOT.'/api/evento/muestra_comercio_ficha.html.php'); ?>
		        </div>
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
			        <div id="p_autoridades" class="tab_content flexcroll" style='height:600px;'>
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

		<?php include(ROOT."/api/evento/inc_barra_sharethis.html.php");?>						    
	</div>
	<div class='clear' style="margin-bottom:10px;"></div>
	
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#IDofControlFiringResizeEvent").click(function () {
            var frame = $('#IDofiframeInMainWindow', window.parent.document);
            var height = jQuery("#IDofContainerInsideiFrame").height();
            frame.height(height + 15);
        });
    });
</script>	
	
<?php //pr($Producto);?>