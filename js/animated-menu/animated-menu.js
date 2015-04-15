$(document).ready(function(){  
  
    //When mouse rolls over  
    $("#am li").mouseover(function(){  
        $(this).stop().animate({height:'90px'},{queue:false, duration:600, easing: 'easeOutBounce'})  
    });  
  
    //When mouse is removed  
    $("#am li").mouseout(function(){  
        $(this).stop().animate({height:'75px'},{queue:false, duration:600, easing: 'easeOutBounce'})  
    });  
  
});  