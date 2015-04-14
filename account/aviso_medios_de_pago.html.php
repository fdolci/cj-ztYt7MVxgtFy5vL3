<?php
	include ('../inc/config.php'); 
    $producto_id = request('producto_id',0);
    $user_id     = request('user_id',0);
    $accion      = request('accion','');
    $id          = request('id',0);

	if(isset($_GET['listItem'])){ 
		$accion = 'ordenar';
	}


    if( !esta_login() ) { 
        $Mensaje["mensaje"]   = $Traducciones['login_requerido'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['user_id']  = '';
        redirect(URL);   die();  
    }


	$tab_activa = 'lista';
	switch ($accion) {
	    case 'guardar':
		    if($_POST){
		    	$data = $_POST;
				$valores = $_POST['data'];

				$pa = array();
				$pa['id'] = 0;
				$pa['user_id']     = $user_id;
				$pa['producto_id'] = $producto_id;
				
				$errores = false;
				//-----------------------------------------------------------------
				//				Esta definida la direccion de la oficina
				//-----------------------------------------------------------------
				if(isset($data['personalmente']) and $data['personalmente']=='on' ){
					if(empty($valores['personalmente']) ) { $error=true; }
				}
				
				//-----------------------------------------------------------------
				//				Estan definidos los datos bancarios
				//-----------------------------------------------------------------
				if(isset($data['transferecia']) and $data['transferecia']=='on' ){
					if(empty($valores['transferncia']) ) { $error=true; }
				}

				//-----------------------------------------------------------------
				//				Estan definidos los datos de Western
				//-----------------------------------------------------------------
				if(isset($data['western']) and $data['western']=='on' ){
					if(empty($valores['western']) ) { $error=true; }
				}

				//-----------------------------------------------------------------
				//				Existe el mail de DineroMail
				//-----------------------------------------------------------------
				if(isset($data['dineromail']) and $data['dineromail']=='on' ){
					if(empty($valores['dineromail']) ) { $error=true; }
				}

				//-----------------------------------------------------------------
				//				Existe el mail de Paypal
				//-----------------------------------------------------------------
				if(isset($data['paypal']) and $data['paypal']=='on' ){
					if(empty($valores['paypal']) ) { $error=true; }
				}

				//-----------------------------------------------------------------
				//				Existe datos de Mercadopago
				//-----------------------------------------------------------------
				if(isset($data['mercadopago']) and $data['mercadopago']=='on' ){
					if( empty($valores['mp_account_id']) or empty($valores['mp_enc']) ) { $error=true; }
				}


				//-----------------------------------------------------------------
				//				Todo OK, grabo
				//-----------------------------------------------------------------
				
				if(!$error){
					$x = base64_encode(serialize($valores));
					$sql = "update productos set medios_de_pago='$x' where id='$producto_id' and user_id='$user_id'";
					$ok  = $db->Execute($sql);
				}
				
		    }
		    $id = 0;
	        break;

	}

	
	$sql = "select * from productos where id='$producto_id' and user_id='$user_id'";
	$rs  = $db->SelectLimit($sql,1);
    $evento = $rs->FetchRow();

	$valores = unserialize(base64_decode($evento['medios_de_pago']));
	if(!empty($valores['personalmente'])) { 
		$chk_personalmente = 'checked'; $disa_personalmente = '';
	} else { 
		$chk_personalmente = ''; $disa_personalmente = 'disabled';
	}
	if(!empty($valores['transferencia'])) { 
		$chk_transferencia = 'checked'; $disa_transferencia = '';
	} else { 
		$chk_transferencia = ''; $disa_transferencia = 'disabled';
	}
	if(!empty($valores['western'])) { 
		$chk_western = 'checked'; $disa_western = '';
	} else { 
		$chk_western = ''; $disa_western = 'disabled';
	}
	if(!empty($valores['dineromail'])) { 
		$chk_dineromail = 'checked'; $disa_dineromail = '';
	} else { 
		$chk_dineromail = ''; $disa_dineromail = 'disabled';
	}
	if(!empty($valores['paypal'])) { 
		$chk_paypal = 'checked'; $disa_paypal = '';
	} else { 
		$chk_paypal = ''; $disa_paypal = 'disabled';
	}
	if(!empty($valores['mp_account_id'])) { 
		$chk_mercadopago = 'checked'; $disa_mercadopago = '';
	} else { 
		$chk_mercadopago = ''; $disa_mercadopago = 'disabled';
	}
	
	
?>

<script type="text/javascript" src="<?php echo URL;?>/js/jquery-1.9.1.min.js"></script>
<link href="<?php echo URL;?>/js/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"  >
<script src="<?php echo URL;?>/js/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo URL;?>/css/muestra_producto.css" type="text/css" media="screen" />


<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style>
	#test-list {
		list-style: none;
	}

	#test-list li {
		display: block;
		/* padding: 20px 10px;  */
		margin-bottom: 3px;
		background-color: #efefef;
	}

	#test-list li img.handle {
		margin-right: 20px;
		cursor: move;
	}

