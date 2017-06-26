<?php
include(CLASSES_PATH . "/class.Page_list.php");
$pdo = new PDO(DSN, USER, PASS);
?>
<table cellpadding="5" cellspacing="1" border="0">      
  <tr>
    <td class="header" style="width:45px;">Ref</td>
    <td class="header" style="width:120px; text-align:center;">Host Product</td>
    <td width="180" align="center">Product Name</td>
    <td class="header" style="width:40px; text-align:center;">PRN</td>
    <td class="header" style="width:70px; text-align:center;">Recieved</td>
    <td class="header" style="width:40px; text-align:center;">Total Pages</td>
    <td class="header" style="width:45px; text-align:center;">Height</td>
    <td class="header" style="width:45px; text-align:center;">Width</td>
    <td class="header" style="width:55px; text-align:center;">Quantity</td>
    <td class="header" style="width:40px; text-align:center;">Cover Pages</td>
    <td class="header" style="width:40px; text-align:center;">Cover GSM</td>
    <td class="header" style="width:40px; text-align:center;">Text Pages</td>
    <td class="header" style="width:40px; text-align:center;">Text GSM</td>    
    <td class="header" style="width:65px; text-align:center;">Total Cost</td>
    <td class="header" style="width:65px; text-align:center;">Cost per copy</td>
    <td class="header" style="width:100px;">&nbsp;</td>
  </tr>
  <?php 
  $db_table     = "prq_printquotes";
  $max_results  = 20;
  $order_by     = "prq_quotenumber";
  
  if(!$_SESSION["admin_user"]) 
  {
    $where_clause = "prq_listholtst='1'";
  }
  else 
  {
    $where_clause = '1';
  }

  $page_list = new page_list($db_table, $max_results, $order_by, $where_clause);

  $i = 0;
  while($row = $page_list->page_query->fetchObject()) 
  {        
    $i++;
    
    $dd_text = new DD_text();
  ?>
    <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
    	<td><?php echo $row->prq_quotenumber ?></td>
        <td><?php echo $dd_text->host_product($row->prq_hostproduct)->hos_hostproduct ?></td>
    	<td><?php echo $row->prq_productname ?></td>
    	<td class="lineSpacing"><?php echo $dd_text->printer($row->prq_printer) ?></td>
    	<td style="text-align:center;"><?php echo date("d/m/y", $row->prq_quoterecieved) ?></td>    	
    	<td style="text-align:center;"><?php echo $row->prq_totalpages; ?></td>
    	<td style="text-align:center;"><?php echo $row->prq_height; ?></td>
    	<td style="text-align:center;"><?php echo $row->prq_width; ?></td>
    	<td style="text-align:center;"><?php echo $row->prq_quantity; ?></td>
    	<td style="text-align:center;"><?php echo $row->prq_coverpages; ?></td>
    	<td style="text-align:center;"><?php echo $row->prq_covergsm; ?></td>
    	<td style="text-align:center;"><?php echo $row->prq_stockpages; ?></td>
    	<td style="text-align:center;"><?php echo $row->prq_stockgsm; ?></td>
    	<td style="padding-left: 8px;">$<?php echo $row->prq_totalcost ?></td>
        <td style="text-align:center;"><?php echo number_format($row->prq_totalcost / $row->prq_quantity,2,'.','');  ?></td>
    	<td>
    	    <div class="listAllLinkContainer">    		  
    	    <?php
    	    if($_SESSION["admin_user"]) 
    	    { 
    	    ?>
    	  	<div class="editLink"><a href="view.php?quote_id=<?php echo $row->prq_id ?>&ut=admin">View</a></div>
          	<div class="separator">|</div>
          	<div class="editLink"><a href="quote_form.php?quote_id=<?php echo $row->prq_id ?>&pageid=quote_form">Edit</a></div>
            <?php 
    	    }
    	    else 
    	    {
            ?>
          	<div class="editLink"><a href="view.php?quote_id=<?php echo $row->prq_id ?>">View</a></div>
             <?php 
    	  }
        ?>
        </div>
    	</td>
    </tr>
  <?php 
  }
  ?>
  <tr>
    <td colspan="16">&nbsp;</td>
  </tr>   
  <tr>
    <td colspan="16"><?php $page_list->build_page_numbers("pageid=" . $page_id . ""); ?></td>
  </tr>    
</table>
