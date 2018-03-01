<?php
// }}}
// {{{ GLOBALS
/**
 *@global Debug  -Enable Debug mode
 *@global DEBUG_SLOW_DOWN_AJAX -slows down ajax to 1000
 *@global ENVIRONMENT -Defines ENVIRONMENT to development
 *@global BASE_PATH -sets base_path
 *@global LIB_PATH -sets path for lib Directory
 *@global MODEL_PATH -sets path for Model Directory
 *@global VIEW_PATH -sets path for View Directory
 *@global CONTROLLER_PATH -sets path for Controller Directory
 *@global DB_HOST -sets database connection
 *@global DB_NAME -sets db username to login
 *@global DB_PASS -sets db password for login
 *@global DB_USER -sets database name
 */
define('DEBUG', true);
define('DEBUG_SLOW_DOWN_AJAX', 1000);
define('ENVIRONMENT', 'development');
define('BASE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('LIB_PATH', BASE_PATH . 'lib' . DIRECTORY_SEPARATOR);
define('MODEL_PATH', BASE_PATH . 'model' . DIRECTORY_SEPARATOR);
define('VIEW_PATH', BASE_PATH . 'view' . DIRECTORY_SEPARATOR);
define('CONTROLLER_PATH', BASE_PATH . 'controller' . DIRECTORY_SEPARATOR);
define('DATA_PATH', BASE_PATH . 'data' . DIRECTORY_SEPARATOR);
define('DB_HOST', '');
define('DB_NAME', '');
define('DB_PASS', '');
define('DB_USER', 'kb_CancerVariant_Curation');

/**
* Set url variables and define BASE_URL_PATH
* @param variable $url  - set url _SERVER URL and script name
*@global BASE_URL_PATH -sets dirname of $url
**/

$url = isset($_SERVER['URL']) ? $_SERVER["URL"] : $_SERVER["SCRIPT_NAME"] ;
define('BASE_URL_PATH', dirname($url));


/**
* Set config variable as array
* @param array $config  - sets config ,  it isnt used
**/
$config = array();


/**
* Set lib directories
**/
require_once LIB_PATH . 'view.php';
require_once LIB_PATH . 'controller_base.php';
require_once LIB_PATH . 'bootstrap.php';
require_once LIB_PATH . 'Route.php';
require_once LIB_PATH . 'connection.php';
require_once LIB_PATH . 'logging.php';
require_once LIB_PATH . 'abstract_model.php';
require_once LIB_PATH . 'json.php';
/**
* Set Session path
*
* @global CSS_PATH - sets PATH for css directory
* @global JS_PATH -sets path for Javascript directlry
**/
session_save_path('/var/www/html/CancerCurationView/session');
ini_set('session.gc_probability', 1);
define('CSS_PATH', BASE_URL_PATH  . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR);
define('JS_PATH', BASE_URL_PATH  . DIRECTORY_SEPARATOR . 'javascript' . DIRECTORY_SEPARATOR);

Route::start(); // run routing
