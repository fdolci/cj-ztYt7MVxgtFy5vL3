<?php
    $item_menu[0] = 4; 
    $item_menu[1] = 2;  
    $title = 'Usuarios';

   	$mipath='../';
   	include ('../inc/config.php');
    $de_donde = '';

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

    $titulo         = 'Edición de Usuarios';    
    
	if(!empty($_SESSION['Msg'])) {
		echo '<center><div style="width:90%;height:30px;background-color:lightblue;border:2px solid blue;font-size:16px;font-weight;bold;text-align:center;margin-top:5px;padding-top:5px;color:blue;">';
		echo $_SESSION['Msg']."</div></center>";
		$_SESSION['Msg']='';
	}
    

	$id        = request('id',0);
	
?>

<?php

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


	$sql="select * from usuarios_grupos where usuario_id='$id'";
	$rs = $db->Execute($sql);
	$Pertenece = $rs->GetRows();

    $cond 	 = "select * from grupos where activo=1 order by nombre ASC";
	$rs 	 = $db->Execute($cond);
	$xGrupos = $rs->GetRows();
    $select_grupos = "<select name='usuarios_grupos[]' multiple style='width:150px; height:100px;' class='required'>";
    foreach ($xGrupos as $xgrupo) {
        if (!empty($Pertenece) ) {
            $existe = 0;
            foreach($Pertenece as $p){
                if ($p['grupo_id'] == $xgrupo['id']) { $existe=1; break;}
            }
            if ($existe == 1) {
                $select_grupos.= "<option value='{$xgrupo['id']}' selected='selected'>{$xgrupo['nombre']}</option>";
            } else {
                $select_grupos.= "<option value='{$xgrupo['id']}'>{$xgrupo['nombre']}</option>";
            }
            
        } else {
            $select_grupos.= "<option value='{$xgrupo['id']}'>{$xgrupo['nombre']}</option>";    
        }
        
    }
    $select_grupos.= "</select>";



	$sql="select * from usuarios where id='$id'";
	$rs = $db->SelectLimit($sql,1);
	$Usuario = $rs->FetchRow();
    

    //---------------------------------------------------------------------------------
    //                                                       Arma Select de Planes
    //---------------------------------------------------------------------------------
	$sql = "select * from planes_usuarios order by plan_usuarios ASC";
	$rs  = $db->Execute($sql);
	$Planes = $rs->GetRows();
    $select_planes = '<select name="data[plan_usuario_id]" id="plan_usuario_id" class="required">';
        foreach($Planes as $dd){
                if ( $Usuario['plan_usuario_id'] == $dd['id'] or $Usuario['plan_usuario_id']==0 or !isset($Usuario)) { 
                    $sel = "selected='selected'"; 
                    if($dd['defecto']==1){
                    	$Usuario['plan_usuario_id']   = $dd['id'];	
                    }
                    
                } else {
                    $sel='';
                }
                $select_planes.= "<option value='{$dd['id']}' $sel >{$dd['plan_usuarios']} -> [{$dd['cantidad_avisos']}]</option>";
        }
        $select_planes.= "</select>";





    //---------------------------------------------------------------------------------
    //                                                       Arma Select de Provincias
    //---------------------------------------------------------------------------------
    $select_provincia = '<select name="data[provincia_id]" id="provincia_id" class="required">';
        foreach($Provincias as $dd){
                if ( $Usuario['provincia_id'] == $dd['id'] or $Usuario['provincia_id']==0 or !isset($Usuario)) { 
                    $sel = "selected='selected'"; 
                    $Usuario['provincia_id']   = $dd['id'];
                } else {
                    $sel='';
                }
                $select_provincia.= "<option value='{$dd['id']}' $sel >{$dd['locacion']}</option>";
        }
        $select_provincia.= "</select>";

        // Obtiene las ciudades
        $sql = "select * from ciudades where parent_id='{$Usuario['provincia_id']}' order by locacion ASC";
        $rs  = $db->Execute($sql);
        $Ciudades = $rs->GetRows();


    //---------------------------------------------------------------------------------
    //                                                         Arma Select de Ciudades
    //---------------------------------------------------------------------------------
    $select_ciudad = '<select name="data[ciudad_id]" id="ciudad_id" class="required">';
        foreach($Ciudades as $dd){
                if ( $Usuario['ciudad_id'] == $dd['id'] or $Usuario['ciudad_id']==0 ) { 
                    $sel = "selected='selected'"; 
                    $Usuario['ciudad_id']   = $dd['id'];
                } else {
                    $sel='';
                }
                $select_ciudad.= "<option value='{$dd['id']}' $sel >{$dd['locacion']}</option>";
        }
        $select_ciudad.= "</select>";

    

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

