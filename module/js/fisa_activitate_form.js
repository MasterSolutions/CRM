// JavaScript Document
// Apeleaza query pentru fisa activitate -> afiseaza grid linii fisa activitate
<!-- 
//Browser Support Code
function ajaxFunction(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('ajaxDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			$.getScript("/CRM/module/js/fisa_activitate_ore.js");	
		}
	}
	var client = document.getElementById('client').value;
	var queryString = "?client=" + client ;
	ajaxRequest.open("GET", "fisa_query.php" + queryString, true);
	ajaxRequest.send(null); 
	
	
}


//-->
