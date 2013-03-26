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
  if ((isset($_POST['contactat'])) && ($_POST["contactat"]=="Da")) {
  $updateSQL = sprintf("UPDATE societati SET contactat=%s WHERE codsocietate=%s",
                       GetSQLValueString($_POST['contactat'], "text"),
                       GetSQLValueString($_POST['codsocietate'], "int"));
 				   
    $insertSQL = sprintf("INSERT INTO sfa (codsfa, codsocietate, solutie, valoare, `data`, comentariu, etapa) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codsfa'], "int"),
                       GetSQLValueString($_POST['codsocietate'], "int"),
                       GetSQLValueString($_POST['solutie'], "text"),
                       GetSQLValueString($_POST['valoare'], "int"),
                       GetSQLValueString($_POST['data'], "date"),
                       GetSQLValueString($_POST['comentariu'], "text"),
                       GetSQLValueString($_POST['etapa'], "text"));						   
				

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($updateSQL, $conexiune_db) or die(mysql_error());
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());

  $updateGoTo = "/crm/sfa.php?codsfaID=$_POST[etapa]";

  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
  }

$maxRows_sfa_callaction = 10;
$pageNum_sfa_callaction = 0;
if (isset($_GET['pageNum_sfa_callaction'])) {
  $pageNum_sfa_callaction = $_GET['pageNum_sfa_callaction'];
}
$startRow_sfa_callaction = $pageNum_sfa_callaction * $maxRows_sfa_callaction;

$colname_sfa_callaction = "-1";
if (isset($_GET['recordID'])) {
  $colname_sfa_callaction = $_GET['recordID'];
}
mysql_select_db($database_conexiune_db, $conexiune_db);
$query_sfa_callaction = sprintf("SELECT * FROM societati WHERE codsocietate = %s", GetSQLValueString($colname_sfa_callaction, "int"));
$query_limit_sfa_callaction = sprintf("%s LIMIT %d, %d", $query_sfa_callaction, $startRow_sfa_callaction, $maxRows_sfa_callaction);
$sfa_callaction = mysql_query($query_limit_sfa_callaction, $conexiune_db) or die(mysql_error());
$row_sfa_callaction = mysql_fetch_assoc($sfa_callaction);

if (isset($_GET['totalRows_sfa_callaction'])) {
  $totalRows_sfa_callaction = $_GET['totalRows_sfa_callaction'];
} else {
  $all_sfa_callaction = mysql_query($query_sfa_callaction);
  $totalRows_sfa_callaction = mysql_num_rows($all_sfa_callaction);
}
$totalPages_sfa_callaction = ceil($totalRows_sfa_callaction/$maxRows_sfa_callaction)-1;

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_sfa_etape = "SELECT * FROM sfa_etape";
$sfa_etape = mysql_query($query_sfa_etape, $conexiune_db) or die(mysql_error());
$row_sfa_etape = mysql_fetch_assoc($sfa_etape);
$totalRows_sfa_etape = mysql_num_rows($sfa_etape);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Call Center - detalii</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <?php echo $row_sfa_callaction['codsocietate']; ?><br />
  <?php echo $row_sfa_callaction['denumire']; ?><br />
  <?php echo $row_sfa_callaction['adresa']; ?>
  <br />
  <?php echo $row_sfa_callaction['profil']; ?><br />
  <?php echo $row_sfa_callaction['email']; ?><br />
  <?php echo $row_sfa_callaction['contact']; ?><br />
  <?php echo $row_sfa_callaction['functia']; ?><br />
  <?php echo $row_sfa_callaction['telefon']; ?><br />
  <?php echo $row_sfa_callaction['emailcontact']; ?><br />
  <?php echo $row_sfa_callaction['observatii']; ?>
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Contactat:</td>
      <td>
        <select name="contactat" id="contactat">
          <option value="Da" <?php if (!(strcmp("Da", $row_sfa_callaction['contactat']))) {echo "selected=\"selected\"";} ?>>Da</option>
          <option value="Nu" <?php if (!(strcmp("Nu", $row_sfa_callaction['contactat']))) {echo "selected=\"selected\"";} ?>>Nu</option>
</select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Solutie</td>
      <td><label for="codsocietate">
        <input type="text" name="solutie" value="" size="32" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Valoare</td>
      <td><input type="text" name="valoare" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Data</td>
      <td><input type="text" name="data" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Comentariu</td>
      <td><input type="text" name="comentariu" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Etapa</td>
      <td><label for="etapa"></label>
        <select name="etapa" id="etapa">
          <?php
do {  
?>
          <option value="<?php echo $row_sfa_etape['codsfae']?>"><?php echo $row_sfa_etape['denumireetapa']?></option>
          <?php
} while ($row_sfa_etape = mysql_fetch_assoc($sfa_etape));
  $rows = mysql_num_rows($sfa_etape);
  if($rows > 0) {
      mysql_data_seek($sfa_etape, 0);
	  $row_sfa_etape = mysql_fetch_assoc($sfa_etape);
  }
?>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"></td>
      <td><input type="submit" value="SFA" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="codsocietate" value="<?php echo $row_sfa_callaction['codsocietate']; ?>" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($sfa_callaction);

mysql_free_result($sfa_etape);
?>