<script type="text/javascript">
    function comprueba_email(){
        var email = $("#email").val();
        $.ajax({
                type:"GET", //tipo de formato de envio de información
                url: "<?php echo URL;?>/ajax/comprueba_email.php?id=<?php echo $Usuario['id'];?>&email="+email,
                success:function(respuesta){
                    console.log(respuesta);
                    if(respuesta==0){
                        $("#email").css({'outline': '0px'});                        
                        $("#frm_registro").validate().element( "#email" );
                    } else {
                        $("#email").val('Ese email está en uso!!');
                        $("#email").css({'outline': '2px solid #FF0000'});
                    }
                    
                }
        });
    }
</script>

</head>

<body style='padding:20px;'>

<?php echo "<h2><a name='editar'>".iif($id>0, 'Modificacion de Datos','Crear nuevo registro')."</h2>";?>
	<form action='usuarios_editar.php' method='post' name='frm_registro' id='frm_registro'>
	<table>
		<tr>
			<td align='right' nowrap><b>Apellido (*):</b></td>
			<td><input type='text' name='data[apellido]' value='<?php echo $Usuario['apellido'];?>' size='50' class="required" /></td>
            <td width="200" valign='top' style="padding-left:10px;" rowspan="8"><b>Grupos de pertenencia (*):</b><br />
            	<?php echo $select_grupos;?>
            	<br><br>
            	<b>Plan de Anunciante:</b><br>
            	<?php echo $select_planes;?>
            </td>
		</tr>
		<tr>
			<td align='right'><b>Nombre (*):</b></td>
			<td><input type='text' name='data[nombre]' value='<?php echo $Usuario['nombre'];?>' size='50' class="required"/></td>
		</tr>
		<tr>
			<td align='right'>Telefono:</td>
			<td><input type='text' name='data[telefono]' value='<?php echo $Usuario['telefono'];?>' size='50'  /></td>
		</tr>
		<tr>
			<td align='right'><b>Email (*):</b></td>
			<td><input type='text' name='data[email]' id='email' value='<?php echo $Usuario['email'];?>' size='70'  class="required email" onblur="comprueba_email();"/></td>
		</tr>

		<tr>
			<td align='right'><b>Dirección (*):</b></td>
			<td><input type='text' name='data[direccion]' value='<?php echo $Usuario['direccion'];?>' size='70'  class="required" /></td>
		</tr>
		<tr>
			<td align='right' nowrap><b>Cod.Postal (*):</b></td>
			<td><input type='text' name='data[codigo_postal]' value='<?php echo $Usuario['codigo_postal'];?>' size='20' /></td>
		</tr>
		<tr>
			<td align='right'><b>Provincia (*):</b></td>
			<td><?php echo $select_provincia;?></td>
		</tr>
		<tr>
			<td align='right'><b>Localidad (*):</b></td>
			<td><?php echo $select_ciudad;?></td>
		</tr>

		<tr>
			<td align='right'>Clave:</td>
			<td colspan='2'>
                <input type='text' name='data[nuevaclave]' value='' <?php if ($Usuario['id']==0){echo "class='required'";}?>/>
                <br><small>Si desea mantener la misma clave, deje este campo vacio.</small>
            </td>
		</tr>

		<tr>
			<td colspan='3' align='center'>
				<br>
				<b>(*) Datos obligatorios</b><br>
				<input type='hidden' name='accion' value='guardar' />
				<input type='hidden' name='data[clave]' value='<?php echo $Usuario['clave'];?>' />
				<input type='hidden' name='data[id]' value='<?php echo $id;?>' />
				<input type='submit' name='submit' value='Guardar Cambios' />
			</td>
		</tr>
	</table>
	</form>
	<script>
	    $(document).ready(function(){
	        $("#frm_contacto").validate();
	    });

		   $("#provincia_id").change(function () {
		        var provincia_id = $("#provincia_id").val();
		        $.ajax({
		            type:"GET", //tipo de formato de envio de información
		            url: "<?php echo URL;?>/ajax/actualizar_ciudades.php?provincia_id="+provincia_id,
		            success:function(respuesta){
		                $('#ciudad_id').html(respuesta);
		            }
		        });

		    });

	</script>

</body></html>