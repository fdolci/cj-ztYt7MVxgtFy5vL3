<?php
    $item_menu[0] = 5;
    $item_menu[1] = 2 ;
    $title = 'Productos';    
	include('header.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$id = request('id',0);
	$sube     = request('sube','no');
	$familia_id = request('familia_id',0);

	$cond 	= "select activo,orden from productos where id='$id' ";
	$rs 	= $db->SelectLimit($cond, 1);
	$x		= $rs->FetchRow();

	$orden_actual = $x['orden'];

	if ($sube=='si') {$nuevo_orden = ($orden_actual - 1.5); }
			else { $nuevo_orden = ($orden_actual + 1.5); }
			$cond 	= "update productos set orden='$nuevo_orden' where id='$id' ";
			$ok		= $db->Execute($cond);

			$sql = "select * from productos where familia_id = '$familia_id' order by orden ASC";
			$rs 	= $db->Execute($sql);
			$x	= $rs->GetRows();
			$orden = 1;
			foreach ($x as $r){
				$cond 	= "update productos set orden='$orden' where id='{$r['id']}' ";
				$ok		= $db->Execute($cond);
				$orden++;

			}

	redirect('productos.php?familia_id='.$familia_id);
	exit();


?>