<div class="grid_12">
    <?php if(!empty($Modulo_5)) { echo "<td >".$Modulo_5."</td>"; }?>
      
    <h1><?php echo $Categoria['titulo'];?></h1>
      
    <?php if ($Categoria['muestra_cuerpo']==1){ echo $Categoria['cuerpo']; } ?>
</div>
<div class='clear'></div>


<?php foreach($Publicaciones as $pub) { ?>        
    <div class="grid_8">
        <div class='fondo_foto_lista_categoria_3'>
            <a href='<?php echo $pub['href'];?>' title='<?php echo $pub['titulo'];?>'>
                <img src="<?php echo $pub['thumbs'];?>"  class='foto_lista_categoria_3'>
            </a>
        </div>
    </div>
    <div class='grid_4 alpha'>    
        <h2><a href='<?php echo $pub['href'];?>' title='<?php echo $pub['titulo'];?>'><?php echo $pub['titulo'];?></a></h2>
        <?php echo $pub['copete'];?>
        <div style="margin-top:10px;">
            <a href="<?php echo $pub['href'];?>" class='ampliar'><?php echo $Traducciones['mas_detalles'];?></a>
        </div>            
    </div>

    <div class="clear"></div>
    <hr style="border-bottom: 1px dashed #CCC;margin:0px 0px 20px 0px;"/>

<?php } //end foreach ?>

<div class="clear"></div>
