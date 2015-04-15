<?php $destacados = productos_destacados($Fam['id'], 4); ?>

<?php if(!empty($destacados)) { ?>
	<div class='c1-destacado' style='text-align:center;'>
		<h3 >Alojamientos Destacados</h3>  
		<?php foreach ($destacados as $calve=>$valor){ ?>
			<?php include('./modulo_estadistica.php'); ?>
		    <div class='destacado'>
	            
	            <?php if(strlen($valor['promociones'])>20) {?>
	            	<div class='promociones' style='margin-left:3px;margin-top:29px;'></div>
	            <?php } ?>
	            
	            <?php if( strlen($valor['tarifas'])>20 ) {?>
	            	<div class='tarifas' style='margin-top: 5px;margin-left: 88px;'></div>
	            <?php } ?>

		        <a href='<?php echo $valor['href'];?>' title='<?php echo $valor['titulo'];?>'>
		        	<img src='<?php echo $valor['thumbs'];?>' >
		      	</a>
		        <h2><?php echo $valor['titulo'];?></h2>
		        <p><?php echo $valor['resumen'];?></p>
		        <a href='<?php echo $valor['href'];?>' title='ver detalles' class='boton'>ver detalles</a>
		    </div>
		    <?php $i++;?>
	  <?php } // endforeach  ?>
	</div>
	<div class="cl-sombra-grande"></div>
	<div class='clear' style='margin-bottom:5px;'></div>
<?php } else {  ?>
    &nbsp;
<?php } // endif !empty destacados  ?>

<?php //pr($destacados);?>
