<script type='text/javascript' src='<?php echo URL;?>/js/jquery-vertical-mega-menu/js/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='<?php echo URL;?>/js/jquery-vertical-mega-menu/js/jquery.dcverticalmegamenu.1.3.js'></script>

<link rel="stylesheet" href="<?php echo URL;?>/js/jquery-vertical-mega-menu/css/dcverticalmegamenu.css"    type="text/css" media="screen" /> 


<ul id="mega-1" class="mega-menu">
    <?php foreach($Familias as $Fam) {?>
      <li >
        <a href="#" id='id_<?php echo $Fam['id'];?>' <?php echo $activo;?> ><?php echo $Fam['nombre'];?> [<?php echo $Fam['cuantos'];?>]</a>
        <?php if(!empty($Fam['child'])){ ?>
          <ul style='margin-left:0px;'>
            <?php foreach($Fam['child'] as $child){ ?>
              <li style='width:200px;'><a href="<?php echo $child['url'];?>"><?php echo $child['nombre'];?> [<?php echo $child['cuantos'];?>]</a></li>

            <?php } //end foreach $Fam['child'];?>
          </ul>
        <?php } // endif !empty($Fam['child'] ?>
      </li>

  <?php } //end foreach $Familias ?>
</ul>



<?php /*
<ul id="mega-1" class="mega-menu">
    <li><a href="#">Menu Item A</a>
        <ul style='margin-left:10px;'>
            <li><a href="#">Sub-Header 1</a>
                <ul style='margin-left:0px;'>
                    <li><a href="#">Menu Link</a></li>
                    <li><a href="#">Menu Link</a></li>
                    <li><a href="#">Menu Link</a></li>
                </ul>
            </li>
            <li><a href="#">Sub-Header 2</a>
                <ul style='margin-left:0px;'>
                    <li><a href="#">Menu Link</a></li>
                    <li><a href="#">Menu Link</a></li>
                    <li><a href="#">Menu Link</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li><a href="#">Menu Item N</a>     
                <ul>
                    <li><a href="#">Menu Link</a></li>
                    <li><a href="#">Menu Link</a></li>
                    <li><a href="#">Menu Link</a></li>
                </ul>
    </li>
</ul>
*/ ?>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#mega-1').dcVerticalMegaMenu();


    $("#selector_provincia").change(function () {
        var jurl        = "<?php echo URL;?>";
        var jprovincia  = $("#selector_provincia").val();
        var jfamilia    = "<?php echo $xurl['familia']['url'];?>";
        var jsubfamilia = "<?php echo $xurl['subfamilia']['url'];?>";
        var redireccion = jurl+'/'+jprovincia;
        if (jfamilia!=''){
            redireccion = redireccion + '/'+jfamilia;
            if(jsubfamilia!=''){
                redireccion = redireccion + '/'+jsubfamilia;
            }
        }
        document.location.href=redireccion;

     });

    <?php if(isset($select_ciudades)) { ?>
        $("#selector_ciudad").change(function () {
            var jciudad     = $("#selector_ciudad").val();
            var jurl        = "<?php echo URL;?>";
            var jprovincia  = "<?php echo $xurl['provincia']['url'];?>";
            var jfamilia    = "<?php echo $xurl['familia']['url'];?>";
            var jsubfamilia = "<?php echo $xurl['subfamilia']['url'];?>";
            var redireccion = jurl+'/'+jprovincia+'/'+jciudad;
            if (jfamilia!=''){
                redireccion = redireccion + '/'+jfamilia;
                if(jsubfamilia!=''){
                    redireccion = redireccion + '/'+jsubfamilia;
                }
            }
            document.location.href=redireccion;
        });
    <?php } ?>  


    });
</script>

