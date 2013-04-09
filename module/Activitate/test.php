<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("log_errors", 0);

function get_time_difference( $start, $end )
{
  $uts['start']      =    strtotime( $start );
  $uts['end']        =    strtotime( $end );
  if( $uts['start']!==-1 && $uts['end']!==-1 )
  {
    if( $uts['end'] >= $uts['start'] )
    {
      $diff    =    $uts['end'] - $uts['start'];
      if( $hours=intval((floor($diff/3600))) )
      $diff = $diff % 3600;
      if( $minutes=intval((floor($diff/60))) )
      $diff = $diff % 60;
      $diff    =    intval( $diff );
	  if($minutes >= 30) { 
              $hours_rot = $hours + 1;
			  $minutes_rot = 0 ;
      return( array('success'=>1, 'hours'=>$hours,'minutes'=>$minutes,'hours_rot'=>$hours_rot,'minutes_rot'=>$minutes_rot) );
	                     } else  {
			  $hours_rot = $hours; 
			  $minutes_rot = 0 ;   
      return( array('success'=>1, 'hours'=>$hours,'minutes'=>$minutes,'hours_rot'=>$hours_rot,'minutes_rot'=>$minutes_rot) );
                                  }
	
	}
     
    else
    {
      return(array('success'=>0, 'reason'=>'Ending date/time is earlier than the start date/time'));
      //trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
    }
  }
  else
  {
    return(array('success'=>0, 'reason'=>'Invalid date/time data detected'));
    //trigger_error( "Invalid date/time data detected", E_USER_WARNING );
  }
}

$start = $_GET['s'];
$end = $_GET['e'];

echo json_encode(get_time_difference( $start, $end ));
?>