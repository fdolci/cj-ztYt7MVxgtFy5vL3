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



    $cond   = "select pagos.*, pu.plan_usuarios, pu.cantidad_avisos, pu.renovacion, pu.importe
                from pagos 
                left join planes_usuarios as pu on pu.id = pagos.plan_id 
                where user_id='$id' order by vencimiento desc";
    $rs     = $db->Execute($cond);
    $data   = $rs->GetRows();

    
    $cat_id = 0;
    $mostrar_en_home = 1;
    $menu_cta = 'estado_cuenta';
    include_once(ROOT.'/inc/inc_publicidad.php');

    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/account/estado_cuenta.html.php');

    include_once(ROOT.'/html/footer.html.php');
    die();

?>