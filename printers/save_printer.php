<?php
require("../globals.php");

$query = new Query();
$id = $query->save(new PDO(DSN, USER, PASS),"prn_printer","prn_id",$_POST["printer_id"],$_POST);

header("LOCATION: list_printers.php");

?>