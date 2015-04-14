<!-- AjaxUpload -->
<link rel="stylesheet" href="<?php echo URL;?>/modules/AjaxUpload/css/ajaxupload.css" type="text/css" media="screen" />    
<script type="text/javascript" src="<?php echo URL;?>/modules/AjaxUpload/js/ajaxupload.js"></script>

<!-- Google Maps -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo URL;?>/js/localizacion_carga.js"></script>

<!-- Menu Pestañas -->
<script type="text/javascript" src="<?php echo URL;?>/js/menupestanas/menupestanas.js"></script>
<link rel="stylesheet" href="<?php echo URL;?>/js/menupestanas/menupestanas_v.css" type="text/css" media="screen" />    

<!-- URL Friendly -->
<script type="text/javascript" src="<?php echo URL;?>/js/jFriendly.js"></script>

<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo URL;?>/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/account/mi-tinymce.js"></script>

<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo URL;?>/css/muestra_producto.css" type="text/css" media="screen" />



<script>
   function autoResize(cual){
        var newheight;
        var newwidth;
        document.getElementById(cual).height= "100px";
        if(document.getElementById){
            newheight=document.getElementById(cual).contentWindow.document.body.scrollHeight;
        }
        document.getElementById(cual).height= (newheight) + "px";
    }
</script>


<?php if(!empty($_SESSION['Msg'])) { echo mensaje_ok($_SESSION['Msg']); $_SESSION['Msg']=''; } ?>


<?php include(ROOT.'/account/menu_mi_cuenta.html.php');?>

