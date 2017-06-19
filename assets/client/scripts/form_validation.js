	function check_delete(form_name,page,client) {		
		if (confirm("Delete " + client + "?")) {
			document.forms[form_name].action = page;
			document.forms[form_name].submit();
		}
	}
		
	function submit_form(aForm,aHref) {			
		var lForm = document.forms[aForm];		
		lForm.action = aHref
		lForm.submit();
		
	}
	
	function valid_option (aForm,aMin,aMax) {	
				
		var lMin = document.forms[aForm.name].elements[aMin.name].options;		
		var lMax = document.forms[aForm.name].elements[aMax.name].options;		
				
		for (var i = 0; i < lMin.length; i++) {		
			if (lMin[i].selected) {
				lMinValue = parseInt(lMin[i].value);
			}
		}	
		
		for (var i = 0; i < lMax.length; i++) {		
			if (lMax[i].selected) {
				lMaxValue = parseInt(lMax[i].value);
			}
		}	
		
		if (lMinValue >= lMaxValue) {
			alert("Maximum Salary value must be greater than Minimum Salary value");
			return false;
		}
		
		return true;
	}	
	
	function reset_select(aForm,aElement) {
			
		document.forms[aForm].elements[aElement].options.selectedIndex = 0;
	}
	
	function uncheck(aForm,aElement) {	
		
		document.forms[aForm].elements[aElement].checked = false;
	}

	function isFilled(elm) 
	{
		if(elm.value == "") 
		{
			return false;
		}
		return true;
	}
	
	function unitCost(form) 
	{
		var totalCost = cleanString(form.prq_totalcost);		
		var unitCost = parseFloat(totalCost) / parseFloat(form.prq_quantity.value);
		
		form.prq_unitcost.value = unitCost.toFixed(2);		
	}

	function cleanString(elm) 
	{
		var elm = (elm.value + "");
		var cleanString = "";
		for (var i = 0; i < elm.length; i++) {			
			if (elm.charAt(i) != "$" && elm.charAt(i) != "," && elm.charAt(i) != " ") 
			{				
				cleanString += elm.charAt(i);
			}
		}
		return cleanString;
	}
	
	function isPhone(aElement) {
		var lElement = (aElement.value + "");
		var lCleanstring = "";
		for (var i = 0; i < lElement.length; i++) {
			if (lElement.charAt(i) >= "0" && lElement.charAt(i) <= "9") {
				lCleanstring += lElement.charAt(i);
			}
		}
		if (lCleanstring.length != 10) {
			alert("Please enter your telephone number (include 2 digit prefix)");
			return false;
		}
		return true;
	}
	
	function isSelected(elm) 
	{
		if(elm.options[elm.options.selectedIndex].value == "")
		{
			return false;	
		}
		return true;
	}

	function isEmail(aElement) {				
		if (aElement.value.indexOf("@") == -1) {
			alert("Please fill out a valid email address"); 
			return false;
		}
		return true;
	}
		
	function isReady(form) {
		// is fullname element filled?
		var submitForm = true;		
		if (!isFilled(form.prq_quotenumber)) 
		{
			alert("Quote number must be entered!");		   
			submitForm = false;
			return false;
		}	
		
		if (!isFilled(form.prq_productname)) 
		{
			alert("Product name must be entered!");		   
			submitForm = false;
			return false;
		}

		if (!isSelected(form.prq_hostproduct)) 
		{
			 alert("Host product must be selected!");		   
			 submitForm = false;
			 return false;			   
		}		
		
		if (!isFilled(form.prq_quoterecieved)) 
		{
			alert("Quote recieved date must be entered!");		   
			submitForm = false;
			return false;
		}

		if (!isFilled(form.prq_totalpages)) 
		{
			alert("Total pages must be entered!");		   
			submitForm = false;
			return false;
		}
		
		if (isFilled(form.prq_coverpages)) 
		{
		  if(!isFilled(form.prq_covergsm)) 
		  {
			  //alert("Cover gsm must be entered!");		   
			  //submitForm = false;
			  //return false;  
		  }
		}
		
		if (!isFilled(form.prq_stockpages)) 
		{
			alert("Stock pages must be entered!");		   
			submitForm = false;
			return false;
		}

		if (!isFilled(form.prq_stockgsm)) 
		{
			alert("Stock GSM must be entered!");		   
			submitForm = false;
			return false;
		}

		if (!isFilled(form.prq_width)) 
		{
			alert("Width must be entered!");		   
			submitForm = false;
			return false;
		}
		
		if (!isFilled(form.prq_height)) 
		{
			alert("Height must be entered!");		   
			submitForm = false;
			return false;
		}
		
		if (!isSelected(form.prq_binding)) 
		{
			 alert("Binding must be selected!");		   
			 submitForm = false;
			 return false;
		}
		
		if (!isFilled(form.prq_quantity)) 
		{
			 alert("Quantity must be entered!");		   
			 submitForm = false;
			 return false;
		}		
		
		if (!isSelected(form.prq_printer)) 
		{
			 alert("Printer must be selected!");		   
			 submitForm = false;
			 return false;
		}

		if (!isFilled(form.prq_totalcost)) 
		{
			 alert("Total cost must be entered!");		   
			 submitForm = false;
			 return false;
		}

		if (!isFilled(form.prq_unitcost)) 
		{
			 alert("Unit cost must be entered!");		   
			 submitForm = false;
			 return false;
		}
	
		if(submitForm) 
		{
			form.submit();
		}		
		return true;
	}
	