<?php
    $item_menu[0] = 5;
    $item_menu[1] = 1;
    $title = 'Editar Familias';    
    if (!defined('URL')) { include('header.php'); }
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }


    $submit = request('submit','');
	$id     = request('id',0);
    $parent_id     = request('parent_id',0);


    if ($_POST['submit']) {

            $data = $_POST['data'];


            $ok = $db->Replace('familias', $data,'id', $autoquote = true); 
            if( $data['id']>0 and $data['parent_id']==0 ) {
                // le asigno a las subfamilias la misma plantilla
                $sql = "update familias set plantilla='{$data['plantilla']}' where parent_id='{$data['id']}'";
                $rs  = $db->Execute($sql);
            }

            if ($ok) { 
                $_SESSION['Msg'] = 'El registro se guardo correctamente.';
                redirect('familias.php?parent_id='.$data['parent_id']);
                exit();die();
               
            } else { 
                $_SESSION['Msg'] = '<br/>ERROR!! No se pudo guardar el registro.'; die();  
            }

        $Familia['parent_id'] = $data['parent_id'];
    } else {
    	$cond 	 = "select * from familias where id=".$id;
    	$rs 	 = $db->SelectLimit($cond, 1);
    	$Familia = $rs->FetchRow();

        if ($id==0){ $Familia['parent_id'] = $parent_id;} 

    }


?>

<link href="<?php echo RUTA;?>/css/texto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo URL;?>/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/js/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/js/ckfinder/boton_ckfinder.js"></script>




<?php	if(!empty($_SESSION['Msg'])) {   echo mensaje_ok($_SESSION['Msg']);	$_SESSION['Msg']=''; } ?>

<center>
<form name='form1' action='familias_editar.php?id=<?php echo $id;?>' method='post' accept-charset="utf-8"> 
<table width='1000' cellpadding='3' cellspacing='3' border='0' style="border-width:1px; border-style:solid; border-color:#000000">
	<tr bgcolor='#0271E3' >
		<td colspan='2' align='center'>
			<span style="color:#FFFFFF; font-weight:bold; font-size:14px;">Agregar o Modificar una Familia</span></td>
	</tr>


    <tr><td colspan='2'>	

        	<table width='100%'>
                <tr>
                    <td width='100' align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Depende de:</span></td>                                   
                    <td width='550' align='left'>
<?php                        
    $sql = "select * from familias where parent_id=0 order by nombre1 ASC";
    $rs = $db->Execute($sql);
    $Parent = $rs->GetRows();
    
    $sql_parent = '<select name="data[parent_id]" >';
    $sql_parent.= "<option value=0>Raiz 1er.Nivel</option>";
    foreach($Parent as $pt){
        if ($Familia['parent_id'] == $pt['id']) { $sel = "selected='selected'"; } else {$sel='';}
        $sql_parent.= "<option value='{$pt['id']}' $sel >{$pt['nombre1']}</option>";
    }
    $sql_parent.= "</select>";
    echo $sql_parent;
