<!-- *********** IMAGENES LATERALES DEL PRODUCTO -->
<tr class='tmed'>
	<td colspan='2' width='100%' align='center'>
	<table class='estilotabla' width='100%' border='0' bgcolor='#F0F0EE' cellpadding='3' cellspacing='3'>
		<tr><td align='center' colspan='1' ><h2>Im&aacute;genes de productos para mostrar en la publicaci&oacute;n</h2></td>	</tr>
		<tr>
		<td align='center'>
			<table class='estilotabla' width='98%' border='0'>

			<?php for($i=1 ; $i<=6 ; $i ++) { ?>

				<tr> <!--  *********** IMAGEN 01 ***************** -->
					<td align='center' width='50' >
					<?php if (!empty($imagen[$i])){ ;?>
						<a href="<?=$imagen[$i];?>" title='Ampliar Imagen'
						onclick="window.open('<?=$imagen[$i];?>','','resizable=yes,dependent=yes,width=400,height=400,left='+(screen.availWidth/2-200)+',top='+(screen.availHeight/2-200)+'');return false;">
						<img src="<?=$imagen[$i];?>" border="2" width="50"  height='50' alt='Ampliar Imagen'/></a> 
					<?php } ?>	
					</td>

					<td align='left' colspan='1' width='100%'>
						<b>0<?=$i;?></b> : <input name="imagen[<?=$i;?>]" type="text" size='90' value='<?=$imagen[$i];?>' />
					</td>	
				</tr>
			<?php } ?>				
			</table>
		</td>
		</tr>

	</table>
		
</td></tr>
