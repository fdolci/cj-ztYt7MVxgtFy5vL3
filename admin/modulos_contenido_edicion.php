<?php

    $item_menu[0] = 3;
    $item_menu[1] = 2 ;
    $title = 'M&oacute;dulos';    
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }


    $accion = request('accion','');
    $id = request('id',0);



	if ($accion == 'guardar') {

		$titulo                 = request('titulo','');
        $bloque_menu            = request('bloque_menu',0);
//        $script                 = request('script','');
        $script                 = addslashes($_POST['script']);
        $descripcion            = addslashes(request('descripcion',''));
        $ubicacion              = request('ubicacion','');
        $categorias             = request('categorias','');
        $listar_categoria       = request('listar_categoria','');
        $cantidad_publicaciones = request('cantidad_publicaciones',5);
        $cantidad_caracteres    = request('cantidad_caracteres',0);
        $muestra_miniatura      = request('muestra_miniatura',0);
        $nombre_div             = request('nombre_div','');
        $mostrar_en_sitemap     = request('mostrar_en_sitemap',0);
        $mostrar_en_contacto    = request('mostrar_en_contacto',0);
        $mostrar_en_home        = request('mostrar_en_home',0);
        $mostrar_en_listado     = request('mostrar_en_listado',0);
        $mostrar_destacados     = request('mostrar_destacados',0);        
        $muestra_titulo         = request('muestra_titulo',0);        
        $cantidad_destacados    = request('cantidad_destacados',0);
        $slide                  = request('slide',0);
        $listar_familia         = request('listar_familia','');
        $cantidad_productos     = request('cantidad_productos',5);
		$idioma_id              = request('idioma_id',0);
		$consulta_rapida        = request('consulta_rapida',0);
                
		if ($id!=0) {
			$sql = "update modulos  set 
                        bloque_menu         = '$bloque_menu', 
                        descripcion         = '$descripcion', 
                        script              = '$script', 
                        ubicacion           = '$ubicacion', 
                        titulo              = '$titulo', 
                        categorias          = '$categorias', 
                        listar_categoria    = '$listar_categoria', 
                        cantidad_publicaciones = '$cantidad_publicaciones', 
                        cantidad_caracteres = '$cantidad_caracteres',
                        muestra_miniatura   = '$muestra_miniatura',
                        nombre_div          = '$nombre_div',
                        mostrar_en_sitemap  = '$mostrar_en_sitemap', 
                        mostrar_en_contacto = '$mostrar_en_contacto', 
                        mostrar_en_home     = '$mostrar_en_home',
                        mostrar_en_listado  = '$mostrar_en_listado',
                        mostrar_destacados  = '$mostrar_destacados',
                        cantidad_destacados = '$cantidad_destacados',
                        muestra_titulo      = '$muestra_titulo',
                        listar_familia      = '$listar_familia', 
                        cantidad_productos  = '$cantidad_productos', 
                        idioma_id           = '$idioma_id',
						consulta_rapida     = '$consulta_rapida',
                        slide               = '$slide' 
                        where id = '$id'";
        } else {
			$sql = "insert into modulos (bloque_menu, descripcion, script, ubicacion, titulo, categorias, listar_categoria, cantidad_publicaciones, nombre_div, 
                    mostrar_en_sitemap, mostrar_en_contacto, mostrar_en_home, mostrar_en_listado, slide, cantidad_caracteres, muestra_miniatura,
                    mostrar_destacados, cantidad_destacados, muestra_titulo, listar_familia, cantidad_productos, idioma_id, consulta_rapida )
                    values ('$bloque_menu', '$descripcion', '$script', '$ubicacion', '$titulo', '$categorias', '$listar_categoria', '$cantidad_publicaciones', '$nombre_div',
                    '$mostrar_en_sitemap', '$mostrar_en_contacto', '$mostrar_en_home','$mostrar_en_listado','$slide', '$cantidad_caracteres', '$muestra_miniatura', 
                    '$mostrar_destacados', '$cantidad_destacados', '$muestra_titulo','$listar_familia', '$cantidad_productos','$idioma_id', '$consulta_rapida' )";
		}
