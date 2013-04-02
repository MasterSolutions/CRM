<?php virtual('../../Connections/conexiune_db.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO sfa (codsfa, codsocietate, solutie, valoare, `data`, comentariu, etapa) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codsfa'], "int"),
                       GetSQLValueString($_POST['codsocietate'], "int"),
                       GetSQLValueString($_POST['solutie'], "text"),
                       GetSQLValueString($_POST['valoare'], "int"),
                       GetSQLValueString($_POST['data'], "date"),
                       GetSQLValueString($_POST['comentariu'], "text"),
                       GetSQLValueString($_POST['etapa'], "text"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());
}

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_societati = "SELECT * FROM societati";
$societati = mysql_query($query_societati, $conexiune_db) or die(mysql_error());
$row_societati = mysql_fetch_assoc($societati);
$totalRows_societati = mysql_num_rows($societati);

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_etape = "SELECT * FROM sfa_etape";
$etape = mysql_query($query_etape, $conexiune_db) or die(mysql_error());
$row_etape = mysql_fetch_assoc($etape);
$totalRows_etape = mysql_num_rows($etape);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SFA - adauga etapa</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" >
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Codsocietate:</td>
      <td><label for="codsocietate"></label>
        <select name="codsocietate" id="codsocietate">
          <?php
do {  
?>
          <option value="<?php echo $row_societati['codsocietate']?>"><?php echo $row_societati['denumire']?></option>
          <?php
} while ($row_societati = mysql_fetch_assoc($societati));
  $rows = mysql_num_rows($societati);
  if($rows > 0) {
      mysql_data_seek($societati, 0);
	  $row_societati = mysql_fetch_assoc($societati);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Solutie:</td>
      <td><input type="text" name="solutie" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Valoare:</td>
      <td><input type="text" name="valoare" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Data:</td>
      <td><input type="text" name="data" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Comentariu:</td>
      <td><input type="text" name="comentariu" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Etapa:</td>
      <td><label for="etapa"></label>
        <select name="etapa" id="etapa">
          <?php
do {  
?>
          <option value="<?php echo $row_etape['codsfae']?>"><?php echo $row_etape['denumireetapa']?></option>
          <?php
} while ($row_etape = mysql_fetch_assoc($etape));
  $rows = mysql_num_rows($etape);
  if($rows > 0) {
      mysql_data_seek($etape, 0);
	  $row_etape = mysql_fetch_assoc($etape);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><input name="codsfa" type="hidden" value="" /></td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($societati);
mysql_free_result($etape);
?>
