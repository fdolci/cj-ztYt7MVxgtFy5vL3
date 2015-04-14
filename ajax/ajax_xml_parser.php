<?php
     $mipath='../';
    include ('../inc/config.php');
    
    $url    = request('url','');
    $utf8   = request('utf8',false);
    $decode = request('decode',false);
    $limite = request('limite',20);


    if (!empty($url)) {
        //$url = "http://www.terapiaurbana.es/feed/";

        $meses['Jan'] = '01';
        $meses['Feb'] = '02';
        $meses['Mar'] = '03';
        $meses['Apr'] = '04';
        $meses['May'] = '05';
        $meses['Jun'] = '06';
        $meses['Jul'] = '07';
        $meses['Aug'] = '08';
        $meses['Sep'] = '09';
        $meses['Oct'] = '10';
        $meses['Nov'] = '11';
        $meses['Dec'] = '12';

        if($utf8==true){
            $rawxml = utf8_encode(file_get_contents($url)); // guardamos el XML como string    
        } else {
            $rawxml = file_get_contents($url); // guardamos el XML como string    
        }
        
        
        
        $xml = simplexml_load_string($rawxml,'SimpleXMLElement', LIBXML_NOCDATA); // cargamos el objeto

        header('Content-Type: text/html; charset=utf-8');          
        
        $feed = array();
        $i=1;
        foreach ($xml->channel->item as $mensaje) {
            
            //---- Cambio el formato de la fecha
            $fecha  = (string) $mensaje->pubDate; 
            $j      = explode(',',$fecha);
            $z      = trim($j[1]);
            $y      = substr($z,0,11);
            $j      = explode(' ',$y);
            $j[1]   = $meses[trim($j[1])];
            $fecha  = $j[0].'-'.$j[1].'-'.$j[2];
            //------------------------------------

            $title       = (string) $mensaje->title;
            $link        = (string) $mensaje->link;
            $description = (string) $mensaje->description;

            $title = limpia($title);
            $description = limpia($description);

            

            
            if( $decode == true ){
                $title       = utf8_decode($title);
                $description = utf8_decode($description);
            }

?>
            <h2><span class='pubDate'><?php echo $fecha;?></span> 
                <a href='<?php echo $link;?>' rel='nofollow' target='_blank' title='Ampliar informacion'><?php echo $title;?></a></h2>
            <p><?php echo $description;?></p>
<?php 
            
            if($limite==$i){
                break;
            } else {
                $i++;
            }


        }

    } else {
        echo "NOO";
    }
    die();


    function limpia($texto) {
        $n_texto=str_replace("á","&aacute;",$texto);
        $n_texto=str_replace("é","&eacute;",$n_texto);
        $n_texto=str_replace("í","&iacute;",$n_texto);
        $n_texto=str_replace("ó","&oacute;",$n_texto);
        $n_texto=str_replace("ú","&uacute;",$n_texto);
        $n_texto=str_replace("ñ","&ntilde;",$n_texto);
        $n_texto=str_replace("Á","&Aacute;",$n_texto);
        $n_texto=str_replace("É","&Eacute;",$n_texto);
        $n_texto=str_replace("Í","&Iacute;",$n_texto);
        $n_texto=str_replace("Ó","&Oacute;",$n_texto);
        $n_texto=str_replace("Ú","&Uacute;",$n_texto);
        $n_texto=str_replace("Ñ","&Ntilde;",$n_texto);
        $n_texto=str_replace("ª","&ordf;",$n_texto);
        $n_texto=str_replace("º","&ordm;",$n_texto);
        $n_texto=str_replace("º","&ordm;",$n_texto);
        
        $n_texto=str_replace("–","-",$n_texto); 
        $n_texto=str_replace(". ",". ",$n_texto); 
        
        $n_texto=str_replace("'","",$n_texto);
        $n_texto=str_replace('"',"",$n_texto);
        $n_texto=str_replace("/","",$n_texto);
        $n_texto=str_replace("\\","",$n_texto);
        return $n_texto;
    }


?>