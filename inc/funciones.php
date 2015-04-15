<?php

function redirect($url) {
	echo "<script type=\"text/javascript\">";
	echo " var pagina = '".$url."';";
	echo " document.location.href=pagina;";
	echo "</script>";
    exit();    
}


/*******************************************************************************************
* Condicion iif
*******************************************************************************************/
function iif($condition,$istrue,$isfalse) {
    if ($condition) {
       return $istrue;
    } else {
       return $isfalse;
    }
}


/*******************************************************************************************
* Print_r elegante
*******************************************************************************************/
function pr($array,$die=null) {
	echo '<div style="width:100%;text-align:left; align:left;text-shadow:none;"><pre>';print_r($array); echo "</pre></div>";
	if (isset($die) AND $die==1) {die();}
}


/***************************************************************************************
* Request_var
****************************************************************************************/
function request($variable, $default, $formato=null, $limite=null){
	
	if ( isset($_POST[$variable]) and !empty($_POST[$variable]) ) {
		$valor = $_POST[$variable];

	} elseif ( isset($_GET[$variable]) ) {
		$valor = $_GET[$variable];
	} else {
		$valor = $default;
	}

	switch ($formato){
		case 'html':
			$valor = trim(htmlspecialchars($valor,ENT_QUOTES,'UTF-8')); 
			break;
		case 'ltrim':
			$valor = trim(strtolower($valor));		
			break;
		case 'trim':
			$valor = trim($valor);		
			break;
		case 'int':
			$valor = intval(($valor));		
			break;
			
	}

	if( $limite>0 ) { $valor = substr($valor,0,$limite); }
	
	return $valor;
}




/****************************************************************************************
* cb_fechas arma combo de fechas 
*******************************************************************************************/
/****************************************************************************************
* cb_fechas arma combo de fechas 
*******************************************************************************************/
function cb_fechas($fecha=0,$variable='',$disabled=false,$null=false){
    if ($fecha==0) { 
		if($null==true){
			$fecha = 0;
			$dia = 0;
			$mes = 0;
			$ano = 0;
			
		} else {
			$fecha=time();
			$dia = date("d",$fecha);
			$mes = date("m",$fecha);
			$ano = date("Y",$fecha);
			
		}
	} else {
		$dia = date("d",$fecha);
		$mes = date("m",$fecha);
		$ano = date("Y",$fecha);
	}


    $xmes[1] = 'Enero';
    $xmes[2] = 'Febrero';
    $xmes[3] = 'Marzo';
    $xmes[4] = 'Abril';
    $xmes[5] = 'Mayo';
    $xmes[6] = 'Junio';
    $xmes[7] = 'Julio';
    $xmes[8] = 'Agosto';
    $xmes[9] = 'Septiembre';
    $xmes[10] = 'Octubre';
    $xmes[11] = 'Noviembre';
    $xmes[12] = 'Diciembre';

    if($disabled==true){ $xdisa = 'disabled=disabled'; } else { $xdisa='';}

    
    $cb_dia = "<select name='".$variable."_dia' id='".$variable."_dia' style='line-height:20px; padding:3px; width:60px;' $xdisa>";
	if($null==true){$cb_dia.= "<option value='0' >--</option>";   }
    for ( $i = 1 ; $i <= 31 ; $i ++) {
		if($dia==$i){$sel = 'selected=selected';} else {$sel='';}
		$z = substr("00".$i,-2);
		$cb_dia.= "<option value='$i' $sel>$z</option>";   
	}    
    $cb_dia.= "</select>";

    $cb_mes = "<select name='".$variable."_mes' id='".$variable."_mes' style='line-height:20px; padding:3px;width:110px;' $xdisa>";
	if($null==true){$cb_mes.= "<option value='0' >--</option>";   }
    for ( $i = 1 ; $i <= 12 ; $i ++) {
		if($mes==$i){$sel = 'selected=selected';} else {$sel='';}
		$cb_mes.= "<option value='$i' $sel>".$xmes[$i]."</option>";   
    }    
    $cb_mes.= "</select>";

    $desde = date("Y",time())-1;
    $hasta = date("Y",time())+5;
    $cb_ano = "<select name='".$variable."_ano' id='".$variable."_ano' style='line-height:20px; padding:3px;width:70px;'  $xdisa>";
	if($null==true){$cb_ano.= "<option value='0' >--</option>";   }
    for ( $i = $desde ; $i <= $hasta ; $i ++) {
		if($ano==$i){$sel = 'selected=selected';} else {$sel='';}
		$cb_ano.= "<option value='$i' $sel>$i</option>";   
    }    
    $cb_ano.= "</select>";
    
    $retorna = $cb_dia."-".$cb_mes.'-'.$cb_ano;
    return $retorna;
}


function saca_espacios($url=null){
	$nueva = $url;
	$acentos = array("ñ","á", "é", "í","ó","ú"," ","_","'",'"');
	$sin   = array("n","a", "e", "i","o","u","-","-","",'');
	$newphrase = strtolower(str_replace($acentos, $sin, $nueva));
	return $newphrase;
}


function fecha_larga($fecha=0){
    if ($fecha==0){ $fecha=time();}

    $dia = date("d",$fecha);
    $m   = date("m",$fecha)*1;
    $ano = date("Y",$fecha);

    $mes[1] = 'Enero';
    $mes[2] = 'Febrero';
    $mes[3] = 'Marzo';
    $mes[4] = 'Abril';
    $mes[5] = 'Mayo';
    $mes[6] = 'Junio';
    $mes[7] = 'Julio';
    $mes[8] = 'Agosto';
    $mes[9] = 'Septiembre';
    $mes[10] = 'Octubre';
    $mes[11] = 'Noviembre';
    $mes[12] = 'Diciembre';

    $fecha_larga = "$dia de {$mes[$m]} de $ano";
    return $fecha_larga;
    die();
}

