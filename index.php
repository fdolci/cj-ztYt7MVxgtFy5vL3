<?php
	include_once('./inc/config.php');

    $route = request('route','');
    $route = saca_espacios($route);
    $ruta  = explode('/',$route);
    $ultimo = end($ruta);
    if (empty($ultimo) ){
        $cual = count($ruta)-1;
        unset($ruta[$cual]);
    }

    //------------------------------------------------- En la URL viene un paginado ???
    $paginado = end($ruta);
    $pagina  = 0;    
    if( substr($paginado,0,4) == 'pag-'  ) {
        $pagina = end(explode('-',$paginado));
        $es_paginado = true;
        //--- Obtuve el pagina, entonces lo elimino del array
        $cual = count($ruta)-1;
        unset($ruta[$cual]);

    } else {
        $pagina = 1;
        $es_paginado = false;
    }



    if (empty($ruta)  ) {

        $xurl = array();
        $xurl['provincia']['id']      = 0;
        $xurl['provincia']['nombre']  = PAIS;
        $xurl['provincia']['url']     = '';
        $xurl['ciudad']['id']         = 0;
        $xurl['ciudad']['nombre']     = '';
        $xurl['ciudad']['url']        = '';
        $xurl['familia']['id']        = 0;
        $xurl['familia']['nombre']    = '';
        $xurl['familia']['url']       = '';
        $xurl['familia']['plantilla'] = '';
        $xurl['subfamilia']['id']     = 0;
        $xurl['subfamilia']['nombre'] = '';
        $xurl['subfamilia']['url']    = '';
        $xurl['anuncio']              = '';

        $breadcrumb[0]['href']  = URL;
        $breadcrumb[0]['title'] = $Traducciones['home'];

        include_once(ROOT.'/lista_comercios.php');


        
    } else {

       // $ruta   = explode('/',$route);

        if ( $ruta[0]=='blog' ) {

            include(ROOT.'/blog_index.php');

        } elseif ( $ruta[0]=='rss' ) {

            include(ROOT.'/rss.php');

        } elseif ( $ruta[0]=='anunciante' ) {

            include(ROOT.'/lista_anunciante.php');

        } else {

            $cuantos = count($ruta);
            $ultimo  = end($ruta);                        
            $x       = explode('.',$ultimo);
            $termina = end($x);

            if ($cuantos == 1 and $termina == 'html') {
                //--------- Es una publicacion

                $url = explode('.',end($ruta));

                if ( (count($ruta)==1 and $url[1]!='html') or substr($url[0],0,4)=='pag:' ) {

                    include('lista_categoria.php');

                } else {


                    //------- Busco la publicacion
                    $Pub = busco_publicacion($url[0]);
                    $cat_id = $Pub['categoria_id'];

                    $mTitle          = $Pub['Categoria']['titulo1'].' '.$Pub['titulo'];
                    $mRobots         = $Pub['robots'];
                    $mKeywords       = $Pub['keywords'];
                    $mDescription    = $Pub['descripcion'];


                    if($Pub['id']==1) {
                        //---------------------------------Formulario de Contacto
                        $breadcrumb[0]['href']  = URL;
                        $breadcrumb[0]['title'] = $Traducciones['home'];
                        $breadcrumb[1]['href']  = URL.'/'.$url[0].'.html';
                        $breadcrumb[1]['title'] = $Pub['titulo1'];

						$mTitle          = $Pub['titulo'];
						$mRobots         = $Pub['robots'];
						$mKeywords       = $Pub['keywords'];
						$mDescription    = $Pub['descripcion'];
						
						
                        include_once(ROOT.'/inc/inc_publicidad.php');
                        include_once(ROOT.'/html/header.html.php');
                        include_once(ROOT.'/html/contacto.html.php');



                    } else {

                        $breadcrumb[0]['href']  = URL;
                        $breadcrumb[0]['title'] = $Traducciones['home'];
                        if($cat_id<10){
                            $breadcrumb[1]['href']  = URL.'/'.$ruta[0].'/'.$ruta[1];
                            $breadcrumb[1]['title'] = $Pub['titulo1'];
                        } else {
                            $breadcrumb[1]['href']  = URL.'/'.$ruta[0];
                            $breadcrumb[1]['title'] = $Pub['Categoria']['titulo1'];
                            $breadcrumb[2]['href']  = URL.'/'.$ruta[0].'/'.$ruta[1];
                            $breadcrumb[2]['title'] = $Pub['titulo1'];
                        }


                        include_once(ROOT.'/inc/inc_publicidad.php');
                        include_once(ROOT.'/html/header.html.php');
                        
                        include_once(ROOT.'/html/ver.html.php');

                    }

                } // endif muestra publicacione    



            } else {

                //------------------------------------------- Anuncios

                $xurl = array();
                $xurl['provincia']['id']      = 0;
                $xurl['provincia']['nombre']  = PAIS;
                $xurl['provincia']['url']     = '';
                $xurl['ciudad']['id']         = 0;
                $xurl['ciudad']['nombre']     = '';
                $xurl['ciudad']['url']        = '';
                $xurl['familia']['id']        = 0;
                $xurl['familia']['nombre']    = '';
                $xurl['familia']['url']       = '';
                $xurl['familia']['plantilla'] = '';
                $xurl['subfamilia']['id']     = 0;
                $xurl['subfamilia']['nombre'] = '';
                $xurl['subfamilia']['url']    = '';
                $xurl['anuncio']              = '';

                $breadcrumb[0]['href']  = URL;
                $breadcrumb[0]['title'] = 'Inicio';

/* 
pr($ruta);
(
    [0] => cartago
    [1] => aguas
    [2] => alimentacion-bebidas
    [3] => almacenes-de-alimentos-comestibles-costa-rica
    [4] => india-house-hostel-75.html
)
*/

                if (isset($Provincias[$ruta[0]])) {
                    //---- es una provincia
                    $xurl['provincia']['id']     = $Provincias[$ruta[0]]['id'];
                    $xurl['provincia']['nombre'] = $Provincias[$ruta[0]]['locacion'];
                    $xurl['provincia']['url']    = $ruta[0];
                    $breadcrumb[1]['href']  = $breadcrumb[0]['href']."/{$xurl['provincia']['url']}";
                    $breadcrumb[1]['title'] = $xurl['provincia']['nombre'];
                    $mTitle          = '';
                    $mRobots         = '';
                    $mKeywords       = '';
                    $mDescription    = '';


                    if (isset($ruta[1])){
                        // Es una localidad??
                        $xurl['ciudad'] = busca_ciudad($xurl['provincia']['id'],$ruta[1]);

                        if( $xurl['ciudad']['id']>0 ){


                            $breadcrumb[2]['href']  = $breadcrumb[1]['href']."/{$xurl['ciudad']['url']}";
                            $breadcrumb[2]['title'] = $xurl['ciudad']['nombre'];

                            if ( isset($ruta[2] ) ){
                                $xurl['familia'] = busca_familia($ruta[2]);    

                                if ( $xurl['familia']['id']>0){
                                    $breadcrumb[3]['href']  = $breadcrumb[2]['href']."/{$xurl['familia']['url']}";
                                    $breadcrumb[3]['title'] = $xurl['familia']['nombre'];

                                    if ( isset($ruta[3] ) ){
                                        $xurl['subfamilia'] = busca_subfamilia($xurl['familia']['id'],$ruta[3]);    

                                         if ( $xurl['subfamilia']['id']>0){
                                            $breadcrumb[4]['href']  = $breadcrumb[3]['href']."/{$xurl['subfamilia']['url']}";
                                            $breadcrumb[4]['title'] = $xurl['subfamilia']['nombre'];

                                            if ( isset($ruta[4] ) ){
                                                $xurl['anuncio'] = $ruta[4];    
                                            }
                                        }

                                    }
                                }
                            }

                        } else {
                            // $ruta[1] NO es una ciudad, busco si es una familia
                            $xurl['familia'] = busca_familia($ruta[1]);    

                            if ( $xurl['familia']['id']>0){
                                $breadcrumb[2]['href']  = $breadcrumb[1]['href']."/{$xurl['familia']['url']}";
                                $breadcrumb[2]['title'] = $xurl['familia']['nombre'];
                                if ( isset($ruta[2] ) ){
                                    $xurl['subfamilia'] = busca_subfamilia($xurl['familia']['id'],$ruta[2]);    

                                    if ( $xurl['subfamilia']['id']>0){
                                        $breadcrumb[3]['href']  = $breadcrumb[2]['href']."/{$xurl['subfamilia']['url']}";
                                        $breadcrumb[3]['title'] = $xurl['subfamilia']['nombre'];

                                        if ( isset($ruta[3] ) ){
                                            $xurl['anuncio'] = $ruta[3];    
                                        }
                                    }
                                }
                            }

                        }

                    }

                } else {
                    // La Ruta[0] NO es una provincia, entonces busco si es familia

                    $xurl['familia'] = busca_familia($ruta[0]);    
                    if ( $xurl['familia']['id']>0){
                        $breadcrumb[1]['href']  = $breadcrumb[0]['href']."/{$xurl['familia']['url']}";
                        $breadcrumb[1]['title'] = $xurl['familia']['nombre'];

                        if ( isset($ruta[1] ) ){
                            $xurl['subfamilia'] = busca_subfamilia($xurl['familia']['id'],$ruta[1]);    
                            if ( $xurl['subfamilia']['id']>0){
                                $breadcrumb[2]['href']  = $breadcrumb[1]['href']."/{$xurl['subfamilia']['url']}";
                                $breadcrumb[2]['title'] = $xurl['subfamilia']['nombre'];
                                if ( isset($ruta[2] ) ){
                                    $xurl['anuncio'] = $ruta[2];    
                                }
                            }

                        }
                    }


                }

                if(!empty($xurl['anuncio'])) {
                    include(ROOT.'/muestra_comercio.php');
                } elseif ( $xurl['subfamilia']['id']>0 ){
                    include(ROOT.'/lista_comercios.php');
                } else {
                    
                    include(ROOT.'/lista_comercios.php');
                }

            }         


        } //end if blog

    }

    include_once(ROOT.'/html/footer.html.php');
  



?>