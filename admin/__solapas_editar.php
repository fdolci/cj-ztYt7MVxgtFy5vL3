<?php

	$mipath='../';
	include ('../inc/config.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$producto_id = request('producto_id',0);
    $solapa_id   = request('solapa_id',0);
	$accion      = request('accion','');    

    if ($accion == 'grabar') {
        $titulo1	= htmlspecialchars(addslashes(request('titulo1','')));
        $titulo2	= htmlspecialchars(addslashes(request('titulo2','')));
        $titulo3	= htmlspecialchars(addslashes(request('titulo3','')));
        $titulo4	= htmlspecialchars(addslashes(request('titulo4','')));
        $titulo5	= htmlspecialchars(addslashes(request('titulo5','')));
                            
        $solapa1	= addslashes(request('solapa1',''));
        $solapa2	= addslashes(request('solapa2',''));
        $solapa3	= addslashes(request('solapa3',''));
        $solapa4	= addslashes(request('solapa4',''));
        $solapa5	= addslashes(request('solapa5',''));

        if ($solapa_id == 0 ){
            $sql = "insert into solapas (producto_id) values ('$producto_id')";
            $ok 	= $db->Execute($sql);
            $solapa_id   = mysql_insert_id();

        }
        
        $sql = "update solapas set 
                titulo1 = '$titulo1',
                titulo2 = '$titulo2', 
                titulo3 = '$titulo3', 
                titulo4 = '$titulo4', 
                titulo5 = '$titulo5',
                solapa1 = '$solapa1',   
                solapa2 = '$solapa2',
                solapa3 = '$solapa3',
                solapa4 = '$solapa4',
                solapa5 = '$solapa5'
                where id = '$solapa_id'";
        $ok 	= $db->Execute($sql);       
                 
        redirect("solapas_acciones.php?producto_id=".$producto_id);	exit();
    }


	$cond 	= "select * from solapas where id='$solapa_id' ";
	$rs 	= $db->SelectLimit($cond, 1);
	$Solapa	= $rs->FetchRow();

    $solapa1	       = stripslashes($Solapa['solapa1']);
    $solapa2	       = stripslashes($Solapa['solapa2']);
    $solapa3	       = stripslashes($Solapa['solapa3']);
    $solapa4	       = stripslashes($Solapa['solapa4']);
    $solapa5	       = stripslashes($Solapa['solapa5']);                
	$titulo1		   = $Solapa['titulo1'];
	$titulo2		   = $Solapa['titulo2'];
	$titulo3		   = $Solapa['titulo3'];
	$titulo4		   = $Solapa['titulo4'];
	$titulo5		   = $Solapa['titulo5'];                

?>
<body style="background-color:#81c2c2;">
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

<link href="<?=RUTA;?>/css/texto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo URL;?>/admin/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/admin/js/ckfinder/ckfinder.js"></script>

    <link href="<?=RUTA;?>/css/css.css" rel="stylesheet" type="text/css"/>
    <link href="<?=ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?=ADMIN;?>stylesheet.css" />    

<center>
<form name='form1' action='solapas_editar.php?accion=grabar&solapa_id=<?php echo $solapa_id;?>&producto_id=<?php echo $producto_id;?>' method='post'>
<table width='900' cellpadding='3' cellspacing='3' border='0' style="border-width:1px; border-style:solid; border-color:#000000;background-color:white;">
	<tr bgcolor='#0271E3' >
		<td colspan='2' align='center'>
			<span style="color:#FFFFFF; font-weight:bold; font-size:14px;">Agregar / Modificar una Solapa</span></td>
	</tr>
    <tr><td colspan="2">
    <div id='menu_idiomas'>
        <ul>
            <li><a href="#" onclick="muestra('idioma1');"><img src='<?=URL.$Idiomas[0]['flag'];?>' border='0' /> <?=$Idiomas[0]['name'];?></a></li>
            <? if( !empty($Idiomas[1]['name'])) {echo "<li><a href='#' onclick=\"muestra('idioma2');\"><img src='".URL.$Idiomas[1]['flag']."' border='0' > ".$Idiomas[1]['name']."</a></li>";} ?>
            <? if( !empty($Idiomas[2]['name'])) {echo "<li><a href='#' onclick=\"muestra('idioma3');\"><img src='".URL.$Idiomas[2]['flag']."' border='0' > ".$Idiomas[2]['name']."</a></li>";} ?>
            <? if( !empty($Idiomas[3]['name'])) {echo "<li><a href='#' onclick=\"muestra('idioma4');\"><img src='".URL.$Idiomas[3]['flag']."' border='0' > ".$Idiomas[3]['name']."</a></li>";} ?>
            <? if( !empty($Idiomas[4]['name'])) {echo "<li><a href='#' onclick=\"muestra('idioma5');\"><img src='".URL.$Idiomas[4]['flag']."' border='0' > ".$Idiomas[4]['name']."</a></li>";} ?>                                    
        </ul>
    </div>
    </td></tr>


	<tr><td colspan='2'>
    <?php for($i=1; $i<=5; $i++) { ?>
        <?php if( !empty($Idiomas[($i-1)]['name']) ) { ?>
        <?php if($i==1) { $display='block';} else {$display='none';} ?>
		<div id="idioma<?=$i;?>" style="display:<?=$display;?>; "><img src='<?=URL.$Idiomas[($i-1)]['flag'];?>' border='0' />  <strong><?=$Idiomas[($i-1)]['name'];?></strong>
        <table width='100%'>
			<tr >
				<td align='right'><span style="color:#000000; font-weight:bold; font-size:12px;\">Titulo:</span></td>
                <td align='left'><input type='text' name='titulo<?=$i;?>' id="xtitulo<?=$i;?>" value='<?php echo ${"titulo".$i};?>' size='90' maxlength='255'/></td>
			</tr>
			<tr >
				<td align='right' colspan="2">
                    <span style="color:#000000; font-weight:bold; font-size:12px;\">Cuerpo:</span><br/>
                    <textarea  id='solapa<?=$i;?>' name='solapa<?php echo $i;?>' style="width:600px; height:600px;" class="ckeditor"><?php echo ${"solapa".$i};?></textarea>
            		<script type="text/javascript">
                       var editor = CKEDITOR.replace( 'solapa<?php echo $i;?>' );
            	       CKFinder.setupCKEditor( editor, '<?php echo URL;?>/admin/js/ckfinder/' ) ;
            		</script>
                
                </td>
			</tr>
        </table>    
        </div>
        <?php } ?>
    
    <?php } ?>

	</td></tr>
	<tr >
		<td align='right'></td>
		<td align='center'>
			<input type='hidden' name='solapa_id' value='<?php echo $solapa_id;?>' />
            <input type='hidden' name='producto_id' value='<?php echo $producto_id;?>' />
			<input type='submit' name='submit' value='<< Guardar los cambios de esta solapa >>'/>
            <input type='button' name='salir' value='<< salir sin guardar >>' onclick="javascript:history.back(1)"/>
		</td>
	</tr>
</table>
</form>
</center>