<?php
require("globals.php");

$page_title = "Save Text";
$_POST["tex_text"] = nl2br(ereg_replace("'", "", $_POST["tex_text"]));

$query = new Query();
$id = $query->save(new PDO(DSN, USER, PASS),"tex_text", $_POST, "WHERE tex_id=1");

header("LOCATION: admin_index.php?pageid=default");
?>