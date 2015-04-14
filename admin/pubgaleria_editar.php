<?php

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$cond 	= "select * from galerias where id=".$id;
	$rs 	= $db->SelectLimit($cond, 1);
	$Nota	= $rs->FetchRow();

    $nombre[1]	      = $Nota['nombre1'];
    $nombre[2]	      = $Nota['nombre2'];
    $nombre[3]	      = $Nota['nombre3'];
    $nombre[4]	      = $Nota['nombre4'];
    $nombre[5]	      = $Nota['nombre5'];                
	$abstract[1]	  = $Nota['abstract1'];
	$abstract[2]	  = $Nota['abstract2'];
	$abstract[3]	  = $Nota['abstract3'];
	$abstract[4]	  = $Nota['abstract4'];
	$abstract[5]	  = $Nota['abstract5'];                
	$descripcion[1]	  = $Nota['descripcion1'];
	$descripcion[2]	  = $Nota['descripcion2'];
	$descripcion[3]	  = $Nota['descripcion3'];
	$descripcion[4]	  = $Nota['descripcion4'];
	$descripcion[5]	  = $Nota['descripcion5'];                
    $keywords[1]	  = $Nota['keywords1'];
    $keywords[2]	  = $Nota['keywords2'];
    $keywords[3]	  = $Nota['keywords3'];
    $keywords[4]	  = $Nota['keywords4'];
    $keywords[5]	  = $Nota['keywords5'];                
    $url_amigable[1]  = $Nota['urlamigable1'];
    $url_amigable[2]  = $Nota['urlamigable2'];
    $url_amigable[3]  = $Nota['urlamigable3'];
    $url_amigable[4]  = $Nota['urlamigable4'];
    $url_amigable[5]  = $Nota['urlamigable5'];                
    $thumbs	          = $Nota['thumbs'];    
    $ubicacion        = $Nota['ubicacion'];
    $mapa	          = $Nota['mapa'];        



