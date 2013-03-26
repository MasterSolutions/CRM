<?php require_once('Connections/conexiune_db.php'); ?><?php
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
  $updateSQL = sprintf("UPDATE sfa_etape SET denumire=%s, ordine=%s WHERE codsfae=%s",
                       GetSQLValueString($_POST['denumire'], "text"),
                       GetSQLValueString($_POST['ordine'], "int"),
                       GetSQLValueString($_POST['codsfae'], "int"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($updateSQL, $conexiune_db) or die(mysql_error());

  $updateGoTo = "/crm/sfa_etape.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_detalii_etape = 10;
$pageNum_detalii_etape = 0;
if (isset($_GET['pageNum_detalii_etape'])) {
  $pageNum_detalii_etape = $_GET['pageNum_detalii_etape'];
}
$startRow_detalii_etape = $pageNum_detalii_etape * $maxRows_detalii_etape;

$colname_detalii_etape = "-1";
if (isset($_GET['recordID'])) {
  $colname_detalii_etape = $_GET['recordID'];
}
mysql_select_db($database_conexiune_db, $conexiune_db);
$query_detalii_etape = sprintf("SELECT * FROM sfa_etape WHERE codsfae = %s", GetSQLValueString($colname_detalii_etape, "int"));
$query_limit_detalii_etape = sprintf("%s LIMIT %d, %d", $query_detalii_etape, $startRow_detalii_etape, $maxRows_detalii_etape);
$detalii_etape = mysql_query($query_limit_detalii_etape, $conexiune_db) or die(mysql_error());
$row_detalii_etape = mysql_fetch_assoc($detalii_etape);

if (isset($_GET['totalRows_detalii_etape'])) {
  $totalRows_detalii_etape = $_GET['totalRows_detalii_etape'];
} else {
  $all_detalii_etape = mysql_query($query_detalii_etape);
  $totalRows_detalii_etape = mysql_num_rows($all_detalii_etape);
}
$totalPages_detalii_etape = ceil($totalRows_detalii_etape/$maxRows_detalii_etape)-1;

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_count = "SELECT sfa_etape.codsfae FROM sfa_etape";
$count = mysql_query($query_count, $conexiune_db) or die(mysql_error());
$row_count = mysql_fetch_assoc($count);
$totalRows_count = mysql_num_rows($count);

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_detalii_etape_count = "SELECT sfa_etape.codsfae FROM sfa_etape";
$detalii_etape_count = mysql_query($query_detalii_etape_count, $conexiune_db) or die(mysql_error());
$row_detalii_etape_count = mysql_fetch_assoc($detalii_etape_count);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Etape - modificare</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Codsfae:</td>
      <td><?php echo $row_detalii_etape['codsfae']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Denumire:</td>
      <td><input type="text" name="denumire" value="<?php echo htmlentities($row_detalii_etape['denumire'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ordine:</td>
      <td><input type="text" name="ordine" value="<?php echo htmlentities($row_detalii_etape['ordine'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"></td>
      <td><p>
        <input type="submit" value="Salveaza" />
</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="codsfae" value="<?php echo $row_detalii_etape['codsfae']; ?>" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($detalii_etape);

mysql_free_result($count);

mysql_free_result($detalii_etape_count);
?>