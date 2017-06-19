<?php
require("../globals.php");

$query = new Query();
$id = $query->save(new PDO(DSN, USER, PASS),"bin_binding","bin_id",$_POST["binding_id"],$_POST);

header("LOCATION: list_bindings.php");

?>