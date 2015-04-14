<?php

$_SESSION["rol"][0] = '2';
$_SESSION["id"] = '2';
$_SESSION["inicio"] = time();
$_SESSION["host"] = 'si';
$mipath='../';
require_once '../inc/config.php';
//require_once '../inc/fn_varias.php';

$cat_id = request('opcion',0);

$sql	= "select id,titulo1 from publicaciones where activo=1 and categoria_id='$cat_id' order by titulo1 ASC";
$rs 	= $db->Execute($sql);
$zz		= $rs->GetRows();

$combo = "<select name='pub_id' id='pub_id'>";
foreach($zz as $item){
	if ($pub_id==$item['id']) {
		$combo.="<option value=".$item['id']." selected='selected'>".$item['titulo1']."</option>";
	} else {
		$combo.="<option value=".$item['id'].">".htmlentities($item['titulo1'])."</option>";
	}
}
$combo .= "</select>";
echo $combo;
?>