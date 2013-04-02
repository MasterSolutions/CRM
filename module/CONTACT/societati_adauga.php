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
  $insertSQL = sprintf("INSERT INTO societati (codsocietate, denumire, adresa, cui, regcom, profil, email, contact, functia, telefon, emailcontact, contactat, observatii, utilizator, parola) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codsocietate'], "int"),
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
                       GetSQLValueString($_POST['utilizator'], "text"),
                       GetSQLValueString($_POST['parola'], "text"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());

  $insertGoTo = "/CRM/societati.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="/CRM/css/machete.css" />
<script language="javascript" type="text/javascript" src="/CRM/module/js/niceforms.js"></script>
<title>Societati - adauga</title>
</head>
<body>
<?php require_once('../../meniu.php'); ?>
<div id="container">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="niceform">
	<fieldset>
    	<legend>Date generale</legend>
   	  <dl>
       	  <dt><label for="denumire">Denumire</label></dt>
        <dd>
              <input name="denumire" type="text" id="denumire" value="" size="32" />
        </dd>
      </dl>
      <dl>
       	  <dt>
       	    <label for="C.U.I">C.U.I</label></dt>
        <dd>
              <input name="cui" type="text" id="cui" value="" size="32" />
        </dd>
      </dl>
      <dl>
       	  <dt>
       	    <label for="Reg.com">Reg.Comert</label></dt>
        <dd>
              <input name="regcom" type="text" id="regcom" value="" size="32" />
        </dd>
      </dl>
      <dl>
       	  <dt><label for="Profil activitate">Profil activitate</label></dt>
        <dd><input name="profil" type="text" id="profil" value="" size="32" /></dd>
      </dl>
       <dl>
       	  <dt><label for="Adresa">Adresa</label></dt>
          <dd><input name="adresa" type="text" id="Adresa" value="" size="32" /></dd>
      </dl>
    </fieldset>
      <fieldset>
    	<legend>Detalii contact</legend>
       <dl>
       	  <dt><label for="denumire">E-mail</label></dt>
        <dd>
              <input name="email" type="text" id="email" value="" size="32" />
        </dd>
      </dl>
      <dl>
       	  <dt>Contact</dt>
        <dd>
              <input name="contact" type="text" id="contact" value="" size="32" />
        </dd>
      </dl>
      <dl>
       	  <dt>
       	    <label for="Functia">Functia</label></dt>
        <dd>
              <input name="functia" type="text" id="functia" value="" size="32" />
        </dd>
      </dl>
      <dl>
       	  <dt>
       	    <label for="Telefon">Nr. telefon</label></dt>
        <dd>
              <input name="telefon" type="text" id="telefon" value="" size="32" />
        </dd>
      </dl>
      <dl>
       	  <dt>
       	    <label for="E-mail">E-mail contact</label></dt>
        <dd>
              <input name="emailcontact" type="text" id="emailcontact" value="" size="32" />
        </dd>
      </dl>
    </fieldset>
    
        <fieldset>
    <legend>Observatii</legend>
          <dl>
       	      <dt><label for="observatii">observatii</label></dt>
              <dd><textarea name="observatii" id="observatii" rows="5" cols="60"></textarea></dd>
         </dl>
         <dl>

        </dl>
    
    </fieldset>
    
    <fieldset>
    <legend>Utilizator CRM
              </legend>
    <dl>
       	      <dt>
       	        <label for="utilizator">Utilizator</label></dt>
              <dd><input name="utilizator" type="text" id="utilizator" value="" size="32" /></dd>
         </dl>
                   <dl>
       	      <dt>
       	        <label for="parola">Parola</label></dt>
              <dd><input name="parola" type="text" id="parola" value="" size="32" /></dd>
         </dl>

    </fieldset>
        <fieldset class="action">
        <input name="codsocietate" type="hidden" id="codsocietate" value="" />        <input name="contactat" type="hidden" value="Nu" />
    	<input type="submit" name="submit" id="submit" value="Salveaza" />
    </fieldset>
    <input type="hidden" name="MM_insert" value="form1" />

</form>
</div>
</body>
</html>