?>    
                        
                     </td>
                </tr>

        		<tr>
    				<td width='100' align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Nombre:</span></td>									
                    <td width='550' align='left'>
                        <input type='text'  name='data[nombre1]' id="nombre1" value="<?php echo $Familia['nombre1'];?>" size='90' maxlength='200' />
                     </td>
    			</tr>
                <tr>
                    <td width='100' align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Meta Title:</span></td>                                   
                    <td width='550' align='left'>
                        <input type='text'  name='data[metatitle]' id="metatitle" value="<?php echo $Familia['metatitle'];?>" size='90' maxlength='200' />
                     </td>
                </tr>

    			<tr >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">URL Amigable:</span></td>
                    <td align='left'><input type='text' id='urlamigable1'  name='data[urlamigable1]' value='<?php echo $Familia['urlamigable1'];?>' size='90' maxlength='255' /></td>
    			</tr>
    
    			<tr >
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Keywords:</span></td>
                    <td align='left'><input type='text' name='data[keywords1]' id='keywords1' value='<?php echo $Familia['keywords1'];?>' size='90' maxlength='255' /></td>
    			</tr>
                <tr >
                    <td style="color:#000000; font-weight:bold; font-size:12px;text-align:right;">Descripcion:<br><small>Max.250caract</small></td>
                    <td align='left'><textarea name='data[description]' id='descripcion' style='width:500px; height:50px;'><?php echo $Familia['description'];?></textarea></td>
                </tr>
                <tr >
                    <td style="color:#000000; font-weight:bold; font-size:12px;text-align:right;">Precio del Anuncio</td>
                    <td align='left'><input type='text' id='precio'  name='data[precio]' value='<?php echo $Familia['precio'];?>' size='10' maxlength='255' /></td>
                </tr>
                <?php if( $Familia['parent_id']==0 ) {?>
                    <tr >
                        <td style="color:#000000; font-weight:bold; font-size:12px;text-align:right;">Plantilla</td>
                        <td align='left'>
                            <select name='data[plantilla]'>
                                <?php 
                                    $Plantilla['generica']    = 'Generica';
                                    $Plantilla['automotores'] = 'Automotores';
                                    $Plantilla['nautica']     = 'Náutica';                                    
                                    $Plantilla['propiedades'] = 'Propiedades';
                                ?>
                                <option value=''> Seleccione un Plantilla</option>
                                <?php 
                                    foreach($Plantilla as $clave=>$valor){
                                        if ( $Familia['plantilla'] == $clave ){ $sel='selected=selected'; } else { $sel=''; }
                                        echo "<option value='$clave' $sel>$valor</option>";  
                                    }
                                ?>

                            </select>

                        </td>
                    </tr>
                <?php } else { ?>
                    <input type='hidden' name = 'data[plantilla]' value='<?php echo $Familia['plantilla'];?>' >
                <?php }  ?>                
    			<tr> 
    				<td align='right' width='50' ><span style="color:#000000; font-weight:bold; font-size:12px;\">Miniatura:</span></small> 
                        <?php if (!empty($Familia['thumbs1'])){ echo "<img src='{$Familia['thumbs1']}' width='60' height='60' border='1'>";}?>
    				</td>
    
    				<td align='left' valign='top' width='100%'>
                        <input type="text" name="data[thumbs1]" id="thumbs1" size='90' maxlength='255' value="<?php echo $Familia['thumbs1'];?>" />
                		<input type="button" value="Buscar en el servidor" onclick="BrowseServer( 'Images:/', 'thumbs1' );" />
    				</td>
    			</tr>

                <tr >
                    <td style="color:#000000; font-weight:bold; font-size:12px;text-align:right;">Slide</td>
                    <td align='left'>
                        <select name='data[slide_id]'>
                            <option value='0'> Seleccione una banner</option>
                            <?php 
                                $cond   = "select * from slides order by nombre ASC";
                                $rs     = $db->Execute($cond);
                                $banner = $rs->GetRows();
                                foreach($banner as $b){
                                    if ($b['id'] == $Familia['slide_id']){$sel='selected=selected';} else {$sel='';}
                                    echo "<option value='{$b['id']}' $sel> {$b['nombre']}</option>";  
                                }
                            ?>

                        </select>
                    </td>
                </tr>

    			<tr>
    				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;">Sumario<br />

    				<td align='left'>
                        <textarea name='data[cuerpo1]' id='cuerpo1' style="width:800px; height:350px;"  class="ckeditor"><?php echo $Familia['cuerpo1'];?></textarea>
                		<script type="text/javascript">
                           var editor = CKEDITOR.replace( 'cuerpo1' ,{ height: '250px'} );
                	       CKFinder.setupCKEditor( editor, '<?php echo URL;?>/js/ckfinder/' ) ;
                		</script>
                    
                    </td>
    			</tr>

           
            </table>




        <hr/>

	</td></tr>
	<tr bgcolor='#FFFFFF' >
		<td align='center' colspan='2'>
			<input type='hidden' name='data[id]' value='<?php echo $id;?>' />
			<input type='submit' name='submit' value='<< Guardar los cambios >>'/>
		</td>
	</tr>
</table>
</form>
</center>
