<?php
session_start();
require("globals.php");

$page_title = "Save Quote";
ob_start();
include(INCLUDES_PATH . "/admin_header.php");

!isset($_POST["prq_selfcover"]) ? $_POST["prq_selfcover"] = 0 : $_POST["prq_selfcover"] = 1;
!isset($_POST["prq_coverpages"]) ? $_POST["prq_coverpages"] = 0 : $_POST["prq_coverpages"] = $_POST["prq_coverpages"] ;
!isset($_POST["prq_covergsm"]) ? $_POST["prq_covergsm"] = 0 : $_POST["prq_covergsm"] = $_POST["prq_covergsm"] ;
!isset($_POST["prq_listholtst"]) ? $_POST["prq_listholtst"] = 0 : $_POST["prq_listholtst"] = 1;

$_POST["prq_totalcost"] = clean_string($_POST["prq_totalcost"]);
$_POST["prq_quoterecieved"] = strtotime($_POST["prq_quoterecieved"]);

$query = new Query();
$id = $query->save(new PDO(DSN, USER, PASS),"prq_printquotes", "prq_id", $_POST["quote_id"], $_POST);

//header("LOCATION: admin_index.php");

?>
  <div style="text-align:center; padding-top:200px;">
	<?php // echo $save_message ?>
  </div>
  <?php

header("LOCATION: admin_list_all.php?pageid=list_all");
ob_end_flush();

include(INCLUDES_PATH . "/admin_footer.php");
?>