/*
function hace_thumb($foto,$path){
	ini_set("memory_limit","64M");
    $tn =  time().'_'.$foto;;
	if (strstr($foto,'.gif')){
		copy ($path.$foto,CREA_TN.$tn);
		$dato['ancho'] = 0;
		$dato['alto']  = 0;
	} else {
		$original = imagecreatefromjpeg($path.$foto);
		$thumb = imagecreatetruecolor(150,150); // Lo haremos de un tamaño 150x150
		$dato['ancho'] = imagesx($original);
		$dato['alto'] = imagesy($original);
		imagecopyresampled($thumb,$original,0,0,0,0,150,150,$ancho,$alto);
		imagejpeg($thumb,CREA_TN.$tn,90); // 90 es la calidad de compresión
	}
    $dato['tn'] = $tn;
    return $dato;
}
*/

function sanitize($texto,$saca_espacios=0) {
	$n_texto=str_replace("á","a",$texto);
	$n_texto=str_replace("é","e",$n_texto);
	$n_texto=str_replace("í","i",$n_texto);
	$n_texto=str_replace("ó","o",$n_texto);
	$n_texto=str_replace("ú","u",$n_texto);
    $n_texto=str_replace("'","",$n_texto);
    $n_texto=str_replace('"',"",$n_texto);
    if($saca_espacios==0) {
        $n_texto=str_replace("/","",$n_texto);
        $n_texto=str_replace("\\","",$n_texto);
        $n_texto=saca_espacios($n_texto);    
    }
	return $n_texto;
}


function mensaje(){
    /* tipo = success | error | warning | information*/
    if (isset($_SESSION['Mensaje']) and !empty($_SESSION['Mensaje']['mensaje'])) {
        $Mensaje = $_SESSION['Mensaje'];
        $tipo      = iif(empty($Mensaje['tipo'])     , 'information', $Mensaje['tipo']      );
        $mensaje   = iif(empty($Mensaje['mensaje'])  , ''           , $Mensaje['mensaje']   );
        $autoclose = iif(empty($Mensaje['autoclose']), 'false'       , $Mensaje['autoclose'] );
        $duracion  = iif(empty($Mensaje['duracion']) , '10'         , $Mensaje['duracion']  );
        
        $mensaje = "<script type='text/javascript'>
                showNotification({
                    message: '$mensaje',
                    type: '$tipo',
                    autoClose: '$autoclose',
                    duration: $duracion                                        
                });
            </script>";
        $_SESSION['Mensaje'] = '';    
        return $mensaje;    
    } else {
        return '';
    }
}


function mensaje_ok($texto){
    $a = "<div id='mensaje_ok'>$texto</div>";
    return $a;
}
function mensaje_error($texto){
    $a = "<div id='mensaje_error'>$texto</div>";
    return $a;
}


function esta_login(){
    if ( isset($_SESSION['user_id']) and $_SESSION['user_id']>0 ) { 
        $login = $_SESSION['user_id'];
        $login = true;
    } else {
        $login = false;
    }
    return $login;
}



function busco_categoria_por_url($cadena_busqueda=''){
    global $db;
    $idioma_default = $_SESSION['idioma_default'];    
    $idioma_elegido = $_SESSION['idioma'];
    
	$cond 	= "select * from categorias where ( urlamigable1='$cadena_busqueda' or urlamigable2='$cadena_busqueda' or urlamigable3='$cadena_busqueda' or urlamigable4='$cadena_busqueda' or urlamigable5='$cadena_busqueda' ) and activo=1";

	$rs 	= $db->SelectLimit($cond,1);
	$Categoria	= $rs->FetchRow();
    if(!empty($Categoria)) {
        if ( empty($Categoria['titulo'.$idioma_elegido])   ) { $Categoria['titulo']   = $Categoria['titulo'.$idioma_default];   } else { $Categoria['titulo']   = $Categoria['titulo'.$idioma_elegido];  }
        if ( empty($Categoria['cuerpo'.$idioma_elegido])   ) { $Categoria['cuerpo']   = $Categoria['cuerpo'.$idioma_default];   } else { $Categoria['cuerpo']   = $Categoria['cuerpo'.$idioma_elegido];  }
        if ( empty($Categoria['keywords'.$idioma_elegido]) ) { $Categoria['keywords'] = $Categoria['keywords'.$idioma_default]; } else { $Categoria['keywords'] = $Categoria['keywords'.$idioma_elegido];}
        if ( empty($Categoria['urlamigable'.$idioma_elegido]) ) { $Categoria['urlamigable'] = $Categoria['urlamigable'.$idioma_default]; } else { $Categoria['urlamigable'] = $Categoria['urlamigable'.$idioma_elegido];}
        $Categoria['titulo']    = htmlspecialchars_decode($Categoria['titulo'],ENT_QUOTES);
        $Categoria['cuerpo']    = htmlspecialchars_decode($Categoria['cuerpo'],ENT_QUOTES);
    }
    return $Categoria;
}

function busco_categoria_por_id( $id=0 ){

    global $db;
    $idioma_default = $_SESSION['idioma_default'];    
    $idioma_elegido = $_SESSION['idioma'];
    $id = intval($id);

	$rs 	    = $db->SelectLimit("select * from categorias where id='$id' ",1);
    $Categoria	= $rs->FetchRow();

    if ( empty($Categoria['titulo'.$idioma_elegido])   ) { $Categoria['titulo']   = $Categoria['titulo'.$idioma_default];   } else { $Categoria['titulo']   = $Categoria['titulo'.$idioma_elegido];  }
    if ( empty($Categoria['cuerpo'.$idioma_elegido])   ) { $Categoria['cuerpo']   = $Categoria['cuerpo'.$idioma_default];   } else { $Categoria['cuerpo']   = $Categoria['cuerpo'.$idioma_elegido];  }
    if ( empty($Categoria['keywords'.$idioma_elegido]) ) { $Categoria['keywords'] = $Categoria['keywords'.$idioma_default]; } else { $Categoria['keywords'] = $Categoria['keywords'.$idioma_elegido];}
    if ( empty($Categoria['urlamigable'.$idioma_elegido]) ) { $Categoria['urlamigable'] = $Categoria['urlamigable'.$idioma_default]; } else { $Categoria['urlamigable'] = $Categoria['urlamigable'.$idioma_elegido];}
    $Categoria['titulo']    = htmlspecialchars_decode($Categoria['titulo'],ENT_QUOTES);
    $Categoria['cuerpo']    = htmlspecialchars_decode($Categoria['cuerpo'],ENT_QUOTES);
    return $Categoria;
}


