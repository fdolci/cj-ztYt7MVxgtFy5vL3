<?php 
mb_http_output( "UTF-8" );
header( "Content-Type: text/html; charset=".mb_http_output());
?>
<!DOCTYPE html>
<html lang="<?php echo $MetaTags['language'];?>" xml:lang="<?php echo $MetaTags['language'];?>">
<head>
<?php include(ROOT.'/html/_meta_tags.html.php'); ?>

<?php include(ROOT.'/html/_javascript.html.php'); ?>

<?php include(ROOT.'/html/_css.html.php'); ?>


</head>

<body>
<div class="container_12 ">              
	<?php if(!empty($_SESSION['Mensaje'])){?>
		<div class="alert fade in <?php echo $_SESSION['Mensaje']['tipo'];?>">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php echo $_SESSION['Mensaje']['mensaje'];?>
		</div>
		<?php unset($_SESSION['Mensaje']);?>
	<?php } ?>

<div id='fondo_blanco' >
