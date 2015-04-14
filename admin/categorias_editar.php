<?php

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$cond 	   = "select * from categorias where id=".$id;
	$rs 	   = $db->SelectLimit($cond, 1);
	$Categoria = $rs->FetchRow();

    if ($id == 0) {
        $Categoria['pub_a_mostrar'] = 5;
    }

    $cond    = "select * from grupos where activo=1 order by nombre ASC";
    $rs      = $db->Execute($cond);
    $xGrupos = $rs->GetRows();
    $grupo_id = $Categoria['grupo_id'];
    $select_grupos = "<select name='data[grupo_id]' style='width:150px;'>";
    if ($grupo_id==0) {
            $select_grupos.= "<option value='0' selected='selected'>Publico</option>";    
    } else {
            $select_grupos.= "<option value='0'>Publico</option>";            
    }        
    foreach ($xGrupos as $xgrupo) {
        if ($xgrupo['id'] == $grupo_id) {
            $select_grupos.= "<option value='{$xgrupo['id']}' selected='selected'>{$xgrupo['nombre']}</option>";    
        } else {
            $select_grupos.= "<option value='{$xgrupo['id']}'>{$xgrupo['nombre']}</option>";
        }
    }
    $select_grupos.= "</select>";

?>



<script type="text/javascript">
    function muestra(cual){

        <?php for($i=1; $i<=5; $i++) { ?>
            <?php if( !empty($Idiomas[($i-1)]['name']) ) { ?>
            document.getElementById('idioma<?=$i;?>').style.display = 'none';
            <?php } ?>
        <?php } ?>        
        document.getElementById(cual).style.display = 'block';
    }
</script>

<link href="<?php echo RUTA;?>/css/texto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo URL;?>/admin/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/admin/js/ckfinder/ckfinder.js"></script>

<center>

