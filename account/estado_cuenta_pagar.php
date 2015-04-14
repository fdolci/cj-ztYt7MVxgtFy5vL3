<?php
    $mipath='../';
    include ('../inc/config.php'); 

    if(!esta_login()) { 
        $Mensaje["mensaje"] = $Traducciones['login_requerido'];
        $Mensaje["tipo"]    = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje'] = $Mensaje;
        $_SESSION['user_id']  = '';
        redirect(URL);   die();  
    }

    $id = $_SESSION['user_id'];

    $estado_id = request('estado_id',0);



    if($_POST['submit']){

        $data = $_POST;
        unset($data['submit']);
        $data['id'] = $id;

        $ok = $db->Replace('usuarios', $data,'id', $autoquote = true); 
        if($ok){
            $Mensaje["mensaje"] = 'Los datos se guardaron correctamente!';
            $Mensaje["tipo"]    = 'success';
            $Mensaje["autoclose"] = true;
            $_SESSION['Mensaje'] = $Mensaje;                
        } else {

            $Mensaje["mensaje"] = 'Error al guardar los datos. Intente nuevamente.!';
            $Mensaje["tipo"]    = 'error';
            $Mensaje["autoclose"] = true;
            $_SESSION['Mensaje'] = $Mensaje;                
        }

    }

    $cond   = "select pagos.*, pu.plan_usuarios, pu.cantidad_avisos, pu.renovacion, pu.importe
                from pagos
                left join planes_usuarios as pu on pu.id = pagos.plan_id 
                where user_id='$id' and pagos.id='$estado_id' ";
    $rs     = $db->SelectLimit($cond,1);
    $data   = $rs->FetchRow();

    
    $cat_id = 0;
    $mostrar_en_home = 1;
    $menu_cta = 'estado_cuenta';
    include_once(ROOT.'/inc/inc_publicidad.php');

    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/account/estado_cuenta_pagar.html.php');

    include_once(ROOT.'/html/footer.html.php');
    die();


/* 
Nombre de usuario de API: guiaentoas_api1.gmail.com
Contraseña de API:        EXH2JHHN7NP27SQ9
Firma:                    An4N6GJwFQ3kXOftChltkKaegXWHAcaMBGxav5V00zOLii-G2gbZrBRY
Fecha de solicitud:       6 mar 2013 12:49:39 PST
*/



?>