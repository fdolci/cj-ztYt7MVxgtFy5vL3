<?php
    //--------------------------------------------------------------------------------------
    //                                                                      Combo provincias
    //--------------------------------------------------------------------------------------
    if(count($Provincias)<=1) { $style = "style='display:none;'"; } else { $style='';}
    $select_provincias = "<select name='provincia_id' id='selector_provincia' $style >";
    if(count($Provincias)>1) {
        $select_provincias.= "<option value='' >Todas las Provincias</option>";
    } else {
        foreach($Provincias as $clave=>$valor){
            $xurl['provincia']['id']     = $valor['id'];
            $xurl['provincia']['nombre'] = $valor['locacion'];
            $xurl['provincia']['url']    = $clave;
        }
    }
    foreach ($Provincias as $clave=>$valor){
        if($xurl['provincia']['id'] == $valor['id']) { $sel='selected=selected'; } else { $sel=''; }
        $select_provincias.= "<option value='$clave' $sel>{$valor['locacion']}</option>";
    }
    $select_provincias.= "</select>";

    if($xurl['provincia']['id']>0){
        $sql = "select * from ciudades where parent_id='{$xurl['provincia']['id']}' and activo='1' order by locacion ASC";
        $rs  = $db->Execute($sql);
        $Ciudades = $rs->GetRows();

        $select_ciudades = "<select name='ciudad_id' id='selector_ciudad'>";
        $select_ciudades.= "<option value='' >Todas las Ciudades</option>";
            foreach ($Ciudades as $c){
                if($xurl['ciudad']['id'] == $c['id']) { $sel='selected=selected'; } else { $sel=''; }
                $select_ciudades.= "<option value='{$c['urlfriendly']}' $sel>{$c['locacion']}</option>";
            }
        $select_ciudades.= "</select>";
    } else {
        $select_ciudades = "<select name='ciudad_id' id='selector_ciudad'><option value='0' >Todas las Ciudades</option></select>";
    }
?>

<link rel="stylesheet" href="<?php echo URL;?>/css/bloque_busqueda.css" type="text/css" media="screen" />

<div id='bloque_busqueda'>

    <form action="<?php echo URL;?>/buscar.php" method="post" id='formulario_busqueda'>
        <?php echo $select_provincias;?>
        <?php if(isset($select_ciudades)) { echo $select_ciudades; } ?> 

        ombre:
        <input type="text" name="nombre" id="nombre" value ="<?php echo $buscar_nombre;?>" onclick="select();" style='width:270px;'/>
                <input type="submit" class="boton_buscar" value="Buscar" title="Buscar" style='margin-left:20px;margin-bottom:13px;'/>
        
    </form> 
</div>
