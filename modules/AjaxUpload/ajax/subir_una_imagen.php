<?php
    $mipath='../';
    include ($mipath.'../../inc/config.php');

    $datos_ajaxupload = request('datos_ajaxupload','');
    if(empty($datos_ajaxupload)) { echo "error ";}
    $ajaxupload = unserialize( base64_decode($datos_ajaxupload) ); 
/*
    $ajaxupload['tabla'] = 'publicaciones_imagenes';
    $ajaxupload['campo'] = 'publicacion_id';
    $ajaxupload['id']    = $Pub['id'];
    $ajaxupload['cual']  = 'miniatura';
    $ajaxupload['identificador']  = $identificador;
    $ajaxupload['donde_subir']    = PUB_SUBIR_FOTOS;
    $ajaxupload['donde_ver']      = PUB_VER_FOTOS;
    $ajaxupload['tn_ancho'] = 240;
    $ajaxupload['tn_alto']  = 120;
    $ajaxupload['ancho']    = 240;
    $ajaxupload['alto']     = 120;
*/
    $tn_ancho = $ajaxupload['tn_ancho'];
    $tn_alto  = $ajaxupload['tn_alto'];
    $ancho    = $ajaxupload['ancho'];
    $alto     = $ajaxupload['alto'];

    if($_GET['action'] == 'listFotos'){
        $sql = "select * from {$ajaxupload['tabla']} where {$ajaxupload['campo']}='{$ajaxupload['id']}' and cual='{$ajaxupload['cual']}' and identificador='{$ajaxupload['identificador']}' ";

        $rs = $db->SelectLimit($sql,1) ;

        $Foto = $rs->FetchRow();

        if ($Foto){
            echo  "<li id='img_{$Foto['id']}' ><a href='#' title='Eliminar la imagen'><img src='".URL."/img/del.gif' onclick='eliminar({$Foto['id']});' ></a>";
            if ($tn_ancho>0 and $tn_alto>0) {            
                echo "<img src='{$ajaxupload['donde_ver']}/mini/tn_{$Foto[imagen]}' />";
            } else {
                echo "<img src='{$ajaxupload['donde_ver']}/{$Foto[imagen]}'  />";
            }
            echo "</li>";
        }

    } elseif($_GET['action'] == 'eliminar'){

        $id = $_GET['id'];
        $rs = $db->SelectLimit("select * from {$ajaxupload['tabla']} where id='$id'",1);
        $foto = $rs->FetchRow();

        $destino     = $ajaxupload['donde_subir'];
        $nombre_foto = $destino.$foto['imagen'];
        $miniatura   = $destino.'mini/tn_'.$foto['imagen'];
        unlink($nombre_foto);
        unlink($miniatura);

        $ok = $db->Execute("delete from {$ajaxupload['tabla']} where id='$id'");




    } else {

        //--- Elimino las anteriores si habia...
        $sql = "select * from {$ajaxupload['tabla']} where {$ajaxupload['campo']}='{$ajaxupload['id']}' and cual='{$ajaxupload['cual']}' and identificador='{$ajaxupload['identificador']}' ";
        $rs = $db->Execute($sql);
        $Fotos = $rs->GetRows();
        
        $destino     = $ajaxupload['donde_subir'] ;
        foreach ($Fotos as $foto) {
            $nombre_foto = $destino.$foto['imagen'];
            $miniatura   = $destino.'mini/tn_'.$foto['imagen'];
            unlink($nombre_foto);
            unlink($miniatura);
        }

        $ok = $db->Execute("delete from {$ajaxupload['tabla']} where {$ajaxupload['campo']}='{$ajaxupload['campo']}' and cual='{$ajaxupload['cual']}' and identificador='{$ajaxupload['identificador']}' ");


        $destino = $ajaxupload['donde_subir'] ."/";
        if(isset($_FILES['image'])){
     
            $x = explode('.',$_FILES['image']['name']);
            $ext = end($x);
            $x = md5(microtime().'_'.$_SERVER["REMOTE_ADDR"]);
            $nombre = $x.'.'.$ext; //$_FILES['image']['name'];
           // echo $nombre;
            $temp   = $_FILES['image']['tmp_name'];

            // subir imagen al servidor
            if(move_uploaded_file($temp, $destino.$nombre)) {



                //---------------------- Ajustamos el tamaño de la imagen
                $ruta_imagen = $destino.$nombre;

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

                if ($tn_ancho>0 and $tn_alto>0) {
                    // hago el thumbsnail
                    $lienzo = imagecreatetruecolor( $tn_ancho, $tn_alto );
                    imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $tn_ancho, $tn_alto, $imagen_ancho, $imagen_alto);
                    imagejpeg( $lienzo, $destino.'mini/tn_'.$nombre, 90 );


                    // le cambio el tamaño a la imagen original
                    $lienzo = imagecreatetruecolor( $ancho, $alto );
                    imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $ancho, $alto, $imagen_ancho, $imagen_alto);
                    $ok = imagejpeg( $lienzo, $destino.$nombre, 90 );


                }



                        $sql = "insert into {$ajaxupload['tabla']} ({$ajaxupload['campo']}, imagen, cual, identificador) values ('{$ajaxupload['id']}', '$nombre','{$ajaxupload['cual']}', '{$ajaxupload['identificador']}' )";
                        $rs = $db->Execute($sql);
                        $id  = $db->Insert_ID();

                        echo  "<li id='img_$id' ><a href='#' title='Eliminar la imagen'><img src='".URL."/img/del.gif' onclick='eliminar($id);' ></a>";
                            echo "<img src='{$ajaxupload['donde_ver']}/$nombre' />";
                        echo "</li>";




            }
     
        }

    }

?>