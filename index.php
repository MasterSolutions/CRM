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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="index.php";
  $loginUsername = $_POST['utilizator'];
  $LoginRS__query = sprintf("SELECT utilizator FROM utilizatori WHERE utilizator=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_conexiune_db, $conexiune_db);
  $LoginRS=mysql_query($LoginRS__query, $conexiune_db) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
	
    header ("Location: $MM_dupKeyRedirect");

    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cont_nou")) {
  $insertSQL = sprintf("INSERT INTO utilizatori (utilizator, parola, mailuser, validat) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['utilizator'], "text"),
                       GetSQLValueString($_POST['parola'], "text"),
                       GetSQLValueString($_POST['mailuser'], "text"),
                       GetSQLValueString($_POST['validat'], "int"));

  mysql_select_db($database_conexiune_db, $conexiune_db);
  $Result1 = mysql_query($insertSQL, $conexiune_db) or die(mysql_error());
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
    // Interogare baza de date pentru definirea variabilei de sesiune COD UTILIZATOR
  $query_societate_user = mysql_query("SELECT coduser FROM utilizatori WHERE utilizator='".$loginUsername."' AND parola='".$password."'");
            while ($rows = mysql_fetch_array($query_societate_user))
   {
            $_SESSION['cod_user'] = $rows['coduser'];
   //Definire variabila de sesiune pentru limba
   $query_societate_user_setari = mysql_query("SELECT rol,lang FROM utilizatori_config WHERE cod_user='".$rows['coduser']."'");
            while ($rows2 = mysql_fetch_array($query_societate_user_setari))
            {				
            $_SESSION['user_rol'] = $rows2['rol'];
			$_SESSION['user_lang'] = $rows2['lang'];
            }
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
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
        <script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
        <script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
        <link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
        <link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />  
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
                <h1>Formular autentificare <span>Administrare CRMaster</span></h1>
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
                                <p class="change_link">
									Nu ai cont de utilizator ?
									<a href="#toregister" class="to_register">Solicita unul</a>
								</p>
                            </form>
                        </div>

                        <div id="register" class="animate form">
                          <form method="POST" name="cont_nou" id="cont_nou" action="<?php echo $editFormAction; ?>" autocomplete="on"> 
                                <h1> Solicita aprobare cont nou </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Nume utilizator</label>
                                    <input id="usernamesignup" name="utilizator" required type="text" placeholder="Numele tau de utilizator" />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Adresa mail</label>
                                    <input id="emailsignup" name="mailuser" required type="email" placeholder="adresa@mail.com"/> 
                                </p>
                            <p>     
                                    <span id="sprypassword1">
                                    <label for="parola2" class="youpasswd" data-icon="p">Parola</label>
                                    <input type="password" name="parola" id="parola2"  placeholder="ex: Parola1234"/></span>
                            </p>
                            <p> 
                              <span id="spryconfirm1">
                              <label for="parola_confirm" class="youpasswd" data-icon="p">Confirmare parola </label>
                              <input type="password" name="parola_confirm" id="parola_confirm" placeholder="ex: Parola1234" />
  <span class="confirmInvalidMsg">Valorile pentru parola nu sunt identice.</span></span>   
                            </p>                 
                                <input name="validat" type="hidden" value="0" />
                            <p class="signin button"> 
									<input type="submit" value="Trimite"/> 
							</p>
                                
                                <p class="change_link">  
									Ai cont de utilizator ?
									<a href="#tologin" class="to_register"> Autentifica-te </a>
								</p>
                                <input type="hidden" name="MM_insert" value="cont_nou" />
                          </form>
                        </div>
						
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>

<script type="text/javascript">
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
</script>

<script type="text/javascript">
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "parola2");
</script>

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