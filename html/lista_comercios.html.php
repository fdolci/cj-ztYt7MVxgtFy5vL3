	<div class="barra_naranja">    
		<?php $ciudad = iif(empty($xurl['ciudad']['nombre']),'Rosario',$xurl['ciudad']['nombre']);?>
		Actividades  <?php echo $xurl['subfamilia']['nombre'];?> en <?php echo $ciudad; ?> <?php echo $xurl['provincia']['nombre']; ?>
		<?php/* Actividades  <?php echo $xurl['subfamilia']['nombre'];?> en <?php echo $xurl['ciudad']['nombre']; ?> <?php echo $xurl['provincia']['nombre']; ?> */?>
	</div>
	
	<center style='width:700px;overflow:hidden;'>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- CJ Horizontal ancho -->
	<ins class="adsbygoogle"
	     style="display:inline-block;width:728px;height:90px"
	     data-ad-client="ca-pub-2434718143283021"
	     data-ad-slot="6763092753"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	</center>


	<?php if($comercios){?>

		<?php //include(ROOT.'/inc/inc_publicidades_central.php'); ?>			
		<?php //pr($comercios);?>			    
	    <?php foreach($comercios as $d){?>
		
			<?php 
				if ($d['destacado_home']==1) { 
					$background = '#FAF2DE'; 
				} else { 
					$background='#FFF';
			} ?>
			
            <div class='c1' style='background:<?php echo $background;?>;'>
                <div class='lista_alojamientos_imagen'>
    	           <a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?> en <?php echo $xurl['familia']['nombre'];?>'>
 	          		   <img src='<?php echo $d['miniatura'];?>' style='width:93px;height:70px;margin:5px;'>
    	      	    </a>

                </div>
                <div class='lista_alojamientos_detalle' style='border-right:1px dotted #CCC;'>
                    <div itemscope itemtype="http://data-vocabulary.org/Organization">                 
                       <h2><a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?> en <?php echo $xurl['familia']['nombre'];?>'>
                        <span itemprop="name"><?php echo $d['titulo'];?></span></a></h2>
        	           <p style='height:40px;'><?php echo $d['subtitulo'];?></p>

        	           <div class='anunciante_destacado'>
        	           		Organiza &rArr; 
        	           		<b><?php echo $d['sigla'];?></b>
							
<?php /*
        	           		<b><a href='<?php echo URL;?>/anunciante/<?php echo $d['anunciante_url'];?>'
        	           			title='Ver todos los anuncios de <?php echo $d['nombre_entidad'];?>'><?php echo $d['sigla'];?></a></b>
*/?>
        	           		<span style='float:right;'><?php echo $d['familia'];?> - <?php echo $d['subfamilia'];?></span>	
        	           	</div>


                    </div>    
                </div>
                <div class='c1_precio' style='padding-left:2px;margin-top:-10px;'>
		            <table>
		                <tr>
		                    <td style='width:30px;'><img src='<?php echo URL;?>/img/congresos-icon-calendario-fecha.png' style='width:20px;height:20px;'>&nbsp;</td>
		                    <td style='text-align:right;font-family:courier;font-size:11px;'>
		                    	<?php echo date("d/m/Y",$d['desde']);?><br><?php echo date("d/m/Y",$d['hasta']);?></td>
		                </tr>
		                <tr><td colspan='2'><img src='<?php echo URL;?>/img/spacer.gif' style='width:2px;height:5px;'></td></tr>
		                <tr>
		                    <td><img src='<?php echo URL;?>/img/congresos-icon-localidad.png' style='width:20px;height:20px;'>&nbsp;</td>
		                    <td style='text-align:left;font-family:courier;font-size:11px;'>
		                    	<?php echo $d['ciudad'].'<br>'.$d['provincia'].'<br>'.$d['pais'];?> </td>
		                 </tr>

		            </table>
                </div>
            </div>
            <div class="cl-sombra-grande"></div>
            <div class='clear' style='margin-bottom:0px;'></div>	       

	    <?php } // foreach?>
	<?php } //endif comercios ?>    


		<?php
		//----------------------------------------------------------------------------
		//                                                             Eventos Pasados
		//----------------------------------------------------------------------------
		?>
		<div class="barra_naranja">    
			<?php $ciudad = iif(empty($xurl['ciudad']['nombre']),'Rosario',$xurl['ciudad']['nombre']);?>
			Actividades Pasadas <?php echo $xurl['subfamilia']['nombre'];?> en <?php echo $ciudad; ?> <?php echo $xurl['provincia']['nombre']; ?>
		</div>

		<center style='width:700px;overflow:hidden;'>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- CJ Horizontal ancho -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:728px;height:90px"
		     data-ad-client="ca-pub-2434718143283021"
		     data-ad-slot="6763092753"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		</center>



		<?php if($EventosPasados){?>
			<?php foreach($EventosPasados as $d){ ?>
			
				<?php 
					if ($d['destacado_home']==1) { 
						$background = '#FAF2DE'; 
					} else { 
						$background = '#FFF';
					} 
				?>
				
				<div class='c1' style='background:<?php echo $background;?>;'>
					<div class='lista_alojamientos_imagen'>
					   <a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?> en <?php echo $xurl['familia']['nombre'];?>'>
						   <img src='<?php echo $d['miniatura'];?>' style='width:93px;height:70px;margin:5px;'>
						</a>
					</div>
					
					<div class='lista_alojamientos_detalle' style='border-right:1px dotted #CCC;'>
						<div itemscope itemtype="http://data-vocabulary.org/Organization">                 
						   <h2><a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?> en <?php echo $xurl['familia']['nombre'];?>'>
							<span itemprop="name"><?php echo $d['titulo'];?></span></a></h2>
						   <p style='height:40px;'><?php echo $d['subtitulo'];?></p>

						   <div class='anunciante_destacado'>
								Organiza &rArr; 
								<b><?php echo $d['sigla'];?></b>
								<span style='float:right;'><?php echo $d['familia'];?> - <?php echo $d['subfamilia'];?></span>	
							</div>
						</div>    
					</div>
					<div class='c1_precio' style='padding-left:2px;margin-top:-10px;'>
						<table>
							<tr>
								<td style='width:30px;'><img src='<?php echo URL;?>/img/congresos-icon-calendario-fecha.png' style='width:20px;height:20px;'>&nbsp;</td>
								<td style='text-align:right;font-family:courier;font-size:11px;'>
									<?php echo date("d/m/Y",$d['desde']);?><br><?php echo date("d/m/Y",$d['hasta']);?></td>
							</tr>
							<tr><td colspan='2'><img src='<?php echo URL;?>/img/spacer.gif' style='width:2px;height:5px;'></td></tr>
							<tr>
								<td><img src='<?php echo URL;?>/img/congresos-icon-localidad.png' style='width:20px;height:20px;'>&nbsp;</td>
								<td style='text-align:left;font-family:courier;font-size:11px;'>
									<?php echo $d['ciudad'].'<br>'.$d['provincia'].'<br>'.$d['pais'];?> </td>
							 </tr>

						</table>
					</div>
				</div>
				<div class="cl-sombra-grande"></div>
				<div class='clear' style='margin-bottom:0px;'></div>	       

			<?php } // foreach?>
		<?php } // endif EventosPasados?>
		


		<center style='width:700px;overflow:hidden;'>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- CJ Horizontal ancho -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:728px;height:90px"
		     data-ad-client="ca-pub-2434718143283021"
		     data-ad-slot="6763092753"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		</center>

		
	<?php if($comercios){?>	
			<?php if ($cantidad_de_paginas > 1) { ?>
				<div id="paginador">
				<?php //echo "total de paginas: $cantidad_de_paginas - Actual:$pagina<br>"; ?>
					<ul>
						<?php if($pagina > 1) { $anterior = $pagina-1;?>
							<li><a href="<?php echo URL."/{$rutas[0]}/{$rutas[1]}/{$rutas[2]}/pag:$anterior";?>" >« Anterior</a></li>    
						<?php } ?>
						
						<?php for($i=1; $i <= $cantidad_de_paginas; $i++ ){ 
								if($pagina == $i){ $clase = 'class="pag_selected"'; } else { $clase = '';}    
						?>
							
							<li><a href="<?php echo URL."/{$rutas[0]}/{$rutas[1]}/{$rutas[2]}/pag:$i";?>" <?=$clase;?> ><?php echo $i;?></a></li>            
						<?php } ?>
				
						
						<?php if($pagina != $cantidad_de_paginas) { $siguiente = $pagina+1;?>
							<li><a href="<?php echo URL."/{$rutas[0]}/{$rutas[1]}/{$rutas[2]}/pag:$siguiente";?>" >Siguiente »</a></li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>	
		
			<?php include(ROOT."/html/inc_barra_sharethis.html.php");?>			

	<?php } // if?>


</div>
<div class='clear'></div>
