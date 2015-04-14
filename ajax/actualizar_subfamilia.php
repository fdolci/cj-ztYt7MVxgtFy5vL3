<?php
    $mipath='../';
	include ('../inc/config.php');

    $familia_id = request('familia_id',0);
    $cual       = $_GET['cual'];

    if( $familia_id>0 ) {
        // Obtiene la Familia
        $sql = "select * from familias where id='$familia_id' ";
        $rs  = $db->SelectLimit($sql,1);
        $x = $rs->FetchRow();
        $plantilla = $x['plantilla'];

        // Obtiene las SubFamilias
        $sql = "select * from familias where parent_id='$familia_id' and activo=1 order by nombre1 ASC";
        $rs  = $db->Execute($sql);
        $SubRubros = $rs->GetRows();

        $select_subrubro = "<select name='subfamilia[$cual]' id='subfamilia_$cual' class='required'>";
        foreach($SubRubros as $dd){
            $select_subrubro.= "<option value='{$dd['id']}' >{$dd['nombre1']}</option>";
        }
        $select_subrubro.= "</select>";

        $respuesta['select_subfamilia'] = $select_subrubro;
        $respuesta['plantilla']         = $plantilla;

        $x = json_encode($respuesta);

        echo $x;
    } else {
        $respuesta['select_subfamilia'] = '';
        $respuesta['plantilla']         = '';
        $x = json_encode($respuesta);
        echo $x;
    }
?>