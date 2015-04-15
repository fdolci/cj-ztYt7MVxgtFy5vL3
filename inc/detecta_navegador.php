<?php
function mobile(){
    $hua=$_SERVER['HTTP_USER_AGENT'];
    $m = false;
    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i',strtolower($hua))) { 
    	$m=true;
    } else {
    	if(strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0 OR 
    	((isset($_SERVER['HTTP_X_WAP_PROFILE']) OR isset($_SERVER['HTTP_PROFILE'])))) { 
    		$m=true;
    	}
 	}
    $mua = strtolower(substr($hua,0,4));
    $ma = array('w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki',
    'oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal',
    'smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','xda','xda-');
    
    if(in_array($mua,$ma)) { $m=true; }
    if(strpos(strtolower(@$_SERVER['ALL_HTTP']),'OperaMini')>0) {$m=true;}
    if(strpos(strtolower($hua),'windows')>0 AND strpos(strtolower($hua),'IEMobile')<=0) {$m=false; }

    if($m==true) {
    	return 'movil';	
    } else {
    	return 'web';
    }
    
}

?>