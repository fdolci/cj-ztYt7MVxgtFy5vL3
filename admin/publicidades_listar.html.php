<center>
<?php
    if( isset($_GET['combo_familia']) ) {
        $data = $_GET;
        list( $data['familia_id'], $data['subfamilia_id'] ) = explode( '-', $data['combo_familia'] );
        unset( $data['combo_familia'] );
    } else {
        $data['familia_id'] = $data['subfamilia_id'] = 0 ;
    }


    $Familias = crearArbol(0);
    $parent_id = 0;
    $select_familia = '<select name="combo_familia" id="combo_familia" class="required">';
    $select_familia.= "<option value='0-0' >Página Principal</option>";
    $familia_id = $subfamilia_id = 0;
    foreach($Familias as $dd){

            if( $dd['parent_id']==0 )
            { 
                $familia_id    = $dd['id']; 
                $subfamilia_id = 0; 
            } else { 
                $familia_id    = $dd['parent_id']; 
                $subfamilia_id = $dd['id'];
            }
            $identificador = $familia_id.'-'.$subfamilia_id;
            
            if ($data['familia_id'] == $familia_id and  $data['subfamilia_id'] == $subfamilia_id ) { $sel = "selected='selected'"; } else {$sel='';}

            $separador = "";
            if ($dd['nivel'] == 2 ) {
                $separador = "------";
            } elseif ($dd['nivel'] == 3 ) {
                $separador = "------------";
            } elseif ($dd['nivel'] == 4 ) {
                $separador = "------------------";
            }
            $select_familia.= "<option value='$identificador' $sel >$separador {$dd['nombre1']}</option>";
    }
    $select_familia.= "</select>";


    $cond 		= "select * from publicidades 
                    where   familia_id    = '{$data['familia_id']}' 
                        and subfamilia_id = '{$data['subfamilia_id']}' 
                        and ubicacion     = '$ubicacion' 
                    order by orden ASC";
	$rs 		= $db->Execute($cond);
	$Registros 	= $rs->GetRows();



?>
<form action='publicidades.php' method='get'>
<table width='800' border="0">
    <tr><td colspan="2"><h2>Administrador de Publicidades Lateral Izquierdo</h2></td></tr>    
    <tr>
    <td align='left' nowrap="nowrap" valign="middle">
        Ubicacion: 
            <select name='ubicacion'>
                <option value='top' <?php echo iif($ubicacion=='top', 'selected=selected','');?> >Top</option>
                <option value='central' <?php echo iif($ubicacion=='central', 'selected=selected','');?> >Central</option>
                <option value='left' <?php echo iif($ubicacion=='left', 'selected=selected','');?> >Izquierda</option>
            </select>
    </td>

	<td align='left' nowrap="nowrap" valign="middle">
		Familia a Listar: <?php echo $select_familia;?>
	</td>
    <td><input type='submit' value='Filtrar'></td>
    <td align="right">
        <a href="publicidades_editar.php?id=0&familia_id=<?php echo $data['familia_id'];?>&subfamilia_id=<?php echo $data['subfamilia_id'];?>&ubicacion=<?php echo $ubicacion;?>" class="boton1" title="Crear nueva Publicidad" >Crear nueva Publicidad</a>
    </td>
    
</tr>
</table>
</form>
<script>
    function cambiar(cual,id){
        $.ajax({
          url: '<?php echo URL;?>/ajax/cambiar_estados_publicidades.php?cual='+cual+'&id='+id,
          success: function(data) {
            console.log(data);
            var image = $('#img_'+cual+'_'+id);
            if(data==1){
                image.attr("src", "img/activo.gif");    
                var estado = 1;
            } else {
                image.attr("src", "img/inactivo.gif");    
                var estado = 0;
            }
          }
        });        

        if(cual=='activo'){
            var estado = $('#img_'+cual+'_'+id).attr("src");
            if(estado=='img/activo.gif'){
                $('#eliminar_'+id).show();
            } else {
                $('#eliminar_'+id).hide();
            }
        }
        
    }
</script>
<?php if (!empty($Registros)) { ?>
	<table width='1000' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='30' class="th">ID</td>
			<td width='50' class="th">Orden</td>
			<td width='100' class="th">Acciones</td>
			<td width='40%' class="th">Titulo</td>
            <td width='40%' class="th">Destino</td>
            <td class="th" >Impresiones</td>
            <td class="th" >Click</td>
            <td class="th" >Eliminar</td>
			</tr>

		<?php
            $color = ''; 
            foreach($Registros as $reg) { 
		       if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}  
        ?>
			<tr bgcolor='<?php echo $color;?>' >
				<td align='left' nowrap='nowrap'><?php echo $reg['id'];?></td>

				<td align='center' nowrap='nowrap'>
					<a href='publicidades.php?accion=orden&sube=no&id=<?php echo $reg['id'];?>&familia_id=<?php echo $familia_id;?>' title='Bajar de Nivel' >
						<img src='<?php echo ADMIN;?>img/abajo.gif' border='0' /></a>
					<a href='publicidades.php?accion=orden&sube=si&id=<?php echo $reg['id'];?>&familia_id=<?php echo $familia_id;?>' title='Subir de Nivel' >
						<img src='<?php echo ADMIN;?>img/arriba.gif' border='0' /></a>
				</td>
				<td align='center' nowrap="nowrap">
					<a href='publicidades_editar.php?id=<?php echo $reg['id'];?>&familia_id=<?php echo $familia_id;?>'
						title='Editar esta publicaci&oacute;n'>
						<img src='<?php echo ADMIN;?>img/edit.gif' border='0'/></a>&nbsp;&nbsp;&nbsp;&nbsp;

                    <?php if ($reg['activo']==0){ $img='img/inactivo.gif'; } else { $img='img/activo.gif'; }?>
                    <a href='publicidades.php?accion=estado&id=<?php echo $reg['id'];?>&familia_id=<?php echo $familia_id;?>' >
                        <img src='<?php echo $img;?>' >
                    </a>

				</td>
				<td nowrap="nowrap"><?php echo substr($reg['titulo'],0,50);?></td>
                <td nowrap="nowrap"><?php echo $reg['web'];?></td>
                <td align="right"><?php echo $reg['lecturas'];?></td>
                <td align="right"><?php echo $reg['click'];?></td>
                <td align="right">
                        <?php $display = iif($reg['activo']==1,'none','inline-block');?>
                        <div id='eliminar_<?php echo $reg['id'];?>' style='width:20px;float:right;margin-top:5px;display:<?php echo $display;?>;'>
                            <a href="publicidades.php?accion=eliminar&id=<?php echo $reg['id'];?>&familia_id=<?php echo $familia_id;?>" title='Eliminar'
                                onclick="return confirm('Est&aacute; seguro de eliminar este Registro?\n <?php echo $reg['titulo'];?>');"><img src='img/del.gif'></a>
                        </div>

                </td>
                
			</tr>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Contenidos para mostrar</span>
<?php } ?>
