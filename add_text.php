<?php
require("globals.php");

$page_title = "Add Text";

$pdo = new PDO(DSN, USER, PASS);		
$stmt = $pdo->query("SELECT * FROM tex_text");
$a = $stmt->fetch();


include(INCLUDES_PATH . "/admin_header.php");

?>
<div style="margin-left:auto;margin-right:auto;">
    <form method="post" action="save_text.php">
	<div>		
            <textarea rows="30" cols="157" class="textBox" name="tex_text"><?php echo str_replace("<br />", "", $a["tex_text"]); ?></textarea>
	</div>
	<div style="padding:10px 20px 0px 35px;">
		<p style="padding-right:10px;"><input type="reset" value="Reset" class="button" /></p>
		<p><input type="submit" value="Submit" class="button" /></p>
	</div>
    </form>
</div>
<?php
include(INCLUDES_PATH . "/admin_footer.php");
?>