<?php
/***************************/
/* Define Static variables */
/* used throughout the     */
/* application             */
/***************************/
date_default_timezone_set('Australia/Sydney');	

define("HOST", "127.0.0.1");
define("DB",   "printquotes");
define("USER", "root");

if($_SERVER["SERVER_NAME"] == 'localhost') {
    define('PASS','');
} else {
    define('PASS','F4xm0d3m');
}

$charset = 'utf8';

define("DSN", "mysql:host=" . HOST . ";dbname=" . DB . ";charset=utf8");

/*$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$stmt = $pdo->query('SELECT hos_hostproduct FROM hos_hostproduct');
while ($row = $stmt->fetchObject())
{
    echo $row->hos_hostproduct . '<br />' . "\n";
}*/

define("FOLDER_NAME", "printquotes");

define("DOC_ROOT",$_SERVER['DOCUMENT_ROOT'] . '/' . FOLDER_NAME . "");
define("ROOT_URL","http://" . $_SERVER["SERVER_NAME"] . "/" . FOLDER_NAME . "");

define("MAIN_TITLE",         "Commercial Print Quotes");
define("COMPANY",            "News Limited");
define("INCLUDES_PATH",      DOC_ROOT."/assets/server/includes");
define("SERVER_ASSETS_PATH", DOC_ROOT."/assets/server");
define("SCRIPTS_URL",        ROOT_URL . "/assets/client/scripts");
define("IMAGES_URL",         ROOT_URL . "/assets/client/images");
define("ADMIN_URL",          ROOT_URL . "/admin");
define("CLIENT_URL",         ROOT_URL . "/assets/client");
define("CSS_URL",            ROOT_URL . "/assets/client/css");
define("CLASSES_PATH",       SERVER_ASSETS_PATH . "/classes");
define("LIBS_PATH",          SERVER_ASSETS_PATH . "/libs");

/** include general utility functions */
include(CLASSES_PATH . "/utilities.php");
require(CLASSES_PATH . "/class.Db.php");

?>