<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/*
 * CKEditor helper for CodeIgniter
 *
 * @author Samuel Sanchez <samuel.sanchez.work@gmail.com> - http://kromack.com/
 * @package CodeIgniter
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/us/
 * @tutorial http://kromack.com/developpement-php/codeigniter/ckeditor-helper-for-codeigniter/
 * @see http://codeigniter.com/forums/viewthread/127374/
 * @version 2010-08-28
 *
 */

/**
 * This function adds once the CKEditor's config vars
 * @author Samuel Sanchez
 * @access private
 * @param array $data (default: array())
 * @return string
 */
function ckeditor_initialize( $data = array() )
{
    $return = '';

    if ( ! defined( 'CI_CKEDITOR_HELPER_LOADED' ) )
    {
        define( 'CI_CKEDITOR_HELPER_LOADED', TRUE );
        $return =  '<script type="text/javascript" src="' . ( $data[ 'path_is_url' ] ? base_url() : '' ) . $data[ 'path' ] . '/ckeditor.js"></script>' . "\n";
        $return .= '<script type="text/javascript">CKEDITOR_BASEPATH = \'' . ( $data[ 'path_is_url' ] ? base_url() : '' ) . $data['path'] . "/';</script>\n";
    }

    return $return;
}

/**
 * This function create JavaScript instances of CKEditor
 * @author Samuel Sanchez
 * @access private
 * @param array $data (default: array())
 * @return string
 */
