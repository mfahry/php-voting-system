 $(document).ready(function(){
 	jQuery.message = function(t,m,w,h){
 		var id = $('#windowmodal');
 		var tit = $('#titlemodal');
 		var msg = $('#messagemodal');
 		// mask action
 		$('#mask').fadeTo(500,0.8);
                    
        var windowWidth = $(window).width();
        var windowHeight = $(document).height();
        
        if(h == null)
        {
        	id.css('width',w).css('height','auto');
        }else{
        	id.css('width',w).css('height',h);
        }
        tit.html(t);
        msg.html(m);
        id.css('top',(windowHeight-($(id).height()+200))/2+'px').css('left',(windowWidth-$(id).width())/2+'px');
        id.fadeIn();
                    
        $('#mask').click(function(){
	        $(this).fadeOut();
	        $(id).hide();
        });
                    
        $(window).resize(function(){
	        var windowWidth = $(window).width();
	        var windowHeight = $(document).height();
	
	        id.css('top',(windowHeight-$(id).height())/2+'px').css('left',(windowWidth-$(id).width())/2+'px');
        });
                    
        return false;
 	}
 });