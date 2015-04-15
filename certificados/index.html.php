<link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />

    <div class="grid_8" >           
        <!-- Login Form -->


        <form id="frm_certificados" class="formulario" method='post' action='<?php echo URL;?>/certificados/index.php'>
            <h2 >Solicitud de Certificados</h2>
            <p>Para obtener el certificado dispuesto por la entidad organizadora del evento, debe ingresar los siguientes datos utilizados al momento de la inscripción:
            </p>
            <table  style='margin:10px auto;'>
                <tr>
                    <td style='text-align:right;padding:7px 10px; font-weight:bold;'>Evento:</td>
                    <td>
                        <select name="data[evento_id]" class="required" style='width:350px;' >
                            echo "<option value='' selected='selected'>Seleccione el Evento en el cual se registró</option>";
                            <?php
                                if(isset($Eventos) ){
                                    foreach ($Eventos as $evento) {
                                        echo "<option value='{$evento['id']}' >{$evento['titulo']}</option>";
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style='text-align:right;padding:7px 10px; font-weight:bold;'>Correo Electrónico:
                        <input type="hidden" name="frm_url" value="<?php echo $_SERVER['SCRIPT_NAME'];?>" />
                    </td>   
                    <td>
                        <input id="frm_email" type='text'  name="data[email]" class="required email" value="" style='width:337px;'/>
                    </td>
                </tr>
            
                <tr>
                    <td colspan='2'>
                        <input type='submit' id="submit" name='submit' value='Solicitar Certificado' title="Solicitar Certificado" style='padding:8px;'/>
                    </td>
                </tr>
            </table>
        </form>
        
    </div>
</div>
<div class='clear'></div>
<script type="text/javascript">
    $(document).ready(function() { 
        jQuery("#frm_certificados").validate();
    }); 
     
</script>
