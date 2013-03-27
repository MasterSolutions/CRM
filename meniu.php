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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="css/meniu.css" rel="stylesheet" type="text/css" />
<head>
	<title>Meniu</title>
</head>

<body>
<div class="info-top">
<?php
echo "Autentificat: ". "<span class=\"utilizator\">" . $_SESSION["MM_Username"] . " Limba:" .$_SESSION['coduser_lang'] . "</span><p>";
?>
</div>
<?php
	error_reporting ( E_ALL );

	$menu = array 
	(
		1 => 	array 
				(
					'text'		=> 	'Catalog',
					'class'		=> 	'catalog',
					'link'		=> 	'#',
					'show_condition'=>	TRUE,
					'parent'	=>	0
				),
		2 =>	array
				(
					'text'		=> 	'Societati',
					'class'		=> 	'show',
					'link'		=> 	'#',
					'show_condition'=>	TRUE,
					'parent'	=>	1
				),
		3 =>	array
				(
					'text'		=> 	'Adauga',
					'class'		=> 	'adauga_articol',
					'link'		=> 	'../crm/societati_adauga.php',
					'show_condition'=>	TRUE,
					'parent'	=>	2
				),
		4 =>	array
				(
					'text'		=> 	'Vizualizare',
					'class'		=> 	'vizualizare',
					'link'		=> 	'../crm/societati.php',
					'show_condition'=>	TRUE,
					'parent'	=>	2
				),
				
		5 =>	array
				(
					'text'		=> 	'Sales Force',
					'class'		=> 	'sfa',
					'link'		=> 	'#',
					'show_condition'=>	TRUE,
					'parent'	=>	0
				),	
		6 =>	array
				(
					'text'		=> 	'Documente',
					'class'		=> 	'sfa',
					'link'		=> 	'../crm/manager_doc.php',
					'show_condition'=>	TRUE,
					'parent'	=>	0
				),		
				

		7 =>	array
				(
					'text'		=> 	'Configurari',
					'class'		=> 	'configurari',
					'link'		=> 	'#',
					'show_condition'=>	TRUE,
					'parent'	=>	0
				)
		

		
				
		
	);	

	function build_menu ( $menu )
	{
		$out = '<div class="container4">' . "\n";
		$out .= '	<div class="menu4">' . "\n";
		$out .= "\n".'<ul>' . "\n";
		
		for ( $i = 1; $i <= count ( $menu ); $i++ )
		{
			if ( is_array ( $menu [ $i ] ) ) {//must be by construction but let's keep the errors home
				if ( $menu [ $i ] [ 'show_condition' ] && $menu [ $i ] [ 'parent' ] == 0 ) {//are we allowed to see this menu?
					$out .= '<li class="' . $menu [ $i ] [ 'class' ] . '"><a href="' . $menu [ $i ] [ 'link' ] . '">';
					$out .= $menu [ $i ] [ 'text' ];
					$out .= '</a>';
					$out .= get_childs ( $menu, $i );
					$out .= '</li>' . "\n";
				}
			}
			else {
				die ( sprintf ( 'menu nr %s must be an array', $i ) );
			}
		}
		
		$out .= '</ul>'."\n";
		$out .= "\n\t" . '</div>';
		return $out . "\n\t" . '</div>';
	}
	
	function get_childs ( $menu, $el_id )
	{
		$has_subcats = FALSE;
		$out = '';
		$out .= "\n".'	<ul>' . "\n";
		for ( $i = 1; $i <= count ( $menu ); $i++ )
		{
			if ( $menu [ $i ] [ 'show_condition' ] && $menu [ $i ] [ 'parent' ] == $el_id ) {//are we allowed to see this menu?
				$has_subcats = TRUE;
				$add_class = ( get_childs ( $menu, $i ) != FALSE ) ? ' subsubl' : '';
				$out .= '		<li class="' . $menu [ $i ] [ 'class' ] . $add_class . '"><a href="' . $menu [ $i ] [ 'link' ] . '">';
				$out .= $menu [ $i ] [ 'text' ];
				$out .= '</a>';
				$out .= get_childs ( $menu, $i );
				$out .= '</li>' . "\n";
			}
		}
		$out .= '	</ul>'."\n";
		return ( $has_subcats ) ? $out : FALSE;
	}

?>
	<div style="width:100%;margin:0px auto">
		<?= build_menu ( $menu ) ?>
	</div>
</body>
</html>