<span style="color:#000000; font-weight:bold; font-size:12px;">Contenido:</span>

<textarea name='data[contenido<?php echo $i;?>]' id='contenido<?php echo $i;?>' style="width:800px; height:600px;"  class="tinymce"><?php echo $Pub[contenido.$i];?></textarea>
<script type="text/javascript">
	var editor = CKEDITOR.replace( 'contenido<?php echo $i;?>',{ height: '600px'} );
    CKFinder.setupCKEditor( editor, '<?php echo URL;?>/js/ckfinder/' ) ;
</script>