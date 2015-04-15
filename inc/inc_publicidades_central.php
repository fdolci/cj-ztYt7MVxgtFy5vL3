<?php
    if(isset($xurl['subfamilia']['id'])) {
        $familia_id = $xurl['subfamilia']['id'];
    } elseif(isset($xurl['familia']['id'])) {
        $familia_id = $xurl['familia']['id'];
    } else {
        $familia_id = 0;
    }


    $sql = "select * from publicidades where familia_id='$familia_id' and activo='1' and ubicacion='central' and (thumbs!='' or script!='')  order by orden ASC";

    $rs  = $db->SelectLimit($sql,1);
    $xdata = $rs->FetchRow();

    if($xdata){
        $return_slide= "<a href='{$xdata['web']}' target='_blank' title='{$xdata['alt']}'>";
        $return_slide.= "       <img src='".VER_PUBLICIDAD.'/'.$xdata['thumbs']."' alt='{$xdata['alt']}' style='width:$xancho;height:$xalto;margin-bottom:10px;'>";            
        $return_slide.= "       </a>";
        echo $return_slide;
    }

?>