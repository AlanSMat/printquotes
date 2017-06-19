<?php
require("../globals.php");

$page_title = "List Binding Styles";
$sub_title = "List Binding Styles";

include(INCLUDES_PATH . "/admin_header.php");

?>
<div style="width:375px">
  <table cellspacing="1" cellpadding="3" border="0"> 
    <tr>
        <td class="header">ID</td>
        <td class="header">Binding Style</td>      
        <td class="header">&nbsp;</td>
    </tr>
    <?php 
    $pdo = new PDO(DSN, USER, PASS);		
    $stmt = $pdo->query("SELECT * FROM bin_binding");
    
    $i = 0;
    while ($row = $stmt->fetchObject())
    {
      $i++;
      ?>	
      <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
        <td style="width:10px"><?php echo $row->bin_id ?></td>          
        <td style="width:300px"><?php echo $row->bin_binding ?></td>        
        <td style="width:75px; text-align:center;" align="center">
          <div class="editLink"><a href="edit_binding.php?binding_id=<?php echo $row->bin_id ?>&pageid=bindings">Edit</a></div>
          <div class="separator">|</div>
          <div class="editLink"><a href="delete_binding.php?binding_id=<?php echo $row->bin_id ?>">Delete</a></div>              
        </td>
      </tr>
      <?php
    }
    ?>
  </table>
	<div class="buttonSpacing"> 
	  <form name="opr_form" method="post" action="edit_binding.php?pageid=bindings" id="aspnetForm">
	    <input type="Submit" value="Add New" class="button" />
	  </form>
	</div>
</div>
<?php
include(INCLUDES_PATH . "/admin_footer.php");
?>