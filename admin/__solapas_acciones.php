<?php

	$mipath='../';
	include ('../inc/config.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$producto_id = request('producto_id',0);
    $solapa_id   = request('solapa_id',0);
	$accion      = request('accion','');    
?>

<body style="background-color:#81c2c2;">
<?php
        $solapa[1] = $solapa[2] = $solapa[3] = $solapa[4] = $solapa[5] = ' ';                
    	$titulo[1] = $titulo[2] = $titulo[3] = $titulo[4] = $titulo[5] = '';                

		switch ($accion) {
			case 'eliminar':
				$sql = "delete from solapas where id='$solapa_id'";
				$rs  = $db->Execute($sql);
				$_SESSION['Msg'] = 'Solapa eliminada correctamente';
                $solapa_id = 0;
				break;

			case 'estado':
				$sql = "select * from solapas where id='$solapa_id'";
				$rs  = $db->SelectLimit($sql,1);
				$x   = $rs->FetchRow();
				$activo = iif($x['activo']==0,1,0);
				$sql = "update solapas set activo='$activo' where id='$solapa_id'";
				$rs 	= $db->Execute($sql);
                $producto_id = $x['producto_id'];
                $solapa_id = 0;
				break;

			case 'editar':
					$cond 	= "select * from solapas where id=".$solapa_id;
					$rs 	= $db->SelectLimit($cond, 1);
					$Solapa	= $rs->FetchRow();
                    $solapa[1]	       = stripslashes($Solapa['solapa1']);
                    $solapa[2]	       = stripslashes($Solapa['solapa2']);
                    $solapa[3]	       = stripslashes($Solapa['solapa3']);
                    $solapa[4]	       = stripslashes($Solapa['solapa4']);
                    $solapa[5]	       = stripslashes($Solapa['solapa5']);                
                	$titulo[1]		   = $Solapa['titulo1'];
                	$titulo[2]		   = $Solapa['titulo2'];
                	$titulo[3]		   = $Solapa['titulo3'];
                	$titulo[4]		   = $Solapa['titulo4'];
                	$titulo[5]		   = $Solapa['titulo5'];                
                    
				break;

		}

?>
<link href="<?=ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>

<?php include_once('solapas_listar.php');?>
