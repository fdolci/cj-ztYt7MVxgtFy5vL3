<style type="text/css">
#menu_mi_cuenta {
	background: #C6D6FC;
	height:20px;
	padding:10px;
	line-height:20px;
	margin-bottom:10px;
}
.mnu_selected{
	font-weight:bold;
}

#menu_mi_cuenta a{
	color:#000;
	font-size:12px;
}

#aviso_deuda {
	background: #B11016;
	height:40px;
	padding:10px;
	line-height:20px;
	margin-bottom:10px;
	color:#FFF;
	font-size:14px;
}
#aviso_deuda a{ 
	background: #FFF;
	color:#B11016;
	font-size:14px;
	padding:3px;
	font-weight: bold;
}

</style>

<div id='menu_mi_cuenta'>
	<div id='mibarra_interna' style='width:700px;display:inline-block'>
		<?php $sel = iif($menu_cta=='mi_cuenta','mnu_selected','');?>
		<a href="<?php echo URL;?>/account/mi_cuenta.php" class='<?php echo $sel;?>' title='Perfil del Organizador' >Perfil del Organizador</a>
			&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;	
		<?php $sel = iif($menu_cta=='cambiar_password','mnu_selected','');?>			
		<a href="<?php echo URL;?>/account/cambiar_password.php" class='<?php echo $sel;?>' title='Datos de Acceso' >Modificar Datos de Acceso</a>
			&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;	
		<?php $sel = iif($menu_cta=='listar_anuncios','mnu_selected','');?>
		<a href="<?php echo URL;?>/account/listar_anuncios.php" class='<?php echo $sel;?>' title='Listar mis Eventos' >Listar mis Actividades</a>
			&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;	

<?php /*			
		<?php $sel = iif($menu_cta=='estado_cuenta','mnu_selected','');?>
		<a href="<?php echo URL;?>/account/estado_cuenta.php" class='<?php echo $sel;?>' title='Estado de Cuenta' >Estado de Cuenta</a>
			&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;	
*/ ?>
		<a href="<?php echo URL;?>/logout.php" title='Salir'>Salir</a>	
	</div>

	<?php
		$user_id = $_SESSION['user_id'];
		//--------------------------------------------------------------------------
		//                                   Cuantos avisos vigente tiene cargados??
		//--------------------------------------------------------------------------
		$sql = "select count(id) as cuantos from productos where user_id='$user_id' ";
		$rs  = $db->SelectLimit($sql,1);
		$x   = $rs->FetchRow();
		$cuantos_avisos_tiene = $x['cuantos'];

		if ($cuantos_avisos_tiene < $_SESSION['limite_avisos'] && $url[3]=='listar_anuncios.php' ) {
	?>
		<div style='float:right;'><a href='<?php echo URL;?>/account/aviso.php?id=0' title='Crear Actividad' 
			style='padding:5px;background:#FF9900;font-weight:bold;'>Crear nueva Actividad</a></div>
	<?php } ?>
</div>	

<?php
	
    $cond   = "select pagos.*, pu.plan_usuarios, pu.cantidad_avisos, pu.vigencia, pu.importe                 
                from pagos 
                left join planes_usuarios as pu on pu.id = pagos.plan_id 
                where user_id='$user_id' and fecha_pago=0 and vencimiento<= '".time()."'";

    $rs     = $db->SelectLimit($cond,1);
    $impagos   = $rs->FetchRow();

    if($impagos) { 
		$vto_mas_quince = $impagos['vencimiento']+(60*60*24*15);
?>
		<div id='aviso_deuda'>    	
			Según nuestros registros, posee una deuda impaga de <?php echo number_format($impagos['importe'],2,'.',',')." ".$impagos['signo'];?> con vencimiento el día <?php echo date("d/m/Y",$impagos['vencimiento']);?>.<br>
			A partir del día <?php echo date("d/m/Y",$vto_mas_quince);?> sus anuncios dejaran de mostrarse en el directorio. Solicitamos regularizar esta situación.
			<a href='estado_cuenta_pagar.php?estado_id=<?php echo $impagos['id'];?>' title='Pagar Ahora'>Realizar el Pago</a>
		</div>
<?php
    }

?>
