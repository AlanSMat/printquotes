<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
require("globals.php");

$page_title = "Quote Form";
$sub_title = "Quote Form";

include(INCLUDES_PATH . "/admin_header.php");

include(CLASSES_PATH . "/class.Calendar.php");

isset($_REQUEST["quote_id"]) ? $quote_id = $_REQUEST["quote_id"] : $quote_id = 0;

$pdo = new PDO(DSN, USER, PASS);

$stmt = $pdo->query("SELECT * FROM prq_printquotes WHERE prq_id='" . $quote_id . "'");
$a = $stmt->fetch();

$_SESSION["quoteform"] = $a;

$_SESSION["quoteform"]["prq_quoterecieved"] == 0 ? $quote_date = "" : $quote_date = rt_date($_SESSION["quoteform"]["prq_quoterecieved"]) ;

$calendar = new Calendar();

//$pdo_t = new PDO(DSN, USER, PASS);

/*$stmt = $pdo->query("SELECT * FROM hos_hostproduct");
while($row = $stmt->fetchObject()) {
    echo $row->hos_hostproduct . '<br />';
}*/

?>
<script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/calc_pages.js"></script>
<div class = "form_container">
    <form method="post" action="save_quote.php" name="prq">  
        <input type="hidden" name="quote_id" value="<?php echo $quote_id ?>" />
        <input type="hidden" name="prq_logdate" value="<?php $_SESSION["quoteform"]["prq_logdate"] == "" ? print date("d M Y", strtotime("now")) : print "" ; ?>" />
        <div class="form_row">
          <div class="textSpacing">Quote Number *</div>
          <div style="float:left"><input id="focus" type="text" name="prq_quotenumber" value="<?php echo $_SESSION["quoteform"]["prq_quotenumber"] ?>" class="textBox" /></div>
        </div>
        <div class="form_row">
          <div class="textSpacing">Product Name *</div>
          <div style="float:left"><input type="text" name="prq_productname" size="40" value="<?php echo $_SESSION["quoteform"]["prq_productname"] ?>" class="textBox" /></div>
        </div>
        <div class="form_row">
          <div class="textSpacing">Host Product *</div>
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
        <div class="form_row">
          <div class="textSpacing">Quote Recieved *</div>
          <div style="float:left"><?php $calendar->input("prq_quoterecieved", $quote_date); ?></div>
          <div style="float:left; padding:1px 0px 0px 3px;"><?php $calendar->image(); ?></div>
        </div>
        <div class="form_row">
          <div class="textSpacing">Self Cover</div>
          <div style="float:left"><input type="checkbox" name="prq_selfcover" onclick="set_values(this.form, this)" <?php $_SESSION["quoteform"]["prq_selfcover"] == 0 ? print "" : print "checked=\"checked\"" ; ?> /></div>	
        </div>
        <div class="form_row">
          <div class="textSpacing">Page Count *</div>
          <div style="float:left"><input type="text" name="prq_totalpages" value="<?php echo $_SESSION["quoteform"]["prq_totalpages"] ?>" class="textBox" onblur="add_pages(this.form, this.form.prq_totalpages, this.form.prq_coverpages, this.form.prq_stockpages)" /></div>
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
          <div style="float:left"><input type="text" name="prq_covergsm" value="<?php echo $_SESSION["quoteform"]["prq_covergsm"] ?>" class="textBox" /></div>
        </div>
        <div class="form_row">
          <div class="textSpacing">Text Pages *</div>
          <div style="float:left"><input type="text" name="prq_stockpages" value="<?php echo $_SESSION["quoteform"]["prq_stockpages"] ?>" class="textBox" /></div>
        </div>
        <div class="form_row">
          <div class="textSpacing">Text Stock GSM *</div>
          <div style="float:left"><input type="text" name="prq_stockgsm" value="<?php echo $_SESSION["quoteform"]["prq_stockgsm"] ?>" class="textBox" /></div>
        </div>
        <div class="form_row">
          <div class="textSpacing">Height *</div>
          <div style="float:left"><input type="text" name="prq_height" value="<?php echo $_SESSION["quoteform"]["prq_height"] ?>" class="textBox" /> (in mm)</div>
        </div>
        <div class="form_row">
          <div class="textSpacing">Width *</div>
          <div style="float:left"><input type="text" name="prq_width" value="<?php echo $_SESSION["quoteform"]["prq_width"] ?>" class="textBox" /> (in mm)</div>
        </div>    
        <div class="form_row">
          <div class="textSpacing">Binding Style *</div>
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
          <div class="textSpacing">Print Quantity *</div>
          <div style="float:left"><input type="text" name="prq_quantity" value="<?php echo $_SESSION["quoteform"]["prq_quantity"] ?>" class="textBox" /></div>
        </div>
        <div class="form_row">
            <div class="textSpacing">Printer *</div>
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
          <div class="textSpacing">Total Cost *</div>
          <div style="float:left"><input type="text" name="prq_totalcost" value="<?php echo number_format($_SESSION["quoteform"]["prq_totalcost"],2) ?>" class="textBox" onblur="calc_unit_cost(this.form)" /></div>
        </div>
        <div class="form_row">
          <div class="textSpacing">Unit Cost *</div>
          <div style="float:left"><input type="text" name="prq_unitcost" value="<?php echo $_SESSION["quoteform"]["prq_unitcost"] ?>" class="textBox" /></div>
        </div>
        <div class="form_row">
          <div class="textSpacing">Comments</div>
          <div style="float:left">
            <textarea rows="6" cols="60" class="textBox" name="prq_comments"><?php echo $_SESSION["quoteform"]["prq_comments"] ?></textarea>
          </div>
        </div>
        <?php 
        if($quote_id != 0) 
        {
        ?>
            <div class="form_row">
                    <div class="textSpacing">New Quote</div>
            <div style="float:left;padding-top:3px;"><input type="checkbox" name="new" value="1"></div>
            </div>
        <?php 
        }
        ?>
        <div class="form_row">
            <div class="textSpacing">List for advertising view</div>
            <div style="float:left;padding-top:3px;"><input type="checkbox" name="prq_listholtst" value="1" <?php $_SESSION["quoteform"]["prq_listholtst"] == 0 ? print "" : print "checked=\"checked\"" ; ?> /></div>
        </div>
        <div class="form_row" style="padding-top:15px;">      
          <div style="float:left;padding-left:138px;"><input type="button" value="Save Quote" class="button" onclick="isReady(this.form)" /></div>
          <?php 
          if($quote_id != 0) 
          {
          ?>
            <div style="float:left;padding-left:10px;"><input type="button" value="Delete Quote" class="button" onclick="delete_item(this.form, 'delete_quote.php?quoteid=<?php echo $quote_id ?>', 'this Quote');" /></div>
          <?php 
          }
          ?>
        </div>
	</form>
	<script type="text/javascript">
            select_option("prq", "prq_hostproduct", "<?php echo $_SESSION["quoteform"]["prq_hostproduct"] ?>");
            select_option("prq", "prq_coverpages",  "<?php echo $_SESSION["quoteform"]["prq_coverpages"] ?>");
            select_option("prq", "prq_binding",     "<?php echo $_SESSION["quoteform"]["prq_binding"] ?>");
            select_option("prq", "prq_printer",     "<?php echo $_SESSION["quoteform"]["prq_printer"] ?>");
	</script>
</div>
<script type="text/javascript">
    set_values(document.forms["prq"], document.forms["prq"].elements["prq_selfcover"]);
    document.getElementById("focus").focus();
</script>
<?php
$calendar->init();
/*
if(isset($_SESSION["quoteform"]))
{
  session_unset($_SESSION["quoteform"]);  
}
*/
include(INCLUDES_PATH . "/admin_footer.php");
?>