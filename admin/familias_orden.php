<?php
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$id = request('id',0);

	$cond 	= "select orden, parent_id from familias where id = '$id' ";
	$rs 	= $db->SelectLimit($cond, 1);
	$x		= $rs->FetchRow();
	$sube     = request('sube','no');
	$orden_actual = $x['orden'];
    $parent_id    = $x['parent_id'];

	if ($sube=='si') {$nuevo_orden = ($orden_actual - 1.5); }
			else { $nuevo_orden = ($orden_actual + 1.5); }
			$cond 	= "update familias set orden = '$nuevo_orden' where id='$id' ";
			$ok		= $db->Execute($cond);

			$sql = "select * from familias where parent_id='$parent_id' order by orden ASC";
			$rs 	= $db->Execute($sql);
			$x	= $rs->GetRows();
            $cuantos = count($x);
			$orden = 1;
			foreach ($x as $r){
				$cond 	= "update familias set orden = '$orden', de = '$cuantos' where id = '{$r['id']}'";
				$ok		= $db->Execute($cond);
				$orden++;

			}

	redirect("familias.php?parent_id=$parent_id");
	exit();


?>