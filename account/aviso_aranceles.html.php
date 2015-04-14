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

				$pa = array();
				$pa['id'] = 0;
				$pa['user_id']     = $user_id;
				$pa['producto_id'] = $producto_id;
				$pa['descripcion'] = $data['arancel_descripcion'];
				$pa['moneda_id']   = $data['moneda_id'];
				
				if(isset($data['chk1']) and $data['chk1']=='on' ){
					//---------------------------------------------- Esta definido el primer vencimiento
					$vencimiento1 = mktime(23,59,59,$data['vencimiento1_mes'],$data['vencimiento1_dia'],$data['vencimiento1_ano']);
					$pa['vto_1']  = $data['arancel_1'];
				} else {
					$vencimiento1 = 0;
					$pa['vto_1']  = 0;
				}

				if(isset($data['chk2']) and $data['chk2']=='on' ){
					//---------------------------------------------- Esta definido el segundo vencimiento
					$vencimiento2 = mktime(23,59,59,$data['vencimiento2_mes'],$data['vencimiento2_dia'],$data['vencimiento2_ano']);
					$pa['vto_2']  = $data['arancel_2'];
				} else {
					$vencimiento2 = 0;
					$pa['vto_2']  = 0;
				}

				//---------------------------------------------- Ultimo Vencimiento
				$vencimiento3 = mktime(23,59,59,$data['vencimiento3_mes'],$data['vencimiento3_dia'],$data['vencimiento3_ano']);
				$pa['vto_3']  = $data['arancel_3'];

				
				//---------------------------------------------------------------------
				//                       Actualizo la fecha de vencimiento en productos
				//---------------------------------------------------------------------
				$sql = "update productos set vencimiento1='$vencimiento1', vencimiento2='$vencimiento2', vencimiento3='$vencimiento3' 
						where id='$producto_id' and user_id='$user_id' ";
				$ok  = $db->Execute($sql);
						
				//---------------------------------------------------------------------
				//                     Creo el nuevo registro en la tabla de aranceles
				//---------------------------------------------------------------------
//				$db->debug = true;
				$ok = $db->Autoexecute('productos_aranceles', $pa,'INSERT');
//				die();
		        unset($data);

		    }
		    $id = 0;
	        break;


	    case 'estado':
	    	$rs = $db->SelectLimit("select activo from productos_aranceles where id='$id'",1);
	    	$x  = $rs->FetchRow();
	    	$estado = iif($x['activo']==1,0,1);

	    	$ok = $db->Execute("update productos_aranceles set activo='$estado' where id='$id'");
			$id = 0;	        
	        break;

	    case 'eliminar':
	    	$ok = $db->Execute("delete from productos_aranceles where id='$id'");
			$id = 0;	        
	        break;

	    case 'ordenar':
	    	foreach($_GET['listItem'] as $clave=>$valor){
				$ok = $db->Execute("update productos_aranceles set orden='$clave' where id='$valor'");	    		
	    	}
	    	die();
			$id = 0;	        
	        break;

	}

	$sql = "select * from productos where id='$producto_id' and user_id='$user_id'";
	$rs  = $db->SelectLimit($sql,1);
    $evento = $rs->FetchRow();
	
	
	$sql = "select * from productos_aranceles where producto_id='$producto_id' and user_id='$user_id' order by orden ASC";
	$rs  = $db->Execute($sql);
    $ax = $rs->GetRows();

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


<?php 
	if($evento['vencimiento3']==0){ $evento['vencimiento3']=$evento['desde'];}
	$chk1 = iif($evento['vencimiento1']>0, 'checked','');
	$chk2 = iif($evento['vencimiento2']>0, 'checked','');
	
	$disa1 = iif($chk1=='checked', '', 'disabled=disabled');
	$disa2 = iif($chk2=='checked', '', 'disabled=disabled');
?>

