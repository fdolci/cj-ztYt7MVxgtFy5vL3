<?php

    if(isset($xurl['subfamilia']['id'])) {
        $subfamilia_id = $xurl['subfamilia']['id'];
    } elseif(isset($xurl['familia']['id'])) {
        $familia_id = $xurl['familia']['id'];
    } else {
        $familia_id = 0;
        $subfamilia_id = 0;
    }

    $sql = "select * 
			from 
				publicidades 
			where 
				familia_id='$familia_id' 
				and activo='1' 
				and (thumbs!='' or script!='') 
				and ubicacion='left'  
			order by orden ASC";

    $rs  = $db->SelectLimit($sql,10);
    $Registros = $rs->GetRows();

    $ancho = '210px';
    $alto  = '160px';

    if ($Registros){

        foreach ($Registros as $reg){
?>
            <div class='c1'>
                <a href='<?php echo $reg['web'];?>' title='<?php echo $reg['alt'];?>' rel="nofollow" target='_blank'>
                    <img src='<?php echo VER_PUBLICIDAD.'/'.$reg['thumbs'];?>' alt='<?php echo $reg['alt'];?>' style='width:<?php echo $ancho;?>;height:auto;'>
                </a>
            </div>
            <div class="cl-sombra"></div>
<?php
        }

    }
?>