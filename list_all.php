<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
require("globals.php");

$page_title = "List All";
include(CLASSES_PATH . "/class.DD_text.php");

include(INCLUDES_PATH . "/site_header.php");

include("list_all_inc.php");

include(INCLUDES_PATH . "/site_footer.php");
?>