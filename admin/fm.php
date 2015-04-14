<?php

    $item_menu[0] = 2;
    $item_menu[1] = 1;    
    $title = 'File Manager';
	if (!isset($_SESSION["admin"])) {
		function redirect($url) {
			echo "<script type=\"text/javascript\">";
			echo " var pagina = '".$url."';";
			echo " document.location.href=pagina;";
			echo "</script>";
		}
		redirect("login.php");	exit();
	}



	$mipath='../';
//	include($mipath.'inc/config.php');
    include('header.php');


	define('ARCHIVOS',  '../archivos/');
    define('ICONOS', 	'iconos'	);
	define('FM_URL', 	RUTA	);
echo "<h3>".FM_URL."</h3>";

	if ( isset($_GET['path'])) { $path = $_GET['path'];}
	elseif ( isset($_POST['path']) ) { $path = $_POST['path']; } else {$path=ARCHIVOS;}

	define('IMG_TINY', FM_URL.str_replace('..','',$path));

	//******************** ELIMINO EL ARCHIVO
	if ( isset($_GET['eliminar']) AND !empty($_GET['eliminar'])) {
		unlink($_GET['eliminar']);
	}
	//******************** ES UN ARCHIVO NUEVO
	if ( isset($_POST['nuevo']) AND !empty($_POST['nuevo'])) {
		if ($_FILES['archivo_nuevo']['size'] != 0){
			$nuevo 	= str_replace(" ","_",$_FILES['archivo_nuevo']['name']);
			if (! move_uploaded_file ($_FILES['archivo_nuevo']['tmp_name'], $path.$nuevo)) {
				echo "<hr>ERROR al subir el archivo<HR>";
			} else { $ArchivoRecienSubido = IMG_TINY.$nuevo; }

		}
	}

	//******************** CREO UNA CARPETA NUEVA Nombre de la Carpeta
	if ( isset($_POST['nueva_carpeta']) AND !empty($_POST['nueva_carpeta']) AND $_POST['nueva_carpeta']!='Nombre de la Carpeta' ) {
		$NuevaCarpeta = saca_espacios($_POST['nueva_carpeta']);
		$donde = $path.$NuevaCarpeta;
		if (mkdir($donde, 0755)) {$msg = 'msg_operacion_ok'; } else {$msg = 'msg_operacion_no'; }
	}

	//******************** ELIMINAR LA CARPETA ACTUAL
	if ( isset($_GET['eliminar_carpeta']) AND $_GET['eliminar_carpeta']==1) {
		$donde = $path;
		if (rmdir($donde)) {$msg = 'msg_operacion_ok'; $path=ARCHIVOS;} else {$msg = 'msg_operacion_no'; }

	}

	$ruta0=ARCHIVOS;

	// Busco las carpetas desde la ruta original hasta 10 anidamientos
	$carpetas2[] = $ruta0;

	if (is_dir($ruta0)) {
      if ($dh = opendir($ruta0)) {
         while (($file = readdir($dh)) !== false) {
            if (is_dir($ruta0 . $file) && $file!="." && $file!=".."){
               $ruta1 = $ruta0.$file."/";
			   $carpetas2[] = $ruta1;
				//****************** Ruta1
			   if ($dh1 = opendir($ruta1)) {
		         while (($file1 = readdir($dh1)) !== false) {

		            if (is_dir($ruta1 . $file1) && $file1!="." && $file1!=".."){
		               $ruta2 = $ruta1.$file1."/";
					   $carpetas2[] = $ruta2;

						//****************** Ruta2
					   if ($dh2 = opendir($ruta2)) {
				         while (($file2 = readdir($dh2)) !== false) {
				            if (is_dir($ruta2 . $file2) && $file2!="." && $file2!=".."){
				               $ruta3 = $ruta2.$file2."/";
							   $carpetas2[] = $ruta3;

								//****************** Ruta3
							   if ($dh3 = opendir($ruta3)) {
						         while (($file3 = readdir($dh3)) !== false) {
						            if (is_dir($ruta3 . $file3) && $file3!="." && $file3!=".."){
						               $ruta4 = $ruta3.$file3."/";
									   $carpetas2[] = $ruta4;

										//****************** Ruta4
									   if ($dh4 = opendir($ruta4)) {
								         while (($file4 = readdir($dh4)) !== false) {
								            if (is_dir($ruta4 . $file4) && $file4!="." && $file4!=".."){
								               $ruta5 = $ruta4.$file4."/";
											   $carpetas2[] = $ruta5;
								            }
								         } closedir($dh4); }

						            }
						         } closedir($dh3); }

				            }
				         }	closedir($dh2); }

		            }
		         }	closedir($dh1); }
		      }

            }
         } closedir($dh) ;

   }

   //$carpetas = array_merge($carpetas1, $carpetas2);
   $carpetas = $carpetas2;
