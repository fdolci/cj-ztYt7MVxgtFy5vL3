<h3 style='text-align:left;margin-bottom:20px;'>Datos de Contacto e informes</h3>

<div class='grid_3 ctitulo' >Web del Evento:</div>
<div class='grid_4'>
    <input type='text'  name='web' id="web" value="<?php echo $data['web'];?>"  style='width:380px;'/>
</div>
<div class='clear'></div>

<div class='grid_3 ctitulo' >Twitter del Evento:</div>
<div class='grid_4'>
    <input type='text'  name='twitter' id="twitter" value="<?php echo $data['twitter'];?>"  style='width:380px;'
		title='Ej: @RosarioAloj' data-placement="right"/>
</div>
<div class='clear'></div>

<div class='grid_3 ctitulo' >Facebook del Evento:</div>
<div class='grid_4'>
    <input type='text'  name='facebook' id="facebook" value="<?php echo $data['facebook'];?>"  style='width:380px;' 
		title='Ej: https://www.facebook.com/Nombre-del-Evento' data-placement="right"/>
</div>
<div class='clear'></div>


<div class='grid_3 ctitulo'>Email para Informes:</div>
<div class='grid_4'>
    <input type='text'  name='email_informes' id="email_informes" value="<?php echo $data['email_informes'];?>" class="email" style='width:380px;'/>
</div>
<div class='clear'></div>
<div class='grid_3 ctitulo'>Email para Inscripción:</div>
<div class='grid_4'>
    <input type='text'  name='email_inscripcion' id="email_inscripcion" value="<?php echo $data['email_inscripcion'];?>" class="email" style='width:380px;'/>
</div>
<div class='clear'></div>
<div class='grid_3 ctitulo'>Teléfono de Consultas e Informes:</div>
<div class='grid_4'>
    <input type='text'  name='telefono' id="telefono" value="<?php echo $data['telefono'];?>" style='width:380px;'/>
</div>
<div class='clear'></div>
<div class='grid_3 ctitulo'>Fax de Consultas e Informes:</div>
<div class='grid_4'>
    <input type='text'  name='fax' id="fax" value="<?php echo $data['fax'];?>" style='width:380px;'/>
</div>
<div class='clear'></div>


<hr style='margin:20px;border-bottom:1px solid #555;'>
<h3 style='text-align:left;margin-bottom:20px;'>Dónde se realizará el Evento</h3>

<div class='grid_1 ctitulo' >Lugar:<em>*</em></div>
<div class='grid_6'>
    <input type='text'  name='lugar' id="lugar" value="<?php echo $data['lugar'];?>" style='width:480px;' class='required'/>
</div>
<div class='clear'></div>

<div class='grid_1 ctitulo' >Provincia:<em>*</em></div>
<div class='grid_3'><?php echo $select_provincia;?></div>
<div class='grid_1 ctitulo' >Loalidad:<em>*</em></div>
<div class='grid_3'><?php echo $select_ciudad;?></div>
<div class='clear'></div>


<div class='grid_1 ctitulo' >Dirección:<em>*</em></div>
<div class='grid_5'>
    <input type='text'  name='direccion' id="direccion" class='required'
	value="<?php echo $data['direccion'];?>" size='40' maxlength='60' onblur="arma_direccion()" style='width:350px;'/>
</div>
<div class='grid_1 ctitulo' >Cód.Postal:</div>
<div class='grid_1'>
    <input type='text'  name='codigo_postal' id="codigo_postal" value="<?php echo $data['codigo_postal'];?>" style='width:70px;' onblur="arma_direccion()"/>
    <input type='hidden'  name='pais' id="pais" value="<?php echo PAIS;?>" />
</div>
<div class='clear'></div>

<div class='grid_8 ' ><br><br> <b>Mapa de Ubicacion</b><br>
            <small>Puede desplazar el puntero del mapa a la ubicación exacta, si la mostrada por la geolocalización, no es correcta.</small>
</div>
<div class='clear'></div>
<div class='grid_8'>
    <div id="map_canvas" style="height: 300px;width: 650px; border:1px solid #333;"></div>
        <table width='100%'>
            <tr>
                <td>Latitud:<input name="latitud" type="text" readonly="readonly" id="txt_latitud" value="<?php echo $data['latitud'];?>" style='width:100px;'/></td>
                <td>Longitud:<input name="longitud" type="text" readonly="readonly" id="txt_longitud" value="<?php echo $data['longitud'];?>"  style='width:100px;'/></td>                    
            </tr>
        </table>
</div>
<div class='clear'></div>

<script>
$(document).ready(function(){
    $('#facebook').tooltip();
	$('#twitter').tooltip();
})

</script>