function ckeditor_create_instance( $data = array() )
{
    /*
    if ( isset( $data[ 'csrf_tk' ] ) )
    {
        $return = '<script type="text/javascript" src="' . $data[ 'jqr_form_url' ] . '"></script>';
    }
    */

    $addData = "{";
    //Adding config values
    if ( isset( $data[ 'config' ] ) )
    {
        $arrConfigKeys = array_keys( $data[ 'config' ] );

        foreach( $data[ 'config' ] as $k => $v )
        {
            // Support for extra config parameters
            if ( is_array( $v ) )
            {
                $addData .= $k . " : [";
                $addData .= ckeditor_config_data( $v );
                $addData .= "]";
            }
            else
            {
                if ( $k == 'filebrowserBrowseUrl' OR $k == 'filebrowserUploadUrl' )
                {
                    $is_add = FALSE;

                    if ( isset( $data[ 'csrf_pass' ] ) )
                    {
                        $v .= '?cron_pass=' . $data[ 'csrf_pass' ];
                        $is_add = TRUE;
                    }

                    if ( isset( $data[ 'adddata' ] ) )
                    {
                        if ( $is_add )
                        {
                            $v .= '&';
                        }
                        else
                        {
                            $v .= '?';
                        }

                        $v .= $data[ 'adddata' ];
                    }
                }

                $addData .= $k . " : '" . $v . "'";
            }

            if ( $k !== end( $arrConfigKeys ) )
            {
                $addData .= ",";
            }
        }
    }

    $addData .= '}';

    $return = '<script type="text/javascript">' . "\n";
    $return .= 'if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
            CKEDITOR.tools.enableHtml5Elements( document );';
    $return .= 'var initCKeditor = ( function() {
            var wysiwygareaAvailable = isWysiwygareaAvailable(),
                isBBCodeBuiltIn = !!CKEDITOR.plugins.get( \'bbcode\' );

            return function() {
                var editorElement = CKEDITOR.document.getById( \'' . $data[ 'id' ] . '\' );

                // Depending on the wysiwygare plugin availability initialize classic or inline editor.
                if ( wysiwygareaAvailable )
                {
                    CKEDITOR.replace( \'' . $data['id'] . '\', ' . $addData . ' );
                } else {
                    editorElement.setAttribute( \'contenteditable\', \'true\' );
                    CKEDITOR.inline( \'' . $data[ 'id' ] . '\', ' . $addData . ' );

                    // TODO we can consider displaying some info box that
                    // without wysiwygarea the classic editor may not work.
                }
            };

            function isWysiwygareaAvailable() {
                // If in development mode, then the wysiwygarea must be available.
                // Split REV into two strings so builder does not replace it :D.
                if ( CKEDITOR.revision == ( \'%RE\' + \'V%\' ) ) {
                    return true;
                }

                return !!CKEDITOR.plugins.get( \'wysiwygarea\' );
            }
        } )();
        initCKeditor();';
    $return .= "\n</script>\n";

    return $return;

}

/**
 * This function displays an instance of CKEditor inside a view
 * @author Samuel Sanchez
 * @access public
 * @param array $data (default: array())
 * @return string
 */
function ckeditor_display( $data = array() )
{
    // Initialization
    $return = ckeditor_initialize( $data );

    // Creating a Ckeditor instance
    $return .= ckeditor_create_instance( $data );

    // Adding styles values
    if ( isset( $data[ 'styles' ] ) )
    {
        $return .= "<script type=\"text/javascript\">\nCKEDITOR.addStylesSet( 'my_styles_" . $data['id'] . "', [";

        foreach ( $data[ 'styles' ] as $k => $v )
        {
            $return .= "{ name : '" . $k . "', element : '" . $v['element'] . "', styles : { ";

            if ( isset( $v[ 'styles' ] ) )
            {
                foreach( $v[ 'styles' ] as $k2 => $v2 )
                {
                    $return .= "'" . $k2 . "' : '" . $v2 . "'";

                    if ( $k2 !== end( array_keys( $v[ 'styles' ] ) ) )
                    {
                        $return .= ",";
                    }
                }
            }

            $return .= '} }';

            if ( $k !== end( array_keys( $data[ 'styles' ] ) ) )
            {
                $return .= ',';
            }
        }

        $return .= ']);';

        $return .= "CKEDITOR.instances['" . $data[ 'id' ] . "'].config.stylesCombo_stylesSet = 'my_styles_" . $data[ 'id' ] . "';
        \n</script>\n";
    }

    return $return;
}

/**
 * config_data function.
 * This function look for extra config data
 *
 * @author ronan
 * @link http://kromack.com/developpement-php/codeigniter/ckeditor-helper-for-codeigniter/comment-page-5/#comment-545
 * @access public
 * @param array $data. (default: array())
 * @return String
 */
function ckeditor_config_data( $data = array() )
{
    $return = '';
    foreach ( $data as $key )
    {
        if ( is_array( $key ) )
        {
            $return .= "[";
            foreach ( $key as $string )
            {
                $return .= "'" . $string . "'";
                if ( $string != end( array_values( $key ) ) ) $return .= ",";
            }
            $return .= "]";
        }
        else {
            $return .= "'".$key."'";
        }

        if ( $key != end( array_values( $data ) ) ) $return .= ",";

    }

    return $return;
}

function ckeditor_upload_process( $ctr_instance, $addpath, $addname )
{
    /* 업로드 설정 */
    /** @noinspection PhpUndefinedMethodInspection */
    $path     = $ctr_instance->get_path_upload();
    /** @noinspection PhpUndefinedMethodInspection */
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

    $upload_config = array(
        'upload_path' => $realpath . '/',
        'allowed_types' => '*',
        'encrypt_name' => FALSE
    );

    $ctr_instance->load->library( 'upload', $upload_config );

    $var_name = "";
    $message = "";

    /* 업로드 처리 */
    foreach ( $_FILES as $field => $file )
    {
        if ( $file[ 'error' ] == 0 )
        {
            $tname = explode( '.', $file[ 'name' ] );

            if ( count( $tname ) > 0 )
            {
                $_FILES[ $field ][ 'name' ] = $addname . '_' . $tname[ 0 ] . '.' . $tname[ 1 ];
            }
            else
            {
                $_FILES[ $field ][ 'name' ] = $addname . '_' . $tname[ 0 ];
            }

            if ( $ctr_instance->upload->do_upload( $field ) )
            {
//                $var_name = $field . "_path";
                $upload_data = $ctr_instance->upload->data();
                $var_name = $upload_data[ 'full_path' ];
                $var_name = preg_replace( "#^" . $_SERVER[ 'DOCUMENT_ROOT' ] . "#", "", $var_name );
            }
            else
            {
                $errors = $ctr_instance->upload->display_errors();
                $message = "파일 업로드 중 오류 발생했습니다. $errors";
            }
        }
    }

    echo '<script type="text/javascript">'
        . 'window.parent.CKEDITOR.tools.callFunction(' . $ctr_instance->input->get('CKEditorFuncNum') . ', '
        . '"' . $var_name . '", '
        . '"' . $message . '");'
        . '</script>';
}

function ckeditor_upload_process_to_remote( $ctr_instance, $config_ftp, $addpath, $addname )
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

    $upload_config = array(
        'upload_path' => $realpath . '/',
        'allowed_types' => '*',
        'encrypt_name' => FALSE
    );

    $ctr_instance->load->library( 'upload', $upload_config );
    $ctr_instance->load->library( 'ftp' );

    $ctr_instance->ftp->connect( $config_ftp );
    $basepath_ftp = $config_ftp[ 'remote_path' ];

    $var_name = "";
    $message = "";

    /* 업로드 처리 */
    foreach ( $_FILES as $field => $file )
    {
        if ( $file[ 'error' ] == 0 )
        {
            $tname = explode( '.', $file[ 'name' ] );

            if ( count( $tname ) > 0 )
            {
                $_FILES[ $field ][ 'name' ] = $addname . '_' . $tname[ 0 ] . '.' . $tname[ 1 ];
            }
            else
            {
                $_FILES[ $field ][ 'name' ] = $addname . '_' . $tname[ 0 ];
            }

            if ( $ctr_instance->upload->do_upload( $field ) )
            {
                $upload_data = $ctr_instance->upload->data();
                $file_name = $upload_data[ 'file_name' ];
                $source = $realpath . '/' . $file_name;
                if ( $ctr_instance->ftp->upload( $source, $basepath_ftp . $addpath . '/' . $file_name ) ) {
                    $var_name = $config_ftp[ 'baseUrl' ] . $addpath . '/' . $file_name;
                }
                else {
                    $errors = $ctr_instance->upload->display_errors();
                    $message = "파일 업로드 중 오류 발생했습니다(1). $errors";
                }

                unlink( $source );
            }
            else
            {
                $errors = $ctr_instance->upload->display_errors();
                $message = "파일 업로드 중 오류 발생했습니다(0). $errors";
            }
        }
    }

    $ctr_instance->ftp->close();

    echo '<script type="text/javascript">'
        . 'window.parent.CKEDITOR.tools.callFunction(' . $ctr_instance->input->get('CKEditorFuncNum') . ', '
        . '"' . $var_name . '", '
        . '"' . $message . '");'
        . '</script>';
}
