<?php
/*
Lee la configuracion de RedesSociales y arma el array $RedesSociales
*/    


	$sql 	= "select * from setting where name='redes_sociales' order by orden ASC";
	$rs 	= $db->SelectLimit($sql,1);
	$rs	= $rs->FetchRow();
    
    if (!empty($rs['valor'])) {
        $rs['valor'] = unserialize(base64_decode($rs['valor']));

        foreach($rs['valor'] as $clave=>$contenido) {
            if (!empty($contenido['script'])) {
                $rs['valor'][$clave]['script'] = html_entity_decode($contenido['script']);
                $rs['valor'][$clave]['script'] = str_replace('\"','"',$rs['valor'][$clave]['script']);
                $rs['valor'][$clave]['script'] = str_replace("\'","'",$rs['valor'][$clave]['script']);
            } 
             
        }
        
    }

    $RedesSociales=$rs['valor'];

/* 
Estructura:
$RedesSociales[facebook] => Array(
                            [nombre] => Facebook
                            [username] => DolciFernando
                            [url] => http://www.facebook.com/dolcifernando
                            [logo] => http://dondeviajo.es/wp-content/uploads/2010/09/logo-facebook.png
                            [script] => script de conexion que provee cada red social para mostrar el contenido
                            }

Por ej. el enlace a mi pagina de facebook sera: $RedesSociales['facebook']['url'];

*/
    
?>