<?php
function xml_parser($url='',$utf8=false) {
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
         
        
        // mostramos la estructura
        //echo "<pre>".nl2br(print_r($xml, true))."</pre>"; 
        $x = 0;
        $feed = array();
        foreach ($xml->channel->item as $mensaje) {
            $fecha = (string) $mensaje->pubDate; 
            $xfecha = (string) $mensaje->pubDate; 
            $j = explode(',',$fecha);
            $z = trim($j[1]);
            $y = substr($z,0,11);
            $j = explode(' ',$y);
            $j[1] = $meses[trim($j[1])];
            $fecha = $j[0].'-'.$j[1].'-'.$j[2];
            $feed[$x]['pubDate'] = $fecha;
            $feed[$x]['title']   = (string) $mensaje->title;
            $feed[$x]['link']    = (string) $mensaje->link;
            $feed[$x]['description'] = (string) $mensaje->description;
            $x++;    
        }
        
    } else {
        $feed=array();
    }
    return $feed;
}

// echo "<pre>"; print_r($feed); echo "</pre>";
?>