<form name='form1' action='categorias.php?accion=grabar&id=$id' method='post'>

    <table width='800' cellpadding='3' cellspacing='3' border='0' style="border-width:1px; border-style:solid; border-color:#000000;background-color:white;">
    	<tr bgcolor='#0271E3' >
    		<td colspan='2' align='center'>
    			<span style="color:#FFFFFF; font-weight:bold; font-size:14px;">Agregar / Modificar una Categoria</span></td>
    	</tr>
        <tr>
            <td colspan="2">
                <div id='menu_idiomas'>
                    <ul>
                        <!-- ---------------------------------------------------------- IDIOMAS ---->    
                        <?php foreach($Idiomas as $idioma) {?>
                            <?php if( !empty($idioma['name'])) { ?>
                                <li>
                                    <a href="#" onclick="muestra('idioma<?php echo $idioma['id'];?>');">
                                        <img src='<?php echo URL.$idioma['flag'];?>' border='0' /> <?php echo $idioma['name'];?>
                                    </a>
                                </li>
                            <?php } // ENDIF ?>
                        <?php } // end foreach ?>
                    </ul>
                </div>
            </td>
        </tr>


    	<tr>
            <td colspan='2'>
        
                <?php foreach ($Idiomas as $idioma) { ?>
                    <?php if( !empty($idioma['name']) ) { ?>
                        <?php $idioma_id = $idioma['id'];?>

                        <?php if($idioma_id==1) { $display='block';} else {$display='none';} ?>

    		            <div id="idioma<?php echo $idioma_id;?>" style="display:<?php echo $display;?>; ">
                            <img src='<?php echo URL.$idioma['flag'];?>' border='0' />  <strong><?php echo $idioma['name'];?></strong>

                            <table width='100%'>
                    			<tr >
                    				<td align='right'>
                                        <span style="color:#000000; font-weight:bold; font-size:12px;\">Titulo:</span>
                                    </td>
                                    <td align='left'>
                                        <input type='text' name='data[titulo<?php echo $idioma_id;?>]' id="xtitulo<?php echo $idioma_id;?>" 
                                            value='<?php echo $Categoria['titulo'.$idioma_id];?>' size='90' maxlength='255' /> 
                                    </td>
                    			</tr>
                    			<tr >
                    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">URL Amigable:</span></td>
                                    <td align='left'>
                                        <input type='text' id='url_amigable<?php echo $idioma_id;?>'  name='data[urlamigable<?php echo $idioma_id;?>]' 
                                            value='<?php echo $Categoria['urlamigable'.$idioma_id];?>' size='90' maxlength='255' />
                                    </td>
                    			</tr>

                    			<tr >
                    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Keywords:</span></td>
                                    <td align='left'>
                                        <input type='text' name='data[keywords<?php echo $idioma_id;?>]' id='keywords<?php echo $idioma_id;?>' 
                                            value='<?php echo $Categoria['keywords'.$idioma_id];?>' size='90' maxlength='255' />
                                    </td>
                    			</tr>
                                <tr >
                                    <td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Descripcion:</span></td>
                                    <td align='left'>
                                        <textarea  id='descripcion<?php echo $idioma_id;?>' name='data[descripcion<?php echo $idioma_id;?>]' style="width:600px; height:60px;" 
                                            ><?php echo $Categoria['descripcion'.$idioma_id];?></textarea><small>Maximo 255 caracteres</small>
                                    </td>
                                </tr>

                    			<tr >
                    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Cuerpo:</span></td>
                    				<td align='left'>
                                        <textarea  id='cuerpo<?php echo $idioma_id;?>' name='data[cuerpo<?php echo $idioma_id;?>]' style="width:800px; height:600px;" 
                                            class="ckeditor"><?php echo $Categoria['cuerpo'.$idioma_id];?></textarea>
                                		<script type="text/javascript">
                                           var editor = CKEDITOR.replace( 'cuerpo<?php echo $idioma_id;?>',{ height: '250px'} );
                                	       CKFinder.setupCKEditor( editor, '<?php echo URL;?>/admin/js/ckfinder/' ) ;
                                		</script>
                                    
                                    </td>
                    			</tr>
                            </table>    

                        </div>
            <?php } //endif !empty idioma-name?>
        
        <?php } //end foreach ?>

                <table width='100%'>
                    <?php if ($_SESSION['god'] == 1) { ?>        
            			<tr ><td align='left' colspan='2'><hr /></td></tr>
            			<tr >
            				<td align='right'>
                                <span style="color:#000000; font-weight:bold; font-size:12px;">Cuando seleccione esta categoría, muestra el Cuerpo o un listado de Publicaciones?:</span>
                            </td>
                            <td align='left'>
                				<select name='data[muestra_cuerpo]'>
                					<option value='0' <?php if($Categoria['muestra_cuerpo']==0){echo "selected=selected";}?> >Listado de Publicaciones</option>
                					<option value='1' <?php if($Categoria['muestra_cuerpo']==1){echo "selected=selected";}?> >Cuerpo de la Categoría</option>
                				</select>
            				</td>
            			</tr>
                        <tr >
                            <td align='right'>
                                <span style="color:#000000; font-weight:bold; font-size:12px;">Cómo desea ordenar el listado de publicaciones?:</span>
                            </td>
                            <td align='left'>
                                <select name='data[ordenar_publicaciones]'>
                                    <option value='orden DESC'   <?php if($Categoria['ordenar_publicaciones']=='orden DESC'  ){echo "selected=selected";}?> >Orden Descendente</option>
                                    <option value='orden ASC'    <?php if($Categoria['ordenar_publicaciones']=='orden ASC'   ){echo "selected=selected";}?> >Orden Ascendente</option>
                                    <option value='fecha DESC'   <?php if($Categoria['ordenar_publicaciones']=='fecha DESC'  ){echo "selected=selected";}?> >Fecha Descendente</option>
                                    <option value='fecha ASC'    <?php if($Categoria['ordenar_publicaciones']=='fecha ASC'   ){echo "selected=selected";}?> >Fecha Ascendente</option>
                                    <option value='titulo1 DESC' <?php if($Categoria['ordenar_publicaciones']=='titulo1 DESC'){echo "selected=selected";}?> >Alfabetico Descendente</option>
                                    <option value='titulo1 ASC'  <?php if($Categoria['ordenar_publicaciones']=='titulo1 ASC' ){echo "selected=selected";}?> >Alfabetico Ascendente</option>
                                </select>
                            </td>
                        </tr>

                        <tr >
                            <td align='right'>
                                <span style="color:#000000; font-weight:bold; font-size:12px;">Que grupo de usuarios accede a las publicaciones de esta categoría?:</span>
                            </td>
                            <td>
                                <?php echo $select_grupos;?>                
                            </td>
                        </tr>

            			<tr >
            				<td align='right'>
                                <span style="color:#000000; font-weight:bold; font-size:12px;">Cantidad de Publicaciones a mostrar por pagina en el listado:</span>
                            </td>
                            <td>
                                <input type='text' name='data[pub_a_mostrar]' value='<?php echo $Categoria['pub_a_mostrar'];?>' size='3' maxlength='2' />
            				</td>
            			</tr>

                        <?php if ($Config['blog']!=$Categoria['id']){ ?>
            			<tr>
            				<td align='right'>
                                <span style="color:#000000; font-weight:bold; font-size:12px;\">Template a Utilizar para mostrar el listado de publicaciones:</span>
                            </td>
                            <td>
                                <select name="data[template]">
                                    <?php foreach($TemplatesCategorias as $key=>$value) { ?>
                                        <option value='<?php echo $key;?>' <?php if($Categoria['template']==$key){echo "selected=selected";}?> ><?php echo $value;?></option>
                                    <?php } ?>
                    				</select>
                            </td>
            			</tr>
                        <?php } else { ?>
                            <input type='hidden' name='data[template]' value='0'>

                        <?php } //endif blog ?>

                        <tr >
                            <td align='right'>
                                <span style="color:#000000; font-weight:bold; font-size:12px;">Slide para la cabecera:</span>
                            </td>
                            <td>
                                <select name='data[slide_id]'>
                                    <option value='0'> Seleccione una banner</option>
                                    <?php 
                                        $cond   = "select * from slides order by nombre ASC";
                                        $rs     = $db->Execute($cond);
                                        $banner = $rs->GetRows();
                                        foreach($banner as $b){
                                            if ($b['id'] == $Categoria['slide_id']){$sel='selected=selected';} else {$sel='';}
                                            echo "<option value='{$b['id']}' $sel> {$b['nombre']}</option>";  
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>


            			<tr >
            				<td align='right'>
                                <span style="color:#000000; font-weight:bold; font-size:12px;">Esta Categoria Muestra Productos?:</span>
                            </td>
                            <td>
                				<select name='data[muestra_productos]'>
                					<option value='0' <?php if($Categoria['muestra_productos']==0){echo "selected=selected";}?> >No</option>
                					<option value='1' <?php if($Categoria['muestra_productos']==1){echo "selected=selected";}?> >Si</option>
                				</select>
                            </td>
            			</tr>
                    <?php } else { ?>
                        <tr><td colspan='2'>
                            <input type='hidden' name='data[muestra_cuerpo]'    value='<?php echo $Categoria['muestra_cuerpo'];?>'   />
                            <input type='hidden' name='data[pub_a_mostrar]'     value='<?php echo $Categoria['pub_a_mostrar'];?>'    />
                            <input type='hidden' name='data[template]'          value='<?php echo $Categoria['template'];?>'         />
                            <input type='hidden' name='data[muestra_productos]' value='<?php echo $Categoria['muestra_productos'];?>'/>
                        </td></tr>
            
                    <?php } // endif ($_SESSION['god'] == 1)?>

    			<tr >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Robots:</span></td>
                    <td align='left'><input type='text' name='data[robots]' value='<?php echo $Categoria['robots'];?>' size='50' maxlength='255' /></td>
    			</tr>

                <tr ><td align='left' colspan='2'>
                    <hr />
                    <pre>
    A continuación podemos ver una explicación de los diferentes valores que podemos usar dentro del tag meta robots:
    <u>index</u>: Permite a los motores de búsqueda indexar la página. No lo tienes que añadir ya que por defecto, las páginas se indexan.
    <u>noindex</u>: No permite a los motores de búsqueda indexar la página.
    <u>none</u>: Este valor dice a los motores de búsqueda que no hagan nada con la página.
    <u>follow</u>: Le dice a los motores de búsqueda que sigan los enlaces de la página, puedan o no puedan indexar su contenido.
    <u>nofollow</u>: Le dice a los motores de búsqueda que no sigan ninguno de los enlaces de la página (Útil para páginas en las que no quieres <br/>pasar ningún PageRank a los enlaces que contiene)
    <u>noarchive</u>: Evita que el motor de búsqueda muestre la opción de “página en cache”.
    <u>nocache</u>: Lo mismo que noarchive, usado por algunos buscadores.
    <u>nosnippet</u>: Evita que los buscadores muestren un breve texto debajo del título de la página. También evita que guarden en caché la página.
    <u>noodp</u>: Bloquea a los buscadores el uso de la descripción de la página de DMOZ (ODP) como texto para descripción del contenido de la página.
                </pre>
                </td></tr>
        	</table>
    	   </td>
        </tr>
    	<tr >
    		<td align='right'></td>
    		<td align='center'>
    			<input type='hidden' name='data[id]' value='<?php echo $Categoria['id'];?>' />
    			<input type='submit' name='submit' value='<< Guardar los cambios >>'/>
    		</td>
    	</tr>
    </table>
</form>
</center>