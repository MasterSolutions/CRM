<?php require_once('../Connections/conexiune_db.php'); ?>
<?php require_once('meniu.php'); ?>
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

mysql_select_db($database_conexiune_db, $conexiune_db);
$query_date = "SELECT distinct lunaan FROM documente_emise where idsoc='".$_SESSION['codsoc_user']."'";
$date = mysql_query($query_date, $conexiune_db) or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Master Page</title>
<link href="/crm/client/css/TableCSSCode.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-22897853-1']);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
<?php

       echo '<div class="CSSTableGenerator" >';
       while ($row = mysql_fetch_array($date)) {
		   
		   echo '<table>';
		   echo '<tr>';
           echo '<td colspan="7">' .'Luna - Anul: ' .$row['lunaan'] .'</td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th>ID Fisier</th>';
           echo '<th>Societate</th>';
		   echo '<th>Nume Fisier</th>';
		   echo '<th>Extensie</th>';
		   echo '<th>Dimensiune</th>';
		   echo '<th>Ziua</th>';
		   echo '<th>Link</th>';
           echo '</tr>';

  
		$query_date2 = mysql_query("SELECT doc.*,soc.denumire FROM documente_emise doc LEFT JOIN societati soc ON doc.idsoc = soc.codsocietate WHERE lunaan='".$row['lunaan']."' and idsoc='".$_SESSION['codsoc_user']."' ORDER BY ziua ASC");
		
		
            while ($rows = mysql_fetch_array($query_date2)) {
				$fisier= $rows['nume_fisier'];
				$nume_fisier = implode('.', explode('.', $fisier, -1));
				$extensie = substr(strrchr($fisier, '.'), 1);
				if ($extensie=="pdf")
                {
                $extensie_pic = '<img src="pic/pdf.gif">';
                }
                else if ($extensie=="doc")
                {
                $extensie_pic = '<img src="pic/doc.gif">';
                }
				else if ($extensie=="xls")
                {
                $extensie_pic = '<img src="pic/xls.gif">';
                }
				else if ($extensie=="xlsx")
                {
                $extensie_pic = '<img src="pic/xlsx.gif">';
                }
				else
                {
                $extensie_pic = '<img src="pic/file.gif">';
                }
				
				$nume_firma = $rows['denumire'];
				$adresa_fisier = 'doc/'.$nume_firma.'/'.$fisier;
                {	
			  echo '<tr>';
              echo '<td>' .$rows['iddoc'] .'</td>';
			  echo '<td>' ."$nume_firma" .'</td>';
			  echo '<td>' ."$nume_fisier" .'</td>';
			  echo '<td>' ."$extensie_pic" .'</br>'."$extensie" .'</td>';
			  echo '<td>' .$rows['dimensiune_fisier'] .'</td>';
			  echo '<td>' .$rows['ziua'] .'</td>';
echo '<td><a href="download.php?desc='.$fisier.'&amp;societate='.$nume_firma.'">'.'<img src="pic/file_download.gif">'.'</br>Descarca</a></td>';
			  echo '</tr>';
               }  
            }
             echo '</br>';
        }

echo '</table>';
echo '</div>';

?>
</body>

</html>
<?php
mysql_free_result($date);
?>
