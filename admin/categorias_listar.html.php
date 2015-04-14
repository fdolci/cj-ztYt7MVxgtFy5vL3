<?php
	$cond 		= "select categorias.*, grupos.nombre 
                    from categorias left join grupos on categorias.grupo_id=grupos.id order by titulo1 ASC";
	$rs 		= $db->Execute($cond);
	$Noticias 	= $rs->GetRows();

	if (!empty($Noticias)) { ?>
	<table width='1000' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='30' class="th">ID</td>
			<td width='80' class="th">Acciones</td>
			<td width='60' class="th">Publicaciones</td>
			<td  class="th">T&iacute;tulo</td>
            <td  class="th">URL Amigable</td> 
            <td  class="th">Orden</td> 
            <td  class="th">Acceso</td> 
            <td  class="th" width="10">Eliminar</td>
			</tr>

		<?php $color=''; 
        
            foreach($Noticias as $not) {
		  
            if($not['id'] == 1) {
                if ($_SESSION['god'] == 1) { $muestra = 1; } else { $muestra = 0;}
            } else { $muestra = 1;}
            
            if ($muestra == 1) { 
    			$cat_id = $not['id'];
    			$cond 		= "select count(id) as cuantos from publicaciones where categoria_id='$cat_id' group by categoria_id";
    			$rs 		= $db->Execute($cond);
    			$xx 		= $rs->FetchRow();
    			
                $Cuantos    = $xx['cuantos'];
                
                if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}

    		?>
    
    			<tr bgcolor='<?php echo $color;?>' >
    				<td align='center'>	<?php echo $not['id'];?> </td>
    				<td align='left'>
                    <?php if($not['id']>1) { ?>
                        
                            <a href='<?php echo ADMIN;?>categorias.php?accion=editar&id=<?php echo $not['id'];?>'
            				    title='Editar esta categoria'>
            					<img src='<?php echo ADMIN;?>img/edit.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php if($not['id']>=10) { ?>
    				        <?php if ($not['activo']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
        					<a href='categorias.php?accion=estado&id=<?php echo $not['id'];?>&categoria_id=<?php echo $not['categoria_id'];?>'
        					title='Activar/Desactivar esta Categoria'>
        					<img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0'/></a>
                        <?php } ?>                            
                    <?php } ?>
    
    				</td>
    				<td align='center'>	<?php echo $Cuantos;?> </td>
    				<td ><?php echo $not['titulo1'];?></td>
                    <td ><?php echo $not['urlamigable1'];?></td>
                    <td>
                        <?php if($not['ordenar_publicaciones']==0){echo "Orden Descendente";}?>
                        <?php if($not['ordenar_publicaciones']==1){echo "Orden Ascendente";}?>
                        <?php if($not['ordenar_publicaciones']==2){echo "Fecha Descendente";}?>
                        <?php if($not['ordenar_publicaciones']==3){echo "Fecha Ascendente";}?>
                        <?php if($not['ordenar_publicaciones']==4){echo "Alfabetico Descendente";}?>
                        <?php if($not['ordenar_publicaciones']==5){echo "Alfabetico Ascendente";}?>

                    </td>
                    <td ><?php if (empty($not['nombre'])) { echo "Público"; } else { echo $not['nombre']; } ?></td>
                    <td align="right">
                    <?php if($not['id']>=10) { ?>
                        <?php if($Cuantos==0 ) { ?>
        					<a href='<?php echo ADMIN;?>categorias.php?accion=delete&id=<?php echo $not['id'];?>'
        						title='Eliminar esta categoria'
        						onclick="return confirm('Est&aacute; seguro de eliminar esta categoria?');">
        						<img src='<?php echo ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php } else { ?>
    						<img src='<?php echo ADMIN;?>img/del_inactivo.gif' border='0' title='Para eliminar esta categoria, la misma no debe contener publicaciones'/>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php } ?>
                    <?php } ?>
                    </td>                
    			</tr>
            <?php } ?>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Categorias para mostrar</span>
<?php } ?>
