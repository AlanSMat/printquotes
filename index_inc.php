<?php
include(CLASSES_PATH . "/class.Page_list.php");
?>

<table cellpadding="2" cellspacing="1" border="0">      
  <tr>
    <td class="header" style="width:25px;">Ref</td>
    <td class="header" style="width:180px; text-align:center;">Product Name</td>
    <td class="header" style="width:30px; text-align:center;">Print</td>
    <td class="header" style="width:120px; text-align:center;">Host Product</td>
    <td class="header" style="width:60px; text-align:center;">Recieved</td>
    <td class="header" style="width:40px; text-align:center;">Total Pages</td>
    <td class="header" style="width:45px; text-align:center;">Height</td>
    <td class="header" style="width:45px; text-align:center;">Width</td>
    <td class="header" style="width:55px; text-align:center;">Quantity</td>
    <td class="header" style="width:40px; text-align:center;">Cover Pages</td>
    <td class="header" style="width:40px; text-align:center;">Cover GSM</td>
    <td class="header" style="width:40px; text-align:center;">Text Pages</td>
    <td class="header" style="width:40px; text-align:center;">Text GSM</td>    
    <td class="header" style="width:65px; text-align:center;">Total Cost</td>
    <td class="header" style="width:62px;">&nbsp;</td>
  </tr>
  <?php 
  $db_table     = "prq_printquotes";
  $max_results  = 25;
  $order_by     = "prq_quoterecieved";

  $page_list = new page_list($db_table, $max_results, $order_by);
          
  $i = 0;
  while($row = $page_list->page_query->next()) 
  {        
    $i++;
    
    $dd_text = new DD_text();
  ?>
    <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
    	<td><?php echo $row->prq_quotenumber ?></td>
    	<td style="width:180px;"><?php echo $row->prq_productname ?></td>
    	<td style="width:30px;text-align:center;"><?php echo substr(strtoupper($dd_text->printer($row->prq_printer)->prn_printer), 0, 3) ?></td>
    	<td style="width:120px;"><?php echo $dd_text->host_product($row->prq_hostproduct)->hos_hostproduct ?></td>
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
    	<td>
    	  <div class="editContainer">    		  
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
    <td colspan="14">&nbsp;</td>
  </tr>   
  <tr>
    <td colspan="14"><?php $page_list->build_page_numbers("pageid=" . $page_id . ""); ?></td>
  </tr>    
</table>
