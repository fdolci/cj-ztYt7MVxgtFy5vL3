<?php
	include('../inc/config.php');
	
	$ancho     = request('ancho',250)-25;
	$ancho = iif($ancho<225,225,$ancho);
	$ancho = iif($ancho>490,490,$ancho);
	
	$alto = request('alto',350)-10;
	$alto = iif($alto<200,200,$alto);
	
	$registros = request('cantreg',0);

	//--------------------------------------------------------------
	//                     Familia y Subfamilia pasada por parametro
	//--------------------------------------------------------------	
	$familia_id = request('familia_id','0-0');
	$x = explode('-',$familia_id);
	$fam = $x[0];
	$sub = $x[1];

	$cond_subfamilia = '';
	$cond_familia    = '';
    if($fam>0) {
        $cond_familia = " and pf.familia_id = '$fam' ";
		if($sub>0) {
			$cond_subfamilia = " and pf.subfamilia_id = '$sub' ";
		}
	}

	//--------------------------------------------------------------
	//                                                         Orden
	//--------------------------------------------------------------	
    $orden = " order by destacado_home DESC, desde ASC";

	//--------------------------------------------------------------
	//                                           Ejecuta la consulta
	//--------------------------------------------------------------	
    $sql = "select 
				productos.*,pf.familia_id, pf.subfamilia_id
            from 
				productos
				left join productos_familias as pf on pf.producto_id = productos.id 
            where 
				productos.activo=1 and hasta>='".time()."'
				$cond_familia $cond_subfamilia $orden
			";
	if( $registros==0 ){
	   $rs  = $db->Execute($sql);
	} else{
	   $rs  = $db->SelectLimit($sql,$registros);
	}
    $eventos = $rs->GetRows();
    

	//--------------------------------------------------------------
	//                                                Asigna el href
	//--------------------------------------------------------------	
    foreach($eventos as $clave=>$valor){
		$eventos[$clave]['href'] = obtiene_ruta_producto($valor['id']);
    }

    include_once(ROOT.'/api/proximos_mini.html.php');
    die();
?>