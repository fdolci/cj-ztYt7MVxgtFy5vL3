<?php
    $data = $_POST['data'];

    $ok = $db->Replace('categorias', $data,'id', $autoquote = true); 

	if ($ok) { 
        $_SESSION['Msg'] = 'La categoria se guardo correctamente.';
	} else { 
        $_SESSION['Msg'] = "<hr>".'ERROR!! No se pudo guardar la publicacion.';	
    }
	redirect('categorias.php');
	die();
?>