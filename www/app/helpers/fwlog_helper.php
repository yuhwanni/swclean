<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

// 메시지 출력 후 이동
function cronlog_message( $level = 'error', $message )
{
    $func_info = get_debug_print_function();
    $style = 'style="width:1000px;padding:10px;margin: 0 auto;border: 1px solid ';

    if ( $level == 'info' )
    {
        $color = 'green';
    }
    else if ( $level == 'debug' )
    {
        $color = 'blue';
    }
    else
    {
        $color = 'red';
    }

    $style .= $color . ';"';

    echo '<div ' . $style . '>';
    echo '<div style="color:#ccc">' . $func_info[ 0 ] . '</div>';
    echo '<div style="color:' . $color . ';">' . $message . '</div>';
    echo '</div>';
}

function get_debug_print_backtrace( $traces_to_ignore = 1 )
{
    $traces = debug_backtrace();
    $ret = array();

    foreach ( $traces as $i => $call )
    {
        if ( $i < $traces_to_ignore )
        {
            continue;
        }

        $object = '';

        if ( isset( $call[ 'class' ] ) )
        {
            $object = $call['class'].$call['type'];

            if ( is_array( $call[ 'args' ] ) )
            {
                foreach ( $call[ 'args' ] as &$arg )
                {
                    get_arg( $arg );
                }
            }
        }

        $ret[] = '#' . str_pad( $i - $traces_to_ignore, 3, ' ' )
            . $object . $call[ 'function' ] . '(' . implode( ', ', $call[ 'args' ] )
            . ') called at [' . $call[ 'file' ] . ':' . $call[ 'line' ] . ']';
    }

    return implode( "\n", $ret );
}

function get_debug_print_function( $traces_to_ignore = 1 )
{
    $traces = debug_backtrace();
    $ret = array();

    foreach( $traces as $i => $call )
    {
        if ( $i < $traces_to_ignore )
        {
            continue;
        }

//        $object = '';
        if ( isset( $call[ 'class' ] ) )
        {
//            $object = $call[ 'class' ] . $call[ 'type' ];

            if ( is_array( $call[ 'args' ] ) )
            {
                foreach ( $call[ 'args' ] as &$arg )
                {
                    get_arg( $arg );
                }
            }
        }

        if ( array_key_exists( 'file', $call ) )
        {
            $ret[] = '[' . $call[ 'file' ] . ':' . $call[ 'line' ] . ']';
        }
     }

    //return implode("\n",$ret);
    return $ret;
}

function get_arg(&$arg) {
     if (is_object($arg)) {
         $arr = (array)$arg;
         $args = array();
         foreach($arr as $key => $value) {
             if (strpos($key, chr(0)) !== false) {
                 $key = '';    // Private variable found
             }
             $args[] =  '['.$key.'] => '.get_arg($value);
         }

         $arg = get_class($arg) . ' Object ('.implode(',', $args).')';
     }
}
