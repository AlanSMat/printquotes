<?php
require("../globals.php");

$page_title = "List Printers";
$sub_title = "List Printers";

$pdo = new PDO(DSN, USER, PASS);

include(INCLUDES_PATH . "/admin_header.php");
?>
<div style="width:375px">
  <table cellspacing="1" cellpadding="3" border="0"> 
    <tr>
      <td class="header">Printer</td>      
      <td class="header">&nbsp;</td>
    </tr>
    <?php 
    $stmt = $pdo->query("SELECT * FROM prn_printer");
    
    $i = 0;
    while($row = $stmt->fetchObject())
    {
      $i++;
      ?>	
      <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
        <td style="width:300px">
        	<p style="width:25px;"><?php echo substr(strtoupper($row->prn_printer), 0, 3) ?></p>
        	<p style="width:8px;">:</p>
        	<p><?php echo $row->prn_printer ?></p>
        </td>        
        <td style="width:75px; text-align:center;" align="center">
          <div class="editLink"><a href="edit_printer.php?printer_id=<?php echo $row->prn_id ?>&pageid=printers">Edit</a></div>
          <div class="separator">|</div>
          <div class="editLink"><a href="delete_printer.php?printer_id=<?php echo $row->prn_id ?>">Delete</a></div>              
        </td>
      </tr>
      <?php
    }
    ?>
  </table>
	<div class="buttonSpacing"> 
	  <form name="opr_form" method="post" action="edit_printer.php?pageid=printers" id="aspnetForm">
	    <input type="Submit" value="Add New" class="button" />
	  </form>
	</div>
</div>
<?php
include(INCLUDES_PATH . "/admin_footer.php");
?>