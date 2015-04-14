<?php
    $data = $_POST['data'];

    $dia = request('dia',date("d",time()));
    $mes = request('mes',date("m",time()));
    $ano = request('ano',date("Y",time()));
    $fecha = mktime(0,0,0,$mes,$dia,$ano);    
    $data['fecha'] = $fecha;

    $busqueda = strip_tags(trim($data['titulo1']).' '.trim($data['titulo2']).' '.trim($data['titulo3']).' '.trim($data['titulo4']).' '.trim($data['titulo5']) );
    $busqueda.= strip_tags(trim($data['copete1']).' '.trim($data['copete2']).' '.trim($data['copete3']).' '.trim($data['copete4']).' '.trim($data['copete5']) );    
    $busqueda.= strip_tags(trim($data['contenido1']).' '.trim($data['contenido2']).' '.trim($data['contenido3']).' '.trim($data['contenido4']).' '.trim($data['contenido5']) );
    $busqueda.= strip_tags(trim($data['keywords1']).' '.trim($data['keywords2']).' '.trim($data['keywords3']).' '.trim($data['keywords4']).' '.trim($data['keywords5']) );        
    $data['busqueda'] = $busqueda;


  //  $data['categoria_id'] = request('categoria_id',1);

    $db->debug = false;

    $data['modificado'] = time();

    $ok = $db->Replace('publicaciones', $data,'id', $autoquote = true); 

    if ($ok) { 
        $_SESSION['Msg'] = 'La publicacion se guardo correctamente.';
        redirect('contenidos.php?categoria_id='.$data['categoria_id']);
        exit();
       
    } else { 
        $Pub    = $data;
        $fecha  = $data['fecha'];
        $_SESSION['Msg'] = 'ERROR!! No se pudo guardar la publicacion.'; 
    }
?>