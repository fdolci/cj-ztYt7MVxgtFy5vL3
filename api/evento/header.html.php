<?php 
mb_http_output( "UTF-8" );
header( "Content-Type: text/html; charset=".mb_http_output());
?>
<!DOCTYPE html>
<html lang="<?php echo $MetaTags['language'];?>" xml:lang="<?php echo $MetaTags['language'];?>">
<head>
	<?php include(ROOT.'/api/evento/_meta_tags.html.php'); ?>
	
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<script type='text/javascript' src="<?php echo URL;?>/js/flexcroll/flexcroll.js"></script>

	<!-- Validation -->
	<script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/localization/messages_es.js"></script>

	<!-- BootStrap -->
	<link href="<?php echo URL;?>/js/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen"  >
	<script src="<?php echo URL;?>/js/bootstrap/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="<?php echo URL;?>/js/menupestanas/menupestanas.js"></script>	

	
	<link rel="stylesheet" href="<?php echo URL;?>/css/960.css"    type="text/css" media="screen" /> 
	<link rel="stylesheet" href="<?php echo URL;?>/api/evento/layout.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo URL;?>/css/menues.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo URL;?>/css/mi_bootstrap.css" type="text/css" media="screen" />


	
	<link rel="stylesheet" href="<?php echo URL;?>/css/muestra_producto.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />
	
	<link rel="stylesheet" href="<?php echo URL;?>/api/evento/cj.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo URL;?>/api/evento/menupestanas_h.css" type="text/css" media="screen" />
</head>

<body>

	<?php if(!empty($_SESSION['Mensaje'])){?>
		<div class="alert fade in <?php echo $_SESSION['Mensaje']['tipo'];?>">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php echo $_SESSION['Mensaje']['mensaje'];?>
		</div>
		<?php unset($_SESSION['Mensaje']);?>
	<?php } ?>
