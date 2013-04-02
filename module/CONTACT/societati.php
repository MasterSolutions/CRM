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

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_societati = "SELECT * FROM societati";
$societati = mysql_query($query_societati, $conexiune_db) or die(mysql_error());
$row_societati = mysql_fetch_assoc($societati);
$totalRows_societati = mysql_num_rows($societati);

$currentPage = $_SERVER["PHP_SELF"];

$queryString_societati = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_societati") == false && 
        stristr($param, "totalRows_societati") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_societati = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_societati = sprintf("&totalRows_societati=%d%s", $totalRows_societati, $queryString_societati);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Societati</title>
<?php require_once('../../meniu.php'); ?>
<script src="/crm/scripts/jquery-1.6.1.min.js" type="text/javascript"></script>
<script src="/crm/scripts/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/crm/scripts/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="/crm/scripts/jquery.dataTables.pagination.js" type="text/javascript"></script>
<link href="/CRM/css/demo_table_jui.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/* BeginOAWidget_Instance_2586523: #dataTable */

	@import url("/CRM/css/custom/base/jquery.ui.all.css");
	#dataTable {padding: 0;margin:0;width:100%;}
	#dataTable_wrapper{width:100%;}
	#dataTable_wrapper th {cursor:pointer;} 
	#dataTable_wrapper tr.odd {color:#000; background-color:#FFF;}
	#dataTable_wrapper tr.odd:hover {color:#fff; background-color:#333}
	#dataTable_wrapper tr.odd td.sorting_1 {color:#000; background-color:#EDF5FF; }
	#dataTable_wrapper tr.odd:hover td.sorting_1 {color:#fff; background-color:red}
	#dataTable_wrapper tr.even {color:#000; background-color:#EDF5FF;}
	#dataTable_wrapper tr.even:hover, tr.even td.highlighted{color:#EEE; background-color:#333}
	#dataTable_wrapper tr.even td.sorting_1 {color:#000; background-color:#DBEAFF}
	#dataTable_wrapper tr.even:hover td.sorting_1 {color:#FFF; background-color:red;}
		
/* EndOAWidget_Instance_2586523 */
</style>
</head>

<body>

<script type="text/javascript">
// BeginOAWidget_Instance_2586523: #dataTable

$(document).ready(function() {
	oTable = $('#dataTable').dataTable({
		"bJQueryUI": true,
		"bScrollCollapse": false,
		"sScrollY": "100%",
		"bAutoWidth": true,
		"bPaginate": true,
		"sPaginationType": "two_button", //full_numbers,two_button
		"bStateSave": true,
		"bInfo": true,
		"bFilter": true,
		"iDisplayLength": 10,
		"bLengthChange": true,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Toate"]]
	});
} );
		
// EndOAWidget_Instance_2586523
</script>

  <table cellpadding="0" cellspacing="0" border="0" id="dataTable">
    <thead>
      <tr>
        <th>Denumire</th>
        <th>Adresa</th>
        <th>Profil</th>
        <th>Contact</th>
        <th>Functie</th>
        <th>Telefon</th>
        <th>E-mail</th>
        <th>Contactat</th>
        <th>Observatii</th>
        <th>Editare</th>
        <th>Sterge</th>

      </tr>
    </thead>
    <tbody>

        <?php do { ?>
        <tr>
            <td><?php echo $row_societati['denumire']; ?></td>
          <td align="center"><?php echo $row_societati['adresa']; ?></td>
          <td align="center"><?php echo $row_societati['profil']; ?></td>
          <td align="center"><?php echo $row_societati['contact']; ?></td>
          <td align="center"><?php echo $row_societati['functia']; ?></td>
          <td align="center"><?php echo $row_societati['telefon']; ?></td>
          <td align="center"><?php echo $row_societati['emailcontact']; ?></td>
          <td align="center"><?php echo $row_societati['contactat']; ?></td>
          <td align="center"><?php echo $row_societati['observatii']; ?></td>
            <td align="center"><a href="societati_detalii.php?recordID=<?php echo $row_societati['codsocietate']; ?>"><img src="/crm/pic/modifica.png" alt="Modifica" width="24" height="24" /></a></td>
            <td align="center"><a href="societati_sterge.php?recordID=<?php echo $row_societati['codsocietate']; ?>"><img src="/CRM/pic/sterge.png" alt="Sterge" width="24" height="24" /></a></td>
        </tr>
          <?php } while ($row_societati = mysql_fetch_assoc($societati)); ?>
    </tbody>
  </table>
</body>
</html>
<?php
mysql_free_result($societati);
?>
