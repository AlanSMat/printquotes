<?php
session_start();
require("globals.php");

$page_title = "Search Form";
$sub_title = "Search Form";

if($_SESSION["admin_user"]) 
{
    include(INCLUDES_PATH . "/admin_header.php");
}
else 
{
    include(INCLUDES_PATH . "/site_header.php");
}

include(CLASSES_PATH . "/class.Calendar.php");

isset($_REQUEST["quote_id"]) ? $quote_id = $_REQUEST["quote_id"] : $quote_id = 0;

$pdo = new PDO(DSN, USER, PASS);

$stmt = $pdo->query("SELECT * FROM prq_printquotes WHERE prq_id='" . $quote_id . "'");
$a = $stmt->fetch();

$_SESSION["searchform"] = $a;

if(!$_SESSION["searchform"]) {
    $_SESSION["searchform"]["prq_quotenumber"] = "";
    $_SESSION["searchform"]["prq_productname"] = "";
    $_SESSION["searchform"]["prq_fromdate"] = "";
    $_SESSION["searchform"]["prq_todate"] = "";
    $_SESSION["searchform"]["prq_totalpages"] = "";
    $_SESSION["searchform"]["prq_covergsm"] = "";
    $_SESSION["searchform"]["prq_selfcover"] = "";
    $_SESSION["searchform"]["prq_stockpages"] = "";
    $_SESSION["searchform"]["prq_stockgsm"] = "";
    $_SESSION["searchform"]["prq_height"] = "";
    $_SESSION["searchform"]["prq_width"] = "";
    $_SESSION["searchform"]["prq_frompagerange"] = "";
    $_SESSION["searchform"]["prq_topagerange"] = "";
    $_SESSION["searchform"]["prq_fromquantity"] = "";
    $_SESSION["searchform"]["prq_toquantity"] = "";
    $_SESSION["searchform"]["prq_fromcost"] = "";
    $_SESSION["searchform"]["prq_tocost"] = "";
    $_SESSION["searchform"]["prq_unitcost"] = "";
}

if(isset($_SESSION["search_results"])) 
{
    foreach($_SESSION["search_results"] as $key => $value) 
    {
        $_SESSION["searchform"][$key] = $value;
    }   
}

!isset($_SESSION["searchform"]["prq_quoterecieved"]) ? $quote_date = "" : $quote_date = rt_date($_SESSION["searchform"]["prq_quoterecieved"]) ;

$calendar = new Calendar();

