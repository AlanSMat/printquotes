  	function calc_unit_cost(form) 
  	{
            var total_cost = cleanString(form.prq_totalcost) 		
            var unit_cost = parseInt(total_cost) / parseInt(form.prq_quantity.value)
            form.prq_unitcost.value = unit_cost.toPrecision(2);		 
            form.prq_totalcost.value = total_cost;
	}


	function add_pages(form, elm_total_pages, elm_cover_pages, elm_stock_pages) 
	{
            if(elm_cover_pages.value == "" && elm_total_pages != "") 
            {
                elm_stock_pages.value = elm_total_pages.value;
            }
            else 
            {
                if(elm_total_pages.value != "") 
                {
                    elm_stock_pages.value = parseInt(elm_total_pages.value);
                }
            }
	}
	
	function calc_pages(form) 
	{
            if(form.prq_totalpages.value != "") 
            {
                var cover_pages_value = form.prq_coverpages.options[form.prq_coverpages.options.selectedIndex].value;	  
                form.prq_totalpages.value = parseInt(form.prq_totalpages.value) + parseInt(cover_pages_value);
            }
	}
	
	function set_values(form, elm) 
	{		  
            if(elm.checked == false) 
            {
                form.prq_coverpages.disabled = false;
                form.prq_covergsm.disabled = false;
                form.prq_coverpages.style.backgroundColor = "#E7EFF7";
                form.prq_covergsm.style.backgroundColor = "#E7EFF7";      
                form.prq_coverpages.focus();
            }
            else 
            {
                form.prq_coverpages.disabled = true;
                form.prq_covergsm.disabled = true;
                form.prq_coverpages.style.backgroundColor = "#ccc";
                form.prq_covergsm.style.backgroundColor = "#ccc";
                form.prq_coverpages.selectedIndex = 0;
                form.prq_covergsm.value = "";
                form.prq_stockpages.value = form.prq_totalpages.value;
                form.prq_totalpages.focus();
            }    
	}