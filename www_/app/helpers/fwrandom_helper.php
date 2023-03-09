<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

function get_random_string( $couponLength, $couponString = '' )
{
    $defaultString = "ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789";

    srand( ( double )microtime() * 1000000 );

    if ( $couponString == "" )
    {
        //$couponString의 값이 정해지지 않았다면 $defaultString 값으로 사용
        $couponString = $defaultString;
    }

    $length = strlen( $couponString );

    $resultStr = '';

    for( $i = 0; $i < $couponLength; $i++ )
    {
        $couponStr = rand( 0, $length - 1 ); //0에서 $defaultString또는 $couponString의 길이사이의 난수를 구한다
        $resultStr .= substr( $couponString, $couponStr, 1 );
    }

    return $resultStr;
}

function get_random_num( $numLength )
{
    $defaultString = "0123456789";

    srand( ( double )microtime() * 1000000 );

    $couponString = $defaultString;

    $length = strlen( $couponString );

    $resultStr = '';

    for( $i = 0; $i < $numLength; $i++ )
    {
        $couponStr = rand( 0, $length - 1 ); //0에서 $defaultString또는 $couponString의 길이사이의 난수를 구한다
        $resultStr .= substr( $couponString, $couponStr, 1 );
    }

    return $resultStr;
}
