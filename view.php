<?php
session_start();
require("globals.php");

$page_title = "View Quote";
$sub_title = "View Quote";

$pdo = new PDO(DSN, USER, PASS);

$_REQUEST['quote_id'] = '409';

$stmt = $pdo->query("SELECT * FROM prq_printquotes WHERE prq_id='" . $_REQUEST['quote_id'] . "'");
$row = $stmt->fetchObject();

echo $row->fetchObject();
exit;

include(CLASSES_PATH . "/class.DD_text.php");

$dd_text = new DD_text();

if($_SESSION["admin_user"]) 
{
    include(INCLUDES_PATH . "/admin_header.php");
}
else 
{
  include(INCLUDES_PATH . "/site_header.php");
}

?>
  <table cellpadding="2" cellspacing="1" border="0">
    <tr>
      <td class="viewCell1">Quote Number</td>
      <td class="viewCell2"><?php echo $row->prq_quotenumber ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Product Name</td>
      <td class="viewCell2"><?php echo $row->prq_productname ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Host Product</td>
      <td class="viewCell2"><?php echo $dd_text->host_product($row->prq_hostproduct)->hos_hostproduct ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Quote Recieved</td>
      <td class="viewCell2"><?php echo rt_date($row->prq_quoterecieved) ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Total Pages</td>
      <td class="viewCell2"><?php echo $row->prq_totalpages ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Cover Pages</td>
      <td class="viewCell2"><?php echo $row->prq_coverpages ?></td>
    </tr>  
    <tr>
      <td class="viewCell1">Cover Stock GSM</td>
      <td class="viewCell2"><?php echo $row->prq_coverpages ?></td>
    </tr>  
    <tr>
      <td class="viewCell1">Text Pages</td>
      <td class="viewCell2"><?php echo $row->prq_stockpages ?></td>
    </tr>  
    <tr>
      <td class="viewCell1">Text Stock GSM</td>
      <td class="viewCell2"><?php echo $row->prq_stockgsm ?></td>
    </tr> 

    <tr>
      <td class="viewCell1">Width</td>
      <td class="viewCell2"><?php echo $row->prq_width ?></td>
    </tr> 
    <tr>
      <td class="viewCell1">Height</td>
      <td class="viewCell2"><?php echo $row->prq_height ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Binding</td>
      <td class="viewCell2"><?php echo $dd_text->binding($row->prq_binding)->bin_binding ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Quantity</td>
      <td class="viewCell2"><?php echo $row->prq_quantity ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Printer</td>
      <td class="viewCell2"><?php echo $dd_text->printer($row->prq_printer, false) ?></td>
    </tr> 
    <tr>
      <td class="viewCell1">Total Cost</td>
      <td class="viewCell2">$<?php echo number_format($row->prq_totalcost, 2) ?></td>
    </tr> 
    <tr>
      <td class="viewCell1">Unit Cost</td>
      <td class="viewCell2"><?php echo $row->prq_unitcost ?></td>
    </tr>     
    <tr>
      <td class="viewCell1" valign="top">Comments</td>
      <td class="viewCell2"><?php echo nl2br($row->prq_comments) ?></td>
    </tr>            
    <tr>
      <td colspan="2" align="center">
        <form name="qc" method="post">
          <div style="text-align:center;padding:10px 55px 0px 0px" class="noprint">
            <input type="button" class="button" value="Print Page" onclick="javascript:window.print();" />
          </div>
        </form>
      </td>
    </tr>      
  </table>   
<?php
if($_SESSION["admin_user"]) 
{
  include(INCLUDES_PATH . "/admin_footer.php");
}
else 
{
  include(INCLUDES_PATH . "/site_footer.php");
}
?>