<?php
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$id = request('id',0);
    $new_parent = request('new_parent',0);

    if ( $id>0 ){
        $cond 	= "update familias set parent_id = '$new_parent' where id='$id' ";
    	$ok		= $db->Execute($cond);

			$sql = "select * from familias where parent_id='$new_parent' order by orden ASC";
			$rs 	= $db->Execute($sql);
			$x	= $rs->GetRows();
            $cuantos = count($x);
			$orden = 1;
			foreach ($x as $r){
				$cond 	= "update familias set orden = '$orden', de = '$cuantos' where id = '{$r['id']}'";
				$ok		= $db->Execute($cond);
				$orden++;

			}

        
    }

	redirect('familias.php');
	exit();


?>