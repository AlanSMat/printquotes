<?php
if(!isset($sub_title)) 
{
  $sub_title = "&nbsp;";
}

if(isset($_REQUEST['pageid'])) 
{
  $page_id = $_REQUEST["pageid"];
}
else if($page_title == "Index") 
{
  $page_id = "default";
}
else 
{
  $page_id = "";
}

$_SESSION["admin_user"] = 0;

?>
<html>
<head>
  <title><?php isset($page_title) ? print $page_title : print "Untitled" ; ?></title>
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <style type="text/css">
	  #<?php echo $page_id ?> {
		  float:left;
		  padding:2px 0px 2px 0px;
		  width:120px;
		  text-align:center;
		  background-color:#ccc;
		  color:#000;
		  cursor:pointer;
		  border: 1px solid #ccc;
		  xborder-right:0px;			
	  }
		
	  a.remake {
		  color:#0000ff;
		  text-decoration:underline;
		  padding-left:10px;
	  }
	  
    .gradbg 
    {
      background-image:url('images/topgrad.gif');
    }
	  
  </style>
  <script language="JavaScript" type="text/javascript">
	  function printpage() {
		  window.print();  
	  }
		
	  function refresh_page() {
		  document.location = document.location;
	  }
	  
	  function windowNew(url, width, height) 
	  {
	    if(!width)
	      width = 600;
	    if(!height)
	      height = 500;
	    var left = (screen.width / 2) - (width / 2);
	    var top = (screen.height / 2) - (height / 2);
	    link = window.open(url,"Link","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=1,width=" + width + ",height=" + height + ",left=" + left + ",top=" + top + ""); 
	  }
		
  </script>    
  <script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/common.js"></script>
  <script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/form_validation.js"></script>
  <script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/default.css"  media="screen" />
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/print.css" media="print" />    
  <style type="text/css">
    .bannerbg { background-image: url(<?php echo IMAGES_URL ?>/header-bg.png) }
  </style>
</head>
<body style="background-image:url(<?php echo IMAGES_URL ?>/sydney_1.jpg); background-repeat:no-repeat; background-attachment:fixed; background-position: 50% 100%; background-size: cover;">
    <div class="mainPageWidthAndHeight" align="center">   
        <div class="noprint">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="bannerbg">
                <tr>
                    <td>
                        <div style="float:left;"><img src="<?php echo IMAGES_URL ?>/header-left.png" alt="" /></div>
                        <div style="float:right;"><img src="<?php echo IMAGES_URL ?>/header-right.png" alt="" /></div>
                    </td>
                </tr>    		  
            </table>
            <div class="navTopContainer">		     
                <div class="navItemTop" id="default" style="float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<?php echo ROOT_URL ?>/index.php?pageid=default'">Home</div>		  	      
                <div class="navItemTop" id="list_all" style="float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<?php echo ROOT_URL ?>/list_all.php?pageid=list_all'">List All</div>
                <div class="navItemTop" id="search" style="border-right:1px outset #ccc;float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<?php echo ROOT_URL ?>/search.php?pageid=search&ut=ord'">Search</div>
                <div class="clear">&nbsp;</div>
            </div><!-- end navTopContainer -->
	</div><!-- end noprint -->   
	<div class="pageTitleContainer">
            <div class="pageTitle">
                <div class="pageTitleSpacing">&nbsp;</div>	      
            </div>
        </div> 
        <div class="topSpacing"></div>