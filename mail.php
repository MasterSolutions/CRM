<?php
$email_to = "predaovidiualin@gmail.com"; // The email you are sending to (example)
 $email_from = "sendfrom@email.com"; // The email you are sending from (example)
 $email_subject = "subject line"; // The Subject of the email
 $email_txt = "text body of message"; // Message that the email has in it
 $email_message = "text body of message"; // Message that the email has in it
 $fileatt = "sfa.php"; // Path to the file (example)
 $fileatt_type = "application/zip"; // File Type
 $fileatt_name = "download.zip"; // Filename that will be used for the file as the attachment
 $file = fopen($fileatt,'rb');
 $data = fread($file,filesize($fileatt));
 fclose($file);
 $semi_rand = md5(time());
 $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
 $headers="From: $email_from"; // Who the email is from (example)
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
?>
