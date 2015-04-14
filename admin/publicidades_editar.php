<?php
    $item_menu[0] = 5;
    $item_menu[1] = 5   ;
    $title = 'Editar Publicidad';    
	
    if (!defined('URL')) { include('header.php'); }
    
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }


    $submit     = request('submit','');
	$id     	= request('id',0);
    $familia_id = request('familia_id',0);
    $ubicacion  = request('ubicacion','left');    
    

    if($_POST['submit']){

        $data = $_POST;

        list( $data['familia_id'], $data['subfamilia_id'] ) = explode( '-', $data['combo_familia'] );
        $combo_familia = $data['combo_familia'];
        unset( $data['combo_familia'] );


        if ($data['familia_id']==0){
            $data['plan_id'] = $data['plan_id_home'];
        } else {
            $data['plan_id'] = $data['plan_id_interna'];
        }
        $data['plan_id'] = 0;

        if(!empty($_FILES['nueva_imagen']['name'])){
            $nombre_original = $_FILES['nueva_imagen']['name'];
            $temp   = $_FILES['nueva_imagen']['tmp_name'];
            $x = explode('.',$nombre_original);
            $extension = end($x);
            $nombre = time().'.'.$extension;
            // subir imagen al servidor
            move_uploaded_file($temp, SUBIR_PUBLICIDAD.'/'.$nombre);
            $data['thumbs'] = $nombre;
        }

        unset($data['plan_id_interna']);
        unset($data['plan_id_home']);
        unset($data['submit']);
        unset($data['test']);


        $data['caduca'] = mktime(23,59,59,$data['caduca_mes'], $data['caduca_dia'], $data['caduca_ano']);
        unset($data['caduca_dia']);
        unset($data['caduca_mes']);
        unset($data['caduca_ano']);


        $db->debug = false;
        $ok = $db->Replace('publicidades', $data,'id', $autoquote = true); 
//die();
        if ($ok) { 
            $_SESSION['Msg'] = 'Publicidad se guardo correctamente.';
            redirect("publicidades.php?accion=listar&combo_familia=$combo_familia&ubicacion={$data['ubicacion']}");
            die();
               
        } else { 
            $_SESSION['Msg'] = '<br/>ERROR!! No se pudo guardar la Publicidad.'; 
            redirect("publicidades.php?accion=listar&combo_familia=$combo_familia&ubicacion={$data['ubicacion']}");
            die();
        }




    } else {
    	$cond 	= "select * from publicidades where id='$id'";
    	$rs 	= $db->SelectLimit($cond, 1);
    	$data	= $rs->FetchRow();

		if($id==0){
			$data['familia_id']    = $familia_id;
			$data['subfamilia_id'] = $subfamilia_id;
			$data['ubicacion']     = $ubicacion;
			
			
		}
		
        $cond   = "select * from planes where activo='1'";
        $rs     = $db->Execute($cond);
        $Planes   = $rs->GetRows();


    }
    

    // -ARMA LOS SELECT DE LAS FAMILIAS
    $Familias = crearArbol(0);

    $parent_id = 0;
    $select_familia = '<select name="combo_familia" id="combo_familia" class="required">';
    $select_familia.= "<option value='0-0' >Página Principal</option>";
    $familia_id = $subfamilia_id = 0;
    foreach($Familias as $dd){

            if( $dd['parent_id']==0 )
            { 
                $familia_id    = $dd['id']; 
                $subfamilia_id = 0; 
            } else { 
                $familia_id    = $dd['parent_id']; 
                $subfamilia_id = $dd['id'];
            }
            $identificador = $familia_id.'-'.$subfamilia_id;
            
            if ($data['familia_id'] == $familia_id and  $data['subfamilia_id'] == $subfamilia_id ) { $sel = "selected='selected'"; } else {$sel='';}

            $separador = "";
            if ($dd['nivel'] == 2 ) {
                $separador = "------";
            } elseif ($dd['nivel'] == 3 ) {
                $separador = "------------";
            } elseif ($dd['nivel'] == 4 ) {
                $separador = "------------------";
            }
            $select_familia.= "<option value='$identificador' $sel >$separador {$dd['nombre1']}</option>";
    }
    $select_familia.= "</select>";



/*
    // Estadisticas de Visita
    $sql = "select count(id) as cuantos, semana from visitas_unicas where publicidad_id='{$data['id']}' and visualizacion=1  group by semana order by fecha ASC";
    $rs  = $db->Execute($sql);
    $Visitas = $rs->GetRows();

    // Estadisticas de Click
    $sql = "select count(id) as cuantos, semana from visitas_unicas where publicidad_id='{$data['id']}' and click=1 group by semana order by fecha ASC";
    $rs  = $db->Execute($sql);
    $Click = $rs->GetRows();
*/

    // Detalle de Pagos
    $sql = "select pagos.*,planes.plan from pagos 
            left join planes on pagos.plan_id = planes.id
            where publicidad_id='{$data['id']}'  order by pagos.desde DESC";
    $rs  = $db->Execute($sql);
    $Pagos = $rs->GetRows();

?>

<style type="text/css">
label { float: left; }
label.error { float: none; color: red; padding-left:0px; vertical-align: top; display: block;font-size:12px;}
p { clear: both; }
em { font-weight: bold; padding-right: 1em; vertical-align: top; color:red;}

</style>



<script>
    $(document).ready(function(){
        $.validator.setDefaults({ ignore: [] });        
        var validator = $("#form1").validate({
              invalidHandler: function() {
                $("#summary").text("Hay " + validator.numberOfInvalids() + " dato(s) NO valido(s). Por favor revise todas las secciones y complételos. Gracias.");
                $("#summary").show();
              }            
        });
    });
</script>


<!-- Menu Pestañas -->
<script type="text/javascript" src="<?php echo URL;?>/js/menupestanas/menupestanas.js"></script>
<link rel="stylesheet" href="<?php echo URL;?>/js/menupestanas/menupestanas.css" type="text/css" media="screen" />    

<style>
.required { border:1px solid #FF9900; background:#eee;}
</style>

<?php if(!empty($_SESSION['Msg'])) { echo mensaje_ok($_SESSION['Msg']); $_SESSION['Msg']=''; } ?>
<center>

    <div id='summary' style='color:#FF0000; font-size:16px; font-weight:bold;line-height:24px; border:1px solid #FF0000;display:none;margin-bottom:20px;background:#F7D3D3;'></div>
    <ul class="tabs">
        <li><a href="#p_datos"> Datos Generales</a></li>
        <?php /* <li><a href="#p_pagos">Pagos</a></li> */ ?>
    </ul>

    <div class="tab_container">
        <div id="p_datos" class="tab_content" style='min-height:400px;width:850px;background:#FFF;'>
            <?php include('publicidades_editar_datos.php'); ?>
        </div>

        <div id="p_pagos" class="tab_content" style='min-height:400px;width:850px;background:#FFF;'>
            <?php include('publicidades_pagos.php');?>
        </div>

    </div>

</center>
<?php //pr($data);?>