<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
 * -------------------------------------------------------------------------------
 * Application Constant;
 * -------------------------------------------------------------------------------
 */
// Layout Kind
define( 'LAYOUT_EMPTY', 'empty' );
define( 'LAYOUT_HCF', 'hcf' );
define( 'LAYOUT_HLCF', 'hlcf' );
define( 'LAYOUT_HCRF', 'hcrf' );
define( 'LAYOUT_HLCRF', 'hlcrf' );
define( 'LAYOUT_C', 'c' );
define( 'LAYOUT_HLC', 'hlc' );

/*// Javascript Position Kind
define( 'JS_KIND_WEB', 0 );
define( 'JS_KIND_BASE', 1 );
define( 'JS_KIND_THEME', 2 );

// CSS Position Kind
define( 'CSS_KIND_WEB', 0 );
define( 'CSS_KIND_BASE', 1 );
define( 'CSS_KIND_THEME', 2 );*/


//define( 'DEV_STR', 'dev' );
define( 'DEV_STR', '' );
define( 'WEB_RES', '/web/assets');

/*define( 'CSS_RES', '/assets/dist/css/');
define( 'CSS_RES2', '/assets/dist2/css/');
define( 'EDITOR_RES', '/assets/editor/');
define( 'ICON_RES', '/assets/icons/');
define( 'IMG_RES', '/assets/images/');
define( 'CIMG_RES', '/assets/cimg/');
define( 'JS_RES', '/assets/dist/js/');
define( 'JS_RES2', '/assets/dist2/js/');
define( 'JS_PLUGIN_RES', '/assets/node_modules/');
define( 'SCSS_RES', '/assets/dist/scss/');

define( 'CUS_RES', '/res/');

define( 'T_CSS_RES', '/resource/css/');
define( 'T_FONT_RES', '/resource/font/');
define( 'T_IMG_RES', '/resource/images/');
define( 'T_JS_RES', '/resource/js/');*/

defined('SCRIPT_VER')      		OR define('SCRIPT_VER', '1.0.0');
defined('CSS_VER')      		OR define('CSS_VER', '1.0.1');

$now_url = $_SERVER['REQUEST_URI'];
$arr_link = explode('?', $now_url);
$now_link = isset($arr_link[0]) ? $arr_link[0] : "";
$arr_link2 = explode('/', $now_url);
$folder = isset($arr_link2[1]) ? $arr_link2[1] : "";

define( 'NOW_FOLDER', $folder);
define( 'NOW_LINK', $now_link);

//LOC_TYPE
$REQUEST_URI_ARR = explode("/", $_SERVER['REQUEST_URI']);
define( 'LOC_TYPE', $REQUEST_URI_ARR[1]);

//SITE INFO
define( 'HEAD_TITLE', "성우환경");
define( 'HEAD_KEYWORD', "카메라, 영상, PIXELCAST");
define( 'HEAD_DISC', "카메라, 영상, PIXELCAST");
define( 'HEAD_AUTHOR', "카메라, 영상, PIXELCAST");

define( 'TOP_STYLE', "A"); // A: B :


