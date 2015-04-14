<?php

	include('header.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$id = request('id',0);
	$categoria_id = request('categoria_id',0);

	$cond 	= "select * from publicaciones where id=".$id;
	$rs 	= $db->SelectLimit($cond, 1);
	$x		= $rs->FetchRow();
	$sube     = request('sube','no');
	$orden_actual = $x[orden];

	if ($sube=='si') {$nuevo_orden = ($orden_actual + 1.5); }
			else { $nuevo_orden = ($orden_actual - 1.5); }
			$cond 	= "update publicaciones set orden=".$nuevo_orden." where id=".$id;
			$ok		= $db->Execute($cond);

			$sql = "select * from publicaciones where categoria_id='$categoria_id' order by orden ASC";
			$rs 	= $db->Execute($sql);
			$x	= $rs->GetRows();
			$orden = 1;
			foreach ($x as $r){
				$cond 	= "update publicaciones set orden=".$orden." where id=".$r[id];
				$ok		= $db->Execute($cond);
				$orden++;

			}

	redirect('contenidos.php?categoria_id='.$categoria_id);
	exit();


?>