//echo $ximg;
//   pr($carpetas);
	$i=0;
	foreach($carpetas as $cp){
		$partes = explode("/",$cp);
		$x = count($partes)-1;
		$Lista[$i][nombre]=$partes[$x-1];
		$Lista[$i][ruta]=$cp;
		if ($cp==$path ) {
			$yhref = "<b>".$partes[$x-1]."</b>";
			$tipo_carpeta="<img src='".IMG_ADMIN."/fm_carpeta_abierta.jpg' border=0 width=20 height=20 align=left>";
		} else {
			$yhref = "<a href='fm.php?path=".$cp."' class=texto>".$partes[$x-1]."</a>";
			$tipo_carpeta="<a href='fm.php?path=".$cp."' class=texto><img src='".IMG_ADMIN."/fm_carpeta.jpg' border=0 width=20 height=20 align=left></a>";
		}
		if (($x==1) OR ($cp==$ximg)){
			$Lista[$i][n0]="<tr><td width=20 align=left>".$tipo_carpeta."</td>
								<td width=180 colspan=4 align=left>".$yhref."</td></tr>";
		} elseif ($x ==2){
			$Lista[$i][n0]="<tr><td width=20 align=left><img src='".IMG_ADMIN."fm_mas.jpg' border=0 align=left width=20 height=20></td>
								<td width=20 align=left>".$tipo_carpeta."</td>
								<td width=160 colspan=3 align=left>".$yhref."</td></tr>";
		} elseif ($x ==3){
			$Lista[$i][n0]="<tr><td width=20 align=left><img src='".IMG_ADMIN."fm_vacio.jpg' border=0 align=left width=20 height=20></td>
								<td width=20 align=left><img src='".IMG_ADMIN."fm_mas.jpg' border=0 align=left width=20 height=20></td>
								<td width=20 align=left>".$tipo_carpeta."</td>
								<td width=140 colspan=2 align=left>".$yhref."</td></tr>";
		} elseif ($x ==4){
			$Lista[$i][n0]="<tr><td width=20 align=left><img src='".IMG_ADMIN."fm_vacio.jpg' border=0 align=left width=20 height=20></td>
								<td width=20 align=left><img src='".IMG_ADMIN."fm_vacio.jpg' border=0 align=left width=20 height=20></td>
								<td width=20 align=left><img src='".IMG_ADMIN."fm_mas.jpg' border=0 align=left width=20 height=20></td>
								<td width=20 align=left>".$tipo_carpeta."</td>
								<td width=120 colspan=1 align=left>".$yhref."</td></tr>";
		}

		$i++;
	}
