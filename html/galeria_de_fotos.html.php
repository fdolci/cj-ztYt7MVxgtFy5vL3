<script language="JavaScript">
<!--
function autoResize(id){
var newheight;
var newwidth;
document.getElementById(id).height= "100px";
if(document.getElementById){
 newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
/* newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth; */
}

document.getElementById(id).height= (newheight) + "px";
/*document.getElementById(id).width= (newwidth) + "px";*/
}
//-->
</script>

<div class="container_12" id="cuerpo">
    <div class="grid_4" >
      <?php //include('./menu_del_dia.php'); ?>
        
      <?php echo publicidad('5'); ?>
    </div>
    <div class="grid_8" id="contenido">
        
        <?php echo publicidad('3'); ?>
        <h1>Galería de Fotos</h1>
        <iframe src="./galeria.php" width='620' height="600" id="iframe1" onLoad="autoResize('iframe1');"></iframe>

        <?php echo publicidad('6'); ?>
    </div>

    <div class="clear"></div>
    <div class="grid_12"><?php echo publicidad('7'); ?></div>

    
</div>