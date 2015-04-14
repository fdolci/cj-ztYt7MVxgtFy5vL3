<?php 
    // Arma los meta tags a incluir en el sitio

    //--- Le asigno los valores dados por la categoria o publicacion
   
    foreach($MetaTags as $clave=>$valor) {

        if(strtolower($clave)=='title'       and isset($mTitle)       and !empty($mTitle))       { $MetaTags['title']    = $mTitle; }  
        if(strtolower($clave)=='robots'      and isset($mRobots)      and !empty($mRobots))      { $MetaTags['robots']   = $mRobots; }
        if(strtolower($clave)=='keywords'    and isset($mKeywords)    and !empty($mKeywords))    { $MetaTags['keywords'] = $mKeywords; }
        if(strtolower($clave)=='description' and isset($mDescription) and !empty($mDescription)) { 
        	$buscar  = array("'",'"', "“", "”",":","?","¿","&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;","&nbsp;");
        	$cambiar = array("" ,"" , "" , "" ,"" ,"" ,"" ,"a"       ,"e"       ,"i"       ,"o"       ,"u"       ,'n', ' ');
        	$x = str_replace($buscar, $cambiar, $mDescription);

            $x = trim( strip_tags($x) );
            $x = htmlspecialchars_decode($x);
            //$x = substr($x,0,300);
            $MetaTags['description'] = $x; 
        }
    }

	if (!empty($ubicacion)) {
	    echo "<title>".$MetaTags['title']." en $ubicacion ".PAIS."</title>\n";
	} else {
	    echo "<title>{$MetaTags['title']}</title>\n";
	}
        
    foreach($MetaTags as $clave=>$valor) { 
        if(strtolower($clave)!='title' and strtolower($clave)!='content-type') {
            echo "<meta name='$clave' content='$valor' >\n";    
        }
    }
?>

<?php $url_actual = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]; ?>

<meta property="fb:admins" content="<?php echo $Config['facebook_admin'];?>"/> <!-- 1093293311 --> 
<meta property="fb:app_id" content="<?php echo $Config['facebook_app_id'];?>"/>  <!-- 191680574307683 -->


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1&appId=<?php echo $Config['facebook_app_id'];?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php if(empty($mImagen)){ $mImagen=URL.'/logo_fb.jpg'; } ?>

<meta property="og:title" content="<?php echo $MetaTags['title'];?>" />
<meta property="og:url" content="<?php echo $url_actual;?>" />
<meta property="og:description" content="<?php echo $MetaTags['description'];?>" />
<meta property="og:locale" content="es_ES" />
<meta property="og:site_name" content="<?php echo $DatosEmpresa['nombre_empresa'];?> - <?php echo $DatosEmpresa['slogan'];?>" />
<meta property="og:image" content="<?php echo $mImagen;?>" />
<meta property="og:image:width" content="290" />
<meta property="og:image:height" content="290" />
<meta property="og:type" content="article" />
<meta property="article:published_time" content="<?php echo $mCreated;?>" />
<meta property="article:modified_time" content="<?php echo $mModified;?>" />
<meta property="article:section" content="<?php echo $mSection;?>" />
<meta property="article:author" content="<?php echo $DatosEmpresa['nombre_empresa'];?>" />
<meta property="article:tag" content="<?php echo $mSection;?>" />
<meta property="article:tag" content="<?php echo $MetaTags['keywords'];?>" />

<meta name="dcterms.identifier" scheme="dcterms.uri" content="<?php echo $url_actual;?>" />
<meta name="dc.title" content="<?php echo $MetaTags['title'];?>" />
<meta name="dc.creator" content="<?php echo $DatosEmpresa['nombre_empresa'];?>" />
<meta name="dc.date" scheme="dc.w3cdtf" content="<?php echo $mCreated;?>" />
<meta name="dc.description" content="<?php echo $MetaTags['description'];?>" />
<meta name="dc.subject" content="<?php echo $MetaTags['keywords'];?>" />
<meta name="dc.language" scheme="dcterms.rfc4646" content="es-ES" />
<meta name="dc.publisher" scheme="dcterms.uri" content="<?php echo $url_actual;?>" />
<meta name="dc.coverage" content="World" />
<meta name="dc.type" scheme="DCMIType" content="Text" />
<meta name="dc.format" scheme="dcterms.imt" content="text/html" />



<?php /* Google + */ ?>
<!-- Update your html tag to include the itemscope and itemtype attributes -->
<html itemscope itemtype="http://schema.org/Portal Regional">
<!-- Add the following three tags inside head -->
<meta itemprop="name" content="<?php echo $MetaTags['title'];?>"/>
<meta itemprop="description" content="<?php echo $MetaTags['description'];?>">
<meta itemprop="image" content="<?php echo $mImagen;?>"/>

<meta http-equiv="Content-Type" content="<?php echo $MetaTags['content-type'];?>" >
 
<meta name="Designer" content="FernandoDolci - http://www.FernandoDolci.com.ar" />    
<meta name="Author"   content="FernandoDolci - http://www.FernandoDolci.com.ar" />
<meta name="Generator" content="FernandoDolci - http://www.FernandoDolci.com.ar" />

<link rel="shortcut icon" href="<?php echo URL;?>/favicon.jpg" />
<link rel="image_src" href="<?php echo $mImagen;?>" />
