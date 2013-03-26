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
$q=$_GET["q"];
mysql_select_db($database_conexiune_db, $conexiune_db);
$query_get_societatiietati = "SELECT * FROM societati WHERE codsocietate = '".$q."'";
$get_societatiietati = mysql_query($query_get_societatiietati, $conexiune_db) or die(mysql_error());
$row_get_societatiietati = mysql_fetch_assoc($get_societatiietati);
$totalRows_get_societatiietati = mysql_num_rows($get_societatiietati);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalii facturare</title>
</head>

<body>
<p>
  <input name="denumire" type="text" value="<?php echo $row_get_societatiietati['denumire']; ?>" />
</p>
<p>
  <input name="email" type="text" value="<?php echo $row_get_societatiietati['email']; ?>" />
</p>
<p>
<input name="codsocietate" type="text" value="<?php echo $row_get_societatiietati['codsocietate']; ?>" />
</p>
</body>
</html>
<?php
mysql_free_result($get_societatiietati);
?>
