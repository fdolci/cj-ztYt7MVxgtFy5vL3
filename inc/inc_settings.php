<?php
	//-------trae los seteos de la tabla de configuracion
	$sql 	 = "select * from setting where panel!=2 order by panel ASC";
	$rs 	 = $db->Execute($sql);
	$Sett = $rs->GetRows();
	
            
    $DatosEmpresa = $Google = $EnvioForm =array();
     
	foreach ($Sett as $clave => $valor) {
	    if ($valor['panel']==1) {
	        $DatosEmpresa[$valor['name']] = $valor['valor'];   
	    } elseif ($valor['panel']==3) {
	        if ($valor['name']=='analytics' and !empty($valor['valor'])) {
				$CodigoAnalytics = "<script type='text/javascript'>var _gaq = _gaq || [];_gaq.push(['_setAccount', '".$valor['valor']."']);
				_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();</script>";
	           $Google[$valor['name']] = $CodigoAnalytics;   
               
	        } else {
	           $Google[$valor['name']] = $valor['valor'];   
	        }  
            
        } elseif ($valor['panel'] == 4 ) {
            $EnvioForm[$valor['name']] = $valor['valor'];

        } elseif ($valor['panel'] == 6 ) {

                $Config[$valor['name']] = $valor['valor'];

        } elseif ($valor['panel'] == 7 ) {
        	//-------------------------PHP Mailer
                $PHPMailer[$valor['name']] = $valor['valor'];

        }

		
	}
    
    
    $TemplatesCategorias[1] = 'Template 1';
    $TemplatesCategorias[2] = 'Template 2';
    $TemplatesCategorias[3] = 'Template 3';
  

    $Monedas[1] = '$';
    $Monedas[2] = 'u$s';

?>