<?php
require("../globals.php");

$page_title = "Edit Printer";
$sub_title = "Edit Printer";

isset($_REQUEST["printer_id"]) ? $id = $_REQUEST["printer_id"] : $id = 0 ;

$pdo = new PDO(DSN, USER, PASS);		
$stmt = $pdo->query("SELECT * FROM prn_printer WHERE prn_id='" . $id . "'");

$a = $stmt->fetch();

include(INCLUDES_PATH . "/admin_header.php");
?>
<div style="width:400px">
  <form name="prn" method="post" action="save_printer.php">
    <input type="hidden" name="printer_id" value="<?php echo $id ?>">
    <table cellpadding="2" cellspacing="1" border="0" style="width:400px">
      <tr>
        <td colspan="2" class="header">Add/Edit Printer</td>
      </tr>
      <tr>
        <td class="altBgRowColor">Printer Name</td>
        <td class="altBgRowColor"><input name="prn_printer" type="text" class="textBox" value="<?php echo $a["prn_printer"] ?>" style="width:250px;" /></td>
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