/*
		echo $sql;	
        die();
*/        
		$ok = $db->Execute( $sql );
        if ($ok) {
            $_SESSION['Msg'] = "Cambios guardados correctamente!";
            redirect('modulos_contenido.php');
            exit();
            
        } else {
            $_SESSION['Msg'] = "ERROR!, no se pudieron guardar los cambios";
            $Mod['titulo']       = $titulo;
            $Mod['script']       = $script;
            $Mod['categorias']   = $categorias;
            $Mod['descripcion']  = $descripcion;
            $Mod['ubicacion']    = $ubicacion;
            $Mod['bloque_menu']  = $bloque_menu;
            $Mod['listar_categoria']  = $listar_categoria;
            $Mod['cantidad_publicaciones']  = $cantidad_publicaciones;
            $Mod['nombre_div']  = $nombre_div;
            $Mod['mostrar_en_sitemap']  = $mostrar_en_sitemap;
            $Mod['mostrar_en_contacto'] = $mostrar_en_contacto;
            $Mod['mostrar_en_home']     = $mostrar_en_home;
            $Mod['mostrar_en_listado']  = $mostrar_en_listado;
            $Mod['mostrar_destacados']  = $mostrar_destacados;
            $Mod['cantidad_destacados'] = $cantidad_destacados;
            $Mod['muestra_titulo']      = $muestra_titulo;
            $Mod['slide']               = $slide;
            $Mod['listar_familia']      = $listar_familia;
            $Mod['cantidad_productos']  = $cantidad_productos;
			$Mod['idioma_id']  = $idioma_id;
			$Mod['consulta_rapida']  = $consulta_rapida;
            
//            pr($sql);
        }

	} else {
        $sql = "select * from modulos where id='$id'";
    	$rs  = $db->SelectLimit($sql,1); 	
    	$Mod = $rs->FetchRow(); 
        $Mod['script'] = stripslashes($Mod['script']);
        $Mod['descripcion'] = stripslashes($Mod['descripcion']);
		$idioma_id = $Mod['idioma_id'];
		
	} 
	// Select Idiomas	
	$rs  = $db->Execute("select name,id from idiomas where activo=1");
	$select_idioma = $rs->GetMenu2('idioma_id',$idioma_id,true,false);

	
    $sql = "select * from bloque_menu where activo=1 order by nombre ASC";
  	$rs  = $db->Execute($sql); 	
   	$BloquesMenues = $rs->GetRows(); 
	   
    $sql = "select * from categorias where activo=1 order by titulo1 ASC";
  	$rs  = $db->Execute($sql); 	
  	$Categorias = $rs->GetRows(); 

    // -ARMA LOS SELECT DE LAS FAMILIAS
    $Familias = crearArbol(0);
    $parent_id = 0;
    $familia_id = '<select name="listar_familia">';
    $familia_id.= "<option value='0' >Seleccione una Familia de Productos</option>";
    foreach($Familias as $dd){
            if ($Mod['listar_familia'] == $dd['id']) { $sel = "selected='selected'"; } else {$sel='';}
            $separador = "";
            if ($dd['nivel'] == 2 ) {
                $separador = "------";
            } elseif ($dd['nivel'] == 3 ) {
                $separador = "------------";
            } elseif ($dd['nivel'] == 4 ) {
                $separador = "------------------";
            }
            $familia_id.= "<option value='{$dd['id']}' $sel >$separador {$dd['nombre1']}</option>";
    }
    $familia_id.= "</select>";

       
    $sql = "select * from slides where activo=1 order by nombre ASC";
  	$rs  = $db->Execute($sql); 	
  	$Slides = $rs->GetRows(); 


	if(!empty($_SESSION['Msg'])) {
	   echo mensaje_ok($_SESSION['Msg']);
		$_SESSION['Msg']='';
	}

?>

<link href="<?=RUTA;?>/css/texto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo INST_DIR;?>/admin/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo INST_DIR;?>/admin/js/ckfinder/ckfinder.js"></script>


<form action="modulos_contenido_edicion.php" method="post">
<table width='1000' cellpadding='3' cellspacing='3' style="border-width:1px; border-style:solid; border-color:#000000">
    <tr><td colspan="2" class="th">Edición de Contenido de Módulo</td></tr>

    <tr>
        <td align="right" width="10%" class="th"><b>Título</b><span class="tchico">&nbsp;(requerido)</span></td>
        <td align="left"><input name="titulo" value="<?=$Mod['titulo'];?>" size="60" type="text" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Muestra el Titulo: </strong>
            <select name="muestra_titulo">
                <option value='0' <?php if($Mod['muestra_titulo']  ==  0){ echo "selected='selected'";} ?> >No</option>
                <option value='1' <?php if($Mod['muestra_titulo']  == 1){ echo "selected='selected'";} ?> >Si</option>
            </select> 
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
		<strong>Mostrar en Idioma:</strong> <?php echo $select_idioma;?>
        </td>
    </tr>


    <tr><td colspan="2"><hr /><h2>DONDE PUBLICAR</h2></td></tr>
    <tr>
        <td align="right" width="150" class="th"><b>Ubicación:</b></td>
        <td align="left"  width="25%" valign="middle">
                    <select name="ubicacion">
                        <option value="1" <?php if($Mod['ubicacion']=='1') { echo 'selected="selected"';}?> >B1</option>
                        <option value="2" <?php if($Mod['ubicacion']=='2') { echo 'selected="selected"';}?> >B2</option>
                        <option value="3" <?php if($Mod['ubicacion']=='3') { echo 'selected="selected"';}?> >B3</option>
                        <option value="4" <?php if($Mod['ubicacion']=='4') { echo 'selected="selected"';}?> >B4</option>
                        <option value="5" <?php if($Mod['ubicacion']=='5') { echo 'selected="selected"';}?> >B5</option>
                        <option value="6" <?php if($Mod['ubicacion']=='6') { echo 'selected="selected"';}?> >B6</option>

                        <option value="7" <?php if($Mod['ubicacion']=='7') { echo 'selected="selected"';}?> >B7</option>
                        <option value="8" <?php if($Mod['ubicacion']=='8') { echo 'selected="selected"';}?> >B8</option>                                                                                                                                                                        
                        <option value="9" <?php if($Mod['ubicacion']=='9') { echo 'selected="selected"';}?> >B9</option>
