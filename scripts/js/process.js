$(document).ready(function(){
	
	$('#start').live('click',function(){
		if($('#nim').val() == '')
		{
			$.message("Error Input","Mohon masukan nim anda untuk mulai memilih",350,100);
		}else{
			getPage($('#go').val());
		}
	});
	$('#nim').live('keyup',function(evt){
		if(!checknumber($(this).val()) && evt.keyCode != 13)
		{
			$.message("Error Input","Masukan angka untuk nim",300,80);
			$(this).val('');
		}else{
			if(evt.keyCode == 13 && checknumber($(this).val()))
			{
				getPage($('#go').val());
			}
		}
	});
	
	function checknumber(v){
		var x=v
        var anum=/(^\d+$)|(^\d+\.\d+$)/
        if (anum.test(x))
        	res=true
        else{
			res=false
        }
        return (res)
    }
    
    function getPage(url)
    {
    	$.ajax({
    		url:url,
    		type:'POST',
    		data:{'nim':$('#nim').val()},
    		dataType:'html',
    		success:function(x){
    			if(x == 'error')
    			{
    				$.message("Error","Error Koneksi, mohon hubungin administrator",300,null);
    			}else if(x == 'lock'){
    				$.message("Locked","Maaf status anda belum unlock, mohon hubungi admin untuk unlock",300,null);
    			}else{
    				
    			}
    		},error:function(){
    			$.message("Error","Error Koneksi, mohon hubungin administrator",300,null);
    		}
    	});
    }
});
