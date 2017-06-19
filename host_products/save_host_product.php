<?php
require("../globals.php");

$query = new Query();
$id = $query->save(new PDO(DSN, USER, PASS),"hos_hostproduct","hos_id",$_POST["host_product_id"],$_POST);

header("LOCATION: list_host_products.php");
?>