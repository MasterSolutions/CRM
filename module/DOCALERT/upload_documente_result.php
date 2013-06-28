<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documente emise - notificari</title>
<link href="/CRM/css/machete.css" rel="stylesheet" type="text/css" />
</head>
<?php require_once('../../meniu.php'); ?>
<?php require_once('../../Connections/conexiune_db.php'); ?>
<div id="container">
<div class="notificare">
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
$query_select_detalii_mail = "SELECT * FROM config_societate";
$select_detalii_mail = mysql_query($query_select_detalii_mail, $conexiune_db) or die(mysql_error());
$row_select_detalii_mail = mysql_fetch_assoc($select_detalii_mail);
$totalRows_select_detalii_mail = mysql_num_rows($select_detalii_mail);



//===============Definire variabile==================
$cod_securizare_document = $_POST["codsocietate"];
setlocale(LC_TIME, array('ro.utf-8', 'ro_RO.UTF-8', 'ro_RO.utf-8', 'ro', 'ro_RO', 'ro_RO.ISO8859-2')); 
$lunaan = strftime('%B-%Y',time());
$ziua = strftime('%d',time());
$kilobyte = 1024;
$megabyte = $kilobyte * 1024;
$gigabyte = $megabyte * 1024;
$terabyte = $gigabyte * 1024;
$precision = 2 ;


//===============Sfarsit definire variabile==================


if(isset($_FILES['files'])){
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$numefisier = $_FILES['files']['name'][$key];
		$sizefisierbits =$_FILES['files']['size'][$key];
        if (($sizefisierbits >= 0) && ($sizefisierbits < $kilobyte)) {
        $sizefisierconvert = $sizefisierbits . ' B';
        } elseif (($sizefisierbits >= $kilobyte) && ($sizefisierbits < $megabyte)) {
        $sizefisierconvert = round($sizefisierbits / $kilobyte, $precision) . ' KB';
        } elseif (($sizefisierbits >= $megabyte) && ($sizefisierbits < $gigabyte)) {
        $sizefisierconvert = round($sizefisierbits / $megabyte, $precision) . ' MB';
        } elseif (($sizefisierbits >= $gigabyte) && ($sizefisierbits < $terabyte)) {
        $sizefisierconvert = round($sizefisierbits / $gigabyte, $precision) . ' GB';
        } elseif ($sizefisierbits >= $terabyte) {
        $sizefisierconvert = round($sizefisierbits / $terabyte, $precision) . ' TB';
        } else {
        $sizefisierconvert = $sizefisierbits . ' B';
        }	
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$tipfisier=$_FILES['files']['type'][$key];	
        if($sizefisierbits > 2097152){
			$errors[]='File size must be less than 2 MB';
        }		
        $director = $_POST["denumire"];
        $desired_dir="$director";
        if(empty($errors)==true){
            if(is_dir("../../client/doc/".$desired_dir)==false){
                 mkdir("../../client/doc/"."$desired_dir", 0755);		// Create directory if it does not exist
            }
			    
				 $filename = "../../client/doc/"."$desired_dir/".$numefisier;
                 $new_dir="../../client/doc/"."$director/".$numefisier;
                 if (file_exists($filename)) {
			     $new_dir="../../client/doc/"."$director/".time().$numefisier;
                 rename($file_tmp,$new_dir) ;
				 chmod("$new_dir", 0644);
				 $numefisierrename= time().$numefisier;
                 echo "Fisierul " .$numefisier ." exista deja. Redenumesc fisierul si il adaug in baza de date cu numele " .time().$numefisier  ."<br>";
				 $query_upload_documente="INSERT into documente_emise (idsoc,nume_fisier,dimensiune_fisier,tip_fisier,ziua,lunaan) VALUES('$cod_securizare_document','$numefisierrename','$sizefisierconvert','$tipfisier','$ziua','$lunaan'); ";
				 $upload_documente = mysql_query($query_upload_documente, $conexiune_db) or die(mysql_error());
                                 			 
                } else {
				 move_uploaded_file($file_tmp,"../../client/doc/"."$director/".$numefisier);
				 echo "Fisierul "  .$numefisier ." nu exista in baza de date. Am creat fisierul si l-am adaugat in baza de date. " ."<br>";
				 $query_upload_documente = "INSERT into documente_emise (idsoc,nume_fisier,dimensiune_fisier,tip_fisier,ziua,lunaan) VALUES('$cod_securizare_document','$numefisier','$sizefisierconvert','$tipfisier','$ziua','$lunaan'); ";
				 $upload_documente = mysql_query($query_upload_documente, $conexiune_db) or die(mysql_error());
                                 
                
				 
                
                }



//Trimite mail//
$adresa_crmclient = $row_select_detalii_mail['crmclienti'];
$adresa_document = '<a href='.$adresa_crmclient.$new_dir. '>AICI</a>' ;
$mesaj = "Buna ziua," 
."<br>"  
."Va aducem la cunostinta ca in contul dumneavoastra a fost generat si atasat acestui mesaj documentul " ." $numefisier "
."<p>" 
."Puteti consulta in orice moment situatia/istoricul documentelor emise catre dumneavoastra la adresa "."$adresa_crmclient". " (necesita autentificare). "
."<br>"
."Acest mesaj a fost generat automat la data emiterii facturii. Va rugam nu raspundeti la acest mesaj";



 $email_to = $_POST['email']; // Adresa de mail catre care se trimite documentul 
 $email_from = $row_select_detalii_mail['mailnotificare']; // Adresa de mail de la care se trimite mesajul
 $email_subject = "A fost generata factura " ." $numefisier "; // Subiectul mailului
 $email_txt = $mesaj; // Mesajul din mail
 $fileatt = "$filename"; // Calea catre fisier
 $fileatt_type = "$tipfisier"; // Tipul fisierului
 $fileatt_name = "$numefisier"; // Numele fisierului folosit in atasament
 $file = fopen($fileatt,'rb');
 $data = fread($file,filesize($fileatt));
 fclose($file);
 $semi_rand = md5(time());
 $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
 $headers="From: Notificare factura $email_from"; // Expeditorul mailului
 $headers .= "\nMIME-Version: 1.0\n" .
 "Content-Type: multipart/mixed;\n" .
 " boundary=\"{$mime_boundary}\"";
 $email_message .= "This is a multi-part message in MIME format.\n\n" .
 "--{$mime_boundary}\n" .
 "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
 "Content-Transfer-Encoding: 7bit\n\n" . $email_txt;
 $email_message .= "\n\n";
 $data = chunk_split(base64_encode($data));
 $email_message .= "--{$mime_boundary}\n" .
 "Content-Type: {$fileatt_type};\n" .
 " name=\"{$fileatt_name}\"\n" .
 "Content-Transfer-Encoding: base64\n\n" .
 $data . "\n\n" .
 "--{$mime_boundary}--\n";

 mail($email_to,$email_subject,$email_message,$headers);
//Sfarsit configurare trimite mail//
				
            			
        }else{
                print_r($errors);
        }
    }
	if(empty($error)){
                foreach ($_FILES['files']['name'] as $value) {


    }

	}
}

mysql_free_result($select_detalii_mail);
?>
</div>
</div>