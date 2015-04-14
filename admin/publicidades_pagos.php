<?php if (!empty($Pagos)) { ?>
	<table width='100%' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='30' class="th">Desde</td>
			<td width='50' class="th">Hasta</td>
			<td class="th">Plan</td>
			<td width='100' class="th">Importe</td>
            <td width='100' class="th">Fecha de Pago</td>
		</tr>

		<?php
            $color = ''; 
            foreach($Pagos as $reg) { 
		       if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}  
        ?>
			<tr bgcolor='<?php echo $color;?>' >
				<td align='left' nowrap='nowrap'><?php echo date("d-m-Y",$reg['desde']);?></td>
                <td align='left' nowrap='nowrap'><?php echo date("d-m-Y",$reg['hasta']);?></td>

                <td align='left' nowrap='nowrap'><?php echo $reg['plan'];?></td>
                <td align='right' nowrap='nowrap'><?php echo number_format($reg['importe'],2);?></td>
                <td align='right' nowrap='nowrap'>
                </td>
                
			</tr>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Contenidos para mostrar</span>
<?php } ?>
