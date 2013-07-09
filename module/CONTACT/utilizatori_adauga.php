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
  $insertSQL = sprintf("INSERT INTO utilizatori (coduser, codpersoana, utilizator, parola, permisiuni) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['coduser'], "int"),
                       GetSQLValueString($_POST['codpersoana'], "int"),
                       GetSQLValueString($_POST['utilizator'], "text"),
                       GetSQLValueString($_POST['parola'], "text"),
                       GetSQLValueString($_POST['permisiuni'], "int"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());

  $insertGoTo = "persoane.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_persoane = "SELECT * FROM societati_persoane";
$persoane = mysql_query($query_persoane, $conexiune_db) or die(mysql_error());
$row_persoane = mysql_fetch_assoc($persoane);
$totalRows_persoane = mysql_num_rows($persoane);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Utilizatori - adauga</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">SS:</td>
      <td><input name="coduser" type="hidden" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nume/Prenume:</td>
      <td><?php if ((isset($_GET['recordID'])) && ($_GET['recordID'] != "")) 
   {?>
        <label for="coduser1"></label>
        <label for="codpersoana"></label>
        <select name="codpersoana" id="codpersoana">
          <?php
do {  
?>
          <option value="<?php echo $row_persoane['cod_pers']?>"<?php if (!(strcmp($row_persoane['cod_pers'], $_GET['recordID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_persoane['numep'], ' ' , $row_persoane['prenumep']?></option>
          <?php
} while ($row_persoane = mysql_fetch_assoc($persoane));
  $rows = mysql_num_rows($persoane);
  if($rows > 0) {
      mysql_data_seek($persoane, 0);
	  $row_persoane = mysql_fetch_assoc($persoane);
  }
?>
      </select>
   <?php }
 else
   {?>
   <label for="codpersoana"></label>
        <select name="codpersoana" id="codpersoana">
          <?php
do {  
?>
          <option value="<?php echo $row_persoane['cod_pers']?>"><?php echo $row_persoane['numep'], ' ' , $row_persoane['prenumep']?></option>
          <?php
} while ($row_persoane = mysql_fetch_assoc($persoane));
  $rows = mysql_num_rows($persoane);
  if($rows > 0) {
      mysql_data_seek($persoane, 0);
	  $row_persoane = mysql_fetch_assoc($persoane);
  }
?>
        </select>
    <?php }
	  
 ?>	</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Utilizator:</td>
      <td><input type="text" name="utilizator"  size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Parola:</td>
      <td><input type="text" name="parola" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Permisiuni:</td>
      <td>FRONT-END
        <input name="permisiuni" type="hidden" value="0" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Adauga" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($persoane);
?>
