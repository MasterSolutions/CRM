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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO societati_persoane (cod_pers, cod_societatep, numep, prenumep, telefonp, emailp) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cod_pers'], "int"),
                       GetSQLValueString($_POST['cod_societatep'], "int"),
                       GetSQLValueString($_POST['numep'], "text"),
                       GetSQLValueString($_POST['prenumep'], "text"),
                       GetSQLValueString($_POST['telefonp'], "text"),
                       GetSQLValueString($_POST['emailp'], "text"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());

  $insertGoTo = "/CRM/module/CONTACT/persoane.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_cod_societate = "SELECT societati.codsocietate, societati.denumire FROM societati";
$cod_societate = mysql_query($query_cod_societate, $conexiune_db) or die(mysql_error());
$row_cod_societate = mysql_fetch_assoc($cod_societate);
$totalRows_cod_societate = mysql_num_rows($cod_societate);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contacte - adauga</title>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cod_societatep:</td>
      <td><label for="cod_societatep"></label>
        <input name="cod_pers" type="hidden" value="" />
        <select name="cod_societatep" id="cod_societatep">
          <?php
do {  
?>
          <option value="<?php echo $row_cod_societate['codsocietate']?>"><?php echo $row_cod_societate['denumire']?></option>
          <?php
} while ($row_cod_societate = mysql_fetch_assoc($cod_societate));
  $rows = mysql_num_rows($cod_societate);
  if($rows > 0) {
      mysql_data_seek($cod_societate, 0);
	  $row_cod_societate = mysql_fetch_assoc($cod_societate);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nume:</td>
      <td><input type="text" name="numep" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Prenume:</td>
      <td><input type="text" name="prenumep" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefon:</td>
      <td><input type="text" name="telefonp" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="emailp" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($cod_societate);
?>
