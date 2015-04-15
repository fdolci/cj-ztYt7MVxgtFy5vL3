<?php
	include('./inc/config.php');
    $cat_id = 0;
    $mostrar_en_home = 1;
	$oculta_publicidad_top = true;

	$data = request('data','');
	$data = unserialize(base64_decode($data));
	
	if( isset($data['producto_id']) and isset($data['user_id']) and isset($data['id']) ){
		
		$sql = "select * from inscripciones where id='{$data['id']}' and  producto_id='{$data['producto_id']}' and  user_id='{$data['user_id']}'";
		$rs  = $db->SelectLimit($sql,1);
		$Inscripto = $rs->FetchRow();
		
		if(!$Inscripto){ die('Hacking attempt!!'); }
		
		$sql = "select productos.*,usuarios.nombre_entidad 
				from productos 
				left join usuarios on usuarios.id = productos.user_id
				where productos.id='{$data['producto_id']}' and user_id='{$data['user_id']}' ";
		$rs  = $db->SelectLimit($sql,1);
		$Producto = $rs->FetchRow();
		
		$sql = "select * from productos_aranceles where producto_id='{$data['producto_id']}' and user_id='{$data['user_id']}' and id='{$Inscripto['arancel_id']}'";
		$rs  = $db->SelectLimit($sql,1);
		$Arancel = $rs->FetchRow();
		
		if($Producto['vencimiento1']>time() ){
			$vto = 'vto_1';
			$vigente_hasta = $Producto['vencimiento1'];
		} elseif($Producto['vencimiento2']>time() ){
			$vto = 'vto_2';
			$vigente_hasta = $Producto['vencimiento2'];
		} else {
			$vto = 'vto_3';
			$vigente_hasta = $Producto['vencimiento3'];
		}
		
		
		$medios_de_pago = unserialize(base64_decode($Producto['medios_de_pago']));
		//-------------------------------------------------------------------------------
		//                                               Tiene medios de pago definidos??
		//-------------------------------------------------------------------------------
		$medios = array();
		if( isset($medios_de_pago['personalmente']) and !empty($medios_de_pago['personalmente']) ) {
			$medios['personalmente'] = 'Personalmente';
		}
		if( isset($medios_de_pago['transferencia']) and !empty($medios_de_pago['transferencia']) ) {
			$medios['transferencia'] = 'Transferencia Bancaria';
		}
		if( isset($medios_de_pago['western']) and !empty($medios_de_pago['western']) ) {
			$medios['western'] = 'Western Union';
		}
		if( isset($medios_de_pago['dineromail']) and !empty($medios_de_pago['dineromail']) ) {
			$medios['dineromail'] = 'DineroMail';
		}
		if( isset($medios_de_pago['mp_account_id']) and !empty($medios_de_pago['mp_account_id']) 
			and isset($medios_de_pago['mp_enc']) and !empty($medios_de_pago['mp_enc']) ) {
			$medios['mercadopago'] = 'MercadoPago';
		}
		if( isset($medios_de_pago['paypal']) and !empty($medios_de_pago['paypal']) ) {
			$medios['paypal'] = 'Paypal';
		}		
		
		
	} else {
		die('Hacking attempt!!');
	}

	
	
	
	
    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/html/pagar.html.php');
    include_once(ROOT.'/html/footer.html.php');
    die();
?>