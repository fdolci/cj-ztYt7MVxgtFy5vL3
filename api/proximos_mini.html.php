<style>
html, body {margin:0px; padding:0px;}
</style>
<div id='contenedor_mini'>
	<div id='header_contenedor_mini'>
		<a href='<?php echo URL;?>' target='_blank'><img src='<?php echo URL;?>/img/logo_footer.png'></a>
	</div>
	<div id='contenido_mini'>
		<?php if( isset($eventos) and !empty($eventos) ) {?>
			<?php $color='';?>
			<?php foreach($eventos as $e){?>
				<?php $color = iif( $color=='#E3D1F0', '#FFF', '#E3D1F0');?>
				<div class='evento' style='background:<?php echo $color;?>' >
					<div class='fecha'><?php echo date("d.m.Y",$e['desde']);?></div>
					<div class='titulo'>
						<a href='<?php echo $e['href'];?>' target='_blank' title='<?php echo $e['titulo'];?>'><?php echo $e['titulo'];?></a>
					</div>
				</div>
			<?php } //endforeach eventos ?>
			
		<?php } //endif eventos ?>
	</div>


</div>


<style>
#contenedor_mini {
	width:<?php echo ($ancho-15);?>px;
	border:1px solid #683D85;
	min-height:200px;
	height: <?php echo $alto;?>px;
	
}
#header_contenedor_mini {
	width:100%;
	background:#683D85;
	text-align:center;
}
#header_contenedor_mini img{
	width:90%;
	margin:2px auto;
	max-width:260px;
}

#contenido_mini {
	padding:0px;
	overflow:auto;
	height:<?php echo ($alto-50);?>px;
}

.evento {
	width:100%;
	min-width:200px;
}
.fecha{
	font-family:'Arial';
	font-size:11px;
	width:56px;
	display:inline-block;
	vertical-align:middle;
	line-height:14px;
	padding:4px 2px;
}
.titulo{
	font-family:'Arial';
	font-size:11px;
	display:inline-block;
	min-width:130px;
	/* width:70%;*/
	vertical-align:middle;
	line-height:14px;	
	padding:4px 2px;
}

</style>