<div class="container_12" id="cuerpo">
<?php $p5 = publicidad('5'); if(!empty($p5)) { ?>
    <div class="grid_3" id="contenido">
        <?php echo publicidad('5'); ?>
    </div>
    <div class="grid_9" id="contenido">    
<?php } else { ?>
    <div class="grid_12" id="contenido">
<?php } ?>    
        <?php echo publicidad('3'); ?>
        
        <h1><?php echo $Traducciones['titulo_galeria'];?></h1>
      
        <?php if ($Categoria['muestra_cuerpo']==1){
            echo $Categoria['cuerpo'];
        } else {
        ?>
            <table width="100%">
            <?php foreach($Publicaciones as $pub) { ?>        
                <tr>
                    <td style="vertical-align:top;" width="70%">
                        <div class="noticia_principal">
                            <h2><?=$pub['titulo'];?></h2>
                            <?= htmlspecialchars_decode($pub['copete'], ENT_NOQUOTES);?>
                        </div>
                    </td>
                    <td rowspan="2"><img src="<?=$pub['thumbs'];?>" class="foto_lista_categoria_1"/></td>
                                    
                </tr>
                <tr>
                    <td style="text-align:left;">
                            <a href="<?=URL;?><?=$pub['urlamigable'];?>" class='ampliar'><?php echo $Traducciones['ver_galeria'];?></a>
                    </td>
                </tr>
                <tr><td colspan="2"><hr style="border-bottom: 1px dashed #CCC;margin:15px 0px 15px 0px;;"/></td></tr>
            <?php } ?>
            </table>
            

  
        <?php } ?>
        
        <?php echo publicidad('6'); ?>
    </div>
<?php if(!empty($p4)) { ?>
    <div class="grid_3">
        <?php echo $p4; ?>
    </div>
<?php } ?>

     <div class="clear"></div>
    <div class="grid_12"><?php echo publicidad('7'); ?></div>

    
</div>

