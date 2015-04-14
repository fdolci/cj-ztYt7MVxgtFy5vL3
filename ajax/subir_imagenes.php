<?php
    $mipath='../';
    include ('../inc/config.php');

/*
$cn = mysql_connect("server","user","pwd");
mysql_select_db("bd", $cn);
 */

if($_GET['action'] == 'listFotos'){
    $producto_id = $_GET['producto_id'];
    $rs = $db->Execute("select * from productos_imagenes where producto_id='$producto_id' ORDER BY id ASC") ;
    $Fotos = $rs->GetRows();

    foreach($Fotos as $row) {
        echo  "<li>
                <a href='javascript:;' id='{$row['id']}'><img src='".URL."/img/del.gif'></a>
                <img src='".VER_FOTOS."/$producto_id/{$row[imagen]}' />
            </li>";
    }

} elseif($_GET['action'] == 'eliminar'){

    $id = $_GET['id'];
    $rs = $db->SelectLimit("select * from productos_imagenes where id='$id'",1);
    $foto = $rs->FetchRow();

    $destino     = SUBIR_FOTOS."/".$foto['producto_id']."/";
    $nombre_foto = $destino.$foto['imagen'];
    $miniatura   = $destino.'tn_'.$foto['imagen'];
    unlink($nombre_foto);
    unlink($miniatura);

    $ok = $db->Execute("delete from productos_imagenes where id='$id'");


} else {
    $producto_id = $_GET['producto_id'];
    $destino = SUBIR_FOTOS."/$producto_id/";
    if(isset($_FILES['image'])){
 
        $nombre = $_FILES['image']['name'];
        $temp   = $_FILES['image']['tmp_name'];



        // subir imagen al servidor
        if(move_uploaded_file($temp, $destino.$nombre))
        {

            //---------------------- Ajustamos el tamaño de la imagen
            $ruta_imagen = $destino.$nombre;
            $miniatura_ancho_maximo = 62;
            $miniatura_alto_maximo = 40;
            $galeria_ancho_maximo = 740;
            $galeria_alto_maximo = 480;

            $info_imagen = getimagesize($ruta_imagen);
            $imagen_ancho = $info_imagen[0];
            $imagen_alto = $info_imagen[1];
            $imagen_tipo = $info_imagen['mime'];

            switch ( $imagen_tipo ){
                case "image/jpg":
                case "image/jpeg":
                    $imagen = imagecreatefromjpeg( $ruta_imagen );
                    break;
                case "image/png":
                    $imagen = imagecreatefrompng( $ruta_imagen );
                    break;
                case "image/gif":
                    $imagen = imagecreatefromgif( $ruta_imagen );
                    break;
            }
            // hago el thumbsnail
            $lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
            imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $miniatura_ancho_maximo, $miniatura_alto_maximo, $imagen_ancho, $imagen_alto);
            imagejpeg( $lienzo, $destino.'tn_'.$producto_id.'-'.$nombre, 90 );

            // le cambio el tamaño a la imagen original
            $nombre_final = $producto_id.'-'.$nombre;
            $lienzo = imagecreatetruecolor( $galeria_ancho_maximo, $galeria_alto_maximo );
            imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $galeria_ancho_maximo, $galeria_alto_maximo, $imagen_ancho, $imagen_alto);
            $ok = imagejpeg( $lienzo, $destino.$nombre_final, 90 );

            if ($ok){
                unlink($ruta_imagen);

                $sql = "insert into productos_imagenes (producto_id, imagen) values ('$producto_id', '$nombre_final' )";
                $rs = $db->Execute($sql);
                $id  = $db->Insert_ID();

                echo  "<li>
                        <a href='javascript:;' id='$id'><img src='".URL."/img/del.gif'></a>
                        <img src='".VER_FOTOS."/$producto_id/$nombre_final' />
                    </li>";


            }

        }
 
    }
}
?>