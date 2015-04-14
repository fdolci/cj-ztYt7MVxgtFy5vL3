<?php
    $mipath='../';
	include ('../inc/config.php');
    $de_donde = '';

    $cual = request('cual','');
    $id   = request('id','');

    $sql = "select $cual as campo from productos where id='$id'";
    $rs  = $db->SelectLimit($sql,1);
    $x   = $rs->FetchRow();
    $valor = $x['campo'];
    if ($valor==0) { $valor=1; } else { $valor=0; }

    $sql = "update productos set $cual='$valor' where id='$id'";
    $ok = $db->Execute($sql);

    echo "$valor";    

?>