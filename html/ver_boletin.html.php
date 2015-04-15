<!DOCTYPE html>
<html lang="<?php echo $MetaTags['language'];?>" xml:lang="<?php echo $MetaTags['language'];?>">
<?php include('_meta_tags.html.php'); ?>

<?php include('_css.html.php'); ?>
<link rel="stylesheet" href="<?php echo URL;?>/css/print.css"  type="text/css" media="all" />
<base href="<?php echo URL;?>"/>
</head>


<body>
<div class="container_12">
    <div class="grid_12">
        <?php echo stripslashes($categoria['cuerpo']);?>
    
        <?php echo "<h1>".stripslashes($boletin['titulo']).'</h1>'; ?>
    </div>
    <div class="clear"></div>
   
    <div class="grid_3">
        <?php if(!empty($boletin['thumbs'])){ ?>
                <img src="<?=$boletin['thumbs'];?>" class="foto_thumbs_print"/>
        <?php } ?>
    
        <?php if(!empty($Modulo_5)) { echo $Modulo_5; } ?>
        
    </div>
    
    <div class="grid_9"> 
            <?php if(!empty($boletin['copete'])){ echo stripslashes($boletin['copete']).'<br/>';} ?>
       
            <?php if(!empty($boletin['contenido'])){ echo stripslashes($boletin['contenido'])."<br><br>";} ?>
                        
            <?php if (!empty($Fotos)) { ?>
                <div class="separador">&nbsp;&nbsp;&nbsp;<?php echo $Traducciones['titulo_galeria'];?></div>
                    <div id="gallery">
                        <?php foreach ($Fotos as $f){ ?>
                            <img src="<?php echo HOST.$f['archivo'];?>" width="100" height="100" alt="<?php echo htmlspecialchars_decode($f['nombre'.$idioma_elegido], ENT_NOQUOTES);?>" class="foto_galeria"/>            
                        <?php } ?>    
                    </div>
            <?php } ?>
        
         
    
    </div>
    <div class="clear"></div>

    <hr style="border-top:1px solid #000;"/>
    <div class="grid_5" id="redes_sociales">
        <h2>Síguenos en</h2>
        <?php foreach($RedesSociales as $rs) { ?>
            <a href="<?php echo $rs['url'];?>" target="<?php echo $rs['nombre'];?>" title="<?=$rs['nombre'];?>: <?=$rs['username'];?>">
            <img src="<?php echo HOST. $rs['logo'];?>" style="border:0px; margin:4px; width:30px; height:30px;" alt="<?=$rs['nombre'];?>: <?=$rs['username'];?>" /></a>
            
        <?php } ?>

    </div>
        <div class="grid_7" style="text-align:right;">
            <p style="font-size:12px; color:#000;">
                <a href="<?php echo URL;?>" title="Sitio web"><?php echo URL;?></a><br />
                <a href="<?php echo URL;?>/formulario-de-contacto~1" title="Formulario de Contacto"><?php echo $DatosEmpresa['email'];?></a><br />
                <?php echo $DatosEmpresa['telefono'];?><br />
                <?php echo $DatosEmpresa['localidad'];?> <?php echo $DatosEmpresa['cp'];?> - <?php echo $DatosEmpresa['pais'];?>
            </p>
        </div>


    <div class="clear"></div>
</div>

<div class="clear"></div>
</body>
</html>