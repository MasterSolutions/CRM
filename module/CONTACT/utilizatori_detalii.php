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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE utilizatori SET coduser=%s, utilizator=%s, parola=%s, permisiuni=%s WHERE codpersoana=%s",
                       GetSQLValueString($_POST['coduser'], "int"),
                       GetSQLValueString($_POST['utilizator'], "text"),
                       GetSQLValueString($_POST['parola'], "text"),
                       GetSQLValueString($_POST['permisiuni'], "int"),
                       GetSQLValueString($_POST['codpersoana'], "int"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($updateSQL, $conexiune_db) or die(mysql_error());

  $updateGoTo = "persoane.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_utilizatori = "-1";
if (isset($_GET['recordID'])){
  $colname_utilizatori = $_GET['recordID'];
}
mysql_select_db($database_conexiune_db, $conexiune_db);
$query_utilizatori = sprintf("SELECT * FROM utilizatori where codpersoana = %s", GetSQLValueString($colname_utilizatori, "int"));
$utilizatori = mysql_query($query_utilizatori, $conexiune_db) or die(mysql_error());
$row_utilizatori = mysql_fetch_assoc($utilizatori);
$totalRows_utilizatori = mysql_num_rows($utilizatori);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Utilizatori - detalii</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Coduser:</td>
      <td><input type="text" name="coduser" value="<?php echo htmlentities($row_utilizatori['coduser'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Codpersoana:</td>
      <td><?php echo $row_utilizatori['codpersoana']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Utilizator:</td>
      <td><input type="text" name="utilizator" value="<?php echo htmlentities($row_utilizatori['utilizator'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Parola:</td>
      <td><input type="text" name="parola" value="<?php echo htmlentities($row_utilizatori['parola'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Permisiuni:</td>
      <td><input type="text" name="permisiuni" value="<?php echo htmlentities($row_utilizatori['permisiuni'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="codpersoana" value="<?php echo $row_utilizatori['codpersoana']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($utilizatori);
?>
