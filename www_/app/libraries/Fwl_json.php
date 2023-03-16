<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Fwl_json
{
    private static $detect_order = 'UTF-8,EUC-KR';

    public static function encode( $data, $detect_order = null )
    {
        if ( $detect_order === null ) $detect_order = self::$detect_order;

        return json_encode( self::convertEncoding( $data, $detect_order ) );
    }

    private static function convertEncoding( $data, $detect_order )
    {
        if ( is_array( $data ) )
        {
            foreach ( $data as $k => $v )
            {
                $data[ $k ] = self::convertEncoding( $v, $detect_order );
            }
        }
        else if ( is_string( $data ) )
        {
            $detected = mb_detect_encoding( $data, $detect_order );

            if ( $detected != 'UTF-8' ) $data = iconv( $detected, 'UTF-8', $data );
        }

        return $data;
    }
}
