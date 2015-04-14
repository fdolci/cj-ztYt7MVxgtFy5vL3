Slide:
    <select name='data[slide_id]'>
        <option value='0'> Seleccione una banner</option>
        <?php 
            $cond   = "select * from slides order by nombre ASC";
            $rs     = $db->Execute($cond);
            $banner = $rs->GetRows();
            foreach($banner as $b){
                if ($b['id'] == $Pub['slide_id']){$sel='selected=selected';} else {$sel='';}
                echo "<option value='{$b['id']}' $sel> {$b['nombre']}</option>";  
            }
        ?>
    </select>