<form name='frm_aviso' id='frm_aviso' class='formulario' action='<?php echo URL;?>/account/aviso.php' method='post' accept-charset="utf-8" enctype="multipart/form-data"> 

	<?php if($id==0){ ?>
	<div id='mensaje_aviso_nuevo'>
		Cuando cree una actividad nueva, deberá hacerla en 2 pasos:<br>
		1) Complete la pestaña "FICHA".<br>
		2) Guarde los cambios realizados presionando el botón "GUARDAR" que se encuentra en la esquina superior derecha.<br>
		Una vez realizado este proceso, se le habilitará el resto de las pestañas para continuar cargando información.
	</div>
	<?php } ?>
    
	<!-- Muestra errores del validator.js -->
	<div id='summary' ></div>
	
    <ul class="tabs">
		
		<li style='margin-left:0px;border-left:none;'>
			<a href="#p_datos"><img src='<?php echo URL;?>/img/p_ficha.png'  class='img_pesta'> Ficha</a>
		</li>
                
		<?php if ($id>0){?>	
			<li><a href="#p_organiza">
				<img src='<?php echo URL;?>/img/p_organiza.png' class='img_pesta'> <?php echo $tabs_name['organiza'];?></a>
			</li>

			<li><a href="#p_auspicios">
				<img src='<?php echo URL;?>/img/p_auspicios.png' class='img_pesta'> <?php echo $tabs_name['auspicios'];?></a>
			</li>

			<li><a href="#p_autoridades">
				<img src='<?php echo URL;?>/img/p_autoridades.png' class='img_pesta'> <?php echo $tabs_name['autoridades'];?></a>
			</li>


			<li><a href="#p_disertantes">
				<img src='<?php echo URL;?>/img/p_disertantes.png' class='img_pesta'> <?php echo $tabs_name['disertantes'];?></a>
			</li>
			<li><a href="#p_cronograma">
				<img src='<?php echo URL;?>/img/p_cronograma.png' class='img_pesta'> <?php echo $tabs_name['cronograma'];?></a>
			</li>
			<li><a href="#p_areas">
				<img src='<?php echo URL;?>/img/p_areas.png' class='img_pesta'> <?php echo $tabs_name['areas'];?></a>
			</li>
			<li><a href="#p_trabajos">
				<img src='<?php echo URL;?>/img/p_trabajos.png' class='img_pesta'> <?php echo $tabs_name['trabajos'];?></a>
			</li>
			<li><a href="#p_sponsors">
				<img src='<?php echo URL;?>/img/p_sponsors.png' class='img_pesta'> <?php echo $tabs_name['sponsors'];?></a>
			</li>
			<li><a href="#p_inscripcion">
				<img src='<?php echo URL;?>/img/p_inscripcion.png' class='img_pesta'> Inscripción</a>
			</li>
			<li><a href="#p_imagenes">
				<img src='<?php echo URL;?>/img/p_imagenes.png' class='img_pesta'> Imagenes</a>
			</li>
			<li><a href="#p_descargas">
				<img src='<?php echo URL;?>/img/p_descarga.png' class='img_pesta'> Archivos para Descargar</a>
			</li>
			<?php if ( $_SESSION['admin']>0 ){?>
				<!-------------------------------- Si es Admin puede gestionar alojamientos -->
				<li><a href="#p_alojamientos"><img src='<?php echo URL;?>/img/p_alojamientos.png' class='img_pesta'> Turismo/Alojamiento</a></li>

				<!-------------------------------- Si es Admin puede gestionar Gastronomia -->
				<li><a href="#p_gastronomia"><img src='<?php echo URL;?>/img/p_gastronomia.png' class='img_pesta'> Gastronomia</a></li>
			<?php } ?>

			<li><a href="#p_widget">
				<img src='<?php echo URL;?>/img/p_widget.png' class='img_pesta'> Widget</a>
			</li>
			
        <?php } //endif $id==0 ?>
		

	</ul>
    

    <div class="tab_container">
        <div id="p_datos" class="tab_content" style='background:#FFF;'>

            <?php include(ROOT.'/account/aviso_datos.html.php'); ?>
            <?php include(ROOT.'/account/aviso_datos_ubicacion.html.php'); ?>

        </div>
		<?php if ($id>0){?>	

			<?php /*------------------------------------------- ORGANIZACION */?>
			<div id="p_organiza" class="tab_content" style='background:#FFF;'>
				<h3 style='text-align:left;'>Datos de la Organización</h3>
				Nombre a mostrar en esta pestaña: <input type='text' name='tabs_name[organiza]' id='tabs_organiza' maxlength='25' style='width:150px;' value='<?php echo $tabs_name['organiza'];?>' >    
				<textarea name='organiza' id='organiza' ><?php echo $data['organiza'];?></textarea>
			</div>

			<?php /*------------------------------------------- AUSPICIOS */?>
			<div id="p_auspicios" class="tab_content" style='background:#FFF;'>
				<h3 style='text-align:left;'>Auspicios y Declaraciones de Interés</h3>
				Nombre a mostrar en esta pestaña: <input type='text' name='tabs_name[auspicios]' id='tabs_auspicios' maxlength='25' style='width:150px;' value='<?php echo $tabs_name['auspicios'];?>' >    
				<textarea name='auspicios' id='auspicios' ><?php echo $data['auspicios'];?></textarea>
			</div>

			<?php /*------------------------------------------- AUTORIDADES */?>
			<div id="p_autoridades" class="tab_content" style='background:#FFF;text-align:left;'>
				Nombre a mostrar en esta pestaña: <input type='text' name='tabs_name[autoridades]' id='tabs_autoridades' maxlength='25' style='width:150px;' value='<?php echo $tabs_name['autoridades'];?>' >    
				<iframe id='f_autoridades' src='<?php echo URL;?>/account/aviso_autoridades.html.php?producto_id=<?php echo $id;?>' style='width:100%; min-height:600px;' height='600px' 
					   onLoad="autoResize('f_autoridades');" ></iframe> 
			</div>

			<?php /*------------------------------------------- AREAS TEMATICAS */?>			
			<div id="p_areas" class="tab_content" style='background:#FFF;'>
				<h3 style='text-align:left;'>Áreas Temáticas</h3>
				Nombre a mostrar en esta pestaña: <input type='text' name='tabs_name[areas]' id='tabs_areas' maxlength='15'  style='width:105px;' value='<?php echo $tabs_name['areas'];?>' >                    
				<textarea name='areas_tematicas' id='areas_tematicas' ><?php echo $data['areas_tematicas'];?></textarea>
			</div>
			
			<?php /*------------------------------------------- PRESENTACION DE TRABAJOS */?>			
			<div id="p_trabajos" class="tab_content" style='background:#FFF;'>
				<h3 style='text-align:left;'>Presentación de Trabajos</h3>
				Nombre a mostrar en esta pestaña: <input type='text' name='tabs_name[trabajos]' id='tabs_organiza' maxlength='15' style='width:105px;' value='<?php echo $tabs_name['trabajos'];?>' >                    
				<textarea name='trabajos' id='trabajos' ><?php echo $data['trabajos'];?></textarea>
			</div>

			<?php /*------------------------------------------- DISERTANTES */?>			
			<div id="p_disertantes" class="tab_content" style='background:#FFF;text-align:center;'>
				Nombre a mostrar en esta pestaña: <input type='text' name='tabs_name[disertantes]' id='tabs_disertantes' maxlength='25' style='width:150px;' value='<?php echo $tabs_name['disertantes'];?>' >    			
				<iframe id='f_disertantes' src='<?php echo URL;?>/account/aviso_disertantes.html.php?producto_id=<?php echo $id;?>' style='width:100%; min-height:600px;' height='600px' 
					   onLoad="autoResize('f_disertantes');" ></iframe> 
			</div>
			
			<?php /*------------------------------------------- CRONOGRAMA */?>			
			<div id="p_cronograma" class="tab_content" style='background:#FFF;'>
				<h3 style='text-align:left;'>Cronograma</h3>
				Nombre a mostrar en esta pestaña: <input type='text' name='tabs_name[cronograma]' id='tabs_cronograma' maxlength='15' style='width:105px;' value='<?php echo $tabs_name['cronograma'];?>' >    
				<textarea name='cronograma' id='cronograma' ><?php echo $data['cronograma'];?></textarea>
			</div>

			<?php /*------------------------------------------- INSCRIPCION */?>			
			<div id="p_inscripcion" class="tab_content" style='background:#FFF;'>
				<ul class="nav nav-tabs" id="myTab" style='list-style:none;margin-left:0px;'>
				  <li class='active'><a href="#datos_generales" data-toggle="tab">Info General</a></li>
				  <li><a href="#tabla_aranceles" data-toggle="tab">Aranceles</a></li>
				  <li><a href="#formulario_inscripcion" data-toggle="tab">Formulario de Inscripcion</a></li>
				  <li><a href="#medios_de_pago" data-toggle="tab">Medios de Pago</a></li>
				  <li><a href="#ver_formulario_inscripcion" data-toggle="tab">Ver Formulario de Inscripcion</a></li>
				</ul>

				<div class="tab-content">
				  <div class="tab-pane active" id="datos_generales">
					<h3 style='text-align:left;'>Datos Generales para la Inscripción</h3>
					<textarea name='inscripcion' id='inscripcion' style='width:700px;'><?php echo $data['inscripcion'];?></textarea>
				  </div>
				  <div class="tab-pane" id="tabla_aranceles">
					<iframe id='f_aranceles' src='<?php echo URL;?>/account/aviso_aranceles.html.php?producto_id=<?php echo $id;?>&user_id=<?php echo $data['user_id'];?>' style='width:100%; min-height:600px;' height='600px' 
						   onLoad="autoResize('f_aranceles');" ></iframe> 
				  </div>
				  <div class="tab-pane" id="formulario_inscripcion">
					<iframe id='f_inscripcion' src='<?php echo URL;?>/account/aviso_inscripcion.html.php?producto_id=<?php echo $id;?>&user_id=<?php echo $data['user_id'];?>' style='width:100%; min-height:600px;' height='600px' 
					   onLoad="autoResize('f_inscripcion');" ></iframe> 
				  </div>
				  <div class="tab-pane" id="medios_de_pago">
					<iframe id='f_medios_de_pago' src='<?php echo URL;?>/account/aviso_medios_de_pago.html.php?producto_id=<?php echo $id;?>&user_id=<?php echo $data['user_id'];?>' style='width:100%; min-height:600px;' height='600px' 
					   onLoad="autoResize('f_medios_de_pago');" ></iframe> 
				  </div>
				  
				  <div class="tab-pane" id="ver_formulario_inscripcion">
					<iframe id='f_ver_inscripcion' src='<?php echo URL;?>/account/aviso_ver_inscripcion.html.php?producto_id=<?php echo $id;?>&user_id=<?php echo $data['user_id'];?>' style='width:100%; min-height:600px;' height='600px' 
					   onLoad="autoResize('f_ver_inscripcion');" ></iframe> 
				  </div>

				</div>

				

			</div>

			<?php /*------------------------------------------- SPONSORS */?>			
			<div id="p_sponsors" class="tab_content" style='background:#FFF;text-align:left;'>
				Nombre a mostrar en esta pestaña: <input type='text' name='tabs_name[sponsors]' id='tabs_sponsors' maxlength='25' style='width:150px;' value='<?php echo $tabs_name['sponsors'];?>' >    			
				<iframe id='f_sponsors' src='<?php echo URL;?>/account/aviso_sponsors.html.php?producto_id=<?php echo $id;?>' style='width:100%; min-height:600px;' height='600px' 
					   onLoad="autoResize('f_sponsors');" ></iframe> 
			</div>

			<?php /*------------------------------------------- IMAGENES */?>
			<div id="p_imagenes" class="tab_content" style='background:#FFF;'>
									<?php 
										$ajaxupload['tabla'] = 'productos_imagenes';
										$ajaxupload['campo'] = 'producto_id';
										$ajaxupload['id']    = $data['id'];
										$ajaxupload['cual']  = 'galeria';
										$ajaxupload['identificador']  = $identificador;
										$ajaxupload['donde_subir']    = SUBIR_FOTOS;
										$ajaxupload['donde_ver']      = VER_FOTOS;
										$ajaxupload['tn_ancho'] = 150;
										$ajaxupload['tn_alto']  = 110;
										$ajaxupload['ancho']    = 800;
										$ajaxupload['alto']     = 600;
										$datos_ajaxupload = base64_encode( serialize($ajaxupload) );
										include(ROOT.'/modules/AjaxUpload/sube_galeria.html.php'); 
									?>

			</div>

			<?php /*------------------------------------------- DESCARGAS */?>			
			<div id="p_descargas" class="tab_content" style='background:#FFF;'>
				<iframe id='f_descargas' src='<?php echo URL;?>/account/aviso_descargas.html.php?producto_id=<?php echo $id;?>' style='width:100%; min-height:600px;' height='600px' 
					onLoad="autoResize('f_descargas');" ></iframe> 
			</div>

			<?php if ( $_SESSION['admin']>0 ) { ?>
				<?php /*------------------------------------------- ALOJAMIENTOS */?>			
				<div id="p_alojamientos" class="tab_content" style='background:#FFF;'>
					<iframe id='f_alojamientos' src='<?php echo URL;?>/account/aviso_alojamientos.html.php?producto_id=<?php echo $id;?>' style='width:100%; min-height:600px;'  height='600px'
						onLoad="autoResize('f_alojamientos');" ></iframe> 
				</div>
				<?php /*------------------------------------------- GASTRONOMIA */?>			
				<div id="p_gastronomia" class="tab_content" style='background:#FFF;'>
					<iframe id='f_gastronomia' src='<?php echo URL;?>/account/aviso_gastronomia.html.php?producto_id=<?php echo $id;?>' style='width:100%; min-height:600px;'  height='600px'
						onLoad="autoResize('f_gastronomia');" ></iframe> 
				</div>
				
			<?php } ?>   
			
			<?php /*------------------------------------------- WIDGET */?>
			<div id="p_widget" class="tab_content" style='background:#FFF;min-height:500px;'>
				<h3 style='text-align:left;'>Incluir la actividad en su pagina web</h3>
				<br>
				<p>Si desea incoporar esta actividad a su página web (Ejemplo: <a href='http://www.aress.com.ar/congreso2013/' target='blank'>http://www.aress.com.ar/congreso2013</a>), siga los siguientes pasos:</p>
				<br>
				<ul>
					<li>Cree una carpeta (directorio) en su sitio web con el nombre por ejemplo: <b><?php echo strtolower($data['tipo_evento']).date("Y");?></b></li>
					<li>Cree un archivo, dentro de dicha carpeta, llamado <b>index.html</b>.</li>
					<li>
						En el archivo <b>index.html</b> pegue el siguiente texto:<br>
						<textarea style='width:600px;height:350px;text-align:left;font-family:"Courier New";font-size:11px;' onclick="select();">
<title><?php echo $data['titulo'];?></title>
<meta property="og:title" content="<?php echo $data['titulo'];?>" />
<meta property="og:description" content="<?php echo $data['subtitulo'];?>" />
<meta property="og:locale" content="es_ES" />
<meta property="og:site_name" content="<?php echo $data['titulo'].' - '.$data['subtitulo'];?>" />
<meta name='description' content='<?php echo $data['titulo'].' - '.$data['subtitulo'];?>' >
<meta name='keywords' content='<?php echo $data['keywords'];?>' >
<meta name='language' content='es' >
<link rel="stylesheet" href="http://www.congresosyjornadas.net/api/full/css.css" type="text/css" media="screen" /> 
<iframe width='100%' height='100%' src='http://www.congresosyjornadas.net/api/full/index.php?id=<?php echo $data['id'];?>'></iframe>
						</textarea>
					
					</li>
					<li>Guarde los cambios y suba los archivos al servidor.</li>
				<ul>
			</div>
			
			
        <?php } ?>   
		

    </div>

    <br>
    <div style='position:absolute;margin-right:0px;top:100px;width:180px;margin-left:775px;'>
        <input type='hidden' name='id' value='<?php echo $id;?>' />
        <input type='hidden' name='identificador' value='<?php echo $identificador;?>' />
        <input type='submit' id='btn_submit' name='submit' value='<< Guardar >>'  style='width:180px;'>
    </div>
</form>
    
<script>
    $(document).ready(function(){
/*
		$.validator.setDefaults({ ignore: [] });        
        var validator = $("#frm_aviso").validate({
              invalidHandler: function() {
                $("#summary").text("Hay " + validator.numberOfInvalids() + " dato(s) NO valido(s). Por favor revise todas las secciones y complételos. Gracias.");
                $("#summary").show();
                validator.showErrors({"titulo": "Debe ingresar el titulo!"});
              }            
        });
*/
        $("#frm_aviso").validate({
              rules: {
                "titulo" : { required: true },
                "lugar": { required: true },
				"subtitulo": { required: true },
				"familia[0]": { required: true, min:1 },
				"subfamilia[0]": { required: true, min:1 }
              }        
        });




        $("#titulo").jFriendly("#urlamigable",true);


        $('#keywords').keyup(function() {
            var longitud = $(this).val().length;
            var resto = 150 - longitud;
            $('#disponible_keywords').html(resto);
            if(resto <= 0){
            var str= $("#keywords").val();
            str = str.substr(0,150);
                $("#keywords").val( str );
                $("#disponible_keywords").html("0");
            }
        });


        <?php if (empty($data['latitud']) or empty($data['longitud']) ) { ?>

            <?php if (empty($data['direccion']) or empty($data['provincia']) or $data['localidad']==0 ) { ?>
                initialize('<?php echo LATITUD;?>','<?php echo LONGITUD;?>');
            <?php } else { ?>
                var address = '<?php echo $data["direccion"];?>, <?php echo $Localidades[$data["localidad"]];?>, <?php echo $data["provincia"];?>, <?php echo $data["pais"];?>';
                geocoder = new google.maps.Geocoder();
                geocoder.geocode( { 'address': address}, function(results, status) {
                      if (status == google.maps.GeocoderStatus.OK) {
                        //console.log(results);
                        initialize(results[0].geometry.location.Ya,results[0].geometry.location.Za);
                      } else {
                        //alert("Geocode was not successful for the following reason: " + status);
                        initialize('<?php echo LATITUD;?>','<?php echo LONGITUD;?>');
                      }
                });

            <?php } ?>                

        <?php } else { ?>

            initialize("<?php echo $data['latitud'];?>","<?php echo $data['longitud'];?>");
 //       initialize('-32.9507','-60.666');
        
        <?php } ?>    



    });    

</script>
<div class='clear'></div>
