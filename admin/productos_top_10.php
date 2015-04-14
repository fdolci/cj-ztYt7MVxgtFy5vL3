<?php
    $item_menu[0] = 5;
    $item_menu[1] = 8 ;
    $title = 'Top 10';    
    include('header.php');

    $familia_id = request('familia_id',0);


    if (!isset($_SESSION["admin"])) {redirect("login.php"); exit(); }

    if(isset($_POST['submit'])){
        //pr($_POST,1);
        $producto_id = $_POST['top_10'];
        $plan_id     = $_POST['plan_id'];
        if ($familia_id==0){
            $cond   = "update productos set top_10_index='1' where id='$producto_id' ";    
        } else {
            $cond   = "update productos set top_10_categoria='1' where id='$producto_id' ";
        }
        $ok     = $db->Execute($cond);

        // Tengo que registrar la fecha de caducidad
        $sql = "select vigencia,importe from planes where id='$plan_id'";
        $rs  = $db->SelectLimit($sql,1);
        $x   = $rs->FetchRow();
        if ($x['vigencia']==0){
            $Pagos['hasta'] = 0;
        } else {
            $Pagos['hasta'] = time()+(60*60*24*$x['vigencia']);    
        }

        // es una publicidad nueva, creo el registro en pagos
        $Pagos['id'] = 0;
        $Pagos['resaltado_id'] = $producto_id;
        $Pagos['desde']         = time();
        $Pagos['importe']       = $x['importe'];
        $Pagos['plan_id']       = $plan_id;
        $ok = $db->Replace('pagos', $Pagos,'id', $autoquote = true); 


    } elseif( $_GET['accion'] and $_GET['accion']=='eliminar'){
        $producto_id = $_GET['id'];
        if ($familia_id==0){
            $cond   = "update productos set top_10_index='0' where id='$producto_id' ";
        } else {
            $cond   = "update productos set top_10_categoria='0' where id='$producto_id' ";
        }
        $ok     = $db->Execute($cond);

    }

    $Familias = crearArbol(0);
    $parent_id = 0;
    $mostrar_familia = "<select name='familia_id' onChange=\"document.location.href='productos_top_10.php?familia_id='+this.value\">";
    $mostrar_familia.= "<option value='0' >Pagina de Inicio</option>";
    foreach($Familias as $dd){
            if ($familia_id == $dd['id']) { $sel = "selected='selected'"; } else {$sel='';}
            
            $separador = "";
            if ($dd['nivel'] == 2 ) {
                $separador = "------";
            } elseif ($dd['nivel'] == 3 ) {
                $separador = "------------";
            } elseif ($dd['nivel'] == 4 ) {
                $separador = "------------------";
            }
            $mostrar_familia.= "<option value='{$dd['id']}' $sel >$separador {$dd['nombre1']}</option>";
    }
    $mostrar_familia.= "</select>";


    if ($familia_id==0){
        $cond = "select productos.*, familias.nombre1
                        from productos 
                        left join familias on productos.familia_id=familias.id
                        where productos.top_10_index = 0
                        order by familias.nombre1 ASC, productos.titulo ASC";
    
        $sql = "select productos.*, familias.nombre1 as fam_nombre 
                    from productos 
                    left join familias on productos.familia_id=familias.id
                    where productos.top_10_index = 1
                    order by productos.titulo ASC";
        $ubicacion = 'RH';

    } else {
        $cond       = "select productos.*
                        from productos 
                        where productos.top_10_categoria = 0 and familia_id='$familia_id'
                        order by productos.titulo ASC";
        $sql = "select productos.*
                    from productos 
                    where productos.top_10_categoria = 1  and familia_id='$familia_id'
                    order by productos.titulo ASC";
        $ubicacion = 'RI';
    }
    $rs         = $db->Execute($cond);
    $ComboAlojamientos  = $rs->GetRows();


	$rs 		= $db->Execute($sql);
	$Productos 	= $rs->GetRows();

    // -ARMA LOS SELECT DE LOS PLANES
    $sql = "select * from planes where ubicacion='$ubicacion' and activo=1";
    $rs  = $db->Execute($sql);
    $Planes = $rs->GetRows();
    $select_plan = '<select name="plan_id" >';
    foreach($Planes as $dd){
        $select_plan.= "<option value='{$dd['id']}' $sel >{$dd['plan']} -> {$dd['vigencia']}días -> {$dd['importe']}$</option>";
    }
    $select_plan.= "</select>";


?>
<h2>Top 10 </h2>

<form action='productos_top_10.php' method='post' style='width:1000px;'>
    Familia: <?php echo $mostrar_familia;?><br>
    Agregar Nuevo Anunciante al Top10: 
    <select name='top_10'>
<?php foreach($ComboAlojamientos as $c){?>
        <option value='<?php echo $c['id'];?>'><?php echo $c['nombre1'];?> -> <?php echo $c['titulo'];?></option>
<?php } //endforeach ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Plan: <?php echo $select_plan;?>
    <input type = 'submit' name='submit' value='Agregar'>
</form>

<?php if (!empty($Productos)) { ?>
	<table width='1000' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='30' class="th" >ID</td>
			<td width='100' class="th">Acciones</td>
			<td width='60' class="th">Update</td>
			<td width='40%' class="th">Titulo</td>
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
                        <?php echo $producto['id'];?>
                </td>
				<td align='center' nowrap="nowrap">
					<a href='productos_editar.php?id=<?php echo $producto['id'];?>&familia_id=<?php echo $familia_id;?>'
						title='Editar esta publicaci&oacute;n'>
						<img src='<?php echo ADMIN;?>img/edit.gif' border='0'/></a>&nbsp;&nbsp;&nbsp;&nbsp;

    			</td>

				<td nowrap='nowrap'><?php echo date("d-m-Y",$producto['modificado']);?></td>
				<td nowrap="nowrap"><?php echo $producto['fam_nombre'] .' -> '. $producto['titulo'];?></td>
                <td align="right"><?php echo $producto['lecturas'];?></td>
                <td align="right">

                <div id='eliminar_<?php echo $producto['id'];?>' style='width:20px;float:right;margin-top:5px;'>
                    <a href="productos_top_10.php?accion=eliminar&id=<?php echo $producto['id'];?>&familia_id=<?php echo $familia_id;?>" title='Eliminar'
                    onclick="return confirm('Est&aacute; seguro de eliminar este Registro del Top10?\n <?php echo $producto['titulo'];?>');"><img src='img/del.gif'></a>
                </div>

                </td>
                
			</tr>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Contenidos para mostrar</span>
<?php } ?>
