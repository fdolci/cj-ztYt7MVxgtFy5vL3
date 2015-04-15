<?php
    $pub_id = $Pub['id'];

    $sql = "select comentarios.*, comentaristas.nombre, comentaristas.apellido
            from comentarios 
            left join comentaristas on comentarios.comentarista_id=comentaristas.id 
            where comentarios.publicacion_id = '$pub_id' and comentarios.publicado='1'
            order by comentarios.fecha ASC";

    $rs = $db->Execute($sql);
    $Comentarios = $rs->GetRows();
    $cuantos_comentarios = count($Comentarios);

    //pr($Comentarios);



  
?>