<?php
    $mipath='../';
	include ('../inc/config.php');
    $de_donde = '';

    $email = request('email','');
    $id   = request('id','');

    $sql = "select id from usuarios where id!='$id' and email='$email'";
    $rs  = $db->SelectLimit($sql,1);
    $x   = $rs->FetchRow();
 
    if (empty($x) ) { $valor=0; } else { $valor=1; }

    echo "$valor";    

?>