function listar_categoria($id=0, $limite=5,$url_categoria='', $orden='orden DESC'){
    global $db, $idioma_elegido, $idioma_default;

    if (empty($url_categoria)){
        $categoria = busco_categoria_por_id($id);
        $url_categoria = $categoria['urlamigable'];        
    }

    settype($id, 'integer');

	$cond 	 = "select * from publicaciones where categoria_id='$id' and activo=1 order by $orden";
    $rs      = $db->SelectLimit($cond,$limite);
//	$rs 	 = $db->SelectLimit($cond,$limite);
    $retorno = $rs->GetRows();
    
    if($retorno){
        foreach($retorno as $clave => $valor) {
            
            if ( empty($valor['titulo'.$idioma_elegido])   )    { 
				$xtitulo = $valor['titulo'.$idioma_default];      
			} else { 
				$xtitulo = $valor['titulo'.$idioma_elegido];  
			}
			
            if ( empty($valor['copete'.$idioma_elegido])   )    { 
				$retorno[$clave]['copete'] = $valor['copete'.$idioma_default];      
			} else { 
				$retorno[$clave]['copete'] = $valor['copete'.$idioma_elegido];  
			}
			
            if ( empty($valor['contenido'.$idioma_elegido])   )    { 
				$retorno[$clave]['contenido'] = $valor['contenido'.$idioma_default];      
			} else { 
				$retorno[$clave]['contenido'] = $valor['contenido'.$idioma_elegido];  
			}            
			
            if ( empty($valor['urlamigable'.$idioma_elegido]) ) { 
				$retorno[$clave]['urlamigable'] = $valor['urlamigable'.$idioma_default]; 
			} else { 
				$retorno[$clave]['urlamigable'] = $valor['urlamigable'.$idioma_elegido];
			}
			
            if ( empty($valor['thumbs'.$idioma_elegido]) )      { 
				$retorno[$clave]['thumbs'] = $valor['thumbs'.$idioma_default];      
			} else { 
				$retorno[$clave]['thumbs'] = $valor['thumbs'.$idioma_elegido];
			}
			
            $retorno[$clave]['titulo']    = htmlspecialchars_decode($xtitulo,ENT_QUOTES);
            $retorno[$clave]['copete']    = htmlspecialchars_decode($retorno[$clave]['copete'],ENT_QUOTES);
            $retorno[$clave]['href'] = URL."/".$url_categoria."/".$retorno[$clave]['urlamigable'].".html";
        
        }        
    }
    
    
    return $retorno;
}

function muestra_en_home($categoria=0, $limite=5){
    global $db, $idioma_elegido;

    if ($categoria>0){ $cat=" and publicaciones.categoria_id='$categoria'";} else {$cat = '';}
    
    settype($id, 'integer');
	$cond 	 = "select publicaciones.*, categorias.urlamigable1 as cat_url from publicaciones left join categorias on 
                publicaciones.categoria_id = categorias.id 
                where home='1' and publicaciones.activo=1 $cat order by publicaciones.fecha DESC";
	$rs 	 = $db->SelectLimit($cond,$limite);
    $retorno = $rs->GetRows();
    
    if($retorno){
        foreach($retorno as $clave => $valor) {
            
            if ( empty($valor['titulo'.$idioma_elegido])   )    { $retorno[$clave]['titulo']      = $valor['titulo'.$idioma_default];      } else { $retorno[$clave]['titulo']      = $valor['titulo'.$idioma_elegido];  }
            if ( empty($valor['copete'.$idioma_elegido])   )    { $retorno[$clave]['copete']      = $valor['copete'.$idioma_default];      } else { $retorno[$clave]['copete']      = $valor['copete'.$idioma_elegido];  }
            if ( empty($valor['urlamigable'.$idioma_elegido]) ) { $retorno[$clave]['urlamigable'] = $valor['urlamigable'.$idioma_default]; } else { $retorno[$clave]['urlamigable'] = $valor['urlamigable'.$idioma_elegido];}
            if ( empty($valor['thumbs'.$idioma_elegido])    )   { $retorno[$clave]['thumbs']      = $valor['thumbs'.$idioma_default];      } else { $retorno[$clave]['thumbs']      = $valor['thumbs'.$idioma_elegido];    }
            $retorno[$clave]['titulo']    = htmlspecialchars_decode($retorno[$clave]['titulo'],ENT_QUOTES);
            $retorno[$clave]['copete']    = htmlspecialchars_decode($retorno[$clave]['copete'],ENT_QUOTES);
            $retorno[$clave]['href'] = URL."/".$valor['cat_url']."/".$retorno[$clave]['urlamigable']."~".$retorno[$clave]['id'];
            if (empty($retorno[$clave]['thumbs'])) {
                $retorno[$clave]['thumbs'] = URL.'/archivos/images/nofoto.jpg';
            }
        
        }        
    }
    
    return $retorno;
}



