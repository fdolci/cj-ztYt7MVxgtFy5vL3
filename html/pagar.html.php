<style>
.td_titulo {
	width:200px;
	text-align:right;
	padding-right:30px;
	font-weight:bold;
}

p{
	font-size:14px;
}

tr{
	height:30px;
}

</style>

	<div class="barra_naranja">La inscripción se realizó correctamente</div>

	<h2><?php echo $Producto['titulo'];?></h2>	
	
	<p>Hola <b><?php echo $Inscripto['nombre'];?></b></p>
	<p>Desde esta página podrá seleccionar el método de pago más conveniente para abonar su inscripción.</p>
	<p>Se ha enviado un mail a su casilla de correos con un enlace a esta página y los datos de su inscripción.</p>
	<p>Si no recibe el correo, por favor verifique la casilla de '<b>Correo No Deseado</b>', '<b>Spam</b>' o '<b>Correo Basura</b>'.</p>
	
	<table style='margin-top:30px;	font-size:16px; width:100%;' class="table table-condensed">
		<tr>
			<td class='td_titulo'>Arancel:</td>
			<td><?php echo $Arancel['descripcion'];?></td>
		</tr>
		<tr>
			<td class='td_titulo'>Tarifa vigente hasta el:</td>
			<td><?php echo date("d-m-Y",$vigente_hasta);?></td>
		</tr>
		
		<tr>
			<td class='td_titulo'>Importe:</td>
			<td><?php echo $Monedas[$Arancel['moneda_id']].' '.$Arancel["$vto"];?>.-</td>
		</tr>
		<tr>
			<td class='td_titulo'>Moneda:</td>
			<td><?php echo iif($Arancel['moneda_id']==1,'Pesos Argentinos','Dolares EEUU');?></td>
		</tr>
		
	</table>
	
	<h2>Opciones de Pago</h2>
	<p>Usted deberá optar por uno de los siguientes medios de pago disponibles.</p>
	<table style='margin-top:30px;	font-size:16px;width:100%;' class="table table-condensed">
		<?php if( isset($medios['personalmente']) ){ ?>
			<tr>
				<td class='td_titulo'>Personalmente en:</td>
				<td><?php echo nl2br($medios_de_pago['personalmente']);?></td>
			</tr>
		<?php } ?>
		
		<?php if( isset($medios['transferencia']) ){ ?>
			<tr>
				<td class='td_titulo' rowspan='2'>Transferencia Bancaria:</td>
				<td><?php echo nl2br($medios_de_pago['transferencia']);?></td>
			</tr>
			<tr>
				<td><small>Si realiza el pago mediante esta opción, deberá enviar un mail a: 
					<b><?php echo $Producto['email_inscripcion'];?></b> indicando los datos correspondientes a la Transferencia Bancaria</small>
				</td>
			</tr>
		<?php } ?>
		
		<?php if( isset($medios['western']) ){ ?>
			<tr>
				<td class='td_titulo' rowspan='2'>Western Union:</td>
				<td><?php echo nl2br($medios_de_pago['western']);?></td>
			</tr>
			<tr>
				<td><small>Si realiza el pago mediante esta opción, deberá enviar un mail a: 
					<b><?php echo $Producto['email_inscripcion'];?></b> indicando el Nro.de Operación de Giro de Dinero</small>
				</td>
			</tr>
		<?php } ?>
		
		<?php if( isset($medios['dineromail']) ){ ?>
			<?php 
			//------------------------------------------------------------------------------------------
			//                                                                       DineroMail
			//------------------------------------------------------------------------------------------
			?>
			<tr>
				<td class='td_titulo'>
					<img src='<?php echo URL;?>/img/dineromail.jpg' alt='DineroMail' style='margin:10px;'>
				</td>
				<td style='vertical-align:middle;text-align:center;'>
					<?php $subject    = $Producto['titulo'].'-'.$Inscripto['apellido'].', '.$Inscripto['nombre']; ?>
					<?php $extra_part = $Inscripto['id'].'-'.date("Y.m.d-H.i.s");?>					
					<?php $currency = iif($Arancel['moneda_id']==1,'ARG','USD');?>
					<form action="https://checkout.dineromail.com/CheckOut" method="post" target='p_dm'>
						<input type="hidden" name="merchant" value="<?php echo $medios_de_pago['dineromail'];?>"/>
						<input type="hidden" name="country_id" value="1" />
						<input type="hidden" name="seller_name" value="<?php echo $Producto['nombre_entidad'];?>" />
						<input type="hidden" name="payment_method_available" value="all" />
						
						<input type="hidden" name="item_name_1" value="<?php echo $subject;?>" />
						<input type="hidden" name="item_quantity_1" value="1" />
						<input type="hidden" name="item_ammount_1" value="<?php echo number_format($Arancel["$vto"],2,'.','');?>" />
						<input type='submit' value='Pagar con DineroMail' style='width:200px;' title='Pagar con DineroMail'>
					</form>					
				</td>
			</tr>
		<?php } ?>
		
		<?php if( isset($medios['mercadopago']) ){ ?>
			<?php 
			//------------------------------------------------------------------------------------------
			//                                                                       MercadoPago
			//------------------------------------------------------------------------------------------
			?>
			<tr>
				<td class='td_titulo'>
					<img src='<?php echo URL;?>/img/mercadopago.jpg' alt='MercadoPago'  style='margin:10px;'>
				</td>
				<td style='vertical-align:middle;text-align:center;'>
					<?php $subject    = $Producto['titulo'].'-'.$Inscripto['apellido'].', '.$Inscripto['nombre']; ?>
					<?php $extra_part = $Inscripto['id'].'-'.date("Y.m.d-H.i.s");?>					
					<?php $currency = iif($Arancel['moneda_id']==1,'ARG','USD');?>
					<form id="MercadoPago" name="MercadoPago" action="https://www.mercadopago.com/mla/buybutton" method="post" target='p_mp'>
						<input type="hidden" name="acc_id"         value="<?php echo $medios_de_pago['mp_account_id'];?>">
						<input type="hidden" name="item_id"        value="<?php echo $subject;?>" >
						<input type="hidden" name="seller_op_id"   value="<?php echo $extra_part;?>">
						<input type="hidden" name="name"           value="<?php echo $subject;?>" >
						<input type="hidden" name="currency"       value="<?php echo $currency;?>">
						<input type="hidden" name="price"          value="<?php printf("%01.1f",$Arancel["$vto"]);?>">
						<input type="hidden" name="shipping_cost"  value="">
						<input type="hidden" name="enc"            value="<?php echo $medios_de_pago['mp_enc'];?>">
						<input type="hidden" name="ship_cost_mode" value="">
						<input type="hidden" name="extra_part"     value="<?php echo $extra_part;?>">
						<input type='submit' value='Pagar con MercadoPago' style='width:200px;' title='Pagar con MercadoPago'>
					</form>
				
				
				</td>
			</tr>
		<?php } ?>
		
		<?php if( isset($medios['paypal']) ){ ?>
			<tr>
				<td class='td_titulo'>
					<img src='<?php echo URL;?>/img/paypal.png' alt='Paypal' style='margin:10px;'>
				</td>
				<td style='vertical-align:middle;text-align:center;'>
					<?php $subject    = $Producto['titulo'].'-'.$Inscripto['apellido'].', '.$Inscripto['nombre']; ?>
					<?php $extra_part = $Inscripto['id'].'-'.date("Y.m.d-H.i.s");?>					
					<?php $currency = iif($Arancel['moneda_id']==1,'ARG','USD');?>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target='p_pp'>
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="<?php echo $medios_de_pago['paypal'];?>">
						<input type="hidden" name="item_name" value="<?php echo $subject;?>">
						<input type="hidden" name="item_number" value="<?php echo $extra_part;?>">
						<input type="hidden" name="amount" value="<?php echo number_format($Arancel["$vto"],2,'.','');?>">
						<input type="hidden" name="tax" value="0">
						<input type="hidden" name="quantity" value="1">
						<input type="hidden" name="no_note" value="1">
						<input type="hidden" name="currency_code" value="USD">
						<input type='submit' name="submit" value='Pagar con Paypal' style='width:200px;' title='Pagar con Paypal'>
					</form>
					<br>
					<small>Según las nuevas disposiciones actuales, los pagos mediante Paypal solo son posibles para residentes del extranjero y se realizan en Dolares (u$s).</small>
				</td>
			</tr>
		<?php } ?>
		
	</table>
	
	<h2>Observaciones:</h2>
	<p>Si el pago se realiza online (medios de pago electrónicos) el tiempo de acreditación de los mismos puede ser de hasta 4 días hábiles</p>
	<p>Si el pago se realiza offline (Rapipago, PagoFacil, Transferencia Bancaria, Western Union), el tiempo de acreditación puede ser de hasta 6 días hábiles, 
	motivo por cual, aconsejamos enviar un mail a <b><?php echo $Producto['email_inscripcion'];?></b> indicando los datos del pago realizado 
	(Nro.de comprobante, fecha y hora de la operación, etc)</p>
</div>
<div class='clear'></div>
