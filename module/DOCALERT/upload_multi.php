<script>
 function showSocietate(str)
 {
 if (str=="")
   {
   document.getElementById("txtHint").innerHTML="";
   return;
   } 
 if (window.XMLHttpRequest)
   {// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
   }
 else
   {// code for IE6, IE5
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
 xmlhttp.onreadystatechange=function()
   {
   if (xmlhttp.readyState==4 && xmlhttp.status==200)
     {
     document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
     }
   }
 xmlhttp.open("GET","upload_factura_soc.php?q="+str,true);
 xmlhttp.send();
 }
 </script>
<?php require_once('Connections/conexiune_db.php'); ?>
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
$query_upload_facturi = "SELECT codsocietate, denumire, email FROM societati WHERE client=1";
$upload_facturi = mysql_query($query_upload_facturi, $conexiune_db) or die(mysql_error());
$row_upload_facturi = mysql_fetch_assoc($upload_facturi);
$totalRows_upload_facturi = mysql_num_rows($upload_facturi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documente emise</title>
</head>

<body>
<form action="upload_multi1.php" method="POST" enctype="multipart/form-data" id="form1">
	<input type="file" name="files[]" multiple/>
    <select name="societate" id="societate" onclick="showSocietate(this.value)">
    <option value="------------------------" <?php if (!(strcmp("------------------------", $row_upload_facturi['denumire']))) {echo "selected=\"selected\"";} ?>>------------------</option>
    <?php
do {  
?>
    <option value="<?php echo $row_upload_facturi['codsocietate']?>"<?php if (!(strcmp($row_upload_facturi['codsocietate'], $row_upload_facturi['denumire']))) {echo "selected=\"selected\"";} ?>><?php echo $row_upload_facturi['denumire']?></option>
    <?php
} while ($row_upload_facturi = mysql_fetch_assoc($upload_facturi));
  $rows = mysql_num_rows($upload_facturi);
  if($rows > 0) {
      mysql_data_seek($upload_facturi, 0);
	  $row_upload_facturi = mysql_fetch_assoc($upload_facturi);
  }
?>
  </select>
</h2>
 <div id="txtHint"><b>Person info will be listed here.</b></div>
	<input type="submit"/>
</form>
</body>
</html>