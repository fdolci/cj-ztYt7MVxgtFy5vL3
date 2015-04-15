<link rel="stylesheet" href="<?php echo URL;?>/css/lector_rss.css"  type="text/css" media="screen" /> 
<div class='grid_3' style='vertical-align:top;'>

    <?php include('./inc/inc_menu_familias.php'); ?>  
</div>
<div class='grid_9' style='vertical-align:top;' id='noticias'>

         <h1 style='margin-top:0px;'>Noticias del Ente de Turismo de Rosario</h1>
        <div class='contenedor_noticias' id='etur'><img src='<?php echo URL;?>/img/loading.gif'>
            <script type="text/javascript">
                        $.ajax({
                            url: '<?php echo URL;?>/ajax/ajax_xml_parser.php?url=http://www.rosarioturismo.com/es/rss/canal.php?canal=ultimas_noticias&utf8=false&decode=true&limite=5',
                            contentType: "text/html; charset=utf-8",
                          success: function(data) {
                            $('#etur').html(data);
                          }
                        });        
            </script>

        </div>
        <div class='fuente'>Información proporcionada por el <a href='http://www.rosarioturismo.com/es/rss/' target='_blank'>Ente Turístico Rosario (Etur)</a></div>

<?php /*
        <h1 style='margin-top:30px;'>Artículos de Interés General</h1>
        <div class='contenedor_noticias' id='articulos'><img src='<?php echo URL;?>/img/loading.gif'>
            <script type="text/javascript">
                        $.ajax({
                            url: '<?php echo URL;?>/ajax/ajax_xml_parser.php?url=http://rosario.tur.ar/es/rss/canal.php?canal=articulos&utf8=false&decode=false&limite=5',
                            contentType: "text/html; charset=utf-8",
                          success: function(data) {
                            $('#articulos').html(data);
                          }
                        });        
            </script>

        </div>
        <div class='fuente'>Información proporcionada por el <a href='http://www.rosarioturismo.com/es/rss/' target='_blank'>Ente Turístico Rosario (Etur)</a></div>

*/ ?>
    	<h1 style='margin-top:30px;'>Gacetillas de Prensa</h1>
    	<div class='contenedor_noticias' id='gacetilla'><img src='<?php echo URL;?>/img/loading.gif'>
            <script type="text/javascript">
                        $.ajax({
                            url: '<?php echo URL;?>/ajax/ajax_xml_parser.php?url=http://rosario.tur.ar/es/rss/canal.php?canal=prensa&utf8=false&decode=true&limite=5',
                            contentType: "text/html; charset=utf-8",
                          success: function(data) {
                            $('#gacetilla').html(data);
                          }
                        });        
            </script>

    	</div>
		<div class='fuente'>Información proporcionada por el <a href='http://www.rosarioturismo.com/es/rss/' target='_blank'>Ente Turístico Rosario (Etur)</a></div>



    

</div>
<?php //pr($Noticias); ?>