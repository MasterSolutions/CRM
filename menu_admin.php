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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "menudb")) {
  $insertSQL = sprintf("INSERT INTO meniu (nume_meniu, tip, parinte) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nume_meniu'], "text"),
                       GetSQLValueString($_POST['tip_meniu'], "int"),
                       GetSQLValueString($_POST['parinte'], "int"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "menudb2")) {
  $insertSQL = sprintf("INSERT INTO meniu (nume_meniu, tip, parinte) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nume_submeniu'], "text"),
                       GetSQLValueString($_POST['tip_submeniu'], "int"),
                       GetSQLValueString($_POST['meniu'], "int"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());
}

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_Meniu = "SELECT * FROM meniu where tip=0";
$Meniu = mysql_query($query_Meniu, $conexiune_db) or die(mysql_error());
$row_Meniu = mysql_fetch_assoc($Meniu);
$totalRows_Meniu = mysql_num_rows($Meniu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrare meniu</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="menudb" method="POST">
<div id="container">
<div id="menu" style="border:1px #000 solid; height:100px; width:500px; margin:0 auto;" align="center">
<legend>
Nume meniu :
<input type="text" id="m1nameid" name="nume_meniu" />
</legend>
<input type="submit" name="submit" id="submitid" /> 
<input name="tip_meniu" type="hidden" id="m1nameid2" value="0" />
<input name="parinte" type="hidden" id="m1nameid3" value="0" />
<input type="hidden" name="MM_insert" value="menudb" />
</div>
</div>

</div>
</form>
<form action="<?php echo $editFormAction; ?>" name="menudb2" method="POST">
<div id="container">
<div id="menu" style="border:1px #000 solid; height:100px; width:500px; margin:0 auto;" align="center">
<legend>
<select name="meniu" id="meniu">
  <?php
do {  
?>
  <option value="<?php echo $row_Meniu['id_meniu']?>"<?php if (!(strcmp($row_Meniu['id_meniu'], $row_Meniu['id_meniu']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Meniu['nume_meniu']?></option>
  <?php
} while ($row_Meniu = mysql_fetch_assoc($Meniu));
  $rows = mysql_num_rows($Meniu);
  if($rows > 0) {
      mysql_data_seek($Meniu, 0);
	  $row_Meniu = mysql_fetch_assoc($Meniu);
  }
?>
</select>

Nume submeniu : <br />
<input type="text" name="nume_submeniu" id="nume_submeniu" />
<input name="tip_submeniu" type="hidden" id="m1nameid4" value="1" />
<br />
<input type="submit" name="submit1" id="submitid2" />
<br />
</legend>
</div>
</div>
<input type="hidden" name="MM_insert" value="menudb2" />
</form>
</body>
</html>
<?php
mysql_free_result($Meniu);
?>
