<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>

<?php if (isset($data)){ ?>

	<div class='grid_6' style='min-height:400px;text-align:center;'>    
		<h2 style='text-align:center;'>Abonar con Paypal</h2>	
		<?php  $item_id = $data['id'].'-'.$data['user_id'].'-'.$data['plan_id']; ?>
		<?php
			$sandbox = false;
			if($sandbox and $data['user_id']==2 ) {
				$form_post = "https://www.sandbox.paypal.com/cgi-bin/webscr";
				$form_email = "fernan_1362611130_biz@gmail.com";
				$importe    = '2.00';
			} else {
				$form_post  = "https://www.paypal.com/cgi-bin/webscr";
				$form_email = "guiaentoas@gmail.com";
				$importe    = number_format($data['importe'],2,'.','');
			}
		?>
		<form name="_xclick" action="<?php echo $form_post;?>" method="post">
		    <input type="hidden" name="cmd" value="_xclick">
		    <input type="hidden" name="business" value="<?php echo $form_email;?>">
		    <input type="hidden" name="currency_code" value="<?php echo $data['signo'];?>">
		    <input type="hidden" name="item_name" value="<?php echo $data['plan_usuarios'];?>">
		    <input type="hidden" name="invoice" value="<?php echo $item_id;?>">
		    <input type="hidden" name="amount" value="<?php echo $importe;?>">
		    <input type="hidden" name="return" value="<?php echo URL;?>/account/estado_cuenta.php">
		    <input type="hidden" name="notify_url" value="<?php echo URL;?>/pasarelas/paypal/ipn.php">
		    <input type="image" src="http://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" 
		        border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
		</form>


	</div>


	<div class='grid_6' style='min-height:400px;text-align:center;'>    
		<h2 style='text-align:center;'>Abonar mediante Transferencia Bancaria</h2>	
			<style type="text/css">
				.uno {width:50%;text-align:right;padding:5px;font-weight:bold;}
				.dos {width:50%;text-align:left;padding:5px;font-weight:normal;}
			</style>
			<table style='width:360px;margin:10px auto;'>
				<tr>
					<td class='uno'>Banco</td>
					<td class='dos'>Macro</td>
				</tr>
				<tr>
					<td class='uno'>Tipo de Cuenta:</td>
					<td class='dos'>Caja de Ahorros</td>
				</tr>
				<tr>
					<td class='uno'>A nombre de:</td>
					<td class='dos'>Fernando Dolci</td>
				</tr>
				<tr>
					<td class='uno'>CUIT:</td>
					<td class='dos'>23-21497593-9</td>
				</tr>
				<tr>
					<td class='uno'>CBU:</td>
					<td class='dos'>15202220003160831</td>
				</tr>
			</table>


	</div>


<?php } else {?>

	<h2>No tiene deudas pendientes de pago</h2>

<?php } ?>

<div class='clear'></div>
<?php //pr($data); ?>