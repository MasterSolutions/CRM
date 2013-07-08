<?php virtual('/CRM/Connections/conexiune_db.php'); ?>
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

$maxRows_persoane = 10;
$pageNum_persoane = 0;
if (isset($_GET['pageNum_persoane'])) {
  $pageNum_persoane = $_GET['pageNum_persoane'];
}
$startRow_persoane = $pageNum_persoane * $maxRows_persoane;

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_persoane = "SELECT persoane.*,utilizatori.utilizator,societati.denumire FROM societati_persoane persoane    LEFT JOIN utilizatori utilizatori ON utilizatori.codpersoana =  persoane.cod_pers  LEFT JOIN societati societati      ON societati.codsocietate = persoane.cod_societatep";
$query_limit_persoane = sprintf("%s LIMIT %d, %d", $query_persoane, $startRow_persoane, $maxRows_persoane);
$persoane = mysql_query($query_limit_persoane, $conexiune_db) or die(mysql_error());
$row_persoane = mysql_fetch_assoc($persoane);

if (isset($_GET['totalRows_persoane'])) {
  $totalRows_persoane = $_GET['totalRows_persoane'];
} else {
  $all_persoane = mysql_query($query_persoane);
  $totalRows_persoane = mysql_num_rows($all_persoane);
}
$totalPages_persoane = ceil($totalRows_persoane/$maxRows_persoane)-1;

$queryString_persoane = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_persoane") == false && 
        stristr($param, "totalRows_persoane") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_persoane = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_persoane = sprintf("&totalRows_persoane=%d%s", $totalRows_persoane, $queryString_persoane);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contacte - persoane</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>cod_pers</td>
    <td>cod_societatep</td>
    <td>numep</td>
    <td>prenumep</td>
    <td>telefonp</td>
    <td>emailp</td>
    <td>utilizator</td>
    <td>denumire</td>
    <td>ss</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="persoane_detalii.php?recordID=<?php echo $row_persoane['cod_pers']; ?>"> <?php echo $row_persoane['cod_pers']; ?>&nbsp; </a></td>
      <td><?php echo $row_persoane['cod_societatep']; ?>&nbsp; </td>
      <td><?php echo $row_persoane['numep']; ?>&nbsp; </td>
      <td><?php echo $row_persoane['prenumep']; ?>&nbsp; </td>
      <td><?php echo $row_persoane['telefonp']; ?>&nbsp; </td>
      <td><?php echo $row_persoane['emailp']; ?>&nbsp; </td>
      <td><?php
	  if ($row_persoane['utilizator'] != NULL)
   {?>
   <?php echo $row_persoane['utilizator']; ?><a href="utilizatori_detalii.php?recordID=<?php echo $row_persoane['cod_pers']; ?>"><img src="/CRM/css/pic/Grid/modifica.png" alt="Modifica" width="24" height="24" /></a>
  <?php }
 else
  {?>
   <?php echo $row_persoane['utilizator']; ?><a href="utilizatori_detalii.php?recordID=<?php echo $row_persoane['cod_pers']; ?>"><img src="/CRM/css/pic/Grid/modifica.png" alt="Modifica" width="24" height="24" /></a>
  <?php }
	  
 ?>	
      <td><?php echo $row_persoane['denumire']; ?>&nbsp; </td>
      <td></td>
	  


    <?php } while ($row_persoane = mysql_fetch_assoc($persoane)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_persoane > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_persoane=%d%s", $currentPage, 0, $queryString_persoane); ?>">First</a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_persoane > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_persoane=%d%s", $currentPage, max(0, $pageNum_persoane - 1), $queryString_persoane); ?>">Previous</a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_persoane < $totalPages_persoane) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_persoane=%d%s", $currentPage, min($totalPages_persoane, $pageNum_persoane + 1), $queryString_persoane); ?>">Next</a>
    <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_persoane < $totalPages_persoane) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_persoane=%d%s", $currentPage, $totalPages_persoane, $queryString_persoane); ?>">Last</a>
    <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_persoane + 1) ?> to <?php echo min($startRow_persoane + $maxRows_persoane, $totalRows_persoane) ?> of <?php echo $totalRows_persoane ?>
</body>
</html>
<?php
mysql_free_result($persoane);
?>
