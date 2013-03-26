<?php
function output_file($file, $name, $mime_type='')
{
 /*
 Aceasta functie preia calea fisierului pentru output ($file),  numele fisierului asa cum il vede browserul ($name) si tipul MIME al fisierului ($mime_type, optional).
 */
 
 //Verifica permisiunile pe fisier
 if(!is_readable($file)) die('Fisierul nu a fost gasit sau nu este accesibil!');
 
 $size = filesize($file);
 $name = rawurldecode($name);
 
 /* Verifica tipul MIME | Se face verificare in array */
 $known_mime_types=array(
 	"pdf" => "application/pdf",
 	"txt" => "text/plain",
 	"html" => "text/html",
 	"htm" => "text/html",
	"exe" => "application/octet-stream",
	"zip" => "application/zip",
	"doc" => "application/msword",
	"xls" => "application/vnd.ms-excel",
	"ppt" => "application/vnd.ms-powerpoint",
	"gif" => "image/gif",
	"png" => "image/png",
	"jpeg"=> "image/jpg",
	"jpg" =>  "image/jpg",
	"php" => "text/plain"
 );
 
 if($mime_type==''){
	 $file_extension = strtolower(substr(strrchr($file,"."),1));
	 if(array_key_exists($file_extension, $known_mime_types)){
		$mime_type=$known_mime_types[$file_extension];
	 } else {
		$mime_type="application/force-download";
	 };
 };
 
 //opreste buffering output pentru scaderea incarcarii CPU
 @ob_end_clean(); 
 
 // necesare pentru IE
 if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');
 
 header('Content-Type: ' . $mime_type);
 header('Content-Disposition: attachment; filename="'.$name.'"');
 header("Content-Transfer-Encoding: binary");
 header('Accept-Ranges: bytes');
 
 /* Urmatoarele 3 linii fac downloadul non-cacheable */
 header("Cache-control: private");
 header('Pragma: private');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 
 // multipart-download si suport download resuming 
 if(isset($_SERVER['HTTP_RANGE']))
 {
	list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
	list($range) = explode(",",$range,2);
	list($range, $range_end) = explode("-", $range);
	$range=intval($range);
	if(!$range_end) {
		$range_end=$size-1;
	} else {
		$range_end=intval($range_end);
	}


	$new_length = $range_end-$range+1;
	header("HTTP/1.1 206 Partial Content");
	header("Content-Length: $new_length");
	header("Content-Range: bytes $range-$range_end/$size");
 } else {
	$new_length=$size;
	header("Content-Length: ".$size);
 }
 
 /* Va scoate un output pentru fisier */
 $chunksize = 1*(1024*1024); //se poate modifica
 $bytes_send = 0;
 if ($file = fopen($file, 'r'))
 {
	if(isset($_SERVER['HTTP_RANGE']))
	fseek($file, $range);
 
	while(!feof($file) && 
		(!connection_aborted()) && 
		($bytes_send<$new_length)
	      )
	{
		$buffer = fread($file, $chunksize);
		print($buffer); //echo($buffer); // merge si asa
		flush();
		$bytes_send += strlen($buffer);
	}
 fclose($file);
 } else
 //Daca nu exista permisiuni pe fisier
 die('Eroare - nu se poate deschide fisierul.');
 //die
die();
}
//Seteaza time out
set_time_limit(0);

//calea spre fisier
$file_path='doc/'.$_REQUEST['societate'].'/'.$_REQUEST['desc'];


//Apeleaza functia de download: calea fisierului, numele fisierului, tipul fisierului
output_file($file_path, ''.$_REQUEST['desc'].'', 'text/plain');

?>