function obtiene_destacados($categoria=0, $limite=5,$destacado=1){
    global $db, $idioma_elegido, $idioma_default;

    if ($categoria>0){ $cat=" and publicaciones.categoria_id='$categoria'";} else {$cat = '';}
    
    settype($id, 'integer');
	$cond 	 = "select publicaciones.*, categorias.urlamigable1 as cat_url from publicaciones left join categorias on 
                publicaciones.categoria_id = categorias.id 
                where destacado='$destacado' and publicaciones.activo=1 $cat order by publicaciones.orden DESC";
	$rs 	 = $db->SelectLimit($cond,$limite);
    $retorno = $rs->GetRows();
    
    if($retorno){
        foreach($retorno as $clave => $valor) {
            
            if ( empty($valor['titulo'.$idioma_elegido])   )    { $retorno[$clave]['titulo']      = $valor['titulo'.$idioma_default];      } else { $retorno[$clave]['titulo']      = $valor['titulo'.$idioma_elegido];  }
            if ( empty($valor['copete'.$idioma_elegido])   )    { $retorno[$clave]['copete']      = $valor['copete'.$idioma_default];      } else { $retorno[$clave]['copete']      = $valor['copete'.$idioma_elegido];  }
            if ( empty($valor['urlamigable'.$idioma_elegido]) ) { $retorno[$clave]['urlamigable'] = $valor['urlamigable'.$idioma_default]; } else { $retorno[$clave]['urlamigable'] = $valor['urlamigable'.$idioma_elegido];}
            if ( empty($valor['thumbs'.$idioma_elegido])    )   { 
				$retorno[$clave]['thumbs']      = $valor['thumbs'.$idioma_default];      
			} else { 
				$retorno[$clave]['thumbs']      = $valor['thumbs'.$idioma_elegido];    
			}
            $retorno[$clave]['titulo']    = htmlspecialchars_decode($retorno[$clave]['titulo'],ENT_QUOTES);
            $retorno[$clave]['copete']    = htmlspecialchars_decode($retorno[$clave]['copete'],ENT_QUOTES);
            if ($valor['categoria_id'] > 2){
				$retorno[$clave]['href'] = URL."/".$valor['cat_url']."/".$retorno[$clave]['urlamigable']."~".$retorno[$clave]['id'];
			} else {
				$retorno[$clave]['href'] = URL."/".$retorno[$clave]['urlamigable']."~".$retorno[$clave]['id'];
			}
            if (empty($retorno[$clave]['thumbs'])) {
                $retorno[$clave]['thumbs'] = URL.'/archivos/images/nofoto.jpg';
            }
        
        }        
    }
    
    
    return $retorno;
}


function productos_destacados($familia_id=0, $limite=4){
    global $db;
    
    settype($id, 'integer');

    if ($familia_id>0){ 

        $cond = "select productos.*, familias.urlamigable1 as fam_url 
                    from productos 
                    left join familias on productos.familia_id = familias.id 
                    where destacado_categoria='1' 
                        and productos.activo=1 
                        and productos.familia_id='$familia_id' 
                    order by productos.orden DESC";
    } else {

        $cond = "select productos.*, familias.urlamigable1 as fam_url 
                    from productos 
                    left join familias on productos.familia_id = familias.id 
                    where destacado_home = '1' 
                        and productos.activo= '1' 
                    order by productos.orden DESC";
    }
 
    $rs      = $db->SelectLimit($cond,$limite);
    $retorno = $rs->GetRows();
 
    if($retorno){
        foreach($retorno as $clave=>$valor){
            $href = URL.'/'.$valor['fam_url']."/".$valor['urlamigable'].'.html';
            $retorno[$clave]['href'] = $href;
        }
    }


    return $retorno;
}




function busco_publicacion($cadena_busqueda='',$id=0){
    global $db, $idioma_elegido,$idioma_default;
    if (!empty($cadena_busqueda)) {
        $idioma_elegido = $_SESSION['idioma'];

        $cond  = "select * from publicaciones where ( urlamigable1='$cadena_busqueda' or urlamigable2='$cadena_busqueda' 
                or urlamigable3='$cadena_busqueda' or urlamigable4='$cadena_busqueda' or urlamigable5='$cadena_busqueda' ) and activo=1";
        $rs    = $db->SelectLimit($cond,1);
        $Pub   = $rs->FetchRow();

    } else {
        settype($id, 'integer');
        $cond  = "select * from publicaciones where id='$id' and publicaciones.activo=1";
        $rs    = $db->SelectLimit($cond,1);
        $Pub   = $rs->FetchRow();
    }

    
    if (!empty($Pub)) {
        $id       = $Pub['id'];
        $lecturas = $Pub['lecturas']+1;
        $sql      = "update publicaciones set lecturas='$lecturas' where id='$id'";
        $ok       = $db->Execute($sql);
        
        $Pub['Categoria'] = busco_categoria_por_id($Pub['categoria_id']);

        if ( empty($Pub['titulo'.$idioma_elegido])    ) { $Pub['titulo']    = $Pub['titulo'.$idioma_default];    } else { $Pub['titulo']    = $Pub['titulo'.$idioma_elegido];    }
        if ( empty($Pub['thumbs'.$idioma_elegido])    ) { $Pub['thumbs']    = $Pub['thumbs'.$idioma_default];    } else { $Pub['thumbs']    = $Pub['thumbs'.$idioma_elegido];    }
        if ( empty($Pub['copete'.$idioma_elegido])    ) { $Pub['copete']    = $Pub['copete'.$idioma_default];    } else { $Pub['copete']    = $Pub['copete'.$idioma_elegido];    }
        if ( empty($Pub['contenido'.$idioma_elegido]) ) { $Pub['contenido'] = $Pub['contenido'.$idioma_default]; } else { $Pub['contenido'] = $Pub['contenido'.$idioma_elegido]; }
        if ( empty($Pub['urlamigable'.$idioma_elegido]) ) { $Pub['urlamigable'] = $Pub['urlamigable'.$idioma_default]; } else { $Pub['urlamigable'] = $Pub['urlamigable'.$idioma_elegido]; }
        $Pub['titulo']    = htmlspecialchars_decode(stripslashes($Pub['titulo']),ENT_QUOTES);
        $Pub['copete']    = htmlspecialchars_decode(stripslashes($Pub['copete']),ENT_QUOTES);
        $Pub['contenido'] = htmlspecialchars_decode(stripslashes($Pub['contenido']),ENT_QUOTES);


        $keywords    = iif(!empty($Pub['keywords'.$idioma_elegido]   ), $Pub['keywords'.$idioma_elegido]   , $Pub['keywords'.$idioma_default]   );            
        $Pub['descripcion'] = iif(!empty($Pub['descripcion'.$idioma_elegido]   ), $Pub['descripcion'.$idioma_elegido]   , $Pub['descripcion'.$idioma_default]   );                    

        $Pub['keywords']    = $keywords;

/*
        if (empty($Pub['thumbs'])) {
            $Pub['thumbs'] = URL.'/archivos/images/nofoto.jpg';
        }
*/

        //-- Tiene galeria de fotos?
        $cond  = "select id,nombre1 as nombre, archivo from galerias_fotos where galeria_id = '{$Pub['id']}' and activo = '1' order by orden ASC";
        $rs    = $db->Execute($cond);
        $Pub['galeria_fotos']  = $rs->GetRows();


    } else {
        $Pub = array();
    }
    
    return $Pub;
}



