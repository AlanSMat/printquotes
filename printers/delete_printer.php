<?php
require("../globals.php");

$pdo = new PDO(DSN, USER, PASS);
$pdo->exec("DELETE FROM prn_printer WHERE prn_id='" .$_REQUEST["printer_id"] . "'");

header("LOCATION: list_printers.php");
?>