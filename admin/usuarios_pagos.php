<?php
    $item_menu[0] = 4; 
    $item_menu[1] = 2;  
    $title = 'Usuarios';

   	$mipath='../';
   	include ('../inc/config.php');
    $de_donde = '';

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$id        = request('id',0);
	$sql = "select * from usuarios where id='$id'";
	$rs  = $db->SelectLimit($sql,1);
	$Usuario = $rs->FetchRow();

	if(!$Usuario) { echo "<h1 style='text-align:center;margin:20px;'>Usuario Inexistente</h1>"; die(); }

    $titulo = "Estado de Cuentas de: {$Usuario['nombre']} {$Usuario['apellido']}";    
    
	if(!empty($_SESSION['Msg'])) {
		echo '<center><div style="width:90%;height:30px;background-color:lightblue;border:2px solid blue;font-size:16px;font-weight;bold;text-align:center;margin-top:5px;padding-top:5px;color:blue;">';
		echo $_SESSION['Msg']."</div></center>";
		$_SESSION['Msg']='';
	}
    

	if ($_POST['accion'] and $_POST['submit']) {

		$data = $_POST['data'];
		$usuarios_grupos = $_POST['usuarios_grupos'];
		//pr($data);
		$sql = "select * from usuarios where id!='{$data[id]}' and email='{$data[email]}'";
		$rs  = $db->SelectLimit($sql,1);
		$Existe = $rs->FetchRow();

		if ($Existe) {
			echo '<center><div style="width:90%;height:30px;background-color:lightred;border:2px solid red;font-size:16px;font-weight;bold;text-align:center;margin-top:5px;padding-top:5px;color:red;">';
			echo "El <b>Email</b> existe para otro usuario. NO se guardaron los cambios.</div></center>";
			die();	
		} else {

			if (!empty($data['nuevaclave'])) {
				$data['clave'] = md5(trim($data['nuevaclave']));
			}
			unset($data['nuevaclave']);

			//--------------------------------- Busco el plan para ver si es premium o no
			$sql = "select * from planes_usuarios where id='{$data['plan_usuario_id']}'";
			$rs  = $db->SelectLimit($sql,1);
			$x   = $rs->FetchRow();
			$data['es_premium'] = $x['es_premium'];

			
			$ok = $db->Replace('usuarios', $data,'id', $autoquote = true); 
			if ($data['id']==0) { 
				$sql = "select * from usuarios where email='{$data[email]}'";
				$rs  = $db->SelectLimit($sql,1);
				$Existe = $rs->FetchRow();
				$data['id'] = $Existe['id']; 
			} 
			$id = $data['id'];

	        //- Elimino los grupos de pertenencia
	        $sql = "delete from usuarios_grupos where usuario_id='$id'";
			$rs 	= $db->Execute($sql);
				
	        foreach($usuarios_grupos as $ug) {
	            $sql = "insert into usuarios_grupos (usuario_id, grupo_id) values('$id','$ug')";
	            $ok 	= $db->Execute($sql);
	        }

			if ($ok) {  
				echo '<center><div style="width:90%;height:30px;background-color:lightblue;border:2px solid blue;font-size:16px;font-weight;bold;text-align:center;margin-top:5px;padding-top:5px;color:blue;">';
				echo "Datos guardados correctamente</div></center>";
			} else {
				echo '<center><div style="width:90%;height:30px;background-color:lightred;border:2px solid red;font-size:16px;font-weight;bold;text-align:center;margin-top:5px;padding-top:5px;color:red;">';
				echo "No se pudieron guardar los datos!!</div></center>";
			}
			die();
		}
	} // if $_POST



    //---------------------------------------------------------------------------------
    //                                                       Busca el Plan del Usuario
    //---------------------------------------------------------------------------------
	$sql = "select * from planes_usuarios where id='{$Usuario['plan_usuario_id']}'";
	$rs  = $db->SelectLimit($sql);
	$Plan = $rs->FetchRow();


    //---------------------------------------------------------------------------------
    //                                       Obtiene el ultimo registro de pago impago
    //---------------------------------------------------------------------------------
	$sql = "select * from pagos where user_id='{$Usuario['id']}' and fecha_pago=0 order by vencimiento DESC";
	$rs  = $db->SelectLimit($sql);
	$Ultimo = $rs->FetchRow();
	if(!$Ultimo){
		$Ultimo['id']    = 0;
		$Ultimo['user_id'] = $Usuario['id'];
		$Ultimo['desde'] = time();
		$Ultimo['hasta'] = time()+(60*60*24*$Plan['renovacion']);
		$Ultimo['vencimiento'] = time()+(60*60*24*10);
		$Ultimo['plan_id'] = $Usuario['plan_usuario_id'];
		$Ultimo['importe'] = $Plan['importe'];
		$ok = $db->Replace('pagos', $Ultimo,'id', $autoquote = true); 		

		$sql = "select * from pagos where user_id='{$Usuario['id']}' and fecha_pago=0 order by vencimiento DESC";
		$rs  = $db->SelectLimit($sql);
		$Ultimo = $rs->FetchRow();

	}

?>

<html>
<head>
	<link href="<?php echo ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo URL;?>/js/ui/development-bundle/jquery-1.7.2.js"></script>
    <script type="text/javascript" src="<?php echo URL;?>/js/ui/js/jquery-ui-1.8.21.custom.min.js"></script>    
	<script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/localization/messages_es.js"></script>
	<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />

	<style>
		#frm_registro input[type="text"] {
			width: 200px;
		}

	    label { float: left; }
	    label.error { float: none; color: red; padding-left:0px; vertical-align: top; display: block;font-size:12px;}
	    p { clear: both; }
	    em { font-weight: bold; padding-right: 1em; vertical-align: top; color:red;}

	    input {margin:5px;}
	    .ctitulo {
	        text-align:right;
	        font-weight:bold;
	        line-height:30px;
	    }
	    .required { 
	        border:1px solid #FF9900; 
	        background:#eee;
	    }


	</style>
</head>

<body style='padding:20px;'>

<?php echo "<h2>$titulo</h2>";?>
	<form action='usuarios_pagos.php' method='post' name='frm_registro' id='frm_registro'>
		<table width='100%' cellpadding='3'>
			<tr>
				<td>Periodo desde el <?php echo date("d/m/Y",$Ultimo['desde']);?></td>
				<td>Hasta el:<?php echo date("d/m/Y",$Ultimo['hasta']);?></td>
			</tr>
			<tr>
				<td >Importe: <input type='text' name='importe' id='importe' value='<?php echo number_format($Ultimo['importe'],2);?>' style='width:70px;text-align:right;'></td>
				<td >Vencimiento: <?php echo cb_fechas($Ultimo['vencimiento']);?></td>
			</tr>
			<tr>
				<td >Pagado?:
					<select name='pagado'>
						<option value='0' >No</option> 
						<option value='1' >Si</option>
					</select>
				</td>
				<td >Obs:
					<input type='text' name='obs' id='obs' value='<?php echo $Ultimo['obs'];?>' style='width:200px;'>
					<input type='submit' value='Guardar Cambios' style='width:110px;'>
				</td>
			</tr>


		</table>
	</form>
</body></html>