function ordenar_array() {
/* 
// EJEMPLO DE USO: 
// Otra manera de declarar un array bidimensional de estos... 
$array_a_ordenar = array( 
                 0 => array('campo1' => 'patatas', 'campo2' => 1, 'campo3' => 'kkkk'), 
                 1 => array('campo1' => 'coles', 'campo2' => 3, 'campo3' => 'aaaa'), 
                 2 => array('campo1' => 'tomates', 'campo2' => 1, 'campo3' => 'zzzz'), 
                 3 => array('campo1' => 'peras', 'campo2' => 7, 'campo3' => 'hhhh'), 
                 4 => array('campo1' => 'tomates', 'campo2' => 4, 'campo3' => 'bbbb'), 
                 5 => array('campo1' => 'aguacates', 'campo2' => 3, 'campo3' => 'yyyy'), 
         ); 
 
$array_ordenadito = ordenar_array($array_a_ordenar, 'campo2', SORT_DESC, 'campo1', SORT_DESC) or die('<br>ERROR!<br>'); 
$array_ordenadito2 = ordenar_array($array_a_ordenar, 'campo3', SORT_DESC, 'campo2', SORT_DESC, 'campo1', SORT_ASC ) or die('<br>ERROR!<br>');  
*/
    
  $n_parametros = func_num_args(); // Obenemos el número de parámetros 
  if ($n_parametros<3 || $n_parametros%2!=1) { // Si tenemos el número de parametro mal... 
    return false; 
  } else { // Hasta aquí todo correcto...veamos si los parámetros tienen lo que debe ser... 
    $arg_list = func_get_args(); 
 
    if (!(is_array($arg_list[0]) && is_array(current($arg_list[0])))) { 
      return false; // Si el primero no es un array...MALO! 
    } 
    for ($i = 1; $i<$n_parametros; $i++) { // Miramos que el resto de parámetros tb estén bien... 
      if ($i%2!=0) {// Parámetro impar...tiene que ser un campo del array... 
        if (!array_key_exists($arg_list[$i], current($arg_list[0]))) { 
          return false; 
        } 
      } else { // Par, no falla...si no es SORT_ASC o SORT_DESC...a la calle! 
        if ($arg_list[$i]!=SORT_ASC && $arg_list[$i]!=SORT_DESC) { 
          return false; 
        } 
      } 
    } 
    $array_salida = $arg_list[0]; 
 
    // Una vez los parámetros se que están bien, procederé a ordenar... 
    $a_evaluar = "foreach (\$array_salida as \$fila){\n"; 
    for ($i=1; $i<$n_parametros; $i+=2) { // Ahora por cada columna... 
      $a_evaluar .= "  \$campo{$i}[] = \$fila['$arg_list[$i]'];\n"; 
    } 
    $a_evaluar .= "}\n"; 
    $a_evaluar .= "array_multisort(\n"; 
    for ($i=1; $i<$n_parametros; $i+=2) { // Ahora por cada elemento... 
      $a_evaluar .= "  \$campo{$i}, SORT_REGULAR, \$arg_list[".($i+1)."],\n"; 
    } 
    $a_evaluar .= "  \$array_salida);"; 
    // La verdad es que es más complicado de lo que creía en principio... :) 
 
    eval($a_evaluar); 
    return $array_salida; 
  } 
} 


/* Para el menu de familias de productos */
function crearArbol($parent_id = 0, $nivel = 0){

    global $db;
    $nivel++; 
    /*Armar query*/
    $sql  = "select * from familias where parent_id = '$parent_id' order by orden ASC";
	$rs   = $db->Execute($sql);
	$Familias 	= $rs->GetRows();

    if($Familias){
        /*Recorrer todos las entradas */
        foreach($Familias as $key => $value) {
            $Familias[$key]['nivel'] = $nivel;
            $Familias[$key]['child'] = crearArbol($value['id'], $nivel);
        }
    }    

    $Resultado = array();
    $a = 0;
    foreach ($Familias as $n1) {
        $Resultado[$a]['id']        = $n1['id'];
        $Resultado[$a]['parent_id'] = $n1['parent_id'];
        $Resultado[$a]['nombre1']   = $n1['nombre1'];
        $Resultado[$a]['nivel']     = $n1['nivel'];
        $Resultado[$a]['orden']     = $n1['orden'];
        $Resultado[$a]['precio']     = $n1['precio'];
        $Resultado[$a]['de']        = $n1['de'];        
        $Resultado[$a]['activo']    = $n1['activo'];
        $Resultado[$a]['urlamigable1']    = $n1['urlamigable1'];
        $Resultado[$a]['thumbs1']    = $n1['thumbs1'];
        
        if (!empty($n1['child'])) {
            foreach ($n1['child'] as $n2) {
                $a++;
                $Resultado[$a]['id']        = $n2['id'];
                $Resultado[$a]['parent_id'] = $n2['parent_id'];
                $Resultado[$a]['nombre1']   = $n2['nombre1'];
                $Resultado[$a]['nivel']     = $n2['nivel'];
                $Resultado[$a]['orden']     = $n2['orden'];
                $Resultado[$a]['precio']    = iif( $n2['precio']==0,$n1['precio'],$n2['precio']);
                $Resultado[$a]['de']        = $n2['de'];
                $Resultado[$a]['activo']    = $n2['activo'];
                $Resultado[$a]['urlamigable1']    = $n2['urlamigable1'];
                $Resultado[$a]['thumbs1']    = $n2['thumbs1'];

                if (!empty($n2['child'])) {
                    foreach ($n2['child'] as $n3) {
                        $a++;
                        $Resultado[$a]['id']        = $n3['id'];
                        $Resultado[$a]['parent_id'] = $n3['parent_id'];
                        $Resultado[$a]['nombre1']   = $n3['nombre1'];
                        $Resultado[$a]['nivel']     = $n3['nivel'];
                        $Resultado[$a]['orden']     = $n3['orden'];
                        $Resultado[$a]['de']        = $n3['de'];
                        $Resultado[$a]['activo']    = $n3['activo'];
                        $Resultado[$a]['urlamigable1']    = $n3['urlamigable1'];
                        $Resultado[$a]['thumbs1']    = $n3['thumbs1'];
                        
                        if (!empty($n3['child'])) {
                            foreach ($n3['child'] as $n4) {
                                $a++;
                                $Resultado[$a]['id']        = $n4['id'];
                                $Resultado[$a]['parent_id'] = $n4['parent_id'];
                                $Resultado[$a]['nombre1']   = $n4['nombre1'];
                                $Resultado[$a]['nivel']     = $n4['nivel'];
                                $Resultado[$a]['orden']     = $n4['orden'];
                                $Resultado[$a]['de']        = $n4['de'];
                                $Resultado[$a]['activo']    = $n4['activo'];
                                $Resultado[$a]['urlamigable1']    = $n4['urlamigable1'];
                                $Resultado[$a]['thumbs1']    = $n4['thumbs1'];
                            }
                        } else {
                            $a++;
                        }
                        
                        
                    }
                } else {
                    $a++;
                }
            
            }
            
        } else {
            $a++;
        }
        
        
    }

    return $Resultado;    
}  



