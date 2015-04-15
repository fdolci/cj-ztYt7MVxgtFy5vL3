<?php 
    $sql = "select id,locacion, urlfriendly from ciudades where parent_id='0' and activo=1 order by locacion ASC";
    $rs  = $db->Execute($sql);
    $prov = $rs->GetRows();
    $Provincias = array();
    foreach ($prov as $p){
        $Provincias[$p['urlfriendly']]['id'] = $p['id'];
        $Provincias[$p['urlfriendly']]['locacion'] = $p['locacion'];
    }

?>