<script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/jquery.validate.js"></script>
<?php if(!empty($Idioma['errores_validacion'])): ?>
    <script type="text/javascript" src="<?php echo URL;?>/js/jquery-validation-1.10.0/localization/<?php echo $Idioma['errores_validacion'];?>"></script>
<?php endif; ?>

<h3 class='h3_titulo_listado'><?php echo $Producto['titulo'];?></h3>  

<table width='360'>
  <tr>
    <td class='lista_alojamientos_imagen' style='width:105px;'>
        <?php if (!empty($Producto['logo'])){ ?>
          <img src='<?php echo $Producto['logo'];?>'>
        <?php } elseif (!empty($Producto['thumbs'])){ ?>
            <img src='<?php echo $Producto['thumbs'];?>'>
        <?php } ?>
    </td>
    <td>
      <div class='datos_contacto' style='width:100%;'>
          <?php if (!empty($Producto['telefono1'])) { echo "<img src='".URL."/img/telefono01.jpg'> {$Producto['telefono1']}"; } ?>
          <?php if (!empty($Producto['telefono2'])) { echo " / {$Producto['telefono2']}"; }?>
          <br><img src='<?php echo URL;?>/img/postal01.jpg'>
          <?php echo $Producto['direccion'];?><br><?php echo $Localidades[$Producto['localidad']];?> (<?php echo $Producto['codigo_postal'];?>)
          <?php if(!empty($Producto['web'])) {?>
          <br><a href='<?php echo $Producto['web'];?>'>Visitar la web del Alojamiento</a>
          <?php } ?>
      </div>
    </td>
  </tr>
</table>
<h3 class='titulo_destacado'>Descripción y Servicios</h3>  
<p><?php echo strip_tags($Producto['resumen']);?></p>
<p><?php echo $Producto['descripcion'];?></p>

<?php if(!empty($Producto['servicios'])) { ?>
    <h2>Servicios y Actividades dentro del Alojamiento</h2>
    <table  border='0'>
        <?php foreach($Producto['servicios'] as $s){ ?>
          <tr>
            <td width='25'><img src='<?php echo $s['icono'];?>' alt='<?php echo $s['servicio'];?>' title='<?php echo $s['servicio'];?>' style='margin:5px;width:25px;' ></td>
            <td width='120'><div class='icono_servicios'><?php echo $s['servicio'];?></div></td>
          </tr>
        <?php } //end foreach ?>    
    </table>

<?php }?>
<?php /*
<h3 class='titulo_destacado'>Formulario de Contacto</h3>  
    <form id="frm_contacto" class="formulario" action='m_formulario.php' method='post'>

        <label><?php echo $Traducciones['frm_apellido'];?><em>*</em></label><br>
        <input id="frm_apellido" name="data[apellido]" class="required" value="<?php echo $apellido;?>"/><br>

        <label><?php echo $Traducciones['frm_nombre'];?><em>*</em></label><br>
        <input id="frm_nombre" name="data[nombre]" class="required" value="<?php echo $nombre;?>"/><br>

        <label><?php echo $Traducciones['frm_email'];?><em>*</em></label><br>
        <input id="frm_email" name="data[email]" class="required email" value="<?php echo $email;?>"/><br>

        <label><?php echo $Traducciones['frm_telefono'];?></label><br>
        <input id="frm_telefono" name="data[telefono]" class="" value="<?php echo $telefono;?>"/><br>



        <label><?php echo $Traducciones['frm_mensaje'];?><em>*</em></label><br>
        <textarea id="frm_mensaje" name="data[comentario]" class="required"><?php echo $mensaje;?></textarea>

        <div id="resultado_form" style='width:290px;height:50px;display:none;'></div>
        <br>
        <input type='text' name='data[captcha]' id='captcha' value='' style='display:none;'/>
        <input type='hidden' name='data[producto_id]' id='producto_id' value='<?php echo $Producto['id'];?>' />
        <input type='submit' id="submit" name='submit' value='<?php echo $Traducciones['frm_enviar'];?>' title="<?php echo $Traducciones['frm_enviar'];?>"/>
        
    </form>

<script type="text/javascript">
    $(document).ready(function() { 
        jQuery("#frm_contacto").validate();

    }); 
     
</script>

*/?>

<?php if(!empty($Producto['imagenes'])) { ?>
    <h3 class='titulo_destacado'>Galería de Imágenes</h3>
    <table  border='0'>
        <?php foreach($Producto['imagenes'] as $s){ ?>
          <tr>
            <td ><img src="<?php echo VER_FOTOS.'/'.$Producto['id'].'/'.$s['imagen'];?>" class='img_galeria'></td>
          </tr>
        <?php } //end foreach ?>    
    </table>
    <script type="text/javascript">
        var ancho = screen.width;

        if (ancho>300) {
          var ancho = 300;
        }
        $(".img_galeria").css({ width: ancho+'px'});
    </script>

<?php }?>