/* crea la dependencia de familias de un producto dado, pasandole el id de la familia a la que pertenece */
function url_producto($familia_id = 0){

    global $db;
    $nivel++; 
    /*Armar query*/
    $sql  = "select * from familias where id = '$familia_id'";
	$rs   = $db->SelectLimit($sql,1);
    $contador = 5;
	$dependencias[$contador] = $rs->FetchRow();
    $parent_id = $dependencias[$contador]['parent_id'];
    while ($parent_id != 0) {
        $contador = $contador-1;
        $familia_id = $parent_id;
        $sql  = "select * from familias where id = '$familia_id'";
    	$rs   = $db->SelectLimit($sql,1);
    	$dependencias[$contador] = $rs->FetchRow();
        $parent_id = $dependencias[$contador]['parent_id'];
    }
    sort($dependencias);
    $depende = array();
    $url = $ruta = '';
    foreach($dependencias  as $clave => $valor){
        
//        $depende[$clave]['id'] = $valor['id'];
//        $depende[$clave]['nombre'] = iif(!empty($valor['nombre'.$idioma_elegido]),$valor['nombre'.$idioma_elegido],$valor['nombre1']);
//        $depende[$clave]['keywords'] = iif(!empty($valor['keywords'.$idioma_elegido]),$valor['keywords'.$idioma_elegido],$valor['keywords1']);
        $depende[$clave]['urlamigable'] = iif(!empty($valor['urlamigable'.$idioma_elegido]),$valor['urlamigable'.$idioma_elegido],$valor['urlamigable1']);
//        $depende[$clave]['nombre'] = htmlspecialchars_decode(stripslashes($Familias[$clave]['nombre']),ENT_QUOTES);
        
        $ruta.= "/{$depende[$clave]['urlamigable']}";
    }
    $url = URL.$ruta;
    return $url;    
}  








/* Para el menu de familias de productos FRONTEND */
function MenuFamilias($parent_id = 0){

    global $db,$ruta;
    $nivel++; 
    /*Armar query*/
    
    $sql  = "select id,nombre1,urlamigable1,thumbs1 from familias where parent_id = '$parent_id' and activo=1 order by orden ASC";
	$rs   = $db->Execute($sql);
	$Familias 	= $rs->GetRows();

    if($Familias){
        /*Recorrer todos las entradas */
        foreach($Familias as $key => $value) {
            $sql  = "select id,nombre1,urlamigable1,thumbs1 from familias where parent_id = '{$value['id']}'  and activo=1 order by orden ASC";
            $rs   = $db->Execute($sql);
            $z   = $rs->GetRows();
            $Familias[$key]['child'] = $z;
        }
    }

    $x = array();
    foreach($Familias as $clave=>$valor){
        $x[$clave]['id']     = $valor['id'];
        $x[$clave]['nombre'] = $valor['nombre1'];
        $x[$clave]['href']   = CATALOGO.$valor['urlamigable1'];
        $x[$clave]['thumbs1']   = $valor['thumbs1'];        
        $x[$clave]['url']   = $valor['urlamigable1'];
        
        if (!empty($valor['child'])){
            
            foreach($valor['child'] as $clave5=>$valor5){
                $x[$clave]['child'][$clave5]['id']     = $valor5['id'];
                $x[$clave]['child'][$clave5]['nombre'] = $valor5['nombre1'];
                // $x[$clave]['child'][$clave5]['href']   = $x[$clave]['href'].'/'.$valor5['urlamigable1'];
                $x[$clave]['child'][$clave5]['href']   = CATALOGO.$valor5['urlamigable1'];
                $x[$clave]['child'][$clave5]['url']   = $valor5['urlamigable1'];
                $x[$clave]['child'][$clave5]['thumbs1']   = $valor5['thumbs1'];

            }
        }

    }
    //pr($x);
    return $x;    
}  

function ObtieneFamiliaPorURL($url=''){
    global $db;

    $sql  = "select * from familias where urlamigable1 = '$url' ";
    $rs   = $db->SelectLimit($sql,1);
    $Familia    = $rs->FetchRow();
    return $Familia;    

}  


function ObtieneFamilia($familia_id = 0,$cual='fam'){
    global $db;
    // $cual 'fam' o 'sub'
    /*Armar query*/
    $sql  = "select * from familias where id = '$familia_id' ";
	$rs   = $db->SelectLimit($sql,1);
	$Familia 	= $rs->FetchRow();

    if($Familia['parent_id']>0 and $cual=='fam'){
        $sql  = "select * from familias where id = '{$Familia['parent_id']}' ";
        $rs   = $db->SelectLimit($sql,1);
        $Familia    = $rs->FetchRow();
    }
    return $Familia;    

}  


function ObtieneUrlFamilias($familia_id = 0){
    global $db;

    $p_subfam   = ObtieneFamilia($familia_id,'sub');
    $url = $p_subfam['urlamigable1'];
    if ($p_subfam['parent_id']>0){
        $p_subfam   = ObtieneFamilia($p_subfam['parent_id'],'sub');
        $url = $p_subfam['urlamigable1'].'/'.$url;
    }
    
    return $url;
}  





