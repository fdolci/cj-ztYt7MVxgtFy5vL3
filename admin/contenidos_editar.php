<?php
    $item_menu[0] = 2;
    $item_menu[1] = 3;

	$mipath='../';
    $title = 'Editar Publicacion';    
    include('header.php');
    if (!isset($_SESSION["admin"])) {redirect("login.php"); exit(); }

    $de_donde = '';
    $submit       = request('submit','');
	$id     	  = request('id',0);
    $categoria_id = request('categoria_id',0);


	//--Arma el select de las categorias
	$cond 	= "select titulo1,id from categorias where activo=1 order by titulo1 ASC";
	$rs 	= $db->Execute($cond);
	$Cate	= $rs->GetRows();
    
	$categoria_nombre='';
	$sCate = "<select name='data[categoria_id]'  >";
	foreach($Cate as $c){
		if($c['id']==$categoria_id) {
			$categoria_nombre	 = $c['titulo1'];
		}
		$sel = iif($c['id']==$categoria_id,'selected="selected"','');
		$sCate.="<option value='".$c['id']."' $sel >".$c['titulo1']."</option>";
	}
	$sCate.= "</select>";



    if (!empty($submit)) {

        include('contenidos_guardar.php');

    } 

    //-- Obtengo la publicacion que estoy editando
   	$rs 	= $db->SelectLimit("select * from publicaciones where id='$id'", 1);
   	$Pub	= $rs->FetchRow();
    $fecha  = $Pub['fecha'];
 
?>

<script type="text/javascript" src="<?php echo URL;?>/admin/contenidos_editar.js"></script>
<script type="text/javascript">
    function muestra(cual){
        console.log(cual);
        document.getElementById('galeria').style.display = 'none';    
        <?php for($i=1; $i<=5; $i++) { ?>
            <?php if( !empty($Idiomas[($i-1)]['name']) ) { ?>
            document.getElementById('idioma<?php echo $i;?>').style.display = 'none';
            <?php } ?>
        <?php } ?>  
              
        document.getElementById(cual).style.display = 'block';
        if(cual == 'galeria') {
            autoResize();
        }
    }

</script>
<!-- Menu Pestañas -->
<script type="text/javascript" src="<?php echo URL;?>/js/menupestanas/menupestanas.js"></script>
<link rel="stylesheet" href="<?php echo URL;?>/js/menupestanas/menupestanas_h.css" type="text/css" media="screen" />    


<link href="<?php echo RUTA;?>/css/texto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo URL;?>/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/js/ckfinder/ckfinder.js"></script>



<?php
	if(!empty($_SESSION['Msg'])) {
	   echo mensaje_ok($_SESSION['Msg']);
		$_SESSION['Msg']='';
	}
?>

<center>
<form name='form1' action='contenidos_editar.php?id=<?php echo $id;?>' method='post' accept-charset="utf-8"> 
<table width='1000' cellpadding='3' cellspacing='3' border='0' style="border-width:1px; border-style:solid; border-color:#000000">
	<tr bgcolor='#0271E3' >
		<td colspan='2' align='center'>
			<span style="color:#FFFFFF; font-weight:bold; font-size:14px;">Agregar o Modificar una Publicación</span></td>
	</tr>


    <tr><td colspan="2">
    <div id='menu_idiomas' >
        <ul>
            <li><a href="#" onclick="muestra('idioma1');"><img src='<?php echo URL.$Idiomas[0]['flag'];?>' border='0' /> <?php echo $Idiomas[0]['name'];?></a></li>
            <?php if( !empty($Idiomas[1]['name'])) { ?>
                <li><a href='#' onclick="muestra('idioma2');"><img src='<?php echo URL.$Idiomas[1]['flag'];?>' border='0' ><?php echo $Idiomas[1]['name'];?></a></li>
            <?php } ?>

            <?php if( !empty($Idiomas[2]['name'])) { ?>
                <li><a href='#' onclick="muestra('idioma3');"><img src='<?php echo URL.$Idiomas[2]['flag'];?>' border='0' ><?php echo $Idiomas[2]['name'];?></a></li>
            <?php } ?>

            <?php if( !empty($Idiomas[3]['name'])) { ?>
                <li><a href='#' onclick="muestra('idioma4');"><img src='<?php echo URL.$Idiomas[3]['flag'];?>' border='0' ><?php echo $Idiomas[3]['name'];?></a></li>
            <?php } ?>

            <?php if( !empty($Idiomas[4]['name'])) { ?>
                <li><a href='#' onclick="muestra('idioma5');"><img src='<?php echo URL.$Idiomas[4]['flag'];?>' border='0' ><?php echo $Idiomas[4]['name'];?></a></li>
            <?php } ?>

            <?php if($id > 0) { ?>
                <li><a href="#" onclick="muestra('galeria');"><img src='img/galeria.gif' border='0' /> Galería de Fotos</a></li>
            <?php } ?>
    </div>
    </td></tr>
	
    <tr>
        <td colspan='2'>	

            <?php for($i=1; $i<=5; $i++) { ?>
                <?php if( !empty($Idiomas[($i-1)]['name']) ) { ?>
                    <?php if($i==1) { $display='block';} else {$display='none';} ?>
            		<div id="idioma<?php echo $i;?>" style="display:<?php echo $display;?>; min-height:500px; ">
                        <img src='<?php echo URL.$Idiomas[($i-1)]['flag'];?>' border='0' />  
                        <strong><?php echo $Idiomas[($i-1)]['name'];?></strong>

                        <ul class="tabs">
                            <li><a href="#idioma<?php echo $i;?>_datos">Datos SEO</a></li>                                               
                            <li><a href="#idioma<?php echo $i;?>_sumario">Sumario</a></li>           
                            <li><a href="#idioma<?php echo $i;?>_contenido">Contenido</a></li>           
                            <li><a href="#idioma<?php echo $i;?>_slide">Slide Cabecera</a></li>           
                        </ul>

                        <div class="tab_container">
                            <div id="idioma<?php echo $i;?>_datos" class="tab_content" style='min-height:400px;'>
                                <?php include('contenidos_editar_datos.php'); ?>
                            </div>
                            <div id="idioma<?php echo $i;?>_sumario" class="tab_content" style='min-height:400px;'>
                                <?php include('contenidos_editar_sumario.php'); ?>
                            </div>
                            <div id="idioma<?php echo $i;?>_contenido" class="tab_content" style='min-height:400px;'>
                                <?php include('contenidos_editar_contenido.php'); ?>
                            </div>
                            <div id="idioma<?php echo $i;?>_slide" class="tab_content" style='min-height:400px;'>
                                <?php include('contenidos_editar_slide.php'); ?>
                            </div>
                         
                        </div>

                    </div>
                <?php } // end if ?>            
            <?php } // end for ?>

        <!-- Galeria de Fotos -->
        <div id="galeria" style="display:none;">
        <img src='img/galeria.gif' border='0' /> <strong>Galería de Fotos</strong><br/>
            <iframe src="pubgaleria_acciones.php?galeria_id=<?php echo $id;?>&color=#D3DFF1" width='1000' height='400' id="iframe1" onLoad="autoResize('iframe1');"
                    style="border:0px; background-color:#D3DFF1;"></iframe>
        </div>

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
