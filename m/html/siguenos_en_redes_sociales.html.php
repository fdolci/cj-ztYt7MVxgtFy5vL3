<div class="siguenos">
	<h3 >Síguenos:</h3><br>
	<?php foreach($RedesSociales as $rs){ ?>
	
		<?php if (!empty($rs['url'])  and !empty($rs['logo']) ) { ?>
			<a href="<?php echo $rs['url'];?>" target='_blank' title='Síguenos en <?php echo $rs['nombre'];?>' ><img src='<?php echo $rs['logo'];?>' alt='<?php echo $rs['nombre'];?>'></a>
		<?php } ?>
	<?php } // end foreach ?>
	<a href="<?php echo URL;?>/rss" title='Síguenos mediante RSS' ><img src='<?php echo URL;?>/img/rss.jpg' alt='RSS'></a>

</div> <!-- end div siguenos -->
<?php //pr($RedesSociales);?>