<?php 
mb_http_output( "UTF-8" );
header( "Content-Type: text/html; charset=".mb_http_output());
?>
<!DOCTYPE html>
<html lang="<?php echo $MetaTags['language'];?>" xml:lang="<?php echo $MetaTags['language'];?>">
<head>
<?php include('_meta_tags.html.php'); ?>

<?php include('_javascript.html.php'); ?>

<?php include('_css.html.php'); ?>

</head>

<body>
	
<?php /*

	if (isset($_SESSION['Mensaje']) and !empty($_SESSION['Mensaje']))	{
	echo jq_notificacion($_SESSION['Mensaje']["mensaje"],$_SESSION['Mensaje']["tipo"],$_SESSION['Mensaje']["autoclose"]);                
	unset($_SESSION['Mensaje']);
} */?>


	<?php //include(ROOT.'/html/inc_login_top.html.php');?>

	<div id='header' >

		<div class='container_12'>

			<div class='grid_5'>
<?php /*				<h1 ><?php echo $DatosEmpresa['slogan'];?></h1> */?>
				<a href="<?php echo URL;?>/" title="<?php echo strip_tags($DatosEmpresa['nombre_empresa'].': '.$DatosEmpresa['slogan']);?>">
					<img src='<?php echo URL;?>/img/logo.png' id='logo'>
				</a>
			</div>
			<div class='grid_7' id='barra_menu_superior'>
				
				<?php if($mostrar_en_home==1){?>
					<a href='#' id='btn_suscripcion' class='botones' style='margin-left:50px;'
					data-toggle="tooltip" data-placement="bottom" data-original-title='Suscribase y recibirá las últimas actividades'
					onclick="TINY.box.show({iframe:'<?php echo URL;?>/suscribirse_al_boletin.php',boxid:'frameless',width:700,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}})"
					>Suscribirse al Boletín</a>

					<a href="<?php echo URL;?>/account/registro.php" data-toggle="tooltip" 
						data-placement="bottom" data-original-title='Regístrese y publique su actividad' 
						id='agregar_empresa' class='botones'>Regístrese y publique su Actividad</a>

					<?php if(!esta_login()){?>
						<a id='btn_ingresar' href="<?php echo URL;?>/login.php" class='botones' 
							data-toggle="tooltip" data-placement="bottom" data-original-title='Acceso Usuarios'>Acceso Usuarios</a>
					<?php } else { ?>
						<a id='btn_ingresar' class='botones' href="<?php echo URL;?>/account/listar_anuncios.php" 
							data-toggle="tooltip" data-placement="bottom" data-original-title='Acceder a Mi Cuenta'>Mi Cuenta</a>
					<?php } ?>

					<div class='clearfix'></div>

					<a href="<?php echo URL;?>/certificados/"
						style='float:right; margin-top:20px; margin-right:6px;'
						title='Descargue su Certificado' 
						id='btn_certificado' class='btn btn-primary'>Descargue su Certificado</a>


					<script>
						$('.botones').tooltip();
					</script>
				<?php } else { echo "&nbsp;";} ?>

			</div>
			<div class='clear'></div>

			<div class='grid_12'>
			<?php //include(ROOT.'/html/inc_bloque_busqueda.html.php');?>
			</div>
		</div> <!-- container 12 -->	


	</div> <!-- div header -->

<div class="container_12 ">              

	<?php if(!empty($_SESSION['Mensaje'])){?>
			<?php 
				if($_SESSION['Mensaje']['tipo'] == 'error') {
					$tipo = 'alert-error';
				} elseif($_SESSION['Mensaje']['tipo'] == 'success') {
					$tipo = 'alert-success';
				} else {
					$tipo = $_SESSION['Mensaje']['tipo'];
				}
			?>	

		<div class="alert fade in <?php echo $tipo;?>">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php echo $_SESSION['Mensaje']['mensaje'];?>
		</div>
		<?php unset($_SESSION['Mensaje']);?>
	<?php } ?>



<div id='fondo_blanco' >

	<?php $resultado = strpos($url_actual, 'account'); ?>

	<?php if(!$resultado and !$oculta_todo){ ?>	
		<div class="grid_3" id='ciudades' style="text-align: right;font-size:12px; ">
			<?php include(ROOT.'/menu_familias.php');?>
			<!-- <script type="text/javascript" src="http://www.RosarioAlojamientos.com/api/api_02.js"></script>	-->
			<!-- <script type="text/javascript" src="http://www.RosarioGastronomia.com.ar/api/api_02.js"></script>	-->

			<center><br>
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- RA Interna IZq -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:200px;height:200px"
			     data-ad-client="ca-pub-2434718143283021"
			     data-ad-slot="5692617158"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>	
			</center>		

			<?php include(ROOT.'/inc/inc_publicidades_izq.php'); ?>	
			
		</div>

		<div class='grid_9'>
			<!--  BREADCRUMB -->
			<?php if ($breadcrumb and  !empty($route) ) { ?>
				<div id='breadcrumb' style="text-align: left;font-size:12px; ">
					<?php include(ROOT.'/html/breadcrumb.html.php');?>
				 </div>
			<?php } ?>		 

			<?php if(!$oculta_publicidad_top ){ include(ROOT.'/inc/inc_publicidades_top.php');} ?>	
			<?php $hay_grid_9 = 1;?>
			
	<?php } else { ?>

		<?php if ($breadcrumb and  !empty($route) ) { ?>
			<div class='grid_10'>
				<div id='breadcrumb' style="text-align: left;font-size:12px; ">
				 	<?php include('html/breadcrumb.html.php');?>
				 </div>
			</div>
			<div class='grid_2'>
				<button type="button" class="btn btn-primary" data-loading-text="Loading..." onclick="window.history.back();">Regresar al Menú</button>
			</div>

			<div class='clear'></div>

		<?php } ?>		 
		<?php $hay_grid_9 = 0;?>


	<? } //endif resultado?>
			
