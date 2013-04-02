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





if(isset($_FILES['files'])){
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
        if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }		
		$partener = $_POST["denumire"];
$email = $_POST["email"];
$cod_secure_document = $_POST["codsocietate"];
$fisier_securizat = $cod_secure_document."-".$myFile ;
$nume_fisier = substr($myFile, 0, strrpos($myFile, '.'));

        mysql_select_db($database_conexiune_db, $conexiune_db);
        $query_upload_documente="INSERT into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE) VALUES('$user_id','$file_name','$file_size','$file_type'); ";
		$upload_documente = mysql_query($query_upload_documente, $conexiune_db) or die(mysql_error());
        $row_upload_documente = mysql_fetch_assoc($upload_documente);
        $totalRows_upload_documente = mysql_num_rows($upload_documente);
        $desired_dir="user_data";
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp,"user_data/".$file_name);
            }else{									//rename the file if another one exist
                $new_dir="user_data/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
            mysql_query($query_upload);
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
        }else{
                print_r($errors);
        }
    }
	if(empty($error)){
                foreach ($_FILES['files']['name'] as $value) {

                echo $value ."<br>";

    }

	}
}
?>