<?php /*
                        <option value="10" <?php if($Mod['ubicacion']=='10') { echo 'selected="selected"';}?> >B10</option>
                        <option value="11" <?php if($Mod['ubicacion']=='11') { echo 'selected="selected"';}?> >B11</option>
                        <option value="12" <?php if($Mod['ubicacion']=='12') { echo 'selected="selected"';}?> >B12</option>
                        <option value="13" <?php if($Mod['ubicacion']=='13') { echo 'selected="selected"';}?> >B13</option>
                        <option value="14" <?php if($Mod['ubicacion']=='14') { echo 'selected="selected"';}?> >B14</option>
                        <option value="15" <?php if($Mod['ubicacion']=='15') { echo 'selected="selected"';}?> >B15</option>
*/ ?>                                                                                                
                    </select>
        </td>
    </tr>
    <tr>
        <td align="right" width="150" class="th"><b>Nombre del DIV:</b></td>
        <td align="left"  width="25%" valign="middle">
            <input type="text" name="nombre_div" value='<?php echo $Mod['nombre_div'];?>' />
        </td>
    </tr>


    <tr><td colspan="2"><hr /><h2>QUE PUBLICAR</h2>Estas opciones son excluyentes [contenido html] o [script] o [Bloque de Menú]</td></tr>
    <tr>
        <td class="th"><b>Imagen <br /> Flash <br /> HTML <br /> Video:</td>
        <td align="left">
            <textarea name="descripcion" cols="100" rows="20" class="ckeditor" ><?=$Mod['descripcion'];?></textarea> 
            <script type="text/javascript">
                var editor = CKEDITOR.replace( 'descripcion' );
            	CKFinder.setupCKEditor( editor, '<?=URL;?>/admin/js/ckfinder/' ) ;
            </script>

        </td>
    </tr>

    <tr>
        <td class="th"><b>Script</b> <small>Ej: Los script de facebook, twitter, etc</small>:</td>
        <td align="left">
            <textarea name="script" cols="150" rows="10" ><?=$Mod['script'];?></textarea>
        </td>
    </tr>
    <tr>
        <td class="th"><br /><b>Formulario de Consulta Rapida</b>:<br /><br /></td>
        <td align="left">
            <select name="consulta_rapida">
                <option value='0' <?php if($Mod['consulta_rapida']  ==  0){ echo "selected='selected'";} ?> >No</option>
                <option value='1' <?php if($Mod['consulta_rapida']  == 1){ echo "selected='selected'";} ?> >Si</option>
            </select> 

        </td>
    </tr>

    <tr>
        <td class="th"><br /><b>Bloque de Menú</b>:<br /><br /></td>
        <td align="left">
            <select name="bloque_menu">
                <option value='0' <?php if($Mod['bloque_menu']==0){ echo "selected='selected'";} ?> >Seleccione un bloque de menu</option>
            <?php foreach($BloquesMenues as $bm){ ?>
                <option value='<?=$bm['id'];?>' <?php if($Mod['bloque_menu']==$bm['id']){ echo "selected='selected'";} ?> ><?=$bm['nombre'];?></option>
            <?php }?>
            </select>
        </td>
    </tr>

    <tr>
        <td class="th"><br/><b>Listar Ultimas Publicaciones de una categoria:</b><br /><br /></td>
        <td align="left">
            
            <select name="listar_categoria">
                <option value='0' <?php if($Mod['listar_categoria']==0){ echo "selected='selected'";} ?> >Seleccione una Categoria</option>
            <?php foreach($Categorias as $bm){ ?>
                <option value='<?=$bm['id'];?>' <?php if($Mod['listar_categoria']==$bm['id']){ echo "selected='selected'";} ?> ><?=$bm['titulo1'];?></option>
            <?php }?>
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Cantidad de Publicaciones a mostrar: <input type="text" name="cantidad_publicaciones" value='<?php echo $Mod['cantidad_publicaciones'];?>' size='2'/>
            <br />
            Cantidad de Caracteres a mostrar: <input type="text" name="cantidad_caracteres" value='<?php echo $Mod['cantidad_caracteres'];?>' size='2'/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Muestra Miniatura: 
            <select name="muestra_miniatura">
                <option value='0' <?php if($Mod['muestra_miniatura']  ==  0){ echo "selected='selected'";} ?> >No</option>
                <option value='1' <?php if($Mod['muestra_miniatura']  == 1){ echo "selected='selected'";} ?> >Si</option>
            </select> 
        </td>
    </tr>


    <tr>
        <td class="th"><br/><b>Listar Productos de una Familia:</b><br /><br /></td>
        <td align="left">
            <?php echo $familia_id;?>                
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Cantidad de Productos a mostrar: <input type="text" name="cantidad_productos" value='<?php echo $Mod['cantidad_productos'];?>' size='2'/>
        </td>
    </tr>


    <tr>
        <td class="th"><br/><b>SLIDE:</b><br /><br /></td>
        <td align="left">
            
            <select name="slide">
                <option value='0' <?php if($Mod['slide']==0){ echo "selected='selected'";} ?> >Seleccione un Banner</option>
            <?php foreach($Slides as $bm){ ?>
                <option value='<?=$bm['id'];?>' <?php if($Mod['slide']==$bm['id']){ echo "selected='selected'";} ?> ><?=$bm['nombre'];?></option>
            <?php }?>
            </select>
        </td>
    </tr>

    <tr>
        <td class="th"><br/><b>Destacados:</b><br /><br /></td>
        <td align="left">
            Mostrar publicaciones destacadas:     
            <select name="mostrar_destacados">
                <option value="0" <?php if($Mod['mostrar_destacados']=='0') { echo 'selected="selected"';}?> >No</option>
                <option value="1" <?php if($Mod['mostrar_destacados']=='1') { echo 'selected="selected"';}?> >Si</option>
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Cantidad de Destacados a mostrar: <input type="text" name="cantidad_destacados" value='<?php echo $Mod['cantidad_destacados'];?>' size='2'/>
        </td>
    </tr>

    <tr><td colspan="2"><hr /><h2>CUANDO PUBLICAR</h2></td></tr>
    <tr>
        <td align="right" width="150" class="th"><b>Cuando se va a Mostrar:</b></td>
        <td align="left" valign="middle">
            En las publicaciones de la siguiente categoria:
            <select name="categorias">
                <option value='0' <?php if($Mod['categorias']  ==  0){ echo "selected='selected'";} ?> >En Todas las categorias</option>
                <option value='-1' <?php if($Mod['categorias']  ==  -1){ echo "selected='selected'";} ?> >Solo en las siguentes opciones</option>
            <?php foreach($Categorias as $cate){ ?>
                <option value='<?=$cate['id'];?>' <?php if($Mod['categorias']==$cate['id']){ echo "selected='selected'";} ?> ><?=$cate['titulo1'];?></option>
            <?php }?>
            </select>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Mostrar tambien en el listado de esa categoria?:     
        <select name="mostrar_en_listado">
            <option value="0" <?php if($Mod['mostrar_en_listado']=='0') { echo 'selected="selected"';}?> >No</option>
            <option value="1" <?php if($Mod['mostrar_en_listado']=='1') { echo 'selected="selected"';}?> >Si</option>
        </select>
        
        <br /><br />
        Mostrar en la Home?:     
        <select name="mostrar_en_home">
            <option value="0" <?php if($Mod['mostrar_en_home']=='0') { echo 'selected="selected"';}?> >No</option>
            <option value="1" <?php if($Mod['mostrar_en_home']=='1') { echo 'selected="selected"';}?> >Si</option>
        </select>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Mostrar en Formulario de Contacto?:     
        <select name="mostrar_en_contacto">
            <option value="0" <?php if($Mod['mostrar_en_contacto']=='0') { echo 'selected="selected"';}?> >No</option>
            <option value="1" <?php if($Mod['mostrar_en_contacto']=='1') { echo 'selected="selected"';}?> >Si</option>
        </select>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Mostrar en Mapa Web?:     
        <select name="mostrar_en_sitemap">
            <option value="0" <?php if($Mod['mostrar_en_sitemap']=='0') { echo 'selected="selected"';}?> >No</option>
            <option value="1" <?php if($Mod['mostrar_en_sitemap']=='1') { echo 'selected="selected"';}?> >Si</option>
        </select>

        <br />



        </td>
    </tr>



    <tr>
        <td colspan="2" align="center">
            <input name="id" value="<?=$Mod['id'];?>" type="hidden" />
            <input name="accion" value="guardar" type="hidden" />
            <input name="submit" value="Guardar los Cambios" type="submit" />
        </td>
    </tr>
</table>                
</form>