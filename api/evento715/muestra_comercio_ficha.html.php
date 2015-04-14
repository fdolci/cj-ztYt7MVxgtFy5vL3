<style type="text/css">
	td {line-height: 25px;}
</style>

<table style='width:100%' class='datos'>
	<tr>
		<td style='width:50%;padding-right:10px;'>

			<table style='width:100%;'>
				<tr>
					<td style='width:30px;'><img src='<?php echo URL;?>/img/congresos-icon-calendario-fecha.png'>&nbsp;</td>
			        <td>
						<span class='ficha_titulo' style='line-height:30px;'>Inicio:</span> 
			            <span class='fechas'><?php echo cb_fechas($Producto['desde'],'',true);?></span>
			        </td>
			    </tr>
			    
				<tr>
					<td style='width:30px;'><img src='<?php echo URL;?>/img/congresos-icon-calendario-fecha.png'>&nbsp;</td>
			        <td>
						<span class='ficha_titulo' style='line-height:30px;'>Fin:</span> 
			            <span class='fechas'><?php echo cb_fechas($Producto['hasta'],'',true);?></span>
			        </td>
			    </tr>
			    
				<tr class='tr1'>
					<td><img src='<?php echo URL;?>/img/congresos-icon-localidad.png'>&nbsp;</td>
			        <td>
						<span class='ficha_titulo'>Localidad:</span> 
						<?php echo $Producto['ciudad'].' - '.$Producto['provincia'].' - '.$Producto['pais'];?> 
					</td>
			    </tr>

			    <tr class='tr2'>
					<td><img src='<?php echo URL;?>/img/congresos-icon-sede.png'>&nbsp;</td>
					<td><span class='ficha_titulo'>Lugar:</span> <?php echo $Producto['lugar'];?></td>
			    </tr>
			    
				<tr class='tr1'>
					<td><img src='<?php echo URL;?>/img/congresos-icon-localidad.png'>&nbsp;</td>
					<td><span class='ficha_titulo'>Dirección:</span> <?php echo $Producto['direccion'];?></td>
			    </tr>

			    <tr class='tr2'>
					<td><img src='<?php echo URL;?>/img/congresos-icon-tag.png'>&nbsp;</td>
					<td><span class='ficha_titulo'>Área:</span> <?php echo $xurl['familia']['nombre'];?> </td>
			    </tr>
			    
				<tr class='tr1'>
					<td><img src='<?php echo URL;?>/img/congresos-icon-tag.png'>&nbsp;</td>
					<td><span class='ficha_titulo'>Disciplina:</span> <?php echo $xurl['subfamilia']['nombre'];?> </td>
			    </tr>
	            
				<?php if (!empty($Producto['web'])) { ?>
					<tr>
						<td ><img src='<?php echo URL;?>/img/congresos-icon-web.png'>&nbsp;</td>
			            <td >
							<a href='<?php echo $Producto['web'];?>' target='_blank' title='Acceder a la Web del Evento'>
			                Acceder a la web del evento</a>
						</td>
			        </tr>
	            <?php } ?> 			                

			</table>

			<hr style='border-top:1px solid #333;margin-top:10px;padding-top:10px;'>
			<h2 style='width:320px;'>Organizador</h2>
			
			<table style='width:330px;'>
				<tr class='tr2'>
					<td style='width:30px;'><img src='<?php echo URL;?>/img/icono_asociacion.jpg'>&nbsp;</td>
			        <td><?php echo $Usuario['sigla'];?> - <?php echo $Usuario['nombre_entidad'];?></td>
			    </tr>
			    
				<tr class='tr1'>
					<td style='width:30px;'><img src='<?php echo URL;?>/img/icono_asociacion_direccion.jpg'>&nbsp;</td>
			        <td><?php echo $Usuario['direccion'];?></td>
			    </tr>
			    
				<tr class='tr2'>
					<td><img src='<?php echo URL;?>/img/icono_asociacion_telefono.jpg'>&nbsp;</td>
			        <td><?php echo $Usuario['telefono'].' - '.$Producto['fax'];?> </td>
			    </tr>

			    <tr class='tr1'>
					<td><img src='<?php echo URL;?>/img/icono_asociacion_mostrado.jpg'>&nbsp;</td>
			        <td>Visualizado: <?php echo $Producto['lecturas'];?> veces</td>
			    </tr>
	            
				<?php if (!empty($Usuario['web'])) { ?>
					<tr class='tr2'>
						<td><img src='<?php echo URL;?>/img/icono_asociacion_web.jpg'>&nbsp;</td>
				        <td>
							<a href='<?php echo $Usuario['web'];?>' target='_blank' title='Acceder a la Web del Organizador'>
				            <?php echo $Usuario['web'];?></a>
				        </td>
				    </tr>
	            <?php } ?>
			</table>

        </td>

        <td style='width:50%;'>

			<?php $ubicacion = "?latitud={$Producto['latitud']}&longitud={$Producto['longitud']}";?>
			    <iframe src='<?php echo URL;?>/html/muestra_comercio_ubicacion.html.php<?php echo $ubicacion;?>' 
			                style='width:340px; height:340px;border:1px solid #333; ' scrolling='no'></iframe>
							
				<?php $FB = trim($Producto['facebook']);	?>
				<?php /* if(!empty($FB)){ ?>
						<div id="fb-root"></div>
						<script>(function(d, s, id) {
								  var js, fjs = d.getElementsByTagName(s)[0];
								  if (d.getElementById(id)) return;
								  js = d.createElement(s); js.id = id;
								  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=<?php echo $Config['facebook_app_id'];?>";
								  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>

						<div class="fb-like-box" data-href="<?php echo $Producto['facebook'];?>" 
							data-width="340" data-height="210" data-show-faces="true" data-stream="false" data-header="true" 
							style="background-color: #FFF;margin-left:0px;border:none;"></div>
				<?php } */ ?>
							
	    </td>
	</tr>
</table>
