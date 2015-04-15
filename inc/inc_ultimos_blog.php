<style>
#ultimos_blogs{

}

#ultimos_blogs h2{

}
#ultimos_blogs ul{
    margin-left:0px;
}

#ultimos_blogs li {
    font-size:12px;
    height:57px;
    overflow:hidden;
    margin-bottom: 10px;
}

#ultimos_blogs li a{
    color:#000;
    text-decoration:underline;
    font-size: 13px;
    font-weight:bold;
}
#ultimos_blogs li img{
    width:60px;
    height:48px;
    float:left;
    margin-right:5px;
    border:1px solid #CCC;
    padding:2px;
}

</style>

<?php
    $idioma_elegido = $_SESSION['idioma'];

    // Busco todas las publicaciones marcadas como destacado
    $Blog = busco_categoria_por_url('blog');

    $ultimos_blogs = listar_categoria($Blog['id'], 3,'', $Blog['ordenar_publicaciones']);

    //pr($ultimos_blogs);
    $resultado = "<div id='ultimos_blogs'>";
    $resultado.= "<h2>Últimas entradas del Blog</h2>";
    $resultado.= "<ul>";
    foreach($ultimos_blogs as $m){
        $resultado.= "<li>";
        $resultado.= "<img src='{$m['thumbs1']}' >";
        $resultado.= date($Traducciones['formato_fecha'],$m['fecha'])." → <a href='{$m['href']}' title='{$m['titulo']} - ".strip_tags($m['copete'])."'>";
        $resultado.= "{$m['titulo']}:</a>&nbsp;&nbsp;{$m['copete']}";
        $resultado.= "</li>";
    }
        
    $resultado.="</ul>\n</div>\n";
    echo $resultado;   
?>