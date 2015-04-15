<?php
	include ('./inc/config.php');


    if ($_POST){

        $data = $_POST['data'];

        if (!empty($data['email']) and !empty($data['apellido'])  and !empty($data['nombre']) ) {

            $data['fecha'] = time();
            $ok = $db->AutoExecute('suscriptores',$data,'INSERT');
            if ($ok){
                $msg = "Gracias por suscribirse al Boletín de Noticias.";    
            } else {
                $msg = "Ud. ya estaba suscripto al Boletin!.";
            }
            
        } else {
                $msg = "Todos los datos son obligatorios.";
        }

    } // end if $_POST

    include_once(ROOT.'/html/suscribirse_al_boletin.html.php');        

    die();
?>