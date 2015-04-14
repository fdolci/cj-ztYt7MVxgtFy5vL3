<?php

    include ('../inc/config.php'); 

    if( !esta_login() ) { 
        $Mensaje["mensaje"]   = $Traducciones['login_requerido'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['user_id']    = '';
        redirect(URL);   die();  
    }

	
	$user_id = $_SESSION['user_id'];	
	$id      = request('id',0);
	if($id<1) { die('Hacking attempt!!'); }
	
	$letra   = request('letra','');

	if($_POST){
		$letra = $_POST['letra'];
		$data  = $_POST['data'];
		
		if($_POST['fecha_pago_dia']>0 and $_POST['fecha_pago_mes']>0 and $_POST['fecha_pago_ano']>0 ){
			$data['fecha_de_pago'] = mktime(0,0,0,$_POST['fecha_pago_mes'],$_POST['fecha_pago_dia'],$_POST['fecha_pago_ano']);
		} else {
			$data['fecha_de_pago'] = 0;
		}

		$ok = $db->Replace('inscripciones', $data,'id', $autoquote = true); 
		if ($ok) { 
            $_SESSION['Mensaje']["mensaje"] = "El Registro se guardó correctamente.";
            $_SESSION['Mensaje']["tipo"]    = 'alert-success';

		} else { 
            $_SESSION['Mensaje']["mensaje"] = "ERROR! No se pudo guardar el registro.";
            $_SESSION['Mensaje']["tipo"]    = 'alert-error';
		}

		redirect("inscriptos.php?producto_id={$data['producto_id']}&letra=$letra");
		die();
	}

	$sql = "select inscripciones.* from inscripciones where id='$id' and user_id='$user_id'";
	$rs  = $db->SelectLimit($sql,1);
	$data = $rs->FetchRow();
	
    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/account/inscripto_editar.html.php');
    include_once(ROOT.'/html/footer.html.php');

?>