<?php
    if (!function_exists('request')) {
    	$mipath='../';
    	include ('../inc/config.php');
        $de_donde = '';
    }

mb_http_output( "UTF-8" );
header( "Content-Type: text/html; charset=".mb_http_output());


?>
<html>
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Administracion: <?=$title;?></title>


    
    <link href="<?php echo ADMIN;?>css_admin.css"  rel="stylesheet" type="text/css"/>
    <link href="<?php echo ADMIN;?>stylesheet.css" rel="stylesheet" type="text/css"  /> 
<?php /*    <link href="<?php echo RUTA;?>/css/texto.css"  rel="stylesheet" type="text/css" /> */?>


    <script type="text/javascript" src="<?php echo URL;?>/js/jquery.js"></script> 
    <link rel="stylesheet" href="<?php echo URL;?>/js/ui/css/ui-lightness/jquery-ui-1.8.21.custom.css" type="text/css" media="screen" />    
    <link rel="stylesheet" href="<?php echo URL;?>/js/ui/development-bundle/themes/base/jquery.ui.all.css">
    <link rel="stylesheet" href="<?php echo URL;?>/js/ui/development-bundle/demos.css">
    <style>
    .ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
    </style>    

    
    <script src="<?php echo URL;?>/js/ui/development-bundle/jquery-1.7.2.js"></script>
    <script type="text/javascript" src="<?php echo URL;?>/js/ui/js/jquery-ui-1.8.21.custom.min.js"></script>    

    
    <script type="text/javascript" src="<?php echo URL;?>/js/tinybox2/tinybox.js"></script>     
    <link rel="stylesheet" href="<?php echo URL;?>/js/tinybox2/tinybox.css" type="text/css" media="screen" />   

    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/localization/messages_es.js"></script>
    <style type="text/css">
        label { float: left; }
        label.error { float: none; color: red; padding-left:0px; vertical-align: top; display: block;font-size:12px;}
        p { clear: both; }
        em { font-weight: bold; padding-right: 1em; vertical-align: top; color:red;}
    </style>

    
</head>

<body >
<div id="header" style="background: url('<?php echo ADMIN;?>img/header.png') repeat-x top left #FFF;">
	<div class="div1"><span class="title1">Website</span>|<span class="title2">ADMINISTRADOR</span></div>
    <div style="float:right;margin-top:6px;"><a href="<?php echo ADMIN;?>logout.php" title='Salir del Administrador' ><img src="<?php echo ADMIN;?>img/salir.png" border="0"/></a></div>
</div>


<table bgcolor="#ffffff" border="0" cellpadding="3" cellspacing="3" width="960" style="float: left;">
  <tbody>
  <tr>
    <td width="180" valign="top">
    <?php if( $de_donde!='login' and isset($_SESSION["admin"])){ include('include_menu.php'); } ?>        
	</td>
    
    <td valign="top"> <!--Contenido cierra en el footer-->