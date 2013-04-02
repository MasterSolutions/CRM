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

$MM_restrictGoTo = "index.php";
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
<?php require_once('Connections/conexiune_db.php'); ?>
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



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="/CRM/css/meniu.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Meniu</title>
</head>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
	$(function() {
	  if ($.browser.msie && $.browser.version.substr(0,1)<7)
	  {
		$('li').has('ul').mouseover(function(){
			$(this).children('ul').show();
			}).mouseout(function(){
			$(this).children('ul').hide();
			})
	  }
	});        
</script>
<body marginwidth="0" topmargin="0">

<div id="container-menu">
 <div class="info-top">
 <?php
 echo "Autentificat: ". "<span class=\"utilizator\">" . $_SESSION["MM_Username"] . " Limba:" .$_SESSION['user_lang'] . "</span><p>";
 ?>
 </div>
 <div class="main_menu">
    <ul id="menu">
        <?php 
		mysql_select_db($database_conexiune_db, $conexiune_db);
        $query_Meniu = "SELECT * FROM meniu where tip=0 ORDER BY ordonare ASC";
        $Meniu = mysql_query($query_Meniu, $conexiune_db) or die(mysql_error());
		while ($rowMeniu = mysql_fetch_array($Meniu))
        {
        $id_meniu=$rowMeniu['id_meniu'];
	    $nume_meniu=$rowMeniu['nume_meniu'];
		$ico_meniu=$rowMeniu['ico'];
		if ($rowMeniu['nume_meniu'] == '#') {
        $adresa_meniu = "#";
        } else {
		$adresa_meniu=$rowMeniu['adresa'];
		}
	     
    ?>
       <li><a href=<?php echo $adresa_meniu ?>><span><img src="/CRM/css/pic/Meniu/<?php echo $ico_meniu ?>" /></span><br><?php echo $nume_meniu; ?></span></a>
              <ul><?php 
			  $query_SubMeniu = "SELECT * FROM meniu where tip=1 and parinte=$id_meniu ORDER BY ordonare ASC";
			  $SubMeniu = mysql_query($query_SubMeniu, $conexiune_db) or die(mysql_error());
		      while ($rowSubMeniu = mysql_fetch_array($SubMeniu))
              {
			  $id_submeniu=$rowSubMeniu['id_meniu'];
		      $nume_submeniu=$rowSubMeniu['nume_meniu'];
			  $ico_submeniu=$rowSubMeniu['ico'];		
			  if ($rowSubMeniu['nume_meniu'] == '#') {
              $adresa_submeniu = "#";
              } else {
		      $adresa_submeniu=$rowSubMeniu['adresa'];
		      }
    ?> 
             <li><a href=<?php echo $adresa_submeniu ?>><span class="submeniu"><img src="/CRM/css/pic/Meniu/<?php echo $ico_submeniu ?>" /><?php echo $nume_submeniu; ?></span></a> 

			                   <ul><?php 
			                   $query_SubMeniu1 = "SELECT * FROM meniu where tip=2 and parinte=$id_submeniu ORDER BY ordonare ASC";
			                   $SubMeniu1 = mysql_query($query_SubMeniu1, $conexiune_db) or die(mysql_error());
		                       while ($rowSubMeniu1 = mysql_fetch_array($SubMeniu1))
							   {
                               $nume_submeniu1=$rowSubMeniu1['nume_meniu'];	
							   $ico_submeniu1=$rowSubMeniu1['ico'];	
		                       $adresa_submeniu1=$rowSubMeniu1['adresa'] ; 
                               ?>
							   
							   <li><a href=<?php echo '../CRM/'.$adresa_submeniu1 ?>><span class="submeniu"><img src="/CRM/css/pic/Meniu/<?php echo $ico_submeniu1 ?>" /><?php echo $nume_submeniu1; ?></span></a>
							   <?php }  ?>
							   </ul>


			 
          <?php }  ?>
            </li>
            </ul>
      </li>
  <?php } ?>
    </ul>
 </div>
</div>
</body>
</html>