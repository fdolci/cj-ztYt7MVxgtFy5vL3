<?php
	include ('./inc/config.php');

    if ( esta_login() ) { 
		
        $Mensaje["mensaje"]   = $Traducciones['ya_logueado'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL);
        die();
    }



    if ($_POST){

        $data = $_POST['data'];

        if (!empty($data['captcha'])) { 
            redirect(URL);
            die();
        }


        $email = trim($data['email']);
        $clave = trim($data['password']);

        if (!empty($email) and !empty($clave)) {

            $clave = md5($clave);

            $sql   = "select * from usuarios where email='$email' and clave='$clave' and activo='1'";
            $rs    = $db->SelectLimit($sql,1);
            $Usuario = $rs->FetchRow();

            if ($Usuario){

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
                $Mensaje["mensaje"] = "Hola $saludo, bienvenido nuevamente!";
                $Mensaje["tipo"]    = 'success';
                $Mensaje["autoclose"] = true;
                $_SESSION['Mensaje'] = $Mensaje;                
                redirect(URL.'/account/listar_anuncios.php');
                die();

            } else {
                $Mensaje["mensaje"] = "Usuario inexistente o inactivo. Por favor vuelva a intentarlo. Gracias!";
                $Mensaje["tipo"]    = 'error';
                $Mensaje["autoclose"] = true;
                $_SESSION['Mensaje'] = $Mensaje;                
            }

        } else {
            $Mensaje["mensaje"] = "Debe ingresar la dirección de Correo electrónico y la contraseña.";
            $Mensaje["tipo"]    = 'error';
            $Mensaje["autoclose"] = true;
            $_SESSION['Mensaje'] = $Mensaje;                
        }
    } // end if $_POST


    $cat_id = 0;
    $mostrar_en_home = 1;

    $breadcrumb[0]['href']  = URL;
    $breadcrumb[0]['title'] = $Traducciones['home'];
    $breadcrumb[1]['href']  = URL.'/login.php';
    $breadcrumb[1]['title'] = 'Acceso Usuarios';

    $route = 'login.php';
    $oculta_publicidad_top  = true;
    include_once(ROOT.'/inc/inc_publicidad.php');

    include_once(ROOT.'/html/header.html.php');        

    include_once(ROOT.'/html/login.html.php');        

    include_once(ROOT.'/html/footer.html.php');
  

?>