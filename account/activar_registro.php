<?php
	include_once('../inc/config.php');

    $data = request('data','');

    if ( esta_login() ){
        $Mensaje["mensaje"]   = 'ERROR!! Ya está logueado en el sistema.!';
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL);
        die();
    }




    if (empty($data)){
        $Mensaje["mensaje"]   = 'ERROR Enlace mal formado!!';
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL);
        die();
    }


    $data     = base64_decode($data);
    $recupero = unserialize($data);



    if (empty($recupero)){
        $Mensaje["mensaje"]   = 'ERROR Enlace mal formado!!';
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL);
        die();
    }


    // $rs = $db->SelectLimit("select * from productos where id='{$recupero['id']}' and email='{$recupero['email']}' and activo=0",1);
    $rs = $db->SelectLimit("select * from usuarios where email='{$recupero['email']}' and id='{$recupero['id']}' and activo=0",1);    
    $Usuario = $rs->FetchRow();


    if ($Usuario){
        
        $Usuario['activo'] = 1;
        $ok = $db->Replace('usuarios', $Usuario,'id', $autoquote = true); 

                //-----------------------------------------------------------------------------
                //                                Cual es el plan que tiene activo el usuario??
                //-----------------------------------------------------------------------------
                $sql = "select * from planes_usuarios where id='{$Usuario['plan_usuario_id']}'";
                $rs  = $db->SelectLimit($sql,1);
                $planes_usuarios    = $rs->FetchRow();
                $limite_avisos      = $planes_usuarios['cantidad_avisos'];
                $vencimiento_avisos = $planes_usuarios['vigencia'];

                $_SESSION['user_id']  = $Usuario['id'];
                $_SESSION['limite_avisos']  = $limite_avisos;
                $_SESSION['vencimiento_avisos']  = $vencimiento_avisos;

                $saludo = $Usuario['nombre'].' '.$Usuario['apellido'];
                $Mensaje["mensaje"]   = 'Su cuenta ha sido activada correctamente!!. Puede proceder a la carga del evento.';
                $Mensaje["tipo"]    = 'success';
                $Mensaje["autoclose"] = true;
                $_SESSION['Mensaje'] = $Mensaje;                
                redirect(URL.'/account/listar_anuncios.php');
                die();


    } else {
        
        $Mensaje["mensaje"]   = 'ERROR La Clave de recuperación no pertenece a ningún usuario activo!!';
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL.'/index.php');
        die();


    }        
    include_once(ROOT.'/html/header.html.php');        

    include_once(ROOT.'/html/footer.html.php');
?>