?>
<script type="text/javascript">
function arma_url_friendly(cual){
    var titulo = document.getElementById('xnombre'+cual).value;
    url_amigable = titulo.toLowerCase();
    url_amigable = url_amigable.replace(/[ ]/gi,'-');
    url_amigable = url_amigable.replace(/[á]/gi,'a');
    url_amigable = url_amigable.replace(/[é]/gi,'e');
    url_amigable = url_amigable.replace(/[í]/gi,'i');
    url_amigable = url_amigable.replace(/[ó]/gi,'o');
    url_amigable = url_amigable.replace(/[ú]/gi,'u');
    url_amigable = url_amigable.replace(/[ñ]/gi,'n');
    url_amigable = url_amigable.replace(/[/*()|&%$#"']/gi,'-');                    

    document.getElementById("url_amigable"+cual).value = url_amigable;
    document.getElementById("keywords"+cual).value = titulo;
    
}

function muestra(cual){

    <?php for($i=1; $i<=5; $i++) { ?>
        <?php if( !empty($Idiomas[($i-1)]['name']) ) { ?>
        document.getElementById('idioma<?=$i;?>').style.display = 'none';
        <?php } ?>
    <?php } ?>        
    document.getElementById(cual).style.display = 'block';
    
}

</script>

<link href="<?=RUTA;?>/css/texto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/sitio/admin/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/sitio/admin/js/ckfinder/ckfinder.js"></script>



<center>
<form name='form1' action='pubgaleria.php?accion=grabar&id=$id' method='post'>
<table width='1000' cellpadding='3' cellspacing='3' border='0' style="border-width:1px; border-style:solid; border-color:#000000;background-color:white;">
	<tr bgcolor='#0271E3' >
		<td colspan='2' align='center'>
			<span style="color:#FFFFFF; font-weight:bold; font-size:14px;">Agregar / Modificar una Galeria</span></td>
	</tr>
    <tr><td colspan="2">
    <div id='menu_idiomas'>
        <ul>
            <li><a href="#" onclick="muestra('idioma1');"><img src='<?=URL.$Idiomas[0]['flag'];?>' border='0' /> <?=$Idiomas[0]['name'];?></a></li>
            <? if( !empty($Idiomas[1]['name'])) {echo "<li><a href='#' onclick=\"muestra('idioma2');\"><img src='".URL.$Idiomas[1]['flag']."' border='0' > ".$Idiomas[1]['name']."</a></li>";} ?>
            <? if( !empty($Idiomas[2]['name'])) {echo "<li><a href='#' onclick=\"muestra('idioma3');\"><img src='".URL.$Idiomas[2]['flag']."' border='0' > ".$Idiomas[2]['name']."</a></li>";} ?>
            <? if( !empty($Idiomas[3]['name'])) {echo "<li><a href='#' onclick=\"muestra('idioma4');\"><img src='".URL.$Idiomas[3]['flag']."' border='0' > ".$Idiomas[3]['name']."</a></li>";} ?>
            <? if( !empty($Idiomas[4]['name'])) {echo "<li><a href='#' onclick=\"muestra('idioma5');\"><img src='".URL.$Idiomas[4]['flag']."' border='0' > ".$Idiomas[4]['name']."</a></li>";} ?>                                    
        </ul>
    </div>
    </td></tr>
	<tr><td colspan='2'>
    <?php for($i=1; $i<=5; $i++) { ?>
        <?php if( !empty($Idiomas[($i-1)]['name']) ) { ?>
        <?php if($i==1) { $display='block';} else {$display='none';} ?>
		<div id="idioma<?=$i;?>" style="display:<?=$display;?>; "><img src='<?=URL.$Idiomas[($i-1)]['flag'];?>' border='0' />  <strong><?=$Idiomas[($i-1)]['name'];?></strong>
        <table width='100%'>
			<tr >
				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Nombre:</span></td>
                <td align='left'><input type='text' name='nombre[<?=$i;?>]' id="xnombre<?=$i;?>" value='<?=$nombre[$i];?>' size='90' maxlength='255' onblur="arma_url_friendly('<?=$i;?>');"/></td>
			</tr>
			<tr >
				<td align='right' nowrap="nowrap"><span style="color:#000000; font-weight:bold; font-size:12px;\">URL Amigable:</span></td>
                <td align='left'><input type='text' id='url_amigable<?=$i;?>'  name='url_amigable[<?=$i;?>]' value='<?=$url_amigable[$i];?>' size='90' maxlength='255' /></td>
			</tr>

			<tr >
				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Keywords:</span></td>
                <td align='left'><input type='text' name='keywords[<?=$i;?>]' id='keywords<?=$i;?>' value='<?=$keywords[$i];?>' size='90' maxlength='255' /></td>
			</tr>

			<tr >
				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Resumen:</span></td>
				<td align='left'>
                    <textarea name='abstract[<?=$i;?>]' id='abstract<?=$i;?>' style="width:1000px; height:300px;"><?=$abstract[$i];?></textarea>
            		<script type="text/javascript">
                       var editor = CKEDITOR.replace( 'abstract<?=$i;?>' );
            	       CKFinder.setupCKEditor( editor, '<?=URL;?>/admin/js/ckfinder/' ) ;
            		</script>
                
                </td>
			</tr>

			<tr >
				<td align='right' valign="top"><span style="color:#000000; font-weight:bold; font-size:12px;\">Descripcion:</span></td>
				<td align='left'>
                    <textarea name='descripcion[<?=$i;?>]' id='descripcion<?=$i;?>' style="width:1000px; height:600px;"><?=$descripcion[$i];?></textarea>
            		<script type="text/javascript">
                       var editor = CKEDITOR.replace( 'descripcion<?=$i;?>' );
            	       CKFinder.setupCKEditor( editor, '<?=URL;?>/admin/js/ckfinder/' ) ;
            		</script>
                
                </td>
			</tr>
        </table>    
        </div>
        <?php } ?>
    
    <?php } ?>

	</td></tr>

    <tr >
	   <td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Miniatura:</span></td>
       <td align='left'>
            <input type='text' name='thumbs' id='thumbs' value='<?=$thumbs;?>' size='90' maxlength='255' />
            <small>Imagen que se mostrará en la portada. Ancho:500px Alto:265px</small>
       
       </td>
	</tr>

	<tr >
		<td align='right'></td>
		<td align='center'>
			<input type='hidden' name='id' value='<?=$id;?>' />
			<input type='submit' name='submit' value='<< Guardar los cambios >>'/>
		</td>
	</tr>
</table>
</form>
</center>