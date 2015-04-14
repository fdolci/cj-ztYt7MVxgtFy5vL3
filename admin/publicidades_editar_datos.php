<form name='form1' id='form1' action='publicidades_editar.php?id=<?php echo $id;?>' method='post' accept-charset="utf-8" enctype="multipart/form-data"> 
            <table width='100%' cellpadding="5" cellspacing="5">
                <tr >
                   <td nowrap style="color:#000000; font-weight:bold; font-size:14px;text-align:right;">Se mostrará en:</td>
                   <td>
                        <?php echo $select_familia;?>
                   </td>
                </tr>
                <tr>
                    <td nowrap style="color:#000000; font-weight:bold; font-size:14px;text-align:right;">Ubicación:</td>
                    <td>
                        <select name='ubicacion'>
                            <option value='top' <?php echo iif($data['ubicacion']=='top', 'selected=selected','');?> >Top</option>
                            <option value='top_right' <?php echo iif($data['ubicacion']=='top_right', 'selected=selected','');?> >Top Right</option>
                            <option value='central' <?php echo iif($data['ubicacion']=='central', 'selected=selected','');?> >Central</option>
                            <option value='left' <?php echo iif($data['ubicacion']=='left', 'selected=selected','');?> >Izquierda</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td style="color:#000000; font-weight:bold; font-size:14px;text-align:right;">Nombre:</td>
                    <td width='550' align='left'>
                        <input type='text'  name='titulo' id="titulo" value="<?php echo $data['titulo'];?>" size='90' maxlength='200' class="required"/>
                    </td>
                </tr>
                <tr>
                    <td style="color:#000000; font-weight:bold; font-size:14px;text-align:right;">Etiqueta ALT:</td>
                    <td width='550' align='left'>
                        <input type='text'  name='alt' id="alt" value="<?php echo $data['alt'];?>" size='90' maxlength='200' class="required"/>
                    </td>
                </tr>

                <tr>
                    <td style="color:#000000; font-weight:bold; font-size:14px;text-align:right;">Email:</td>
                    <td width='550' align='left'>
                        <input type='text'  name='email' id="email" value="<?php echo $data['email'];?>" size='90' maxlength='200'  class='required email'/>
                    </td>
                </tr>

                <tr>
                    <td style="color:#000000; font-weight:bold; font-size:14px;text-align:right;">Vencimiento:</td>
                    <td width='550' align='left'>
                        <?php echo cb_fechas($data['caduca'],'caduca');?>
                    </td>
                </tr>


                <tr> 
                    <td nowrap style="color:#000000; font-weight:bold; font-size:14px;text-align:right;">
                        <small>Top: 700px x 180px</small><br>
                        <small>Central: 700px x 100px</small><br>
                        <small>Izq.: 210px x 160px</small>
                    </td>
                    <td align='left' valign='top' width='100%'>
                        <table>
                            <tr>
                                <td><?php if (!empty($data['thumbs'])){ echo "<img src='".VER_PUBLICIDAD.'/'.$data['thumbs']."' width='60' height='60'>";}?></td>
                                <td>
                                    <input type="file" name='nueva_imagen' value="Buscar en el servidor" />
                                    <input type="text" name="thumbs" id="thumbs" size='80' maxlength='255' value="<?php echo $data['thumbs'];?>" /><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="color:#000000; font-weight:bold; font-size:14px;text-align:right;">Web:</td>
                    <td width='550' align='left'>
                        <input type='text'  name='web' id="web" value="<?php echo $data['web'];?>" size='90' maxlength='200'  />
                    </td>
                </tr>
            </table>
            <br><br>
    <input type='hidden' name='id' value='<?php echo $id;?>' />
    <input type='text'  name='test' id="test" value="." style='width:20px;color:#eee;' readonly='readonly'  class='required'/><b>Datos Obligatorios</b>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
    <input type='submit' name='submit' value='<< Guardar los cambios >>'  />
</form>