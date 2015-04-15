<?php 
    $pub_a_mostrar = 10;
    
    if ($familia_id>0){             
        // Cuantas publicaciones tiene la categoria?
        $cond    = "select count(id) as cuantas from productos where familia_id='$familia_id' and activo=1  and productos.resumen!='' ";
        $rs      = $db -> SelectLimit($cond,1);
        $cuantas_publicaciones = $rs -> FetchRow();

        if ( $cuantas_publicaciones['cuantas'] > 0 ) {
            $cantidad_de_paginas = ceil( $cuantas_publicaciones['cuantas'] / $pub_a_mostrar);    
        } else {
            $cantidad_de_paginas = 0;
        }
                         
        $desde = ($pagina - 1) * $pub_a_mostrar;

        $cond = "select productos.*, familias.urlamigable1 as fam_url , familias.thumbs1 as fam_img , familias.nombre1 as fam_nombre
                    from productos 
                    left join familias on productos.familia_id = familias.id 
                    where productos.activo=1 and productos.resumen!=''
                        and productos.familia_id='$familia_id' 
                    order by productos.top_10_categoria DESC, productos.valoracion_contenido DESC, productos.titulo ASC";
    } else {

            // Cuantas publicaciones tiene la categoria?
            $cond    = "select count(id) as cuantas from productos where productos.activo= '1'  and productos.resumen!='' ";
            $rs      = $db -> SelectLimit($cond,1);
            $cuantas_publicaciones = $rs -> FetchRow();

            if ( $cuantas_publicaciones['cuantas'] > 0 ) {
                $cantidad_de_paginas = ceil( $cuantas_publicaciones['cuantas'] / $pub_a_mostrar);    
            } else {
                $cantidad_de_paginas = 0;
            }
                         
            $desde = ($pagina - 1) * $pub_a_mostrar;

            $cond = "select productos.*, familias.urlamigable1 as fam_url , familias.thumbs1 as fam_img , familias.nombre1 as fam_nombre
                        from productos 
                        left join familias on productos.familia_id = familias.id 
                        where productos.activo= '1'  and productos.resumen!=''
                        order by productos.top_10_index DESC, productos.valoracion_contenido DESC, productos.titulo ASC";
    }
         
        $rs  = $db -> SelectLimit( $cond, $pub_a_mostrar, $desde );
        $Alojamientos = $rs->GetRows();
         
        if($Alojamientos){
            foreach($Alojamientos as $clave=>$valor){
                include('./modulo_estadistica.php');
                $href = URL.'/'.$valor['fam_url']."/".$valor['urlamigable'].'.html';
                $Alojamientos[$clave]['href'] = $href;
            }
        }

?>

  <?php if(!empty($Alojamientos)) { ?>



        <?php include("mapa_google_home.html.php");?>


		<h3 style='background:#FEBA02;color:#FFF;line-height:30px;font-size:18px;text-align:center;font-weight:normal;'>Listado de Alojamientos</h3>  
		<?php $i=1;?>
		<?php foreach ($Alojamientos as $d){ ?>
            <?php 
                if($familia_id>0){
                    if($d['top_10_categoria']==1){
                        $background = '#FAF2DE';
                    } else {
                        $background = '#FFF';
                    }
                } else {
                    if($d['top_10_index']==1){
                        $background = '#FAF2DE';
                    } else {
                        $background = '#FFF';
                    }
                }
            ?>
            <div class='c1' style='background:<?php echo $background;?>;height:130px;'>
                <div class='lista_alojamientos_imagen'>
                    <?php if(strlen($d['promociones'])>20) {?>
                        <div class='promociones'></div>
                    <?php } ?>
                    <?php if( strlen($d['tarifas'])>20 ) {?>
                        <div class='tarifas'></div>
                    <?php } ?>

    	           <a href='<?php echo $d['href'];?>' title='<?php echo $d['titulo'];?>'>
                        <?php if (!empty($d['thumbs'])){ ?>
    	          		   <img src='<?php echo $d['thumbs'];?>' style='width:150px;height:113px;margin:5px;'>
                        <?php } else { ?>
                            <img src='<?php echo URL;?>/img/logo.png' style='width:150px;height:113px;margin:5px;'>
                        <?php } ?>
    	      	    </a>

                </div>
                <div class='lista_alojamientos_detalle'>
                   <h1><?php echo $d['titulo'];?></h1>
    	           <p style='height:30px;'><?php echo substr($d['resumen'],0,150);?></p>
                    <div class='datos_contacto_top' style='height:45px;overflow:hidden;'>
                        <span style='float:right;'>Categoría: <?php echo $d['fam_nombre'];?></span><br>
                        <?php if (!empty($d['telefono1'])) { echo "<img src='".URL."/img/telefono01.jpg' style='height:12px;width:22px;'> {$d['telefono1']}"; } ?>
                        <?php if (!empty($d['telefono2'])) { echo " / {$d['telefono2']}"; }?>
                        <br><img src='<?php echo URL;?>/img/postal01.jpg'  style='height:12px; width:22px;'>
                        <?php echo $d['direccion'];?> | <?php echo $Localidades[$d['localidad']];?> (<?php echo $d['codigo_postal'];?>)
                         | <?php echo $d['provincia'];?> | <?php echo $d['pais'];?>

                    </div>
    	           <a href='<?php echo $d['href'];?>' title='ver detalles' class='boton'>ver detalles</a>
                </div>
            </div>
            <div class="cl-sombra-grande"></div>
            <div class='clear' style='margin-bottom:10px;'></div>	       
	  <?php } // endforeach  ?>


      <?php include_once('./html/paginador_productos.html.php');  ?>

  <?php } else {  ?>
 	      <h1>No se encontraron resultados</h1>
          <h2>Disculpe las molestias, estamos incorporando nuevos alojamientos.<br>En breve estarán disponibles todas las categorías</h2>
  <?php } // endif !empty destacados  ?>

<?php //pr($Alojamientos);?>