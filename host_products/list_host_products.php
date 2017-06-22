<?php
require("../globals.php");

$page_title = "List Host Products";
$sub_title = "List Host Products";

include(INCLUDES_PATH . "/admin_header.php");
?>
<div class="editListContainer">
    <table cellspacing="1" cellpadding="3" border="0"> 
        <tr>
            <td class="header">Host Products</td>      
            <td class="header">&nbsp;</td>
        </tr>
        <?php 
        $pdo = new PDO(DSN, USER, PASS);
        $stmt = $pdo->query("SELECT * FROM hos_hostproduct");

        $i = 0;
        
        while($row = $stmt->fetchObject()) 
        {
            $i++;
            ?>	
            <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
                <td  class="editLineSpacing"><?php echo $row->hos_hostproduct ?></td>        
                <td width="100">
                    <div class="editLinkContainer" xstyle="border:1px solid #000;"> 
                        <div class="editLink"><a href="edit_host_product.php?host_product_id=<?php echo $row->hos_id ?>&pageid=host_products">Edit</a></div>
                        <div class="separator">|</div>
                        <div class="editLink"><a href="delete_host_product.php?host_product_id=<?php echo $row->hos_id ?>">Delete</a></div>              
                    </div>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <div class="buttonSpacing"> 
        <form name="hos_form" method="post" action="edit_host_product.php?pageid=host_product" id="aspnetForm">
            <input type="Submit" value="Add New" class="button" />
        </form>
    </div>
</div>
<?php
include(INCLUDES_PATH . "/admin_footer.php");
?>