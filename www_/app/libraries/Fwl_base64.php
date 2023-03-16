<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Fwl_base64
{
    protected $m_base64s = '';

    public function __construct()
    {
        $this->m_base64s = "BCDEAFGHIJKLMNOPQSTURVWXYZabcefghijklmndopqrstuvwxyz1234056789()";
        //$this->m_base64s = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    }
    /*
    function _cronbase64_encode($input)
    {
        $output = "";
        $chr1 = $chr2 = $chr3 = $enc1 = $enc2 = $enc3 = $enc4 = null;
        $i = 0;

        while ( $i < strlen( $input ) )
        {
            $chr1 = ord( $input[ $i++ ] );
            $chr2 = ord( $input[ $i++ ] );
            $chr3 = ord( $input[ $i++ ] );

            $enc1 = $chr1 >> 2;
            $enc2 = ( ( $chr1 & 3 ) << 4 ) | ( $chr2 >> 4 );
            $enc3 = ( ( $chr2 & 15 ) << 2 ) | ( $chr3 >> 6 );
            $enc4 = $chr3 & 63;

            if (is_nan($chr2)) {
                $enc3 = $enc4 = 64;
            } else if (is_nan($chr3)) {
                $enc4 = 64;
            }

            $output .=  $this->m_base64s[$enc1]
                      . $this->m_base64s[$enc2]
                      . $this->m_base64s[$enc3]
                      . $this->m_base64s[$enc4];
         }

         return $output;
    }
    */

    public function encode( $str )
    {
        //*
        $size = strlen( $str );

        $p = array( $size * 4 / 3 + 4 );

        $q = $str;

        $idx = 0;

        for ( $i = 0; $i < $size; )
        {
            $c = ord( $q[ $i++ ] );

            $c *= 256;

            if ( $i < $size )
                $c += ord( $q[ $i ] );

            $i++;

            $c *= 256;

            if ( $i < $size )
                $c += ord( $q[ $i ] );

            $i++;

            $p[ $idx ] = $this->m_base64s[ ( $c & 0x00fc0000 ) >> 18 ];
            $p[ $idx + 1 ] = $this->m_base64s[ ( $c & 0x0003f000 ) >> 12 ];
            $p[ $idx + 2 ] = $this->m_base64s[ ( $c & 0x00000fc0 ) >> 6 ];
            $p[ $idx + 3 ] = $this->m_base64s[ ( $c & 0x0000003f ) >> 0 ];

            if ( $i > $size )
                $p[ $idx + 3 ] = '=';

            if ( $i > $size + 1 )
                $p[ $idx + 2 ] = '=';

            $idx += 4;
        }

        $str = implode( "", $p );

        return $str;
        /*/
            $output = "";
             $chr1 = $chr2 = $chr3 = $enc1 = $enc2 = $enc3 = $enc4 = null;
             $i = 0;

    //        $input = self::utf8_encode($input);

            while($i < strlen($input)) {
                 $chr1 = ord($input[$i++]);
                 $chr2 = ord($input[$i++]);
                 $chr3 = ord($input[$i++]);

                $enc1 = $chr1 >> 2;
                 $enc2 = (($chr1 & 3) << 4) | ($chr2 >> 4);
                 $enc3 = (($chr2 & 15) << 2) | ($chr3 >> 6);
                 $enc4 = $chr3 & 63;

                if (is_nan($chr2)) {
                     $enc3 = $enc4 = 64;
                 } else if (is_nan($chr3)) {
                     $enc4 = 64;
                 }

                $output .=  $this->m_base64s[$enc1]
                           . $this->m_base64s[$enc2]
                           . $this->m_base64s[$enc3]
                           . $this->m_base64s[$enc4];
            }

            print_r( $this->m_base64s );

            echo "output: " . $output . " " . $this->m_base64s;

            return $output;
            //*/
    }

    public function encode_file( $str, $size )
    {
        $p = array( $size * 4 / 3 + 4 );

        $q = $str;

        $idx = 0;

        for ( $i = 0; $i < $size; )
        {
            $c = ord( $q[ $i++ ] );

            $c *= 256;

            if ( $i < $size )
                $c += ord( $q[ $i ] );

            $i++;

            $c *= 256;

            if ( $i < $size )
                $c += ord( $q[ $i ] );

            $i++;

            $p[ $idx ] = $this->m_base64s[ ( $c & 0x00fc0000 ) >> 18 ];
            $p[ $idx + 1 ] = $this->m_base64s[ ( $c & 0x0003f000 ) >> 12 ];
            $p[ $idx + 2 ] = $this->m_base64s[ ( $c & 0x00000fc0 ) >> 6 ];
            $p[ $idx + 3 ] = $this->m_base64s[ ( $c & 0x0000003f ) >> 0 ];

            if ( $i > $size )
                $p[ $idx + 3 ] = '=';

            if ( $i > $size + 1 )
                $p[ $idx + 2 ] = '=';

            $idx += 4;

        }

        $str = implode( "", $p );

        return $str;
    }

    public function decode( $str )
    {
        $p = $str;
        $q = array();
        $done = 0;
        $dataidx = 0;

        $size = strlen( $str );

        for ( $idx = 0; $idx + 3 < $size && !$done; $idx += 4 )
        {
            $x = strpos( $this->m_base64s , $p[ $idx ], 0 );

            if ( $x >= 0 )
            {
                $c = $x;
            }
            else
            {
                break;
            }

            $c *= 64;

            $x = strpos( $this->m_base64s, $p[ $idx + 1 ], 0 );

            if ( $x >= 0 )
            {
                $c += $x;
            } else
            {
                return null;
            }

            $c *= 64;

            if ( ord( $p[ $idx + 2 ] ) == ord( "=" ) )
            {
                $done++;
            } else
            {
                $x = strpos( $this->m_base64s, $p[ $idx + 2 ], 0 );

                if ( $x >= 0 )
                {
                    $c += $x;
                } else
                {
                    return null;
                }
            }

            $c *= 64;

            if ( ord( $p[ $idx + 3 ] ) == ord( "=" ) )
            {
                $done++;
            } else
            {
                if ( $done )
                {
                    return null;
                }

                $x = strpos( $this->m_base64s, $p[ $idx + 3 ], 0 );

                if ( $x >= 0 )
                {
                    $c += $x;
                } else
                {
                    return null;
                }
            }

            if ( $done < 3 )
            {
                $q[ $dataidx ] = chr( ( $c & 0x00ff0000 ) >> 16 );
                $dataidx ++;
            }

            if ( $done < 2 )
            {
                $q[ $dataidx ] = chr( ( $c & 0x0000ff00 ) >> 8 );
                $dataidx++;
            }

            if ( $done < 1 )
            {
                $q[ $dataidx ] = chr( ( $c & 0x000000ff ) >> 0 );

                $dataidx++;
            }
        }

        return implode( "", $q );
    }
}
