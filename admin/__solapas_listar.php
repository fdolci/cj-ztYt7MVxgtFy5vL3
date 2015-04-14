<?php
	$cond 		= "select * from solapas where producto_id = '$producto_id' order by orden ASC";
	$rs 		= $db->Execute($cond);
	$Solapas 	= $rs->GetRows();
?>
    <br/>
    

<?php
	if (!empty($Solapas)) { ?>
	<center>
    <table width='600' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='30' class="th">ID</td>
			<td width='80' class="th">Acciones</td>
			<td  class="th">T&iacute;tulo</td>
            <td  class="th" width="10">Eliminar</td>
			</tr>

		<?php 
            $color = '';
            foreach($Solapas as $not) {
		  
                if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
    		?>
    
    			<tr bgcolor='<?=$color;?>' >
    				<td align='center'>	<?=$not['id'];?> </td>
    				<td align='center'>
                      
                            <a href='solapas_editar.php?producto_id=<?php echo $producto_id;?>&solapa_id=<?=$not['id'];?>'
                                title='Editar esta Solapa'>
            					<img src='<?=ADMIN;?>img/edit.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;

    				        <?php if ($not['activo']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
        					<a href='solapas_acciones.php?accion=estado&solapa_id=<?=$not['id'];?>'
        					title='Activar/Desactivar esta Solapa'>
        					<img src='<?=ADMIN;?><?=$imagen;?>' border='0'/></a>
                            

    
    				</td>
    				<td ><?=$not['titulo1'];?></td>
                    <td align="right">
        					<a href='<?=ADMIN;?>solapas_acciones.php?accion=eliminar&solapa_id=<?=$not['id'];?>&producto_id=<?=$not['producto_id'];?>'
        						title='Eliminar esta categoria'
        						onclick="return confirm('Est&aacute; seguro de eliminar esta solapa?');">
        						<img src='<?=ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>                
    			</tr>

		<?php } ?>

	</table>
    <br />
    </center>
<?php } else { ?>
	<br/><br />
    <span class='titulo'>No hay Solapas para mostrar</span>
<?php } ?>


