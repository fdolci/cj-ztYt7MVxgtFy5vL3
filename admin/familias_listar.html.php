<?php
//    $Familias = crearArbol(0);
//    $DependeDe = $Familias;

    $sql = "select * from familias where parent_id=0 order by nombre1 ASC";
    $rs = $db->Execute($sql);
    $Parent = $rs->GetRows();
    $parent_id = request('parent_id',0);

    $sql_parent = '<select name="parent_id" onChange="document.location.href=\'familias.php?parent_id=\'+this.value">';
    $sql_parent.= "<option value=0>Raiz 1er.Nivel</option>";
    foreach($Parent as $pt){
        if ($parent_id == $pt['id']) { $sel = "selected='selected'"; } else {$sel='';}
        $sql_parent.= "<option value='{$pt['id']}' $sel >{$pt['nombre1']}</option>";
    }
    $sql_parent.= "</select>";

?>    
<table width='1000'>
<tr>
    <td>Filtrar por: <?php echo $sql_parent;?>

    </td>
	<td align='right'>
<?php if ($accion=='listar' and ( $_SESSION['god'] == 1 or $Config['crea_familias'] == 'S') ) { ?> 
       <a href="familias.php?accion=editar&id=0&parent_id=<?php echo $parent_id;?>" class="boton1"  title='Crear nueva Familia de Productos' >Crear nueva Familia de Productos</a>
<?php } ?>    
	</td>
</tr>
</table>
<br />
<?php 
    $sql = "select * from familias where parent_id = '$parent_id' order by orden ASC";
    $rs  = $db->Execute($sql);
    $Familias = $rs->GetRows();
?>
<?php
	if (!empty($Familias)) { ?>
	<table width='1000' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='10' class="th"></td>
			<td width='80' class="th">Acciones</td>
			<td width='30' class="th" colspan="2">Orden</td>
            <td width='30' class="th" colspan="1">Precio</td>            
            <td  class="th" width='170' colspan="5">Nombre</td>
            <td  class="th">URL Amigable</td> 
            <td  class="th" width="10">Eliminar</td>
        </tr>
        
		<?php 
            $url = array();
            $color = '';
            foreach($Familias as $familia) {
                $url[$familia['nivel']] = $familia['urlamigable1'];
                
                if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
    		?>
    
    			<tr bgcolor='<?=$color;?>' >
    				<td align='center'>	
                        <?php echo $familia['id'];?> - 
                        <?php echo $familia['orden'];?>
                    </td>
                    
    				<td align='center'>
                        <a href='<?=ADMIN;?>familias.php?accion=editar&id=<?=$familia['id'];?>'
            			     title='Editar esta Familia'>
            			     <img src='<?=ADMIN;?>img/edit.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;

                        <?php if ($familia['activo'] == 1) { $imagen="img/activo.gif"; } else { $imagen='img/inactivo.gif'; } ?>
        				<a href='familias.php?accion=estado&id=<?=$familia['id'];?>&parent_id=<?php echo $parent_id;?>'
        				    title='Activar/Desactivar esta Familia'>
        					<img src='<?=ADMIN;?><?=$imagen;?>' border='0'/></a>
    				</td>
                    <!-- ORDEN -->
    				<td align='center' nowrap='nowrap'>
    					   <a href='familias_orden.php?sube=no&id=<?=$familia['id'];?>&parent_id=<?php echo $parent_id;?>' title='Bajar de Orden' >
    						<img src='<?=ADMIN;?>img/abajo.gif' border='0' /></a>
                    </td>
                    <td align='center' nowrap='nowrap'>
                            <a href='familias_orden.php?sube=si&id=<?=$familia['id'];?>&parent_id=<?php echo $parent_id;?>' title='Subir de Orden' >
    						<img src='<?=ADMIN;?>img/arriba.gif' border='0' /></a>
    				</td>

    				<td colspan="<?php echo $familia['nivel'];?>">
                        $<?php echo number_format($familia['precio'],2);?>.-
                    </td>
                    <td colspan="<?php echo (5-$familia['nivel']);?>">
                        <?php echo $familia['nombre1'];?>
                    </td>
                    
                    
                    <td ><?php echo $familia['urlamigable1']; ?></td>
                    
                    <!-- DELETE -->
                    <td align="right">
<?php
                        $id = $familia['id'];
                        $sql  = "select * from familias where parent_id = '$id'";
                    	$rs   = $db->Execute($sql);
                    	$z_delete 	= $rs->GetRows();
                        if (!$z_delete) { ?>
        					<a href='<?=ADMIN;?>familias.php?accion=delete&id=<?php echo $familia['id'];?>'
        						title='Eliminar esta categoria'
        						onclick="return confirm('Est&aacute; seguro de eliminar esta Familia?');">
        						<img src='<?=ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            
                        <?php } ?>                        
                    </td>                

    			</tr>
            <?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Categorias para mostrar</span>
<?php } ?>

<?php //pr($Familias);?>