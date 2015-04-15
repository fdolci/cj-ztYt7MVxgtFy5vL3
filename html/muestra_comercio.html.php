<script type="text/javascript" src="<?php echo URL;?>/js/menupestanas/menupestanas.js"></script>
<link rel="stylesheet" href="<?php echo URL;?>/js/menupestanas/menupestanas_v.css" type="text/css" media="screen" />    
<link rel="stylesheet" href="<?php echo URL;?>/css/muestra_producto.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />

<div class='muestra_aviso '>
	<table style='width:100%;'>
		<?php if(isset($Producto['banner']) and !empty($Producto['banner']) ){ ?>
			<tr>
				<td colspan='3'>
					<img src='<?php echo $Producto['banner'];?>' style='width:950px;max-height:220px;margin-bottom:10px;'>
				</td>
			</tr>
		<?php } ?>
	
		<tr>
			<td colspan='2'><h1 ><?php echo $Producto['titulo'];?></h1></td>
			<td style='padding:10px;text-align:center;border:1px solid #DDD;vertical-align:middle;background:#F9F9F9;' rowspan='2'>
   				<div id='banner_ra'>¿Buscas alojamiento en Rosario?</div>
				<a href='http://www.RosarioAlojamientos.com' target='_blank' title='Guía de Hoteles y Alojamientos de Rosario'>
				<img src='<?php echo URL;?>/img/rosario_alojamientos.png' style='width:200px;'></a>
				<div id='banner_ra_2'>La más completa <b>Guía de Hoteles y Alojamientos de Rosario</b></div>
   			</td>
		
		</tr>
		<tr>
			<td style='width:160px;'><img src='<?php echo $Producto['miniatura'];?>' style='width:150px;margin-right:25px;max-width:150px;'></td>
			<td style='width:500px;'>
   				<h2 style='text-align:center;font-size:16px;'><?php echo nl2br($Producto['subtitulo']);?></h2>
   			</td>
   		</tr>
   	</table>
	<div class='clear'></div>
			
			
			<?php include(ROOT."/html/inc_barra_sharethis.html.php");?>					
			
		    <ul class="tabs" >
		        <li style='margin-left:0px;border-left:none;'><a href="#p_ficha"><img src='<?php echo URL;?>/img/p_ficha.png'  class='img_pesta'> Ficha</a></li>
		        <li><a href="#p_organiza"><img src='<?php echo URL;?>/img/p_organiza.png' class='img_pesta'> <?php echo $tabs_name['organiza'];?></a></li>
				
   		        <?php if(!empty($Producto['auspicios'])){?>
		        	<li><a href="#p_auspicios"><img src='<?php echo URL;?>/img/p_auspicios.png' class='img_pesta'> <?php echo $tabs_name['auspicios'];?></a></li>
		        <?php } ?>
				

		        <?php if(!empty($Autoridades)){?>
		        	<li><a href="#p_autoridades"><img src='<?php echo URL;?>/img/p_autoridades.png' class='img_pesta'> <?php echo $tabs_name['autoridades'];?></a></li>
				<?php } ?>		        	

   		        <?php if(!empty($Disertantes)){?>
		        	<li><a href="#p_disertantes"><img src='<?php echo URL;?>/img/p_disertantes.png' class='img_pesta'> <?php echo $tabs_name['disertantes'];?></a></li>
		        <?php } ?>
   		        <?php if(!empty($Producto['cronograma'])){?>
		        	<li><a href="#p_cronograma"><img src='<?php echo URL;?>/img/p_cronograma.png' class='img_pesta'> <?php echo $tabs_name['cronograma'];?></a></li>
		        <?php } ?>

		        <?php if(!empty($Producto['areas_tematicas'])){?>
		        	<li><a href="#p_areas"><img src='<?php echo URL;?>/img/p_areas.png' class='img_pesta'> <?php echo $tabs_name['areas'];?></a></li>
				<?php } ?>		        	
   		        <?php if(!empty($Producto['trabajos'])){?>
   		        	<li><a href="#p_trabajos"><img src='<?php echo URL;?>/img/p_trabajos.png' class='img_pesta'> <?php echo $tabs_name['trabajos'];?></a></li>
   		        <?php } ?>

		        <?php if(!empty($Sponsors)){?>
		        	<li><a href="#p_sponsors"><img src='<?php echo URL;?>/img/p_sponsors.png' class='img_pesta'> <?php echo $tabs_name['sponsors'];?></a></li>
				<?php } ?>		        	

		        <?php if(!empty($Producto['inscripcion'])){?>
		        	<li><a href="#p_inscripcion"><img src='<?php echo URL;?>/img/p_inscripcion.png' class='img_pesta'> Inscripción</a></li>
		        <?php } ?>
		        <?php if(!empty($Imagenes)){?>
					<li><a href="#p_imagenes"><img src='<?php echo URL;?>/img/p_imagenes.png' class='img_pesta'> Imagenes</a></li>
		    	<?php } ?>
		    	<?php if(!empty($Archivos)){?>
					<li><a href="#p_archivos"><img src='<?php echo URL;?>/img/p_descarga.png' class='img_pesta'>  Archivos para Descargar</a></li>		    	
				<?php } ?>

				<li><a href="#p_alojamientos"><img src='<?php echo URL;?>/img/p_alojamientos.png' class='img_pesta'> Turismo y Alojamientos</a></li>		    	
