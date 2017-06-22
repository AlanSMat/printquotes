<?php
require("globals.php");

$page_title = "Save Text";
$_POST["tex_text"] = nl2br(str_replace("'", "", $_POST["tex_text"]));

$_POST["tex_id"] = "1";

$query = new Query();
$id = $query->save(new PDO(DSN, USER, PASS),"tex_text","tex_id", $_POST["tex_id"],$_POST);

header("LOCATION: admin_index.php?pageid=default");
?>