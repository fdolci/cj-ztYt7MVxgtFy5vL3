<?php
	include_once('./inc/config.php');

    $data = request('data','');
    $cat_id = 0;
    $mostrar_en_home = 0;

    if ($login){
        $Mensaje["mensaje"]   = 'ERROR!! Ya está logueado en el sistema.!';
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL.'/');
        die();
    }


        if ($_POST['submit']){
            $data = $_POST['data'];

            $x = explode('?',$_SERVER['REQUEST_URI']);
            $uri = $x[0];
            if ($uri != $_SERVER['PHP_SELF'] or !empty($_POST['captcha'])) {
                $Mensaje["mensaje"] = 'Hacking Attempt!!';
                $Mensaje["tipo"]    = 'error';
                $Mensaje["autoclose"] = false;
                $_SESSION['Mensaje'] = $Mensaje;
                redirect(URL.'/');
                die();
            }


            $data = $_POST['data'];

            $restore = $_SESSION['reset_pwd'];
            

            if (!empty($data['nuevaclave']) and $data['nuevaclave']==$data['re_clave']) {
                $data['clave']       = md5($data['nuevaclave']);
                $data['id']          = $restore['id'];

                unset($data['nuevaclave']);
                unset($data['re_clave']);

                $ok = $db->Replace('usuarios', $data,'id', $autoquote = true); 
                unset($_SESSION['reset_pwd']);

                if ($ok) {  
                    $Mensaje["mensaje"] = 'La contraseña se cambió correctamente!';
                    $Mensaje["tipo"]    = 'success';
                    $Mensaje["autoclose"] = false;
                    $_SESSION['Mensaje'] = $Mensaje;
                } else {
                    $Mensaje["mensaje"] = 'No se pudo cambiar la contraseña!!';
                    $Mensaje["tipo"]    = 'error';
                    $Mensaje["autoclose"] = false;
                    $_SESSION['Mensaje'] = $Mensaje;
                }
                redirect(URL.'/');
                die();

            }
        }
        


    include_once('./inc/inc_publicidad.php');

    include_once('./html/header.html.php');        



    if (empty($data)){
        $Mensaje["mensaje"]   = 'ERROR Enlace mal formado!!';
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL.'/');
        die();
    }


    $data     = base64_decode($data);
    $recupero = unserialize($data);

    if (empty($recupero)){
        $Mensaje["mensaje"]   = 'ERROR Enlace mal formado!!';
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL.'/');
        die();
    }

    if ( $recupero['dia']!=date(Ymd) ){
        $Mensaje["mensaje"]   = 'ERROR Clave de recuperación vencida!!';
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL.'/');
        die();
    }


    $rs = $db->SelectLimit("select * from usuarios where id='{$recupero['id']}' and email='{$recupero['email']}'",1);
    $Usuario = $rs->FetchRow();

    $_SESSION['reset_pwd']['id']    = $Usuario['id']; 
    $_SESSION['reset_pwd']['email'] = $Usuario['email'];

    if ($Usuario){
        
        include_once('./html/resetear_password.html.php');

    } else {
        
        $Mensaje["mensaje"]   = 'ERROR La Clave de recuperación no pertenece a ningún usuario activo!!';
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL.'/');
        die();


    }        

    include_once('./html/footer.html.php');
?>