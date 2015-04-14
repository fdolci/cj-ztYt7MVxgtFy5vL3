<?php
    $item_menu[0] = 1;
    $item_menu[1] = 8; 
    $title = 'Corregir URL';

	include('header.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

    $titulo         = 'Administracion de Usuarios';    


	$submit = request('submit','');
    if (!empty($submit)) {
        $anterior = request('anterior','');
        $nueva = request('nueva','');
        
        if (!empty($anterior) and !empty($nueva)) {
            //----- Categorias
            $rs = $db->execute("select * from categorias");
            $x = $rs->GetRows();
            foreach($x as $z) {
                $id = $z['id'];
                $cuerpo1   = str_replace($anterior,$nueva,$z['cuerpo1']);
                $cuerpo2   = str_replace($anterior,$nueva,$z['cuerpo2']);
                $cuerpo3   = str_replace($anterior,$nueva,$z['cuerpo3']);
                $cuerpo4   = str_replace($anterior,$nueva,$z['cuerpo4']);
                $cuerpo5   = str_replace($anterior,$nueva,$z['cuerpo5']);
                $sql = "update categorias set cuerpo1='$cuerpo1', cuerpo2='$cuerpo2', cuerpo3='$cuerpo3', cuerpo4='$cuerpo4', cuerpo5='$cuerpo5' where id='$id'";
                $rs = $db->execute($sql);
            }            

            //----- Publicaciones
            $rs = $db->execute("select * from publicaciones");
            $x = $rs->GetRows();
            foreach($x as $z) {
                // $id = $z['id'];
                $z['thumbs1'] = str_replace($anterior,$nueva,$z['thumbs1']);
                $z['thumbs2'] = str_replace($anterior,$nueva,$z['thumbs2']);
                $z['thumbs3'] = str_replace($anterior,$nueva,$z['thumbs3']);
                $z['thumbs4'] = str_replace($anterior,$nueva,$z['thumbs4']);
                $z['thumbs5'] = str_replace($anterior,$nueva,$z['thumbs5']);
                $z['copete1'] = str_replace($anterior,$nueva,$z['copete1']);
                $z['copete2'] = str_replace($anterior,$nueva,$z['copete2']);
                $z['copete3'] = str_replace($anterior,$nueva,$z['copete3']);
                $z['copete4'] = str_replace($anterior,$nueva,$z['copete4']);
                $z['copete5'] = str_replace($anterior,$nueva,$z['copete5']);
                $z['contenido1'] = str_replace($anterior,$nueva,$z['contenido1']);
                $z['contenido2'] = str_replace($anterior,$nueva,$z['contenido2']);
                $z['contenido3'] = str_replace($anterior,$nueva,$z['contenido3']);
                $z['contenido4'] = str_replace($anterior,$nueva,$z['contenido4']);
                $z['contenido5'] = str_replace($anterior,$nueva,$z['contenido5']);

                $ok = $db->Replace('publicaciones', $z,'id', $autoquote = true); 
/*
                $sql = "update publicaciones set thumbs1='$thumbs1',thumbs2='$thumbs2',thumbs3='$thumbs3',thumbs4='$thumbs4',thumbs5='$thumbs5',
                        copete1='$copete1', copete2='$copete2',copete3='$copete3',copete4='$copete4',copete5='$copete5',
                        contenido1='$contenido1', contenido2='$contenido2', contenido3='$contenido3', contenido4='$contenido4', contenido5='$contenido5' where id='$id'";
                $rs = $db->execute($sql);
*/                
            }            


            //----- Modulos
            $rs = $db->execute("select * from modulos");
            $x = $rs->GetRows();
            foreach($x as $z) {
                $id = $z['id'];
                $descripcion = str_replace($anterior,$nueva,$z['descripcion']);
                $script      = str_replace($anterior,$nueva,$z['script']);
                $sql = "update modulos set descripcion='$descripcion', script='$script' where id='$id'";
                $rs = $db->execute($sql);
            }            
             

            //----- Familias de Productos
            $rs = $db->execute("select * from familias");
            $x = $rs->GetRows();
            foreach($x as $z) {
                $id = $z['id'];
                $thumbs1    = str_replace($anterior,$nueva,$z['thumbs1']);
                $thumbs2    = str_replace($anterior,$nueva,$z['thumbs2']);
                $thumbs3    = str_replace($anterior,$nueva,$z['thumbs3']);
                $thumbs4    = str_replace($anterior,$nueva,$z['thumbs4']);
                $thumbs5    = str_replace($anterior,$nueva,$z['thumbs5']);
                $nombre1    = str_replace($anterior,$nueva,$z['nombre1']);
                $nombre2    = str_replace($anterior,$nueva,$z['nombre2']);
                $nombre3    = str_replace($anterior,$nueva,$z['nombre3']);
                $nombre4    = str_replace($anterior,$nueva,$z['nombre4']);
                $nombre5    = str_replace($anterior,$nueva,$z['nombre5']);
                $cuerpo1 = str_replace($anterior,$nueva,$z['cuerpo1']);
                $cuerpo2 = str_replace($anterior,$nueva,$z['cuerpo2']);
                $cuerpo3 = str_replace($anterior,$nueva,$z['cuerpo3']);
                $cuerpo4 = str_replace($anterior,$nueva,$z['cuerpo4']);
                $cuerpo5 = str_replace($anterior,$nueva,$z['cuerpo5']);
                 $sql = "update familias set thumbs1='$thumbs1',thumbs2='$thumbs2',thumbs3='$thumbs3',thumbs4='$thumbs4',thumbs5='$thumbs5',
                        nombre1='$nombre1', nombre2='$nombre2',nombre3='$nombre3',nombre4='$nombre4',nombre5='$nombre5',
                        cuerpo1='$cuerpo1', cuerpo2='$cuerpo2', cuerpo3='$cuerpo3', cuerpo4='$cuerpo4', cuerpo5='$cuerpo5' where id='$id'";
                $rs = $db->execute($sql);
            }            

            //----- Productos
            $rs = $db->execute("select * from productos");
            $x = $rs->GetRows();
            foreach($x as $z) {
                $id = $z['id'];
                $thumbs1    = str_replace($anterior,$nueva,$z['thumbs']);
                $resumen    = str_replace($anterior,$nueva,$z['resumen']);
                $descripcion    = str_replace($anterior,$nueva,$z['descripcion']);
                $sql = "update productos set thumbs='$thumbs1', resumen='$resumen', descripcion='$descripcion'
                where id='$id'";
                $rs = $db->execute($sql);
            }            

            //----- Solapas
            $rs = $db->execute("select * from solapas");
            $x = $rs->GetRows();
            foreach($x as $z) {
                $id = $z['id'];
                $solapa1    = str_replace($anterior,$nueva,$z['solapa1']);
                $solapa2    = str_replace($anterior,$nueva,$z['solapa2']);
                $solapa3    = str_replace($anterior,$nueva,$z['solapa3']);
                $solapa4    = str_replace($anterior,$nueva,$z['solapa4']);
                $solapa5    = str_replace($anterior,$nueva,$z['solapa5']);
                $sql = "update solapas set solapa1='$solapa1',solapa2='$solapa2',solapa3='$solapa3',solapa4='$solapa4',solapa5='$solapa5' where id='$id'";
                $rs = $db->execute($sql);
            }            


            //----- Galerias de Fotos
            $rs = $db->execute("select * from galerias_fotos");
            $x = $rs->GetRows();
            foreach($x as $z) {
                $id = $z['id'];
                $archivo    = str_replace($anterior,$nueva,$z['archivo']);
                $sql = "update galerias_fotos set archivo='$archivo' where id='$id'";
                $rs = $db->execute($sql);
            }            


            //----- Slides
            $rs = $db->execute("select * from slides");
            $x = $rs->GetRows();
            foreach($x as $z) {

                if (!empty($z['data'])) {

                    $xdata = unserialize($z['data']);
                  
                    $clave = 0;
                    foreach($xdata as $value) {
                        $data[$clave]['imagen'] = str_replace($anterior,$nueva,$value['imagen']); 
                        $data[$clave]['posicion_texto'] = $value['posicion_texto'];
                        $data[$clave]['texto'] = html_entity_decode($value['texto']);
                        $data[$clave]['href'] = $value['href'];
                        $clave++;
                        
                    }
                    $xdata = serialize($data);
    
                    $id = $z['id'];
                    $sql = "update slides set data='$xdata' where id='$id'";
                    $rs = $db->execute($sql);

                    
                }
            }            








            
            $_SESSION['Msg']='Cambios realizados correctamente.';
        }    
	}


	if(!empty($_SESSION['Msg'])) {
	   echo mensaje_ok($_SESSION['Msg']);
		$_SESSION['Msg']='';
	}
?>

<h2>Reemplazo de URL en imagenes</h2>
<center>
<form action='corregir_url.php' method='post'>
<table width='400'>
    <tr>
        <td width="200" class="th">URL Anterior</td>
        <td width='200'><input type='text' name='anterior' value='' size='50'/></td>
    </tr>
    <tr>
        <td width="200" class="th">URL Nueva</td>
        <td width='200'><input type='text' name='nueva' value='<?=URL;?>' size='50'/></td>
    </tr>
	<tr>
		<td colspan="4" align="center"><br />
		<input type="submit" name="submit" value="Comenzar" />
		</td>
	</tr>
</table>
</form>
</center>
		</td>
    </tr>
</table>
</div>
</body></html>