<?php include_once('Connections/conexiune_db.php'); ?><?php
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
  $updateSQL = sprintf("UPDATE sfa SET codsocietate=%s, solutie=%s, valoare=%s, `data`=%s, comentariu=%s, etapa=%s WHERE codsfa=%s",
                       GetSQLValueString($_POST['codsocietate'], "int"),
                       GetSQLValueString($_POST['solutie'], "text"),
                       GetSQLValueString($_POST['valoare'], "int"),
                       GetSQLValueString($_POST['data'], "date"),
                       GetSQLValueString($_POST['comentariu'], "text"),
                       GetSQLValueString($_POST['etapa'], "text"),
                       GetSQLValueString($_POST['codsfa'], "int"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($updateSQL, $conexiune_db) or die(mysql_error());
}

$maxRows_sfa_detalii = 10;
$pageNum_sfa_detalii = 0;
if (isset($_GET['pageNum_sfa_detalii'])) {
  $pageNum_sfa_detalii = $_GET['pageNum_sfa_detalii'];
}
$startRow_sfa_detalii = $pageNum_sfa_detalii * $maxRows_sfa_detalii;

$colname_sfa_detalii = "-1";
if (isset($_GET['codsfaeID'])) {
  $colname_sfa_detalii = $_GET['codsfaeID'];
}
mysql_select_db($database_conexiune_db, $conexiune_db);
$query_sfa_detalii = sprintf("SELECT sf.*,et.denumireetapa,so.* FROM sfa sf  LEFT JOIN sfa_etape et     ON sf.etapa = et.codsfae    LEFT JOIN societati so      ON so.codsocietate = sf.codsocietate WHERE codsfa = %s", GetSQLValueString($colname_sfa_detalii, "int"));
$query_limit_sfa_detalii = sprintf("%s LIMIT %d, %d", $query_sfa_detalii, $startRow_sfa_detalii, $maxRows_sfa_detalii);
$sfa_detalii = mysql_query($query_limit_sfa_detalii, $conexiune_db) or die(mysql_error());
$row_sfa_detalii = mysql_fetch_assoc($sfa_detalii);

if (isset($_GET['totalRows_sfa_detalii'])) {
  $totalRows_sfa_detalii = $_GET['totalRows_sfa_detalii'];
} else {
  $all_sfa_detalii = mysql_query($query_sfa_detalii);
  $totalRows_sfa_detalii = mysql_num_rows($all_sfa_detalii);
}
$totalPages_sfa_detalii = ceil($totalRows_sfa_detalii/$maxRows_sfa_detalii)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Codsfa:</td>
      <td><?php echo $row_sfa_detalii['codsfa']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Codsocietate:</td>
      <td><input type="text" name="codsocietate" value="<?php echo htmlentities($row_sfa_detalii['codsocietate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Solutie:</td>
      <td><input type="text" name="solutie" value="<?php echo htmlentities($row_sfa_detalii['solutie'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Valoare:</td>
      <td><input type="text" name="valoare" value="<?php echo htmlentities($row_sfa_detalii['valoare'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Data:</td>
      <td><input type="text" name="data" value="<?php echo htmlentities($row_sfa_detalii['data'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Comentariu:</td>
      <td><input type="text" name="comentariu" value="<?php echo htmlentities($row_sfa_detalii['comentariu'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Etapa:</td>
      <td><input type="text" name="etapa" value="<?php echo htmlentities($row_sfa_detalii['etapa'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="codsfa" value="<?php echo $row_sfa_detalii['codsfa']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($sfa_detalii);
?>