<?php /*
				<li><a href="#p_gastronomia"><img src='<?php echo URL;?>/img/p_gastronomia.png' class='img_pesta'> Gastronomía</a></li>		    	
*/ ?>
		        <li><a href="#p_contacto"><img src='<?php echo URL;?>/img/p_contacto.png' class='img_pesta'> Contacto / Consulta</a></li>

<?php /* 				
				<?php if(!empty($Producto['twitter'])){;?>
					<li style='height:30px;background:#FFF;border:none;padding:10px 0px;vertical-align:middle;'>
						<div id='cuenta_twitter' > <?php echo $Producto['twitter'];?></div>
					</li>
				<?php } ?>

				<?php if(!empty($Producto['facebook'])){;?>
					<li style='height:470px;background:#FFF;border:none;padding:10px 0px;'>
						<div id="fb-root"></div>
							<script>(function(d, s, id) {
										  var js, fjs = d.getElementsByTagName(s)[0];
										  if (d.getElementById(id)) return;
										  js = d.createElement(s); js.id = id;
										  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=<?php echo $Config['facebook_app_id'];?>";
										  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>

						<div class="fb-like-box" data-href="<?php echo $Producto['facebook'];?>" 
							data-width="210" data-height="450" data-show-faces="true" data-stream="false" data-header="true" 
								style="background-color: #FFF;margin-left:0px;border:none;"></div>
					</li>
				<?php } ?>
*/?>
			</ul>

		    <div class="tab_container" style='margin-bottom:30px;' >
		        <div id="p_ficha" class="tab_content" >
		            <?php include(ROOT.'/html/muestra_comercio_ficha.html.php'); ?>
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
			        <div id="p_autoridades" class="tab_content" style='min-height:407px;position:relative;'>
			            <?php include(ROOT.'/html/muestra_comercio_autoridades.html.php'); ?>
			        </div>
			    <?php } ?>

		        <?php if(!empty($Producto['trabajos'])){?>
		        	<div id="p_trabajos" class="tab_content" style='min-height:407px;'>
		            	<?php echo $Producto['trabajos'];?>
		            </div>
		    	<?php } ?>
				<?php if(!empty($Disertantes)){?>
			        <div id="p_disertantes" class="tab_content" style='min-height:407px;'>
			            <?php include(ROOT.'/html/muestra_comercio_disertantes.html.php'); ?>
			        </div>
			    <?php } ?>
				<?php if(!empty($Producto['cronograma'])){?>
			        <div id="p_cronograma" class="tab_content" style='min-height:407px;'>
			            <?php echo $Producto['cronograma'];?>
			        </div>
			    <?php } ?>

		        <?php if(!empty($Sponsors)){?>
			        <div id="p_sponsors" class="tab_content" style='min-height:407px;'>
			            <?php include(ROOT.'/html/muestra_comercio_sponsors.html.php'); ?>
			        </div>
			    <?php } ?>

			    <?php if(!empty($Producto['inscripcion'])){?>
			        <div id="p_inscripcion" class="tab_content" style='min-height:407px;'>
			            <?php include(ROOT.'/html/muestra_comercio_inscripcion.html.php'); ?>
						
			        </div>
			    <?php } ?>
		        <?php if(!empty($Imagenes)){?>
		        	<div id="p_imagenes" class="tab_content" style='min-height:407px;'>
		            	<?php include(ROOT.'/html/muestra_comercio_imagenes.html.php'); ?>
		            </div>
		    	<?php } ?>
		        <?php if(!empty($Archivos)){?>
		        	<div id="p_archivos" class="tab_content" style='min-height:407px;'>
		            	<?php include(ROOT.'/html/muestra_comercio_archivos.html.php'); ?>
		            </div>
		    	<?php } ?>

		        	<div id="p_alojamientos" class="tab_content" style='min-height:407px;'>
						<?php if(!empty($Alojamientos)){?>
							<h3>Alojamientos Recomendados</h3>
							<?php if (!empty($Alojamientos)) { ?>
								<table width='100%' >

								<?php foreach($Alojamientos as $x){ ?>

									<tr style='margin-bottom:20px; border-top:1px solid #666;'>
										<td >
											<h3><a href='<?php echo $x['href'];?>' title='<?php echo $x['titulo'];?>' target='_ra'><?php echo $x['titulo'];?></a></h3>
											<span class='detalle_hotel'><?php echo nl2br($x['descripcion']);?></span>
										</td>

										<td >
											<a href='<?php echo $x['href'];?>' title='<?php echo $x['titulo'];?>' target='_ra'>
											<img src='<?php echo VER_ALOJAMIENTOS.'/'.$x['archivo'];?>' class='img_detalle_hotel' title="<?php $x['titulo'];?>" />
											</a>
										</td>

									</tr>
								<?php  } //endforeach ?>
								
								</table>
							<?php } //endif ?>
						<?php } else { ?>
							<?php include(ROOT.'/html/muestra_comercio_alojamientos.html.php'); ?>
						<?php } ?>
		            </div>


		        	<div id="p_gastronomia" class="tab_content" style='min-height:407px;'>
						<?php if(!empty($Gastronomia)){?>
							<h3>Establecimientos Gastronómicos Destacados</h3>
							<?php if (!empty($Gastronomia)) { ?>
								<table width='100%' >

								<?php foreach($Gastronomia as $x){ ?>

									<tr style='margin-bottom:20px; border-top:1px solid #666;'>
										<td >
											<h3><a href='<?php echo $x['href'];?>' title='<?php echo $x['titulo'];?>' target='_ra'><?php echo $x['titulo'];?></a></h3>
											<span class='detalle_hotel'><?php echo nl2br($x['descripcion']);?></span>
										</td>

										<td >
											<a href='<?php echo $x['href'];?>' title='<?php echo $x['titulo'];?>' target='_ra'>
											<img src='<?php echo VER_ALOJAMIENTOS.'/'.$x['archivo'];?>' class='img_detalle_hotel' title="<?php $x['titulo'];?>" />
											</a>
										</td>

									</tr>
								<?php  } //endforeach ?>
								
								</table>
							<?php } //endif ?>
						<?php } else { ?>
							<?php include(ROOT.'/html/muestra_comercio_gastronomia.html.php'); ?>
						<?php } ?>
		            </div>
					
					
	        	<div id="p_contacto" class="tab_content" style='min-height:407px;'>
	            	<?php include(ROOT.'/html/muestra_comercio_contacto.html.php'); ?>
	            </div>

		    </div>


	    </div>	

		<?php include(ROOT."/html/inc_barra_sharethis.html.php");?>		    
	</div>
	<div class='clear' style="margin-bottom:10px;"></div>
<?php //pr($Producto);?>