function ObtieneProductos($familia_id = 0){
    global $db;
    $idioma_elegido = $_SESSION['idioma'];
    /*Armar query*/
    $sql  = "select * from productos where familia1_id = '$familia_id' or  familia2_id = '$familia_id' or  familia3_id = '$familia_id'";
	$rs   = $db->Execute($sql);
	$Productos 	= $rs->GetRows();

    foreach($Productos as $clave => $valor) {
        
        $Productos[$clave]['titulo'] = iif(!empty($valor['titulo'.$idioma_elegido]),$valor['titulo'.$idioma_elegido],$valor['titulo1']);
        $Productos[$clave]['thumbs'] = iif(!empty($valor['thumbs'.$idioma_elegido]),$valor['thumbs'.$idioma_elegido],$valor['thumbs1']);
        $Productos[$clave]['contenido'] = iif(!empty($valor['contenido'.$idioma_elegido]),$valor['contenido'.$idioma_elegido],$valor['contenido1']);
        $Productos[$clave]['urlamigable'] = iif(!empty($valor['urlamigable'.$idioma_elegido]),$valor['urlamigable'.$idioma_elegido],$valor['urlamigable1']);
        $Productos[$clave]['titulo'] = htmlspecialchars_decode(stripslashes($Productos[$clave]['titulo']),ENT_QUOTES);
        $Productos[$clave]['contenido'] = htmlspecialchars_decode(stripslashes($Productos[$clave]['contenido']),ENT_QUOTES);


    }
    return $Productos;
}  


function accede_a_familias($familia){
    $familia = unserialize($familia);

    $accede = false;
    
    if(empty($familia)) { 
        $accede = true;                       
    } else {
//      pr($familia);
        $accede = false;
        if (isset($_SESSION['login']['grupos'])) {
            foreach($familia as $grupos) {
//                pr($grupos);                                
                $familia_grupo = $grupos['grupo_id'];
//              pr($familia_grupo);

                foreach($_SESSION['login']['grupos'] as $mis_grupos){
//                  pr($mis_grupos); 
                    $usuario_grupo = $mis_grupos['grupo_id'];
//                  pr($usuario_grupo);
                    if ($familia_grupo === $usuario_grupo) {
                        $accede = true;
                        break;
                    } 
                }
                if ($accede == true){  break; }                                
            }
                            
        }
    }
    
    return $accede;
}


function accede_a_productos($producto){
    $producto = unserialize($producto);

    $accede = false;
    
    if(empty($producto)) { 
        $accede = true;                       
    } else {
        $accede = false;
        if (isset($_SESSION['login']['grupos'])) {
            foreach($producto as $grupos) {
                $producto_grupo = $grupos['grupo_id'];

                foreach($_SESSION['login']['grupos'] as $mis_grupos){
                    $usuario_grupo = $mis_grupos['grupo_id'];
                    if ($producto_grupo === $usuario_grupo) {
                        $accede = true;
                        break;
                    } 
                }

                if ($accede == true){  break; }                                
            }
                            
        }
    }
    
    return $accede;
}


function slide($slide_id=0){
    if ($slide_id==0) { return '';}

    global $db;
    $cond  = "select * from slides where activo=1 and id='$slide_id'";
    $rs    = $db->SelectLimit($cond,1);
    $x     = $rs->FetchRow();
    if (!$x) { return '';}    
    $xdata = unserialize($x['data']);   
    $ancho = $x['ancho'];
    $alto  = $x['alto'];
    
    $x = 0;
    $slides = array();
    
    foreach($xdata as $value) {
        $slides[$x]['imagen'] = $value['imagen'];
        $slides[$x]['posicion_texto'] = $value['posicion_texto'];
        $slides[$x]['texto'] = html_entity_decode($value['texto']);
        $slides[$x]['href'] = $value['href'];
        $x++;
    }
    foreach($slides as $clave=>$valor) {
        if($valor['posicion_texto']=='Centro'){ $slides[$clave]['donde']="top:0px;text-align:center;margin:0px auto;"; }
        if($valor['posicion_texto']=='Derecha'){ $slides[$clave]['donde']="top:0px;float:right;text-align:right; margin-right:70px;"; }
        if($valor['posicion_texto']=='Izquierda'){ $slides[$clave]['donde']="float:left;text-align:left;margin-left:30px;"; }
    }


    $return_slide = '';
    
    
    $xalto = $alto.'px';
    $xancho = $ancho.'px';

    
    $return_slide = "<link href='".URL."/js/jsImgSlider/themes/1/js-image-slider.css' rel='stylesheet' type='text/css' />";
    $return_slide.= "<script src='".URL."/js/jsImgSlider/themes/1/js-image-slider.js' type='text/javascript'></script>";
    $return_slide.= "<link href='".URL."/js/jsImgSlider/generic.css' rel='stylesheet' type='text/css' />";            


    $botonera = 10;
    $return_slide.="<style>
    #slider { width:".$ancho."px;height:".$alto."px;}
    #sliderFrame { width:".$ancho."px;}
    div.navBulletsWrapper  {  top:".$botonera."px; }
    </style>";

    $return_slide.= "
    <div id='sliderFrame' style='margin-bottom:10px;'>
        <div id='slider'>";

    foreach($slides as $s) { 

        if(!empty($s['href'])){
            $return_slide.= "       <a href='{$s['href']}' target='_blank'>";
        }
        $return_slide.= "       <img src='{$s['imagen']}' alt='{$s['texto']}'>";            
        if(!empty($s['href'])){
            $return_slide.= "       </a>";
        }

    }   
        if ($slide_id==1){
//            $return_slide.= "<a class='video' href='http://www.youtube.com/watch?v=T0XuuikuFkY'  autoPlayVideo='false' ><img src='".URL."/img/video_rosario.jpg' alt='' /></a>";
        }

    $return_slide.= "
        </div>
    </div><div class='clear'></div>
    ";

    return $return_slide;
}

