<?php
require("../globals.php");

$page_title = "Edit Binding";
$sub_title = "Edit Binding";

isset($_REQUEST["binding_id"]) ? $id = $_REQUEST["binding_id"] : $id = 0 ;

$pdo = new PDO(DSN, USER, PASS);		
$stmt = $pdo->query("SELECT * FROM bin_binding WHERE bin_id='" . $id . "'");

$a = $stmt->fetch();

include(INCLUDES_PATH . "/admin_header.php");
?>
<div style="width:400px">
  <form name="prn" method="post" action="save_binding.php">
    <input type="hidden" name="binding_id" value="<?php echo $id ?>">
    <table cellpadding="2" cellspacing="1" border="0" style="width:400px">
      <tr>
        <td colspan="2" class="header">Add/Edit Binding</td>
      </tr>
      <tr>
        <td class="altBgRowColor">Binding</td>
        <td class="altBgRowColor"><input name="bin_binding" type="text" class="textBox" value="<?php echo $a["bin_binding"] ?>" style="width:250px;" /></td>
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