<?php require_once('../../Connections/conexiune_db.php'); ?><?php
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

$maxRows_detalii_persoana = 10;
$pageNum_detalii_persoana = 0;
if (isset($_GET['pageNum_detalii_persoana'])) {
  $pageNum_detalii_persoana = $_GET['pageNum_detalii_persoana'];
}
$startRow_detalii_persoana = $pageNum_detalii_persoana * $maxRows_detalii_persoana;

$colname_detalii_persoana = "-1";
if (isset($_GET['recordID'])) {
  $colname_detalii_persoana = $_GET['recordID'];
}
mysql_select_db($database_conexiune_db, $conexiune_db);
$query_detalii_persoana = sprintf("SELECT persoane.*,utilizatori.utilizator,societati.denumire FROM societati_persoane persoane    LEFT JOIN utilizatori utilizatori ON utilizatori.codpersoana =  persoane.cod_pers  LEFT JOIN societati societati      ON societati.codsocietate = persoane.cod_societatep WHERE cod_pers = %s", GetSQLValueString($colname_detalii_persoana, "int"));
$query_limit_detalii_persoana = sprintf("%s LIMIT %d, %d", $query_detalii_persoana, $startRow_detalii_persoana, $maxRows_detalii_persoana);
$detalii_persoana = mysql_query($query_limit_detalii_persoana, $conexiune_db) or die(mysql_error());
$row_detalii_persoana = mysql_fetch_assoc($detalii_persoana);

if (isset($_GET['totalRows_detalii_persoana'])) {
  $totalRows_detalii_persoana = $_GET['totalRows_detalii_persoana'];
} else {
  $all_detalii_persoana = mysql_query($query_detalii_persoana);
  $totalRows_detalii_persoana = mysql_num_rows($all_detalii_persoana);
}
$totalPages_detalii_persoana = ceil($totalRows_detalii_persoana/$maxRows_detalii_persoana)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalii contact</title>
</head>

<body>

<table border="1" align="center">
  <tr>
    <td>cod_pers</td>
    <td><?php echo $row_detalii_persoana['cod_pers']; ?></td>
  </tr>
  <tr>
    <td>cod_societatep</td>
    <td><?php echo $row_detalii_persoana['cod_societatep']; ?></td>
  </tr>
  <tr>
    <td>Nume</td>
    <td><?php echo $row_detalii_persoana['numep']; ?></td>
  </tr>
  <tr>
    <td>Prenume</td>
    <td><?php echo $row_detalii_persoana['prenumep']; ?></td>
  </tr>
  <tr>
    <td>Telefon</td>
    <td><?php echo $row_detalii_persoana['telefonp']; ?></td>
  </tr>
  <tr>
    <td>E-mail</td>
    <td><?php echo $row_detalii_persoana['emailp']; ?></td>
  </tr>
  <tr>
    <td>Utilizator CRM</td>
    <td><?php echo $row_detalii_persoana['utilizator']; ?></td>
  </tr>
  <tr>
    <td>Societate</td>
    <td><?php echo $row_detalii_persoana['denumire']; ?></td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($detalii_persoana);
?>