<?php
	$cond 		= "select * from galerias order by nombre1 ASC";
	$rs 		= $db->Execute($cond);
	$Noticias 	= $rs->GetRows();
?>

<script language="javascript">
function abrir(direccion, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
     var opciones = "fullscreen=" + pantallacompleta +
                 ",toolbar=" + herramientas +
                 ",location=" + direcciones +
                 ",status=" + estado +
                 ",menubar=" + barramenu +
                 ",scrollbars=" + barrascroll +
                 ",resizable=" + cambiatamano +
                 ",width=" + ancho +
                 ",height=" + alto +
                 ",left=" + izquierda +
                 ",top=" + arriba;
     var ventana = window.open(direccion,"venta",opciones,sustituir);
}

function muestra_foto(cual){
    var estado = document.getElementById('foto_'+cual).style.display;
    <?php foreach($Noticias as $not) { ?>
        document.getElementById('foto_<?=$not['id'];?>').style.display = 'none';
    <?php } ?>        
    if(estado == 'block') {
        document.getElementById('foto_'+cual).style.display = 'none';
    } else {
        document.getElementById('foto_'+cual).style.display = 'block';
        autoResizeFoto(cual);
    }
}


function autoResizeFoto(id){
    var newheight;
    var newwidth;
    document.getElementById('photo_frame_'+id).height= "400px";
    if(document.getElementById){
         newheight=document.getElementById('photo_frame_'+id).contentWindow.document .body.scrollHeight;
         newwidth=document.getElementById('photo_frame_'+id).contentWindow.document .body.scrollWidth;
    }
    document.getElementById('photo_frame_'+id).height= (newheight) + "px";
}

</script>
<?php

	if (!empty($Noticias)) { ?>
	<table width='800' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr>
			<td width='30' class="th">ID</td>
			<td width='140' class="th">Acciones</td>
			<td  class="th">Nombre</td>
            <td  class="th">URL Amigable</td>            
			</tr>
    <?php foreach($Noticias as $not) {
            if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
    ?>
			<tr  bgcolor="<?=$color;?>" >
				<td align='center'>	<?=$not[id];?> </td>
				<td align='center'>
   					<a href='<?=ADMIN;?>pubgaleria.php?accion=delete&id=<?=$not['id'];?>'
   						title='Eliminar esta Galeria'
   						onclick="return confirm('Est&aacute; seguro de eliminar esta Galeria?');">
   						<img src='<?=ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;

					<a href='<?=ADMIN;?>pubgaleria.php?accion=editar&id=<?=$not['id'];?>'
						title='Editar esta Galeria'>
						<img src='<?=ADMIN;?>img/edit.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;

				<?php if ($not['activo']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
					<a href='pubgaleria.php?accion=estado&id=<?=$not['id'];?>'
					title='Activar/Desactivar esta Galeria' >
					<img src='<?=ADMIN;?><?=$imagen;?>' border='0'/></a>

                    &nbsp;&nbsp;&nbsp;
                    <img src='<?=ADMIN;?>img/galeria.gif' border='0' title="Abrir Galeria de Imagenes" style="cursor:pointer;"
                        onclick="muestra_foto('<?=$not[id];?>');" />

                    &nbsp;&nbsp;&nbsp;
				</td>

				<td ><?=$not['nombre1'];?></td>
                <td ><?=$not['urlamigable1'];?></td>                
			</tr>
            
            <tr bgcolor="<?=$color;?>" style="height:1px;"><td colspan="4">
                <div id="foto_<?=$not['id'];?>" style="display:none;">
                    <iframe src="pubgaleria_acciones.php?galeria_id=<?=$not['id'];?>&color=<?=$color;?>" width='800' height='400' id="photo_frame_<?=$not['id'];?>"
                	onLoad="autoResizeFoto('<?=$not['id'];?>');"
                    style="border:0px; background-color:<?=$color;?>;"></iframe>
                </div>
            </td></tr>
<?php } //endforeach ?>
	</table>
<?php } else { ?>
	<span class='titulo'>No hay Galerias para mostrar</span>
<?php } ?>
