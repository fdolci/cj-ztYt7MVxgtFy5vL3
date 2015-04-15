<div class="siguenos">
	<h3 >Síguenos:</h3>
	<?php foreach($RedesSociales as $rs){ ?>
	
		<?php if (!empty($rs['url'])  and !empty($rs['logo']) ) { ?>
			<a href="<?php echo $rs['url'];?>" target='_blank' title='Síguenos en <?php echo $rs['nombre'];?>' ><img src='<?php echo $rs['logo'];?>' alt='<?php echo $rs['nombre'];?>'></a>
		<?php } ?>
	<?php } // end foreach ?>
	<a href="<?php echo URL;?>/rss" title='Síguenos mediante RSS' ><img src='<?php echo URL;?>/img/rss.jpg' alt='RSS'></a>
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<img src='<?php echo URL;?>/img/icono_disminuir_letra.png' id='minusBtn' title='Disminuir el Tamaño'>
	<img src='<?php echo URL;?>/img/icono_aumentar_letra.png' id='plusBtn'  title='Aumentar el Tamaño'>
	<img src='<?php echo URL;?>/img/icono_restablecer_letra.png' id='restablecerBtn'  title='Restablecer el Tamaño Original'>

	<script type="text/javascript">
							var zoom = 1;
						    $(document).ready(function() { 

							    $('#plusBtn').on('click',function(){
							    	var step = 0.1;
							        zoom += step; 
						  			$('body').css('MozTransform','scale('+zoom+')');
									$('body').css('MozTransformOrigin', '0 0');  			
									$('body').css('zoom', ''+zoom+'');  			
							    });

							    $('#minusBtn').on('click',function(){
							    	var step = 0.1;
							        zoom -= step; 
						  			$('body').css('MozTransform','scale('+zoom+')');
									$('body').css('MozTransformOrigin', '0 0');  			
									$('body').css('zoom', ''+zoom+'');  			
							    });

								$('#restablecerBtn').click(function() {
						            location.reload();
						        });	    
							});    
	</script>

</div> <!-- end div siguenos -->
<?php //pr($RedesSociales);?>