<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<script language="javascript" type="text/javascript">
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
		}
	}
	var age = document.getElementById('age').value;
	var wpm = document.getElementById('wpm').value;
	var sex = document.getElementById('sex').value;
	var queryString = "?age=" + age + "&wpm=" + wpm + "&sex=" + sex;
	ajaxRequest.open("GET", "ajax-example.php" + queryString, true);
	ajaxRequest.send(null); 
}

//-->
</script>



<form name='myForm'>
Max Age: <input name="" type='text' id='age' /> <br />
Max WPM: <input name="" type='text' id='wpm' onkeyup="ajaxFunction()"  />
<br />
Sex: <select id='sex' onclick='ajaxFunction()' value='Query MySQL' > 
<option value='m'>m</option>
<option value='f'>f</option>
</select>
</form>
<div id='ajaxDiv'>Your result will display here</div>
</body>
</html>