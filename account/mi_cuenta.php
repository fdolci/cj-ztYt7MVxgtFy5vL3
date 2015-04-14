<?php
    $mipath='../';
    include ('../inc/config.php'); 

    if(!esta_login()) { 
        $Mensaje["mensaje"] = $Traducciones['login_requerido'];
        $Mensaje["tipo"]    = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje'] = $Mensaje;
        $_SESSION['user_id']  = '';
        redirect(URL);   die();  
    }

    $id = $_SESSION['user_id'];


    if($_POST['submit']){

        $data = $_POST;
        $data['id'] = $id;        

        if(!empty($_FILES['miniatura']['name']) and $data['id']>0) {

            //-------------------------------------------------------------------------------------------------------
            //                                                          Subi una miniatura
            //-------------------------------------------------------------------------------------------------------
            // Subi un archivo válido y no vacio
            // define('SUBIR_FOTOS',   ROOT."/archivos/images/anuncios/" );
            // define('VER_FOTOS',     URL."/archivos/images/anuncios" );

            $ubicacion = SUBIR_FOTOS;
            $x = explode('.',$_FILES['miniatura']['name']);
            $ext = end($x);

            $archivo = 'user-'.$data['id'].'.'.$ext;
            
            if (! move_uploaded_file ($_FILES['miniatura']['tmp_name'], $ubicacion.$archivo)) {   echo "error al subir el archivo";die(); }
            //echo "Archivo enviado: ".$ubicacion.$archivo."<br>";
            $data['miniatura'] = $archivo;

        }



        
        unset($data['submit']);


        $ok = $db->Replace('usuarios', $data,'id', $autoquote = true); 
        if($ok){
            $Mensaje["mensaje"] = 'Los datos se guardaron correctamente!';
            $Mensaje["tipo"]    = 'success';
            $Mensaje["autoclose"] = true;
            $_SESSION['Mensaje'] = $Mensaje;                
        } else {

            $Mensaje["mensaje"] = 'Error al guardar los datos. Intente nuevamente.!';
            $Mensaje["tipo"]    = 'error';
            $Mensaje["autoclose"] = true;
            $_SESSION['Mensaje'] = $Mensaje;                
        }

    }

    $cond   = "select * from usuarios where id='$id'";
    $rs     = $db->SelectLimit($cond, 1);
    $data   = $rs->FetchRow();

        $select_provincia = '<select name="provincia_id" id="provincia_id" class="required" style="line-height:20px;padding:3px;">';
        foreach($Provincias as $dd){
                if ( $data['provincia_id'] == $dd['id'] or $data['provincia_id']==0 or !isset($data)) { 
                    $sel = "selected='selected'"; 
                    $data['provincia_id']   = $dd['id'];
                } else {
                    $sel='';
                }
                $select_provincia.= "<option value='{$dd['id']}' $sel >{$dd['locacion']}</option>";
        }
        $select_provincia.= "</select>";

        // Obtiene las ciudades
        $sql = "select * from ciudades where parent_id='{$data['provincia_id']}' and activo='1' order by locacion ASC";
        $rs  = $db->Execute($sql);
        $Ciudades = $rs->GetRows();

        $select_ciudad = '<select name="ciudad_id" id="ciudad_id" class="required" style="line-height:20px;padding:3px;">';
        foreach($Ciudades as $dd){
                if ( $data['ciudad_id'] == $dd['id'] or $data['ciudad_id']==0 ) { 
                    $sel = "selected='selected'"; 
                    $data['ciudad_id']   = $dd['id'];
                } else {
                    $sel='';
                }
                $select_ciudad.= "<option value='{$dd['id']}' $sel >{$dd['locacion']}</option>";
        }
        $select_ciudad.= "</select>";


        


    
    $cat_id = 0;
    $mostrar_en_home = 0;
    $menu_cta = 'mi_cuenta';
//    include_once(ROOT.'/inc/inc_publicidad.php');

    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/account/mi_cuenta.html.php');

    include_once(ROOT.'/html/footer.html.php');
    die();

?>