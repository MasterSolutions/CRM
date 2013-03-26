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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO sfa_etape (codsfae, denumiresolutie,ordine) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['codsfae'], "int"),
                       GetSQLValueString($_POST['denumiresolutie'], "text"),
					   GetSQLValueString($_POST['ordine'], "text"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());

  $insertGoTo = "/crm/sfa_etape.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_etape = 10;
$pageNum_etape = 0;
if (isset($_GET['pageNum_etape'])) {
  $pageNum_etape = $_GET['pageNum_etape'];
}
$startRow_etape = $pageNum_etape * $maxRows_etape;

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_etape = "SELECT * FROM sfa_etape ORDER BY sfa_etape.ordine";
$query_limit_etape = sprintf("%s LIMIT %d, %d", $query_etape, $startRow_etape, $maxRows_etape);
$etape = mysql_query($query_limit_etape, $conexiune_db) or die(mysql_error());
$row_etape = mysql_fetch_assoc($etape);

if (isset($_GET['totalRows_etape'])) {
  $totalRows_etape = $_GET['totalRows_etape'];
} else {
  $all_etape = mysql_query($query_etape);
  $totalRows_etape = mysql_num_rows($all_etape);
}
$totalPages_etape = ceil($totalRows_etape/$maxRows_etape)-1;

$queryString_etape = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_etape") == false && 
        stristr($param, "totalRows_etape") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_etape = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_etape = sprintf("&totalRows_etape=%d%s", $totalRows_etape, $queryString_etape);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SFA - etape</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>ID intern</td>
    <td>Denumire etapa</td>
    <td>Ordine</td>
    <td>Modifica</td>
    <td>Sterge</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_etape['codsfae']; ?></td>
      <td><?php echo $row_etape['denumiresolutie']; ?>&nbsp; </td>
      <td><?php echo $row_etape['ordine']; ?></td>
      <td><a href="sfa_etape_detalii.php?recordID=<?php echo $row_etape['codsfae']; ?>"><img src="/crm/imagini/modifica.png" alt="Modifica" width="24" height="24" /></a></td>
      <td><a href="sfa_etape_sterge.php?recordID=<?php echo $row_etape['codsfae']; ?>"><img src="imagini/sterge.png" alt="Sterge" width="24" height="24" /></a></td>
    </tr>
    <?php } while ($row_etape = mysql_fetch_assoc($etape)); ?>
    <tr>
      <td colspan="5"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC"><strong>ADAUGA ETAPA</strong></td>
      </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Denumire:</td>
      <td><input type="text" name="denumiresolutie" value="" size="32" /></td>
      </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Ordine</td>
      <td><input type="text" name="ordine" value="" size="32" /></td>
      </tr>
    <tr valign="baseline">
      <td height="26" align="right" nowrap="nowrap"><input name="codsfae" type="hidden" value="" /></td>
      <td><input type="submit" value="Adauga" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form></td>
    </tr>
</table>
<p>&nbsp;</p>
<p><br />
</p>

<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($etape);
?>
