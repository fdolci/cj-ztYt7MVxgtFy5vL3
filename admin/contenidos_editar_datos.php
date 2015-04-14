<table width='100%'>
	<tr>
		<td width='100' align='right'>
			<span style="color:#000000; font-weight:bold; font-size:12px;\">Titulo:</span>
		</td>
        <td width='550' align='left'>
        	<input type='text'  name='data[titulo<?php echo $i;?>]' id="xtitulo<?php echo $i;?>" value="<?php echo $Pub[titulo.$i];?>" size='90' maxlength='200' onblur="arma_url_friendly(<?php echo $i;?>);"/>
        </td>
    </tr>
    <tr >
	    <td align='right' nowrap>
	   		<span style="color:#000000; font-weight:bold; font-size:12px;\">URL Amigable:</span>
	    </td>
        <td align='left'>
        	<input type='text' id='url_amigable<?php echo $i;?>'  name='data[urlamigable<?php echo $i;?>]' value='<?php echo $Pub[urlamigable.$i];?>' size='90' maxlength='255' />
        </td>
    </tr>

	<tr >
	    <td align='right'>
	    	<span style="color:#000000; font-weight:bold; font-size:12px;\">Keywords:</span>
	    </td>
        <td align='left'>
        	<input type='text' name='data[keywords<?php echo $i;?>]' id='keywords<?php echo $i;?>' value='<?php echo $Pub[keywords.$i];?>' size='90' maxlength='255' />
       	</td>
    </tr>
	<tr>
	    <td align='right'>
	    	<span style="color:#000000; font-weight:bold; font-size:12px;\">Descripcion:</span>
	    </td>
        <td align='left'>
        	<textarea name='data[descripcion<?php echo $i;?>]' id='descripcion<?php echo $i;?>' style="width:580px; height:50px;" ><?php echo $Pub[descripcion.$i];?></textarea>
        	<small>Máximo 255 caracteres.<br><br></small>
        </td>
    </tr>

	<tr> 
	   	<td align='right' width='50' >
	   		<span style="color:#000000; font-weight:bold; font-size:12px;\">Miniatura:</span></small> 
	   	</td>
        <td align='left' valign='top' width='100%'>
            <input type="text" name="data[thumbs<?php echo $i;?>]" id="thumbs<?php echo $i;?>" size='90' maxlength='255' value="<?php echo $Pub[thumbs.$i];?>" />
            <input type="button" value="Buscar en el servidor" onclick="BrowseServer( 'Images:/', 'thumbs<?php echo $i;?>' );" />
			<small><br>Esta permitido subir imágenes JPG o PNG de 240 x 120 pixeles. Estas medidas van a variar de acuerdo al espacio asignado para cada imagen.</small>
        </td>
    </tr>

	<tr >
	    <td align='right'>
	    	<span style="color:#000000; font-weight:bold; font-size:12px;">Tags:</span>
	    </td>
        <td align='left'>
        	<input type='text' name='data[tags<?php echo $i;?>]' id='tags<?php echo $i;?>' value='<?php echo $Pub[tags.$i];?>' size='90' maxlength='255' />
        	<small><br>Escriba los tags separados por coma, Ej: libros, libros de informatica, educacion</small>
       	</td>
    </tr>

    <tr><td colspan='2'><hr></td></tr>
</table>
<center>
<table cellpadding='2' cellspacing='2' bgcolor='#FFFFFF'>
	<?php if ($i == 1) { ?>
	    
		<?php if($Config['blog']!=$categoria_id){ ?>
	    <tr >
		   <td colspan='2'>
	            <span style="color:#000000; font-weight:bold; font-size:12px;\">Categoría en la que se mostrará esta publicación:</span>									
	            <?php echo $sCate ;?>
	       </td>
	    </tr>
	    <?php } else { ?>
	    	<input type='hidden' name='data[categoria_id]' value='<?php echo $categoria_id;?>'
	    <?php } ?>
		<tr>
			<td align='left' colspan='2'>
            	<span style="color:#000000; font-weight:bold; font-size:12px;"> Muestra formulario de contacto rapido?:</span>
    				<select name='data[form_contacto]'>
    					<option value='0' <?php if($Pub['form_contacto']==0){echo "selected=selected";}?> >No</option>
    					<option value='1' <?php if($Pub['form_contacto']==1){echo "selected=selected";}?> >Si</option>
    				</select>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span style="color:#000000; font-weight:bold; font-size:12px;"> Muestra modulo de comentarios de FaceBook?:</span>
    				<select name='data[comentarios]'>
    					<option value='0' <?php if($Pub['comentarios']==0){echo "selected=selected";}?> >No</option>
    					<option value='1' <?php if($Pub['comentarios']==1){echo "selected=selected";}?> >Si</option>
    				</select>
                    
				</td>
			</tr>
        
			<tr>
				<td align='right' ><span style="color:#000000; font-weight:bold; font-size:12px;"> Marcar como 'Destacado':</span></td>
				<td>
				<select name='data[destacado]'>
					<option value='0' <?php if($Pub['destacado']==0){echo "selected=selected";}?> >No</option>
					<option value='1' <?php if($Pub['destacado']==1){echo "selected=selected";}?> >Si</option>
				</select>
                <small>(Si el diseño de la web lo admite)</small>
				</td>
			</tr>
        
			<tr>
				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;">Fecha de la publicacion:</span></td>
				<td><?php echo cb_fechas($fecha);?></td>
			</tr>

			<tr>
				<td align='right' ><span style="color:#000000; font-weight:bold; font-size:12px;"> Muestra esta publicación en la Pagina de Inicio?:</span></td>
				<td>
					<select name='data[home]'>
						<option value='0' <?php if($Pub['home']==0){echo "selected=selected";}?> >No</option>
						<option value='1' <?php if($Pub['home']==1){echo "selected=selected";}?> >Si</option>
					</select>
	                <small>(Si el diseño de la web lo permite)</small>
				</td>
			</tr>
			<tr>
				<td align='right' ><span style="color:#000000; font-weight:bold; font-size:12px;">Establece como Home Page?:</span></td>
				<td>
					<select name='data[pagina_inicio]'>
						<option value='0' <?php if($Pub['pagina_inicio']==0){echo "selected=selected";}?> >No</option>
						<option value='1' <?php if($Pub['pagina_inicio']==1){echo "selected=selected";}?> >Si</option>
					</select>
	                <small>(Si el diseño de la web lo permite)</small>
				</td>
			</tr>
			<tr>
				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;">Robots :</span></td>
				<td>
					<select name="data[robots]">
	                    <option value="INDEX, FOLLOW" <?php if($Pub['robots'] == 'INDEX, FOLLOW') { echo "selected='selected'";} ?> >INDEX, FOLLOW</option>
	                    <option value="INDEX, NOFOLLOW" <?php if($Pub['robots'] == 'INDEX, NOFOLLOW') { echo "selected='selected'";} ?> >INDEX, NOFOLLOW</option>
	                    <option value="NOINDEX" <?php if($Pub['robots'] == 'NOINDEX') { echo "selected='selected'";} ?> >NOINDEX</option>
	                </select>
			</tr>
			<tr>
				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;">Cantidad de Visitas :</span></td>
				<td>
					<input type='text' name='data[lecturas]' id='lecturas' size='3' value='<?php echo $Pub['lecturas'];?>' />
			</tr>

	<?php } ?>
            
	</table>
	</center>
</form>
</center>