<div id="info"></div> 
	<h3 style='text-align:left;margin-top:20px;margin-bottom:10px;'>Definir Fechas de Vencimiento</h3>
	
	<form action='<?php echo URL;?>/account/aviso_aranceles.html.php' method='post'>
	
	<table>
		<tr>
			<td><input type='checkbox' name='chk1' id='chk1' <?php echo $chk1;?> ></td>
			<td>Habilitar Primer Vencimiento: </td>
			<td><?php echo cb_fechas($evento['vencimiento1'],'vencimiento1',$disa1);?></td>
		</tr>
		<tr>
			<td><input type='checkbox' name='chk2' id='chk2'  <?php echo $chk2;?> ></td>
			<td>Habilitar Segundo Vencimiento: </td>
			<td><?php echo cb_fechas($evento['vencimiento2'],'vencimiento2', $disa2);?></td>
		</tr>
		<tr>
			<td></td>
			<td>Ultimo Vencimiento: </td>
			<td><?php echo cb_fechas($evento['vencimiento3'],'vencimiento3');?></td>
		</tr>
	</table>

	<table class="table table-condensed" style='width:500px;margin-left:50px;border-left:1px solid #333;'>
		<tr>
			<th colspan='2' style='text-align:center;font-size:14px;'>Definir Tabla de Aranceles</th>
		</tr>
		<tr>
			<td style='width:180px;text-align:right;'>Descripción</td>
			<td><input type='text' name='arancel_descripcion' style='width:300px;padding:10px;height:30px;'></td>
		</tr>
		<tr>
			<td style='text-align:right;'>Importe Primer Vencimiento</td>
			<td>
				<input type='text' name='arancel_1' id='arancel_1' style='width:100px;padding:10px;height:30px;' <?php echo $disa1;?> >
			</td>
		</tr>
		<tr>
			<td style='text-align:right;'>Importe Segundo Vencimiento</td>
			<td>
				<input type='text' name='arancel_2' id='arancel_2' style='width:100px;padding:10px;height:30px;'  <?php echo $disa2;?> >
			</td>
		</tr>
		<tr>
			<td style='text-align:right;'>Importe Ultimo Vencimiento</td>
			<td>
				<input type='text' name='arancel_3'  style='width:100px;padding:10px;height:30px;'>
				<select name='moneda_id' style='width:70px;'>
					<option value='1'><?php echo $Monedas[1];?></option>
					<option value='2'><?php echo $Monedas[2];?></option>
				</select>
				
					
				<input type='hidden' name='user_id' value='<?php echo $user_id;?>'>
				<input type='hidden' name='producto_id' value='<?php echo $producto_id;?>'>
				<input type='hidden' name='accion' value='guardar'>
				<input type='submit' value='Guardar'>
				
			</td>
		</tr>
	</table>	
	</form>
	
	
	
<table class="table table-condensed">
	<tr>
		<th >Acciones</th>
		<th >Descripción</th>
		<th style="width:70px;text-align:right;">1er.Vto.</th>
		<th style="width:70px;text-align:right;">2do.Vto.</th>
		<th style="width:70px;text-align:right;">3er.Vto.</th>
		<th style="width:55px;">Moneda</th>
	</tr>
</table>

	<ul id="test-list" style='margin:0 0 10px 0;'> 		
	<?php if($ax){?>
		<?php foreach($ax as $clave=>$valor){?>
		<li id="listItem_<?php echo $valor['id'];?>">
			<table class="table table-condensed">
			<tr>
				<td width='20' style="color:#000000; font-weight:bold; font-size:12px;text-align:center;">
					<img src="<?php echo URL;?>/img/arrow.png" alt="move" width="16" height="16" class="handle" title='Arrastre para ordenar'/>
				</td>

				<td width='20' align='center' style="color:#000000; font-weight:bold; font-size:12px;">
					<a href='aviso_aranceles.html.php?accion=eliminar&producto_id=<?php echo $producto_id;?>&user_id=<?php echo $user_id;?>&id=<?php echo $valor['id'];?>'
						title='Eliminar este Item'	onclick="return confirm('Est&aacute; seguro de eliminar este Item?');">
						<img src='<?php echo ADMIN;?>img/del.gif' border='0' /></a>
				</td>
			
				<td ><?php echo $valor['descripcion'];?></td>
				<td style="width:70px;text-align:right;"><?php echo number_format($valor['vto_1'],2);?></td>
				<td style="width:70px;text-align:right;"><?php echo number_format($valor['vto_2'],2);?></td>
				<td style="width:70px;text-align:right;"><?php echo number_format($valor['vto_3'],2);?></td>
				<td style="width:55px;text-align:center;"><?php echo $Monedas[$valor['moneda_id']];?></td>
			</tr>
			</table>
		</li>
		
		<?php } //endofreach ?>
	</ul>
	<?php } ?>
	
	
</table>	

<script>
$(document).ready(function(){  

	$("#chk1").click(function() {  
        if($("#chk1").is(':checked')) {  
            $('#vencimiento1_dia').attr('disabled',false);            
            $('#vencimiento1_mes').attr('disabled',false);            
            $('#vencimiento1_ano').attr('disabled',false);            
			$('#arancel_1').attr('disabled',false); 
        } else {  
            $('#vencimiento1_dia').attr('disabled',true);            
            $('#vencimiento1_mes').attr('disabled',true);            
            $('#vencimiento1_ano').attr('disabled',true);            
			$('#arancel_1').attr('disabled',true); 
        }  
    });  
	
	$("#chk2").click(function() {  
        if($("#chk2").is(':checked')) {  
            $('#vencimiento2_dia').attr('disabled',false);            
            $('#vencimiento2_mes').attr('disabled',false);            
            $('#vencimiento2_ano').attr('disabled',false);            
			$('#arancel_2').attr('disabled',false); 
        } else {  
            $('#vencimiento2_dia').attr('disabled',true);            
            $('#vencimiento2_mes').attr('disabled',true);            
            $('#vencimiento2_ano').attr('disabled',true);            
			$('#arancel_2').attr('disabled',true); 
        }  
    });  

    $("#test-list").sortable({
      handle : '.handle',
      update : function () {
		var order = $('#test-list').sortable('serialize');
		$("#info").load("<?php echo URL;?>/account/aviso_aranceles.html.php?producto_id=<?php echo $producto_id;?>&"+order);
      }
    });

	
});
</script>
