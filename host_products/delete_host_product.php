<?php
include("../globals.php");

$pdo = new PDO(DSN, USER, PASS);
$pdo->exec("DELETE FROM hos_hostproduct WHERE hos_id='" .$_REQUEST["host_product_id"] . "'");

header("LOCATION: list_host_products.php");

?>