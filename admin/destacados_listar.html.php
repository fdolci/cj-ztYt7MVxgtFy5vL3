<center>

<?php if (!empty($Noticias)) { ?>
	<table width='1000' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='30'  class="th" colspan='1'>ID</td>
			<td width='30'  class="th" colspan='1'>Destacado</td>
			<td width='100' class="th">Acciones</td>
			<td width='60'  class="th">Update</td>
			<td width='60'  class="th">Fecha</td>            
			<td width='40%' class="th">Titulo</td>
			<td class="th" >Categoria</td>
            <td class="th" >Visitas</td>
		</tr>

		<?php
            $color = ''; 
            foreach($Noticias as $not) { 
		       if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}  
        ?>
			<tr bgcolor='<?php echo $color;?>' >
				<td align='left' nowrap='nowrap'><?php echo $not['id'];?></td>
                <td align='center' nowrap='nowrap'>
					<a href='destacados.php?accion=destacado&id=<?php echo $not['id'];?>'
						title='Sacar de Destacado'> <img src='<?php echo ADMIN;?>/img/destacado.png' width='18' border='0'/></a>
               	</td>
				<td align='center' nowrap="nowrap">
					<a href='contenidos_editar.php?id=<?php echo $not['id'];?>&categoria_id=<?php echo $not['categoria_id'];?>'
						title='Editar esta publicaci&oacute;n'><img src='<?php echo ADMIN;?>img/edit.gif' border='0'/></a>
				</td>
                <td nowrap='nowrap'><?php echo date("d-m-Y",$not['modificado']);?></td>
                <td nowrap='nowrap'><?php echo date("d-m-Y",$not['fecha']);?></td>                
				<td nowrap="nowrap">
					<?php if($not['pagina_inicio'] == 1) { ?>
						<img src='<?php echo ADMIN;?>img/pagina_inicio.gif' border='0' />
					<?php } ?>
					<?php echo substr($not['titulo1'],0,50);?></td>
				<td nowrap="nowrap"><?php echo $not['categoria'];?></td>
                <td align="right"><?php echo $not['lecturas'];?></td>
			</tr>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Contenidos para mostrar</span>
<?php } ?>

