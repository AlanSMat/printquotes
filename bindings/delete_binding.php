<?php
include("../globals.php");

$pdo = new PDO(DSN, USER, PASS);
$pdo->exec("DELETE FROM bin_binding WHERE bin_id='" .$_REQUEST["binding_id"] . "'");

header("LOCATION: list_bindings.php");
?>