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
setlocale(LC_TIME, array('ro.utf-8', 'ro_RO.UTF-8', 'ro_RO.utf-8', 'ro', 'ro_RO', 'ro_RO.ISO8859-2')); 
$lunaan = strftime('%B-%Y',time());
$ziua = strftime('%d',time());
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
	// Retrieve data from Query String
$client = $_GET['client'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO activitate (cod_client, nr_fisa, ziua, lunaan, explicatii, ora_inc, ora_fin, total_ore) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cod_client'], "int"),
                       GetSQLValueString($_POST['nr_fisa'], "int"),
                       GetSQLValueString($_POST['ziua'], "text"),
                       GetSQLValueString($_POST['lunaan'], "text"),
                       GetSQLValueString($_POST['explicatii'], "text"),
                       GetSQLValueString($_POST['ora_inc'], "text"),
                       GetSQLValueString($_POST['ora_fin'], "text"),
                       GetSQLValueString($_POST['total_ore'], "int"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());

  $insertGoTo = "fisa_activitate.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}



mysql_select_db($database_conexiune_db, $conexiune_db);
$query_numar_doc = "SELECT * FROM activitate WHERE cod_client = '$client' and lunaan='$lunaan'  ORDER BY activitate.ziua ASC";
$numar_doc = mysql_query($query_numar_doc, $conexiune_db) or die(mysql_error());
$row_numar_doc = mysql_fetch_assoc($numar_doc);
$totalRows_numar_doc = mysql_num_rows($numar_doc);
?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table border="1" align="center">
          <?php if ($totalRows_numar_doc > 0) { // Show if recordset not empty ?>
      <tr valign="baseline" bgcolor="#00FFFF">
          <td colspan="7">Alte activitati in luna curenta - Inregistrari: <?php echo $totalRows_numar_doc ?></td>
      </tr>
      <?php do { ?>
        <tr valign="baseline">
          <td><?php echo $row_numar_doc['cod_client']; ?></td>
          <td><?php echo $row_numar_doc['nr_fisa']; ?></td>
          <td><?php echo $row_numar_doc['ziua']; ?></td>
          <td><?php echo $row_numar_doc['explicatii']; ?></td>
          <td><?php echo $row_numar_doc['ora_inc']; ?></td>
          <td><?php echo $row_numar_doc['ora_fin']; ?></td>
          <td><?php echo $row_numar_doc['total_ore']; ?></td>
        </tr>
        <?php } while ($row_numar_doc = mysql_fetch_assoc($numar_doc)); ?>
<?php while ($row_numar_doc = mysql_fetch_assoc($numar_doc)); ?>
<?php } // Show if recordset not empty ?>
<tr valign="baseline" bgcolor="#00FFFF">
        <td colspan="7">Adauga activitate:</td>
    </tr>
    <tr valign="baseline">
      <td>Cod_client:</td>
      <td>Numar fisa</td>
      <td>Ziua</td>
      <td>Explicatii</td>
      <td>Ora inceput</td>
      <td>Ora sfarsit</td>
      <td>Total</td>
    </tr>
    <tr valign="baseline">
      <td><input name="lunaan" type="hidden" id="lunaan" value="<?php echo $lunaan ?>" />        <input name="cod_client" type="text" value="<?php echo $client; ?>" size="2" readonly="readonly"></td>
      <td><input name="nr_fisa" type="text" value="<?php echo $totalRows_numar_doc+1 ?>" readonly="readonly" /></td>
      <td><input name="ziua" type="text" id="ziua" value="<?php echo $ziua ?>" size="2" /></td>
      <td><input type="text" name="explicatii" value="" size="32"></td>
      <td><input type="text" name="ora_inc" value="" size="5"></td>
      <td><input type="text" name="ora_fin" value="" size="5"></td>
      <td><input type="text" name="total_ore" value="" size="5"></td>
    </tr>
    <tr valign="baseline">
      <td colspan="7"><input type="submit" name="submit" id="submit" value="Submit"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<?php
mysql_free_result($numar_doc);
?>
