<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
require("globals.php");

$page_title = "Index";

include(INCLUDES_PATH . "/site_header.php");

$pdo = new PDO(DSN, USER, PASS);

$stmt = $pdo->query('SELECT * FROM tex_text');
$row = $stmt->fetchObject();

?>
<div class="homePageLayout">
    <?php echo $row->tex_text; ?>
</div>
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>