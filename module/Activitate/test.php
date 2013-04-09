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
      if( $days=intval((floor($diff/86400))) )
      $diff = $diff % 86400;
      if( $hours=intval((floor($diff/3600))) )
      $diff = $diff % 3600;
      if( $minutes=intval((floor($diff/60))) )
      $diff = $diff % 60;
      $diff    =    intval( $diff );
      return( array('success'=>1, 'days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
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