<?php
    include_once('./inc/config.php');

    $data = request('data','');
    $data = unserialize(base64_decode($data));

    // Actualizo Visitas Unicas
    $xdata['id']            = 0;
    $xdata['producto_id']   = $data['producto_id'];
    $xdata['ip']            = $_SERVER['REMOTE_ADDR'];
    $xdata['fecha']         = date("Y-m-d");
    $xdata['hora']          = date("H:i");

    if(date("d") >= 1 and date("d") < 7) {
        $semana = '1er.Q';
    } elseif( date("d") >= 7 and date("d") < 14) {
        $semana = '2do.Q';
    } elseif( date("d") >= 14 and date("d") < 21) {
        $semana = '3er.Q';
    } else {
        $semana = '4to.Q';
    }

    $mes['01'] = 'Enero';
    $mes['02'] = 'Febrero';
    $mes['03'] = 'Marzo';
    $mes['04'] = 'Abril';
    $mes['05'] = 'Mayo';
    $mes['06'] = 'Junio';
    $mes['07'] = 'Julio';
    $mes['08'] = 'Agosto';
    $mes['09'] = 'Septiembre';
    $mes['10'] = 'Octubre';
    $mes['11'] = 'Noviembre';
    $mes['12'] = 'Diciembre';

    $xmes =  $mes[date('m')];
       

    $xdata['semana'] = "$semana $xmes";

    $ok = $db->Autoexecute('enlaces_externos', $xdata,'INSERT'); 

    $url = urldecode($data['url']);
    if(substr($url,0,7)!='http://') { $url='http://'.$url;}

    redirect($url);
    die();


?>