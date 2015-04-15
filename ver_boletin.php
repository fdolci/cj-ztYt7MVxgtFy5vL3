<?php
	include_once('./inc/config.php');
    $boletin_id = request('boletin_id',0);
    if ($boletin_id == 0) {
        $Mensaje["mensaje"]   = "Bolet&iacute;n inexistente!!";
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect( URL.'/index.php');
    }

    $categoria_boletin = ($Config['categoria_boletin']);
    
    $categoria = busco_categoria_por_id( $categoria_boletin );
    $boletin = busco_publicacion('',$boletin_id);

    //-- Tiene galeria de fotos?
    $cond  = "select * from galerias_fotos where galeria_id = '$boletin_id' and activo = '1' order by orden ASC";
    $rs    = $db->Execute($cond);
    $Fotos = $rs->GetRows();

    include_once('./html/ver_boletin.html.php');
?>