//	$smarty->assign("Lista",$Lista);
	//pr($Lista);


	//abrimos el directorio

	$dir = opendir($path);
	//guardamos los archivos en un arreglo
	$img_total=0;
	$img_array = array();

	while ($elemento = readdir($dir)) {
			if (!is_dir($path.$elemento."/") AND $elemento!="." AND $elemento!="..")
			//if (strlen($elemento)>2)
			{


				$img_array[$img_total]['archivo']	= $elemento;
                $img_array[$img_total]['lower_archivo']	= strtolower($elemento);
				$xy = GetImageSize($path.$elemento);
				$img_array[$img_total]['xy']		= "<b>Ancho:</b>".$xy[0]."px. <b>Alto:</b>".$xy[1]."px.";
				$extension=explode('.',$elemento);
				$img_array[$img_total]['extension']	= end($extension);
				$img_array[$img_total]['size'] 		= number_format(filesize($path.$elemento)/1024, 2, ',', ' ')." Kb.";
				$fecha =  date ("F d Y H:i:s", filemtime($path.$elemento));
				$img_array[$img_total]['fecha'] 	= date("d-m-Y", filemtime($path.$elemento));
				$img_array[$img_total]['imagen'] 	= 0;
				switch (strtoupper($img_array[$img_total]['extension'])) {
    				case 'AI' : $img_array[$img_total]['icono'] = "iconos/ai.gif";  break;
    				case 'AVI': $img_array[$img_total]['icono'] = "iconos/avi.gif"; break;
    				case 'BMP': $img_array[$img_total]['icono'] = "iconos/bmp.gif"; $img_array[$img_total]['imagen'] =1; break;
    				case 'CS' : $img_array[$img_total]['icono'] = "iconos/cs.gif"; break;
    				case 'DLL': $img_array[$img_total]['icono'] = "iconos/dll.gif"; break;
    				case 'DOC': $img_array[$img_total]['icono'] = "iconos/doc.gif"; break;
    				case 'EXE': $img_array[$img_total]['icono'] = "iconos/exe.gif"; break;
    				case 'FLA': $img_array[$img_total]['icono'] = "iconos/fla.gif"; break;
    				case 'GIF': $img_array[$img_total]['icono'] = "iconos/gif.gif"; $img_array[$img_total]['imagen'] =1; break;
    				case 'HTM': $img_array[$img_total]['icono'] = "iconos/htm.gif"; break;
    				case 'HTML': $img_array[$img_total]['icono'] = "iconos/html.gif"; break;
    				case 'JPG': $img_array[$img_total]['icono']	 = "iconos/jpg.gif"; $img_array[$img_total]['imagen'] =1; break;
    				case 'JPEG': $img_array[$img_total]['icono'] = "iconos/jpg.gif"; $img_array[$img_total]['imagen'] =1; break;
    				case 'PNG': $img_array[$img_total]['icono']  = "iconos/jpg.gif"; $img_array[$img_total]['imagen'] =1; break;
    				case 'JS' : $img_array[$img_total]['icono'] = "iconos/js.gif"; break;
    				case 'MDB': $img_array[$img_total]['icono'] = "iconos/mdb.gif"; break;
    				case 'MP3': $img_array[$img_total]['icono'] = "iconos/mp3.gif"; break;
    				case 'WAV': $img_array[$img_total]['icono'] = "iconos/mp3.gif"; break;
    				case 'PDF': $img_array[$img_total]['icono'] = "iconos/pdf.gif"; break;
    				case 'PPT': $img_array[$img_total]['icono'] = "iconos/ppt.gif"; break;
    				case 'RDP': $img_array[$img_total]['icono'] = "iconos/rdp.gif"; break;
    				case 'SWF': $img_array[$img_total]['icono'] = "iconos/swf.gif"; break;
    				case 'SWT': $img_array[$img_total]['icono'] = "iconos/swt.gif"; break;
    				case 'TXT': $img_array[$img_total]['icono'] = "iconos/txt.gif"; break;
    				case 'VSD': $img_array[$img_total]['icono'] = "iconos/vsd.gif"; break;
    				case 'XLS': $img_array[$img_total]['icono'] = "iconos/xls.gif"; break;
    				case 'CSV': $img_array[$img_total]['icono'] = "iconos/xls.gif"; break;
    				case 'XML': $img_array[$img_total]['icono'] = "iconos/xml.gif"; break;
    				case 'ZIP': $img_array[$img_total]['icono'] = "iconos/zip.gif"; break;
    				case 'RAR': $img_array[$img_total]['icono'] = "iconos/zip.gif"; break;
    				default: $img_array[$img_total]['icono'] 	= "iconos/txt.gif"; break;
				}
			}
			$img_total++;
		}
		sort($img_array);
		$img_total=0;
        if (!empty($img_array)) {
            $array_ordenadito = ordenar_array($img_array, 'lower_archivo', SORT_ASC) or die('<br>ERROR!<br>');
            $img_array =$array_ordenadito;  
    		foreach($img_array as $iga){
    			$img_total++;
    		}
        } else {$img_total=0;}        



	closedir($dir);

	//------------------------------------------------------------Para poder mostrar los mensajes del sistema-------------------------------------------------------------------------
	//include_once("inc/mensajes.php");
	//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	$Files = $img_array;
	$Path = $path;

    
