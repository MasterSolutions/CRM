<?php include_once('Connections/conexiune_db.php'); ?>
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
$query_sfa_etape_denumire = "SELECT * FROM sfa_etape";
$sfa_etape_denumire = mysql_query($query_sfa_etape_denumire, $conexiune_db) or die(mysql_error());
$row_sfa_etape_denumire = mysql_fetch_assoc($sfa_etape_denumire);
$totalRows_sfa_etape_denumire = mysql_num_rows($sfa_etape_denumire);

$colname_sfa_etape = "-1";
if (isset($_GET['codsfaID'])) {
  $colname_sfa_etape = $_GET['codsfaID'];
}
mysql_select_db($database_conexiune_db, $conexiune_db);
$query_sfa_etape = sprintf("SELECT sf.*,et.denumireetapa,so.* FROM sfa sf  LEFT JOIN sfa_etape et     ON sf.etapa = et.codsfae    LEFT JOIN societati so      ON so.codsocietate = sf.codsocietate WHERE et.codsfae = %s", GetSQLValueString($colname_sfa_etape, "int"));
$sfa_etape = mysql_query($query_sfa_etape, $conexiune_db) or die(mysql_error());
$row_sfa_etape = mysql_fetch_assoc($sfa_etape);
$totalRows_sfa_etape = mysql_num_rows($sfa_etape);

$queryString_sfa_etape = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_sfa_etape") == false && 
        stristr($param, "totalRows_sfa_etape") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_sfa_etape = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_sfa_etape = sprintf("&totalRows_sfa_etape=%d%s", $totalRows_sfa_etape, $queryString_sfa_etape);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SFA - etape</title>
<script src="/crm/scripts/jquery-1.6.1.min.js" type="text/javascript"></script>
<script src="/crm/scripts/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/crm/scripts/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="/crm/scripts/jquery.dataTables.pagination.js" type="text/javascript"></script>
<script type="text/xml">
<!--
<oa:widgets>
  <oa:widget wid="2586523" binding="#dataTable" />
</oa:widgets>
-->
</script>
<link href="/crm/css/demo_table_jui.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/* BeginOAWidget_Instance_2586523: #dataTable */

	@import url("css/custom/base/jquery.ui.all.css");
	#dataTable {padding: 0;margin:0;width:100%;}
	#dataTable_wrapper{width:100%;}
	#dataTable_wrapper th {cursor:pointer} 
	#dataTable_wrapper tr.odd {color:#000; background-color:#FFF}
	#dataTable_wrapper tr.odd:hover {color:#333; background-color:#CCC}
	#dataTable_wrapper tr.odd td.sorting_1 {color:#000; background-color:#999}
	#dataTable_wrapper tr.odd:hover td.sorting_1 {color:#000; background-color:#666}
	#dataTable_wrapper tr.even {color:#FFF; background-color:#666}
	#dataTable_wrapper tr.even:hover, tr.even td.highlighted{color:#EEE; background-color:#333}
	#dataTable_wrapper tr.even td.sorting_1 {color:#CCC; background-color:#333}
	#dataTable_wrapper tr.even:hover td.sorting_1 {color:#FFF; background-color:#000}
		
/* EndOAWidget_Instance_2586523 */
</style>
</head>

<body>
      <?php do { ?>
  <?php echo "<a href='sfa.php?codsfaID=". $row_sfa_etape_denumire['codsfae'] . "'>" . $row_sfa_etape_denumire['denumireetapa'] . "</a>";?>  
  <?php } while ($row_sfa_etape_denumire = mysql_fetch_assoc($sfa_etape_denumire)); ?>
<br />
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
<?php if ($totalRows_sfa_etape > 0) { // Show if recordset not empty ?>
  <table cellpadding="0" cellspacing="0" border="0" id="dataTable">
    <thead>
      <tr>
        <th>Etapa</th>
        <th>Data</th>
        <th>Solutie</th>
        <th>Valoare</th>
        <th>Societate</th>
        <th>Profil</th>
        <th>Contact</th>
        <th>E-mail</th>
        <th>Vizualizare</th>
      </tr>
    </thead>
    <tbody>
      <?php do { ?>
        <tr>
          <td><?php echo $row_sfa_etape['denumireetapa']; ?></td>
          <td><?php echo date('d-m-Y',strtotime($row_sfa_etape['data']));?></td>
          <td><?php echo $row_sfa_etape['solutie']; ?></td>
          <td><?php echo $row_sfa_etape['valoare']; ?></td>
          <td><?php echo $row_sfa_etape['denumire']; ?></td>
          <td><?php echo $row_sfa_etape['profil']; ?></td>
          <td><?php echo $row_sfa_etape['contact']; ?></td>
          <td><?php echo $row_sfa_etape['emailcontact']; ?></td>
          <td><a href="sfa_detalii.php?codsfaeID=<?php echo $row_sfa_etape['codsfa']; ?>"><img src="/crm/imagini/vizualizare.png" width="24" height="24" /></a></td>
        </tr>
        <?php } while ($row_sfa_etape = mysql_fetch_assoc($sfa_etape)); ?>
    </tbody>
  </table>
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_sfa_etape == 0) { // Show if recordset empty ?>
    Nu exista inregistrari !!!
  <?php } // Show if recordset empty ?>
</body>
</html>
<?php
mysql_free_result($sfa_etape_denumire);

mysql_free_result($sfa_etape);

?>
