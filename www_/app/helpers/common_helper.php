<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
/**
 * HTTP의 URL을 "/"를 Delimiter로 사용하여 배열로 바꾸어 리턴한다.
 *
 * @param    string   $seg 대상이 되는 문자열
 *
 * @return    string[]
 */
function segment_explode( $seg )
{
    //세크먼트 앞뒤 '/' 제거후 uri를 배열로 반환
    $len = strlen( $seg );
    if ( substr( $seg, 0, 1 ) == '/' )
    {
        $seg = substr( $seg, 1, $len );
    }
    $len = strlen( $seg );
    if ( substr( $seg, -1 ) == '/' )
    {
        $seg = substr( $seg, 0, $len - 1 );
    }
    $seg_exp = explode( "/", $seg );

    return $seg_exp;
}

/**
 * url중 키값을 구분하여 값을 가져오도록.
 *
 * @param array  $url : segment_explode 한 url값
 * @param string $key : 가져오려는 값의 key
 *
 * @return String $url[$k] : 리턴값
 */
function url_explode( $url, $key )
{
    $cnt = count( $url );
    for ( $i = 0; $cnt > $i; $i++ )
    {
        if ( $url[ $i ] == $key )
        {
            $k = $i + 1;

            return $url[ $k ];
        }
    }

    return null;
}

function pagination( $link, $paging_data )
{
    $links = "";
    // The first page
    $links .= anchor( $link . '/' . $paging_data[ 'first' ], 'First', array( 'title' => 'Go to the first page', 'class' => 'first_page' ) );
    $links .= "\n";
    // The previous page
    $links .= anchor( $link . '/' . $paging_data[ 'prev' ], '<', array( 'title' => 'Go to the previous page', 'class' => 'prev_page' ) );
    $links .= "\n";
    // The other pages
    for ( $i = $paging_data[ 'start' ]; $i <= $paging_data[ 'end' ]; $i++ )
    {
        if ( $i == $paging_data[ 'page' ] )
            $current = '_current';
        else
            $current = "";
        $links .= anchor( $link . '/' . $i, $i, array( 'title' => 'Go to page ' . $i, 'class' => 'page' . $current ) );
        $links .= "\n";
    }
    // The next page
    $links .= anchor( $link . '/' . $paging_data[ 'next' ], '>', array( 'title' => 'Go to the next page', 'class' => 'next_page' ) );
    $links .= "\n";
    // The last page
    $links .= anchor( $link . '/' . $paging_data[ 'last' ], 'Last', array( 'title' => 'Go to the last page', 'class' => 'last_page' ) );
    $links .= "\n";

    return $links;
}

function paging( $page, $rp, $total, $limit )
{
    $limit -= 1;
    $mid = floor( $limit / 2 );
    if ( $total > $rp )
        $numpages = ceil( $total / $rp );
    else
        $numpages = 1;
    if ( $page > $numpages ) $page = $numpages;
    $npage = $page;
    while ( ( $npage - 1 ) > 0 && $npage > ( $page - $mid ) && ( $npage > 0 ) )
    {
        $npage -= 1;
    }
    $lastpage = $npage + $limit;
    if ( $lastpage > $numpages )
    {
        $npage = $numpages - $limit + 1;
        if ( $npage < 0 ) $npage = 1;
        $lastpage = $npage + $limit;
        if ( $lastpage > $numpages ) $lastpage = $numpages;
    }
    while ( ( $lastpage - $npage ) < $limit )
    {
        $npage -= 1;
    }
    if ( $npage < 1 ) $npage = 1;
    //echo $npage; exit;
    $paging[ 'first' ] = 1;
    if ( $page > 1 ) $paging[ 'prev' ] = $page - 1;
    else $paging[ 'prev' ] = 1;
    $paging[ 'start' ] = $npage;
    $paging[ 'end' ]   = $lastpage;
    $paging[ 'page' ]  = $page;
    if ( ( $page + 1 ) < $numpages ) $paging[ 'next' ] = $page + 1;
    else $paging[ 'next' ] = $numpages;
    $paging[ 'last' ]   = $numpages;
    $paging[ 'total' ]  = $total;
    $paging[ 'iend' ]   = $page * $rp;
    $paging[ 'istart' ] = ( $page * $rp ) - $rp + 1;
    if ( ( $page * $rp ) > $total ) $paging[ 'iend' ] = $total;

    return $paging;
}

function url_delete( $url_arr, $del_param )
{
    $arr_s = array_search( $del_param, $url_arr );
    if ( $arr_s != '' )
    {
        array_splice( $url_arr, $arr_s, 2 );
    }

    return $url_arr;
}

/**
 * 내용중에서 이미지명 추출후 DB 입력, 파일갯수 리턴. fckeditor용
 *
 * @param $str
 * @param $no
 * @param $type
 * @param $table
 * @param $table_no
 *
 * @return int
 */