?>


<style type="text/css">
<!--
.body,div,h3,h4,h5,h6,img,p,input,ul,li,a,span{
	font-family: Arial, sans-serif;
	font-size: 10pt;
/*color: #666666;*/
	padding:0px;
	margin:0px;
	}
/*
h2{
	font-family: "Trebuchet MS",Arial, sans-serif;
	font-size: 14pt;
	color: #666666;
	padding:0px;
	margin:0px;
	font-weight: normal;
	}
*/
.fm {
   display:block;
   background-color:#f5f7f9;
   padding:5px;
   margin:5px;
   text-align: left;
   border-right: #a5a7aa solid 1px;
   border-bottom: #a5a7aa solid 1px;
}

.c2 {
	font-family:'Trebuchet MS', Courier, Fixed;
	font-size:12pt;
	margin:4px 4px 4px 0px;
	padding:20px 20px 20px 20px;
	color:#666666;
	border:1px dashed #061;
	min-height:40px;
	background: #F6F7FF ;
/* url('../img/iso_logo_100px.png') no-repeat bottom right */
	}

.texto, .texto a:link, .texto a:visited{
	padding-left:3px;
	color: #666666;
	padding-right:5px;
	font-family: "Trebuchet MS", Tahoma, Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: normal;
	margin-top: 8px;
	margin-bottom: 8px;
	text-decoration:none;
}
.texto:hover { text-decoration:none; color: #000000; }

a.delete:link, a.delete:visited {
	font-family:'Trebuchet MS',Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#FF9000;
	background-image: url(**{$img}**delete.gif);
	background-repeat:no-repeat;
	background-position:0 2px;
	font-weight: bold;
	padding: 0px 0px 0px 20px;
	margin: 0px 0px 0px 10px;
	}

div#msgflash {
	font-family:"Trebuchet MS",Arial, Helvetica, sans-serif;
	color: #CD9600;
	background-color: #FFF7D3;
	font-size: 13px;
	padding: 4px;
	margin: 6px 6px 6px 6px;
	font-weight: normal;
	border: 1px solid;
	width: 97%;
	text-align: center;
	float:left;
}
-->
</style>

	</head>
<body>
	<!-- ******************************* MENSAJES***********************************  -->
<?php if (!empty($xmsg)){ ?>
    <table width='100%'>
    	<tr><td align='center' width='100%'><div id="msgflash"><?=$xmsg;?></div></td></tr>
    </table>
<?php } ?>
<table width='100%' cellpadding='3' cellspacing='3' border='1'>
	<tr>
		<td width='200' align='left' valign='top'>
			<h3>Carpetas:</h3>
			<span class='texto'><small>Hasta 3 niveles.</small>
			<table width='200' cellpadding='0' cellspacing='0' border='0' class='texto'>
<?php
			foreach ($Lista as $item){
				echo $item[n0];
			}
