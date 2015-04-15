<!DOCTYPE html>
<html lang="<?php echo $MetaTags['language'];?>" xml:lang="<?php echo $MetaTags['language'];?>">
<head>
<?php include('_meta_tags.html.php'); ?>

<?php include('_javascript.html.php'); ?>

	<link rel="stylesheet" href="<?php echo mURL;?>/html/m_layout.css" type="text/css" media="screen" />
</head>

<body >

	<table width='100%'>
		<tr>
			<td>
				<a href="<?php echo mURL;?>/" title="<?php echo strip_tags($DatosEmpresa['nombre_empresa'].': '.$DatosEmpresa['slogan']);?>">
					<img src='<?php echo URL;?>/img/logo.png' id='logo'>
				</a>
			</td>
			<td style='text-align:right;'>
				<h1>Rosario<br>Alojamientos</h1>
			</td>

		<tr>
			<td colspan='2'>
				<form action='listar.php' method='post' name='cambia_familia'>
					<?php  echo 'Categorias:'.$select_familia; ?>
				</form>
			</td>
		</tr>	

	</table>

