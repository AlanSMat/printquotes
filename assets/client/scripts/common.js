
/*	function select_option(form, optionName, selected) 
	{
		form.elements[optionName]  	
	}*/

function select_option (aForm,aElm,aOpValue) {
	var lOption = document.forms[aForm].elements[aElm].options;
	
	for (var i = 0; i < lOption.length; i++) {
		if (lOption[i].value == aOpValue) {
			lOption[i].selected = true;
		}
	}	
}

function submit_form(form, page) 
{
  form.action = page;
  form.submit();
}

function delete_item(form, page, item) 
{
  if(confirm("Are you sure you wish to delete " + item + "?")) 
  {
    form.action = page;
    form.submit();
  }
}

function open_window(aPage,aWidth,aHeight,aLeft,aTop) {		
	if (!aWidth)
		aWidth = 480;
	if (!aHeight)
		height = 350; 
	if (!aLeft)
		aLeft = 400;
	if (!aTop)
		aTop = 200; 
		
	OpenWin = window.open(aPage, "window", "toolbar=no,menubar=no,location=no,scrollbars=no,resizable=no,width=" + aWidth + ",height=" + aHeight + ",left=" + aLeft + ",top=" + aTop + "");
}


/*function strip_chars(total_cost) 
{
  total_cost = total_cost + "";
  var cleanstring = "";
	for (var i = 0; i < total_cost.length; i++) {			
		if (total_cost.charAt(i) != ",") {				
			cleanstring += total_cost.charAt(i);
		}
	}		
	return cleanstring;
}*/