?>
			</table>
			<hr />
			<h3>Crear nueva Carpeta:</h3>
			<span class='texto'><small>La nueva carpeta se crear&aacute; dentro de la carpeta actual.</small>
			<form action='fm.php' method='post'>
			<input type='text' name='nueva_carpeta' size='30' value='Nombre de la Carpeta' onclick="this.select();"/>
			<input type='hidden' name='path' value='<?=$Path;?>'/>
			<input type='submit' value='Crear Carpeta'/>
			</form>
			</span>

<?php if(empty($Files)) { ?>
				<br/><br/><hr/>
				<h3>Eliminar esta Carpeta:</h3>
				<span class='texto'><small>Para poder eliminar la carpeta, la misma debe estar vac&iacute;a.</small>
				<a href='fm.php?eliminar_carpeta=1&path=<?=$Path;?>' title='Eliminar Carpeta avtual'  class='delete'
				onclick="javascript:return confirm('Esta seguro de eliminar esta carpeta:\n\n <?=$Path;?>')" > Eliminar</a>
<?php } ?>

		</td>
		<td width='100%' align='left' valign='top'>
			<h2><?=$Path;?></h2>

			<form action='fm.php' method='post' enctype="multipart/form-data">
			<span class='texto'></b>Enviar nuevo archivo al servidor:</b>
			<small>(El mismo, se ubicar&aacute; en la carpeta arriba mencionada)</small><br/>
			<input type='file' name='archivo_nuevo' size='60' value='Utilice el botón Examinar, para buscar el archivo en su PC'/>
			<input type='hidden' name='path' value='<?=$Path;?>'/>
			<input type='hidden' name='nuevo' value='archivo_nuevo'/>
			<input type='submit' name='enviar' size='60' value='Enviar nuevo archivo al servidor'/>
			</form>
<?php	if( isset($ArchivoRecienSubido)) { ?>
			<br /><b>Archivo Reci&eacute;n Subido: </b><input type='text' name='xx' readonly='readonly' value='<?=$ArchivoRecienSubido;?>'
			onclick="this.select();" size='80'/>
<?php } ?>

			</span>
			<table width='100%'>
<?php		foreach($Files as $item) { ?>
				<tr>
					<td  width='50%'>

						<div  class='fm'>
						<table width='100%' cellpadding='2' cellspacing='2'>
						<tr><td width='50' valign='top'>
							<a href="<?=$Path.$item[archivo];?>" title='Ampliar Imagen'
								onclick="window.open('<?=$Path.$item[archivo];?>','','resizable=yes,dependent=yes,width=400,height=400,left='+(screen.availWidth/2-200)+',top='+(screen.availHeight/2-200)+'');return false;">
                            <?php if($item[imagen]==1){ ?>
								<img src="<?=$Path.$item[archivo];?>" border="0" width="60"  alt='Ampliar Imagen'/></a>
                            <?php } else { ?>
                            	<img src="<?=$item[icono];?>" border="0" width="30"  alt='Ampliar Imagen'/></a>
                            <?php } ?>
							</td>
							<td valign='top' align='left' width='100%'>
                                <b>Nombre:</b> <?=$item[archivo];?><br />
								<b>Fecha:</b> <?=$item[fecha];?>&nbsp;&nbsp;&nbsp;<b>Peso: </b><?=$item{size};?><br/>
								<?=$item[xy];?>
								<a href='fm.php?eliminar=<?=$Path.$item[archivo];?>&path=<?=$Path;?>' title='Eliminar Archivo'  class='delete'
								onclick="javascript:return confirm('Esta seguro de eliminar este archivo:\n\n <?=$Path.$item[archivo];?>?')" > Eliminar</a>
							</td>
						</tr>
						<tr> <td colspan='2'>
							<input type='text' name='xx' readonly='readonly' value='<?=IMG_TINY.$item[archivo];?>' onclick="this.select();" size='80'/>
							</td></tr>
						</table>
						</div>

					</td>
				</tr>
<?php 	   } //foreach ?>
			   </table>
		</td>
	</tr>
</table>
</body>
</html>