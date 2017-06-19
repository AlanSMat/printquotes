<?php
class Search {  
  
	public function __construct( $table = "", $post_vars = "", $order_by = "", $max_results = "", $admin_user ) 
	{		
            $this->error_check($table);		
            $this->error_check($post_vars);		
            $this->dd_text       = new DD_text();
            $this->admin_user    = $admin_user;
            $this->table         = $table;
            $this->post_vars     = $post_vars;
            $this->prefix        = substr_replace($this->table, "" , 3);
            $this->order_by      = $order_by;		
            $this->max_results   = $max_results;
            $this->filtered_vars = $this->filter_vars();		
            $this->where_clause  = $this->where_clause();
	}

	private function error_check($var) 
	{
            if($var == "") {			
                echo "ERROR: missing argument";					
                exit;
            }	
	}
	
        //** get all the post variables with the prq prefix that have been selected from the form
	private function filter_vars() {
            $table_data = '';
            foreach($this->post_vars as $key => $value) {                
                if (strpos($key, $this->prefix) > -1) {
                    if($value != "") {    						
                        $table_data[$key] = $value;						
                    }			
                }				
            }
            return $table_data;
	}

	private function get_page_limit() 
	{		
            // If current page number, use it
            // if not, set one.		
            if(!isset($_GET['page'])){
                $this->page = 1;
            } else {
                $this->page = $_GET['page'];
            }

            // Figure out the limit for the query based
            // on the current page number.
            $from = (($this->page * $this->max_results) - $this->max_results);

            $limit = "LIMIT " . $from . ", " . $this->max_results . "";

            return $limit;
	}

	private function str_range($from, $to, $db_col, $key, $value, $type) 
	{
            $str_range = "";
            
            //** strpos($haystack, $needle)
	    if(strpos($key, $from) > -1) 
	    {
	        $str_range = "" . $type . " " . $db_col . " >= '" . $value . "' ";
	    }
	    else if(strpos($key, $to) > -1)
	    {
	        $str_range = "" . $type . " " . $db_col . " <= '" . $value . "' ";
	    }	
	    else if((strpos($key, $from) > -1) && (strpos($key, $to) > -1))
	    { 
	        $str_range = "" . $type . " " . $db_col . " >= '" . $value . "' " . $db_col . " <= '" . $value . "' ";
	    }
	  
	    return $str_range;
	}
	
	private function where_clause_string($key, $value, $type) 
	{
            switch($key) 
            {
                case (strpos($key,"date") > 0) :
                    $where_clause = $this->str_range("fromdate", "todate", "prq_quoterecieved", $key, strtotime($value), $type);
                    break;

                case (strpos($key,"pagerange") > -1) :
                    $where_clause = $this->str_range("frompagerange", "topagerange", "prq_totalpages", $key, $value, $type);
                    break;

                case (strpos($key,"quantity") > -1) :    
                    $where_clause = $this->str_range("fromquantity", "toquantity", "prq_quantity", $key, $value, $type);
                    break;

                case (strpos($key,"cost") > -1) :    
                    $where_clause = $this->str_range("fromcost", "tocost", "prq_totalcost", $key, $value, $type);
                    break;
                
                case (strpos($key,"hostproduct") > -1) || (strpos($key,"binding") > -1) || (strpos($key,"printer") > -1) || (strpos($key,"cover") > -1) :    
                    $where_clause = "" . $type . " " . $key . " = '" . $value . "' "; 
                    break;
                
                default :
                    $where_clause = "" . $type . " " . $key . " LIKE '%" . $value . "%' "; 
                    break;
            }
	    return $where_clause;
	}
	
