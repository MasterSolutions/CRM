<?php require_once('../../Connections/conexiune_db.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_societati = "SELECT societati.codsocietate, societati.denumire FROM societati";
$societati = mysql_query($query_societati, $conexiune_db) or die(mysql_error());
$row_societati = mysql_fetch_assoc($societati);
$totalRows_societati = mysql_num_rows($societati);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fisa activitate</title>
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
	var client = document.getElementById('client').value;
	var queryString = "?client=" + client ;
	ajaxRequest.open("GET", "fisa_query.php" + queryString, true);
	ajaxRequest.send(null); 
}

//-->
</script>



<form name='myForm'>
  <select name="client" id="client" onblur="ajaxFunction()" onclick='ajaxFunction()' value='Query MySQL'>
      <?php
do {  
?>
    <option value="<?php echo $row_societati['codsocietate']?>"><?php echo $row_societati['denumire']?></option>
      <?php
} while ($row_societati = mysql_fetch_assoc($societati));
  $rows = mysql_num_rows($societati);
  if($rows > 0) {
      mysql_data_seek($societati, 0);
	  $row_societati = mysql_fetch_assoc($societati);
  }
?>
  </select>
  <label for="client"></label>
</form>
<div id='ajaxDiv'>Your result will display here</div>
</body>
</html>
<?php
mysql_free_result($societati);
?>
