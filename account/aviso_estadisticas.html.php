<h3>SEO, Optimización para los buscadores (Google, Yahoo, Bing, etc.)</h3>

<div class='grid_2 ctitulo' >Meta Title:</div>
<div class='grid_8'>
    <input type='text'  name='metatitle' id="metatitle" value="<?php echo $data['metatitle'];?>" size='90' maxlength='150' class="required"/>
</div>

<div class='grid_2 ctitulo' >Meta Keywords:</div>
<div class='grid_8'>
    <input type='text' name='keywords' id='keywords' value='<?php echo $data['keywords'];?>' size='90' maxlength='255' class="required" />
</div>

<div class='grid_2 ctitulo' >Meta Description:<small ><br>Máximo:2 renglones</small></div>
<div class='grid_8'>
    <textarea name='metadescripcion' id='metadescripcion' style='width:575px; height:40px;' class="required" ><?php echo $data['metadescripcion'];?></textarea>
</div>
