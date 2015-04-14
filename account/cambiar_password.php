<?php
    $mipath='../';
    include ('../inc/config.php'); 

    if(!esta_login() ) { 
        $Mensaje["mensaje"] = $Traducciones['login_requerido'];
        $Mensaje["tipo"]    = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje'] = $Mensaje;
        $_SESSION['user_id']  = '';
        redirect(URL);   die();  
    }

    $id = $_SESSION['user_id'];


    if($_POST['submit']){

        $email = request('email','');
        $clave_nueva  = md5(trim($_POST['clave_nueva']));
        $reingreso    = md5(trim($_POST['reingreso']));


        if ($clave_nueva != $reingreso){
                $Mensaje["mensaje"] = 'Error las contraseñas no concuerdan. Intente nuevamente.!';
                $Mensaje["tipo"]    = 'error';
                $Mensaje["autoclose"] = true;
                $_SESSION['Mensaje'] = $Mensaje;                

        } else {

            //----------------- Existe ese email para otro usuario?
            $sql = "select * from usuarios where email='$email' and id!='$id'";
            $rs  = $db->SelectLimit($sql,1);
            $Existe = $rs->FetchRow();
            if(!$Existe and !empty($email) ){

                $sql = "select * from usuarios where id='$id'";
                $rs  = $db->SelectLimit($sql,1);
                $Existe = $rs->FetchRow();

                if($Existe){

                    $Existe['clave'] = $clave_nueva;
                    $Existe['email'] = $email;
                    $ok = $db->Replace('usuarios', $Existe,'id', $autoquote = true); 
                    if($ok){
                        $Mensaje["mensaje"] = 'La Contraseña se modifico correctamente!';
                        $Mensaje["tipo"]    = 'success';
                        $Mensaje["autoclose"] = true;
                        $_SESSION['Mensaje'] = $Mensaje;                
                    } else {

                        $Mensaje["mensaje"] = 'Error no se pudo cambiar la contraseña. Intente nuevamente.!';
                        $Mensaje["tipo"]    = 'error';
                        $Mensaje["autoclose"] = true;
                        $_SESSION['Mensaje'] = $Mensaje;                
                    }

                }

            } else {
                $Mensaje["mensaje"] = 'El email ingresado pertenece a otro usuario!';
                $Mensaje["tipo"]    = 'error';
                $Mensaje["autoclose"] = true;
                $_SESSION['Mensaje'] = $Mensaje;                
            }


        }


    }

    $sql = "select * from usuarios where id='$id'";
    $rs  = $db->SelectLimit($sql,1);
    $data = $rs->FetchRow();

    
    $cat_id = 0;
    $mostrar_en_home = 0;
    $menu_cta = 'cambiar_password';
//    include_once(ROOT.'/inc/inc_publicidad.php');

    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/account/cambiar_password.html.php');

    include_once(ROOT.'/html/footer.html.php');
    die();

?>