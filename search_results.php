<?php
session_start();
require("globals.php");
include(CLASSES_PATH . "/class.DD_text.php");
include(CLASSES_PATH . "/class.Search.php");

$page_title = "Search Results";
$sub_title = "Search Results";

if(isset($_POST["prq_quoterecieved"])) 
{
  $_POST["prq_quoterecieved"] = strtotime($_POST["prq_quoterecieved"]);
} 

!isset($_POST["prq_selfcover"]) ? $_POST["prq_selfcover"] = 0 : $_POST["prq_selfcover"] = 1;

if(isset($_POST["prq_coverpages"])) 
{
  $_POST["prq_coverpages"] == 0 ? $_POST["prq_coverpages"] = "" : $_POST["prq_coverpages"] = $_POST["prq_coverpages"]  ;
}

if(isset($_SESSION["search_results"])) 
{
  $_POST = $_SESSION["search_results"];
}

$page_title = "Search Results";

$search_table = "prq_printquotes";
$post_vars = $_POST;
$order_by = "prq_quotenumber";
$max_results = "20";
$_SESSION["admin_user"] ? $admin_user = 1 : $admin_user = 0;

$search = new Search($search_table, $post_vars, $order_by, $max_results, $admin_user);

//** copy the search variables into the session so that they can be used for form re-population
$_SESSION["search_results"] = $search->filtered_vars;

if($_SESSION["admin_user"]) 
{
    include(INCLUDES_PATH . "/admin_header.php");
}
else 
{
    include(INCLUDES_PATH . "/site_header.php");
}

?>
	<script type="text/javascript">

	function go_back(form) 
	{
            form.action = "http://<?php echo $_SERVER["SERVER_NAME"] ?>/printquotes/search.php?pageid=search&repop=1";
            form.submit();
	}
	</script>
    <table cellpadding="2" cellspacing="1" border="0">      
      <tr>
        <td class="header" style="width:25px;">Ref</td>
        <td class="header" style="width:160px; text-align:center;">Product Name</td>
        <td class="header" style="width:30px; text-align:center;">PRN</td>
        <?php 
        if($_SESSION["admin_user"]) 
        {
        ?>
            <td class="header" style="width:130px; text-align:center;">Binding Style</td>
        <?php
        }
        else 
        { 
        ?>
            <td class="header" style="width:130px; text-align:center;">Host Product</td>
        <?php
        }
        ?>
        <td class="header" style="width:60px; text-align:center;">Recieved</td>
        <td class="header" style="width:40px; text-align:center;">Total Pages</td>
        <td class="header" style="width:45px; text-align:center;">Height</td>
        <td class="header" style="width:45px; text-align:center;">Width</td>
        <td class="header" style="width:55px; text-align:center;">Quantity</td>
        <td class="header" style="width:40px; text-align:center;">Cover Pages</td>
        <td class="header" style="width:40px; text-align:center;">Cover GSM</td>
        <td class="header" style="width:40px; text-align:center;">Text Pages</td>
        <td class="header" style="width:40px; text-align:center;">Text GSM</td>    
        <td class="header" style="width:70px; text-align:center;">Total Cost</td>
        <td class="header" style="width:70px;">&nbsp;</td>
      </tr>
      <?php

      $stmt = $search->search_results();
			
      $i = 0;
      while($row = $stmt->fetchObject()) 
      {
        
      $i++;
    
      $dd_text = new DD_text();
      ?>
        <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
        	<td><?php echo $row->prq_quotenumber ?></td>
        	<td style="width:160px;"><?php echo $row->prq_productname ?></td>
        	<td style="width:30px;text-align:center"><?php echo $dd_text->printer($row->prq_printer) ?></td>
          <?php 
          if($_SESSION["admin_user"]) 
          {
          ?>
          	<td style="width:130px;"><?php echo $dd_text->binding($row->prq_binding)->bin_binding ?></td>
          <?php
          }
          else 
          { 
          ?>
        		<td style="width:130px;"><?php echo $dd_text->host_product($row->prq_hostproduct)->hos_hostproduct ?></td>
        	<?php 
          }
        	?>
        	<td style="text-align:center;"><?php echo date("d/m/y", $row->prq_quoterecieved) ?></td>    	
        	<td style="text-align:center;"><?php echo $row->prq_totalpages; ?></td>
        	<td style="text-align:center;"><?php echo $row->prq_height; ?></td>
        	<td style="text-align:center;"><?php echo $row->prq_width; ?></td>
        	<td style="text-align:center;"><?php echo $row->prq_quantity; ?></td>
        	<td style="text-align:center;"><?php echo $row->prq_coverpages; ?></td>
        	<td style="text-align:center;"><?php echo $row->prq_covergsm; ?></td>
        	<td style="text-align:center;"><?php echo $row->prq_stockpages; ?></td>
        	<td style="text-align:center;"><?php echo $row->prq_stockgsm; ?></td>
        	<td>$<?php echo $row->prq_totalcost ?></td>  
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
                	<div class="editLink"><a href="view.php?quote_id=<?php echo $row->prq_id ?>&ut=ord">View</a></div>
                <?php 
          	  }
              ?>
            </div>
        	</td>
        </tr>
      <?php 
      }
      if($i == 0) 
      {
        ?>
        <tr>
          <td colspan="13" style="text-align:center;">No Search Results Found</td>
        </tr>
        <?php 
      }
      else 
      {
        ?>
        <tr>
          <td colspan="13" style="text-align:center;">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="13" style="text-align:center;"><?php echo $search->build_page_numbers() ?></td>
        </tr>        
        <?php 
      }
      ?>
      <tr>
        <td colspan="13" align="center">
          <form name="qc" method="post">
            <div style="text-align:center;padding:10px 0px 0px 0px" class="noprint">
              <div style="float:left;"><input type="button" value="Back To Search Form" class="button" onclick="javascript:go_back(this.form)" /></div>
              <div style="float:left;padding-left:10px;"><input type="button" class="button" value="Print Page" onclick="javascript:window.print();" /></div>
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