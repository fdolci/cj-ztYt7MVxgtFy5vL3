<?php if ($cantidad_de_paginas > 1) { ?>
    <div id="paginador_producto">
    <?php //echo "total de paginas: $cantidad_de_paginas - Actual:$pagina<br>"; ?>

            <?php if($pagina > 1) { $anterior = $pagina-1;?>
                <a href="listar.php?familia_id=<?php echo $familia_id?>&pagina=1" title='Primera'><<</a>
                <a href="listar.php?familia_id=<?php echo $familia_id?>&pagina=<?php echo $anterior;?>" title='Anterior'><</a>
            <?php } ?>
            
            <?php for($i=1; $i <= $cantidad_de_paginas; $i++ ){ 
                    if($pagina == $i){ $clase = 'class="pag_selected"'; } else { $clase = '';}    
            ?>
                
                <a href="listar.php?familia_id=<?php echo $familia_id?>&pagina=<?php echo $i;?>" <?php echo $clase;?> ><?php echo $i;?></a>
            <?php } ?>
    
            
            <?php if($pagina != $cantidad_de_paginas) { $siguiente = $pagina+1;?>
                <a href="listar.php?familia_id=<?php echo $familia_id?>&pagina=<?php echo $siguiente;?>" title='Siguiente' >></a>
                <a href="listar.php?familia_id=<?php echo $familia_id?>&pagina=<?php echo $cantidad_de_paginas;?>" title='Ultima' >>></a>
            <?php } ?>

    </div>
<?php } ?>
