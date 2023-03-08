<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

function diff_day_now( $comparetime )
{
    date_default_timezone_set( "Asia/Seoul" );
    //$time = time();
    $date = date( "Y-m-d" );
    return diff_day( $comparetime, $date );
}

function dateDiff( $date1, $date2 )
{
    $_date1 = explode("-",$date1);
    $_date2 = explode("-",$date2);

    $tm1 = mktime(0,0,0,$_date1[1],$_date1[2],$_date1[0]);
    $tm2 = mktime(0,0,0,$_date2[1],$_date2[2],$_date2[0]);

    return ($tm1 - $tm2) / 86400;
}

function diff_day( $starttime, $endtime )
{
    /*
    date_default_timezone_set( "Asia/Seoul" );

    $startday = date("Y-m-d",strtotime( $starttime ) );
    $endday = date("Y-m-d",strtotime( $endtime ) );

    echo "start: $startday end: $endday<br>";

    $start = new DateTime( $startday );
    $end = new DateTime( $endday );
    $minus = date_diff( $start, $end );

    //echo "time: $utime<br>";
    //echo "차이는 $minus->days<br><br>";

    echo $minus->days;

    return $minus->days;
    /*/
    date_default_timezone_set( "Asia/Seoul" );

    $startday = date("Y-m-d",strtotime( $starttime ) );
    $endday = date("Y-m-d",strtotime( $endtime ) );

    $days = dateDiff( $endday, $startday );

    return $days;
    //*/
}
