<?php
session_start();

header("Cache-Control: no-cache, must-revalidate");
require("globals.php");

$page_title = "Admin Index";
include(CLASSES_PATH . "/class.DD_text.php");

include(INCLUDES_PATH . "/admin_header.php");

include("list_all_inc.php");

include(INCLUDES_PATH . "/admin_footer.php");
?>