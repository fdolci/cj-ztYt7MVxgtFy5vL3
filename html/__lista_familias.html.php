<style type="text/css">
#nav {
    float: left;
    width: 218px;
    border-top: 1px solid #999;
    border-right: 1px solid #999;
    border-left: 1px solid #999;
    margin-left: 0px;
    list-style-type: none;
}
#nav li a {
    display: block;
    padding: 10px 15px;
    background: #ccc;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #999;
    text-decoration: none;
    color: #000;
}
#nav li a:hover, #nav li a.active {
    background: #999;
    color: #fff;
}
#nav li ul {
    display: none; 
    margin-left: 0px;
    list-style-type: none;
}
#nav li ul li a {
    padding: 10px 25px;
    background: #ececec;
    border-bottom: 1px dotted #ccc;
}
</style>


<ul id="nav">
  <li><a href="#">Item 1</a>
    <ul>
      <li><a href="#">Sub-Item 1 a</a></li>
      <li><a href="#">Sub-Item 1 b</a></li>
      <li><a href="#">Sub-Item 1 c</a></li>
    </ul>
  </li>
  <li><a href="#">Item 2</a>
    <ul>
      <li><a href="#">Sub-Item 2 a</a></li>
      <li><a href="#">Sub-Item 2 b</a></li>
    </ul>
  </li>
  <li><a href="#">Item 3</a>
    <ul>
      <li><a href="#">Sub-Item 3 a</a></li>
      <li><a href="#">Sub-Item 3 b</a></li>
      <li><a href="#">Sub-Item 3 c</a></li>
      <li><a href="#">Sub-Item 3 d</a></li>
    </ul>
  </li>
  <li><a href="#">Item 4</a>
    <ul>
      <li><a href="#">Sub-Item 4 a</a></li>
      <li><a href="#">Sub-Item 4 b</a></li>
      <li><a href="#">Sub-Item 4 c</a></li>
    </ul>
  </li>
</ul>


<script type="text/javascript">
$(document).ready(function () {
  $('#nav > li > a').click(function(){
    if ($(this).attr('class') != 'active'){
      $('#nav li ul').slideUp();
      $(this).next().slideToggle();
      $('#nav li a').removeClass('active');
      $(this).addClass('active');
    }
  });
});
</script>