table{
	font-size:12px;
	font-family:Arial;
}
</style>


<div id="info"></div> 
	<h3 style='text-align:left;margin-top:20px;margin-bottom:10px;'>Medios de Pago Disponible</h3>
	<p>Por favor complete las opciones correspondientes a los medio de pago que quiera habilitar</p>
	
	<form action='<?php echo URL;?>/account/aviso_medios_de_pago.html.php' method='post'>
	
	<table class="table table-condensed">
		<tr>
			<td>
				<input type='checkbox' name='personalmente' id='personalmente' <?php echo $chk_personalmente;?> title='Habilitar / Deshabilitar este medio de pago'>
			</td>
			<td style='padding-right:20px;'>Personalmente</td>
			<td>Ingrese la dirección de la oficina donde se realizará el pago</td>
			<td>
				<textarea type='text' name='data[personalmente]' id='v_personalmente' style='width:300px;height:100px;' <?php echo $disa_personalmente;?> ><?php echo $valores['personalmente'];?></textarea>
			</td>
		</tr>
	
		<tr>
			<td>
				<input type='checkbox' name='transferencia' id='transferencia' <?php echo $chk_transferencia;?> title='Habilitar / Deshabilitar este medio de pago'>
			</td>
			<td style='padding-right:20px;'>Transferencia<br>Bancaria</td>
			<td>Ingrese el CBU y los datos bancarios que considere necesarios para que realicen la transferencia</td>
			<td>
				<textarea type='text' name='data[transferencia]' id='v_transferencia' style='width:300px;height:100px;' <?php echo $disa_transferencia;?> ><?php echo $valores['transferencia'];?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input type='checkbox' name='western' id='western' <?php echo $chk_western;?> title='Habilitar / Deshabilitar este medio de pago'>
			</td>
			<td style='padding-right:20px;'>Western Union</td>
			<td>Ingrese Tipo y Nro.de Documento, Apellido y Nombres completos, Domicilio (ciudad, pcia,pais) de la persona que va a recibir el giro</td>
			<td>
				<textarea type='text' name='data[western]' id='v_western' style='width:300px;height:100px;' <?php echo $disa_western;?> ><?php echo $valores['western'];?></textarea>
			</td>
		</tr>
		
		<tr>
			<td><input type='checkbox' name='dineromail' id='dineromail' <?php echo $chk_dineromail;?> title='Habilitar / Deshabilitar este medio de pago'></td>
			<td style='padding-right:20px;'>DineroMail</td>
			<td>Ingrese la dirección de mail registrada en DineroMail para recibir pagos</td>
			<td>
				<input type='text' name='data[dineromail]' id='v_dineromail' style='width:300px;padding:10px;height:30px;' <?php echo $disa_dineromail;?> value='<?php echo $valores['dineromail'];?>'>
			</td>
		</tr>
		<tr>
			<td rowspan='2'>
				<input type='checkbox' name='mercadopago' id='mercadopago' <?php echo $chk_mercadopago;?> title='Habilitar / Deshabilitar este medio de pago'>
			</td>
			<td rowspan='2' style='padding-right:20px;'>MercadoPago</td>
			<td>Ingrese el <b>Account ID</b> de MercadoPago<br>
			 (Para obtenerlo, haga click en el siguiente link: <a href='https://www.mercadopago.com/mla/cartdata' target='_blank'>https://www.mercadopago.com/mla/cartdata</a>)</td>
			<td>
				<input type='text' name='data[mp_account_id]' id='v_mp_account_id' style='width:300px;padding:10px;height:30px;' <?php echo $disa_mercadopago;?> value='<?php echo $valores['mp_account_id'];?>'>
			</td>
		</tr>
		<tr>
			<td>Ingrese el <b>Código validador de seguridad</b>(enc) de MercadoPago<br>
				(Para obtenerlo, haga click en el siguiente link: <a href='https://www.mercadopago.com/mla/cartdata' target='_blank'>https://www.mercadopago.com/mla/cartdata</a>)</td>
			<td>
				<input type='text' name='data[mp_enc]' id='v_mp_enc' style='width:300px;padding:10px;height:30px;'  <?php echo $disa_mercadopago;?> value='<?php echo $valores['mp_enc'];?>'>
			</td>
		</tr>
		
		<tr>
			<td><input type='checkbox' name='paypal' id='paypal' <?php echo $chk_paypal;?> title='Habilitar / Deshabilitar este medio de pago'></td>
			<td style='padding-right:20px;'>Paypal</td>
			<td>
				Ingrese la dirección de mail registrada en Paypal para recibir pagos
				<br><b>Nota:</b>Sólo para pagos en dólares desde el exterior
			</td>
			<td>
				<input type='text' name='data[paypal]' id='v_paypal' style='width:300px;padding:10px;height:30px;' <?php echo $disa_paypal;?> value='<?php echo $valores['paypal'];?>'>
			</td>
		</tr>

		
		
	</table>

	<input type='hidden' name='user_id' value='<?php echo $user_id;?>'>
	<input type='hidden' name='producto_id' value='<?php echo $producto_id;?>'>
	<input type='hidden' name='accion' value='guardar'>
	<input type='submit' value='Guardar'>
	</form>
	
	
	

<script>
$(document).ready(function(){  

	$("#personalmente").click(function() {  
        if($("#personalmente").is(':checked')) {  
            $('#v_personalmente').attr('disabled',false);            
        } else {  
            $('#v_personalmente').val('');            
            $('#v_personalmente').attr('disabled',true);            
        }  
    });  
	
	$("#transferencia").click(function() {  
        if($("#transferencia").is(':checked')) {  
            $('#v_transferencia').attr('disabled',false);            
        } else {  
            $('#v_transferencia').val('');            
            $('#v_transferencia').attr('disabled',true);            
        }  
    });  
	
	$("#western").click(function() {  
        if($("#western").is(':checked')) {  
            $('#v_western').attr('disabled',false);            
        } else {  
            $('#v_western').val('');            
            $('#v_western').attr('disabled',true);            
        }  
    });  
	
	$("#dineromail").click(function() {  
        if($("#dineromail").is(':checked')) {  
            $('#v_dineromail').attr('disabled',false);            
        } else {  
            $('#v_dineromail').val('');            
            $('#v_dineromail').attr('disabled',true);            
        }  
    });  

	$("#paypal").click(function() {  
        if($("#paypal").is(':checked')) {  
            $('#v_paypal').attr('disabled',false);            
        } else {  
            $('#v_paypal').val('');            
            $('#v_paypal').attr('disabled',true);            
        }  
    });  
	
	$("#mercadopago").click(function() {  
        if($("#mercadopago").is(':checked')) {  
            $('#v_mp_account_id').attr('disabled',false);            
            $('#v_mp_enc').attr('disabled',false);            
        } else {  
            $('#v_mp_account_id').val('');            
            $('#v_mp_account_id').attr('disabled',true);            
            $('#v_mp_enc').val('');            
            $('#v_mp_enc').attr('disabled',true);            
			
        }  
    });  
	
	
});
</script>
