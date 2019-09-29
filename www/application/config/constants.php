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

// BEVOL SITE SCRAPE INIT DATA
define('RESOURCE_PAGE_URL' , 'https://www.bevol.cn');
define('PRODUCTDETAIL_PAGE_URL' , 'https://www.bevol.cn/product/');
define('INGREDIENTDETAIL_PAGE_URL' , 'https://www.bevol.cn/composition/');
define('GET_PRODUCTLIST_APIURL' , 'https://api.bevol.cn/search/goods/index3?');
// OTHER SITE SCRAPE INIT DATA
define('INTERNATIONALSITEURL' , 'http://117.50.56.242/province/webquery/wq.do?method=query');
define('IMPORTEDPRODUCT_HTTPHEADER_ORIGIN' , '117.50.56.242');
define('IMPORTEDPRODUCT_HTTPHEADER_REFERER' , 'http://117.50.56.242/province/webquery/list.jsp?querytype=productname&pfid=&content=');
define('INTERNATIONALSITEURL_DETAIL' , 'http://117.50.56.242/province/webquery/wq.do');
define('IMPORTEDPRODUCT_HTTPHEADER_REFERER_DETAIL' , 'http://117.50.56.242/province/webquery/show.jsp?id=');

define('IMPORTEDPRODUCT_PROBEVOLURL_PREFIX', 'IMPORTEDPRODUCT');
define('DOMESTICPRODUCT_PROBEVOLURL_PREFIX', 'DOMESTICPRODUCT');
define('INTERNATIONALSITE_CFSTR_GLUE', '、');

define('DOMESTICSITEURL' , 'http://125.35.6.80:8181/ftban/itownet/fwAction.do?method=getBaNewInfoPage');
define('DOMESTICPRODUCT_HTTPHEADER_ORIGIN' , '125.35.6.80:8181');
define('DOMESTICPRODUCT_HTTPHEADER_REFERER' , 'http://125.35.6.80:8181/ftban/fw.jsp');
define('DOMESTICSITEURL_DETAIL' , 'http://125.35.6.80:8181/ftban/itownet/fwAction.do?method=getBaInfo');
define('DOMESTICPRODUCT_HTTPHEADER_REFERER_DETAIL' , 'http://125.35.6.80:8181/ftban/itownet/hzp_ba/fw/pz.jsp');

define('COM_COUNTRY_LABEL' , '生产国/地区');			// COMPANY COUNTRY LABEL
define('COM_NAME_LABEL' , '生产企业');				// COMPANY NAME LABEL
define('COM_NAME_ALIAS_LABEL' , '生产企业英文');		// COMPANY ALIAS LABEL
define('FLAVOR_LABEL' , '香精');						// FLAVOR
define('PRESERVATIVE_LABEL' , '防腐剂');				// PRESERVATIVE
define('SECURITYRISK_LABEL' , '风险成分');			// SECURITY RISK
define('PREGANTCAUTION_LABEL' , '孕妇慎用');			// PREGANTCAUTION
define('MAINFUNCTION_LABEL' , '主要功效成分');		// MAINFUNCTION
define('CLEANSING_LABEL' , '清洁成分');				// CLEANSING
define('AMINOACID_LABEL' , '氨基酸表活成分');			// AMINOACID
define('SLS_SLES_LABEL' , 'sls/sles成分');			// SLS/SLES

define('MOISTURIZER_SEARCHKEY', '保湿剂');
define('ANTIOXIDANTS_SEARCHKEY', '抗氧化剂');
define('WHITENING_SEARCHKEY', '美白祛斑');

define('SCHOOLTITLE' , '瓦呐尔');
define('LOGOIMGURL' , './uploads/bg/logo_frontend.png');
define('FRONTENDLOGOIMGURL' , './uploads/bg/logo_frontend.png');
define('FAVICONURL' , './uploads/bg/favicon.png');
define('LOADING_GIF_FILE_URL' , './uploads/bg/Loading_icon.gif');
define('DEFAULT_AVATAR_IMGURL' , './uploads/avatars/default.png');
define('PRODUCTDEFAULTIMAGEURL' , './uploads/bg/defaultproduct.png');
define('COMPANYDEFAULTIMAGEURL' , './uploads/bg/default.jpg');
define('ING_GOOD_STATE_IMGURL' , './uploads/bg/goodstate.png');
define('ING_WARNING_STATE_IMGURL' , './uploads/bg/warningstate.png');
define('LOADDATAPERPAGE' , 20);

define('DEFAULTSHOPPINGCATEGORYIMGWIDTH', 100);
define('DEFAULTSHOPPINGCATEGORYIMGHEIGHT', 100);
define('DEFAULTIMGWIDTH', 500);
define('DEFAULTIMGHEIGHT', 500);
define('DEFAULTPASSWORD', '123456789');