function jq_notificacion($texto='',$tipo='information',$autoclose=false,$duracion=10){
    /* tipo = success | error | warning | information*/

    if ($texto!='') {
        $mensaje = "<script type='text/javascript'>
                showNotification({
                    message: '$texto',
                    type: '$tipo',
                    autoClose: '$autoclose',
                    duration: $duracion                                        
                });
            </script>";
        return $mensaje;    
    } else {
        return '';
    }
}


function xURLcl($url){
        $context = stream_context_create(array(
            'http' => array(
              'method'  => 'GET',
              'timeout' => 5),));
        $ret = file_get_contents('http://xurl.cl/api.php?url='.urlencode($url), false, $context);
        return $ret;
    }



    function busca_ciudad($provincia_id=0, $url=''){
        global $db;
        $sql = "select * from ciudades where parent_id='$provincia_id' and urlfriendly='$url'";
        
        $rs  = $db->SelectLimit($sql,1);
        $Ciudad = $rs->FetchRow();
        if (isset($Ciudad) and !empty($Ciudad)){
            $ciudad['id']     = $Ciudad['id'];
            $ciudad['nombre'] = $Ciudad['locacion'];
            $ciudad['url']    = $url;
        } else {
            $ciudad['id']     = 0;
            $ciudad['nombre'] = '';
            $ciudad['url']    = '';
        }
        return $ciudad;
    }

    function busca_familia($url=''){
        global $db;
        //-------Es una Familia ?
        $sql = "select * from familias where urlamigable1='$url'";
        $rs  = $db->SelectLimit($sql,1);
        $Fam = $rs->FetchRow();
        if (isset($Fam) and !empty($Fam)){
            $familia['id']     = $Fam['id'];
            $familia['url']    = $url;
            $familia['sumario'] = $Fam['cuerpo1'];
            $familia['nombre'] = $Fam['nombre1'];
            $familia['meta-keywords']    = $Fam['keywords1'];
            $familia['meta-title']       = $Fam['metatitle'];
            $familia['meta-description'] = $Fam['descripcion'];
            $familia['meta-robots']      = $Fam['robots'];
            $familia['plantilla']        = $Fam['plantilla'];
        } else {
            $familia['id']     = 0;
            $familia['nombre'] = '';
            $familia['url']    = '';
            $familia['plantilla']        = '';
        }

        return $familia;
    }

    function busca_subfamilia($familia_id=0,$url=''){
        global $db;
        //-------Es una SubFamilia ?
        $sql = "select * from familias where parent_id='$familia_id' and urlamigable1='$url'";
        $rs  = $db->SelectLimit($sql,1);
        $SubFam = $rs->FetchRow();
        if (isset($SubFam) and !empty($SubFam)){
            $subfamilia['id']     = $SubFam['id'];
            $subfamilia['url']    = $url;
            $subfamilia['sumario']          = $SubFam['cuerpo1'];
            $subfamilia['nombre']           = $SubFam['nombre1'];            
            $subfamilia['meta-keywords']    = $SubFam['keywords1'];
            $subfamilia['meta-title']       = $SubFam['metatitle'];
            $subfamilia['meta-description'] = $SubFam['descripcion'];
            $subfamilia['meta-robots']      = $SubFam['robots'];

        } else {
            $subfamilia['id']     = 0;
            $subfamilia['nombre'] = '';
            $subfamilia['url']    = '';
        }
        return $subfamilia;
    }


    function obtiene_icono($extension='' ){
        global $ruta_iconos;
        $ext['pdf'] = 'pdf';
        $ext['doc'] = 'doc';
        $ext['docx'] = 'doc';
        $ext['xls'] = 'xls';
        $ext['xlsx'] = 'xls';
        $ext['csv'] = 'csv';
        $ext['ppt'] = 'ppt';
        $ext['pptx'] = 'ppt';
        $ext['txt'] = 'txt';
        $ext['jpg'] = 'jpg';
        $ext['png'] = 'jpg';        
        $ext['gif'] = 'jpg';
        $ext['bmp'] = 'jpg';

        if(isset($ext["$extension"])){
            return $ruta_iconos.$ext["$extension"].'.png';
        } else {
            return $ruta_iconos.'default.png';
        }

    }

	
	function obtiene_ruta_producto($producto_id=0){
		global $db;
		if($producto_id>0){
			$sql = "select productos.urlamigable,pf.familia_id, pf.subfamilia_id
					from productos
					left join productos_familias as pf on productos.id=pf.producto_id
					where productos.id='$producto_id'";
			$rs  = $db->SelectLimit($sql,1);
			$Prod = $rs->FetchRow();
			if($Prod){
				$sql = "select urlamigable1 from familias where id='{$Prod['familia_id']}'";
				$rs  = $db->SelectLimit($sql,1);
				$fam = $rs->FetchRow();
				
				$sql = "select urlamigable1 from familias where id='{$Prod['subfamilia_id']}'";
				$rs  = $db->SelectLimit($sql,1);
				$sub = $rs->FetchRow();
				
				$href = URL."/{$fam['urlamigable1']}/{$sub['urlamigable1']}/{$Prod['urlamigable']}-$producto_id.html";
				return $href;
				
			} else {
				return '';
			}
			
		} else {
			return '';
		}
	}
	
	
	
	function PaisesAutoridades($pais='argentina.gif'){
		
		$ruta = ROOT.'/img/flags/';

		if ($gestor = opendir($ruta)) {
			$a_paises = array();	 
			/* Esta es la forma correcta de iterar sobre el directorio. */
			while (false !== ($entrada = readdir($gestor))) {
				$z = explode('.',$entrada);
				if( strtolower(end($z))=='gif'){
					$x = explode('_',$z[0]);
					$nombre = '';
					foreach($x as $y){
						$nombre.=ucwords($y).' ';
					}
					$nombre = trim($nombre);
					$a_paises["$entrada"] = $nombre;
				}
			}
			closedir($gestor);
		}
		if($a_paises){
			ksort($a_paises);
			$return = "<select name='pais_origen' id='pais_origen'>";
			$return.= "<option value=''>Seleccione el país de Origen</option>";
			foreach($a_paises as $clave=>$valor){
				$sel = iif($pais==$clave,'selected','');
				$return.= "<option value='$clave' $sel >$valor</option>";
			}
			$return.="</select>";
		}
		return $return;
	}
?>