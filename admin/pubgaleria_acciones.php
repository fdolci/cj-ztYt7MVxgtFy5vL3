<?php

	$mipath='../';
	include ('../inc/config.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }


	$galeria_id = request('galeria_id',0);
    $foto_id    = request('foto_id',0);
	$accion     = request('accion','');    
?>

<body style="background-color:#e0e0e0;">
<?php

    if($galeria_id == 0) {
        echo "<h1>Debe seleccionar una Galeria</h1>";
        die();
    }


		switch ($accion) {
			case 'guardar':

	            $nombre1 = request('nombre1','');
                $nombre2 = request('nombre2','');
                $nombre3 = request('nombre3','');
                $nombre4 = request('nombre4','');
                $nombre5 = request('nombre5','');            
                $nombre1 = iif( isset($nombre1), htmlspecialchars($nombre1, ENT_QUOTES,'UTF-8'), '');
                $nombre2 = iif( isset($nombre2), htmlspecialchars($nombre2, ENT_QUOTES,'UTF-8'), '');
                $nombre3 = iif( isset($nombre3), htmlspecialchars($nombre3, ENT_QUOTES,'UTF-8'), '');
                $nombre4 = iif( isset($nombre4), htmlspecialchars($nombre4, ENT_QUOTES,'UTF-8'), '');
                $nombre5 = iif( isset($nombre5), htmlspecialchars($nombre5, ENT_QUOTES,'UTF-8'), '');
                
                $archivo = request('archivo','');

                $ancho = 0; //$thumbs['ancho'];
                $alto  = 0; //$thumbs['alto'];
                $tn    = ''; //TN.$thumbs['tn'];

                if ($foto_id == 0) {
                    $cond = "insert into galerias_fotos (galeria_id, nombre1,nombre2,nombre3,nombre4,nombre5, archivo, thumbs, alto, ancho) values 
    				        ('$galeria_id', '$nombre1','$nombre2','$nombre3','$nombre4','$nombre5', '$archivo', '$tn','$alto','$ancho')";
    				$ok   = $db->Execute($cond);
                } else {
                    $cond = "update galerias_fotos set nombre1='$nombre1', nombre2='$nombre2',nombre3='$nombre3',nombre4='$nombre4',nombre5='$nombre5', 
                            archivo = '$archivo', thumbs='$tn', alto='$alto', ancho='$ancho' where id='$foto_id'";
                    $ok   = $db->Execute($cond);                            
                }
				if ($ok) {
				    echo '<center><b>Los cambios se realizaron correctamente</b></center>';
                } else {
				    echo '<center><b>No se pudo guardar, intente nuevamente</b></center>';
                }
                $foto_id = 0;
				break;


			case 'foto_eliminar':
				$sql = "delete from galerias_fotos where id='$foto_id'";
				$rs  = $db->Execute($sql);
				$_SESSION['Msg'] = 'Foto eliminado correctamente';
                $foto_id = 0;
				break;

			case 'foto_estado':
				if ($foto_id>0){
					$sql = "select * from galerias_fotos where id='$foto_id'";
					$rs  = $db->SelectLimit($sql,1);
					$x   = $rs->FetchRow();
					$activo = iif($x['activo']==0,1,0);
					$sql = "update galerias_fotos set activo='$activo' where id='$foto_id'";
					$rs 	= $db->Execute($sql);
				}
                $foto_id = 0;
				break;

			case 'foto_orden':
				if ($foto_id>0){
					$cond 	= "select * from galerias_fotos where id=".$foto_id;
					$rs 	= $db->SelectLimit($cond, 1);
					$x		= $rs->FetchRow();
					$sube     = request('sube','no');
					$orden_actual = $x['orden'];

					if ($sube=='si') {$nuevo_orden = ($orden_actual - 1.5); }
					else { $nuevo_orden = ($orden_actual + 1.5); }
					$cond 	= "update galerias_fotos set orden=".$nuevo_orden." where id=".$foto_id;
					$ok		= $db->Execute($cond);

					$sql = "select * from galerias_fotos where galeria_id='$galeria_id' order by orden ASC";
					$rs 	= $db->Execute($sql);
					$x	= $rs->GetRows();
					$orden = 1;
					foreach ($x as $r){
						$cond 	= "update galerias_fotos set orden=".$orden." where id=".$r['id'];
						$ok		= $db->Execute($cond);
						$orden++;
					}
				}
                $foto_id = 0;
				break;

			case 'foto_editar':
				if ($foto_id>0){
					$cond 	= "select * from galerias_fotos where id=".$foto_id;
					$rs 	= $db->SelectLimit($cond, 1);
					$Foto	= $rs->FetchRow();
				}
				break;

		}

?>
<link href="<?=ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>

			<?php include_once('pubgaleria_galeria.php');?>
