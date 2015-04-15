<?php
	$cond 		= "select * from slides where activo=1 and grupo_slides=1 order by orden ASC";
	$rs 		= $db->Execute($cond);
	$slides 	= $rs->GetRows();
	
	foreach($slides as $clave=>$valor) {
		if($valor['posicion_texto']=='center'){ $slides[$clave]['donde']="top:0px;text-align:center;margin:0px auto;"; }
		if($valor['posicion_texto']=='right'){ $slides[$clave]['donde']="top:0px;float:right;text-align:right; margin-right:70px;"; }
		if($valor['posicion_texto']=='left'){ $slides[$clave]['donde']="float:left;text-align:left;margin-left:30px;"; }
	}

?>

<div class="slides" style="float:none;">
<?php foreach($slides as $s) { ?>
	<div>
		<div id='contenido<?=$s['id'];?>' style="background-image:url('<?php echo $s['imagen'];?>');height:325px;width:962px;overflow:hidden;" >
			<div class="title" style="<?=$s['donde'];?> font-size:30px;font-weight:bold;text-shadow: #fff 1px 1px 1px;">
			<?php echo nl2br($s['texto']);?>
			</div>
		</div>	<!-- fin Contenido1 -->
	</div>	
<?php } ?>
</div> <!-- Fin Slide-->