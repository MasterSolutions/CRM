<?php require_once('../Connections/conexiune_db.php'); ?>
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
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['utilizator'])) {
  $loginUsername=$_POST['utilizator'];
  $password=$_POST['parola'];
  $MM_fldUserAuthorization = "permisiuni";
  $MM_redirectLoginSuccess = "master_page.php";
  $MM_redirectLoginFailed = "loginesuat.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexiune_db, $conexiune_db);
  	
  $LoginRS__query=sprintf("SELECT utilizator, parola, permisiuni FROM utilizatori WHERE utilizator=%s AND parola=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
  $LoginRS = mysql_query($LoginRS__query, $conexiune_db) or die(mysql_error());
  // Interogare baza de date pentru definirea variabilei de sesiune COD SOCIETATE UTILIZATOR
  $query_societate_user = mysql_query("SELECT codsocietate,coduser FROM utilizatori WHERE utilizator='".$loginUsername."' AND parola='".$password."'");
            while ($rows = mysql_fetch_array($query_societate_user))
   {
   $_SESSION['codsoc_user'] = $rows['codsocietate'];
   //Definire variabila de sesiune pentru limba
   $query_societate_user_setari = mysql_query("SELECT * FROM utilizatori_config WHERE cod_user='".$rows['coduser']."'");
            while ($rows2 = mysql_fetch_array($query_societate_user_setari))
   $_SESSION['codsoc_lang'] = $rows2['lang'];
   }
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'permisiuni');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['utilizator'])) {
  $loginUsername=$_POST['utilizator'];
  $password=$_POST['parola'];
  $MM_fldUserAuthorization = "permisiuni";
  $MM_redirectLoginSuccess = "master_page.php";
  $MM_redirectLoginFailed = "loginesuat.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexiune_db, $conexiune_db);
  	
  $LoginRS__query=sprintf("SELECT utilizator, parola, permisiuni FROM utilizatori WHERE utilizator=%s AND parola=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexiune_db) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'permisiuni');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Autentificare CRMaster</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
    <link rel="shortcut icon" href="file:///C|/xampp/htdocs/favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="../css/demo.css" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link rel="stylesheet" type="text/css" href="../css/animate-custom.css" />
    </head>
    <body onload="startTime()">
    <body>
        <div class="container">
            <!-- Codrops top bar -->
            <div class="codrops-top">
                <a href="">
                    <strong> <div id="txt"></div> </strong>

                </a>
                <span class="right">
                    <a href="http://www.mastersolutions.ro">
                        <strong>Pagina dezvoltatorului</strong>
                    </a>
                </span>
              <div class="clr"></div>
            </div><!--/ Codrops top bar -->
            <header>
                <h1>Formular autentificare <span>Client</span></h1>
				<nav class="codrops-demos">
				<?php if (isset($_GET['requsername'])) {
                                 echo "Numele de utilizator "  .$_GET['requsername']  ." exista deja in baza de date. ";
                                                        };?>
                </nav>
            </header>
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form METHOD="POST"  action="<?php echo $loginFormAction; ?>" id="formaut" autocomplete="on"> 
                                <h1>Autentificare</h1> 
                              <p> 
                                    <label for="utilizator" class="uname" data-icon="u" > Utilizator </label>
                                    <input id="utilizator" name="utilizator" required type="text" placeholder="Numele tau de utilizator"/>
                                </p>
                                <p> 
                                    <label for="parola" class="youpasswd" data-icon="p"> Parola </label>
                                    <input id="parola" name="parola" required type="password" placeholder="ex: parola1234" /> 
                                </p>
                                <p class="keeplogin"> 
									<input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
									<label for="loginkeeping">Pastreaza autentificarea</label>
								</p>
                                <p class="login button"> 
                                    <input type="submit" value="Autentificare" /> 
								</p>
                            </form>
                        </div>
                        </div>

    </body>
</html>
<script>
function startTime()
{
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
m=checkTime(m);
s=checkTime(s);
document.getElementById('txt').innerHTML=h+":"+m+":"+s;
t=setTimeout(function(){startTime()},500);
}

function checkTime(i)
{
if (i<10)
  {
  i="0" + i;
  }
return i;
}
</script>