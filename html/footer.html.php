	<div class="clear"></div>
	

	<?php if(!$resultado and !$oculta_todo){ ?>	
		<div class='grid_12' style='width:960px; margin:10px auto;'>
			<?php include(ROOT.'/html/inc_carrusel_asociaciones.html.php'); ?>
		</div>
	<?php } ?>
	</div> <!-- end fondo_blanco -->

</div> <!-- end container -->




<div id="footer_out" >
	
	<div id="arriba_footer" class='container_12' >
		<?php if($mostrar_en_home==1){?>
			<div class='grid_6' id='novedades'>
				<?php include(ROOT.'/inc/inc_ultimos_blog.php'); ?>
			</div>
				
			<div class='grid_1' style='vertical-align:top;'>
				&nbsp;
			</div>

			<div class='grid_5'>
				<?php include(ROOT.'/html/megusta_facebook.html.php'); ?>            
			</div>
		<?php } else { echo "&nbsp;";} ?>
	</div>


    <div id="footer" class='container_12'>
    	<div class="grid_4"  >
                <a href="<?php echo URL;?>/index.php" title="<?php echo strip_tags($DatosEmpresa['nombre_empresa'].': '.$DatosEmpresa['slogan']);?>">
                    <img src='<?php echo URL;?>/img/logo_footer.png' style='margin-top:20px;'>
                </a>
				
    	</div>
            <div class='grid_8' id='barra_menu_superior' style='margin-top:35px;'>
                <a href='#' id='btn_suscripcion' class='botones' style='margin-left:130px;'
                data-toggle="tooltip" data-placement="bottom" data-original-title='Suscribase y recibirá las últimas actividades'
                onclick="TINY.box.show({iframe:'<?php echo URL;?>/suscribirse_al_boletin.php',boxid:'frameless',width:700,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}})"
                >Suscribirse al Boletín</a>

                <a href="<?php echo URL;?>/account/registro.php" data-toggle="tooltip" 
                    data-placement="bottom" data-original-title='Regístrese y publique su actividad' 
                    id='agregar_empresa' class='botones'>Regístrese y publique su Actividad</a>

                <?php if(!$login){?>
                    <a id='btn_ingresar' href="<?php echo URL;?>/login.php" class='botones' 
                        data-toggle="tooltip" data-placement="bottom" data-original-title='Acceso Usuarios'>Acceso Usuarios</a>
                <?php } else { ?>
                    <a id='btn_ingresar' class='botones' href="<?php echo URL;?>/account/listar_anuncios.php" 
                        data-toggle="tooltip" data-placement="bottom" data-original-title='Acceder a Mi Cuenta'>Mi Cuenta</a>
                <?php } ?>

            </div>
            <div class='clear'></div>


        <div class="grid_2"  >
            &nbsp;
        </div>

        <div class="grid_3 servicios_footer">
            Servicios <?php echo $DatosEmpresa['nombre_empresa'];?><br>
            &divide; <a href="#" title='Anuncia tu Empresa' rel='nofollow'>Anuncia tu Empresa</a><br>
            &divide; <a href="<?php echo URL;?>/login.php" title='Acceso Usuarios' rel='nofollow'>Acceso Usuarios</a><br>
            &divide; <a href="<?php echo URL;?>/formulario-de-contacto.html" title='Formulario de Contacto' rel='nofollow'>Formulario de Contacto</a><br>
        </div>

        <div class="grid_3 servicios_footer">
            Legales <?php echo $DatosEmpresa['nombre_empresa'];?><br>
            &divide; <a href="<?php echo URL;?>/politicas-de-privacidad.html" title='Política de Privacidad' rel='nofollow'>Política de Privacidad</a><br>
            &divide; <a href="<?php echo URL;?>/terminos-y-condiciones.html" title='Términos y Condiciones' rel='nofollow'>Términos y Condiciones</a><br>
            &divide; <a href="<?php echo URL;?>/proteccion-de-datos.html" title='Protección de Datos' rel='nofollow'>Protección de Datos</a><br>
        </div>

        <div class="grid_4 desarrollo-web" >
            <a href="http://www.TuRespaldo.com.ar" title="Protegidos con: TuRespaldo.com.ar" target="_blank" ><img src='<?php echo URL;?>/img/turespaldo.png' 
                style='width:30px;margin:10px 0px;'></a>
            <br>
            <a href="http://www.FernandoDolci.com.ar" title="Diseño Web y Programación Web: FernandoDolci.com.ar" target="_blank" >
                Diseño Web y Programación Web: FernandoDolci.com.ar
            </a>
            <br>
            <a href="http://www.PiensaEnJulia.com.ar" title="Diseño Web, Posicionamiento y SEO: PiensaEnJulia.com.ar" target="_blank" >
                Diseño Web, Posicionamiento y SEO: PiensaEnJulia.com.ar
            </a>
			
			<?php /* <script type="text/javascript" src="http://www.RosarioAlojamientos.com/api/api_01.js"></script>	 */?>

        </div>    
        <div class="clear"></div>
          
    </div> <!-- div footer -->
	<table style='width:960px;margin:0px auto;margin-bottom:20px;'>
		<tr>
			<td style='width:25%; text-align:center;'>
				<a href='http://www.ClickEvento.com.ar' title='ClickEvento' target='_blank'>
					<img src='<?php echo URL;?>/img/logo-ce-footer.png' style='height:40px; margin-top:20px;'>			
				</a>
			</td>
		
			<td style='width:25%; text-align:center;'>
				<a href='http://www.RosarioGastronomia.com.ar' title='RosarioGastronomia' target='_blank'>
					<img src='<?php echo URL;?>/img/logo-rg-footer.png' style='height:40px; margin-top:20px;'>			
				</a>
			</td>
			<td style='width:25%; text-align:center;'>
				<a href='http://www.CongresosyJornadas.net' title='Congresos y Jornadas' target='_blank'>
					<img src='<?php echo URL;?>/img/logo-cj-footer.png' style='height:40px; margin-top:20px;'>			
				</a>
			</td>
			<td style='width:25%; text-align:center;'>
				<a href='http://www.RosarioAlojamientos.com' title='RosarioAlojamientos' target='_blank'>
					<img src='<?php echo URL;?>/img/logo-ra-footer.png' style='height:40px; margin-top:20px;'>			
				</a>
			</td>
		</tr>
	</table>
</div> <!-- div footer_out -->
<div class="clear"></div>

<?php echo $Google['analytics'];?>
</body>

</html>
