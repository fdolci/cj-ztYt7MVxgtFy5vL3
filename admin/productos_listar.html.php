<center>
<?php

    // Rubros
    $sql = "select * from familias where parent_id=0 and activo=1 order by nombre1 ASC";
    $rs  = $db->Execute($sql);
    $Rubros = $rs->GetRows();

    $select_rubro = "<select name='familia' id='familia'>";
    $select_rubro.= "<option value='0' >Seleccione una Categoria</option>";
    foreach($Rubros as $ru){
            if( $familia == $ru['id'] ) {
                $sel = 'selected=selected';
            } else {
                $sel = '';
            }
            $select_rubro.= "<option value='{$ru['id']}' $sel >{$ru['nombre1']}</option>";
    }
    $select_rubro.= "</select>";

    if( $familia > 0 ) {
        $sql = "select * from familias where parent_id='$familia' and activo=1 order by nombre1 ASC";
        $rs  = $db->Execute($sql);
        $SubRubros = $rs->GetRows();

        $select_subrubro = "<select name='subfamilia' id='subfamilia'>";
        $select_subrubro.= "<option value='0' >Seleccione una Categoria</option>";
        foreach($SubRubros as $sru){
                if( $subfamilia == $sru['id'] ) {
                    $sel = 'selected=selected';
                } else {
                    $sel = '';
                }
                $select_subrubro.= "<option value='{$sru['id']}' $sel >{$sru['nombre1']}</option>";
        }
        $select_subrubro.= "</select>";

    } else {
        $select_subrubro = "<select name='subfamilia' id='subfamilia'></select>";    
    }
    


    $cond 		= "select productos.* from productos 
                    left join productos_familias as pf on productos.id = pf.producto_id
                    where pf.familia_id = '$familia' and pf.subfamilia_id = '$subfamilia' order by productos.titulo ASC";
	$rs 		= $db->Execute($cond);
	$Productos 	= $rs->GetRows();



?>
<form action='productos.php' method='get'>
<table width='800' border="0">
    <tr>
        <td colspan="2"><h2>Administrador de Anuncios</h2></td>
        <td align="right">
            <a href="aviso.php?id=0&familia=<?php echo $familia;?>&subfamilia=<?php echo $subfamilia;?>" class="boton1" title="Crear nuevo Producto" >Crear nuevo Producto</a>
        </td>

    </tr>    
    <tr>
    	<td align='left' nowrap="nowrap" valign="middle">
    		Familia a Listar: <?php echo $select_rubro;?>
    	</td>
        <td align='left' nowrap="nowrap" valign="middle">
            Subfamilia: <?php echo $select_subrubro;?>
        </td>
        <td align="right">
            <input type='submit' value='Listar Anuncios'>
        </td>

    </tr>
</table>
</form>
<script>
    $(document).ready(function(){
           $("#familia").change(function () {
                var familia_id = $("#familia").val();
                $.ajax({
                    type:"GET", //tipo de formato de envio de información
                    url: "<?php echo URL;?>/ajax/actualizar_subfamilia.php?familia_id="+familia_id,
                    success:function(respuesta){
                        $('#subfamilia').html(respuesta);
                    }
                });

            });
    })

    function cambiar(cual,id){
        $.ajax({
          url: '<?php echo URL;?>/ajax/cambiar_estados_productos.php?cual='+cual+'&id='+id,
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
<?php if (!empty($Productos)) { ?>
	<table width='1000' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='30' class="th" colspan='2'>ID</td>
			<td width='50' class="th">Orden</td>
			<td width='100' class="th">Acciones</td>
            <td width='50' class="th">Dest.Home</td>
            <td width='50' class="th">Dest.Categ</td>
			<td width='60' class="th">Update</td>
			<td width='40%' class="th">Titulo</td>
			<td class="th" >URL Amigable</td>
            <td class="th" >Visitas</td>
            <td class="th" >Eliminar</td>
			</tr>

		<?php
            $color = ''; 
            foreach($Productos as $producto) { 
		       if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}  
        ?>
			<tr bgcolor='<?php echo $color;?>' >
				<td align='left' nowrap='nowrap'>
                
                </td>
                <td align='left' nowrap='nowrap'>
                    <?php if ($producto['destacado']==1){echo "<img src='".ADMIN."img/destacado.png' width='18' border='0' title='Producto destacado'/>";}?>
                </td>
				<td align='center' nowrap='nowrap'>
					<a href='productos_orden.php?sube=no&id=<?php echo $producto['id'];?>&familia_id=<?php echo $familia_id;?>' title='Bajar de Nivel' >
						<img src='<?php echo ADMIN;?>img/abajo.gif' border='0' /></a>
					<a href='productos_orden.php?sube=si&id=<?php echo $producto['id'];?>&familia_id=<?php echo $familia_id;?>' title='Subir de Nivel' >
						<img src='<?php echo ADMIN;?>img/arriba.gif' border='0' /></a>
				</td>
				<td align='center' nowrap="nowrap">
					<a href='aviso.php?id=<?php echo $producto['id'];?>&familia=<?php echo $familia;?>&subfamilia=<?php echo $subfamilia;?>'
						title='Editar esta publicaci&oacute;n'>
						<img src='<?php echo ADMIN;?>img/edit.gif' border='0'/></a>&nbsp;&nbsp;&nbsp;&nbsp;

                    <?php if ($producto['activo']==0){ $img='img/inactivo.gif'; } else { $img='img/activo.gif'; }?>
                    <img src='<?php echo $img;?>' onclick="javascript:cambiar('activo',<?php echo $producto['id'];?>);" style='cursor:pointer;' title='Cambiar' id='img_activo_<?php echo $producto['id'];?>'>

				</td>
                <td align='center' nowrap='nowrap'>
                    <?php if ($producto['destacado_home']==0){ $img='img/inactivo.gif'; } else { $img='img/activo.gif'; }?>
                    <img src='<?php echo $img;?>' onclick="javascript:cambiar('destacado_home',<?php echo $producto['id'];?>);" style='cursor:pointer;' title='Cambiar' id='img_destacado_home_<?php echo $producto['id'];?>'>
                </td>        
                <td align='center' nowrap='nowrap'>
                    <?php if ($producto['destacado_categoria']==0){ $img='img/inactivo.gif'; } else { $img='img/activo.gif'; }?>
                    <img src='<?php echo $img;?>' onclick="javascript:cambiar('destacado_categoria',<?php echo $producto['id'];?>);" style='cursor:pointer;' title='Cambiar' id='img_destacado_categoria_<?php echo $producto['id'];?>'>
                </td>        

				<td nowrap='nowrap'><?php echo date("d-m-Y",$producto['modificado']);?></td>
				<td nowrap="nowrap"><?php echo substr($producto['titulo'],0,50);?></td>
				<td nowrap="nowrap"><?php echo substr($producto['urlamigable'],0,50);?></td>
                <td align="right"><?php echo $producto['lecturas'];?></td>
                <td align="right">

                        <?php $display = iif($producto['activo']==1,'none','inline-block');?>
                        <div id='eliminar_<?php echo $producto['id'];?>' style='width:20px;float:right;margin-top:5px;display:<?php echo $display;?>;'>
                            <a href="productos.php?accion=eliminar&id=<?php echo $producto['id'];?>&familia_id=<?php echo $familia_id;?>" title='Eliminar'
                                onclick="return confirm('Est&aacute; seguro de eliminar este Registro?\n <?php echo $producto['titulo'];?>');"><img src='img/del.gif'></a>
                        </div>

                </td>
                
			</tr>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Contenidos para mostrar</span>
<?php } ?>
