<?php
    $mipath='../';
	include ('../inc/config.php');

    $data = $_GET['data'];

    $subject   = "Suscripcion Boletin";

    $data['subject'] = $subject;
    $data['fecha']   = date("Y-m-d H:i:s");
    $data['id']      = 0;

    $ok = $db->AutoExecute('base_mailing', $data, 'INSERT');        


    if(!$ok) {
      $msg = mensaje_error('No se pudo suscribir al boletin');

    } else {
      $msg = mensaje_ok('Suscripcion correcta!');
    }

    echo $msg;
     
?>