<?php
	include_once("inc/config.php");


    $fecha = date("Y-m-d H:i:s");
    $url=URL;
    $NombreEmpresa = $DatosEmpresa['nombre_empresa'];
    $email         = $DatosEmpresa['email'];
//< ?xml version="1.0" encoding="iso-8859-1"? >
//< rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" >

    if (!isset($idioma_elegido)) { $idioma_elegido = 1;}
    if (!isset($idioma_default)) { $idioma_default = 1;}    
	//----- Busco la categorias
	$cond 	    = "select * from publicaciones where activo=1 and categoria_id > 1 order by modificado DESC";
	$rs 	    = $db->Execute($cond);
    $Publicaciones	= $rs->GetRows();

    foreach($Publicaciones as $clave => $valor) {
        if ( empty($valor['titulo'.$idioma_elegido])   ) { 
            $Publicaciones[$clave]['titulo']   = $valor['titulo'.$idioma_default];   
        } else { 
            $Publicaciones[$clave]['titulo']   = $valor['titulo'.$idioma_elegido];  
        }
        if ( empty($valor['thumbs'.$idioma_elegido])   ) { 
            $Publicaciones[$clave]['thumbs']   = $valor['thumbs'.$idioma_default];   
        } else { 
            $Publicaciones[$clave]['thumbs']   = $valor['thumbs'.$idioma_elegido];  
        }
        
        if ( empty($Publicaciones[$clave]['thumbs'] )   ) { 
            $Publicaciones[$clave]['thumbs']   = URL."/img/logo.png";   
        } else { 
            $Publicaciones[$clave]['thumbs']   = HOST.$Publicaciones[$clave]['thumbs'] ;  
        }

        $contenido = $valor['copete'.$idioma_elegido]." - ".$valor['contenido'.$idioma_elegido];
        $Publicaciones[$clave]['contenido']   = $contenido;

        if ( empty($valor['urlamigable'.$idioma_elegido])   ) { 
            $Publicaciones[$clave]['urlamigable']   = $valor['urlamigable'.$idioma_default];   
        } else { 
            $Publicaciones[$clave]['urlamigable']   = $valor['urlamigable'.$idioma_elegido];  
        }
        $Publicaciones[$clave]['titulo']    = htmlspecialchars_decode($Publicaciones[$clave]['titulo'],ENT_QUOTES);
        $Publicaciones[$clave]['contenido']    = stripslashes($Publicaciones[$clave]['contenido']);
        
        $categoria_id = $valor['categoria_id'];
        $categoria = busco_categoria_por_id($categoria_id);
        $Publicaciones[$clave]['categoria'] = $categoria;
        $Publicaciones[$clave]['href'] = URL."/".$categoria['urlamigable']."/".$Publicaciones[$clave]['urlamigable']."~".$Publicaciones[$clave]['id'];
    }
    
//pr($Publicaciones);
    $pubDate = gmdate('D, d M Y H:i:s', time());

    if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
    {
    	header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
    } else {
    	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
    }
    header ('Expires: $pubDate GMT');
    header ('Last-Modified: $pubDate GMT');
    header ('Content-Type: text/xml');



echo <<<INICIO
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
    <title>SiteMap de $url</title>
	<atom:link href="$url/rss_facebook.php" rel="self" type="application/rss+xml" />
    <pubDate>$pubDate</pubDate>
    <link>$url</link>
    <description>Ultimas publicaciones en $url </description>
    <image>
        <url>$url/img/logo.png</url>
        <title>$NombreEmpresa</title>
        <link>$url</link>
    </image>    
    <language>es-es</language>
	<copyright>$NombreEmpresa</copyright>
    <webMaster>FernandoDolci@gmail.com (Fernando Dolci)</webMaster>
	<generator>Fernando Dolci CMS</generator>\n

INICIO;


	foreach ($Publicaciones as $pub){

            $pubDate = date('D, d M Y H:i:s', $pub['modificado']);
    		$img = "<img src='".$pub['thumbs']."' width='150'>";
    		$desc = trim($pub['contenido']);
            $desc = $img." ".$desc;
    		$titulo = strip_tags($pub['titulo']);
    		echo "<item>\n";
    		echo "<title><![CDATA[$titulo]]></title>\n";
    		echo "<link>".$pub['href']."</link>\n";
    		echo "<description><![CDATA[$desc]]></description>\n";
    		echo "<guid>".$pub['href']."</guid>";
            echo "<pubDate>$pubDate</pubDate>";
    		echo "</item>\n";
            

	}

echo "</channel>\n</rss>";



function cambio_texto ($texto) {
	$n_texto=ereg_replace("&nbsp;"," ",$texto);
	$n_texto=ereg_replace("á","a",$n_texto);
	$n_texto=ereg_replace("é","e",$n_texto);
	$n_texto=ereg_replace("í","i",$n_texto);
	$n_texto=ereg_replace("ó","o",$n_texto);
	$n_texto=ereg_replace("ú","u",$n_texto);
	$n_texto=ereg_replace("Á","A",$n_texto);
	$n_texto=ereg_replace("É","E",$n_texto);
	$n_texto=ereg_replace("Í","I",$n_texto);
	$n_texto=ereg_replace("Ó","O",$n_texto);
	$n_texto=ereg_replace("Ú","U",$n_texto);
	$n_texto=ereg_replace("ñ","n",$n_texto);
	$n_texto=ereg_replace("Ñ","N",$n_texto);
	$n_texto=ereg_replace("¿","",$n_texto);

	return $n_texto;
}




?>