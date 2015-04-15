<h3>Establecimientos Gastronómicos Destacados
	<span class='logo_ra'>
		powered by <a href='http://www.RosarioGastronomia.com.ar' target='_rg' title='RosarioGastronomia.com.ar'>
		<img src='<?php echo URL;?>/img/rosario_gastronomia.png'></a>
	</span>
</h3>

<?php
	$url_api = 'http://www.RosarioGastronomia.com.ar/api/promo_cj/promo_cj.php?evento_id='.$Producto['id'];
	$a       = file_get_contents($url_api);
	$r       = base64_decode($a);
	$result  = json_decode($r,true);
//	pr($result,1);
	
	$contador_familia = 0;
?>	
	<link rel="stylesheet" href="<?php echo URL;?>/css/muestra_alojamientos_ra.css" type="text/css" media="screen" />
	
	<div class="accordion" id="accordion2">
	
	<?php foreach($result as $familia=>$r){ ?>
		<div class="accordion-group">
			<div class="accordion-heading" >
			  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_rg_<?php echo $contador_familia;?>" 
				href="#collapse_rg_<?php echo $contador_familia;?>">
				&raquo; <?php echo $familia;?>
			  </a>
			</div>
			<?php $in = iif($contador_familia==0,'in','');?>
			<div id="collapse_rg_<?php echo $contador_familia;?>" class="accordion-body collapse <?php echo $in;?>">
			  <div class="accordion-inner">

					<?php foreach ($r as $d){ ?>

						<?php 
							if($d['destacado']==1){
								$background = '#FAF2DE';
							} else {
								$background = '#FFF';
							}
							
							
							
						?>
						<div class='c1_ra' style='background:<?php echo $background;?>;'>
							<div class='lista_alojamientos_ra_imagen'>
								<?php if(strlen($d['promociones'])>20) {?>
									<?php $promociones = '<p>'.strip_tags(trim($d['promociones'])).'</p>';?>
									<div class='promociones'></div>
								<?php } else { $promociones=''; } ?>
								<?php if( strlen($d['tarifas'])>20 ) {?>
									<div class='tarifas'></div>
								<?php } ?>

							   <a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?>' target='_blank'>
									<?php if (!empty($d['thumbs'])){ ?>
									   <img src='<?php echo $d['thumbs'];?>' style='width:150px;height:113px;margin:5px;'>
									<?php } else { ?>
										<img src='<?php echo URL;?>/img/logo.png' style='width:150px;height:113px;margin:5px;'>
									<?php } ?>
								</a>

							</div>

							<div class='lista_alojamientos_ra_detalle'>
								<div itemscope itemtype="http://data-vocabulary.org/Organization">                 
									<h2><a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?>' target='_blank'>
									<span itemprop="name"><?php echo $d['titulo'];?></span></a></h2>

<?php /* Para abrir en ventana modal
									<h2><a data-toggle="modal" 
										href="<?php echo URL;?>/modal_ficha_alojamiento.php?alojamiento_id=<?php echo $d['id'];?>" 
										title='<?php echo $d['titulo'];?>'
										data-target="#modal"><?php echo $d['titulo'];?></a>
									</h2>
*/ ?>									
									<p ><?php echo substr($d['resumen'],0,200);?></p>
									<?php //echo $promociones;?>
									<div class='datos_contacto_top' style='height:45px;overflow:hidden;'>
										<span itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
											<?php if (!empty($d['telefono1'])) { echo "<img src='".URL."/img/telefono01.jpg' style='height:12px;width:22px;'><span itemprop='tel'>{$d['telefono1']}</span>"; } ?>
											<?php if (!empty($d['telefono2'])) { echo " / <span itemprop='tel'>{$d['telefono2']}</span>"; }?>
											<br><img src='<?php echo URL;?>/img/postal01.jpg'  style='height:12px; width:22px;'>
											<span itemprop="street-address"><?php echo $d['direccion'];?></span> | 
											<span itemprop="locality"><?php echo $d['ciudad'];?></span> | 
											<span itemprop="region"><?php echo $d['provincia'];?></span> | <?php echo $d['pais'];?>
										</span>     
									</div>
								</div>    
							</div>
						</div>
						<div class="cl_ra-sombra-grande"></div>
						<div class='clear' style='margin-bottom:10px;'></div>	       
				  <?php } // endforeach  ?>
				

			  </div>
			</div>
		</div>
		<?php $contador_familia++;?>
		<?php //pr($r);?>
	
	<?php } // endforeach ?>
	</div>
	
<?php /* Para abrir en ventana modal	
<div class="modal hide fade" id="modal">
	<div class="modal-header">
          <h3>Mensaje</h3>
    </div>

    <div class="modal-body"></div>

        <div class="modal-footer">
          <a href="#" class="btn" type="reset" onclick="closeDialog ();">Cancelar</a>
          <a href="#" class="btn btn-danger" onclick="okClicked ();">Eliminar</a>
        </div>
</div> 
*/ ?>
