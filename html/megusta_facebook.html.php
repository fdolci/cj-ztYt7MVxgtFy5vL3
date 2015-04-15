<div id="fb-root"></div>
            <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=<?php echo $Config['facebook_app_id'];?>";
                  fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like-box" data-href="https://www.facebook.com/<?php echo $RedesSociales['facebook']['username'];?>" data-width="380" data-height="290" data-show-faces="true" data-stream="false" data-header="true" 
        style="background-color: #FFF;margin-left:0px;border:none;"></div>