	private function where_clause() 
	{
            $i = 1;
            $where_clause = "";
            
            if(count($this->filtered_vars) > 0 && $this->filtered_vars != '') 
            {	
                foreach( $this->filtered_vars as $key => $value ) 
                { 
                    if( $i == 1 ) 
                    {
                        $where_clause .= $this->where_clause_string($key, $value, "WHERE");
                    } 
                    elseif( $i > 1) 
                    {
                        $where_clause .= $this->where_clause_string($key, $value, " AND");		
                    }

                  $i++;
                } 

                if($this->admin_user == 0) 
                {
                    $where_clause .= "AND prq_listholtst='1'";
                }
            }
            else if($this->admin_user == 0) 
            {
                $where_clause .= "WHERE prq_listholtst='1'";
            }
            
            return $where_clause;	
	}
	
	private function limit_clause() 
	{
	  $limit_clause = "";
		if($this->order_by != "") 
		{
			$limit_clause .= "ORDER BY " . $this->order_by . " DESC ";
		}
	
		if($this->max_results != "") {
			$limit_clause .= $this->get_page_limit();
		}
		return $limit_clause;
	}
	
	public function search_results() 
	{
            
            $pdo = new PDO(DSN, USER, PASS);
	    $select_string = "SELECT * FROM " . $this->table . " " . $this->where_clause() . " " . $this->limit_clause() . "";	  
            
	    $stmt = $pdo->query($select_string);
            
	    return $stmt;	
	}
	
	function expired_date() 
	{	
            return $expired_date = strtotime('last month');	
	}
	
        public function build_page_numbers($a_args = "", $type = "normal") 
        {
            
            $pdo = new PDO(DSN, USER, PASS);	
            $stmt = $pdo->query("SELECT * FROM " . $this->table . " " . $this->where_clause() . "");
            // Figure out the total number of results in DB:

            $total_results = 0;

            while($row = $stmt->fetch()) {
                $total_results++;
            }

            // Figure out the total number of pages. Always round up using ceil()
            $total_pages = ceil($total_results / $this->max_results);

            ?>
            <div align="center">
            <?php
            switch($type) {

                case "normal" :

                    // Build Previous Link
                    if($this->page > 1)
                    {
                        $l_prev = ($this->page - 1);
                        echo "<a href=\"".$_SERVER['PHP_SELF']."?page=" . $l_prev . "&" . $a_args . "\"><<</a> ";
                    }
                    
                    for($i = 1; $i <= $total_pages; $i++) 
                    {
                        if(($this->page) == $i)
                        {
                            echo "<span class=\"pageNumberSelected\">" . $i . " </span>";
                        } 
                        else 
                        {
                            echo "<a href=\"".$_SERVER['PHP_SELF']."?page=" . $i . "&" . $a_args . "\">" . $i . "</a> ";
                        }
                    }

                    // Build Next Link
                    if($this->page < $total_pages){
                        $l_next = ($this->page + 1);
                        echo "<a href=\"".$_SERVER['PHP_SELF']."?page=" . $l_next . "&" . $a_args . "\">>></a>";
                    }

                break;

                case "select" :

                    // Build Previous Link
                    if($this->page > 1){
                        $l_prev = ($this->page - 1);
                        echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $l_prev . "&" . $a_args . "\"><<</a> ";
                    }
                    ?>
                    <script language="javascript">

                        function page(selected) {
                            href = "<?php echo $_SERVER['PHP_SELF'] ?>?page=" + selected + "&<?php echo $a_args ?>"; 
                            document.location = href
                        }

                    </script>
                    <form method="get">
                        <select name="pages" onchange="page(this.options[this.options.selectedIndex].value)">
                            <?php
                            for($i = 1; $i <= $total_pages; $i++){
                                if(($this->page) == $i){
                                    echo "" . $i . "";
                                } else {
                                    ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </form>
                    <?php			
                    // Build Next Link
                    if($this->page < $total_pages){
                        $l_next = ($this->page + 1);
                        echo "<a href=\"".$_SERVER['PHP_SELF']."?page=" . $l_next . "&" . $a_args . "\">>></a>";
                    }					
                    else 
                    {
                        echo "<span style='color:#ccc'>next</span> ";
                    }			
                break;	
            }
            ?>
            </div>
		<?php
	}
}


?>