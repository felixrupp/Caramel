
$(document).ready(function(){
	
	
	// Menu
	if($("#adminnavigation").length>0) {
		
		$("#adminnavigation li a").click(function(event){
			event.preventDefault();
			
			var data = $(this).attr("href").substring(1);
			
			$.ajax({
	        	method: "GET",
	        	url: "ajaxCommand.php",
	        	data: data,
	        	success: function(html) {
	        		        	
	        		$("#content").html(html);
	        
	        	},
	        	error: function(html) {
	        	    alert("Fehler: "+html);               
	        	}
	        	
	    	});
			
		});
		
	}
	
});