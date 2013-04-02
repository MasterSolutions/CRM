<?php require_once('../../Connections/conexiune_db.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index1.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE societati SET denumire=%s, adresa=%s, cui=%s, regcom=%s, profil=%s, email=%s, contact=%s, functia=%s, telefon=%s, emailcontact=%s, contactat=%s, observatii=%s, utilizator=%s, parola=%s WHERE codsocietate=%s",
                       GetSQLValueString($_POST['denumire'], "text"),
                       GetSQLValueString($_POST['adresa'], "text"),
                       GetSQLValueString($_POST['cui'], "text"),
                       GetSQLValueString($_POST['regcom'], "text"),
                       GetSQLValueString($_POST['profil'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString($_POST['functia'], "text"),
                       GetSQLValueString($_POST['telefon'], "text"),
                       GetSQLValueString($_POST['emailcontact'], "text"),
                       GetSQLValueString($_POST['contactat'], "int"),
                       GetSQLValueString($_POST['observatii'], "text"),
                       GetSQLValueString($_POST['utilizator'], "text"),
                       GetSQLValueString($_POST['parola'], "text"),
                       GetSQLValueString($_POST['codsocietate'], "int"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($updateSQL, $conexiune_db) or die(mysql_error());

  $updateGoTo = "societati.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE societati SET denumire=%s, adresa=%s, cui=%s, regcom=%s, profil=%s, email=%s, contact=%s, functia=%s, telefon=%s, emailcontact=%s, contactat=%s, observatii=%s,client=%s, utilizator=%s, parola=%s WHERE codsocietate=%s",
                       GetSQLValueString($_POST['denumire'], "text"),
                       GetSQLValueString($_POST['adresa'], "text"),
                       GetSQLValueString($_POST['cui'], "text"),
                       GetSQLValueString($_POST['regcom'], "text"),
                       GetSQLValueString($_POST['profil'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString($_POST['functia'], "text"),
                       GetSQLValueString($_POST['telefon'], "text"),
                       GetSQLValueString($_POST['emailcontact'], "text"),
                       GetSQLValueString($_POST['contactat'], "text"),
                       GetSQLValueString($_POST['observatii'], "text"),
					   GetSQLValueString($_POST['client'], "int"),
					   GetSQLValueString($_POST['utilizator'], "text"),
					   GetSQLValueString($_POST['parola'], "text"),
                       GetSQLValueString($_POST['codsocietate'], "int"));
					   

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($updateSQL, $conexiune_db) or die(mysql_error());
}

$maxRows_detaliisocietate = 10;
$pageNum_detaliisocietate = 0;
if (isset($_GET['pageNum_detaliisocietate'])) {
  $pageNum_detaliisocietate = $_GET['pageNum_detaliisocietate'];
}
$startRow_detaliisocietate = $pageNum_detaliisocietate * $maxRows_detaliisocietate;

$colname_detaliisocietate = "-1";
if (isset($_GET['recordID'])) {
  $colname_detaliisocietate = $_GET['recordID'];
}
mysql_select_db($database_conexiune_db, $conexiune_db);
$query_detaliisocietate = sprintf("SELECT * FROM societati WHERE codsocietate = %s", GetSQLValueString($colname_detaliisocietate, "int"));
$query_limit_detaliisocietate = sprintf("%s LIMIT %d, %d", $query_detaliisocietate, $startRow_detaliisocietate, $maxRows_detaliisocietate);
$detaliisocietate = mysql_query($query_limit_detaliisocietate, $conexiune_db) or die(mysql_error());
$row_detaliisocietate = mysql_fetch_assoc($detaliisocietate);

if (isset($_GET['totalRows_detaliisocietate'])) {
  $totalRows_detaliisocietate = $_GET['totalRows_detaliisocietate'];
} else {
  $all_detaliisocietate = mysql_query($query_detaliisocietate);
  $totalRows_detaliisocietate = mysql_num_rows($all_detaliisocietate);
}
$totalPages_detaliisocietate = ceil($totalRows_detaliisocietate/$maxRows_detaliisocietate)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalii societate</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Codsocietate:</td>
      <td><?php echo $row_detaliisocietate['codsocietate']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Denumire:</td>
      <td><input type="text" name="denumire" value="<?php echo htmlentities($row_detaliisocietate['denumire'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Adresa:</td>
      <td><input type="text" name="adresa" value="<?php echo htmlentities($row_detaliisocietate['adresa'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cui:</td>
      <td><input type="text" name="cui" value="<?php echo htmlentities($row_detaliisocietate['cui'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Regcom:</td>
      <td><input type="text" name="regcom" value="<?php echo htmlentities($row_detaliisocietate['regcom'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Profil:</td>
      <td><input type="text" name="profil" value="<?php echo htmlentities($row_detaliisocietate['profil'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="email" value="<?php echo htmlentities($row_detaliisocietate['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Contact:</td>
      <td><input type="text" name="contact" value="<?php echo htmlentities($row_detaliisocietate['contact'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Functia:</td>
      <td><input type="text" name="functia" value="<?php echo htmlentities($row_detaliisocietate['functia'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefon:</td>
      <td><input type="text" name="telefon" value="<?php echo htmlentities($row_detaliisocietate['telefon'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Emailcontact:</td>
      <td><input type="text" name="emailcontact" value="<?php echo htmlentities($row_detaliisocietate['emailcontact'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Contactat:</td>
      <td><label for="contactat"></label> 
      <label for="contactat">
        <select name="contactat" id="contactat">
          <option value="Nu" <?php if (!(strcmp("Nu", $row_detaliisocietate['contactat']))) {echo "selected=\"selected\"";} ?>>Nu</option>
          <option value="Da" <?php if (!(strcmp("Da", $row_detaliisocietate['contactat']))) {echo "selected=\"selected\"";} ?>>Da</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Observatii:</td>
      <td><input type="text" name="observatii" value="<?php echo htmlentities($row_detaliisocietate['observatii'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Client </td>
      <td><select name="client" id="client">
        <option value="0" <?php if (!(strcmp(0, $row_detaliisocietate['client']))) {echo "selected=\"selected\"";} ?>>Nu</option>
        <option value="1" <?php if (!(strcmp(1, $row_detaliisocietate['client']))) {echo "selected=\"selected\"";} ?>>Da</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Utilizator site</td>
      <td><input type="text" name="utilizator" value="<?php echo htmlentities($row_detaliisocietate['utilizator'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Parola site</td>
      <td><input type="text" name="parola" value="<?php echo htmlentities($row_detaliisocietate['parola'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Salveaza" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="codsocietate" value="<?php echo $row_detaliisocietate['codsocietate']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($detaliisocietate);
?>