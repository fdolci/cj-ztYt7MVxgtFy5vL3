<?php
    $mipath='../';
	include ('../inc/config.php');

    $provincia_id = $_GET['provincia_id'];

    // Obtiene las ciudades
        $sql = "select * from ciudades where parent_id='$provincia_id' and activo='1' order by locacion ASC";
        $rs  = $db->Execute($sql);
        $Ciudades = $rs->GetRows();

        $select_ciudad = '<select name="ciudad_id" id="ciudad_id" class="required">';
        $select_ciudad.= "<option value='0' >Todas las Ciudades</option>";
        foreach($Ciudades as $dd){
                if ( $data['ciudad_id'] == $dd['id'] or $data['ciudad_id']==0 ) { 
                    $sel = "selected='selected'"; 
                    $data['ciudad_id']   = $dd['id'];
                    $data['ciudad_name'] = $dd['locacion'];
                } else {
                    $sel='';
                }
                $select_ciudad.= "<option value='{$dd['id']}' $sel >{$dd['locacion']}</option>";
        }
        $select_ciudad.= "</select>";


    echo $select_ciudad;
     
?>