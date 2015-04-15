<?php
    
    $url_vieja = $route;
    
    $sql = "select * from redirecciones where url_vieja='$url_vieja'";
	$rs 	= $db->SelectLimit($sql,1);
	$stt	= $rs->FetchRow();
    
    if ($stt) {
        $tipo = $stt['tipo'];
        $url  = $stt['url_nueva'];

        if ($tipo == 301) {
            $tipo = '301 Moved Permanently';    
        }
        
        Header("HTTP/1.1 $tipo");
        Header("Location: $url");
        exit();
        
    }

?>

