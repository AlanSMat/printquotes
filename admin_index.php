<?php
session_start();

header("Cache-Control: no-cache, must-revalidate");
require("globals.php");

$pdo = new PDO(DSN, USER, PASS);

$page_title = "Admin Index";

include(INCLUDES_PATH . "/admin_header.php");

$stmt = $pdo->query('SELECT * FROM tex_text');
$row = $stmt->fetchObject();

?>
<div class="homePageLayout">
<?php 
  echo $row->tex_text;
?>  

</div>
<?php
include(INCLUDES_PATH . "/admin_footer.php");
?>