function strip_image_tags_fck( $str, $no, $type, $table, $table_no )
{
    $CI         =& get_instance();
    $file_table = "files";
    preg_match_all( "<img [^<>]*>", $str, $out, PREG_PATTERN_ORDER );
    $strs = $out[ 0 ];
    //$arr=array();
    $cnt = count( $strs );
    for ( $i = 0; $i < $cnt; $i++ )
    {
        $arr  = preg_replace( "#img\s+.*?src\s*=\s*[\"']\s*\/data/images/\s*(.+?)[\"'].*?\/#", "\\1", $strs[ $i ] );
        $data = array(
            'module_id'   => $table_no,
            'module_name' => $table,
            'module_no'   => $no,
            'module_type' => $type,
            'file_name'   => $arr,
            'reg_date'    => date( "Y-m-d H:i:s" )
        );
        if ( count( $arr ) <= 25 )
        {
            $CI->db->insert( $file_table, $data );
        }
    }

    return $cnt;
}

function trim_text( $str, $len, $tail = ".." )
{
    if ( strlen( $str ) < $len )
    {
        return $str; //자를길이보다 문자열이 작으면 그냥 리턴
    }
    else
    {
        $result_str = '';
        for ( $i = 0; $i < $len; $i++ )
        {
            if ( ( Ord( $str[ $i ] ) <= 127 ) && ( Ord( $str[ $i ] ) >= 0 ) )
            {
                $result_str .= $str[ $i ];
            }
            else if ( ( Ord( $str[ $i ] ) <= 223 ) && ( Ord( $str[ $i ] ) >= 194 ) )
            {
                $result_str .= $str[ $i ] . $str[ $i + 1 ];
                $i = $i + 1;
            }
            else if ( ( Ord( $str[ $i ] ) <= 239 ) && ( Ord( $str[ $i ] ) >= 224 ) )
            {
                $result_str .= $str[ $i ] . $str[ $i + 1 ] . $str[ $i + 2 ];
                $i = $i + 2;
            }
            else if ( ( Ord( $str[ $i ] ) <= 244 ) && ( Ord( $str[ $i ] ) >= 240 ) )
            {
                $result_str .= $str[ $i ] . $str[ $i + 1 ] . $str[ $i + 2 ] . $str[ $i + 3 ];
                $i = $i + 3;
            }
        }

        return $result_str . $tail;
    }
}

/**
 * checkmb=true, len=10
 * 한글과 Eng (한글=2*3 + 공백=1*1 + 영문=1*1 => 10)
 * checkmb=false, len=10
 * 한글과 English (모두 합쳐 10자)
 *
 * @param        $str
 * @param        $len
 * @param bool   $checkmb
 * @param string $tail
 *
 * @return string
 */
