<?php if(!empty($Modulo_4)) {  echo $Modulo_4; } ?>

    <h1><?php echo $Producto['titulo'];?></h1>
    
    <div class='grid_3' style="text-align:center;">
        <img src='<?php echo HOST;?>/<?php echo $Producto['thumbs'];?>' class='img_producto'/>
        <?php if($Config['muestra_precio']=='si') {?>
            <div class='precio_listado'><br />
                <ins><?php echo $Traducciones['precio'];?></ins>&nbsp;
                <?php echo $Traducciones['moneda'];?><?php echo $Producto['precio'];?>.-
                <?php if($Producto['destacado']==1) {?>
                    <img src="<?php echo INST_DIR;?>/archivos/images/destacado.gif" title='Producto Destacado!'/>
                <?php } ?>
            </div>
        <?php } ?>        
        <?php if (!empty($Fotos)) { ?>
            <div class="galeria_fotos_productos">
                <script type="text/javascript">
                    $(function() {
                        	$('#gallery a').lightBox({fixedNavigation:true});
                    });
                </script>    

                <div id="gallery">
                    <?php foreach ($Fotos as $f){ ?>
                        <a href="<?=$f['archivo'];?>" title="<?php echo $f['nombre'];?>">
                        <img src="<?=$f['archivo'];?>" width="100" height="100" alt="<?php echo $f['nombre'];?>" class="galeria_productos" style="margin:2px;"/></a>            
                	<?php } ?>    
                    </div>
            </div>
        <?php } ?>            

    </div>
    
    <div class="grid_6 omega"  style="width:520px;">
        
        <?php echo $Producto['contenido'];?>

        <?php if (!empty($Solapas)) { ?>
        
            <!-- jQuery OrganicTabs -->
            <link rel="stylesheet" href="<?php echo URL;?>/js/organictabs/css/style.css" />
            <script type="text/javascript" src="<?php echo URL;?>/js/organictabs/js/organictabs.jquery.js"></script>
        
            <script>
                $(function() {
            
                    $("#solapas").organicTabs({
                        "speed": 200
                    });
            
                });
            </script>

            <div id="solapas">
                <ul class="nav">            
                <?php 
                    $class = 'class="current"';
                    $cuantos = count($solapas);
                    $i = 1;
                    foreach($Solapas as $solapa) {
                        if ($i == $cuantos) { $liclass = "class = 'last'"; } else {$liclass = '';}
                        echo "<li $liclass><a href='#id_{$solapa['id']}' $class >{$solapa['titulo']}</a></li>";
                        $class = '';
                        $i++;
                        
                    } 
                ?>
                </ul>
            
                <ul class="list-wrap">            
                <?php 
                    $class = '';
                    foreach($Solapas as $solapa) {
                        echo "<ul id='id_{$solapa['id']}' $class>";
                        echo htmlspecialchars_decode(stripslashes($solapa['solapa']));
                        echo "</ul>";
                        $class = ' class="hide"';
                    } 
                ?>
                </ul>
            
            
            </div>
<!--
            <?php foreach($Solapas as $solapa) { ?>
                <div onclick="mostrar('s<?php echo $solapa['id'];?>')" class='titulo_solapa'><?php echo $solapa['titulo'];?></div>
                <div id="s<?php echo $solapa['id'];?>" class='contenido_solapa' ><?php echo $solapa['solapa'];?></div> 
            <?php } ?>
 -->
            
        <?php } ?>            


    </div>


    <div class='clear'></div>
    


   
<?php if(!empty($Modulo_6)) {  
     echo "</div>"; //grid_8   
     echo "<div class='grid_2'>$Modulo_6</div>";
} ?>
<div class="clear"></div>
<?php if(!empty($Modulo_5)) {  echo $Modulo_5; } ?>