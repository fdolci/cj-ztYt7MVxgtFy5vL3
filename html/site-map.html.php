<div class="container_12" id="cuerpo">
    <table width='100%' >
        <tr>
            <?php if(!empty($Modulo_5)) { ?>
                <td > <?php echo $Modulo_5; ?> </td>
            <?php } ?>
            
            <td >
                <?php if(!empty($Modulo_3)) {  echo $Modulo_3; } ?>


              	<?php if(!empty($Pub['titulo'])){ echo "<h1>".$Pub['titulo']."</h1>";} ?>
                
                <hr style="border-bottom: 1px solid #2476C0;"/>
                <br/>
                
                <?php if(!empty($Pub['copete'])){ echo $Pub['copete'];} ?>
                
                <ul class="lista_categoria" >
                <?php 
                foreach($sCategorias as $cat) {
                    echo "<li style=\"padding-top:10px;\"><h2>".$cat['titulo']."</h2><ul style=\"padding-left:30px;\">";
                    foreach($cat['publicaciones'] as $p) {
                        echo "<li ><a href='".$p['urlamigable']."' title='".$p['titulo']."'>".$p['titulo']."</a></li>";     
                    }        
                   echo "</ul></li>";
        
                } ?>

            
            
                <?php if(!empty($Modulo_6)) {  echo $Modulo_6; } ?>
            </td>

            <?php if(!empty($Modulo_4)) { ?>
                <td > <?php echo $Modulo_4; ?> </td>
            <?php } ?>

        </tr>
    
    </table>
    <?php if(!empty($Modulo_7)) {  echo $Modulo_7; } ?>    
    <div class="clear"></div>
</div>