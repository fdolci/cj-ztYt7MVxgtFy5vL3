<?php if ($cantidad_de_paginas > 1) { ?>
    <div id="paginador"  class="pagination pagination-small pagination-right">
    <?php //echo "total de paginas: $cantidad_de_paginas - Actual:$pagina<br>"; ?>
        <ul >
            <?php if($pagina > 1) { $anterior = $pagina-1;?>
                <li><a href="<?php echo "$categoria_href/pag:$anterior";?>" >«</a></li>    
            <?php } ?>
            
            <?php for($i=1; $i <= $cantidad_de_paginas; $i++ ){ 
                    if($pagina == $i){ $clase = 'class="active"'; } else { $clase = '';}    
            ?>
                
                <li><a href="<?php echo "$categoria_href/pag:$i";?>" <?=$clase;?> ><?php echo $i;?></a></li>            
            <?php } ?>
    
            
            <?php if($pagina != $cantidad_de_paginas) { $siguiente = $pagina+1;?>
                <li><a href="<?php echo "$categoria_href/pag:$siguiente";?>" >»</a></li>
            <?php } ?>
        </ul>
    </div>
	
<?php } ?>