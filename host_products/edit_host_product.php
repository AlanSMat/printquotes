<?php
require("../globals.php");

$page_title = "Edit Host Product";
$sub_title = "Edit Host Product";

isset($_REQUEST["host_product_id"]) ? $id = $_REQUEST["host_product_id"] : $id = 0 ;

$pdo = new PDO(DSN, USER, PASS);		
$stmt = $pdo->query("SELECT * FROM hos_hostproduct WHERE hos_id='" . $id . "'");
$a = $stmt->fetch();

include(INCLUDES_PATH . "/admin_header.php");
?>
<div style="width:400px">
  <form name="prn" method="post" action="save_host_product.php">
    <input type="hidden" name="host_product_id" value="<?php echo $id ?>">
    <table cellpadding="2" cellspacing="1" border="0" style="width:400px">
      <tr>
        <td colspan="2" class="header">Add/Edit Host Product</td>
      </tr>
      <tr>
        <td class="altBgRowColor">Host Product</td>
        <td class="altBgRowColor"><input name="hos_hostproduct" type="text" class="textBox" value="<?php echo $a["hos_hostproduct"] ?>" style="width:250px;" /></td>
      </tr>      
    </table>
    <div class="buttonSpacing">
      <input type="submit" value="Submit" class="button" />
    </div>
  </form>
</div>
<?php
include(INCLUDES_PATH . "/admin_footer.php");
?>