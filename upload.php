<?php
//=============Configuring Server and Database=======
$host = 'localhost';
$user = 'masterso_Picasso';
$password = 'Inspire';
//=============Data Base Information=================
$database = 'masterso_crm';
 
$conn = mysql_connect($host,$user,$password) or die('Nu sunt corecte datele de autentificare la server'); //Establish Connection with Server
mysql_select_db($database,$conn) or die('Nu sunt corecte datele de autentificare la baza de date');
 
//===============End Server Configuration============
 
if(isset($_POST['btnAdd']))
{
$myFile = $_FILES['fileField']['name']; // Storing name into variable
 
//====If you want to change the name of the File====
$anyNum = rand(20,500789000); //Will generate a random number between 20and 500789000
$partener = $_POST["denumire"];
$email = $_POST["email"];
$cod_secure_document = $_POST["codsocietate"];
$fisier_securizat = $cod_secure_document."-".$myFile ;
$nume_fisier = substr($myFile, 0, strrpos($myFile, '.'));
$fisier_nou = $fisier_securizat;//===New string is concatenated====
//===Following Function will check if the File already exists========
 
if (file_exists("facturi/".$fisier_nou))
{
echo " Documentul " .$myFile ." criptat sub denumirea " .$fisier_nou ." exista deja in baza de date si a mai fost trimis catre partenerul " .$partener;
require_once('upload_factura.php');
}
//******If file already exists in your Folder, It will return zero and Will not take any action===
//======Otherwise File will be stored in your given directory and Will store its name in Database===
else
{
 
$query = "insert into tblfileupload(file_name,societate) values ('$fisier_nou','$_POST[societate]')";
 
$res = mysql_query($query);
 
copy($_FILES['fileField']['tmp_name'],'facturi/'.$fisier_nou);
//===Copy File Into your given Directory,copy(Source,Destination)
 
if($res>0)
{
//====$res will be greater than 0 only when File is uploaded Successfully====:)
echo 'Fisierul ' .$myFile. ' a fost adaugat in baza de date in forma ' .$fisier_securizat ;
echo '</br>';
echo $partener;
echo '</br>';
echo  $email ;
echo '</br>';
echo '</br>'; 
echo '<a href="/crm/facturi/' . $fisier_securizat . '">Vizualizeaza</a>'; 
echo '</br>';
$adresa_document = '<a href="http://www.mastersolutions.ro/crm/facturi/' . $fisier_securizat . '">AICI</a>' ;
$adresa_documente = 'http://www.mastersolutions.ro/crm/facturi/';
$mesaj = "Buna ziua," 
."<br>" 
."Va aducem la cunostinta ca factura" ." $myFile "
."a fost generata. 
Pentru a vizualiza si descarca acest document apasati $adresa_document."
."<p>" 
."Puteti consulta in orice moment situatia facturilor emise catre dumneavoastra la adresa $adresa_documente (necesita autentificare). "
."<br>"
."Acest mesaj a fost generat automat la data emiterii facturii. Va rugam nu raspundeti la acest mesaj";


//Trimite mail//
 $email_to = $_POST['email']; // The email you are sending to (example)
 $email_from = "facturare@mastersolutions.ro"; // The email you are sending from (example)
 $email_subject = "A fost generata factura " ." $nume_fisier "; // The Subject of the email
 $email_txt = $mesaj; // Message that the email has in it
 $fileatt = "/home/masterso/public_html/crm/facturi/"."$fisier_securizat"; // Path to the file (example)
 $fileatt_type = "application/octet-stream"; // File Type
 $fileatt_name = "$myFile"; // Filename that will be used for the file as the attachment
 $file = fopen($fileatt,'rb');
 $data = fread($file,filesize($fileatt));
 fclose($file);
 $semi_rand = md5(time());
 $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
 $headers="From: Factura $email_from"; // Who the email is from (example)
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




}
}
}
?>


