<?php
    
    $habilita_idiomas = true;

    //-------trae los seteos de la tabla de configuracion
    $sql 	 = "select * from idiomas where activo=1 order by id ASC";

    $rs 	 = $db->Execute($sql);
    $Idiomas = $rs->GetRows();

    
    if($habilita_idiomas) {
        
        $cuantos_idiomas = count($Idiomas);
        $idioma_default = 1;
        foreach($Idiomas as $idio) {
            if($idio['defecto'] == 1){$idioma_default = $idio['id'];}
        }	        
        
        if (isset($_GET['idioma'])) {
            $idioma_elegido = request('idioma',$idioma_default);        
        } elseif (isset($_SESSION['idioma'])) {
            $idioma_elegido = $_SESSION['idioma'];
        } else {
            $idioma_elegido = $idioma_default;
        }
        
        $_SESSION['idioma'] = $idioma_elegido;
        $que_idioma = 'idioma'.$idioma_elegido;
        $idioma1 = 'idioma'.$idioma_default;
        
    } else {
        $idioma_default = 1;
        $idioma_elegido = 1;
        $que_idioma     = 'idioma'.$idioma_elegido;
        $idioma1        = 'idioma'.$idioma_default;
                

    }
    $_SESSION['idioma']         = $idioma_elegido;
    $_SESSION['idioma_default'] = $idioma_default;

    //-------trae los seteos de la tabla segun el idioma elegido
    $sql 	 = "select * from idiomas where id = '$idioma_elegido'";
    $rs 	 = $db->Execute($sql);
    $Idioma = $rs->FetchRow();


	$sql 	 = "select id,variable,$que_idioma as idioma, $idioma1 as idioma1 from archivo_traducciones";
	$rs 	 = $db->Execute($sql);
	$x = $rs->GetRows();

    $Traducciones = array();
    foreach($x as $z) { 
        $Traducciones[$z['variable']] = iif( !empty($z['idioma']), $z['idioma'], $z['idioma1']); 
    }

//    pr($Traducciones);

?>