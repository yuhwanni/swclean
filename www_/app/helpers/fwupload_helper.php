<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * cronupload_show_dialog
 *
 * 업로드 버튼 눌렀을 때 보여지는 창
 *
 * @param   object      $ctr_instance   업로드를 처리할 컨트롤러 인스턴스
 * @param   array   $config 폼 데이터
 *                  wrap_divid  감싸지는 div 태그 ID
 *                  title       창에 보여질 제목
 *                  form_name   전송 form ID 및 Name
 *                  regist_url  폼 전송될 URL
 *                  input_name  file input 태크 ID 및 name
 *
 * @return  string  html 태그 문자열
 */
function cronupload_show_dialog( $ctr_instance, $config = array() )
{
    $ctr_instance->load->helper( 'form' );

    $html = '<div id="' . $config[ 'wrap_divid' ] . '" title="' . $config[ 'title' ] . '" style="display:none;">';
    $html .= '<p class="validateTips">' . $config[ 'desc' ] . '</p>';

    $attributes = array( 'id' => $config[ 'form_name' ], 'name' => $config[ 'form_name' ], 'method' => 'post' );
    $html .= form_open_multipart( $config[ 'regist_url' ], $attributes );

    $html .= '<fieldset>' .
             '<input type="file" name="' . $config[ 'input_name' ] . '" id="' . $config[ 'input_name' ] . '"' .
             ' class="text ui-widget-content ui-corner-all">' .
             '</fieldset>' .
             '<div id="cron_progressbar"></div>';
    $html .= form_close();

    $html = preg_replace( '/\r\n|\r|\n/', '<br>', $html );

    return $html;
}

/**
 * cronupload_process
 *
 * 업로드 통신이 들어왔을 때 업로드 처리 함수
 *
 * @param   object      $ctr_instance   업로드를 처리할 컨트롤러 인스턴스
 * @param   string      $addpath        기본 upload경로에 추가로 생성할 폴더명
 * @param   array       $config         upload 환경설정( codeigniter upload 설정 사용)
 *
 * @return  string json 형식의 결과. jquery_upload.js에 통신 결과 넘겨줌
 */

function cronupload_process( $ctr_instance, $addpath, $config = array() )
{
    /* 업로드 설정 */
    $path = $ctr_instance->get_path_upload();
    $realpath =  $ctr_instance->get_path_filebase() . $path;

    if ( $addpath != '' )
    {
//        $path .= '/' . $addpath;
        $realpath .= '/' . $addpath;

        if ( is_dir( $realpath ) == FALSE )
        {
            if ( !@mkdir( $realpath, 0777, TRUE ) )
            {
                $result[ 'ret' ] = 0;
                $result[ 'reason' ] = '내부 서버에 문제가 있습니다. 잠시후 다시 시도해 주세요';
                echo json_encode( $result );
                exit;
            }
        }
    }

    $up_conf[ 'allowed_types' ] = array_key_exists( 'allowed_type', $config ) ? $config[ 'allowed_type' ] : '*';
    $up_conf[ 'max_size' ] = array_key_exists( 'max_size', $config ) ? $config[ 'max_size' ] : 20000;

    if ( array_key_exists( 'max_width', $config ) )
    {
        $up_conf[ 'max_width' ] = $config[ 'max_width' ];
    }

    if ( array_key_exists( 'max_height', $config ) )
    {
        $up_conf[ 'max_height' ] = $config[ 'max_height' ];
    }

    if ( array_key_exists( 'file_name', $config ) )
    {
        $up_conf[ 'file_name' ] = $config[ 'file_name' ];
    }

    $up_conf[ 'overwrite' ] = array_key_exists( 'overwrite', $config ) ? $config[ 'overwrite' ] : TRUE;
    $up_conf[ 'upload_path' ] = $realpath . '/';
    $up_conf[ 'remove_spaces' ] = TRUE;

    $ctr_instance->load->library( 'upload', $up_conf );

    $result = array();

    $result[ 'ret' ] = 0;
    $result[ 'reason' ] = '시작';

    /* 업로드 처리 */
    $cnt = 0;
    foreach ( $_FILES as $field => $file )
    {
        if ( $file[ 'error' ] == 0 )
        {
            if ( $ctr_instance->upload->do_upload( $field ) )
            {
//                $var_name = $field . "_path";
                $upload_data = $ctr_instance->upload->data();
                $var_name = $upload_data[ 'full_path' ];
                $var_name = preg_replace( "#^" . $_SERVER[ 'DOCUMENT_ROOT' ] . "#", "", $var_name );

                $cnt++;
            }
            else
            {
                $result[ 'ret' ] = -1;
                $errors = strip_tags( $ctr_instance->upload->display_errors() );
                $message = "파일 업로드 중 오류 발생했습니다. $errors";
                $result[ 'reason' ] = $message;
                break;
            }
        }
        else
        {
            $result[ 'reason' ] = $file[ 'error' ];
            break;
        }
    }

    if ( $result[ 'ret' ] >= 0 )
    {
        if ( $cnt > 0 )
        {
            $result[ 'ret' ] = 1;
            /** @noinspection PhpUndefinedVariableInspection */
            $result[ 'path' ] = $var_name;
        }
        else
        {
            $result[ 'ret' ] = 0;
            $result[ 'reason' ] = '업로드 파일을 지정하세요';
        }
    }

    return json_encode( $result );
}