?>
<script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/calc_pages.js"></script>
<div class = "form_container">
    <form method="post" action="search_results.php" name="prq">  
	<input type="hidden" name="quote_id" value="<?php echo $quote_id ?>" />
    <?php 
    if($_SESSION["admin_user"]) 
    {
    ?>
    <div class="form_row">
        <div class="textSpacing">Ref Number</div>
        <div style="float:left"><input type="text" id="focus" name="prq_quotenumber" value="<?php echo $_SESSION["searchform"]["prq_quotenumber"] ?>" class="textBox" /></div>
    </div>
    <div class="form_row">
        <div class="textSpacing">Product Name</div>
        <div style="float:left"><input type="text" name="prq_productname" size="40" value="<?php echo $_SESSION["searchform"]["prq_productname"] ?>" class="textBox" /></div>
    </div>
    <div class="form_row">
        <div class="textSpacing">Host Product</div>
        <div style="float:left">
            <select name="prq_hostproduct">
      		<option value=""> -- select host product -- </option>
      		<?php 
      		$stmt = $pdo->query("SELECT * FROM hos_hostproduct");
      		
      		while($row = $stmt->fetchObject()) 
      		{
      		?>
      			<option value="<?php echo $row->hos_id ?>"><?php echo $row->hos_hostproduct ?></option>
      		<?php
      		}
      		?>
            </select>
        </div>
      </div>
    <?php 
    }
    ?>
    <div class="form_row">
      <div class="textSpacing">Quote Recieved Date</div>
      <div style="float:left"><?php $calendar->input("prq_fromdate", $_SESSION["searchform"]["prq_fromdate"], "fc_from"); ?></div>
      <div style="float:left; padding:1px 10px 0px 3px;"><?php $calendar->image("f_trigger_from"); ?></div>
            <div style="float:left"><?php $calendar->input("prq_todate", $_SESSION["searchform"]["prq_todate"], "fc_to"); ?></div>
      <div style="float:left; padding:1px 0px 0px 3px;"><?php $calendar->image("f_trigger_to"); ?></div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Page Range</div>
      <div style="float:left;padding:3px 5px 0px 0px;">From</div>
      <div style="float:left"><input type="text" name="prq_frompagerange" size="5" value="<?php echo $_SESSION["searchform"]["prq_frompagerange"] ?>" class="textBox" onkeyup="this.form.prq_coverpages.value='';this.form.prq_stockpages.value=''" onblur="copy_value(this, 'to_page')" /></div>
      <div style="float:left;padding:3px 5px 0px 10px;">To</div>
      <div style="float:left"><input type="text" id="to_page" name="prq_topagerange" size="5" value="<?php echo $_SESSION["searchform"]["prq_topagerange"] ?>" class="textBox" onkeyup="this.form.prq_coverpages.value='';this.form.prq_stockpages.value=''" /></div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Self Cover</div>
      <div style="float:left;"><input type="checkbox" name="prq_selfcover" onclick="set_values(this.form, this)" <?php $_SESSION["searchform"]["prq_selfcover"] == 0 ? print "" : print "checked=\"checked\"" ; ?>/></div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Page Count</div>
      <div style="float:left"><input type="text" name="prq_totalpages" value="<?php echo $_SESSION["searchform"]["prq_totalpages"] ?>" class="textBox" onblur="add_pages(this.form, this.form.prq_totalpages, this.form.prq_coverpages, this.form.prq_stockpages)" /></div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Cover Pages</div>
      <div style="float:left">
      	<select name="prq_coverpages" id="prq_coverpages" onChange="calc_pages(this.form)">
      		<option value="0"> -- cover pages -- </option>
      		<option value="4">4</option>
      		<option value="6">6</option>
      		<option value="8">8</option>
      	</select>      	
      </div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Cover Stock GSM</div>
      <div style="float:left"><input type="text" name="prq_covergsm" value="<?php echo $_SESSION["searchform"]["prq_covergsm"] ?>" class="textBox" /></div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Text Pages</div>
      <div style="float:left"><input type="text" name="prq_stockpages" value="<?php echo $_SESSION["searchform"]["prq_stockpages"] ?>" class="textBox" /></div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Text Stock GSM</div>
      <div style="float:left"><input type="text" name="prq_stockgsm" value="<?php echo $_SESSION["searchform"]["prq_stockgsm"] ?>" class="textBox" /></div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Height</div>
      <div style="float:left"><input type="text" name="prq_height" value="<?php echo $_SESSION["searchform"]["prq_height"] ?>" class="textBox" /></div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Width</div>
      <div style="float:left"><input type="text" name="prq_width" value="<?php echo $_SESSION["searchform"]["prq_width"] ?>" class="textBox" /></div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Binding Style</div>
      <div style="float:left">
      	<select name="prq_binding">
      		<option value=""> -- select binding -- </option>
      		<?php 
      		$stmt = $pdo->query("SELECT * FROM bin_binding");
      		
      		while($row = $stmt->fetchObject()) 
      		{
      		?>
      			<option value="<?php echo $row->bin_id ?>"><?php echo $row->bin_binding ?></option>
      		<?php
      		}
      		?>
      	</select>
      </div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Print Quantity</div>
      <div style="float:left;padding:3px 5px 0px 0px;">From</div>
      <div style="float:left"><input type="text" name="prq_fromquantity" size="15" value="<?php echo $_SESSION["searchform"]["prq_fromquantity"] ?>" class="textBox" onblur="copy_value(this, 'to_quantity')" /></div>
      <div style="float:left;padding:3px 5px 0px 10px;">To</div>
      <div style="float:left"><input type="text" id="to_quantity" name="prq_toquantity" size="15" value="<?php echo $_SESSION["searchform"]["prq_toquantity"] ?>" class="textBox" /></div>
    </div>
    <div class="form_row">
    	<div class="textSpacing">Printer</div>
      <div style="float:left">
				<select name="prq_printer">
      		<option value=""> -- select printer -- </option>
      		<?php 
      		$stmt = $pdo->query("SELECT * FROM prn_printer");
      		
      		while($row = $stmt->fetchObject()) 
      		{
      		?>
      			<option value="<?php echo $row->prn_id ?>"><?php echo $row->prn_printer ?></option>
      		<?php
      		}
      		?>
      	</select>
      </div>
    </div>
    <div class="form_row">
      <div class="textSpacing">Total Cost</div>
      <div style="float:left;padding:3px 5px 0px 0px;">From</div>
    	<div style="float:left;padding:0px 10px 0px 0px;"><input type="text" size="15" name="prq_fromcost" value="<?php echo $_SESSION["searchform"]["prq_fromcost"] ?>" class="textBox" onblur="cleanstring(this);copy_value(this, 'to_cost');" /></div>	
    	<div style="float:left;padding:3px 5px 0px 0px;">To</div>
    	<div style="float:left"><input type="text" size="15" id="to_cost" name="prq_tocost" value="<?php echo $_SESSION["searchform"]["prq_tocost"] ?>" class="textBox" onblur="cleanstring(this)" /></div>
    </div>    
    <div class="form_row">
      <div class="textSpacing">Unit Cost</div>
      <div style="float:left"><input type="text" name="prq_unitcost" value="<?php echo $_SESSION["searchform"]["prq_unitcost"] ?>" class="textBox" /></div>
    </div>
    <div class="form_row" style="padding-top:15px;">
      <div style="float:left;padding-left:138px;"><input type="button" value="Reset" class="button" onclick="document.location='<?php echo ROOT_URL . "/search.php?pageid=search"?>'" /></div>
      <div style="float:left;padding-left:10px;"><input type="submit" value="Search" class="button" /></div>
    </div>
    </form>
	<script type="text/javascript">	  
        //** re-populate selects
        <?php
            if($_SESSION["admin_user"]) 
            { 
            ?>
                select_option("prq", "prq_hostproduct", "<?php isset($_SESSION["searchform"]["prq_hostproduct"]) ? print $_SESSION["searchform"]["prq_hostproduct"] : print '' ; ?>");
            <?php 
            }
            ?>
            select_option("prq", "prq_coverpages", "<?php isset($_SESSION["searchform"]["prq_coverpages"]) ? print $_SESSION["searchform"]["prq_coverpages"] : print '' ;?>");
            select_option("prq", "prq_binding",    "<?php isset($_SESSION["searchform"]["prq_binding"])    ? print $_SESSION["searchform"]["prq_binding"]    : print '' ?>");
            select_option("prq", "prq_printer",    "<?php isset($_SESSION["searchform"]["prq_printer"])    ? print $_SESSION["searchform"]["prq_printer"]    : print '' ?>");

            set_values(document.forms["prq"], document.forms["prq"].elements["prq_selfcover"]);
        </script>
</div>
<?php
$calendar->init("fc_from", "f_trigger_from");
$calendar->init("fc_to", "f_trigger_to");

unset($_SESSION["searchform"]);
unset($_SESSION["search_results"]);

if($_SESSION["admin_user"])  
{
  include(INCLUDES_PATH . "/admin_footer.php");
}
else 
{
  include(INCLUDES_PATH . "/site_footer.php");
}
?>