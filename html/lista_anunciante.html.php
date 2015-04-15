	<div class='grid_3 barra_superior'>
				<h3>Categorías</h3>
	</div>

	<div class='grid_9 barra_superior'>
				<form action="<?php echo URL;?>/buscar.php" method="post" id='caja_busqueda'>
					<input type="text" name="buscar" id="buscar" value ="Buscar productos" onclick="select();"/>
					<input type="submit" class="boton_buscar" value="" title="Buscar"/>
				</form>	

	</div>
	<div class='clear'></div>

	<div class="grid_3" id='ciudades' style="text-align: right;font-size:12px; ">
		<?php include(ROOT.'/menu_familias.php');?>
	</div>

	<div class='grid_9'>
	<!--  BREADCRUMB -->
	<?php if ($breadcrumb and  !empty($route) ) { ?>
		<div id='breadcrumb' style="text-align: left;font-size:12px; ">
		 	<?php include('html/breadcrumb.html.php');?>
		 </div>
	<?php } ?>		 

	<?php include(ROOT."/html/inc_barra_sharethis.html.php");?>		

	<div class="detalle_anunciante_premium" style='height:100%;padding-top:1px;'>
		<table width='94%' style='margin:10px auto;'>
			<tr>
				<td width='320'><img src='<?php echo VER_FOTOS;?>/<?php echo $Usuario['miniatura'];?>' style='width:300px; height:220px;'></td>
				<td>
                    <div itemscope itemtype="http://data-vocabulary.org/Organization">                 
                       <h1><span itemprop="name"><?php echo $Usuario['nombre_fantasia'];?></span></h1>

                    <span itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
                        <u>Dirección:</u> <span itemprop='street-addres' style='line-height:25px'><?php echo $Usuario['direccion'];?></span>
                        <br>
                        <span itemprop="locality"><?php echo $Usuario['ciudad'];?></span> | 
                        <span itemprop="region"><?php echo $Usuario['provincia'];?></span>
						<br><br>
						<u>Web:</u> <span itemprop='web' style='line-height:25px'><?php echo $Usuario['web'];?></span>                    	
                        <br><u>Teléfono:</u> <span itemprop='tel' style='line-height:25px'><?php echo $Usuario['telefono'];?></span>
						<br><u>Fax:</u> <span itemprop='fax' style='line-height:25px'><?php echo $Usuario['fax'];?></span>
                        <br><u>Email:</u> <span itemprop='email' style='line-height:25px'><?php echo $Usuario['email'];?></span>
                    </span>     


				</td>
			</tr>
		</table>


	</div>

	<?php if(isset($Premium) and !empty($Premium) ){ ?>
		
	    <?php foreach($Premium as $d){ ?>
			<?php if($d['id']>0) { ?>
            <div class='c1_premium' >
                <div class='lista_alojamientos_imagen'>
    	           <a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?> en <?php echo $xurl['familia']['nombre'];?>'>
 	          		   <img src='<?php echo $d['miniatura'];?>' style='width:93px;height:70px;margin:5px;'>
    	      	    </a>
                </div>
                <div class='lista_alojamientos_detalle'>
                    <div itemscope itemtype="http://data-vocabulary.org/Organization">                 
                       <h2><a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?> en <?php echo $xurl['familia']['nombre'];?>'>
                        <span itemprop="name"><?php echo $d['titulo'];?></span></a></h2>
        	           <p style='height:35px;'><?php echo $d['resumen'];?></p>
        	           <div class='anunciante_destacado'>
        	           		Categoría: <?php echo $d['fam_nombre'];?> &rArr; <?php echo $d['subfam_nombre'];?>
        	           	</div>
                    </div>    
                </div>

                <div class='c1_precio'>$<?php echo number_format($d['precio'],2,',','.');?></div>


            </div>
            <div class="cl-sombra-grande"></div>
            <div class='clear' style='margin-bottom:0px;'></div>	       
			<?php } ?>
	    <?php } // foreach?>
	<?php } //endif $Premium?>


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


</div>
<div class='clear'></div>
