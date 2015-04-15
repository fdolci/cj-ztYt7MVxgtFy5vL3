<?php
	$sql 	= "select * from setting where name='meta_tags' order by orden ASC";
	$rs 	= $db->SelectLimit($sql,1);
	$rs	    = $rs->FetchRow();

    $mm=array();
    if (!empty($rs['valor'])) { $mm = unserialize($rs['valor']);}
    foreach($mm as $clave => $valor ){
        $MetaTags[$clave] = $valor['idioma'.$idioma_elegido];
    }

?>