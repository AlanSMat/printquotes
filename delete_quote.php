<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
require("globals.php");

$query = new Query("DELETE FROM prq_printquotes WHERE prq_id='" . $_REQUEST["quoteid"] . "'");
header("LOCATION: admin_index.php");
?>