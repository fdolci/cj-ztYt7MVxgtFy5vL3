<?php
    if(empty($ruta[1]) or !isset($ruta[1])) {

        $cat_id = 0;
        $mostrar_en_home = 1;
        include_once('./inc/inc_publicidad.php');
        $mTitle       = 'Canales RSS de '.URL;
        include_once('./html/header.html.php');
        include_once('./html/canales_rss.html.php');
        include_once('./html/footer.html.php');
        die();
    } else {
        $cual = $ruta[1];
    }


    $fecha = date("Y-m-d H:i:s");
    $url=URL;
    $NombreEmpresa = $DatosEmpresa['nombre_empresa'];
    $email         = $DatosEmpresa['email'];
//< ?xml version="1.0" encoding="iso-8859-1"? >
//< rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" >

    if (!isset($idioma_elegido)) { $idioma_elegido = 1;}
    if (!isset($idioma_default)) { $idioma_default = 1;}    
	//----- Busco la categorias


    if ($cual=='blog'){

        $cond    = "select * from publicaciones where categoria_id='3' and activo=1 order by fecha DESC";
        $rs         = $db->SelectLimit($cond,40);
        $Pub  = $rs->GetRows();
        $Publicaciones = array();
        foreach($Pub as $valor) {
            $x = array();
            if ( empty($valor['thumbs1'] )   ) { 
                $x['logo']   = URL."/img/logo.png";   
            } else { $x['logo'] = $valor['thumbs1']; }

            $x['href'] = URL."/blog/".$valor['urlamigable1'].".html";
            $x['modificado'] = $valor['modificado'];
            $x['resumen'] = $valor['descripcion1'];
            $x['titulo'] = $valor['titulo1'];

            $Publicaciones[] = $x;
        }


    } elseif($cual=='new'){
        $cond       = "select productos.*,familias.nombre1 as fam_nombre, familias.urlamigable1 as fam_url
                     from productos 
                     left join familias on productos.familia_id=familias.id
                     where productos.activo=1 and familia_id > 1 order by productos.id DESC";
        $rs         = $db->Execute($cond);
        $Publicaciones  = $rs->GetRows();
        foreach($Publicaciones as $clave => $valor) {
            if ( empty($valor['logo'] )   ) { 
                $Publicaciones[$clave]['logo']   = URL."/img/logo.png";   
            }
            $Publicaciones[$clave]['href'] = URL."/".$valor['fam_url']."/".$valor['urlamigable'].".html";
        }

    } else {
        $Familia = ObtieneFamiliaPorURL("$cual");
        $familia_id = $Familia['id'];
        $cond       = "select productos.*,familias.nombre1 as fam_nombre, familias.urlamigable1 as fam_url
                     from productos 
                     left join familias on productos.familia_id=familias.id
                     where productos.activo=1 and familia_id ='$familia_id' order by productos.id DESC";
        $rs         = $db->Execute($cond);
        $Publicaciones  = $rs->GetRows();
        foreach($Publicaciones as $clave => $valor) {
            if ( empty($valor['logo'] )   ) { 
                $Publicaciones[$clave]['logo']   = URL."/img/logo.png";   
            }
            $Publicaciones[$clave]['href'] = URL."/".$valor['fam_url']."/".$valor['urlamigable'].".html";
        }

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
    header('Content-Type: text/xml; charset=utf-8'); 



echo <<<INICIO
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
    <title>Anunciantes de: $url</title>
	<atom:link href="$url/rss" rel="self" type="application/rss+xml" />
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
        if($pub['modificado']>0) {   
            $fecha = $pub['modificado'];
        } elseif ($pub['fecha']>0) {
            $fecha = $pub['fecha'];
        } else {
            $fecha = time();
        }
            $pubDate = date('D, d M Y H:i:s', $fecha);
    		$img = "<img src='".$pub['logo']."' width='150'>";
    		$desc = trim($pub['resumen']);
            $desc = $img." ".$desc;
    		$titulo = strip_tags($pub['titulo']);
?>            
    		<item>
    		    <title><![CDATA[<?php echo $titulo;?>]]></title>
    		    <link><?php echo $pub['href'];?></link>
                <image>
                    <url><?php echo $pub['logo'];?></url>
                    <title><![CDATA[<?php echo $titulo;?>]]></title>
                    <link><?php echo $pub['href'];?></link>
                </image>            
    		    <description><![CDATA[<?php echo $pub['resumen'];?>]]></description>
    		    <guid><?php echo $pub['href'];?></guid>
                <pubDate><?php echo $pubDate;?></pubDate>
    		</item>
<?php     

	}
?>
    </channel></rss>
<?php
    die();
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