function cronupload_process_remote( $ctr_instance, $config_ftp, $addpath, $addname, $config = array() )
{
    /* 업로드 설정 */
    /** @noinspection PhpUndefinedMethodInspection */
    $path     = $ctr_instance->get_path_upload();
    /** @noinspection PhpUndefinedMethodInspection */
    $realpath =  $ctr_instance->get_path_filebase() . $path;

    if ( $addpath != '' )
    {
        $realpath .= '/' . $addpath;

        if ( is_dir( $realpath ) == FALSE )
        {
            if ( !@mkdir( $realpath, 0777, TRUE ) )
            {
                $result[ 'ret' ] = 0;
                $result[ 'reason' ] = '내부 서버에 문제가 있습니다. 잠시후 다시 시도해 주세요';
                echo json_encode( $result );
                exit;
            }
        }
    }

    $up_conf[ 'allowed_types' ] = array_key_exists( 'allowed_type', $config ) ? $config[ 'allowed_type' ] : '*';
    $up_conf[ 'max_size' ] = array_key_exists( 'max_size', $config ) ? $config[ 'max_size' ] : 20000;

    if ( array_key_exists( 'max_width', $config ) )
    {
        $up_conf[ 'max_width' ] = $config[ 'max_width' ];
    }

    if ( array_key_exists( 'max_height', $config ) )
    {
        $up_conf[ 'max_height' ] = $config[ 'max_height' ];
    }

    if ( array_key_exists( 'file_name', $config ) )
    {
        $up_conf[ 'file_name' ] = $config[ 'file_name' ];
    }

    $up_conf[ 'overwrite' ] = array_key_exists( 'overwrite', $config ) ? $config[ 'overwrite' ] : TRUE;
    $up_conf[ 'upload_path' ] = $realpath . '/';
    $up_conf[ 'remove_spaces' ] = TRUE;

    $ctr_instance->load->library( 'upload', $up_conf );
    $ctr_instance->load->library( 'ftp' );

    $ctr_instance->ftp->connect( $config_ftp );
    $basepath_ftp = $config_ftp[ 'remote_path' ];

    $result = array();

    $result[ 'ret' ] = 0;
    $result[ 'reason' ] = '시작';

    $var_name = "";
    /** @noinspection PhpUnusedLocalVariableInspection */
    $message   = "";
    $file_name = "";

    /* 업로드 처리 */
    $cnt = 0;
    foreach ( $_FILES as $field => $file )
    {
        if ( $file[ 'error' ] == 0 )
        {
            $tname = explode( '.', $file[ 'name' ] );

            if ( count( $tname ) > 0 )
            {
                $_FILES[ $field ][ 'name' ] = $tname[ 0 ] . '_' . $addname .  '.' . $tname[ 1 ];
            }
            else
            {
                $_FILES[ $field ][ 'name' ] = $tname[ 0 ] . '_' . $addname;
            }

            if ( $ctr_instance->upload->do_upload( $field ) )
            {
                $upload_data = $ctr_instance->upload->data();
                $file_name = $upload_data[ 'file_name' ];
                $source = $realpath . '/' . $file_name;
                if ( $ctr_instance->ftp->upload( $source, $basepath_ftp . $addpath . '/' . $file_name ) )
                {
                    $var_name = $config_ftp[ 'baseUrl' ] . $addpath . '/' . $file_name;
                }
                else {
                    $errors = $ctr_instance->upload->display_errors();
                    $message = "파일 업로드 중 오류 발생했습니다(1). $errors";

                    $result[ 'ret' ] = -1;
                    $result[ 'reason' ] = $message;

                    unlink( $source );
                    break;
                }

                unlink( $source );

                $cnt++;
            }
            else
            {
                $errors = strip_tags( $ctr_instance->upload->display_errors() );
                $message = "파일 업로드 중 오류 발생했습니다. $errors";
                $result[ 'ret' ] = -1;
                $result[ 'reason' ] = $message;
                break;
            }
        }
        else
        {
            $result[ 'reason' ] = $file[ 'error' ];
            break;
        }
    }

    $ctr_instance->ftp->close();

    if ( $result[ 'ret' ] >= 0 )
    {
        if ( $cnt > 0 )
        {
            $result[ 'ret' ] = 1;
            $result[ 'path' ] = $var_name;
            $result[ 'fname' ] = $file_name;
        }
        else
        {
            $result[ 'ret' ] = 0;
            $result[ 'reason' ] = '업로드 파일을 지정하세요';
        }
    }

    return $result;
}


function cronupload_file_del_remote( $ctr_instance, $config_ftp, $img_name)
{
    $ctr_instance->load->library( 'ftp' );
    $ctr_instance->ftp->connect( $config_ftp );

    $basepath_ftp = $config_ftp[ 'remote_path' ];

    $result = array();
    $result[ 'ret' ] = 0;
    $del_url = $basepath_ftp . $img_name;

    /* 파일삭제 처리 */
    $ctr_instance->ftp->delete_file($del_url);

    $ctr_instance->ftp->close();

    $result[ 'ret' ] = 1;
    return $result;
}
