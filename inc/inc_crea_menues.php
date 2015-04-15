<?php
    //-- Obtengo la url para determinar la opcion de menu activa
    $x = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $x = explode('/',str_replace(URL,'',$x));
    $miopcion = '';
    foreach($x as $zz){ if (!empty($zz)) { $miopcion.='/'.$zz; } }
    $idioma_elegido = $_SESSION['idioma'];
	

    //--- Obtengo todos los Bloques de Menu activos
	$cond 		= "select id,nombre,div_css,categorias from bloque_menu where id ='$bloque_menu_id' ";
	$rs 		= $db->SelectLimit($cond,1);
	$bloquemenu = $rs->FetchRow();

    $MenuCategoria='';

    //-------Agrego cada uno de los item, segun el bloque al que pertenecen
        $cond 		= "select * from menues where activo=1 and bloque_id='$bloque_menu_id' order by orden ASC";
        $rs 		= $db->Execute($cond);
        $MM		 	= $rs->GetRows();
 //       $url = 'urlamigable'.$idioma_elegido;        
        $x=0;

		$url = URL;
        $Menues = array();
        foreach($MM as $m){
            $m['link'] = $m['link'.$idioma_elegido];
	
            if($m['tipolink']==0) { //--- Lleva a una publicacion
            
				$regpub = busco_publicacion('',$m['pub_id']);
				if ($regpub['categoria_id']>10){
                    $m['link'] = "$url/{$regpub['Categoria']['urlamigable']}/{$regpub['urlamigable']}.html";    
                } else {
                    $m['link'] = "$url/{$regpub['urlamigable']}.html";
                }
				

			} elseif($m['tipolink']==2) { // LLeva a una URL

				$m['elegido'] = iif($m['link']==URL.$miopcion, 1, 0);
				
            } else {
                $m['elegido'] = iif($m['link']==$miopcion, 1, 0);
            }
   
        
        	$m['orden'] = intval($m['orden']);
        
        	if ($m['nivel']==1) {
        	   $x++;
        	   $Menues[$x] = $m;
            } else {
        	   $Menues[$x]['sub'][] = $m;
            }
        }
        
        $mnu = '';
       	$mnu.= "<ul class='{$bloquemenu['div_css']}' >"."\n";
        $caption = 'caption'.$idioma_elegido;
        $cuantos_items = count($Menues);
        $xx = 0;

        foreach($Menues as $not) {
            
            if($not['tipolink'] == 1) {

                $menu_cat_id = $not['cat_id'];
                $menu_categoria =  busco_categoria_por_id( $menu_cat_id );
                $limite = $menu_categoria['pub_a_mostrar'];
                $orden  = $menu_categoria['ordenar_publicaciones'];

                $publicaciones_categoria = listar_categoria( $menu_cat_id, $limite,$menu_categoria['urlamigable'],$orden);
 
                $not['caption'] = iif( !empty($not[$caption]), $not[$caption], $not['caption1'] );
            	$class = iif($not['elegido']==1,'class="selected"','');

				if ( empty($not['thumb'.$idioma_elegido] ) ) {
					$tn = $not['thumb'.$idioma_default];
				} else {
					$tn = $not['thumb'.$idioma_elegido];
				}
				// Si el menu tiene imagen, la muestro
				if (!empty($tn)) {
					//$tn = URL.$tn;
					$mnu.= "<li><a href='$url/{$menu_categoria['urlamigable']}' $class ><img src='$tn' ></a></li>";
				
				} else {
				
					$mnu.= "<li><a href='$url/{$menu_categoria['urlamigable']}' $class >{$not['caption']}</a>";
				
					if ( $not['elegido']==1 ){ $display="block"; } else {$display="none";}

					$accede = true;    
					if($accede === true and !empty($publicaciones_categoria)) {
					
						$mnu.= '<ul class="ul_n2"  id="s_'.$not['orden'].'" style="display:none" >'."\n";

						foreach($publicaciones_categoria as $pc){
							$caption     = substr($pc['titulo'],0,28);
							$urlamigable = $pc['urlamigable'];
							$class = iif($m['elegido']==1,'n2s','n2');
							$mnu.="<li class='li_n2'>\n";
							$mnu.= "<a href='{$pc['href']}'  title='{$pc['titulo']}' class='$class'>$caption</a>";
							$mnu.="</li>\n";                                    
								
						} // accede=true
						$mnu.="</ul>"; //n2                    
						$mnu.="</li>";                    
					}
					$mnu.="</li>"; 
				}
                

                
            } elseif($not['tipolink']==3) { 

                //-------------------------------------------------------------------------------------------
                //                                                   Menu de Listado de Familias de Productos
                //-------------------------------------------------------------------------------------------

                $not['caption'] = iif( !empty($not[$caption]), $not[$caption], $not['caption1'] );
            	$class = iif($not['elegido']==1,'class="selected"','');
            	
                if ($not['cat_id']>0){
                    $sql = "select * from familias where id={$not['cat_id']}";
                    $rs 		= $db->SelectLimit($sql,1);
                    $x1		 	= $rs->FetchRow();
                    $urlamigable_n1 = URL.'/'.iif( !empty($x1['urlamigable'.$idioma_elegido]), $x1['urlamigable'.$idioma_elegido], $x1['urlamigable1'] );
                    $parent_id = $xl['parent_id'];
                } else {
                    // $urlamigable_n1 = URL.'/familias-de-productos';
                    $urlamigable_n1 = '#';
                    $parent_id = 0;
                }
//              	$mnu.= "<li><a href='$urlamigable_n1~f{$not['cat_id']}' title='".strip_tags($not['caption'])."'";
              	$mnu.= "<li><a href='".CATALOGO."' $class >$candado {$not['caption']}</a>";
            
            	if ( $not['elegido']==1 ){ $display="block"; } else {$display="none";}
                
                $menu_familias = MenuFamilias($not['cat_id']);

                $mnu.= '<ul class="ul_n2"  id="s_'.$not['orden'].'" style="display:none" >'."\n";
                //pr($_SESSION['login']['grupos']);
                foreach($menu_familias as $mf){

                    if ($Config['acceso_productos'] == 2){
                        $accede = accede_a_familias(serialize($mf['grupos']));    
                    } else {
                        $accede = true;    
                    }


                    if($accede === true) {
                        if ($not['cat_id']>0){
                            $urlamigable_n2 = $mf['href'];
                        } else {
                            $urlamigable_n2 = $mf['href'];
                        }
                        $m['caption'] = $mf['nombre'];
                        $class = iif($m['elegido']==1,'n2s','n2');
                        $mnu.="<li class='li_n2'><a href='$urlamigable_n2'  class='$class'>{$m['caption']}</a>";                        
    
                        if (!empty($mf['child'])){
                            
                            
                            
                            $mnu.= '<ul class="ul_n3"  id="s_'.$not['orden'].'" style="display:none" >'."\n";
                                                    
                            foreach($mf['child'] as $mf2){
                                
                                if ($Config['acceso_productos'] == 2){
                                    $accede = accede_a_familias(serialize($mf2['grupos']));    
                                } else {
                                    $accede = true;    
                                }

                                if($accede === true) {            

                                    $urlamigable_n3 = $urlamigable_n2.'/'.iif( !empty($mf2['urlamigable'.$idioma_elegido]), $mf2['urlamigable'.$idioma_elegido], $mf2['urlamigable1'] );
                                    $m['caption'] = iif( !empty($mf2['nombre'.$idioma_elegido]), $mf2['nombre'.$idioma_elegido], $mf2['nombre1'] );
                                    $class = iif($m['elegido']==1,'n2s','n2');
                                    $mnu.="<li class='li_n3'>\n";
//                                    $mnu.= "<a href='$urlamigable_n3~f{$mf2['id']}' title='".strip_tags($m['caption'])."' class='$class'>{$m['caption']}</a>";                            
                                    $mnu.= "<a href='$urlamigable_n3~f{$mf2['id']}'  class='$class'>{$m['caption']}</a>";                                    
        
                                    if (!empty($mf2['child'])){
                                        $mnu.= '<ul class="ul_n4"  id="s_'.$not['orden'].'" style="display:none" >'."\n";                        
                                        
                                        foreach($mf2['child'] as $mf3){

                                            if ($Config['acceso_productos'] == 2){
                                                $accede = accede_a_familias(serialize($mf3['grupos']));    
                                            } else {
                                                $accede = true;    
                                            }


                                            if($accede === true) {            
                                            
                                                $urlamigable_n4 = $urlamigable_n3.'/'.iif( !empty($mf3['urlamigable'.$idioma_elegido]), $mf3['urlamigable'.$idioma_elegido], $mf3['urlamigable1'] );
                                                $m['caption'] = iif( !empty($mf3['nombre'.$idioma_elegido]), $mf3['nombre'.$idioma_elegido], $mf3['nombre1'] );
                                                $class = iif($m['elegido']==1,'n2s','n2');
                                                $mnu.="<li class='li_n3'>\n";
//                                                $mnu.= "<a href='$urlamigable_n4~f{$mf3['id']}' title='".strip_tags($m['caption'])."' class='$class'>{$m['caption']}</a>";
                                                $mnu.= "<a href='$urlamigable_n4~f{$mf3['id']}'  class='$class'>{$m['caption']}</a>";                                                
            
                                                if (!empty($mf3['child'])){
                                                    $mnu.= '<ul class="ul_n5"  id="s_'.$not['orden'].'" style="display:none" >'."\n";                        
                                                    
                                                    foreach($mf3['child'] as $mf4){

                                                        if ($Config['acceso_productos'] == 2){
                                                            $accede = accede_a_familias(serialize($mf4['grupos']));    
                                                        } else {
                                                            $accede = true;    
                                                        }


                                                        if($accede === true) {            
                                                            $urlamigable_n5 = $urlamigable_n4.'/'.iif( !empty($mf4['urlamigable'.$idioma_elegido]), $mf4['urlamigable'.$idioma_elegido], $mf4['urlamigable1'] );
                                                            $m['caption'] = iif( !empty($mf4['nombre'.$idioma_elegido]), $mf4['nombre'.$idioma_elegido], $mf4['nombre1'] );
                                                            $class = iif($m['elegido']==1,'n2s','n2');
                                                            $mnu.="<li class='li_n4'>\n";
//                                                            $mnu.= "<a href='$urlamigable_n5~f{$mf4['id']}' title='".strip_tags($m['caption'])."' class='$class'>{$m['caption']}</a>";
                                                            $mnu.= "<a href='$urlamigable_n5~f{$mf4['id']}'  class='$class'>{$m['caption']}</a>";                                                            
                                                            $mnu.="</li>";
                                                        } //accede=true 4
                                                    }                        
                                                    
                                                    $mnu.="</ul>"; //n3
                                                }
            
                                                $mnu.="</li>";
    
                                        } // accede=true 3                        
                                        
                                    }
                                    $mnu.="</ul>"; //n3                                        
                                }
                                $mnu.="</li>";                                                        
                            
                            } /* accede=true 2 */
                            
                        }
                        
                        $mnu.="</ul>"; //n2                            
                    } // accede=true
                    $mnu.="</li>";                    
                }
                } // foreach
                $mnu.="</ul>"; // class="ul_n2"


            } elseif($not['tipolink'] == 5) { // Listado de Productos desde una familia

                $not['caption'] = iif( !empty($not[$caption]), $not[$caption], $not['caption1'] );
            	$class = iif($not['elegido']==1,'class="selected"','');
            	$candado = iif($not['clave']==1,'<img src="'.IMG.'candado.jpg" style="float:right;margin-right:6px;" border="0">','');

                $sql = "select * from familias where id={$not['cat_id']}";
                $rs 		= $db->SelectLimit($sql,1);
                $x1		 	= $rs->FetchRow();
                $urlamigable_n1 = URL.'/'.iif( !empty($x1['urlamigable'.$idioma_elegido]), $x1['urlamigable'.$idioma_elegido], $x1['urlamigable1'] );

              	$mnu.= "<li><a href='$urlamigable_n1~f{$not['cat_id']}' ";                
                $mnu.= ' '.$class.' >'.$candado.$not['caption'].'</a>';
            
            	if ( $not['elegido']==1 ){ $display="block"; } else {$display="none";}
                
                $menu_familias = ObtieneProductos($not['cat_id']);
//pr($menu_familias);
                $mnu.= '<ul class="ul_n2"  id="s_'.$not['orden'].'" style="display:none" >'."\n";
                //pr($_SESSION['login']['grupos']);
                foreach($menu_familias as $mf){

                    if ($Config['acceso_productos'] == 2){
                        $accede = accede_a_familias(serialize($mf['grupos']));    
                    } else {
                        $accede = true;    
                    }


                    if($accede === true) {
                    
                        $urlamigable_n2 = $urlamigable_n1.'/'.$mf['urlamigable']."~p".$mf['id']."-".$not['cat_id'];

                        $m['caption']   = $mf['titulo'];
                        $class          = iif($m['elegido']==1,'n2s','n2');

                        $mnu.="<li class='li_n2'>\n";
                        $mnu.= "<a href='$urlamigable_n2'  class='$class'>{$m['caption']}</a></li>";                    
                    }
                } // foreach
                $mnu.="</ul>"; // class="ul_n2"



            } else {


                $not['caption'] = iif( !empty($not[$caption]), $not[$caption], $not['caption1'] );
                
                
            	$class = iif($not['elegido']==1,'class="selected"','');
//            	$candado = iif($not['clave']==1,'<img src="'.IMG.'candado.jpg" style="float:right;margin-right:6px;" border="0">','');
    
//            	$mnu.= '<li><a href="'.$not['link'].'" title="'.strip_tags($not['caption']).'" ';

				if ( empty($not['thumb'.$idioma_elegido] ) ) {
					$tn = $not['thumb'.$idioma_default];
				} else {
					$tn = $not['thumb'.$idioma_elegido];
				}
				// Si el menu tiene imagen, la muestro
				if (!empty($tn)) {
					//$tn = URL.$tn;
					$mnu.= "<li><a href='{$not['link']}' $class ><img src='$tn' ></a>";
				
				} else {

					$mnu.= "<li><a href='{$not['link']}' $class >{$not['caption']}</a>";
				}
            
            	if ( $not['elegido']==1 ){ $display="block"; } else {$display="none";}


            	if (!empty($not['sub'])) {
            		if ($display=='none') {
            			foreach($not['sub'] as $m) {
            				if ( $m['elegido']==1 ){ $display="block"; break; }
            			}
            		}
            		$mnu.= '<ul class="ul_n2"  id="s_'.$not['orden'].'" style="display:'.$display.'" >'."\n";
    
                    $zcuantos_items = count($not['sub']);
                    $zz = 0;
    
            		foreach($not['sub'] as $m) {
            		    $m['caption'] = iif( !empty($m[$caption]), $m[$caption], $m['caption1'] );
                          
            		    $mnu.="<li class='li_n2'>\n";
            			$Target = '';
            			if ($m['target']==2) {
            				$Target = 'target=new';
            			}elseif ($m['target']==3){
            				$Target = 'rel="sexylightbox"';
            				$m['link'] = $m['link']."&TB_iframe=true&height=600&width=1000";
            			}
            			if ($m['nivel']==2) {
            				$class = iif($m['elegido']==1,'n2s','n2');
//            				$mnu.= '<a href="'.$m['link'].'" title="'.strip_tags($m['caption']).'" class="'.$class.'">'.$m['caption'].'</a>'."\n";
            				$mnu.= '<a href="'.$m['link'].'"  class="'.$class.'">'.$m['caption'].'</a>'."\n";                            
            			} else {
            				$class = iif($m['elegido']==1,'n3s','n3');
            				$mnu.= "<div class='div_n3' >\n";
//            				$mnu.= '<a href="'.$m['link'].'" title="'.strip_tags($m['caption']).'"  '.$Target.' class="'.$class.'">'.$m['caption'].'</a>'."\n";
            				$mnu.= '<a href="'.$m['link'].'"  '.$Target.' class="'.$class.'">'.$m['caption'].'</a>'."\n";                            
            				$mnu.="</div>\n";
            			}
                        $mnu.="</li>\n";
                        $zz++;
                        if ($zz > 0 and $zz<$zcuantos_items) {
                            $mnu.="<li class='separador_n2'></li>\n"; // n1    
                        }
                        
            		}
            		$mnu.="</ul>\n"; // sub n2
            	}
            }
            
        	$mnu.="</li>\n"; // n1
            
            $xx++;
            if ($xx > 0 and $xx<$cuantos_items) {
                $mnu.="<li class='separador'></li>\n"; // n1    
            }
            
        
        }
        
        $mnu.= "</ul>";
//        </div>\n";
        
    //}



?>