<link rel="stylesheet" href="<?php echo URL;?>/css/lector_rss.css"  type="text/css" media="screen" /> 
<div class='grid_3' style='vertical-align:top;'>

    <?php include('./inc/inc_menu_familias.php'); ?>  
</div>
<div class='grid_9' style='vertical-align:top;'>
    
    <!-- SLIDER -->
    <?php echo slide(1); ?>

        <h1 style='margin-top:30px;'>Agenda de Eventos</h1>
        <div class='contenedor_noticias' id='agenda'><img src='<?php echo URL;?>/img/loading.gif'>
            <script type="text/javascript">
                        $.ajax({
                            url: '<?php echo URL;?>/ajax/ajax_xml_parser.php?url=http://rosario.tur.ar/es/rss/canal.php?canal=agenda&utf8=false&decode=true&limite=20',
                            contentType: "text/html; charset=utf-8",
                          success: function(data) {
                            $('#agenda').html(data);
                          }
                        });        
            </script>

        </div>
        <div class='fuente'>Información proporcionada por el <a href='http://www.rosarioturismo.com/es/rss/' target='_blank'>Ente Turístico Rosario (Etur)</a></div>



</div>
