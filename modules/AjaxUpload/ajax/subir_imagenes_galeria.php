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

        $rs = $db->Execute("select * from {$ajaxupload['tabla']} where {$ajaxupload['campo']}='{$ajaxupload['id']}' and cual='{$ajaxupload['cual']}' and identificador='{$ajaxupload['identificador']}' ") ;
        $Fotos = $rs->GetRows();

        if ($Fotos){
            foreach($Fotos as $foto ){
            echo  "<li id='img_{$foto['id']}' ><a href='#' title='Eliminar la imagen'><img src='".URL."/img/del.gif' onclick='eliminar_gal({$foto['id']});' ></a>";                
            echo  "
                    <img src='{$ajaxupload['donde_ver']}/mini/tn_{$foto[imagen]}' />
                </li>";
            } // endforeach
        }

    } elseif($_GET['action'] == 'eliminar'){

        $id = $_GET['id'];
        $rs = $db->SelectLimit("select * from {$ajaxupload['tabla']} where id='$id'",1);
        $foto = $rs->FetchRow();

        $destino     = $ajaxupload['donde_subir']."/";
        $nombre_foto = $destino.$foto['imagen'];
        $miniatura   = $destino.'mini/tn_'.$foto['imagen'];
        unlink($nombre_foto);
        unlink($miniatura);

        $ok = $db->Execute("delete from {$ajaxupload['tabla']} where id='$id'");


    } else {

        $destino = $ajaxupload['donde_subir'] ."/";
        if(isset($_FILES['image'])){
     
            $x = explode('.',$_FILES['image']['name']);
            $ext = strtolower(end($x));
            $x = md5(microtime().'_'.$_SERVER["REMOTE_ADDR"]);
            $nombre = $x.'.'.$ext; //$_FILES['image']['name'];

            $temp   = $_FILES['image']['tmp_name'];



        if(move_uploaded_file($temp, $destino.$nombre)) {

            //---------------------- Ajustamos el tamaño de la imagen
            $ruta_imagen            = $destino.$nombre;
            $miniatura_ancho_maximo = $tn_ancho;
            $miniatura_alto_maximo  = $tn_alto;
            $galeria_ancho_maximo   = $ancho;
            $galeria_alto_maximo    = $alto;

            if($ext=='jpg' or $ext=='jpeg'){

                $ruta = $ruta_imagen;
                list($ancho_foto, $alto_foto, $formato) = getimagesize($ruta); //obtenemos los datos de la imagen.

                $nue_ancho = $galeria_ancho_maximo;
                $nue_alto  = $galeria_alto_maximo;

                // Dimensiones del thumbnail 
                $ancho_thumbnail = $nue_ancho; 
                $alto_thumbnail  = $nue_alto; 


                // Cargamos la fotografía y guardamos sus dimensiones y ratio 
                $foto_entera = imagecreatefromjpeg($ruta); 
                 
                         
                // Creamos una imagen con fondo blanco para el thumbnail 
                $nueva  = imagecreatetruecolor($ancho_thumbnail,$alto_thumbnail); 
                $fondo  = imagecolorallocate($nueva, 255, 255, 200);     
                imagefill($nueva, 0, 0, $fondo);  

                // Creamos el thumbnail y lo grabamos 
                if($nue_ancho > $nue_alto) {
                    $tipo = 'apaisada';
                    $ratio_foto = $ancho_foto/$alto_foto;
                    $nuevo_alto = $ancho_thumbnail/$ratio_foto;

                    if($nuevo_alto < $nue_alto) {
                        $nuevo_alto = $nue_alto;
                        $ratio_foto  = $alto_foto/$ancho_foto;
                        $nuevo_ancho = $alto_thumbnail/$ratio_foto;
                    } else {
                        $nuevo_ancho = $alto_thumbnail/$ratio_foto;
                    }
                    $margen_top = ($nuevo_alto - $nue_alto)/2;
                    $margen_left = ($nuevo_ancho - $nue_ancho)/2;

                    imagecopyresampled($nueva,$foto_entera,0,0,0,$margen_top,$ancho_thumbnail,$nuevo_alto,$ancho_foto,$alto_foto); 
                    
                } else {
                    $tipo = 'vertical';
                    $ratio_foto  = $alto_foto/$ancho_foto;
                    $nuevo_ancho = $alto_thumbnail/$ratio_foto;
                    $margen_left = ($nuevo_ancho - $nue_ancho)/2;

                    $nuevo_alto = $ancho_thumbnail/$ratio_foto;
                    $margen_top = ($nuevo_alto - $nue_alto)/2;
                    imagecopyresampled($nueva,$foto_entera,0,0,$margen_left,0,$nuevo_ancho,$alto_thumbnail,$ancho_foto,$alto_foto); 
                }


                imagejpeg( $nueva, $destino.$nombre, 100 );


                $lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
                imagecopyresampled($lienzo, $foto_entera, 0, 0, 0, 0, $miniatura_ancho_maximo, $miniatura_alto_maximo, $ancho_foto, $alto_foto);
                imagejpeg( $lienzo, $destino.'mini/tn_'.$nombre, 100 );


            } else {
                copy($destino.$nombre, $destino.'/mini/tn_'.$nombre);
            }

//               unlink($ruta_imagen);
 
            $sql = "insert into {$ajaxupload['tabla']} ({$ajaxupload['campo']}, imagen, cual, identificador) values ('{$ajaxupload['id']}', '$nombre','{$ajaxupload['cual']}', '{$ajaxupload['identificador']}' )";
            $rs = $db->Execute($sql);
            $id  = $db->Insert_ID();

            echo  "<li id='img_$id' ><a href='#' title='Eliminar la imagen'><img src='".URL."/img/del.gif' onclick='eliminar_gal($id);' ></a>";                
            echo  "<img src='{$ajaxupload['donde_ver']}/mini/tn_$nombre' /></li>";

        } //endif move_upload_file

     
        }

    }

?>