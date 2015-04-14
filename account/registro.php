<?php
	include_once('../inc/config.php');

    
    if (esta_login()) { 
        $Mensaje["mensaje"] = "Ud.ya se encuentra registrado en el sistema.";
        $Mensaje["tipo"]    = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje'] = $Mensaje;
        redirect( URL); die();
    }
    
    

    $cat_id = 0;
    $mostrar_en_home = 0;
    include_once(ROOT.'/inc/inc_publicidad.php');

    
    if (isset($_POST['submit'])) {


        $data = $_POST;

      
        if (!empty($data['apellido']) and !empty($data['nombre']) and !empty($data['email']) and !empty($data['password']) ) {


            if ($data['password']!=$data['reingreso']){

                $Mensaje["mensaje"] = "Las contraseñas ingresadas no coinciden.";
                $Mensaje["tipo"]    = 'error';
                $Mensaje["autoclose"] = false;
                $_SESSION['Mensaje'] = $Mensaje;
                $data['password'] = $data['reingreso'] = '';

            } else {

                if($data['acepta_toc']!='on') {
                    $Mensaje["mensaje"] = "Para poder ser un usuario registrado, debe aceptar los Términos y Condiciones.";
                    $Mensaje["tipo"]    = 'error';
                    $Mensaje["autoclose"] = false;
                    $_SESSION['Mensaje'] = $Mensaje;
                    $data['password'] = $data['reingreso'] = '';
                } else {


                    $data['clave']  = md5(trim($data['password']));
                    $data['id'] = 0;
                    $data['email'] = strtolower(trim($data['email']));


                    // Existe ese email?
                    $sql = "select id from usuarios where email='{$data['email']}' ";
                    $rs  = $db->SelectLimit($sql,1);
                    $Existe = $rs->FetchRow();

                    if (!$Existe) {


                        //----------------------------------------------------------
                        //                                 Busco el plan por defecto
                        //----------------------------------------------------------
                        $sql = "select * from planes_usuarios where defecto=1";
                        $rs  = $db->SelectLimit($sql,1);
                        $PlanesUsuarios = $rs->FetchRow();
                        $data['plan_usuario_id'] = $PlanesUsuarios['id'];
                        $data['activo']          = 0;

                        unset($data['password']);
                        unset($data['reingreso']);
                        unset($data['accion']);
                        unset($data['submit']);
                        unset($data['acepta_toc']);

                        $db->debug = false;

                        $ok = $db->AutoExecute('usuarios', $data, 'INSERT');        

                        $sql = "select id from usuarios where email='{$data['email']}' ";
                        $rs  = $db->SelectLimit($sql,1);
                        $Existe = $rs->FetchRow();
                        $user_id = $Existe['id'];


                        //----------------------------------------------------------
                        //                    Busco el Grupo de USuarios por defecto
                        //----------------------------------------------------------
                        $sql = "select * from grupos where defecto=1";
                        $rs  = $db->SelectLimit($sql,1);
                        $GruposUsuarios = $rs->FetchRow();

                        $usuario_grupo['id'] = 0;
                        $usuario_grupo['usuario_id'] = $user_id;
                        $usuario_grupo['grupo_id']   = $GruposUsuarios['id'];
                        $ok = $db->AutoExecute('usuarios_grupos', $usuario_grupo, 'INSERT');        



                        $nombre = $data['apellido'].', '.$data['nombre'];
                        $message   = "";
                        $message .= '<span style="color:black;font-family:Verdana, Tahoma,Arial;font-size:12px;font-weight:normal;" >';
                        $message .= "<b>Apellido y Nombre:</b> $nombre<br>";
                        $message .= "<b>Email:</b> {$data['email']}<br>";
                        
                        $recupero['id']    = $user_id;
                        $recupero['email'] = $data['email'];

                        $datos = base64_encode( serialize($recupero) );
                        $url_recuperar = URL.'/account/activar_registro.php?data='.$datos;

                        $message = 'Para activar su cuenta, por favor haga click en el siguiente enlace, o copie y pegue en el navegador de internet.';
                        $message.= '<br>';
                        $message.= "<a href='$url_recuperar'>$url_recuperar</a>";

                        // ------------------------------------------------------------------- PHP-Mailer
                        $PHPMailer_Ruta     = ROOT.'/modules/PHPMailer_5.2.1/';
                        include($PHPMailer_Ruta."class.phpmailer.php"); 
                        include($PHPMailer_Ruta."class.smtp.php"); 
                        $mail = new PHPMailer(); 

                        $mail->IsSMTP(); 
                        $mail->SMTPAuth   = $PHPMailer['auth']; 
                        $mail->SMTPSecure = $PHPMailer['secure']; 
                        $mail->Host       = $PHPMailer['host']; 
                        $mail->Port       = $PHPMailer['port']; 
                        $mail->Username   = $PHPMailer['username']; 
                        $mail->Password   = $PHPMailer['password'];
                        $mail->SMTPDebug  = 1;

                        $mail->SetFrom($DatosEmpresa['email'], "{$DatosEmpresa['nombre_empresa']}"); 

                        //$mail->AddReplyTo("name@yourdomain.com","First Last");

                        $mail->Subject    = 'Activar cuenta en '.$DatosEmpresa['nombre_empresa'];
                        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                        $mail->MsgHTML($message);
                        $mail->AddAddress($data['email'], "$nombre");

                        if($mail->Send()) {
                            $Mensaje["mensaje"] = "Datos guardados correctamente. Se envió un mail a su casilla de correos para confirmar la dirección";
                            $Mensaje["tipo"]    = 'success';
                            $Mensaje["autoclose"] = true;
                            $_SESSION['Mensaje'] = $Mensaje;

                            $registro_ok = true;

                        } else {

                            $Mensaje["mensaje"] = $Traducciones['datos_guardados_no'];
                            $Mensaje["tipo"]    = 'error';
                            $Mensaje["autoclose"] = false;
                            $_SESSION['Mensaje'] = $Mensaje;


                        }                    


                    } else {
                        $Mensaje["mensaje"] = "Ese email ya existe en nuestra base de datos.";
                        $Mensaje["tipo"]    = 'error';
                        $Mensaje["autoclose"] = false;
                        $_SESSION['Mensaje'] = $Mensaje;
                        $data['password'] = $data['reingreso'] = $data['email']  = '';

                    }




                } //endif acepta_toc
            }
            
        } else {
            $Mensaje["mensaje"] = "Debe completar todos los datos obligatorios.";
            $Mensaje["tipo"]    = 'error';
            $Mensaje["autoclose"] = false;
            $_SESSION['Mensaje'] = $Mensaje;
        }
                
    }


    //---------------------------------------------------------------------------------
    //                                                       Arma Select de Provincias
    //---------------------------------------------------------------------------------
    $select_provincia = '<select name="provincia_id" id="provincia_id" class="required" style="line-height:20px;padding:3px;">';
        foreach($Provincias as $dd){
                if ( $data['provincia_id'] == $dd['id'] or $data['provincia_id']==0 or !isset($data)) { 
                    $sel = "selected='selected'"; 
                    $data['provincia_id']   = $dd['id'];
                    $data['provincia_name'] = $dd['locacion'];                    
                } else {
                    $sel='';
                }
                $select_provincia.= "<option value='{$dd['id']}' $sel >{$dd['locacion']}</option>";
        }
        $select_provincia.= "</select>";

        // Obtiene las ciudades
        $sql = "select * from ciudades where parent_id='{$data['provincia_id']}' and activo=1 order by locacion ASC";
        $rs  = $db->Execute($sql);
        $Ciudades = $rs->GetRows();


    //---------------------------------------------------------------------------------
    //                                                         Arma Select de Ciudades (64651)
    //---------------------------------------------------------------------------------
    
    if($data['ciudad_id']==0 or !isset($data['ciudad_id']) ) {$data['ciudad_id']=64651;}    
    $select_ciudad = '<select name="ciudad_id" id="ciudad_id" class="required" style="line-height:20px;padding:3px;">';
        foreach($Ciudades as $dd){
                if ( $data['ciudad_id'] == $dd['id'] ) { 
                    $sel = "selected='selected'"; 
                    $data['ciudad_id']   = $dd['id'];

                } else {
                    $sel='';
                }
                $select_ciudad.= "<option value='{$dd['id']}' $sel >{$dd['locacion']}</option>";
        }
        $select_ciudad.= "</select>";



    

    $mTitle          = 'Formulario de Registro';
    $mDescription    = 'Formulario de Registro en '.$DatosEmpresa['nombre_empresa'];

    $oculta_publicidad_top = true;
    include_once(ROOT.'/html/header.html.php');
    if($registro_ok==true){
        include_once(ROOT.'/account/registro_ok.html.php');    
    } else {
        include_once(ROOT.'/account/registro.html.php');
    }
    
    include_once(ROOT.'/html/footer.html.php');

?>