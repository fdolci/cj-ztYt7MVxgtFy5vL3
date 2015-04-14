<?php
    $item_menu[0] = 5;
    $item_menu[1] = 6 ;
    $title = 'Productos';    
    include('header.php');

    if (!isset($_SESSION["admin"])) {redirect("login.php"); exit(); }


    $cond 		= "select productos.*
                    from productos 
                    order by productos.id DESC";
	$rs 		= $db->SelectLimit($cond,30);
	$Productos 	= $rs->GetRows();



?>
<h2>Ultimos Alojamientos Registrados</h2>

<?php if (!empty($Productos)) { ?>
	<table width='1000' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='30' class="th" >ID</td>
			<td width='100' class="th">Acciones</td>
            <td width='50' class="th">Dest.Home</td>
            <td width='50' class="th">Dest.Categ</td>
			<td width='60' class="th">Update</td>
			<td width='40%' class="th">Titulo</td>
			<td class="th" >URL Amigable</td>
            <td class="th" >Visitas</td>
            <td class="th" >Eliminar</td>
			</tr>

		<?php
            $color = ''; 
            foreach($Productos as $producto) { 
		       if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}  
        ?>
			<tr bgcolor='<?php echo $color;?>' >
				<td align='left' nowrap='nowrap'>
                        <?php echo $producto['id'];?>
                </td>
				<td align='center' nowrap="nowrap">
					<a href='aviso.php?id=<?php echo $producto['id'];?>'
						title='Editar esta publicaci&oacute;n'>
						<img src='<?php echo ADMIN;?>img/edit.gif' border='0'/></a>&nbsp;&nbsp;&nbsp;&nbsp;

                    <?php if ($producto['activo']==0){ $img='img/inactivo.gif'; } else { $img='img/activo.gif'; }?>
                    <img src='<?php echo $img;?>' id='img_activo_<?php echo $producto['id'];?>'>

				</td>
                <td align='center' nowrap='nowrap'>
                    <?php if ($producto['destacado_home']==0){ $img='img/inactivo.gif'; } else { $img='img/activo.gif'; }?>
                    <img src='<?php echo $img;?>'  id='img_destacado_home_<?php echo $producto['id'];?>'>
                </td>        
                <td align='center' nowrap='nowrap'>
                    <?php if ($producto['destacado_categoria']==0){ $img='img/inactivo.gif'; } else { $img='img/activo.gif'; }?>
                    <img src='<?php echo $img;?>' id='img_destacado_categoria_<?php echo $producto['id'];?>'>
                </td>        

				<td nowrap='nowrap'><?php echo date("d-m-Y",$producto['modificado']);?></td>
				<td nowrap="nowrap"><?php echo substr($producto['titulo'],0,50);?></td>
				<td nowrap="nowrap"><?php echo substr($producto['urlamigable'],0,50);?></td>
                <td align="right"><?php echo $producto['lecturas'];?></td>
                <td align="right">

                        <?php $display = iif($producto['activo']==1,'none','inline-block');?>
                        <div id='eliminar_<?php echo $producto['id'];?>' style='width:20px;float:right;margin-top:5px;display:<?php echo $display;?>;'>
                            <a href="productos.php?accion=eliminar&id=<?php echo $producto['id'];?>&familia_id=<?php echo $familia_id;?>" title='Eliminar'
                                onclick="return confirm('Est&aacute; seguro de eliminar este Registro?\n <?php echo $producto['titulo'];?>');"><img src='img/del.gif'></a>
                        </div>

                </td>
                
			</tr>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Contenidos para mostrar</span>
<?php } ?>
