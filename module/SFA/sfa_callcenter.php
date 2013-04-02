<?php include_once('../../Connections/conexiune_db.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_sfa_callcenter = 10;
$pageNum_sfa_callcenter = 0;
if (isset($_GET['pageNum_sfa_callcenter'])) {
  $pageNum_sfa_callcenter = $_GET['pageNum_sfa_callcenter'];
}
$startRow_sfa_callcenter = $pageNum_sfa_callcenter * $maxRows_sfa_callcenter;

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_sfa_callcenter = "SELECT * FROM societati WHERE contactat='Nu'";
$query_limit_sfa_callcenter = sprintf("%s LIMIT %d, %d", $query_sfa_callcenter, $startRow_sfa_callcenter, $maxRows_sfa_callcenter);
$sfa_callcenter = mysql_query($query_limit_sfa_callcenter, $conexiune_db) or die(mysql_error());
$row_sfa_callcenter = mysql_fetch_assoc($sfa_callcenter);

if (isset($_GET['totalRows_sfa_callcenter'])) {
  $totalRows_sfa_callcenter = $_GET['totalRows_sfa_callcenter'];
} else {
  $all_sfa_callcenter = mysql_query($query_sfa_callcenter);
  $totalRows_sfa_callcenter = mysql_num_rows($all_sfa_callcenter);
}
$totalPages_sfa_callcenter = ceil($totalRows_sfa_callcenter/$maxRows_sfa_callcenter)-1;

$queryString_sfa_callcenter = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_sfa_callcenter") == false && 
        stristr($param, "totalRows_sfa_callcenter") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_sfa_callcenter = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_sfa_callcenter = sprintf("&totalRows_sfa_callcenter=%d%s", $totalRows_sfa_callcenter, $queryString_sfa_callcenter);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Call Center - vizualizare lista</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>codsocietate</td>
    <td>denumire</td>
    <td>profil</td>
    <td>contact</td>
    <td>observatii</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="sfa_callcenter_detalii.php?recordID=<?php echo $row_sfa_callcenter['codsocietate']; ?>"> <?php echo $row_sfa_callcenter['codsocietate']; ?>&nbsp; </a></td>
      <td><?php echo $row_sfa_callcenter['denumire']; ?>&nbsp; </td>
      <td><?php echo $row_sfa_callcenter['profil']; ?>&nbsp; </td>
      <td><?php echo $row_sfa_callcenter['contact']; ?></td>
      <td><?php echo $row_sfa_callcenter['observatii']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_sfa_callcenter = mysql_fetch_assoc($sfa_callcenter)); ?>
</table>
<br />
</body>
</html>
<?php
mysql_free_result($sfa_callcenter);
?>