function strcut_utf8( $str, $len, $checkmb = false, $tail = '..' )
{
    preg_match_all( '/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match );
    $m    = $match[ 0 ];
    $slen = strlen( $str ); // length of source string
    $tlen = strlen( $tail ); // length of tail string
    $mlen = count( $m ); // length of matched characters
    if ( $slen <= $len ) return $str;
    if ( !$checkmb && $mlen <= $len ) return $str;
    $ret   = array();
    $count = 0;
    for ( $i = 0; $i < $len; $i++ )
    {
        $count += ( $checkmb && strlen( $m[ $i ] ) > 1 ) ? 2 : 1;
        if ( $count + $tlen > $len ) break;
        $ret[] = $m[ $i ];
    }

    return join( '', $ret ) . $tail;
}

//로그인 처리용 주소 인코딩, 디코딩
function url_code( $url, $type = 'e' )
{
    if ( $type == 'e' )
    {
        //encode
        return strtr( base64_encode( addslashes( gzcompress( serialize( $url ), 9 ) ) ), '+/=', '-_.' );
    }
    else
    {
        //decode
        return unserialize( gzuncompress( stripslashes( base64_decode( strtr( $url, '-_.', '+/=' ) ) ) ) );
    }
}

//게시판 모델에서 이동. 게시물내 오토링크
function auto_link2( $str )
{
    // 속도 향상 031011
    $str = preg_replace( "/&lt;/", "\t_lt_\t", $str );
    $str = preg_replace( "/&gt;/", "\t_gt_\t", $str );
    $str = preg_replace( "/&amp;/", "&", $str );
    $str = preg_replace( "/&quot;/", "\"", $str );
    $str = preg_replace( "/&nbsp;/", "\t_nbsp_\t", $str );
    $str = preg_replace( "/([^(http:\/\/)]|\(|^)(www\.[^[:space:]]+)/i", "\\1<A HREF=\"http://\\2\" TARGET='_blank'><font color=blue><u>\\2</u></font></A>", $str );
    $str = preg_replace( "/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,]+)/i", "\\1<A HREF=\"\\2\" TARGET='_blank'><font color=blue><u>\\2</u></font></A>", $str );
    // 이메일 정규표현식 수정 061004
    //$str = preg_replace("/(([a-z0-9_]|\-|\.)+@([^[:space:]]*)([[:alnum:]-]))/i", "<a href='mailto:\\1'>\\1</a>", $str);
    $str = preg_replace( "/([0-9a-z]([-_\.]?[0-9a-z])*@[0-9a-z]([-_\.]?[0-9a-z])*\.[a-z]{2,4})/i", "<a href='mailto:\\1'>\\1</a>", $str );
    $str = preg_replace( "/\t_nbsp_\t/", "&nbsp;", $str );
    $str = preg_replace( "/\t_lt_\t/", "&lt;", $str );
    $str = preg_replace( "/\t_gt_\t/", "&gt;", $str );

    return $str;
}

function is_mobile()
{
    $useragent = $_SERVER[ 'HTTP_USER_AGENT' ];
    if ( preg_match( '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent ) || preg_match( '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr( $useragent, 0, 4 ) ) )
    {
        return true;
    }

    return false;
}

function get_UID()
{
    if ( function_exists( 'com_create_guid' ) )
    {
        return com_create_guid();
    }
    else
    {
        mt_srand( (double)microtime() * 10000 );//optional for php 4.2.0 and up.
        $charid = strtoupper( md5( uniqid( rand(), true ) ) );
        $hyphen = chr( 45 );// "-"
        $uuid   = chr( 123 )// "{"
            . substr( $charid, 0, 8 ) . $hyphen
            . substr( $charid, 8, 4 ) . $hyphen
            . substr( $charid, 12, 4 ) . $hyphen
            . substr( $charid, 16, 4 ) . $hyphen
            . substr( $charid, 20, 12 )
            . chr( 125 );// "}"
        return $uuid;
    }
}

function get_mdata( $data, $name, $defvalue )
{
    $set_value = $data ? $data->{$name} : $defvalue;

    return set_value( $name, $set_value );
}

function set_bit( $origin, $set, $shift )
{
    if ( $set )
    {
        return $origin | ( 1 << $shift );
    }

    return $origin & !( 1 << $shift );
}

function get_bit( $origin, $shift )
{
    $val = $origin & ( 1 << $shift );

    return $val >> $shift;
}

/**
 * 컨트롤러에서 전달된 값 파싱
 *
 * @param mixed  $item 전달된 값
 * @param string $var  인자이름
 * @param mixed  $def  기본값
 *
 * @return string
 */
function get_ctr_value( $item, $var, $def )
{
    return $item ? $item->$var : $def;
}

/*
function HandleXmlError( $errno, $errstr, $errfile, $errline )
{
//    if ($errno==E_WARNING && (substr_count($errstr,"DOMDocument::loadXML()")>0))
//    {
//        throw new DOMException($errstr);
//    }
//    else
//        return false;
    return false;
}
*/

function debug_flush( $msg, $is_line )
{
    ob_end_clean();
    echo $msg . ( $is_line ? '<br/>' : '' );
    echo str_pad( ' ', 256 );
    ob_flush();
    flush();
    usleep( 10 );
//    sleep( 1 );
}

function get_timeuuid()
{
    // Time based PHP Unique ID
    $uid = uniqid( null, true );
    // Random SHA1 hash
    $rawid = strtoupper( sha1( uniqid( rand(), true ) ) );
    // Produce the results
    $result = substr( $uid, 6, 8 );
    $result .= substr( $uid, 0, 4 );
    $result .= substr( sha1( substr( $uid, 3, 3 ) ), 0, 4 );
    $result .= substr( sha1( substr( time(), 3, 4 ) ), 0, 4 );
    $result .= strtolower( substr( $rawid, 10, 12 ) );

    return $result;
}

function var_dump_pretty( $object )
{
    echo '<pre>';
    var_dump( $object );
    echo '</pre>';
}

function var_dump_to_string( $object )
{
    ob_start();
    var_dump( $object );
    $result = ob_get_clean();
    return $result;
}

function print_r_pretty( $object )
{
    echo '<pre>';
    print_r( $object );
    echo '</pre>';
}

function show_phone_format( $phone )
{
    return preg_replace( "/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/", "$1-$2-$3", $phone );
}

function get_millis()
{
    list( $usec, $sec ) = explode( ' ', microtime() );

    return (int)( (int)$sec * 1000 + ( (float)$usec * 1000 ) );
}

function get_millis_to_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function show_excute_time( $start_time, $end_time )
{
    $time = $end_time - $start_time;
    $msg = $time . '초 걸림';

    debug_flush( $msg, true );
}